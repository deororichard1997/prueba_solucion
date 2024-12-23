<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Models\FormacionAcademica;
use App\Models\ExperienciaLaboral;

class UserController extends Controller
{
    /**
     * Muestra una lista de los usuarios
     */
    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    /**
     * Guarda el usuario en la base de datos
     */
    public function store(Request $request)
    {
        // dd($request);
        $validatedData = $request->validate([
            'name' => 'string|max:255',
            'email' => 'required|email|unique:users,email',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password' => 'required|string|min:8',
            'rango_salarial' => 'nullable|string|max:255',
            'nivel_profesional' => 'nullable|string|max:255',
            'nombre_completo' => 'nullable|string|max:255',
            'profesion' => 'nullable|string|max:255',
            'especializacion' => 'nullable|string|max:255',
            'numero_documento' => 'nullable|numeric',
            'ciudad_de_empleo' => 'nullable|string|max:255',
            'traslado' => 'nullable|boolean',
            'celular' => 'nullable|string|max:255',
            'linkedin' => 'nullable|string|max:255',
            'valor_agregado' => 'nullable|string',
            'feliz_en_la_labor' => 'nullable|string|max:255',
            'talento_profesional' => 'nullable|string|max:255',
            'ideas' => 'nullable|string|max:255',
            'datos_complementarios' => 'nullable|string|max:255',
            'competencias' => 'nullable|string|max:255',
            'tipo_cultura' => 'nullable|string|max:255',
            'jornada' => 'nullable|string|max:255',
            'tipo_formacion' => 'nullable|string|max:255',
            
            // validacion para formación académica
            'formacion_academica' => 'nullable|array',
            'formacion_academica.*.titulo_obtenido' => 'nullable|string|max:255',
            'formacion_academica.*.institucion' => 'nullable|string|max:255',
            'formacion_academica.*.fecha_inicio' => 'nullable|date',
            'formacion_academica.*.fecha_fin' => 'nullable|date',
            
            // validacion experiencia laboral
            'experiencia_laboral' => 'nullable|array',
            'experiencia_laboral.*.cargo' => 'nullable|string|max:255',
            'experiencia_laboral.*.empresa' => 'nullable|string|max:255',
            'experiencia_laboral.*.logros' => 'nullable|string|max:255',
            'experiencia_laboral.*.fecha_inicio' => 'nullable|date',
            'experiencia_laboral.*.fecha_fin' => 'nullable|date',
            'experiencia_laboral.*.trabaja_actualmente' => 'nullable|boolean',
        ]);
        
        // cargar la foto
        if ($request->hasFile('photo')) {
            $validatedData['photo'] = $request->file('photo')->store('photos', 'public');
        }
        
        try {
            $user = new User();
            $user->name = $validatedData['name'] ?? null;
            $user->email = $validatedData['email'];
            $user->photo = $validatedData['photo'] ?? null;
            $user->password = Hash::make($validatedData['password']);
            $user->rango_salarial = $validatedData['rango_salarial'] ?? null;
            $user->nivel_profesional = $validatedData['nivel_profesional'] ?? null;
            $user->nombre_completo = $validatedData['nombre_completo'] ?? null;
            $user->profesion = $validatedData['profesion'] ?? null;
            $user->especializacion = $validatedData['especializacion'] ?? null;
            $user->numero_documento = $validatedData['numero_documento'] ?? null;
            $user->ciudad_de_empleo = $validatedData['ciudad_de_empleo'] ?? null;
            $user->traslado = $validatedData['traslado'] ?? null;
            $user->celular = $validatedData['celular'] ?? null;
            $user->linkedin = $validatedData['linkedin'] ?? null;
            $user->valor_agregado = $validatedData['valor_agregado'] ?? null;
            $user->feliz_en_la_labor = $validatedData['feliz_en_la_labor'] ?? null;
            $user->talento_profesional = $validatedData['talento_profesional'] ?? null;
            $user->ideas = $validatedData['ideas'] ?? null;
            $user->datos_complementarios = $validatedData['datos_complementarios'] ?? null;
            $user->competencias = $validatedData['competencias'] ?? null;
            $user->tipo_cultura = $validatedData['tipo_cultura'] ?? null;
            $user->jornada = $validatedData['jornada'] ?? null;
            $user->tipo_formacion = $validatedData['tipo_formacion'] ?? null;
            
            $user->save();

            // Guardar la formación académica
            if (isset($validatedData['formacion_academica'])) {
                foreach ($validatedData['formacion_academica'] as $formacion) {
                    FormacionAcademica::create([
                        'user_id' => $user->id,
                        'titulo_obtenido' => $formacion['titulo_obtenido'],
                        'institucion' => $formacion['institucion'],
                        'fecha_inicio' => $formacion['fecha_inicio'],
                        'fecha_fin' => $formacion['fecha_fin'],
                    ]);
                }
            }

            // Guardar la experiencia laboral
            if (isset($validatedData['experiencia_laboral'])) {
                foreach ($validatedData['experiencia_laboral'] as $experiencia) {
                    ExperienciaLaboral::create([
                        'user_id' => $user->id,
                        'cargo' => $experiencia['cargo'],
                        'empresa' => $experiencia['empresa'],
                        'fecha_inicio' => $experiencia['fecha_inicio'],
                        'fecha_fin' => $experiencia['fecha_fin'],
                        'logros' => $experiencia['logros'] ?? null,
                        'archivo' => $experiencia['archivo'] ?? null,
                        'trabaja_actualmente' => $experiencia['trabaja_actualmente'],
                    ]);
                }
            }
    
            return response()->json([
                'message' => 'Usuario creado exitosamente',
                'success' => true,
                'user' => $user,
            ], 201);

        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Error al crear el usuario',
                'success' => false,
                'error' => $e->getMessage(),
            ], 500);

        }
    }

    /**
     * Mostrar un usuario en especifico
     */
    public function show($id)
    {
        try {
            $user = User::with(['formacionAcademica', 'experienciaLaboral'])->findOrFail($id);

            return response()->json([
                'message' => 'Usuario encontrado exitosamente',
                'success' => true,
                'user' => $user,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Usuario no encontrado',
                'success' => false,
                'error' => $e->getMessage(),
            ], 404);
        }
    }

    /**
     * Actualizar un usuario en especifico
     */
    public function update(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);

            // Actualizar los datos del usuario
            $user->update($request->only([
                'name',
                'email',
                'photo',
                'password',
                'rango_salarial',
                'nivel_profesional',
                'nombre_completo',
                'profesion',
                'especializacion',
                'numero_documento',
                'ciudad_de_empleo',
                'traslado',
                'celular',
                'linkedin',
                'valor_agregado',
                'feliz_en_la_labor',
                'talento_profesional',
                'ideas',
                'datos_complementarios',
                'competencias',
                'tipo_cultura',
                'jornada',
                'tipo_formacion',
            ]));

            // Actualizar la formación académica
            foreach ($request->formacion_academica as $formacion) {
                $item = FormacionAcademica::find($formacion['id']);
                if ($item) {
                    $item->update($formacion);
                }
            }

            // Actualizar la experiencia laboral
            foreach ($request->experiencia_laboral as $experiencia) {
                $item = ExperienciaLaboral::find($experiencia['id']);
                if ($item) {
                    $item->update($experiencia);
                }
            }

            return response()->json([
                'message' => 'Usuario actualizado con éxito',
                'success' => true,
                'user' => $user,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al actualizar el usuario',
                'success' => false,
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Eliminar info almacenada
     */
    public function delete($id)
    {
        try {
            $user = User::with(['formacionAcademica', 'experienciaLaboral'])->findOrFail($id);
            // dd($user);

            // Eliminar la foto del usuario si existe
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }

            // Eliminar formación académica relacionada
            $user->formacionAcademica()->delete();

            // Eliminar experiencia laboral relacionada
            $user->experienciaLaboral()->delete();

            // Eliminar el usuario
            $user->delete();

            return response()->json([
                'message' => 'Usuario y sus datos relacionados eliminados exitosamente',
                'success' => true,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al eliminar el usuario',
                'success' => false,
                'error' => $e->getMessage(),
            ], 500);
        }
    }

}

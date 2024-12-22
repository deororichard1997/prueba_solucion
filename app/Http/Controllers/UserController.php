<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // cargar la foto
        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('photos', 'public');
        }

        $user = User::create($validated);

        return response()->json($user, 201);
    }

    /**
     * Mostrar un usuario en especifico
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    /**
     * Actualizar un usuario en especifico
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:6',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // para actualización de la foto
        if ($request->hasFile('photo')) {
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }

            $validated['photo'] = $request->file('photo')->store('photos', 'public');
        }

        // Actualizar los campos del usuario
        $user->update($validated);

        return response()->json($user);
    }

    /**
     * Eliminar info almacenada
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Eliminar la foto si existe
        if ($user->photo) {
            Storage::disk('public')->delete($user->photo);
        }

        $user->delete();

        return response()->json(['message' => 'Usuario eliminado con éxito.']);
    }
}

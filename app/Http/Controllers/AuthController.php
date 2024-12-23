<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('prueba')->plainTextToken;

            return response()->json([
                'message' => 'Login realizado',
                'token' => $token,
                'user' => $user,
                'succes' => true
            ]);
        }

        return response()->json(['succes' => false, 'message' => 'No autorizado, valide las credenciales'], 401);
    }
    
    public function logout(Request $request)
    {
        // Eliminar token de acceso
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout exitoso',
            'success' => true,
        ]);
    }

    public function updatePassword(Request $request)
    {
        // Validar los datos de entrada
        $validatedData = $request->validate([
            'id' => 'required',
            'password' => 'required',
        ]);
        
        // Buscar el usuario por ID
        $user = User::find($validatedData['id']);
        // dd($request->id);
        // dd($user);
        
        if (!$user) {
            return response()->json([
                'message' => 'Usuario no encontrado',
                'success' => false,
            ], 404);
        }

        // Actualizar la contraseña
        $user->password = Hash::make($validatedData['password']);
        $user->save();

        // Respuesta de éxito
        return response()->json([
            'message' => 'Contraseña actualizada exitosamente',
            'success' => true,
        ]);
    }
}
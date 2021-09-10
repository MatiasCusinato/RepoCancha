<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AccesoUsuarioController extends Controller
{
    public function registro(Request $request){
        $formRegistro= $request->validate([
            'nombre' => 'required',
            'apellido' => 'required',
            'email' => 'required|unique:users',
            'telefono' => 'required',
            'password' => 'required|string',
            'token_actual' => 'required|string',
            'club_configuracion_id' => 'required'
        ]);

        $user =  User::create([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'password' => $request->password,
            'token_actual' => $request->token_actual,
            'club_configuracion_id' => $request->club_configuracion_id,
        ]);

        $user->password = bcrypt($user->password);
        $user->save();

        return response()->json([
            'msj' => 'Registro exitoso',
            'usuario' => $user,
        ], 200);
    }

    public function login(Request $request){
        $formLogin= $request->validate([
            'email' => 'required|exists:users',
            'password' => 'required|string'
        ]);

        $user = User::where('email', $request->email)->first();

        if(!Hash::check($formLogin['password'], $user->password)){
            return response()->json([
                'msj' => 'Datos incorrectos'
            ], 401);
        }
        $user->token_actual = $user->createToken('laravelToken')->plainTextToken;
        $user->save();
        
        return response()->json([
            'msj' => 'Login exitoso',
            'user' => $user
        ], 200);
    }

    public function logout(Request $request){
        $user = User::where('token_actual', $request->token_actual)->first();
        $user->token_actual = 'null';
        $user->save();

        return response()->json([
            'msj' => 'Logout exitoso'
        ], 200);
    }   
}

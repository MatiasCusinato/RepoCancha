<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class AccesoUsuarioController extends Controller
{
    public function registro(Request $request){
        
        $validacionRegistro = Validator::make($request->all(), [
            //'nombre' => 'required',
            //'apellido' => 'required',
            'email' => ['required', 'unique:users'],
            //'telefono' => 'required',
            //'password' => ['required', 'string'],
            //'token_actual' => ['required', 'string'],
            //'club_configuracion_id' => 'required'
        ]); 
        
        if($validacionRegistro->fails()){
            return response()->json([
                'msj' => 'Error', 
                'razon' => 'El usuario ya se encuentra registrado'], 422);
        }else { 
            $user =  User::create([
                'nombre' => $request->nombre,
                'apellido' => $request->apellido,
                'email' => $request->email,
                'telefono' => $request->telefono,
                'password' => $request->password,
                'token_actual' => "null",
                'club_configuracion_id' => $request->club_configuracion_id,
            ]);
    
            $user->password = bcrypt($user->password);
            $user->save();
    
            return response()->json([
                'msj' => 'Registro exitoso',
                'usuario' => $user,
            ], 200); 
        }
    }

    public function login(Request $request){

        $validacionLogin = Validator::make($request->all(), [
            'email' => ['required', 'exists:users'],
            'password' => ['required', 'string'],
        ]);

        if($validacionLogin->fails()){
            return response()->json([
                'msj' => 'Error', 
                'razon' => 'Ese email no esta registrado'
            ], 422);

        }else { 

            $user = User::where('email', $request->email)->first();

            if(!Hash::check($request->password, $user->password)){
                return response()->json([
                    'msj' => 'Error',
                    'razon' => 'Password incorrecta'
                ], 401);
            }
            //dd($user->token_actual);

            if($user->token_actual == 'null'){
                $fechaAhora= Carbon::createFromFormat('Y-m-d H:i:s', now(), 'UTC')->setTimezone('America/Buenos_Aires');
                $fechaAhora= $fechaAhora->format('Y-m-d H:i:s');
                
                $arrUser= array("email" => $user->email, 
                                "club" => $user->club_configuracion_id, 
                                "fechaInicio" => $fechaAhora);
                $jsonUser= json_encode($arrUser);
                //$jsonUser= json_encode(utf8_decode($jsonUser));
                $tokenUser= base64_encode($jsonUser);    
                $user->token_actual = $tokenUser;


                //$user->token_actual = $user->createToken('laravelToken')->plainTextToken;
                
                $user->save();
                    return response()->json([
                        'msj' => 'Login exitoso',
                        'user' => $user
                    ], 200);
                } else {
                    return response()->json([
                        'msj' => 'Error',
                        'razon' => 'Este usuario ya se encuentra logueado'
                    ], 401);
                } 
        }

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

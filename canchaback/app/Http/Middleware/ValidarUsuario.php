<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ValidarUsuario
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        //$clubUrl= $request->club_id; //Club de la URL(parametro)
        $clubRequest= $request->club_configuracion_id; //Club del objeto request (objeto que viene de Vue)
        
        $token= $request->token; //Token del local storage
        $tokenUser= base64_decode($token); //decodifico el token a un objeto JSON
        $jsonToken= json_decode($tokenUser);
        $url= $request->fullUrl(); //url a la que se quiere acceder
        $metodo= $request->getMethod(); //metodo de la peticion

        $respuestaAccesoDenegado= response()->json([
            'msj' => "Error",
            'razon' => 'Acceso denegado, no puedes realizar esta accion',
        ], 413);

        //busco al usuario que tiene ese token y lo valido, 
        //      ademas de validar su club y sobre que club quiere realizar tal accion..
        $existeUsuario= DB::table('users')
                            ->where('token_actual', '=', $token)
                            ->get();

        if($existeUsuario->isEmpty() || ($jsonToken->club != $clubRequest)){
            return $respuestaAccesoDenegado;
        }else{
            return $next($request);
        }
    }
}

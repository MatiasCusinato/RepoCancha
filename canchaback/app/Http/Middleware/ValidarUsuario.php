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
        $club= $request->club_id;
        $token= $request->token;
        $url= $request->fullUrl();
        $metodo= $request->getMethod();
        //dd($request, $metodo, $url, $token, $club);
        
        if($token != "null" && $club != "null"){
            //Busco al usuario mediante el club y su token, si lo encuentro, lo guardo
            $user = DB::table('users')
                            ->where([
                                ['token_actual', '=', $token],
                                ['club_configuracion_id','=', $club],
                            ])->first();
        }

        //Si no encuentro el usuario, retorno false
        if($user==null){
            return response()->json([
                                'msj' => "Error",
                                'razon' => 'Acceso denegado, unauthorized',
                            ], 413);
        } else {
            //si se encuentra, true.
            return $next($request);
        }
    }
}

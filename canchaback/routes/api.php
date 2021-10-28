<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\ClienteController;
use App\Http\Controllers\API\CanchaController;
use App\Http\Controllers\API\TurnoController;
use App\Http\Controllers\API\clubConfiguracionController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\AccesoUsuarioController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//APIS
/* Route::apiResource('clubes', clubConfiguracionController::class); */
Route::apiResource('users', UserController::class);
//Route::apiResource('canchas', CanchaController::class);
//Route::apiResource('clientes', ClienteController::class);
//Route::apiResource('turnos', TurnoController::class);


//Registro, login y logout
Route::post('registro',[AccesoUsuarioController::class, 'registro']);
Route::post('login',[AccesoUsuarioController::class, 'login']);
Route::post('logout',[AccesoUsuarioController::class, 'logout']); 

//Ruta Clubes
Route::get('clubes', [clubConfiguracionController::class, 'index']);
Route::post('clubes/ganacias', [clubConfiguracionController::class, 'gananciaClub']);
Route::post('clubes/guardar', [clubConfiguracionController::class, 'store']);
Route::get('clubes/show/{club_id}', [clubConfiguracionController::class, 'show']);
Route::put('clubes/editar/{club_id}', [clubConfiguracionController::class, 'update']);
Route::delete('clubes/eliminar/{club_id}', [clubConfiguracionController::class, 'destroy']);


//Rutas Canchas
Route::get('canchas/{club_id}/{registros?}', [CanchaController::class, 'index']);
Route::get('canchas/{club_id}/show/{cancha_id}', [CanchaController::class, 'show']);
Route::get('canchas/{club_id}/deporte/{deporte}', [CanchaController::class, 'filtroDeporte']); //Ruta filtro x deportes de Canchas
Route::middleware('validarUsuario')->group(function(){
    Route::post('canchas/guardar', [CanchaController::class, 'store']);
    Route::put('canchas/editar/{club_id}/{cancha_id}', [CanchaController::class, 'update']);
    Route::delete('canchas/eliminar/{club_id}/{cancha_id}', [CanchaController::class, 'destroy']);
}); 


//Rutas Clientes
Route::get('clientes/{club_id}/{registros?}', [ClienteController::class, 'index']);
Route::get('clientes/{club_id}/show/{cliente_id}', [ClienteController::class, 'show']);
Route::get('clientes/{club_id}/nombre/{nombre}', [ClienteController::class, 'filtroNombre']); //Ruta filtro x nombre de Clientes 
Route::middleware('validarUsuario')->group(function(){
    Route::post('clientes/guardar', [ClienteController::class, 'store']);
    Route::put('clientes/editar/{club_id}/{cliente_id}', [ClienteController::class, 'update']);
    Route::delete('clientes/eliminar/{club_id}/{cliente_id}', [ClienteController::class, 'destroy']);  
});


//Rutas Turnos
Route::get('turnos/{club_id}/{cancha_id}', [TurnoController::class, 'index']); 
Route::get('turnos/{club_id}/show/{turno_id}', [TurnoController::class, 'show']);
Route::middleware('validarUsuario')->group(function(){
    Route::post('turnos/guardar', [TurnoController::class, 'store']);
    Route::put('turnos/editar/{turno_id}', [TurnoController::class, 'update']);
    Route::delete('turnos/eliminar/{grupo}/{turno_id?}', [TurnoController::class, 'destroy']); 
});
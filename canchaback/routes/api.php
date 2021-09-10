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
Route::apiResource('clubes', clubConfiguracionController::class);
Route::apiResource('clientes', ClienteController::class);
Route::apiResource('canchas', CanchaController::class);
Route::apiResource('turnos', TurnoController::class);
Route::apiResource('users', UserController::class);

//Registro, login y logout
Route::post('registro',[AccesoUsuarioController::class, 'registro']);
Route::post('login',[AccesoUsuarioController::class, 'login']);
Route::post('logout',[AccesoUsuarioController::class, 'logout']); 

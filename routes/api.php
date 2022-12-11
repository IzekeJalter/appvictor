<?php

use App\Http\Controllers\Parque\SensorController;
use App\Http\Controllers\Parque\UsuarioController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post("/registroDueño", [UsuarioController::class, "crearDueño"]);
Route::get("/pero", [SensorController::class, "getAllSensores"]);

Route::post("/login",[UsuarioController::class,"InicioSesion"]);

Route::post("/telefonoregistr/{url}",[UsuarioController::class,"registrarSMS"])->name('telefonoregistr')->middleware('signed');
Route::get("/validarnumero/{url}",[UsuarioController::class,"numerodeverificacionmovil"])->name('validarnumero')->middleware('signed');
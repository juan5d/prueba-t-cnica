<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SoporteController;
use App\Http\Controllers\SolicitudController;
use App\Http\Controllers\RequerimientoController;
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('/soporte',SoporteController::class);
Route::apiResource('/solicitud',SolicitudController::class);
Route::apiResource('/requerimiento',RequerimientoController::class);
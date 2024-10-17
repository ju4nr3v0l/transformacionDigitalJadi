<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing');
});


Route::get('/dimensiones', function () {
    return view('dimensiones');
});
Route::get('/inicioConsultoria', function () {
    return view('inicioConsultoria');
});

Route::get('/recomendaciones/{id_usuario}',[\App\Http\Controllers\GeneracionCopilotController::class, 'generarRecomendacionCopilot']);
Route::get('/reporte/{id_usuario}',[\App\Http\Controllers\GenerarReporteController::class, 'generarReporte']);
Route::get('/test',[\App\Http\Controllers\TestController::class, 'test']);


<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('inicioConsultoria');
});


Route::get('/dimensiones', function () {
    return view('dimensiones');
});
Route::get('inicioConsultoria', function () {
    return view('inicioConsultoria');
});

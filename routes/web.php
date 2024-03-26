<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/dimensiones', function () {
    return view('dimensiones');
});
Route::get('wizard', function () {
    return view('inicioConsultoria');
});

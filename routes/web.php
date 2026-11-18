<?php

use App\Http\Controllers\UjiCobaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/uji-coba', [UjiCobaController::class, 'index'])->name('uji-coba.index');
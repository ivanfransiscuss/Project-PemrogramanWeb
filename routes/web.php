<?php

use App\Http\Controllers\UjiCobaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/uji-coba', [UjiCobaController::class, 'index'])->name('uji-coba.index');

Route::get('/uji-a', fn () => 'halaman A');

// ===== Nindira: PKM Match & To-Do List =====
Route::middleware('auth')->group(function () {
    // PKM Match (feed postingan)
    Route::get('/match', [\App\Http\Controllers\PostinganController::class, 'index'])->name('match.index');
    Route::post('/match', [\App\Http\Controllers\PostinganController::class, 'store'])->name('match.store');
    Route::get('/match/{postingan}', [\App\Http\Controllers\PostinganController::class, 'show'])->name('match.show');
    Route::post('/match/{postingan}/balas', [\App\Http\Controllers\PostinganController::class, 'balas'])->name('match.balas');
    Route::patch('/match/{postingan}/selesai', [\App\Http\Controllers\PostinganController::class, 'selesai'])->name('match.selesai');
    Route::delete('/match/{postingan}', [\App\Http\Controllers\PostinganController::class, 'destroy'])->name('match.destroy');

    // Kelompok
    Route::get('/kelompok/buat', [\App\Http\Controllers\KelompokController::class, 'create'])->name('kelompok.create');
    Route::post('/kelompok', [\App\Http\Controllers\KelompokController::class, 'store'])->name('kelompok.store');
    Route::get('/kelompok/{kelompok}', [\App\Http\Controllers\KelompokController::class, 'show'])->name('kelompok.show');
    Route::post('/kelompok/{kelompok}/gabung', [\App\Http\Controllers\KelompokController::class, 'gabung'])->name('kelompok.gabung');
    Route::patch('/kelompok/{kelompok}/anggota/{anggota}/status', [\App\Http\Controllers\KelompokController::class, 'updateStatus'])->name('kelompok.anggota.status');
    Route::patch('/kelompok/{kelompok}/anggota/{anggota}/peran', [\App\Http\Controllers\KelompokController::class, 'updatePeran'])->name('kelompok.anggota.peran');

    // To-Do List
    Route::get('/todo', [\App\Http\Controllers\TodoController::class, 'index'])->name('todo.index');
    Route::post('/todo', [\App\Http\Controllers\TodoController::class, 'store'])->name('todo.store');
    Route::patch('/todo/{todo}/status', [\App\Http\Controllers\TodoController::class, 'status'])->name('todo.status');
    Route::put('/todo/{todo}', [\App\Http\Controllers\TodoController::class, 'update'])->name('todo.update');
    Route::delete('/todo/{todo}', [\App\Http\Controllers\TodoController::class, 'destroy'])->name('todo.destroy');
});
// ===== akhir bagian Nindira =====

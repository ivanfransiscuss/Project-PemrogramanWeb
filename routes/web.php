<?php

use App\Http\Controllers\UjiCobaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingBimbinganController;
use App\Http\Controllers\JadwalDosenController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/uji-coba', [UjiCobaController::class, 'index'])->name('uji-coba.index');

Route::get('/uji-a', fn () => 'halaman A');

Route::get('/booking', [BookingBimbinganController::class, 'index'])->name('booking.index');
Route::get('/booking/create/{jadwal_id}', [BookingBimbinganController::class, 'create'])->name('booking.create');
Route::post('/booking', [BookingBimbinganController::class, 'store'])->name('booking.store');
Route::put('/booking/{id_bimbingan}/status', [BookingBimbinganController::class, 'updateStatus'])->name('booking.updateStatus');

Route::get('/jadwal', [JadwalDosenController::class, 'index'])->name('jadwal.index');
Route::get('/jadwal/create', [JadwalDosenController::class, 'create'])->name('jadwal.create');
Route::post('/jadwal', [JadwalDosenController::class, 'store'])->name('jadwal.store');

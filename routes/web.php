<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PenggunaController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function () {
    return view('layouts.main');
})->middleware('auth');

Route::get('/event', function () {
    return view('event.dataevent');
});

Route::get('/pengguna', [PenggunaController::class, 'index'])->name('pengguna');

Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

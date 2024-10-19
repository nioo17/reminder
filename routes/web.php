<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PenggunaController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function () {
    return view('layouts.main');
})->middleware('auth')->name('dashboard');

// event
Route::resource('event', EventController::class);

//pengguna
Route::resource('pengguna', PenggunaController::class);

//login logout
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PenggunaController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function () {
    return view('layouts.main');
})->middleware('auth')->name('dashboard');

Route::get('/event', [EventController::class, 'index'])->name('event');
Route::get('/event/create', [EventController::class, 'create'])->name('createevent');
Route::post('/event/create', [EventController::class, 'store']);

Route::get('/pengguna', [PenggunaController::class, 'index'])->name('pengguna');

Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

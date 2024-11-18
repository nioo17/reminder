<?php

use App\Mail\TestMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PenggunaController;
use App\Models\Pengguna;

Route::get('/dashboard', function () {
    return view('layouts.main');
})->middleware('auth')->name('dashboard');

// event
Route::get('/get-calendar-events', [EventController::class, 'getCalendarEvents'])->name('calendar.events');
Route::resource('event', EventController::class);

// pengguna
Route::resource('pengguna', PenggunaController::class);

// login logout
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

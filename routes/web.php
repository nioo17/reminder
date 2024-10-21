<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PenggunaController;
use Illuminate\Support\Facades\Route;

Route::get('/pengguna', function () {
    return view('pengguna.datapengguna');
});
Route::post('/store', [PenggunaController::class, 'store'])->name('store');
Route::get('/getall', [PenggunaController::class, 'getall'])->name('getall');
Route::get('/penggunaController/{id}/edit', [PenggunaController::class, 'edit'])->name('edit');
Route::post('/penggunaController/update', [PenggunaController::class, 'update'])->name('update');

Route::delete('/penggunaController/delete', [PenggunaController::class, 'delete'])->name('delete');

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

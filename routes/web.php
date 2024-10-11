<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('user.login');
});

Route::get('/dashboard', function () {
    return view('layouts.main');
});

Route::get('/event', function () {
    return view('layouts.dataevent');
});

Route::get('/pengguna', function () {
    return view('layouts.datapengguna');
});

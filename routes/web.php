<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return ['Laravel' => app()->version()];
});
Route::get('/sanctum/csrf-cookie', function () {
    return response()->json('CSRF cookie set')->withCookie(cookie('XSRF-TOKEN', csrf_token(), 120));
});

require __DIR__.'/auth.php';

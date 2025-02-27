<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TemaController;
use App\Http\Controllers\DeseoController;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/crearTema', action: [TemaController::class, 'store'])->name('temas.store');
Route::get('/temas', [TemaController::class, 'index'])->name('temas.index');


Route::post('/deseos', [DeseoController::class, 'store'])->name('deseos.store');

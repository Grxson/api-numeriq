<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\NivelesEducativosController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TemaController;
use App\Http\Controllers\DeseoController;
use App\Http\Controllers\CategoriaController;

Route::post('/register', [RegisteredUserController::class, 'store'])
    ->middleware('guest')
    ->name('register');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware('guest')
    ->name('login');

Route::middleware('auth:sanctum')->get('/user', [ProfileController::class, 'show']);


//Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::post('/crearTema', action: [TemaController::class, 'store'])->name('temas.store');
Route::get('/temas', [TemaController::class, 'index'])->name('temas.index');


Route::post('/deseos', [DeseoController::class, 'store'])->name('deseos.store');

Route::get('/categorias', [CategoriaController::class, 'index'])->name('categorias.index');
Route::get('/niveles', [NivelesEducativosController::class, 'index']);

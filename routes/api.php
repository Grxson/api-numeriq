<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\DeseoController;
use App\Http\Controllers\NivelesEducativosController;
use App\Http\Controllers\RecursoController;
use App\Http\Controllers\TemaController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [RegisteredUserController::class, 'store'])
    ->middleware('guest')
    ->name('register');

Route::post('/login', [AuthenticatedSessionController::class, 'store']);

//Route::middleware('auth:sanctum')->get('/user', [ProfileController::class, 'show']);
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/perfil', [ProfileController::class, 'show']);
    Route::put('/perfil', [ProfileController::class, 'update']);
    Route::delete('/perfil', [ProfileController::class, 'destroy']);
});


//Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::post('/crearTema', action: [TemaController::class, 'store'])->name('temas.store');
Route::get('/temas', [TemaController::class, 'index'])->name('temas.index');
Route::delete('/temas/{idTema}', [TemaController::class, 'destroy']);


Route::post('/deseos', [DeseoController::class, 'store']);
Route::get('/deseos/usuario/{idUsuario}', [DeseoController::class, 'getDeseosByUsuario']);
Route::delete('/deseos/{idDeseo}', [DeseoController::class, 'destroy']);

<<<<<<< HEAD
=======
// Ruta para agregar un deseo
Route::post('/deseos', [DeseoController::class, 'store']);

// Ruta para obtener los deseos de un usuario
Route::get('/deseos/{idUsuario}', [DeseoController::class, 'index']);
>>>>>>> f0c476b542a2ac095e2a85812737a5bd88ee3464
Route::get('/categorias', [CategoriaController::class, 'index'])->name('categorias.index');
Route::get('/niveles', [NivelesEducativosController::class, 'index']);

// Recursos para los temas
Route::prefix('temas/{idTema}/recursos')->group(function () {
   Route::get('/', [RecursoController::class, 'index']);
   Route::post('/', [RecursoController::class, 'store']);
});

Route::prefix('recursos/{idRecurso}')->group(function () {
    Route::put('/', [RecursoController::class, 'update']);
    Route::delete('/', [RecursoController::class, 'destroy']);
});
//Route::post('/temas/{idTema}/recursos', [RecursoController::class, 'store']);

Route::get('/sanctum/csrf-cookie', function () {
    return response()->json('CSRF cookie set')->withCookie(cookie('XSRF-TOKEN', csrf_token(), 120));
});


Route::middleware('auth:sanctum')->prefix('carrito')->group(function () {
    Route::get('/', [CarritoController::class, 'index']);
    Route::post('/agregar', [CarritoController::class, 'agregar']);
    Route::delete('/eliminar/{idTema}', [CarritoController::class, 'eliminar']);
    Route::post('/vaciar', [CarritoController::class, 'vaciar']);
});

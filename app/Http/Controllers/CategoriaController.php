<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;

class CategoriaController extends Controller
{
    /**
     * Obtener todas las categorías.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $categorias = Categoria::all(); // Recupera todas las categorías

        return response()->json($categorias);
    }
}

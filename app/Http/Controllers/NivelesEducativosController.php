<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NivelEducativo;

class NivelesEducativosController extends Controller
{
    /**
     * Obtener todos los niveles educativos.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $niveles = NivelEducativo::all(); // Recupera todos los niveles

        return response()->json($niveles);
    }
}

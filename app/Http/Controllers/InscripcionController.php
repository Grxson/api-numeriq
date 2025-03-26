<?php

namespace App\Http\Controllers;

use App\Models\Inscripcions;
use App\Models\Tema;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class InscripcionController extends Controller
{
    public function inscribirEnTema($idTema): JsonResponse
    {

        $user = Auth::user();

        $tema = Tema::find($idTema);
        if (!$tema) {
            return response()->json(['message' => 'El tema no existe'], 404);
        }

        $inscripcionExistente = Inscripcions::where('idUsuario', $user->idUsuario)
            ->where('idTema', $idTema)
            ->first();

        if ($inscripcionExistente) {
            return response()->json(['message' => 'Ya estas inscrito en este tema'], 400);
        }

        $inscripcion = Inscripcions::create([
            'idUsuario' => $user->idUsuario,
            'idTema' => $idTema,
            'estado' => 'inscrito',
            'fechaInscripcion' => now(),
            'progreso' => 0
        ]);
        return response()->json([
            'message' => 'Inscripción realizada con éxito.',
            'inscripcion' => $inscripcion
        ], 201);
    }
}

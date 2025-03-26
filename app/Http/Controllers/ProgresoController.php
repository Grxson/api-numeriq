<?php

namespace App\Http\Controllers;

use App\Models\Inscripcions;
use App\Models\Recurso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProgresoController extends Controller
{

    public function obtenerProgreso($idTema)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Usuario no autenticado'], 401);
        }

        $user = Auth::user();

        // Verificar si el usuario está inscrito en el tema
        $inscripcion = Inscripcions::where('idUsuario', $user->idUsuario)
            ->where('idTema', $idTema)
            ->first();

        if (!$inscripcion) {
            return response()->json(['message' => 'No estás inscrito en este tema'], 400);
        }

        $recursos = Recurso::where('idTema', $idTema)->get();
        $totalRecursos = $recursos->count();

        $recursosCompletados = $user->recursosCompletados()
            ->where('idTema', $idTema)
            ->count();

        // calcular el progreso
        $progreso = ($totalRecursos > 0) ? ($recursosCompletados / $totalRecursos) * 100 : 0;

        return response()->json([
            'progreso' => $progreso,
            'estado' => $inscripcion->estado,
            'recursos' => $recursos
        ]);
    }

    public function actualizarProgreso(Request $request, $idTema)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Usuario no autenticado'], 401);
        }

        $user = Auth::user();

        // Verificar si el usuario está inscrito en el tema
        $inscripcion = Inscripcions::where('idUsuario', $user->idUsuario)
            ->where('idTema', $idTema)
            ->first();

        if (!$inscripcion) {
            return response()->json(['message' => 'No estás inscrito en este tema'], 400);
        }

        // Validar y actualizar el recurso
        $recursoId = $request->input('idRecurso');
        $recurso = Recurso::find($recursoId);

        if (!$recurso || $recurso->idTema != $idTema) {
            return response()->json(['message' => 'Recurso no válido para este tema'], 400);
        }

        // Marcar el recurso como completado
        $user->recursos()->syncWithoutDetaching([
            $recursoId => ['completado' => true]
        ]);

        // Calcular progreso
        $totalRecursos = Recurso::where('idTema', $idTema)->count();
        $recursosCompletados = $user->recursosCompletados()->where('idTema', $idTema)->count();
        $progreso = ($totalRecursos > 0) ? ($recursosCompletados / $totalRecursos) * 100 : 0;

        // Actualizar progreso y estado
        $inscripcion->progreso = $progreso;

        if ($progreso == 100) {
            $inscripcion->estado = 'completado';
        } else {
            $inscripcion->estado = 'activo';
        }

        $inscripcion->save();

        return response()->json([
            'message' => 'Progreso actualizado con éxito.',
            'progreso' => $progreso,
            'estado' => $inscripcion->estado
        ]);
    }

}

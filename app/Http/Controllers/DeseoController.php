<?php

namespace App\Http\Controllers;

use App\Models\Deseo;
use App\Models\Tema;
use Illuminate\Http\Request;

class DeseoController extends Controller
{
    // Crear un deseo
    public function store(Request $request)
    {

        $request->validate([
            'idUsuario' => 'required|exists:usuario,idUsuario',
            'idTema' => 'required|exists:temas,idTema'
        ]);

        // Verificar si ya existe el deseo
        $existe = Deseo::where('idUsuario', $request->idUsuario)
            ->where('idTema', $request->idTema)
            ->first();

        if ($existe) {
            return response()->json(['message' => 'El tema ya está en la lista de deseos'], 400);
        }

        // Crear deseo (Laravel agregará created_at automáticamente)
        $deseo = Deseo::create([
            'idUsuario' => $request->idUsuario,
            'idTema' => $request->idTema
        ]);

        $tema = Tema::find($request->idTema);

        return response()->json([
            'message' => 'Agregado a la lista de deseos',
            'deseo' => $deseo,
            'tema' => $tema
        ], 201);
    }

    // Obtener todos los deseos de un usuario con información del tema
    public function getDeseosByUsuario($idUsuario)
    {
        $deseos = Deseo::where('idUsuario', $idUsuario)
            ->with('tema')
            ->get();

        if ($deseos->isEmpty()) {
            return response()->json(['message' => 'No hay deseos para este usuario'], 404);
        }

        return response()->json([
            'message' => 'Lista de deseos',
            'deseos' => $deseos
        ], 200);
        
    }

    // Eliminar un deseo específico
    public function destroy($idDeseo)
    {
        $deseo = Deseo::find($idDeseo);

        if (!$deseo) {
            return response()->json(['message' => 'Deseo no encontrado'], 404);
        }

        $deseo->delete();

        return response()->json(['message' => 'Deseo eliminado correctamente'], 200);
    }
}

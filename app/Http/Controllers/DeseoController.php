<?php

namespace App\Http\Controllers;

use App\Models\Deseo;
use Illuminate\Http\Request;

class DeseoController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'idUsuario' => 'required|exist:usuario,idUsuario',
            'idTema' => 'required|exist:temas, idTema',
            'fechaAgregado' => 'required|date'
        ]);

        // Verifica si ya existe en la lista de deseos
        $existe = Deseo::where('idUsuario', $request->idUsuario)
            ->where('idTema', $request->idTema)
            ->first();

        if ($existe) {
            return response()->json(['message' => 'El tema ya existe en la lista de deseos'], 400);
        }

        $deseo = Deseo::create([
            'idUsuario' => $request->idUsuario,
            'idTema' => $request->idTema,
            'fechaAgregado' => now()
        ]);

        return response()->json(['message' => 'Agregado a la lista de deseos', $deseo], 201);
    }
}

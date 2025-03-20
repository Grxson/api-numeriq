<?php

namespace App\Http\Controllers;

use App\Models\Carrito;
use App\Models\CarritoDetalle;
use App\Models\Tema;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CarritoController extends Controller
{
    public function index(): JsonResponse
    {
        $user = Auth::user();

        if (!empty($user->idUsuario)) {
            $carrito = Carrito::with('detalles.tema')
                ->where('idUsuario', $user->idUsuario)
                ->first();
        }
        if (!$carrito) return response()->json(['message' => 'Carrito vacío'], 201);

        return response()->json($carrito, 201);
    }

    public function agregar(Request $request): JsonResponse
    {
        $user = Auth::user();
        $request->validate([
            'idTema' => 'required|exists:temas,idTema',
            'cantidad' => 'required|integer|min:1'
        ]);

        $tema = Tema::find($request->idTema);

        // Buscar o crear el carrito del usuario
        if (!empty($user->idUsuario)) {
            $carrito = Carrito::firstOrCreate(
                ['idUsuario' => $user->idUsuario],
                ['total' => 0]
            );
        }

        // Buscar si el tema ya está en el carrito
        $detalle = CarritoDetalle::where('idCarrito', $carrito->idCarrito)
            ->where('idTema', $tema->idTema)
            ->first();

        if ($detalle) {
            $detalle->cantidad += $request->cantidad;
            $detalle->precio = $tema->precio * $detalle->cantidad;
            $detalle->save();
        } else {
            CarritoDetalle::create([
                'idCarrito' => $carrito->idCarrito,
                'idTema' => $tema->idTema,
                'cantidad' => $request->cantidad,
                'precio' => $tema->precio * $request->cantidad
            ]);
        }
        // Recalcular total del carrito
        $carrito->total = CarritoDetalle::where('idCarrito', $carrito->idCarrito)->sum('precio');
        $carrito->save();

        return response()->json([
            'message' => 'Tema agregado al carrito',
            'carrito' => $carrito
        ], 201);
    }

    public function eliminar($idTema): JsonResponse
    {
        $user = Auth::user();
        if (!empty($user->idUsuario)) {
            $carrito = Carrito::where('idUsuario', $user->idUsuario)->first();
        }

        if (!$carrito) {
            return response()->json(['message' => 'Carrito no encontrado'], 404);
        }

        $detalle = CarritoDetalle::where('idCarrito', $carrito->idCarrito)
            ->where('idTema', $idTema)
            ->first();

        if (!$detalle) {
            return response()->json(['message' => 'Tema no encontrado en el carrito'], 404);
        }

        $detalle->delete();

        // Recalcular total
        $carrito->total = CarritoDetalle::where('idCarrito', $carrito->idCarrito)->sum('precio');
        $carrito->save();

        return response()->json(['message' => 'Tema eliminado del carrito', 'carrito' => $carrito], 201);
    }


    public function vaciar(): JsonResponse
    {
        $user = Auth::user();
        if (!empty($user->idUsuario)) {
            $carrito = Carrito::where('idUsuario', $user->idUsuario)->first();
        }

        if ($carrito) {
            CarritoDetalle::where('idCarrito', $carrito->idCarrito)->delete();
            $carrito->total = 0;
            $carrito->save();
        }

        return response()->json(['message' => 'Carrito vaciado'], 201);
    }
}



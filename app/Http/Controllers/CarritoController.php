<?php

namespace App\Http\Controllers;

use App\Models\Tema;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

/**
 * @method middleware(string $string)
 */
class CarritoController extends Controller
{
    // Función para asegurar que cada acción sea por un usuario autenticado
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function index(): JsonResponse
    {
        $carrito = session()->get('carrito', []);
        return response()->json($carrito);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function agregar(Request $request): JsonResponse
    {
        $idTema = $request->input('idTema');
        $tema = Tema::find($idTema);

        if (!$tema) {
            return response()->json(['error' => 'Tema no encontrado'], 404);
        }

        $carrito = session()->get('carrito', []);
        $carrito[$idTema] = $tema;
        session()->put('carrito', $carrito);

        return response()->json(['success' => 'Tema agregado al carrito']);

    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function eliminar($idTema): JsonResponse
    {
        $carrito = session()->get('carrito', []);
        if (isset($carrito[$idTema])) {
            unset($carrito[$idTema]);
            session()->put('carrito', $carrito);
        }

        return response()->json(['success' => 'Tema eliminado del carrito']);
    }

    public function comprar(): JsonResponse
    {
        session()->forget('carrito');
        return response()->json(['success' => 'Compra realizada con éxito']);
    }
}



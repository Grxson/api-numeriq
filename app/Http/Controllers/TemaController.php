<?php

namespace App\Http\Controllers;

use App\Models\Tema;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TemaController extends Controller
{
<<<<<<< HEAD
    public function index(Request $request)
=======

    public function index(Request $request): JsonResponse
>>>>>>> f0c476b542a2ac095e2a85812737a5bd88ee3464
    {
        // Creación de los filtrados
        $categoria = $request->input('categoria');
        $nivel = $request->input('nivel');
        $precioMin = $request->input('precio_min');
        $precioMax = $request->input('precio_max');

        // Consultar los temas con los filtros
        $query = Tema::query();
        if ($categoria) {
            $query->where('idCategoria', $categoria);
        }
        if ($nivel) {
            $query->where('idNivel', $nivel);
        }
        if ($precioMin !== null && $precioMax !== null) {
            $query->whereBetween('precio', [$precioMin, $precioMax]);
        } elseif ($precioMin !== null) {
            $query->where('precio', '<=', $precioMin);
        } elseif ($precioMax !== null) {
            $query->where('precio', '<=', $precioMax);
        }
        $temas = $query->paginate(20);

        return response()->json($temas, 201);
    }

<<<<<<< HEAD
    public function store(Request $request)
=======
    public function store(Request $request): JsonResponse
>>>>>>> f0c476b542a2ac095e2a85812737a5bd88ee3464
    {
        $request->validate([
            'nombreTema' => 'required|string|max:255',
            'descripcionTema' => 'nullable|string',
            'miniaturaTema' => 'required|mimes:jpg,jpeg,png,mp4,mov,avi,mkv|max:51200',
            'precio' => 'required|numeric|min:0',
            'idCategoria' => 'required|exists:categorias,idCategoria',
            'idNivel' => 'required|exists:nivel_educativos,idNivel',
            'horasContenido' => 'required|integer|min:0',
            'idioma' => 'required|string|max:255',
            'certificado' => 'required|in:1,0',
        ]);

        // Verifica si se ha subido un archivo
        if($request->hasFile('miniaturaTema')){
            $file = $request->file('miniaturaTema');

            // Define un nombre único para el archivo
            $fileName = time() . '_' . $file->getClientOriginalName();

            // Verifica si el archivo es una imagen o un video
            $fileExtension = $file->getClientOriginalExtension();

            // Si el archivo es una imagen
            if(in_array($fileExtension, ['jpg', 'jpeg', 'png'])){
                // Guarda la imagen en storage
                $file->storeAs('public/temas', $fileName);
            }
            // Si el archivo es un video
            elseif(in_array($fileExtension, ['mp4', 'mov', 'avi', 'mkv'])){
                // Guarda el video en storage
                $file->storeAs('public/videos', $fileName);
            }

            // Obtiene la URL del archivo
            $fileUrl = asset('storage/temas/' . $fileName);
        }

        // Crear el tema con la URL del archivo
        $tema = Tema::create([
            'nombreTema' => $request->nombreTema,
            'descripcionTema' => $request->descripcionTema,
            'miniaturaTema' => isset($fileUrl) ? $fileUrl : null, // Asignación de la URL si está presente
            'precio' => $request->precio,
            'idCategoria' => $request->idCategoria,
            'idNivel' => $request->idNivel,
            'horasContenido' => $request->horasContenido,
            'fechaUltimaActualizacion' => NOW(),
            'idioma' => $request->idioma,
            'certificado' => $request->certificado,
        ]);

        return response()->json(['tema' => $tema], 201);
    }

    public function destroy($idTema)
    {
        $tema = Tema::find($idTema);
        if (!$tema) {
            return response()->json(['message' => 'Tema no encontrado'], 404);
        }

        $tema->delete();
        return response()->json(['message' => 'Tema eliminado'], 200);
    }
}

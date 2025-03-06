<?php

namespace App\Http\Controllers;

use App\Models\Recurso;
use App\Models\Tema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RecursoController extends Controller
{
    public function index($idTema){
        try{
            // Verificar si el tema existe
            $tema = Tema::where('idTema',$idTema)->firstOrFail();

            // Obtener todos los recursos del tema
            $recursos = Recurso::where('idTema', $idTema)->get();

            return response()->json([
                'tema' => $tema->nombreTema,
                'recursos' => $recursos
            ]);
        }catch (\Exception $e){
            return response()->json([
                'error' => 'No se pudieron obtener los recursos',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public function store(Request $request, $idTema){
        try{
            // Validar que el tema exista
            $tema = Tema::where('idTema', $idTema)->firstOrFail();
            // Validar el tipo de recurso
            $request ->validate([
                'tipoRecurso' => 'required|string|in:Video,Ejercicio,Recurso Adicional,Examen Diagnóstico,Examen Final',
                'tituloRecurso' => 'required|string|max:255',
                'descripcionRecurso' => 'nullable|string',
            ]);
            $rutaArchivo = null; // Variable para almacenar la ruta del archivo

            // En caso de que sea "video"
            if ($request->tipoRecurso === 'Video') {
                $request->validate([
                    'video' => 'required|mimes:mp4,avi,mov|max:50480', // Hasta 50MB
                    'duracionVideo' => 'required|integer|min:1', // Minutos
                ]);
                if ($request->hasFile('video')) {
                    $rutaArchivo = $request->file('video')->store('videos', 'public');
                } else {
                    return response()->json(['error' => 'Error al subir el video'], 400);
                }
            }
            // Si es EJERCICIO
            elseif ($request->tipoRecurso === 'Ejercicio') {
                $request->validate([
                    'archivo' => 'required|mimes:zip,pdf,docx,txt,pptx|max:10240'
                ]);
                if($request->hasFile('archivo')){
                    $rutaArchivo = $request->file('archivo')->store('ejercicios', 'public');
                } else {
                    return response()->json(['error' => 'Error al subir el archivo'], 400);
                }
            }
            // Si es RecursoAdicional
            elseif($request->tipoRecurso === 'Recurso Adicional') {
                $request->validate([
                    'archivo' => 'required|mimes:zip,pdf,docx,txt,pptx|max:10240'
                ]);
                if($request->hasFile('archivo')){
                    $rutaArchivo = $request->file('archivo')->store('recursos_adicionales', 'public');
                } else {
                    return response()->json(['error' => 'Error al subir el recurso adicional'], 400);
                }
            }

            // Examenes


            // Generar la url publica
            $urlRecurso = $rutaArchivo ? asset('storage/' . $rutaArchivo) : null;

            // Crear el recurso
            $recurso = new Recurso();
            $recurso->idTema = $idTema;
            $recurso->tipoRecurso = $request->tipoRecurso;
            $recurso->tituloRecurso = $request->tituloRecurso;
            $recurso->descripcionRecurso = $request->descripcionRecurso;
            $recurso->enlaceREcurso = $urlRecurso;
            $recurso->duracionVideo = $request->tipoRecurso === 'Video' ? $request->duracionVideo : null;
            $recurso->save();

            return response()->json([
                'message' => 'Recurso agregado correctamente',
                'recurso' => $recurso
            ]);


        }catch(\Exception $e){
            return response()->json([
                'error' => 'Error al agregar el recurso',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $idRecurso){
        try{
        // Buscar el recurso
            $recurso = Recurso::findOrFail($idRecurso);

            // validación
            $request->validate([
                'tipoRecurso' => 'sometimes|string|in:Video,Ejercicio,Recurso Adicional,Examen Diagnóstico,Examen Final',
                'tituloRecurso' => 'sometimes|string|max:255',
                'descripcionRecurso' => 'nullable|string',
            ]);

            // Por si es un video
            if ($request->tipoRecurso === 'Video') {
                $request->validate([
                    'video' => 'sometimes|mimes:mp4,avi,mov|max:50480', // Hasta 50MB
                    'duracionVideo' => 'sometimes|integer|min:1'
                ]);

                if ($request->hasFile('video')) {
                    $rutaArchivo = $request->file('video')->store('videos', 'public');
                    $recurso->enlaceRecurso = asset('storage/' . $rutaArchivo);
                }
            }

            // Si es un Ejercicio o Recurso Adicional
            if (in_array($request->tipoRecurso, ['Ejercicio', 'Recurso Adicional'])) {
                $request->validate([
                    'archivo' => 'sometimes|mimes:zip,pdf,docx,txt,pptx|max:10240'
                ]);

                if ($request->hasFile('archivo')) {
                    $rutaArchivo = $request->file('archivo')->store('recursos', 'public');
                    $recurso->enlaceRecurso = asset('storage/' . $rutaArchivo);
                }
            }

            // Actualizar campos, (solo los campos enviados en la solicitud)
            $recurso->fill($request->only([
                'tipoRecurso', 'tituloRecurso', 'descripcionRecurso', 'duracionVideo'
            ]));
            $recurso->save();

            return response()->json([
                'message' => 'Recurso actualizado correctamente',
                'recurso' => $recurso
            ], 200);
        }catch(\Exception $e){
            return response()->json([
                'error' => 'Error al actualizar el recurso',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($idRecurso){
        try {
            // Buscar el recurso
            $recurso = Recurso::where('idRecurso', $idRecurso)->firstOrFail();

            // ELiminar el archivo del servidor, si es que existe
            if($recurso->enlaceRecurso){
                $path = str_replace(asset('/storage'), '', $recurso->enlaceRecurso);
                Storage::disk('public')->delete($path);
            }
            $recurso->delete();

            return response()->json(['message' => 'Recurso eliminado correctamente'], 201);
        }catch(\Exception $e){
            return response()->json([
                'error' => 'Error al eliminar el recurso',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}

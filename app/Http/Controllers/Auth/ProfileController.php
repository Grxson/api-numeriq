<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
    * Mostrar el perfil del usuario
     * */
    public function show(){
        return response()->json(Auth::user());
    }

    public function update(Request $request){
        $user = Auth::user();

        // validación de campos
        $request->validate([
            'nombre' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:usuarios,email,' . $user->idUsuario . ',idUsuario',
            'descripcion' => 'nullable|string|max:500',
            'institucion' => 'nullable|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Actualizar los datos del usuario
        if ($request->has('nombre')) {
            $user->nombre = $request->nombre;
        }
        if ($request->has('email')) {
            $user->email = $request->email;
        }
        if ($request->has('descripcion')) {
            $user->descripcion = $request->descripcion;
        }
        if ($request->has('institucion')) {
            $user->institucion = $request->institucion;
        }

        // Si hay imagen nueva, eliminar la anterior y guardar la nueva
        if($request->hasFile('foto')){
            if($user->foto){
                $path = str_replace(asset('storage/'), '', $user->foto);
                Storage::disk('public')->delete($path);
            }

            $fotoPath = $request->file('foto')->store('perfiles', 'public');
            $user->foto = asset('storage/' . $fotoPath);

        }
        $user->save();

        return response()->json([
            'message' => 'Perfil actualizado correctamente',
            'user' => $user,
        ]);
    }

    /**
     * Eliminar la cuenta del usuario autenticado
     */
    public function destroy()
    {
        $user = Auth::user();

        // Eliminar imagen si existe
        if ($user->foto) {
            $path = str_replace(asset('storage/'), '', $user->foto);
            Storage::disk('public')->delete($path);
        }

        $user->delete();

        return response()->json([
            'message' => 'Cuenta eliminada correctamente'
        ]);
    }


}

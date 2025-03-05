<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
    * Mostrar el perfil del usuario
     * */
    public function show(){
        return response()->json(Auth::user());
    }
}

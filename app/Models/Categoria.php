<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;
    protected $table = 'categorias';
    protected $primaryKey = 'idCategoria';
    public $timestamps = true;

    protected $fillable = ['nombreCategoria', 'descripcionCategoria'];

    public function temas()
    {
        return $this->hasMany(Tema::class, 'idCategoria');
    }

    public function index()
    {
        // Obtener todas las categorías
        $categorias = Categoria::all();
        return response()->json($categorias);
    }
}

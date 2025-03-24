<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tema extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombreTema',
        'descripcionTema',
        'miniaturaTema',
        'precio',
        'idCategoria',
        'idNivel',
        'horasContenido',
        'fechaUltimaActualizacion',
        'idioma',
        'certificado'
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'idCategoria');
    }

    public function nivel()
    {
        return $this->belongsTo(NivelEducativo::class, 'idNivel');
    }

    public function deseos()
    {
        return $this->hasMany(Deseo::class, 'idTema');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static find(mixed $idTema)
 * @method static create(array $array)
 */
class Tema extends Model
{
    use HasFactory;

    protected $primaryKey = 'idTema';

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

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class, 'idCategoria');
    }

    public function nivel(): BelongsTo
    {
        return $this->belongsTo(NivelEducativo::class, 'idNivel');
    }

    public function deseos()
    {
        return $this->hasMany(Deseo::class, 'idTema');
    }

    public function recursos()
    {
        return $this->hasMany(Recurso::class, 'idTema');
    }
}

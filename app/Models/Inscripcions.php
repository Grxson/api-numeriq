<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $array)
 * @method static where(string $string, $idUsuario)
 */
class Inscripcions extends Model
{
    use HasFactory;

    protected $table = 'inscripcions';
    protected $primaryKey = 'idInscripcion';

    protected $fillable = [
        'idUsuario',
        'idTema',
        'estado',
        'fechaInscripcion',
        'progreso',
    ];

    public function tema()
    {
        return $this->belongsTo(Tema::class, 'idTema', 'idTema');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'idUsuario');
    }
}

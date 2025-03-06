<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recurso extends Model
{
    use HasFactory;

    protected $table = 'recursos';
    protected $primaryKey = 'idRecurso';

    protected $fillable = [
        'tipoRecurso',
        'tituloRecurso',
        'descripcionRecurso',
        'enlaceRecurso',
        'duracionVideo',
        'tipoExamen',
        'idTema',
    ];

    public function tema(){
        return $this->belongsTo(Tema::class, 'idTema');
    }
}

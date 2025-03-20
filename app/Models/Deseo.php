<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deseo extends Model
{
    use HasFactory;

    protected $table = 'deseos';
    protected $primaryKey = 'idDeseo';

    protected $fillable = ['idUsuario', 'idTema', 'fechaAgregado'];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'idUsuario');
    }
    public function tema()
    {
        return $this->belongsTo(Tema::class, 'idTema');
    }
}

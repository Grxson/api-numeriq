<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NivelEducativo extends Model
{
    use HasFactory;
    protected $table = 'nivel_educativos';
    protected $primaryKey = 'idNivel';
    public $timestamps = true;

    protected $fillable = ['nombreNivel'];

    public function temas()
    {
        return $this->hasMany(Tema::class, 'idNivel');
    }
}

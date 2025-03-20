<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static firstOrCreate(array $array, int[] $array1)
 * @method static where(string $string, $idUsuario)
 */
class Carrito extends Model
{
    use HasFactory;

    protected $table = 'carritos';
    protected $primaryKey = 'idCarrito';

    protected $fillable = ['idUsuario', 'total'];

    public function detalles(): HasMany
    {
        return $this->hasMany(CarritoDetalle::class, 'idCarrito');
    }

}

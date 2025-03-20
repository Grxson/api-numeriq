<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static where(string $string, $idCarrito)
 * @method static create(array $array)
 */
class CarritoDetalle extends Model
{
    use HasFactory;

    protected $table = 'carrito_detalles';
    protected $primaryKey = 'idCarritoDetalle';

    protected $fillable = ['idCarrito', 'idTema', 'cantidad', 'precio'];

    public function tema(): BelongsTo
    {
        return $this->belongsTo(Tema::class, 'idTema');
    }
}

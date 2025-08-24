<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleProducto extends Model
{
    use HasFactory;

    // Nombre de la tabla (opcional, Laravel lo infiere automáticamente)
    protected $table = 'detalles_productos';

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'producto_id',
        'caracteristicas',
        'resumen',
        'especificaciones',
    ];

    /**
     * Relación: Un detalle pertenece a un producto
     */
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}

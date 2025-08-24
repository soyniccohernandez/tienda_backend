<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FotoProducto extends Model
{
    use HasFactory;

    // Nombre de la tabla (opcional si el plural concuerda con Laravel)
    protected $table = 'fotos_productos';

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'producto_id',
        'nombre_archivo',
        'ruta_archivo',
        'tipo_archivo',
        'tamano_archivo',
    ];

    /**
     * Relación con el modelo Producto
     */
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
    
}

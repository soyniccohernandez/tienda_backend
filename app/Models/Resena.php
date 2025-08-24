<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resena extends Model
{
    use HasFactory;

    // Nombre de la tabla (opcional, Laravel lo infiere automáticamente)
    protected $table = 'reseñas';

    // Campos que se pueden asignar de forma masiva
    protected $fillable = [
        'producto_id',
        'user_id',
        'contenido',
        'rating',
    ];

    /**
     * Relación: Una reseña pertenece a un producto
     */
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }

    /**
     * Relación: Una reseña pertenece a un usuario
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

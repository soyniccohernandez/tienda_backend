<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    // Campos que se pueden asignar de forma masiva
    protected $fillable = [
        'nombre',
        'marca',
        'especificaciones', // info básica
        'garantia',
        'precio',
        'fecha_lanzamiento',
        'categoria_id',
    ];

    /**
     * Relación: Un producto pertenece a una categoría
     */
    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    /**
     * Relación: Un producto puede tener muchas fotos
     */
    public function fotos()
    {
        return $this->hasMany(FotoProducto::class, 'producto_id');
    }

    /**
     * Relación: Un producto puede tener varias reseñas de usuarios
     */
    public function resenas()
    {
        return $this->hasMany(Resena::class, 'producto_id');
    }

    /**
     * Relación: Un producto tiene un detalle extendido
     */
    public function detalle()
    {
        return $this->hasOne(DetalleProducto::class, 'producto_id');
    }
}

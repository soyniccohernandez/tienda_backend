<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResenaApiController extends Controller
{
    /**
     * Guardar una reseña para un producto.
     */
    public function store(Request $request, Producto $producto)
    {
        // Validar datos
        $request->validate([
            'contenido' => 'required|string|max:1000',
            'rating'    => 'nullable|integer|min:1|max:5',
        ]);

        // Revisar si el usuario ya dejó una reseña para este producto
        $existeResena = $producto->resenas()->where('user_id', Auth::id())->exists();
        if ($existeResena) {
            return response()->json([
                'success' => false,
                'message' => 'Ya has dejado una reseña para este producto.',
            ], 409); // 409 Conflict
        }

        // Crear la reseña
        $resena = $producto->resenas()->create([
            'user_id'  => Auth::id(),
            'contenido'=> $request->contenido,
            'rating'   => $request->rating,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Reseña agregada correctamente.',
            'data'    => $resena,
        ], 201); // 201 Created
    }
}

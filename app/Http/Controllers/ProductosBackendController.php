<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductosBackendController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Producto::query();

        // Búsqueda por nombre, marca o especificaciones
        if ($request->filled('search')) {
            $query->where('nombre', 'like', "%{$request->search}%")
                ->orWhere('marca', 'like', "%{$request->search}%")
                ->orWhere('especificaciones', 'like', "%{$request->search}%");
        }

        // Paginación (10 por página)
        $productos = $query->with('categoria')->paginate(10);

        // Retorna la vista con los datos
        return view('productosback.index', compact('productos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Trae todas las categorías para el select en el formulario
        $categorias = Categoria::all();

        // Retorna la vista con las categorías disponibles
        return view('productosback.create', compact('categorias'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validación manual
        $validator = Validator::make($request->all(), [
            'nombre'            => 'required|string|max:255|unique:productos,nombre',
            'marca'             => 'required|string|max:255',
            'especificaciones'  => 'nullable|string',
            'garantia'          => 'nullable|string|max:255',
            'precio'            => 'required|numeric|min:0',
            'fecha_lanzamiento' => 'nullable|date',
            'categoria_id'      => 'required|exists:categorias,id',
        ]);

        if ($validator->fails()) {
            // Redirige de vuelta con errores en SweetAlert
            return redirect()->back()
                ->with('error', 'Por favor corrige los errores en el formulario.')
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Crea el producto
            Producto::create([
                'nombre'            => $request->nombre,
                'marca'             => $request->marca,
                'especificaciones'  => $request->especificaciones,
                'garantia'          => $request->garantia,
                'precio'            => $request->precio,
                'fecha_lanzamiento' => $request->fecha_lanzamiento,
                'categoria_id'      => $request->categoria_id,
            ]);

            return redirect()->route('productosback.index')
                ->with('success', 'Producto creado correctamente.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Ocurrió un error al crear el producto.')
                ->withInput();
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Producto $producto)
    {
        // Para mostrar la lista de categorías en el select del formulario
        $categorias = Categoria::all();

        return view('productosback.edit', compact('producto', 'categorias'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Producto $producto)
    {
        // Validación manual
        $validator = Validator::make($request->all(), [
            'nombre'           => 'required|string|max:255|unique:productos,nombre,' . $producto->id,
            'marca'            => 'required|string|max:255',
            'especificaciones' => 'nullable|string',
            'garantia'         => 'nullable|string|max:255',
            'precio'           => 'required|numeric|min:0',
            'fecha_lanzamiento' => 'nullable|date',
            'categoria_id'     => 'required|exists:categorias,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->with('error', 'Por favor corrige los errores en el formulario.')
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Actualiza el producto
            $producto->update($request->only(
                'nombre',
                'marca',
                'especificaciones',
                'garantia',
                'precio',
                'fecha_lanzamiento',
                'categoria_id'
            ));

            return redirect()->route('productosback.index')
                ->with('success', 'Producto actualizado correctamente.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Ocurrió un error al actualizar el producto.')
                ->withInput();
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Producto $producto)
    {
        try {
            $producto->delete();

            // Mensaje de éxito con SweetAlert
            return redirect()->route('productosback.index')
                ->with('success', 'Producto eliminado correctamente.');
        } catch (\Exception $e) {
            // Mensaje de error con SweetAlert
            return redirect()->route('productosback.index')
                ->with('error', 'Ocurrió un error al eliminar el producto.');
        }
    }
}

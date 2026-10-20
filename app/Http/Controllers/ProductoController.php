<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::all();

        return view('productos', compact('productos'));
    }

    public function guardar(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0'
        ]);

        Producto::create($request->all());

        return redirect('/productos');
    }

    public function editar($id)
    {
        $producto = Producto::findOrFail($id);

        return view('editar-producto', compact('producto'));
    }

    public function actualizar(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0'
        ]);

        $producto = Producto::findOrFail($id);

        $producto->update($request->all());

        return redirect('/productos');
    }

    public function eliminar($id)
    {
        $producto = Producto::findOrFail($id);

        $producto->delete();

        return redirect('/productos');
    }
}

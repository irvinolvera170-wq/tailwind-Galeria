<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ClienteController extends Controller
{
    public function index()
    {
        $clientes = Cliente::all();
        return view('clientes', compact('clientes'));
    }

    public function guardar(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'email' => 'required|email|unique:clientes,email',
            'direccion' => 'required|string|max:255',
            'telefono' => 'required|string|max:20'
        ]);

        Cliente::create($request->all());

        return redirect('/clientes');
    }

    public function editar($id)
    {
        $cliente = Cliente::findOrFail($id);
        return view('editar-cliente', compact('cliente'));
    }

    public function actualizar(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'email' => [
                'required',
                'email',
                Rule::unique('clientes', 'email')->ignore($id)
            ],
            'direccion' => 'required|string|max:255',
            'telefono' => 'required|string|max:20'
        ]);

        $cliente = Cliente::findOrFail($id);
        $cliente->update($request->all());

        return redirect('/clientes');
    }

    public function eliminar($id)
    {
        $cliente = Cliente::findOrFail($id);
        $cliente->delete();

        return redirect('/clientes');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Cliente;
use App\Models\Producto;
use App\Models\DetalleVenta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VentaController extends Controller
{
    public function index()
    {
        $ventas = Venta::with('cliente')->get();
        $clientes = Cliente::all();
        $productos = Producto::where('stock', '>', 0)->get();

        return view('ventas', compact('ventas', 'clientes', 'productos'));
    }

    public function guardar(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($request) {
            $producto = Producto::where('id', $request->producto_id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($producto->stock < $request->cantidad) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'cantidad' => 'No hay suficiente stock para esta venta.'
                ]);
            }

            $total = $producto->precio * $request->cantidad;

            $venta = Venta::create([
                'cliente_id' => $request->cliente_id,
                'fecha_venta' => now()->toDateString(),
                'estado' => 'pendiente',
                'total' => $total
            ]);

            DetalleVenta::create([
                'venta_id' => $venta->id,
                'producto_id' => $producto->id,
                'cantidad' => $request->cantidad,
                'precio_unitario' => $producto->precio,
                'total' => $total
            ]);

            $producto->stock = $producto->stock - $request->cantidad;
            $producto->save();
        });

        return redirect('/ventas');
    }

    public function cambiarEstado(Request $request, $id)
    {
        $request->validate([
            'estado' => 'required|in:pendiente,confirmada,cancelada'
        ]);

        $venta = Venta::findOrFail($id);
        $venta->estado = $request->estado;
        $venta->save();

        return redirect('/ventas');
    }

    
public function eliminar($id)
{
    $venta = Venta::findOrFail($id);

    if ($venta->estado != 'pendiente' && $venta->estado != 'cancelada') {
        return redirect('/ventas')
            ->with('error', 'No puedes eliminar una venta confirmada.');
    }

    DB::transaction(function () use ($venta) {
        $detalles = DetalleVenta::where('venta_id', $venta->id)->get();

        foreach ($detalles as $detalle) {
            $producto = Producto::find($detalle->producto_id);

            if ($producto) {
                $producto->stock += $detalle->cantidad;
                $producto->save();
            }

            $detalle->delete();
        }

        $venta->delete();
    });

    return redirect('/ventas');
}

}

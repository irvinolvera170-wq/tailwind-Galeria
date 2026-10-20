<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ventas</title>
</head>
<body>

    <h1>Registro de ventas</h1>
    @if (session('error'))
    <p style="color: red;">{{ session('error') }}</p>
    @endif

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <p style="color: red;">{{ $error }}</p>
        @endforeach
    @endif

    <h2>Registrar venta</h2>

    @if ($clientes->isEmpty())
        <p>Primero debes registrar un cliente.</p>
    @elseif ($productos->isEmpty())
        <p>No hay productos con stock disponible.</p>
    @else
        <form action="/ventas" method="POST">
            @csrf

            <label>Cliente:</label>
            <select name="cliente_id" required>
                <option value="">Selecciona un cliente</option>
                @foreach ($clientes as $cliente)
                    <option value="{{ $cliente->id }}">
                        {{ $cliente->nombre }}
                    </option>
                @endforeach
            </select>

            <br><br>

            <label>Producto:</label>
            <select name="producto_id" required>
                <option value="">Selecciona un producto</option>
                @foreach ($productos as $producto)
                    <option value="{{ $producto->id }}">
                        {{ $producto->nombre }} - ${{ number_format($producto->precio, 2) }} - Stock: {{ $producto->stock }}
                    </option>
                @endforeach
            </select>

            <br><br>

            <label>Cantidad:</label>
            <input type="number" name="cantidad" min="1" required>

            <br><br>

            <button type="submit">Guardar venta</button>
        </form>
    @endif

    <hr>

    <h2>Ventas registradas</h2>

    @if ($ventas->isEmpty())
        <p>No hay ventas registradas.</p>
    @else
        <table border="1" cellpadding="10">
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Fecha</th>
                <th>Total</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>

            @foreach ($ventas as $venta)
                <tr>
                    <td>{{ $venta->id }}</td>
                    <td>{{ $venta->cliente->nombre }}</td>
                    <td>{{ $venta->fecha_venta }}</td>
                    <td>${{ number_format($venta->total, 2) }}</td>
                    <td>{{ $venta->estado }}</td>
                    <td>
                        <form action="/ventas/{{ $venta->id }}/estado" method="POST">
                            @csrf
                            @method('PUT')

                            <select name="estado">
                                <option value="pendiente" {{ $venta->estado == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                <option value="confirmada" {{ $venta->estado == 'confirmada' ? 'selected' : '' }}>Confirmada</option>
                                <option value="cancelada" {{ $venta->estado == 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                            </select>

                            <button type="submit">Cambiar estado</button>
                        </form>

                        @if ($venta->estado == 'pendiente' || $venta->estado == 'cancelada')
                            <form action="/ventas/{{ $venta->id }}" method="POST"
                                  onsubmit="return confirm('¿Seguro que quieres eliminar esta venta?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit">Eliminar</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </table>
    @endif

    <br>
    <a href="/productos">Ir a productos</a>
    <br><br>
    <a href="/clientes">Ir a clientes</a>

</body>
</html>

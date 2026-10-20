
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ventas</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container mt-4">

        <h1 class="text-dark text-center mb-4">Módulo de ventas</h1>

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <p class="mb-1">{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Registrar venta</h4>
            </div>

            <div class="card-body">
                @if ($clientes->isEmpty())
                    <div class="alert alert-warning">
                        Primero debes registrar un cliente.
                    </div>
                @elseif ($productos->isEmpty())
                    <div class="alert alert-warning">
                        No hay productos con stock disponible.
                    </div>
                @else
                    <form action="/ventas" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Cliente:</label>
                            <select name="cliente_id" class="form-select" required>
                                <option value="">Selecciona un cliente</option>

                                @foreach ($clientes as $cliente)
                                    <option value="{{ $cliente->id }}"
                                        {{ old('cliente_id') == $cliente->id ? 'selected' : '' }}>
                                        {{ $cliente->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Producto:</label>
                            <select name="producto_id" class="form-select" required>
                                <option value="">Selecciona un producto</option>

                                @foreach ($productos as $producto)
                                    <option value="{{ $producto->id }}"
                                        {{ old('producto_id') == $producto->id ? 'selected' : '' }}>
                                        {{ $producto->nombre }} -
                                        ${{ number_format($producto->precio, 2) }} -
                                        Stock: {{ $producto->stock }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Cantidad:</label>
                            <input type="number" name="cantidad" class="form-control"
                                   min="1" value="{{ old('cantidad', 1) }}" required>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            Guardar venta
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-dark text-white">
                <h4 class="mb-0">Ventas registradas</h4>
            </div>

            <div class="card-body">
                @if ($ventas->isEmpty())
                    <div class="alert alert-info">
                        No hay ventas registradas.
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover align-middle">
                            <thead class="table-primary">
                                <tr>
                                    <th>ID</th>
                                    <th>Cliente</th>
                                    <th>Fecha</th>
                                    <th>Total</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($ventas as $venta)
                                    <tr>
                                        <td>{{ $venta->id }}</td>
                                        <td>
                                            {{ $venta->cliente ? $venta->cliente->nombre : 'Cliente no disponible' }}
                                        </td>
                                        <td>{{ $venta->fecha_venta }}</td>
                                        <td>${{ number_format($venta->total, 2) }}</td>
                                        <td>
                                            @if ($venta->estado == 'confirmada')
                                                <span class="badge bg-success">Confirmada</span>
                                            @elseif ($venta->estado == 'cancelada')
                                                <span class="badge bg-danger">Cancelada</span>
                                            @else
                                                <span class="badge bg-warning text-dark">Pendiente</span>
                                            @endif
                                        </td>

                                        <td>
                                            <form action="/ventas/{{ $venta->id }}/estado"
                                                  method="POST" class="mb-2">
                                                @csrf
                                                @method('PUT')

                                                <select name="estado" class="form-select form-select-sm mb-2">
                                                    <option value="pendiente"
                                                        {{ $venta->estado == 'pendiente' ? 'selected' : '' }}>
                                                        Pendiente
                                                    </option>
                                                    <option value="confirmada"
                                                        {{ $venta->estado == 'confirmada' ? 'selected' : '' }}>
                                                        Confirmada
                                                    </option>
                                                    <option value="cancelada"
                                                        {{ $venta->estado == 'cancelada' ? 'selected' : '' }}>
                                                        Cancelada
                                                    </option>
                                                </select>

                                                <button type="submit" class="btn btn-primary btn-sm">
                                                    Cambiar estado
                                                </button>
                                            </form>

                                            @if ($venta->estado == 'pendiente' || $venta->estado == 'cancelada')
                                                <form action="/ventas/{{ $venta->id }}"
                                                      method="POST"
                                                      onsubmit="return confirm('¿Seguro que quieres eliminar esta venta?')">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        Eliminar
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

        <div class="text-center mt-4 mb-4">
            <a href="/productos" class="btn btn-primary">Ir a productos</a>
            <a href="/clientes" class="btn btn-success">Ir a clientes</a>
        </div>

    </div>

</body>
</html>

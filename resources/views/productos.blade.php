<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Productos</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container mt-4">

        <h1 class="text-primary text-center mb-4">Lista de productos</h1>

        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Registrar producto</h4>
            </div>

            <div class="card-body">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <p class="mb-1">{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form action="/productos" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Nombre:</label>
                        <input type="text" name="nombre" class="form-control"
                               value="{{ old('nombre') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Precio:</label>
                        <input type="number" name="precio" class="form-control"
                               step="0.01" min="0" value="{{ old('precio') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Stock:</label>
                        <input type="number" name="stock" class="form-control"
                               min="0" value="{{ old('stock') }}" required>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        Guardar producto
                    </button>
                </form>

            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-dark text-white">
                <h4 class="mb-0">Productos registrados</h4>
            </div>

            <div class="card-body">

                @if ($productos->isEmpty())
                    <div class="alert alert-info">
                        No hay productos registrados.
                    </div>
                @else

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover align-middle">

                            <thead class="table-primary">
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Precio</th>
                                    <th>Stock</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($productos as $producto)
                                    <tr>
                                        <td>{{ $producto->id }}</td>
                                        <td>{{ $producto->nombre }}</td>
                                        <td>${{ number_format($producto->precio, 2) }}</td>
                                        <td>{{ $producto->stock }}</td>

                                        <td>
                                            <a href="/productos/{{ $producto->id }}/editar"
                                               class="btn btn-warning btn-sm mb-1">
                                                Editar
                                            </a>

                                            <form action="/productos/{{ $producto->id }}"
                                                  method="POST"
                                                  class="d-inline"
                                                  onsubmit="return confirm('¿Seguro que quieres eliminar este producto?')">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn btn-danger btn-sm mb-1">
                                                    Eliminar
                                                </button>
                                            </form>
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
            <a href="/clientes" class="btn btn-success">Ir a clientes</a>
            <a href="/ventas" class="btn btn-dark">Ir a ventas</a>
        </div>

    </div>

</body>
</html>

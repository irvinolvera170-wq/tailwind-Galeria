
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Clientes</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container mt-4">

        <h1 class="text-success text-center mb-4">Registro de clientes</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <p class="mb-1">{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <div class="card shadow-sm mb-4">
            <div class="card-header bg-success text-white">
                <h4 class="mb-0">Registrar cliente</h4>
            </div>

            <div class="card-body">
                <form action="/clientes" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Nombre:</label>
                        <input type="text" name="nombre" class="form-control"
                               value="{{ old('nombre') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Correo electrónico:</label>
                        <input type="email" name="email" class="form-control"
                               value="{{ old('email') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Dirección:</label>
                        <input type="text" name="direccion" class="form-control"
                               value="{{ old('direccion') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Teléfono:</label>
                        <input type="text" name="telefono" class="form-control"
                               maxlength="20" value="{{ old('telefono') }}" required>
                    </div>

                    <button type="submit" class="btn btn-success">
                        Guardar cliente
                    </button>
                </form>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-dark text-white">
                <h4 class="mb-0">Clientes registrados</h4>
            </div>

            <div class="card-body">
                @if ($clientes->isEmpty())
                    <div class="alert alert-info">
                        No hay clientes registrados.
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover align-middle">
                            <thead class="table-success">
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Correo</th>
                                    <th>Dirección</th>
                                    <th>Teléfono</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($clientes as $cliente)
                                    <tr>
                                        <td>{{ $cliente->id }}</td>
                                        <td>{{ $cliente->nombre }}</td>
                                        <td>{{ $cliente->email }}</td>
                                        <td>{{ $cliente->direccion }}</td>
                                        <td>{{ $cliente->telefono }}</td>
                                        <td>
                                            <a href="/clientes/{{ $cliente->id }}/editar"
                                               class="btn btn-warning btn-sm mb-1">
                                                Editar
                                            </a>

                                            <form action="/clientes/{{ $cliente->id }}"
                                                  method="POST"
                                                  class="d-inline"
                                                  onsubmit="return confirm('¿Seguro que quieres eliminar este cliente?')">
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
            <a href="/productos" class="btn btn-primary">Ir a productos</a>
            <a href="/ventas" class="btn btn-dark">Ir a ventas</a>
        </div>

    </div>

</body>
</html>

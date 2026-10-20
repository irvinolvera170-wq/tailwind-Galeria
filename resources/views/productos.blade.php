
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Productos</title>
</head>
<body>

    <h1>Lista de productos</h1>

    <h2>Registrar producto</h2>

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <p style="color: red;">{{ $error }}</p>
        @endforeach
    @endif

    <form action="/productos" method="POST">
        @csrf

        <label>Nombre:</label>
        <input type="text" name="nombre" required>
        <br><br>

        <label>Precio:</label>
        <input type="number" name="precio" step="0.01" min="0" required>
        <br><br>

        <label>Stock:</label>
        <input type="number" name="stock" min="0" required>
        <br><br>

        <button type="submit">Guardar producto</button>
    </form>

    <hr>

    <h2>Productos registrados</h2>

    @if ($productos->isEmpty())
        <p>No hay productos registrados.</p>
    @else
        <table border="1" cellpadding="10">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Acciones</th>
            </tr>

            @foreach ($productos as $producto)
                <tr>
                    <td>{{ $producto->id }}</td>
                    <td>{{ $producto->nombre }}</td>
                    <td>${{ number_format($producto->precio, 2) }}</td>
                    <td>{{ $producto->stock }}</td>
                    <td>
                        <a href="/productos/{{ $producto->id }}/editar">
                            Editar
                        </a>

                        <form action="/productos/{{ $producto->id }}"
                              method="POST"
                              style="display:inline;"
                              onsubmit="return confirm('¿Seguro que quieres eliminar este producto?')">
                            @csrf
                            @method('DELETE')

                            <button type="submit">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
    @endif

</body>
</html>

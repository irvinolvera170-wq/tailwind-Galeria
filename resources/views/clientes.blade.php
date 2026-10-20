<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Clientes</title>
</head>
<body>

    <h1>Registro de clientes</h1>

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <p style="color: red;">{{ $error }}</p>
        @endforeach
    @endif

    <h2>Registrar cliente</h2>

    <form action="/clientes" method="POST">
        @csrf

        <label>Nombre:</label>
        <input type="text" name="nombre" required>
        <br><br>

        <label>Correo:</label>
        <input type="email" name="email" required>
        <br><br>

        <label>Dirección:</label>
        <input type="text" name="direccion" required>
        <br><br>

        <label>Teléfono:</label>
        <input type="text" name="telefono" maxlength="20" required>
        <br><br>

        <button type="submit">Guardar cliente</button>
    </form>

    <hr>

    <h2>Clientes registrados</h2>

    @if ($clientes->isEmpty())
        <p>No hay clientes registrados.</p>
    @else
        <table border="1" cellpadding="10">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Dirección</th>
                <th>Teléfono</th>
                <th>Acciones</th>
            </tr>

            @foreach ($clientes as $cliente)
                <tr>
                    <td>{{ $cliente->id }}</td>
                    <td>{{ $cliente->nombre }}</td>
                    <td>{{ $cliente->email }}</td>
                    <td>{{ $cliente->direccion }}</td>
                    <td>{{ $cliente->telefono }}</td>
                    <td>
                        <a href="/clientes/{{ $cliente->id }}/editar">Editar</a>

                        <form action="/clientes/{{ $cliente->id }}"
                              method="POST"
                              style="display:inline;"
                              onsubmit="return confirm('¿Seguro que quieres eliminar este cliente?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
    @endif

    <br>
    <a href="/productos">Ir a productos</a>

</body>
</html>

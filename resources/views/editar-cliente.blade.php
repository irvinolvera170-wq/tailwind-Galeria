<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar cliente</title>
</head>
<body>

    <h1>Editar cliente</h1>

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <p style="color: red;">{{ $error }}</p>
        @endforeach
    @endif

    <form action="/clientes/{{ $cliente->id }}" method="POST">
        @csrf
        @method('PUT')

        <label>Nombre:</label>
        <input type="text" name="nombre"
               value="{{ $cliente->nombre }}" required>
        <br><br>

        <label>Correo:</label>
        <input type="email" name="email"
               value="{{ $cliente->email }}" required>
        <br><br>

        <label>Dirección:</label>
        <input type="text" name="direccion"
               value="{{ $cliente->direccion }}" required>
        <br><br>

        <label>Teléfono:</label>
        <input type="text" name="telefono"
               value="{{ $cliente->telefono }}" maxlength="20" required>
        <br><br>

        <button type="submit">Actualizar cliente</button>
    </form>

    <br>
    <a href="/clientes">Volver a clientes</a>

</body>
</html>

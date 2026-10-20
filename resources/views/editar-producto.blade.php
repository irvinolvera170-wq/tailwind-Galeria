<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar producto</title>
</head>
<body>

    <h1>Editar producto</h1>

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <p style="color: red;">{{ $error }}</p>
        @endforeach
    @endif

    <form action="/productos/{{ $producto->id }}" method="POST">
        @csrf
        @method('PUT')

        <label>Nombre:</label>
        <input type="text" name="nombre"
               value="{{ $producto->nombre }}" required>
        <br><br>

        <label>Precio:</label>
        <input type="number" name="precio" step="0.01" min="0"
               value="{{ $producto->precio }}" required>
        <br><br>

        <label>Stock:</label>
        <input type="number" name="stock" min="0"
               value="{{ $producto->stock }}" required>
        <br><br>

        <button type="submit">Actualizar producto</button>
    </form>

    <br>

    <a href="/productos">Volver a productos</a>

</body>
</html>

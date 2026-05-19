<!doctype html>
<html lang="es">
<head><meta charset="utf-8"><title>Adivina el número</title></head>
<body>
<h1>Adivina el número (1-100)</h1>

<p>Intentos realizados: {{ $intentos }}</p>

@if ($mensaje)
    <p><strong>{{ $mensaje }}</strong></p>
@endif

<form method="POST" action="{{ route('adivina.probar') }}">
    @csrf
    <input type="number" name="numero" min="1" max="100" required>
    <button>Probar</button>
</form>

@error('numero') <p style="color:red">{{ $message }}</p> @enderror
</body>
</html>

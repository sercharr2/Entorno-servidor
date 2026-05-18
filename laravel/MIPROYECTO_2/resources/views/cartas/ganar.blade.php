<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>¡Ganaste!</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; padding: 60px; }
        h1   { font-size: 52px; color: goldenrod; }
        .btn { padding: 14px 40px; font-size: 20px; cursor: pointer; margin-top: 20px; }
    </style>
</head>
<body>

    <h1>¡Ganaste! &#127881;</h1>
    <p>¡Conseguiste 5 aciertos seguidos! Eres el mejor.</p>

    {{-- Reiniciar borra la sesión y vuelve al inicio del juego --}}
    <form method="POST" action="{{ route('cartas.reiniciar') }}">
        @csrf
        <button class="btn" type="submit">Jugar de nuevo</button>
    </form>

</body>
</html>

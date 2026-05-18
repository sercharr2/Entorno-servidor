<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mayor o Menor</title>
    <style>
        body  { font-family: Arial, sans-serif; text-align: center; padding: 30px; }
        img   { width: 140px; border: 2px solid #333; margin: 10px; }
        .btn  { padding: 12px 35px; font-size: 18px; margin: 5px; cursor: pointer; }
        .ok   { color: green; font-size: 20px; font-weight: bold; }
        .mal  { color: red;   font-size: 20px; font-weight: bold; }
    </style>
</head>
<body>

    <h1>Mayor o Menor</h1>

    {{-- Racha actual --}}
    <p>Racha: <strong>{{ $racha }} / 5</strong></p>

    {{-- Resultado del turno anterior (mensaje flash) --}}
    @if(session('resultado') === 'acierto')
        <p class="ok">¡Acertaste! Sigue así.</p>
    @elseif(session('resultado') === 'fallo')
        <p class="mal">¡Fallaste! Racha reiniciada a 0.</p>
    @endif

    {{-- Carta actual que el jugador debe evaluar --}}
    <p>Carta actual:</p>
    <img src="{{ asset($imagen) }}" alt="Carta {{ $valor }}">
    <p><em>(valor: {{ $valor }})</em></p>

    {{-- El jugador elige si la siguiente será mayor o menor --}}
    <p>¿La siguiente carta será...?</p>
    <form method="POST" action="{{ route('cartas.adivinar') }}">
        @csrf
        <button class="btn" type="submit" name="apuesta" value="mayor">&#9650; Mayor</button>
        <button class="btn" type="submit" name="apuesta" value="menor">&#9660; Menor</button>
    </form>

</body>
</html>

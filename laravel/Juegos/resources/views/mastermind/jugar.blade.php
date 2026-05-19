<!doctype html>
<html lang="es">
<head><meta charset="utf-8"><title>Mastermind</title></head>
<body>
<h1>Mastermind (intentos {{ count($intentos) }} / {{ $max }})</h1>

<p>Colores: {{ implode(', ', $colores) }}</p>

@foreach ($intentos as $i)
    <p>
        {{ implode(' ', $i['combinacion']) }}
        — ⚫ {{ $i['negras'] }} negras, ⚪ {{ $i['blancas'] }} blancas
    </p>
@endforeach

@if ($ganado)
    <p>🎉 ¡Acertaste! Era: {{ implode(' ', $secreto) }}</p>
@elseif ($perdido)
    <p>💀 Sin intentos. Era: {{ implode(' ', $secreto) }}</p>
@else
    <form method="POST" action="{{ route('mastermind.probar') }}">
        @csrf
        @for ($p = 0; $p < $longitud; $p++)
            <select name="colores[]" required>
                @foreach ($colores as $c)
                    <option value="{{ $c }}">{{ $c }}</option>
                @endforeach
            </select>
        @endfor
        <button>Probar</button>
    </form>
@endif
</body>
</html>

<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<title>Wordle</title>
<style>
    .letra { display:inline-block; width:32px; height:32px; line-height:32px;
             text-align:center; margin:2px; color:white; font-weight:bold; }
    .verde    { background:#4caf50; }
    .amarillo { background:#e6c200; }
    .gris     { background:#888;    }
</style>
</head>
<body>
<h1>Wordle (intentos {{ count($intentos) }} / {{ $max }})</h1>

@foreach ($intentos as $linea)
    <div>
        @foreach ($linea as $l)
            <span class="letra {{ $l['estado'] }}">{{ $l['letra'] }}</span>
        @endforeach
    </div>
@endforeach

@if ($ganado)
    <p>🎉 ¡Acertaste! La palabra era <strong>{{ $secreto }}</strong>.</p>
@elseif ($perdido)
    <p>💀 Sin intentos. La palabra era <strong>{{ $secreto }}</strong>.</p>
@else
    <form method="POST" action="{{ route('wordle.probar') }}">
        @csrf
        <input type="text" name="palabra" maxlength="5" minlength="5" required>
        <button>Probar</button>
    </form>
@endif
</body>
</html>

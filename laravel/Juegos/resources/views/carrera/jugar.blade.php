<!doctype html>
<html lang="es">
<head><meta charset="utf-8"><title>Carrera de caballos</title></head>
<body>
<h1>Carrera de caballos (meta = {{ $meta }})</h1>

@if ($mensaje) <p><strong>{{ $mensaje }}</strong></p> @endif

{{-- Pista de cada caballo: pintamos guiones según su posición --}}
@foreach ($posiciones as $i => $pos)
    <p>
        Caballo {{ $i + 1 }}: {!! str_repeat('-', min($pos, $meta)) !!}🐎 ({{ $pos }})
    </p>
@endforeach

@if (!$apuesta && !$ganador)
    <h3>Apuesta por un caballo</h3>
    <form method="POST" action="{{ route('carrera.apostar') }}">
        @csrf
        <input type="number" name="caballo" min="1" max="{{ count($posiciones) }}" required>
        <button>Apostar</button>
    </form>
@elseif (!$ganador)
    <p>Apostaste al caballo <strong>{{ $apuesta }}</strong>.</p>
    <form method="POST" action="{{ route('carrera.tirar') }}">
        @csrf <button>Tirar dados</button>
    </form>
@else
    <form method="POST" action="{{ route('carrera.reiniciar') }}">
        @csrf <button>Nueva carrera</button>
    </form>
@endif
</body>
</html>

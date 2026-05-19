<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<title>Tres en raya</title>
<style>
    .tablero { display:grid; grid-template-columns:repeat(3, 60px); gap:4px; }
    .casilla button { width:60px; height:60px; font-size:1.6em; }
</style>
</head>
<body>
<h1>Tres en raya (tú = X, IA = O)</h1>

<p>Estado: <strong>{{ $estado }}</strong></p>

<div class="tablero">
    @foreach ($tablero as $i => $v)
        <div class="casilla">
            @if ($v === null && $estado === 'jugando')
                <form method="POST" action="{{ route('tres.mover', $i) }}">
                    @csrf <button>·</button>
                </form>
            @else
                <button disabled>{{ $v ?? '·' }}</button>
            @endif
        </div>
    @endforeach
</div>

@if ($estado !== 'jugando')
    <form method="POST" action="{{ route('tres.reiniciar') }}">
        @csrf <button>Reiniciar</button>
    </form>
@endif
</body>
</html>

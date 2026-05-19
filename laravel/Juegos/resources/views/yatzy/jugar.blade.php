<!doctype html>
<html lang="es">
<head><meta charset="utf-8"><title>Yatzy</title></head>
<body>
<h1>Yatzy (puntos totales: {{ $puntosTotales }})</h1>

<p>Tirada {{ $tirada }} / 3</p>

<div>
    @foreach ($dados as $i => $d)
        {{-- Cada dado es un mini-form que toggla "guardado" --}}
        <form method="POST" action="{{ route('yatzy.guardar', $i) }}" style="display:inline">
            @csrf
            <button style="font-size:2em; {{ $guardados[$i] ? 'color:green' : '' }}">
                {{ $d ?: '·' }}
            </button>
        </form>
    @endforeach
</div>

@if ($tirada < 3)
    <form method="POST" action="{{ route('yatzy.tirar') }}">
        @csrf <button>Tirar dados</button>
    </form>
@endif

<h3>Puntuar (categorías ya usadas: {{ implode(', ', $categorias) ?: '—' }})</h3>
@foreach (['trio','poker','yatzy','full','escalera'] as $c)
    @if (!in_array($c, $categorias) && $tirada > 0)
        <form method="POST" action="{{ route('yatzy.puntuar', $c) }}" style="display:inline">
            @csrf <button>{{ ucfirst($c) }}</button>
        </form>
    @endif
@endforeach
</body>
</html>

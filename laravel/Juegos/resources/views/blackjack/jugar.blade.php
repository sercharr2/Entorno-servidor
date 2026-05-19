<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<title>Blackjack</title>
<style>
    body  { font-family: sans-serif; background:#0a5d2a; color:#eee; max-width:720px; margin:1em auto; padding:1em; }
    h1, h2, h3 { color:#fff; }
    /* Una "carta" es un rectángulo blanco con la cifra y el palo. */
    .carta { display:inline-block; width:60px; height:84px; background:#fff; color:#222;
             border-radius:6px; margin:4px; padding:4px; box-shadow:2px 2px 4px #0006;
             font-family:serif; font-weight:bold; text-align:left; vertical-align:top; }
    .carta .v { font-size:1.4em; line-height:1; }
    .carta .p { font-size:1.8em; display:block; text-align:right; margin-top:6px; }
    .roja  { color:#c00; }
    .dorso { background:repeating-linear-gradient(45deg,#234,#234 4px,#456 4px,#456 8px); color:transparent; }
    .acciones form { display:inline-block; margin-right:6px; }
    .acciones button, .apuesta button { font-size:1em; padding:0.4em 0.9em; cursor:pointer; }
    .res-blackjack { color:#ffd54a; font-weight:bold; }
    .res-gana      { color:#7fff7f; font-weight:bold; }
    .res-pierde    { color:#ff7777; font-weight:bold; }
    .res-empata    { color:#cccccc; font-weight:bold; }
    .res-rendido   { color:#ffaa55; font-weight:bold; }
</style>
</head>
<body>

@php
    // Helper local para pintar una carta. Lee "VALOR-PALO" y devuelve HTML.
    $pintar = function (string $carta, bool $oculta = false): string {
        if ($oculta) return '<span class="carta dorso">?</span>';
        [$v, $p] = explode('-', $carta);
        // Mapeamos las iniciales de palo al carácter unicode.
        $simb = ['P' => '♠', 'C' => '♥', 'D' => '♦', 'T' => '♣'][$p] ?? '?';
        $clase = in_array($p, ['C', 'D']) ? 'roja' : '';
        return "<span class='carta $clase'><span class='v'>$v</span><span class='p'>$simb</span></span>";
    };
@endphp

<h1>Blackjack</h1>
<p>Saldo: <strong>{{ $saldo }}</strong> @if($apuesta) | Apuesta: <strong>{{ $apuesta }}</strong> @endif</p>

@if ($errors->any())
    <p style="color:#ff8">{{ $errors->first() }}</p>
@endif

{{-- ============================================== CRUPIER --}}
<h2>Crupier</h2>
<div>
    @foreach ($crupier as $i => $c)
        {!! $pintar($c, !$mostrarCrupier && $i > 0) !!}
    @endforeach
</div>
@if ($mostrarCrupier)
    <p>Total: {{ $totalCrupier }}</p>
@endif

{{-- ============================================== JUGADOR --}}
<h2>Jugador</h2>
<div>
    @foreach ($jugador as $c)
        {!! $pintar($c) !!}
    @endforeach
</div>
@if ($jugador)
    <p>Total: {{ $totalJugador }}</p>
@endif

{{-- ============================================== ESTADO + ACCIONES --}}
@if ($fase === 'apuesta')
    @if ($saldo <= 0)
        <p>Te has quedado sin saldo. Borra la fila de `partidas` y recarga para reiniciar.</p>
    @else
        <h3>Haz tu apuesta</h3>
        <form class="apuesta" method="POST" action="{{ route('blackjack.apostar') }}">
            @csrf
            <input type="number" name="apuesta" min="1" max="{{ $saldo }}" value="10" required>
            <button>Apostar y repartir</button>
        </form>
    @endif

@elseif ($fase === 'jugando')
    <h3>Tu turno</h3>
    <div class="acciones">
        <form method="POST" action="{{ route('blackjack.pedir') }}">
            @csrf <button @disabled($doblado)>Pedir (Hit)</button>
        </form>
        <form method="POST" action="{{ route('blackjack.plantarse') }}">
            @csrf <button>Plantarse (Stand)</button>
        </form>
        {{-- Doblar solo es legal con 2 cartas y saldo suficiente. --}}
        <form method="POST" action="{{ route('blackjack.doblar') }}">
            @csrf
            <button @disabled(count($jugador) !== 2 || $saldo < $apuesta * 2)>
                Doblar (Double)
            </button>
        </form>
        <form method="POST" action="{{ route('blackjack.rendirse') }}">
            @csrf
            <button @disabled(count($jugador) !== 2)>Rendirse (Surrender)</button>
        </form>
    </div>

@elseif ($fase === 'terminada')
    <h3 class="res-{{ $resultado }}">
        @switch($resultado)
            @case('blackjack') ¡BLACKJACK! +{{ $pago }} @break
            @case('gana')      Ganas la mano (+{{ $pago }}) @break
            @case('pierde')    Pierdes la mano ({{ $pago }}) @break
            @case('empata')    Empate (push) @break
            @case('rendido')   Te has rendido ({{ $pago }}) @break
        @endswitch
    </h3>
    <form method="POST" action="{{ route('blackjack.nueva') }}">
        @csrf <button>Nueva mano</button>
    </form>
@endif

<p style="margin-top:2em"><a href="{{ url('/') }}" style="color:#eee">← Volver al índice</a></p>
</body>
</html>

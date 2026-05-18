@extends('layouts.app')

@section('title', 'Contador de sesión')

@section('styles')
<style>
    /* ── Contenedor centrado ── */
    .counter-wrap {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: calc(100vh - 65px);
        padding: 2rem;
        gap: 3rem;
    }

    /* ── Etiqueta superior ── */
    .label {
        font-size: .7rem;
        letter-spacing: .3em;
        text-transform: uppercase;
        color: var(--muted);
    }

    /* ── Número grande ── */
    .counter-display {
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: .5rem;
    }

    .counter-number {
        font-family: var(--font-head);
        font-size: clamp(7rem, 22vw, 14rem);
        line-height: 1;
        letter-spacing: -.02em;
        color: var(--text);
        transition: color .2s;
        /* Contorno offset */
        text-shadow:
            3px 3px 0 var(--accent),
            -1px -1px 0 var(--border);
    }

    .counter-number.positive { color: #f0f0f0; }
    .counter-number.negative { color: var(--danger); text-shadow: 3px 3px 0 #7a0000, -1px -1px 0 var(--border); }
    .counter-number.zero     { color: var(--muted); text-shadow: none; }

    /* ── Barra de estado ── */
    .status-bar {
        width: 220px;
        height: 3px;
        background: var(--border);
        border-radius: 2px;
        overflow: hidden;
    }
    .status-fill {
        height: 100%;
        background: var(--accent);
        width: {{ min(abs($count), 100) }}%;
        transition: width .3s ease;
    }
    @if($count < 0)
    .status-fill { background: var(--danger); }
    @endif

    /* ── Botones principales ── */
    .btn-group {
        display: flex;
        gap: 1rem;
        align-items: center;
    }

    .btn {
        cursor: pointer;
        border: 1.5px solid var(--border);
        background: var(--surface);
        color: var(--text);
        font-family: var(--font-head);
        font-size: 2rem;
        letter-spacing: .05em;
        width: 80px;
        height: 80px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all .15s ease;
        position: relative;
        overflow: hidden;
    }

    .btn::after {
        content: '';
        position: absolute;
        inset: 0;
        background: var(--accent);
        transform: translateY(100%);
        transition: transform .15s ease;
        z-index: 0;
    }

    .btn span { position: relative; z-index: 1; }

    .btn:hover::after  { transform: translateY(0); }
    .btn:hover         { color: #0f0f0f; border-color: var(--accent); }
    .btn:active        { transform: scale(.95); }

    /* Botón decrementar: acento rojo */
    .btn-dec::after    { background: var(--danger); }
    .btn-dec:hover     { color: #fff; border-color: var(--danger); }

    /* ── Botón reset ── */
    .btn-reset {
        cursor: pointer;
        background: transparent;
        border: 1px solid var(--border);
        color: var(--muted);
        font-family: var(--font-mono);
        font-size: .7rem;
        letter-spacing: .2em;
        text-transform: uppercase;
        padding: .6rem 1.4rem;
        transition: all .15s ease;
    }

    .btn-reset:hover {
        border-color: var(--muted);
        color: var(--text);
        background: #222;
    }

    .btn-reset:active { transform: scale(.97); }

    /* ── Footer hint ── */
    .hint {
        font-size: .65rem;
        color: #333;
        letter-spacing: .1em;
    }
</style>
@endsection

@section('content')
<div class="counter-wrap">

    <span class="label">// valor en sesión</span>

    {{-- Número --}}
    <div class="counter-display">
        <div class="counter-number {{ $count > 0 ? 'positive' : ($count < 0 ? 'negative' : 'zero') }}">
            {{ $count }}
        </div>
        <div class="status-bar">
            <div class="status-fill"></div>
        </div>
    </div>

    {{-- Botones + / - --}}
    <div class="btn-group">
        {{-- Decrementar --}}
        <form action="{{ route('counter.decrement') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-dec" title="Decrementar">
                <span>−</span>
            </button>
        </form>

        {{-- Incrementar --}}
        <form action="{{ route('counter.increment') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-inc" title="Incrementar">
                <span>+</span>
            </button>
        </form>
    </div>

    {{-- Reset --}}
    <form action="{{ route('counter.reset') }}" method="POST">
        @csrf
        <button type="submit" class="btn-reset">
            ↺ &nbsp;reiniciar
        </button>
    </form>

    <span class="hint">los cambios persisten mientras dure la sesión</span>

</div>
@endsection
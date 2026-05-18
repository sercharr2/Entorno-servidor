@extends('layouts.app')

@section('title', 'Ahorcado IA')

@section('styles')
<style>
    .card {
        background: #1c1c1e;
        border-radius: 32px;
        box-shadow: 0 0 0 1px rgba(255,255,255,.08), 0 40px 100px rgba(0,0,0,.9);
        width: 100%;
        max-width: 680px;
        overflow: hidden;
    }

    /* ── PLAYING LAYOUT ── */
    .board { display: flex; }

    .gallows-side {
        flex: 0 0 210px;
        background: #111113;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 28px 16px;
    }

    .hangman-svg { width: 100%; max-width: 190px; }
    .hangman-svg line,
    .hangman-svg circle,
    .hangman-svg path { fill: none; stroke-linecap: round; stroke-linejoin: round; }
    .st-gallows { stroke: #48484a; stroke-width: 5; }
    .st-rope    { stroke: #636366; stroke-width: 3; }
    .st-body    { stroke: #e5e5e7; stroke-width: 4; }
    .st-face    { stroke: #e5e5e7; stroke-width: 3; }

    .play-side {
        flex: 1;
        min-width: 0;
        padding: 28px 24px 32px;
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .badge {
        display: inline-flex; align-items: center; gap: 6px;
        font-size: 11px; font-weight: 700; letter-spacing: 1.5px;
        text-transform: uppercase; color: #bf5af2;
        background: rgba(191,90,242,.12);
        border: 1px solid rgba(191,90,242,.3);
        border-radius: 8px; padding: 4px 10px; width: fit-content;
    }

    .tema-tag {
        display: inline-flex; align-items: center; gap: 5px;
        font-size: 11px; font-weight: 600; letter-spacing: 0.5px;
        color: #636366;
        background: #2c2c2e;
        border: 1px solid #3a3a3c;
        border-radius: 6px; padding: 3px 9px; width: fit-content;
    }

    .pista-box {
        font-size: 13px; color: #bf5af2;
        background: rgba(191,90,242,.08);
        border: 1px solid rgba(191,90,242,.2);
        border-radius: 8px; padding: 7px 12px;
    }
    .pista-box strong { font-weight: 700; }

    .intentos-row { display: flex; align-items: baseline; gap: 6px; }
    .intentos-label { font-size: 13px; color: #636366; }
    .intentos-num   { font-size: 26px; font-weight: 600; color: #bf5af2; }
    .intentos-de    { font-size: 13px; color: #48484a; }

    .word-display { display: flex; flex-wrap: wrap; gap: 7px; }
    .lbox {
        width: 36px; height: 46px;
        border-radius: 8px;
        background: #2c2c2e;
        border: 1px solid #3a3a3c;
        display: flex; align-items: center; justify-content: center;
        font-size: 20px; font-weight: 700;
    }
    .lbox.revealed { color: #30d158; }
    .lbox.hidden   { color: transparent; }
    .lbox.correct  { color: #30d158; }
    .lbox.missed   { color: #ff453a; background: rgba(255,69,58,.1); border-color: #ff453a; }

    .section-label {
        font-size: 11px; font-weight: 600; letter-spacing: 1.5px;
        text-transform: uppercase; color: #48484a; margin-bottom: 8px;
    }
    .wrong-letters { display: flex; flex-wrap: wrap; gap: 6px; min-height: 34px; }
    .wletter {
        width: 34px; height: 34px; border-radius: 7px;
        background: rgba(255,69,58,.15); border: 1px solid #ff453a;
        display: flex; align-items: center; justify-content: center;
        font-size: 15px; font-weight: 700; color: #ff453a;
    }

    .letter-form { display: flex; gap: 10px; align-items: center; }
    .letter-input {
        width: 54px; height: 54px;
        background: #2c2c2e; border: 2px solid #3a3a3c; border-radius: 12px;
        color: #fff; font-size: 26px; font-weight: 700;
        text-align: center; text-transform: uppercase; outline: none;
    }
    .letter-input:focus { border-color: #bf5af2; }
    .btn-send {
        height: 54px; padding: 0 22px;
        background: #bf5af2; color: #fff;
        border: none; border-radius: 12px;
        font-size: 16px; font-weight: 600; cursor: pointer;
    }
    .btn-send:active { filter: brightness(1.2); }

    /* ── START SCREEN ── */
    .start-screen {
        padding: 48px 44px 52px;
        display: flex; flex-direction: column;
        gap: 32px;
    }
    .start-header { display: flex; flex-direction: column; gap: 10px; }
    .start-title  { font-size: 34px; font-weight: 800; color: #e5e5e7; letter-spacing: -1px; margin-top: 10px; }
    .start-sub    { font-size: 14px; color: #636366; line-height: 1.5; }

    .chips-section { display: flex; flex-direction: column; gap: 10px; }
    .chips-label   { font-size: 12px; font-weight: 600; letter-spacing: 1.5px; text-transform: uppercase; color: #48484a; }
    .chips-row     { display: flex; flex-wrap: wrap; gap: 8px; }
    .chip {
        padding: 7px 14px;
        background: #2c2c2e;
        border: 1.5px solid #3a3a3c;
        border-radius: 20px;
        color: #aeaeb2;
        font-size: 13px; font-weight: 500;
        cursor: pointer;
        transition: background .1s, border-color .1s, color .1s;
    }
    .chip:hover  { background: #3a3a3c; color: #e5e5e7; }
    .chip.active {
        background: rgba(191,90,242,.15);
        border-color: #bf5af2;
        color: #bf5af2;
        font-weight: 600;
    }

    .custom-row {
        display: flex; gap: 10px; align-items: center; margin-top: 4px;
    }
    .custom-input {
        flex: 1; height: 50px;
        background: #2c2c2e; border: 2px solid #3a3a3c; border-radius: 12px;
        color: #e5e5e7; font-size: 15px; padding: 0 16px; outline: none;
    }
    .custom-input::placeholder { color: #48484a; }
    .custom-input:focus { border-color: #bf5af2; }
    .btn-empezar {
        height: 50px; padding: 0 28px;
        background: #bf5af2; color: #fff;
        border: none; border-radius: 12px;
        font-size: 16px; font-weight: 600; cursor: pointer; white-space: nowrap;
    }
    .btn-empezar:active { filter: brightness(1.15); }

    .error-inline {
        background: rgba(255,69,58,.08);
        border: 1px solid rgba(255,69,58,.3);
        border-radius: 10px; padding: 12px 16px;
        font-size: 13px; color: #ff453a; line-height: 1.5;
    }

    /* ── WIN SCREEN ── */
    .win-screen {
        padding: 60px 40px 52px;
        display: flex; flex-direction: column; align-items: center;
        gap: 28px; text-align: center;
    }
    .win-title  { font-size: 56px; font-weight: 800; color: #30d158; letter-spacing: -2px; }
    .win-sub    { font-size: 15px; color: #636366; }
    .win-sub strong { color: #e5e5e7; }

    /* ── LOSE SCREEN ── */
    .lose-screen {
        padding: 44px 40px 52px;
        display: flex; flex-direction: column; align-items: center;
        gap: 24px; text-align: center;
    }
    .lose-title { font-size: 56px; font-weight: 800; color: #ff453a; letter-spacing: -2px; }
    .lose-word-label { font-size: 13px; color: #636366; letter-spacing: 0.5px; }
    .lose-word-label span {
        display: block; font-size: 20px; font-weight: 700;
        color: #e5e5e7; letter-spacing: 5px; margin-top: 4px;
    }

    .word-reveal { display: flex; flex-wrap: wrap; gap: 7px; justify-content: center; }

    .btn-restart {
        height: 52px; padding: 0 44px;
        background: linear-gradient(135deg, #bf5af2, #5e5ce6);
        color: #fff; border: none; border-radius: 26px;
        font-size: 17px; font-weight: 600; cursor: pointer; letter-spacing: 0.2px;
    }
    .btn-restart:active { filter: brightness(1.15); }
</style>
@endsection

@section('content')
<div class="card">

@if (!isset($palabra))
{{-- ═══════════════ PANTALLA INICIO ═══════════════ --}}
<div class="start-screen">
    <div class="start-header">
        <span class="badge">✦ Gemini AI</span>
        <div class="start-title">Ahorcado con IA</div>
        <p class="start-sub">Gemini generará una palabra sobre el tema que elijas. Tienes 6 intentos para adivinarla.</p>
    </div>

    @if ($error ?? false)
    <div class="error-inline">{{ $error }}</div>
    @endif

    <form action="{{ route('ahorcado-ia.reiniciar') }}" method="POST">
        @csrf
        <div class="chips-section">
            <div class="chips-label">Elige un tema</div>
            <div class="chips-row">
                @foreach (['Cultura general','Animales','Tecnología','Deportes','Cocina','Geografía','Cine y TV','Música','Historia','Naturaleza'] as $t)
                    <button type="button" class="chip" onclick="setTema('{{ $t }}', this)">{{ $t }}</button>
                @endforeach
            </div>
        </div>
        <div class="custom-row">
            <input class="custom-input" type="text" name="tema" id="tema-input"
                   value="{{ $temaError ?? 'Cultura general' }}"
                   placeholder="O escribe tu propio tema..." required>
            <button class="btn-empezar" type="submit">Empezar</button>
        </div>
    </form>
</div>

@elseif ($ganado)
{{-- ═══════════════ PANTALLA VICTORIA ═══════════════ --}}
<div class="win-screen">
    <div class="win-title">¡GANASTE!</div>

    <div class="word-reveal">
        @foreach (str_split($palabra) as $l)
            <div class="lbox correct">{{ $l }}</div>
        @endforeach
    </div>

    <p class="win-sub">
        Adivinaste la palabra con
        <strong>{{ count($letrasErroneas) }} {{ count($letrasErroneas) === 1 ? 'fallo' : 'fallos' }}</strong>.
    </p>

    <form action="{{ route('ahorcado-ia.reiniciar') }}" method="POST">
        @csrf
        <button class="btn-restart" type="submit">Nueva palabra</button>
    </form>
</div>

@elseif ($perdido)
{{-- ═══════════════ PANTALLA DERROTA ═══════════════ --}}
<div class="lose-screen">
    <div class="lose-title">¡PERDISTE!</div>

    <svg class="hangman-svg" viewBox="0 0 200 250" xmlns="http://www.w3.org/2000/svg" style="max-width:170px">
        <line class="st-gallows" x1="5"   y1="240" x2="195" y2="240"/>
        <line class="st-gallows" x1="50"  y1="240" x2="50"  y2="15"/>
        <line class="st-gallows" x1="50"  y1="15"  x2="140" y2="15"/>
        <line class="st-rope"    x1="140" y1="15"  x2="140" y2="42"/>
        <circle class="st-body" cx="140" cy="62" r="20"/>
        <line class="st-body" x1="140" y1="82"  x2="140" y2="148"/>
        <line class="st-body" x1="140" y1="102" x2="112" y2="128"/>
        <line class="st-body" x1="140" y1="102" x2="168" y2="128"/>
        <line class="st-body" x1="140" y1="148" x2="112" y2="190"/>
        <line class="st-body" x1="140" y1="148" x2="168" y2="190"/>
        <line class="st-face" x1="130" y1="55" x2="137" y2="62"/>
        <line class="st-face" x1="137" y1="55" x2="130" y2="62"/>
        <line class="st-face" x1="143" y1="55" x2="150" y2="62"/>
        <line class="st-face" x1="150" y1="55" x2="143" y2="62"/>
        <path class="st-face" d="M 131 73 Q 140 79 149 73"/>
    </svg>

    <div class="word-reveal">
        @foreach (str_split($palabra) as $l)
            <div class="lbox {{ in_array($l, $letrasUsadas) ? 'correct' : 'missed' }}">{{ $l }}</div>
        @endforeach
    </div>

    <p class="lose-word-label">La palabra era: <span>{{ $palabra }}</span></p>

    <form action="{{ route('ahorcado-ia.reiniciar') }}" method="POST">
        @csrf
        <button class="btn-restart" type="submit">Nueva palabra</button>
    </form>
</div>

@else
{{-- ═══════════════ PANTALLA DE JUEGO ═══════════════ --}}
<div class="board">

    <div class="gallows-side">
        <svg class="hangman-svg" viewBox="0 0 200 250" xmlns="http://www.w3.org/2000/svg">
            <line class="st-gallows" x1="5"   y1="240" x2="195" y2="240"/>
            <line class="st-gallows" x1="50"  y1="240" x2="50"  y2="15"/>
            <line class="st-gallows" x1="50"  y1="15"  x2="140" y2="15"/>
            <line class="st-rope"    x1="140" y1="15"  x2="140" y2="42"/>

            @if ($fallos >= 1) <circle class="st-body" cx="140" cy="62" r="20"/> @endif
            @if ($fallos >= 2) <line class="st-body" x1="140" y1="82"  x2="140" y2="148"/> @endif
            @if ($fallos >= 3) <line class="st-body" x1="140" y1="102" x2="112" y2="128"/> @endif
            @if ($fallos >= 4) <line class="st-body" x1="140" y1="102" x2="168" y2="128"/> @endif
            @if ($fallos >= 5) <line class="st-body" x1="140" y1="148" x2="112" y2="190"/> @endif
            @if ($fallos >= 6)
                <line class="st-body" x1="140" y1="148" x2="168" y2="190"/>
            @endif
        </svg>
    </div>

    <div class="play-side">
        <div style="display:flex; flex-direction:column; gap:6px;">
            <span class="badge">✦ Gemini AI</span>
            @if ($tema)
                <span class="tema-tag">Tema: {{ $tema }}</span>
            @endif
        </div>

        @if ($pista)
        <div class="pista-box"><strong>Pista:</strong> {{ $pista }}</div>
        @endif

        <div class="intentos-row">
            <span class="intentos-label">Intentos:</span>
            <span class="intentos-num">{{ $intentos }}</span>
            <span class="intentos-de">/ 6</span>
        </div>

        <div class="word-display">
            @foreach (str_split($palabra) as $l)
                <div class="lbox {{ in_array($l, $letrasUsadas) ? 'revealed' : 'hidden' }}">{{ $l }}</div>
            @endforeach
        </div>

        <div>
            <div class="section-label">Letras falladas</div>
            <div class="wrong-letters">
                @foreach ($letrasErroneas as $l)
                    <div class="wletter">{{ $l }}</div>
                @endforeach
            </div>
        </div>

        <form class="letter-form" action="{{ route('ahorcado-ia.letra') }}" method="POST">
            @csrf
            <input class="letter-input" type="text" name="letra"
                   maxlength="1" placeholder="A" autocomplete="off" autofocus>
            <button class="btn-send" type="submit">Enviar</button>
        </form>
    </div>

</div>
@endif

</div>

<script>
    function setTema(tema, el) {
        document.getElementById('tema-input').value = tema;
        document.querySelectorAll('.chip').forEach(c => c.classList.remove('active'));
        el.classList.add('active');
    }

    document.addEventListener('DOMContentLoaded', () => {
        const input = document.getElementById('tema-input');
        if (!input) return;
        const val = input.value.trim();
        document.querySelectorAll('.chip').forEach(c => {
            if (c.textContent.trim() === val) c.classList.add('active');
        });
        input.addEventListener('input', () => {
            document.querySelectorAll('.chip').forEach(c => {
                c.classList.toggle('active', c.textContent.trim() === input.value.trim());
            });
        });
    });
</script>
@endsection

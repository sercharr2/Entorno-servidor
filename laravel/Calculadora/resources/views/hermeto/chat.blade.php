@extends('layouts.app')

@section('title', 'Hermeto Pascoal — Consultor Emocional')

@section('styles')
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    .app-main {
        align-items: flex-start !important;
        padding: 20px 16px !important;
    }

    /* ── TARJETA ── */
    .chat-card {
        width: 100%;
        max-width: 860px;
        height: calc(100vh - 98px);
        min-height: 520px;
        background: #0d0a06;
        border-radius: 24px;
        box-shadow: 0 0 0 1px rgba(255,255,255,.06), 0 32px 80px rgba(0,0,0,.9);
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }

    /* ── CABECERA ── */
    .chat-header {
        flex-shrink: 0;
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 14px 20px;
        background: #120e08;
        border-bottom: 1px solid rgba(255,255,255,.06);
    }

    .header-avatars { display: flex; gap: -6px; }
    .avatar {
        width: 40px; height: 40px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 13px; font-weight: 800; letter-spacing: -0.5px;
        flex-shrink: 0;
    }
    .avatar-clasico { background: linear-gradient(135deg,#d4890a,#a8610a); color: #0b0804; }
    .avatar-moderno { background: linear-gradient(135deg,#5ac8fa,#2ea8d5); color: #041018; margin-left: -10px; border: 2px solid #0d0a06; }

    .header-info { flex: 1; min-width: 0; }
    .header-name { font-size: 15px; font-weight: 700; color: #ddc99a; }
    .header-sub  {
        font-size: 10px; font-weight: 500; letter-spacing: 1.1px;
        text-transform: uppercase; color: #5a4a2a; margin-top: 2px;
    }

    .btn-nueva {
        height: 28px; padding: 0 14px;
        background: transparent;
        border: 1px solid rgba(255,255,255,.1);
        border-radius: 8px; color: #7a6545;
        font-size: 11px; font-weight: 600; cursor: pointer;
        transition: border-color .1s, color .1s;
    }
    .btn-nueva:hover { border-color: rgba(255,255,255,.2); color: #ddc99a; }

    /* ── CABECERAS DE COLUMNA ── */
    .col-headers {
        flex-shrink: 0;
        display: flex;
        border-bottom: 1px solid rgba(255,255,255,.05);
    }
    .col-header {
        flex: 1;
        display: flex; align-items: center; gap: 8px;
        padding: 8px 16px;
        font-size: 10px; font-weight: 700; letter-spacing: 1.4px;
        text-transform: uppercase;
    }
    .col-header:first-child { border-right: 1px solid rgba(255,255,255,.05); }
    .col-header-dot {
        width: 7px; height: 7px; border-radius: 50%; flex-shrink: 0;
    }
    .col-header.clasico { color: #7a5520; background: #0f0b06; }
    .col-header.clasico .col-header-dot { background: #d4890a; }
    .col-header.moderno { color: #1a4a6a; background: #080d12; }
    .col-header.moderno .col-header-dot { background: #5ac8fa; }

    /* ── ÁREA DE MENSAJES ── */
    .messages-area {
        flex: 1;
        display: flex;
        overflow: hidden;
    }

    .msg-col {
        flex: 1;
        overflow-y: auto;
        padding: 20px 16px;
        display: flex;
        flex-direction: column;
        gap: 12px;
        scroll-behavior: smooth;
    }
    .msg-col:first-child {
        border-right: 1px solid rgba(255,255,255,.04);
        background: #0f0c07;
    }
    .msg-col:last-child { background: #090d12; }

    .msg-col::-webkit-scrollbar { width: 3px; }
    .msg-col::-webkit-scrollbar-track { background: transparent; }
    .msg-col.clasico::-webkit-scrollbar-thumb { background: #3d2e15; border-radius: 4px; }
    .msg-col.moderno::-webkit-scrollbar-thumb { background: #1e3448; border-radius: 4px; }

    /* ── BURBUJAS ── */
    .bubble {
        padding: 10px 14px;
        border-radius: 14px;
        font-size: 13.5px;
        line-height: 1.65;
        white-space: pre-wrap;
        word-break: break-word;
        max-width: 100%;
    }

    .bubble-user-c {
        align-self: flex-end;
        background: #2a1f0e; border: 1px solid #5a3e1b;
        color: #c8a870; border-bottom-right-radius: 4px;
    }
    .bubble-user-m {
        align-self: flex-end;
        background: #112030; border: 1px solid #1e4060;
        color: #88b8d8; border-bottom-right-radius: 4px;
    }
    .bubble-bot-c {
        align-self: flex-start;
        background: #1e1a10; border: 1px solid #3d3020;
        color: #ddc99a; font-family: Georgia, serif;
        border-bottom-left-radius: 4px;
    }
    .bubble-bot-m {
        align-self: flex-start;
        background: #0e1821; border: 1px solid #1e3448;
        color: #b8d8f0; border-bottom-left-radius: 4px;
    }
    .bubble-error {
        background: rgba(255,69,58,.08); border: 1px solid rgba(255,69,58,.25);
        color: #ff6b5e; font-size: 13px;
    }

    /* ── TYPING INDICATOR ── */
    .typing-indicator {
        display: flex; align-items: center; gap: 5px;
        padding: 12px 14px;
    }
    .typing-indicator span {
        display: inline-block; width: 6px; height: 6px;
        border-radius: 50%; opacity: 0.4;
        animation: tbounce 1.4s infinite;
    }
    .msg-col.clasico .typing-indicator span { background: #d4890a; }
    .msg-col.moderno .typing-indicator span { background: #5ac8fa; }
    .typing-indicator span:nth-child(2) { animation-delay: .2s; }
    .typing-indicator span:nth-child(3) { animation-delay: .4s; }
    @keyframes tbounce {
        0%,80%,100% { transform: translateY(0); opacity: .4; }
        40%          { transform: translateY(-5px); opacity: 1; }
    }

    /* ── INPUT ── */
    .chat-input-area {
        flex-shrink: 0;
        display: flex; gap: 10px; align-items: flex-end;
        padding: 12px 18px 16px;
        background: #0a0805;
        border-top: 1px solid rgba(255,255,255,.05);
    }

    .msg-input {
        flex: 1; min-height: 44px; max-height: 110px;
        background: #1a1410; border: 1.5px solid #2e2518;
        border-radius: 12px; color: #ddc99a;
        font-size: 14px; padding: 11px 14px; outline: none;
        resize: none; line-height: 1.5;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        transition: border-color .12s;
    }
    .msg-input::placeholder { color: #4a3a20; }
    .msg-input:focus { border-color: #7a5520; }

    .btn-send {
        height: 44px; padding: 0 20px;
        background: linear-gradient(135deg, #d4890a, #5ac8fa);
        border: none; border-radius: 12px;
        color: #0a0805; font-size: 14px; font-weight: 700;
        cursor: pointer; white-space: nowrap;
        transition: filter .1s; flex-shrink: 0;
    }
    .btn-send:hover   { filter: brightness(1.1); }
    .btn-send:active  { filter: brightness(1.2); }
    .btn-send:disabled { opacity: .35; cursor: default; filter: none; }
</style>
@endsection

@section('content')
<div class="chat-card">

    {{-- CABECERA --}}
    <div class="chat-header">
        <div class="header-avatars">
            <div class="avatar avatar-clasico">72</div>
            <div class="avatar avatar-moderno">M</div>
        </div>
        <div class="header-info">
            <div class="header-name">Hermeto Pascoal</div>
            <div class="header-sub">Consultor dual &middot; Dos perspectivas, un mismo problema</div>
        </div>
        <form action="{{ route('hermeto.limpiar') }}" method="POST">
            @csrf
            <button class="btn-nueva" type="submit">Nueva sesión</button>
        </form>
    </div>

    {{-- CABECERAS DE COLUMNA --}}
    <div class="col-headers">
        <div class="col-header clasico">
            <span class="col-header-dot"></span> Hermeto '72
        </div>
        <div class="col-header moderno">
            <span class="col-header-dot"></span> Contemporáneo
        </div>
    </div>

    {{-- COLUMNAS DE MENSAJES --}}
    <div class="messages-area">

        <div class="msg-col clasico" id="col-clasico">
            @if (empty($historial))
                <div class="bubble bubble-bot-c">Siéntate. No tengo todo el día.

Soy Hermeto Pascoal. Llevo desde el 72 escuchando los problemas de la gente y, le digo, ya no me sorprende nada. ¿Qué le pasa?</div>
            @else
                @foreach ($historial as $msg)
                    @if ($msg['tipo'] === 'user')
                        <div class="bubble bubble-user-c">{{ $msg['texto'] }}</div>
                    @else
                        <div class="bubble bubble-bot-c">{{ $msg['clasico'] }}</div>
                    @endif
                @endforeach
            @endif
        </div>

        <div class="msg-col moderno" id="col-moderno">
            @if (empty($historial))
                <div class="bubble bubble-bot-m">Hola, me alegra que hayas venido. Este es un espacio seguro, sin juicios ni prisas.

Soy Hermeto, y estoy aquí para escucharte. Tómate tu tiempo... ¿qué te gustaría hablar hoy?</div>
            @else
                @foreach ($historial as $msg)
                    @if ($msg['tipo'] === 'user')
                        <div class="bubble bubble-user-m">{{ $msg['texto'] }}</div>
                    @else
                        <div class="bubble bubble-bot-m">{{ $msg['moderno'] }}</div>
                    @endif
                @endforeach
            @endif
        </div>

    </div>

    {{-- INPUT --}}
    <div class="chat-input-area">
        <textarea class="msg-input" id="msg-input"
                  placeholder="Escribe tu mensaje... ambos responderán."
                  rows="1"></textarea>
        <button class="btn-send" id="btn-send">Enviar</button>
    </div>

</div>

<script>
(function () {
    const colC      = document.getElementById('col-clasico');
    const colM      = document.getElementById('col-moderno');
    const input     = document.getElementById('msg-input');
    const btnSend   = document.getElementById('btn-send');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    function scrollCols() {
        colC.scrollTop = colC.scrollHeight;
        colM.scrollTop = colM.scrollHeight;
    }
    scrollCols();

    input.addEventListener('input', () => {
        input.style.height = 'auto';
        input.style.height = Math.min(input.scrollHeight, 110) + 'px';
    });

    input.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); handleSend(); }
    });
    btnSend.addEventListener('click', handleSend);

    function addBubble(col, cls, texto) {
        const d = document.createElement('div');
        d.className = 'bubble ' + cls;
        d.textContent = texto;
        col.appendChild(d);
        return d;
    }

    function addTyping(col) {
        const d = document.createElement('div');
        d.className = 'bubble typing-indicator';
        d.innerHTML = '<span></span><span></span><span></span>';
        col.appendChild(d);
        return d;
    }

    function setLoading(on) {
        btnSend.disabled = on;
        input.disabled   = on;
    }

    async function handleSend() {
        const texto = input.value.trim();
        if (!texto) return;

        input.value = '';
        input.style.height = 'auto';

        addBubble(colC, 'bubble-user-c', texto);
        addBubble(colM, 'bubble-user-m', texto);
        scrollCols();

        setLoading(true);
        const indC = addTyping(colC);
        const indM = addTyping(colM);
        scrollCols();

        try {
            const res  = await fetch('{{ route("hermeto.mensaje") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: new URLSearchParams({ mensaje: texto }),
            });
            const data = await res.json();

            indC.remove();
            indM.remove();

            if (data.error) {
                addBubble(colC, 'bubble-error', 'Error: ' + data.error);
                addBubble(colM, 'bubble-error', 'Error: ' + data.error);
            } else {
                addBubble(colC, 'bubble-bot-c', data.clasico);
                addBubble(colM, 'bubble-bot-m', data.moderno);
            }
        } catch (err) {
            indC.remove();
            indM.remove();
            addBubble(colC, 'bubble-error', 'No pude conectar. Prueba de nuevo.');
            addBubble(colM, 'bubble-error', 'No pude conectar. Prueba de nuevo.');
        }

        setLoading(false);
        scrollCols();
        input.focus();
    }
})();
</script>
@endsection

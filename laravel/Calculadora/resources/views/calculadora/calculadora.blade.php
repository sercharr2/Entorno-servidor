@extends('layouts.app')

@section('title', 'Calculadora')

@section('styles')
<style>
    .calculator {
        background: #1c1c1e;
        width: 340px;
        padding: 20px 16px 24px;
        border-radius: 44px;
        box-shadow:
            0 0 0 1px rgba(255,255,255,0.08),
            0 40px 100px rgba(0,0,0,0.9);
    }

    .result-banner {
        padding: 10px 12px 12px;
        margin-bottom: 4px;
        text-align: right;
    }
    .result-banner .expr {
        color: #636366;
        font-size: 14px;
        min-height: 18px;
    }
    .result-banner .value {
        font-size: 26px;
        font-weight: 600;
        margin-top: 4px;
    }
    .result-banner.ok  .value { color: #30d158; }
    .result-banner.err .value { color: #ff453a; font-size: 17px; }

    .display {
        padding: 4px 14px 20px;
        text-align: right;
    }
    .display .pending {
        color: #636366;
        font-size: 16px;
        min-height: 22px;
    }
    .display .current {
        color: #fff;
        font-size: 64px;
        font-weight: 300;
        letter-spacing: -2px;
        line-height: 1;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .display .current.shrink  { font-size: 44px; }
    .display .current.shrink2 { font-size: 30px; }

    .btn-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 10px;
    }

    button {
        border: none;
        aspect-ratio: 1;
        border-radius: 50%;
        font-size: 22px;
        font-weight: 500;
        cursor: pointer;
        outline: none;
        -webkit-tap-highlight-color: transparent;
        width: 100%;
    }
    button:active { filter: brightness(1.4); }

    .btn-num  { background: #333336; color: #fff; }
    .btn-util { background: #636366; color: #000; font-size: 20px; }
    .btn-op   { background: #ff9f0a; color: #fff; font-size: 26px; }
    .btn-op.lit { background: #fff; color: #ff9f0a; }

    .btn-fn {
        background: #2c2c2e;
        color: #ff9f0a;
        font-size: 15px;
        font-weight: 700;
        border-radius: 50%;
    }
    .btn-fn.lit { background: #fff; color: #ff9f0a; }

    .btn-equals {
        grid-column: span 4;
        aspect-ratio: auto;
        height: 64px;
        border-radius: 32px;
        background: linear-gradient(135deg, #ff9f0a, #ff375f);
        color: #fff;
        font-size: 28px;
    }
</style>
@endsection

@section('content')
<div class="calculator">

    @if($resultado !== null)
    <div class="result-banner {{ $isError ? 'err' : 'ok' }}">
        @if(!$isError && $expresion)
            <div class="expr">{{ $expresion }} =</div>
        @endif
        <div class="value">{{ $resultado }}</div>
    </div>
    @endif

    @php
        $sym = ['+'=>'+', '-'=>'−', '*'=>'×', '/'=>'÷', '^'=>'xʸ', 'nrt'=>'ⁿ√y', 'log'=>'logₙ'];
        $opStr = (string) $op;
        $pendingText = ($n1 !== '' && $opStr !== '') ? $n1 . ' ' . ($sym[$opStr] ?? $opStr) : '';
        $curLen  = strlen($cur);
        $curClass = 'current' . ($curLen > 12 ? ' shrink2' : ($curLen > 8 ? ' shrink' : ''));
        $isAC = ($cur === '0' && $n1 === '');
        $waitN2Bool = (bool) $waitN2;
        $lit = function(string $o) use ($opStr, $waitN2Bool): string {
            return ($opStr === $o && $waitN2Bool) ? ' lit' : '';
        };
    @endphp

    <div class="display">
        <div class="pending">{{ $pendingText }}</div>
        <div class="{{ $curClass }}">{{ $cur }}</div>
    </div>

    <form action="{{ route('calculadora.operacion') }}" method="POST">
        @csrf
        <input type="hidden" name="cur"    value="{{ $cur }}">
        <input type="hidden" name="n1"     value="{{ $n1 }}">
        <input type="hidden" name="op"     value="{{ $op }}">
        <input type="hidden" name="waitN2" value="{{ $waitN2 ? '1' : '0' }}">
        <input type="hidden" name="fresh"  value="{{ $fresh  ? '1' : '0' }}">

        <div class="btn-grid">
            <!-- Row 1 -->
            <button class="btn-util" name="action" value="clear">{{ $isAC ? 'AC' : 'C' }}</button>
            <button class="btn-util" name="action" value="backspace">⌫</button>
            <button class="btn-fn{{ $lit('nrt') }}" name="action" value="op_nrt">ⁿ√y</button>
            <button class="btn-op{{ $lit('^') }}"   name="action" value="op_^">x<sup>y</sup></button>

            <!-- Row 2 -->
            <button class="btn-num" name="action" value="digit_7">7</button>
            <button class="btn-num" name="action" value="digit_8">8</button>
            <button class="btn-num" name="action" value="digit_9">9</button>
            <button class="btn-op{{ $lit('/') }}"   name="action" value="op_/">÷</button>

            <!-- Row 3 -->
            <button class="btn-num" name="action" value="digit_4">4</button>
            <button class="btn-num" name="action" value="digit_5">5</button>
            <button class="btn-num" name="action" value="digit_6">6</button>
            <button class="btn-op{{ $lit('*') }}"   name="action" value="op_*">×</button>

            <!-- Row 4 -->
            <button class="btn-num" name="action" value="digit_1">1</button>
            <button class="btn-num" name="action" value="digit_2">2</button>
            <button class="btn-num" name="action" value="digit_3">3</button>
            <button class="btn-op{{ $lit('-') }}"   name="action" value="op_-">−</button>

            <!-- Row 5 -->
            <button class="btn-fn{{ $lit('log') }}" name="action" value="op_log">logₙ</button>
            <button class="btn-num" name="action" value="digit_0">0</button>
            <button class="btn-num" name="action" value="decimal">.</button>
            <button class="btn-op{{ $lit('+') }}"   name="action" value="op_+">+</button>

            <!-- Row 6 -->
            <button class="btn-equals" name="action" value="equals">=</button>
        </div>
    </form>

</div>
@endsection

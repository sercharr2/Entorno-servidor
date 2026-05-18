@extends('layouts.app')

@section('title', 'Sube-Baja')

@section('styles')
<style>
    .card {
        background: #1c1c1e;
        padding: 48px 40px 40px;
        border-radius: 32px;
        box-shadow:
            0 0 0 1px rgba(255,255,255,0.08),
            0 40px 100px rgba(0,0,0,0.9);
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 32px;
    }

    .counter-row {
        display: flex;
        align-items: center;
        gap: 24px;
    }

    .number-box {
        background: #2c2c2e;
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 20px;
        width: 160px;
        height: 100px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 56px;
        font-weight: 300;
        color: #fff;
        letter-spacing: -2px;
    }
    .number-box.positive { color: #30d158; }
    .number-box.negative { color: #ff453a; }

    button {
        border: none;
        border-radius: 50%;
        width: 64px;
        height: 64px;
        font-size: 32px;
        font-weight: 400;
        cursor: pointer;
        outline: none;
        transition: filter 0.08s;
        line-height: 1;
    }
    button:active { filter: brightness(1.4); }

    .btn-bajar { background: #ff453a; color: #fff; }
    .btn-subir { background: #30d158; color: #fff; }

    .btn-reset {
        background: #636366;
        color: #000;
        width: 140px;
        height: 48px;
        border-radius: 24px;
        font-size: 16px;
        font-weight: 600;
        letter-spacing: 0.3px;
    }
</style>
@endsection

@section('content')
<div class="card">

    <div class="counter-row">
        <form action="{{ route('sube-baja.bajar') }}" method="POST">
            @csrf
            <button class="btn-bajar" type="submit">−</button>
        </form>

        @php $clase = $numero > 0 ? 'positive' : ($numero < 0 ? 'negative' : ''); @endphp
        <div class="number-box {{ $clase }}">{{ $numero }}</div>

        <form action="{{ route('sube-baja.subir') }}" method="POST">
            @csrf
            <button class="btn-subir" type="submit">+</button>
        </form>
    </div>

    <form action="{{ route('sube-baja.reiniciar') }}" method="POST">
        @csrf
        <button class="btn-reset" type="submit">Reiniciar</button>
    </form>

</div>
@endsection

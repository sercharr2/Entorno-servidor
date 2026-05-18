@extends('layouts.master')

@section('content')

    <h1>Añadir película</h1>

    <form action="{{ route('catalog.postCreate') }}" method="POST">
        @csrf

        <label>Título:</label>
        <input type="text" name="title" required>
        <br>

        <label>Año:</label>
        <input type="number" name="year" required>
        <br>

        <label>Director:</label>
        <input type="text" name="director" required>
        <br>

        <label>Poster (URL):</label>
        <input type="url" name="poster">
        <br>

        <label>¿Alquilada?</label>
        <input type="radio" name="rented" value="true"> Alquilada
        <input type="radio" name="rented" value="false" checked> No alquilada
        <br>

        <label>Sinopsis:</label>
        <textarea name="synopsis"></textarea>
        <br>

        <input type="submit" value="Añadir película">
    </form>

@endsection
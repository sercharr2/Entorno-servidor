@extends('layouts.master')

@section('content')

    <h1>Editar película</h1>

    <form action="{{ route('catalog.putEdit', $id) }}" method="POST">
        @csrf
        @method('PUT')

        <label>Título:</label>
        <input type="text" name="title" value="{{ $pelicula->title }}" required>
        <br>

        <label>Año:</label>
        <input type="number" name="year" value="{{ $pelicula->year }}" required>
        <br>

        <label>Director:</label>
        <input type="text" name="director" value="{{ $pelicula->director }}" required>
        <br>

        <label>Poster (URL):</label>
        <input type="url" name="poster" value="{{ $pelicula->poster }}">
        <br>

        <label>¿Alquilada?</label>
        <input type="radio" name="rented" value="true"  {{ $pelicula->rented ? 'checked' : '' }}> Alquilada
        <input type="radio" name="rented" value="false" {{ !$pelicula->rented ? 'checked' : '' }}> No alquilada
        <br>

        <label>Sinopsis:</label>
        <textarea name="synopsis">{{ $pelicula->synopsis }}</textarea>
        <br>

        <input type="submit" value="Guardar cambios">
    </form>

    <a href="{{ route('catalog.show', $id) }}">Cancelar</a>

@endsection
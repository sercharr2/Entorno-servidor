@extends('layouts.master')

@section('content')

    <h2>✅ Película añadida correctamente</h2>
    <p><strong>Título:</strong> {{ $pelicula->title }}</p>
    <p><strong>Año:</strong> {{ $pelicula->year }}</p>
    <p><strong>Director:</strong> {{ $pelicula->director }}</p>
    <p><strong>Sinopsis:</strong> {{ $pelicula->synopsis }}</p>

    <a href="{{ route('catalog.index') }}">Volver al catálogo</a>

@endsection
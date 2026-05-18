@extends('layouts.master')

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>

    <div class="row">
        <div class="col-sm-4">

            <img src="{{$pelicula['poster']}}" class="img-fluid" style="width: 100%; max-width: 300px;" />

        </div>
        <div class="col-sm-8">

            <h1 style="min-height:45px;margin:5px 0 10px 0">
                {{$pelicula['title']}}
            </h1>

            <p>
                Año: {{$pelicula['year']}}
            </p>

            <p>
                Director: {{$pelicula['director']}}
            </p>

            <p>
                Sinopsis: {{$pelicula['synopsis']}}
            </p>

            @if ($pelicula['rented']){

                <h1>Película actualmente alquilada</h1>

                <a class="btn btn-default" style="background-color: red;" href="{{ url('') }}">Devolver película </a>

            }@else

                <h1>Película disponible</h1>

                <a class="btn btn-default" style="background-color: blue; color: white;" href="{{ url('') }}"> Alquilar
                    película </a>

            @endif

            <br>
            <br>

            <a class="btn btn-default" href="{{ url('/catalog/edit/' . $id) }}" style="margin-right: 10px">Editar
                película</a>

            <a class="btn btn-default" href="{{ url('/') }}">Volver al listado de películas</a>

        </div>
    </div>
</body>

</html>
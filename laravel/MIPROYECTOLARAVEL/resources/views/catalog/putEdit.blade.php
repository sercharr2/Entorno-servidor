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
    @extends('layouts.master')

    @section('content')

    <h2>Pelicula cambiada</h2>
    <p>Titulo: {{$_REQUEST["title"]}}</p>
    <p>año: {{$_REQUEST["year"]}}</p>
    <p>director: {{$_REQUEST["director"]}}</p>
    <p>poster:</p>
        <img src="{{$_REQUEST["poster"]}}" style="height:300px"/>
    <br>
    <br>
    <p>alquilada: {{$_REQUEST["alquilada"]}}</p>
    <p>sinopsis: {{$_REQUEST["synopsis"]}}</p>

    @endsection

</body>
</html>
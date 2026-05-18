<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

</head>
<body>

    <a style="visibility: hidden">{{$n1 = $_POST["n1"]}}</a>
    <a style="visibility: hidden">{{$n2 = $_POST["n2"]}}</a>

    @if (isset($_POST["sum"]))

        <h1>Suma</h1>

        <p>Numero 1 = {{ $n1 }}</p>
        <p>Numero 2 = {{ $n2 }}</p>
        
        <h3>{{ $n1 }} + {{ $n2 }} = {{ $n1 + $n2 }} </h3>

    @elseif(isset($_POST["rest"]))

        <h1>Resta</h1>

        <p>Numero 1 = {{ $n1 }}</p>
        <p>Numero 2 = {{ $n2 }}</p>
        
        <h3>{{ $n1 }} - {{ $n2 }} = {{ $n1 - $n2 }} </h3>

    @elseif(isset($_POST["mult"]))

        <h1>Multiplicacion</h1>

        <p>Numero 1 = {{ $n1 }}</p>
        <p>Numero 2 = {{ $n2 }}</p>
        
        <h3>{{ $n1 }} * {{ $n2 }} = {{ $n1 * $n2 }} </h3>

    @elseif(isset($_POST["div"]))

        @if ($n2 == 0)

            <h1>Error: no se puede dividir entre cero</h1>
        
        @else

        <h1>Division</h1>

        <p>Numero 1 = {{ $n1 }}</p>
        <p>Numero 2 = {{ $n2 }}</p>
        
        <h3>{{ $n1 }} / {{ $n2 }} = {{ $n1 / $n2 }} </h3>
        
        @endif

    @elseif(isset($_POST["elev"]))

        <h1>Potencia</h1>

        <p>Numero 1 = {{ $n1 }}</p>
        <p>Numero 2 = {{ $n2 }}</p>
        
        <h3>{{ $n1 }} ^ {{ $n2 }} = {{ pow($n1,$n2) }} </h3>

    @elseif(isset($_POST["raiz"]))

        @if ($n2 < 0 )

            <h1>Error: no existen raices reales de numeros negativos</h1>
        
        @else

            <h1>Raiz</h1>

            <p>Numero 1 = {{ $n1 }}</p>
            <p>Numero 2 = {{ $n2 }}</p>
            
            <h3>{{ $n1 }} √ {{ $n2 }} = {{ pow($n2,(1/$n1)) }} </h3>
        
        @endif

    @elseif(isset($_POST["log"]))

        <h1>Potencia</h1>

        <p>Numero 1 = {{ $n1 }}</p>
        <p>Numero 2 = {{ $n2 }}</p>
        
        <h3>{{ $n1 }} log( {{ $n2 }} ) = {{ log($n2,$n1) }} </h3>

    @else

        <h1>Error: algo a salido mal :<</h1>
    
    @endif

        <a class="btn btn-primary" href="{{ url('/calculadora/calculadora') }}">Volver a la calculadora</a>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    
</body>
</html>
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

    <h1>Calculadora</h1>

    <form action="{{ url('/calculadora/calculadora/operacion') }}" method="POST">

        {{ csrf_field() }}

        <label>numero 1:</label>
            <input type="number" name="n1" step="0.0001" required>

        <br>

        <label>numero 2:</label>
            <input type="number" name="n2" step="0.0001" required>
           
        <br>
        <br>

        <input class="btn btn-primary"  type="submit" value="+" name="sum">
        <input class="btn btn-primary"  type="submit" value="-" name="rest">
        <input class="btn btn-primary"  type="submit" value="*" name="mult">
        <input class="btn btn-primary"  type="submit" value="/" name="div">
        <br>
        <br>
        <input class="btn btn-primary"  type="submit" value="^" name="elev">
        <input class="btn btn-primary"  type="submit" value="√" name="raiz">
        <input class="btn btn-primary"  type="submit" value="log()" name="log">

    
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</body>
</html>
<?php

    session_start();
    $colores = $_SESSION['color'];
    $circulos = $_SESSION['circulo'];
    $cantidadCirculo = $_SESSION['cantidadCirculo'];
    $cantidadColor = $_SESSION['cantidadColor'];

    $respuesta = [];

    for ($i = 0; $i < $cantidadCirculo; $i++) {

        $respuesta[$i] = 0;

    }


    $_SESSION['respuesta'] = $respuesta;

    $j = 0;
    $_SESSION['bucle'] = $j;

    echo <<<_END
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Simón</h1>
        <h2> pulsa los botones del color correcto en el orden correspondiente:</h2> 
_END;

    echo "<div style='display:flex; gap:10px; align-items:center; flex-wrap: wrap;'>";

    for ($i = 0; $i < $cantidadCirculo; $i++) {
        echo $circulos[0];

    }


    echo "</div>";

    echo <<<_END
    <br>
    <form method="post" action="simon3.3.php">
    _END;

    $botones = [];
    $colorR = $_SESSION["colorR"];


    for ($i = 0; $i <$cantidadColor; $i++) {
    
        $botones[$i] = "<input type='submit' value = '".$colorR[$i]."' name = '".$colorR[$i]."' style='background-color:". $colorR[$i].";'>";

    }    

    for ($i = 0; $i < count($botones); $i++) {

        echo"$botones[$i]";

    }
    $_SESSION["botones"] = $botones;

    echo<<<_END
    </form>

_END;



?>
<?php

function rand_color() {
    return '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
}

$colores = [];
$circulos = [

    "<div style='width: 100px; height: 100px; background-color: black; border-radius: 50%;'></div>"

];
session_start();
$_SESSION['cantidadCirculo'] = $_POST['cantidadCirculo'];
$_SESSION['cantidadColor'] = $_POST['cantidadColor'];
$color=[];

for ($i = 0; $i <$_POST['cantidadColor']; $i++) {

    $colorR = rand_color();

    
    if($circulos[$i]==("<div style='width: 100px; height: 100px;border-radius: 50%; background-color: ".$colorR ."'></div>")){

        $i--;

    }else{
    
    $color[$i] = $colorR;
    array_push($circulos, ("<div style='width: 100px; height: 100px;border-radius: 50%; background-color: ".$colorR ."'></div>"));

    }
}

$_SESSION['circulo'] = $circulos;
$_SESSION['colorR'] = $color;

for ($i = 0; $i < $_POST['cantidadCirculo']; $i++) {

    $colores[$i] = rand(1, $_POST['cantidadColor']);

}

$_SESSION['color'] = $colores;

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
        <h2> memoriza la combinacion de colores:</h2>
_END;

// Mostrar los círculos seleccionados en una fila
echo "<div style='display:flex; gap:10px; align-items:center; flex-wrap: wrap;'>";

for ($i = 0; $i < $_POST['cantidadCirculo']; $i++) {
    // $colores contiene valores 1..cantidadColor (porque $circulos[0] es el negro inicial)
    $idx = $colores[$i];
    if (isset($circulos[$idx])) {
        echo $circulos[$idx];
        // para depuración: muestra índices como comentario HTML
        echo "<!-- $i | $idx -->";
    }
}

echo "</div>";

echo <<<_END
    <br>
    <form method="post" action="simon3.2.php">

        <input type="submit" value = "jugar">
    </form>

_END;


?>
<?php

$colores = [];
$circulos = [

    "<div style='width: 100px; height: 100px; background-color: red; border-radius: 50%;'></div>",
    "<div style='width: 100px; height: 100px; background-color: blue; border-radius: 50%;'></div>",
    "<div style='width: 100px; height: 100px; background-color: yellow; border-radius: 50%;'></div>",
    "<div style='width: 100px; height: 100px; background-color: green; border-radius: 50%;'></div>",
    "<div style='width: 100px; height: 100px; background-color: black; border-radius: 50%;'></div>"

];
session_start();
$_SESSION['circulo'] = $circulos;
$_SESSION['cantidad'] = $_POST['cantidad'];

for ($i = 0; $i < $_POST['cantidad']; $i++) {

    $colores[$i] = rand(0, 3);

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

echo "<div style='display:flex; gap:10px; align-items:center; flex-wrap: wrap;'>";

for ($i = 0; $i < $_POST['cantidad']; $i++) {

    if ($colores[$i] == 0) {

        echo $circulos[0];

    } else if ($colores[$i] == 1) {

        echo $circulos[1];

    } else if ($colores[$i] == 2) {

        echo $circulos[2];

    } else if ($colores[$i] == 3) {

        echo $circulos[3];

    }
}

echo "</div>";

echo <<<_END
    <br>
    <form method="post" action="simon2.2.php">

        <input type="submit" value = "jugar">
    </form>

_END;


?>
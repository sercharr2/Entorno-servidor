<?php

    

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
        <h2> Dificultad:</h2>
        <p>Selecciona un numero de circulos y colores para adivinar</p>
    <br>
    <form method="post" action="simon3.php">
        <label>Numero de circulos: </label>
        <input type="number" name="cantidadCirculo" required min="1">
        <br><br>
        <label>Numero de colores: </label>
        <input type="number" name="cantidadColor" required min="1">
        <br><br>
        <input type="submit" value = "jugar">

    </form>

_END;

?>


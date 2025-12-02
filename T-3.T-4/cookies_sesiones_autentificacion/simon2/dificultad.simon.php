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
        <p>Selecciona un numero de colores para adivinar</p>
    <br>
    <form method="post" action="simon2.php">

        <input type="number" name="cantidad" required min="1">
        <input type="submit" value = "jugar">

    </form>

_END;

?>


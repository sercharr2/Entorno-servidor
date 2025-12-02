<?php

    session_start();
    $nombre = $_SESSION['nombre'];
    $jugador1 = $_POST['jugador1'];
    $jugador2 = $_POST['jugador2'];
    $jugador3 = $_POST['jugador3'];


       echo <<<_END
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
  <h1>Buenos dias $nombre</h1>
  <p>Los jugadores que has escogido son: $jugador1, $jugador2 y $jugador3</p>
</body>
</html>
_END;

?>
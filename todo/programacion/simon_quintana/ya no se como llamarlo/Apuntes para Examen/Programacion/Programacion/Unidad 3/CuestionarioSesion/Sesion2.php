<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Sesión 3</title>
</head>
<body>
  <h2>Sesión 3: Resultados</h2>
  <p>Tu nombre: <?= $_SESSION["nombre_usuario"] ?></p>
  <p>Jugadores:</p>
  <ul>
    <li><?= $_SESSION["nombre1"] ?></li>
    <li><?= $_SESSION["nombre2"] ?></li>
    <li><?= $_SESSION["nombre3"] ?></li>
  </ul>
</body>
</html>

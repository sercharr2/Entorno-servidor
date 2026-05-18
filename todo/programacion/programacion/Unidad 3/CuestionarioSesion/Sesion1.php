<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $_SESSION["nombre_usuario"] = $_POST["nombre"];
    header("Location: Sesion2.php");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Sesión 1</title>
</head>
<body>
  <h2>Sesión 1: Tu nombre</h2>
  <form method="post" action="Sesion1.php">
    <label>Tu nombre:</label>
    <input type="text" name="nombre" required><br><br>
    <input type="submit" value="Jugar">
  </form>
</body>
</html>

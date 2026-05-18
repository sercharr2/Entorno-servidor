<?php
// Sesion3.php
session_start();

// Opción para reiniciar la sesión (limpiar y volver a Sesion1)
if (isset($_GET['reset']) && $_GET['reset'] === '1') {
    session_unset();
    session_destroy();
    header("Location: Sesion1.php");
    exit;
}

// Validaciones mínimas
if (!isset($_SESSION["nombre_usuario"])) {
    header("Location: Sesion1.php");
    exit;
}
if (!isset($_SESSION["nombre1"], $_SESSION["nombre2"], $_SESSION["nombre3"])) {
    header("Location: Sesion2.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Sesión 3</title>
</head>
<body>
  <h2>Sesión 3: Resultados</h2>

  <p><strong>Tu nombre:</strong> <?= htmlspecialchars($_SESSION["nombre_usuario"], ENT_QUOTES, 'UTF-8') ?></p>

  <p><strong>Jugadores:</strong></p>
  <ul>
    <li><?= htmlspecialchars($_SESSION["nombre1"], ENT_QUOTES, 'UTF-8') ?></li>
    <li><?= htmlspecialchars($_SESSION["nombre2"], ENT_QUOTES, 'UTF-8') ?></li>
    <li><?= htmlspecialchars($_SESSION["nombre3"], ENT_QUOTES, 'UTF-8') ?></li>
  </ul>

  <p>
    <a href="Sesion3.php?reset=1">Reiniciar</a>
  </p>
</body>
</html>

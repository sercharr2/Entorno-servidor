<?php
session_start();

$numeroSesion = $_SESSION['numero'];
$respuesta    = $_POST['respuesta'];

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultado</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; }
        h2   { font-size: 1.8em; }
        a    { display: block; margin-top: 10px; font-size: 0.9em; }
    </style>
</head>
<body>

<?php if ($respuesta == $numeroSesion): ?>
    <h2>Respuesta acertada el número es, <?= $numeroSesion ?></h2>
<?php else: ?>
    <h2>Has fallado, vuelve a jugar</h2>
<?php endif; ?>

    <a href="ejercicio2.php">VOLVER A JUGAR</a>

</body>
</html>

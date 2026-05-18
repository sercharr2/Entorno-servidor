<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['nombre'] = htmlspecialchars($_POST['nombre'] ?? '','UTF-8');
    $_SESSION['apellido'] = htmlspecialchars($_POST['apellido'] ?? '','UTF-8');
}
?>

<html>
<head>
    <title>VAMOS A JUGAR AL SIMÓN!!!</title>
</head>
<body>
    <h2>Introduce tus datos personales</h2>
    <form method="post" action="">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required><br><br>

        <label for="apellido">Clave:</label>
        <input type="text" id="apellido" name="apellido" required><br><br>

        <a href="juego.php">Entrar</a>
    </form>
</body>
</html>
<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Primer formulario (tu nombre)
    if (isset($_POST["nombre"])) {
        $_SESSION["nombre_usuario"] = htmlspecialchars($_POST["nombre"]);
        $mostrarSegundo = true;
    }

    // Segundo formulario (3 nombres)
    if (isset($_POST["nombre1"])) {
        $_SESSION["nombre1"] = htmlspecialchars($_POST["nombre1"]);
        $_SESSION["nombre2"] = htmlspecialchars($_POST["nombre2"]);
        $_SESSION["nombre3"] = htmlspecialchars($_POST["nombre3"]);
        $mostrarResultado = true;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario con Sesion</title>
</head>
<body>

<?php if (!isset($mostrarSegundo) && !isset($mostrarResultado)) : ?>

    <form method="post">
        <label for="nombre">Tu nombre:</label>
        <input type="text" id="nombre" name="nombre" required><br><br>
        <input type="submit" value="Jugar">
    </form>

<?php elseif (isset($mostrarSegundo)) : ?>

    <form method="post">
        <h3>Introduce 3 nombres de jugadores:</h3>
        <label>Nombre 1:</label>
        <input type="text" name="nombre1" required><br><br>
        <label>Nombre 2:</label>
        <input type="text" name="nombre2" required><br><br>
        <label>Nombre 3:</label>
        <input type="text" name="nombre3" required><br><br>
        <input type="submit" value="Guardar">
    </form>

<?php elseif (isset($mostrarResultado)) : ?>
  
    <h3>Resultados:</h3>
    <p>Tu nombre: <?= $_SESSION["nombre_usuario"] ?></p>
    <p>Jugadores: </p>
   
    <li><?=$_SESSION["nombre1"] ?></li>
    <li><?=$_SESSION["nombre2"] ?></li>
    <li><?=$_SESSION["nombre3"] ?></li>
    
<?php endif; ?>

</body>
</html>

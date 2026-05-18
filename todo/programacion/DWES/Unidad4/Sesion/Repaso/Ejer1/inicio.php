<?php
    session_start();

    if(isset($_POST["boton"])){
        $_SESSION["nombre"] = $_POST["nombre"] ?? '';
        $_SESSION["passwd"] = $_POST["passwd"] ?? '';
        
        header("Location: confirmacion.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
</head>
<body>
    <form action="inicio.php" method="POST">
        <label for="nombre">Ingrese su nombre: </label>
        <input type="text" id="nombre" name="nombre"><br>

        <label for="passwd">Ingrese su contraseña: </label>
        <input type="password" id="passwd" name="passwd"><br>

        <input type="submit" name="boton" value="Ingresar">
    </form>
</body>
</html>
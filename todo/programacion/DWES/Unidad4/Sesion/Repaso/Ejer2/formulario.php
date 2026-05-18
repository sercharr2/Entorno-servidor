<?php
    session_start(); 
    if(isset($_POST["boton"])){
        $_SESSION["nombre"] = $_POST["nombre"] ?? '';
        header("Location: producto.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario</title>
</head>
<body>
    <h1>Bienvenido a la Tienda</h1>
    <form action="formulario.php" method="post">
            <label for="nombre">Ingrese su nombre: </label>
            <input type="text" id="nombre" name="nombre">

            <input type="submit" name="boton" value="Ingresar">
    </form>
</body>
</html>
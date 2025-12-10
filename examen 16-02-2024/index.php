<?php

if (isset($_POST["usuario"]) && $_POST["contrasenia"]) {

    session_start();
    $_SESSION['usuario'] = htmlspecialchars($_POST['usuario'], ENT_QUOTES);
    $_SESSION['contrasenia'] = htmlspecialchars($_POST['contrasenia'],ENT_QUOTES);
    $login;
    $clave;
    $inicioConfirmado = false;

    $conn = new mysqli('localhost:3307', 'jugador', '', 'jeroglifico');
    if ($conn->connect_error)
        die("Fatal Error");


    $query = "SELECT login,clave,nombre FROM jugador";
    $result = $conn->query($query);
    if (!$result)
        die("Fatal Error");

    if ($result->num_rows > 0) {
        // usar while para iterar cada fila y evitar avanzar el puntero varias veces
        while ($row = $result->fetch_assoc()) {

            $login1 = $row['login'];
            $clave1 = $row['clave'];

            if ($login1 == $_SESSION['usuario'] && $clave1 == $_SESSION['contrasenia']) {

                $inicioConfirmado = true;
                $login = $row['login'];
                $clave = $row['clave'];
                $_SESSION["nombre"] = $row["nombre"];

            }

        }
    }

    if ($inicioConfirmado) {

        header("Location: inicio.php");
        exit();

    } else {

        echo <<<_END
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio sesion</title>
</head>
<body>
        <h1> Inicio de sesión:</h1>
        <p>llena los campos usuario y contraseña correctas para continuar</p>
    <br>
        <p style="color:red;">*usuario o contraseña erroneo</p>
    <form method="post" action="index.php">

        <lavel>Usuario</lavel>
        <input type="text" name="usuario" required>
        <br><br>
        
        <lavel>Contraseña</lavel>
        <input type="password" name="contrasenia" required>
        <br><br>

        <input type="submit" value = "jugar">

    </form>
_END;


    }

} else {

    echo <<<_END
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio sesion</title>
</head>
<body>
        <h1> Inicio de sesión:</h1>
        <p>llena los campos usuario y contraseña correctas para continuar</p>
    <br>
    <form method="post" action="index.php">

        <lavel>Usuario</lavel>
        <input type="text" name="usuario" required>
        <br><br>
        
        <lavel>Contraseña</lavel>
        <input type="password" name="contrasenia" required>
        <br><br>

        <input type="submit" value = "jugar">

    </form>

_END;

}
?>
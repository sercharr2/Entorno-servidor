<?php

if (isset($_POST["usuario"]) && $_POST["contrasenia"]) {

    session_start();
    $_SESSION['usuario'] = $_POST['usuario'];
    $_SESSION['contrasenia'] = $_POST['contrasenia'];
    $inicioConfirmado = false;

    $conn = new mysqli('localhost', 'root', '', 'AGENDA');
    if ($conn->connect_error)
        die("Fatal Error");


    $query = "SELECT * FROM usuarios";
    $result = $conn->query($query);
    if (!$result)
        die("Fatal Error");

    if ($result->num_rows > 0) {
        // usar while para iterar cada fila y evitar avanzar el puntero varias veces
        while ($row = $result->fetch_assoc()) {

            $nombre1 = $row['Nombre'];
            $clave1 = $row['Clave'];

            if ($nombre1 == $_SESSION['usuario'] && $clave1 == $_SESSION['contrasenia']) {

                $inicioConfirmado = true;

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
    <title>Inicio de sesion de la agenda</title>
    <style>
    
        div{ border: 1px solid black;}

    </style>
</head>
<body>
    <h1> Agenda de contactos:</h1>
    <br>
    <form method="post" action="index.php">

        <div>
            <lavel>Usuario</lavel>
            <input type="text" name="usuario" required>
        
            <lavel>Contraseña</lavel>
            <input type="password" name="contrasenia" required>

            <input type="submit" value = "entrar">
        </div>

    </form>
    <p style:'color: red'>*usuario o contraseña incorrectos</p>

_END;

    }

} else {

    echo <<<_END
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de sesion de la agenda</title>
    <style>
    
        div{ border: 1px solid black;}

    </style>
</head>
<body>
    <h1> Agenda de contactos:</h1>
    <br>
    <form method="post" action="index.php">

        <div>
            <lavel>Usuario</lavel>
            <input type="text" name="usuario" required>
        
            <lavel>Contraseña</lavel>
            <input type="password" name="contrasenia" required>

            <input type="submit" value = "entrar">
        </div>

    </form>
_END;

}
?>
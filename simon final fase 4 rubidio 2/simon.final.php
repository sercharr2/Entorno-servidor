<?php

if (isset($_POST["usuario"]) && $_POST["contrasenia"]) {

    session_start();
    $_SESSION['usuario'] = $_POST['usuario'];
    $_SESSION['contrasenia'] = $_POST['contrasenia'];
    $nombre;
    $clave;
    $codigo;
    $inicioConfirmado = false;

    $conn = new mysqli('localhost', 'root', '', 'bdsimon2');
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
                $codigo = $row['Codigo'];
                $nombre = $row['Nombre'];
                $clave = $row['Clave'];

            }

        }
    }

    if ($inicioConfirmado) {

          echo <<<_END
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Simón</h1>
        <h2> Dificultad:</h2>
        <p>Selecciona un numero de circulos y colores para adivinar</p>
    <br>
    <form method="post" action="simon.final.2.php">
        <label>Numero de circulos: </label>
        <input type="number" name="cantidadCirculo" required min="1">
        <br><br>
        <label>Numero de colores: </label>
        <input type="number" name="cantidadColor" required min="1">
        <br><br>
        <input type="submit" value = "jugar">

    </form>

_END;

    } else {

        echo "usuario o contraseña incorrectos";
        echo <<<_END
    <br>
    <form method="get" action="simon.final.php" style="margin-top:16px;">
    <button type="submit">Volver a jugar</button>
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
    <title>Inicio sesion Simon</title>
</head>
<body>
    <h1>Simón</h1>
        <h2> Inicio de sesión:</h2>
        <p>llena los campos usuario y contraseña correctas para continuar</p>
    <br>
    <form method="post" action="simon.final.php">

        <lavel>Usuario</lavel>
        <input type="text" name="usuario" required>
        <br><br>
        
        <lavel>Contraseña</lavel>
        <input type="password" name="contrasenia" required>
        <br><br>

        <input type="submit" value = "jugar">

    </form>

    <br>
    <form method="get" action="simon.registro.php" style="margin-top:16px;">
    <button type="submit">Registro</button>
    </form>

_END;

}
?>
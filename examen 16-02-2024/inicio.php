<?php

if (isset($_POST["enviar"])) {

    session_start();
    $login = $_SESSION["usuario"];
    $nombre = $_SESSION["nombre"];
    $fecha = date("Y-m-d");
    $hora = date("H:i:s");
    $respuesta = $_POST["solucion"];
    $_SESSION["respuesta"] = $respuesta;
    $error = '';
    $acierto='';
    $repdiaria = true;

    $conn = new mysqli('localhost:3307', 'jugador', '', 'jeroglifico');
    if ($conn->connect_error)
        die("Fatal Error");

    $query3 = "SELECT fecha,login FROM respuestas";
    $result3 = $conn->query($query3);
    if (!$result3)
        die("Fatal Error");


    if ($result3->num_rows > 0) {
        // usar while para iterar cada fila y evitar avanzar el puntero varias veces
        while ($row3 = $result3->fetch_assoc()) {

            $login1 = $row3['login'];
            $fecha1 = $row3['fecha'];

            if ($login1 == $login && $fecha1 == $fecha) {

                $repdiaria = false;

            }

        }
    }

    if ($repdiaria) {

        $stmt = $conn->prepare("INSERT INTO respuestas (fecha, login, hora, respuesta) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $fecha, $login, $hora, $respuesta);
        if (!$stmt->execute()) {
            die("Fallo en INSERT");
        }
        $stmt->close();

    } else {

        $error = "<p style='color: red;'>*Hoy $nombre ya introdujo una respuesta</p>";

    }

    echo <<<_END
        <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <style>
        
            img{
            
            width:500px;

            }

        </style>
    </head>
    <body>
    
        <h2>Bienvenido, $nombre</h2>

        <img src="./materiales/20240216.jpg">

        <br>

        <form method="post" action="inicio.php">

            <lavel>Solucion al jeroglifico</lavel>
            <input type="text" name="solucion">
            <br>

            <input type="submit" name="enviar" value = "enviar">

        </form>
        $acierto
        $error

        <form method="post" action="puntos.php">

            <input type="submit" name="puntos" value = "ver puntos por jugador">

        </form>

        <form method="post" action="resultado.php">

            <input type="submit" name="resultado" value = "resultados del dia">

        </form>

    </body>
    </html>
    _END;

} else {

    session_start();
    $nombre = $_SESSION["nombre"];

    echo <<<_END
        <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <style>
        
            img{
            
            width:500px;

            }

        </style>
    </head>
    <body>
    
        <h2>Bienvenido, $nombre</h2>

        <img src="./materiales/20240216.jpg">

        <br>

        <form method="post" action="inicio.php">

            <lavel>Solucion al jeroglifico</lavel>
            <input type="text" name="solucion">
            <br>

            <input type="submit" name="enviar" value = "enviar">

        </form>
        <br><br>

        <form method="post" action="puntos.php">

            <input type="submit" name="puntos" value = "ver puntos por jugador">

        </form>

        <form method="post" action="resultado.php">

            <input type="submit" name="resultado" value = "resultados del dia">

        </form>

    </body>
    </html>
    _END;
}

?>
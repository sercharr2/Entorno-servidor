<?php

     session_start();
    $login = $_SESSION["usuario"];
    $nombre = $_SESSION["nombre"];
    $fecha = date("Y-m-d");
    $hora = date("H:i:s");
    $respuesta = $_SESSION["respuesta"];
    $solucion = "Que sonada";


    $conn = new mysqli('localhost:3307', 'jugador', '', 'jeroglifico');
    if ($conn->connect_error)
        die("Fatal Error");

    $query = "SELECT login,hora FROM respuestas WHERE fecha = $fecha AND respuesta = (SELECT solucion FROM solucion WHERE fecha = $fecha)";
    $result = $conn->query($query);
    if (!$result)
        die("Fatal Error");

    $query2 = "SELECT COUNT(login) FROM respuestas WHERE fecha = $fecha AND respuesta = (SELECT solucion FROM solucion WHERE fecha = $fecha)";
    $result2 = $conn->query($query2);
    if (!$result2)
        die("Fatal Error");
    $row = $result2->fetch_assoc();
    $njugadores = $row['COUNT(login)'];

    $query3 = "SELECT login,hora FROM respuestas WHERE fecha = $fecha AND respuesta != (SELECT solucion FROM solucion WHERE fecha = $fecha)";
    $result3 = $conn->query($query3);
    if (!$result3)
        die("Fatal Error");

    echo <<<_END
        <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    </head>
    <body>
    
        <h2>Fecha: $fecha</h2>
        <h3>jugadores acertantes: $njugadores<h3>
        <table>
        <tr>
            <th>Login</th>
            <th>Hora</th>
        </tr>
    _END;

    if ($result3->num_rows > 0) {
        // usar while para iterar cada fila y evitar avanzar el puntero varias veces
        while ($row3 = $result3->fetch_assoc()) {

           $login =  $row3['login'];
            $hora = $row3['hora'];

            echo<<<_END

                <tr>
                    <th>$login</th>
                    <th>$hora</th>
                </tr>
                
            _END;

        }
    }


echo<<<_END
    </table>

    <h3>jugadores que fallaron:<h3>
        <table>
        <tr>
            <th>Login</th>
            <th>Hora</th>
        </tr>
    _END;

    if ($result->num_rows > 0) {
        // usar while para iterar cada fila y evitar avanzar el puntero varias veces
        while ($row = $result->fetch_assoc()) {

           $login =  $row['login'];
            $hora = $row['hora'];

            echo<<<_END

                <tr>
                    <th>$login</th>
                    <th>$hora</th>
                </tr>
                
            _END;

        }
    }


echo<<<_END
    </body>
    </html>
    _END;

?>
<?php

session_start();
$login = $_SESSION["usuario"];
$nombre = $_SESSION["nombre"];
$fecha = date("Y-m-d");

$conn = new mysqli('localhost:3307', 'jugador', '', 'jeroglifico');
if ($conn->connect_error)
    die("Fatal Error");

// === EJERCICIO 3e: Sumar 1 punto a cada jugador acertante ===
$queryUpdate = "UPDATE jugador SET puntos = puntos + 1 
                WHERE login IN (
                    SELECT login FROM respuestas 
                    WHERE fecha = '$fecha' 
                    AND respuesta = (SELECT solucion FROM solucion WHERE fecha = '$fecha')
                )";
$conn->query($queryUpdate);

// Jugadores que han ACERTADO
$queryAciertos = "SELECT login, hora FROM respuestas 
                  WHERE fecha = '$fecha' 
                  AND respuesta = (SELECT solucion FROM solucion WHERE fecha = '$fecha')";
$resultAciertos = $conn->query($queryAciertos);
if (!$resultAciertos)
    die("Fatal Error");

// Contar jugadores acertantes
$queryConteo = "SELECT COUNT(login) AS total FROM respuestas 
                WHERE fecha = '$fecha' 
                AND respuesta = (SELECT solucion FROM solucion WHERE fecha = '$fecha')";
$resultConteo = $conn->query($queryConteo);
if (!$resultConteo)
    die("Fatal Error");
$rowConteo = $resultConteo->fetch_assoc();
$njugadores = $rowConteo['total'];

// Jugadores que han FALLADO
$queryFallos = "SELECT login, hora FROM respuestas 
                WHERE fecha = '$fecha' 
                AND respuesta != (SELECT solucion FROM solucion WHERE fecha = '$fecha')";
$resultFallos = $conn->query($queryFallos);
if (!$resultFallos)
    die("Fatal Error");

echo <<<_END
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados del día</title>
</head>
<body>

    <h2>Fecha: $fecha</h2>

    <h3>Jugadores acertantes: $njugadores</h3>
    <table border="1">
        <tr>
            <th>Login</th>
            <th>Hora</th>
        </tr>
_END;

if ($resultAciertos->num_rows > 0) {
    while ($row = $resultAciertos->fetch_assoc()) {
        $loginJ = $row['login'];
        $horaJ  = $row['hora'];
        echo "<tr><td>$loginJ</td><td>$horaJ</td></tr>\n";
    }
}

echo <<<_END
    </table>

    <h3>Jugadores que han fallado:</h3>
    <table border="1">
        <tr>
            <th>Login</th>
            <th>Hora</th>
        </tr>
_END;

if ($resultFallos->num_rows > 0) {
    while ($row = $resultFallos->fetch_assoc()) {
        $loginJ = $row['login'];
        $horaJ  = $row['hora'];
        echo "<tr><td>$loginJ</td><td>$horaJ</td></tr>\n";
    }
}

echo <<<_END
    </table>

</body>
</html>
_END;

$conn->close();
?>

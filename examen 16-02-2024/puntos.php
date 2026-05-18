<?php

session_start();
$nombre = $_SESSION["nombre"];

$conn = new mysqli('localhost:3307', 'jugador', '', 'jeroglifico');
if ($conn->connect_error)
    die("Fatal Error");

// Obtener todos los jugadores ordenados por login
$query = "SELECT login, puntos FROM jugador ORDER BY login ASC";
$result = $conn->query($query);
if (!$result)
    die("Fatal Error");

// Obtener el máximo de puntos para calcular el ancho de las barras
$queryMax = "SELECT MAX(puntos) AS maximo FROM jugador";
$resultMax = $conn->query($queryMax);
$rowMax = $resultMax->fetch_assoc();
$maxPuntos = $rowMax['maximo'];
if ($maxPuntos == 0) $maxPuntos = 1; // evitar división por cero

$conn->close();

echo <<<_END
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Puntos por jugador</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            font-size: 1.6em;
        }
        table {
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #999;
            padding: 4px 10px;
            text-align: left;
        }
        th {
            background-color: #eee;
        }
        .barra-contenedor {
            width: 150px;
            background-color: #f0f0f0;
        }
        .barra {
            height: 16px;
            background-color: #4a90d9;
        }
    </style>
</head>
<body>

    <h1>Puntos por jugador</h1>

    <table>
        <tr>
            <th>Login</th>
            <th>Puntos</th>
            <th></th>
        </tr>
_END;

// Volver a ejecutar la consulta para iterar los resultados
$conn2 = new mysqli('localhost:3307', 'jugador', '', 'jeroglifico');
$result2 = $conn2->query("SELECT login, puntos FROM jugador ORDER BY login ASC");

if ($result2->num_rows > 0) {
    while ($row = $result2->fetch_assoc()) {
        $loginJ  = htmlspecialchars($row['login']);
        $puntosJ = $row['puntos'];
        // Calcular el ancho de la barra como porcentaje respecto al máximo
        $anchoPct = ($maxPuntos > 0) ? round(($puntosJ / $maxPuntos) * 100) : 0;

        echo "        <tr>\n";
        echo "            <td>$loginJ</td>\n";
        echo "            <td>$puntosJ</td>\n";
        echo "            <td class=\"barra-contenedor\">";
        echo "<div class=\"barra\" style=\"width:{$anchoPct}%;\"></div>";
        echo "</td>\n";
        echo "        </tr>\n";
    }
}

$conn2->close();

echo <<<_END
    </table>

</body>
</html>
_END;
?>

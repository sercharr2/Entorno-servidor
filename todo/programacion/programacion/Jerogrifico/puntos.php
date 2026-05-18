<?php
session_start();
$hn = 'localhost';
$db = 'jerogrifico';
$un = 'jugador';
$pw = '';
$connection = new mysqli($hn, $un, $pw, $db);

if (!isset($_SESSION['login'])) {
    header("Location: index.php");
    exit();
}

$query = "SELECT login, puntos FROM jugador";
$result = $connection->query($query);

if (!$result) die("Error al obtener los datos");
echo <<<_END
<html>
    <head>
        <style>
            .barra {
                background-color: #87CEEB; 
                height: 15px;
            }
        </style>
    </head>
    <body>
        <h1>Puntos por jugador</h1>
        <table border="1" style="border-collapse: collapse; width: 60%;">
            <tr>
                <th>Login</th>
                <th colspan="2">Puntos</th> </tr>
_END;

$rows = $result->num_rows;
for ($j = 0 ; $j < $rows ; ++$j) {
    $result->data_seek($j);
    $row=$result->fetch_assoc();
    $login = htmlspecialchars($row['login']);
    $puntos = htmlspecialchars($row['puntos']);


$ancho = $puntos * 3; 

    echo "<tr>";
    echo "<td>$login</td>";
    echo "<td style='width:50px;'>$puntos</td>"; // Columna del número
    
    echo "<td>";
    if ($puntos > 0) {
        echo "<div class='barra' style='width: {$ancho}px;'></div>";
    }
    echo "</td>";
    echo "</tr>";
}

$result->close();

echo <<<_END
        </table>
    </body>
</html>
_END;








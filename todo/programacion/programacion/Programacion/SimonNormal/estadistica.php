<?php
session_start();

$hn = 'localhost';
$db = 'bdsimon';
$un = 'root';
$pw = '';

    $connection = new mysqli($hn, $un, $pw, $db);
    if ($connection->connect_error) die("Fatal Error");
    $query = "
    SELECT u.Codigo, u.Nombre, COUNT(j.acierto) AS NumeroAciertos
    FROM usuarios u
    LEFT JOIN jugadas j ON u.Codigo = j.codigousu AND j.acierto = 1
    GROUP BY u.Codigo, u.Nombre
    ORDER BY u.Codigo
";
$result = $connection->query($query);
echo <<<_END
<html>
    <body>
        <h1>SIMÓN</h1>
            <h2>Estadistica</h2>
_END;
echo <<<_END
   <table border=1 >
        <tr>
            <th>Código usuario</th>
            <th>Nombre</th>
            <th>Número aciertos</th>
        </tr>
_END;
            $rows = $result->num_rows;
            for ($j = 0 ; $j < $rows ; ++$j) {
                $result->data_seek($j);
                $row = $result->fetch_assoc();

                    echo "<tr>";
                    echo '<td>' . htmlspecialchars($row['Codigo']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['Nombre']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['NumeroAciertos']) . '</td>';
                    echo "</tr>";
}

                
        
        $result->close();
    echo<<<_END
    </table>
    <a href="inicio.php">VOLVER AL INICIO</a>
</body>
</html>
_END;
    
    $connection->close();

?>
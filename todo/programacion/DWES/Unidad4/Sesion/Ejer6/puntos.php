<?php
    session_start();
    
    // Datos de conexión
    $hn = 'localhost';
    $db = 'jeroglifico';
    $un = 'jugador';
    $pw = '';

    $conn = new mysqli($hn, $un, $pw, $db);
    if ($conn->connect_error) die("Error de conexión: " . $conn->connect_error);

    // Sumar Punto 
    $sql = "UPDATE jugador j
            JOIN respuestas r ON j.login = r.login
            JOIN solucion s ON r.fecha = s.fecha
            SET j.puntos = j.puntos + 1
            WHERE r.fecha = CURDATE()
                AND r.respuesta = s.solucion;
            ";
    $punto = $conn->query($sql);

    // Login Puntos
    $sqlLoginPuntos = "SELECT j.nombre, j.puntos
            FROM jugador j
            ORDER BY j.puntos DESC;
            ";
    $sql = $conn->query($sqlLoginPuntos);

    $nombre = [];
    $puntos = [];

    if($sql->num_rows > 0){
        while ($row = $sql->fetch_assoc()){
            $nombre[] = $row['nombre'];
            $puntos[] = $row['puntos'];
            $data[] = $row;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Puntos</title>
</head>
<body>
    <h1>Puntos Por Jugador</h1>
    <table border="1">
        <tr>
            <th>Login</th>
            <th>Puntos</th>
        </tr>
        <?php foreach ($data as $row): ?>
        <tr>
            <td><?= $row['nombre'] ?></td>
            <td><?= $row['puntos'] ?></td>
            <td>
                <?php 
                    $max = 200;
                    $porcentaje = ($row['puntos'] / $max) * 100;
                ?>
                <div style="width:300px; border:1px solid #555;">
                    <div style="
                        width: <?php echo $porcentaje; ?>%;
                        height: 30px;
                        background: #72c5eb;">
                    </div>
                </div>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
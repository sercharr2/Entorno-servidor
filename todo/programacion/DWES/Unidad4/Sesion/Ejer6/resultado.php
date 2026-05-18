<?php 
    session_start();
    $usuario = $_SESSION["usuario"]; 

    // Datos de conexión
    $hn = 'localhost';
    $db = 'jeroglifico';
    $un = 'jugador';
    $pw = '';

    $conn = new mysqli($hn, $un, $pw, $db);
    if ($conn->connect_error) die("Error de conexión: " . $conn->connect_error);
    
    // Jugadores Acertantes NUMERO
    $sqlNumAciertos = "SELECT COUNT(*) AS acertantes
            FROM respuestas r
            JOIN solucion s ON r.fecha = s.fecha
            WHERE r.fecha = CURDATE()
                AND r.respuesta = s.solucion;
            ";
    $acertantes = $conn->query($sqlNumAciertos);
    $filaAciertos = $acertantes->fetch_assoc();
    $num_acertantes = $filaAciertos['acertantes'] ?? 0;

    // Jugadores Acertantes NOMBRE & HORA
    $sqlNombreAcertantes = "SELECT j.nombre, r.hora
            FROM respuestas r
            JOIN jugador j ON r.login = j.login
            JOIN solucion s ON r.fecha = s.fecha
            WHERE r.fecha = CURDATE()
                AND r.respuesta = s.solucion
            ORDER BY r.hora;
            ";
    $nombreAciertos = $conn->query($sqlNombreAcertantes);

    $nombre = [];
    $hora = [];

    if($nombreAciertos->num_rows > 0){
        while ($row = $nombreAciertos->fetch_assoc()){
            $nombre[] = $row['nombre'];
            $hora[] = $row['hora'];
            $data[] = $row;
        }
    }

    // Jugadores Fallan NOMBRE & HORA
    $sqlNombreFallo = "SELECT j.nombre, r.hora
            FROM respuestas r
            JOIN jugador j ON r.login = j.login
            JOIN solucion s ON r.fecha = s.fecha
            WHERE r.fecha = CURDATE()
                AND r.respuesta <> s.solucion
            ORDER BY r.hora;";
    $fallos = $conn->query($sqlNombreFallo);

    $nombre = [];
    $hora = [];

    if($fallos->num_rows > 0){
        while ($row2 = $fallos->fetch_assoc()){
            $nombre[] = $row2['nombre'];
            $hora[] = $row2['hora'];
            $data2[] = $row2;
        }
    }

    if(isset($_POST["puntos"])){
        header("Location: puntos.php");
        exit;
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado</title>
</head>
<body>
    <h1>Fecha <?php echo date("d-m-Y"); ?></h1>
    <h3>Numero De Jugadores Acertantes: <?php echo $num_acertantes; ?> </h3>

    <table border="1">
        <tr>
            <th>Login</th>
            <th>Fecha</th>
        </tr>
        <?php foreach ($data as $row): ?>
        <tr>
            <td><?= $row['nombre'] ?></td>
            <td><?= $row['hora'] ?></td>
        </tr>
        <?php endforeach; ?>
    </table>

    <h3>Jugadores Que Han Fallado</h3>
    <table border="1">
        <tr>
            <th>Login</th>
            <th>Fecha</th>
        </tr>
        <?php foreach ($data2 as $row2): ?>
        <tr>
            <td><?= $row2['nombre'] ?></td>
            <td><?= $row2['hora'] ?></td>
        </tr>
        <?php endforeach; ?>
    </table>

    <form action="resultado.php" method="post">
        <br><br><input type="submit" name="puntos" value="Ver puntos por jugador">
    </form>
</body>
</html>
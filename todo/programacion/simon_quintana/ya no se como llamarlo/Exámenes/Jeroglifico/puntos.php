<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

require_once 'login.php';
$conn = new mysqli($hn, $un, $pw, $db);
if ($conn->connect_error) die("Fatal Error");


$sacarPuntos = "SELECT login, puntos FROM jugador ORDER BY puntos DESC";

$result = $conn->query($sacarPuntos);
if (!$result) die("Fatal Error");

if($result->num_rows == 0){
    echo "<p>No hay jugadores registrados.</p>";
    exit();
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
        table { border-collapse: collapse; width: 80%; margin: 20px auto; }
        th, td { border: 1px solid black; padding: 10px; text-align: center; }
        th { background-color: #f2f2f2; }
        .barra-grafica { background-color: blue; height: 20px; }
    </style>
<body>
    <h1>Puntos por jugador</h1>
    <table>
        <tr>
            <th>Login</th>
            <th>Puntos</th>
            <th>Gráfica</th>
        </tr>
        <?php while ($fila = $result->fetch_assoc()): ?>
                <?php $ancho = $fila['puntos'] * 5; ?>
                <tr>
                    <td><?php echo $fila['login']; ?></td>
                    <td><?php echo $fila['puntos']; ?></td>
                    <td style="text-align: left;">
                        <div class="barra-grafica" style="width: <?php echo $ancho; ?>px;"></div>
                    </td>
                </tr>
                <?php endwhile; ?>
    </table>
</body>
</html>
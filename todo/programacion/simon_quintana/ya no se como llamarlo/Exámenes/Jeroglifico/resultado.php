<?php
session_start();

// Opcional: Configura tu zona horaria para que la hora sea correcta
// Si estás en España: 'Europe/Madrid'
// Si estás en Argentina: 'America/Argentina/Buenos_Aires', etc.
date_default_timezone_set('Europe/Madrid'); 

if(!isset($_SESSION['usuario'])){
    header("Location: index.php");
    exit();
} 

require_once 'login.php';
$hoy=date ("Y-m-d");

$conn = new mysqli($hn, $un, $pw, $db);
if ($conn->connect_error) die("Fatal Error");

$consultaSolucion=$conn-> query ("SELECT solucion FROM solucion WHERE fecha='$hoy'");
if ($consultaSolucion->num_rows==0){
    echo "<p>No hay solución registrada para hoy ($hoy). </p>";
    exit ();
}

$aciertos= $conn->query ("SELECT login, hora FROM respuestas r
INNER JOIN solucion s ON r.fecha=s.fecha
WHERE r.respuesta=s.solucion AND r.fecha='$hoy'");

$fallos= $conn->query ("SELECT login, hora FROM respuestas r
INNER JOIN solucion s ON r.fecha=s.fecha
WHERE r.respuesta!=s.solucion AND r.fecha='$hoy'");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>FECHA: <?php echo $hoy; ?></h1>
    <h2>Jugadores acertantes: <?php echo $aciertos->num_rows  ?></h2> <br>
    <table border='1'>
        <tr>
            <th>Login</th>
            <th>Hora</th>
        </tr>
        <?php
        while ($row = $aciertos->fetch_assoc()) {
            echo "<tr><td>".$row['login']."</td><td>".$row['hora']."</td></tr>";
        } echo "</table>";
        ?>
        <h2>Jugadores que han fallado: <?php echo  $fallos->num_rows  ?></h2> <br>
    <table border='1'>
        <tr>
            <th>Login</th>
            <th>Hora</th>
        </tr>
        <?php
        while ($row = $fallos->fetch_assoc()) {
            echo "<tr><td>".$row['login']."</td><td>".$row['hora']."</td></tr>";
        } echo "</table>";
        ?>
</body>
</html>
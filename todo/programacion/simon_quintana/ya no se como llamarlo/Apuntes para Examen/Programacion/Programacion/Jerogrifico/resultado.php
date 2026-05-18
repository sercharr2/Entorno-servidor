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
$hoy=date ("Y-m-d");

$consultaSolucion=$connection-> query ("SELECT solucion FROM solucion WHERE fecha='$hoy'");
if ($consultaSolucion->num_rows==0){
    echo "<p>No hay solución registrada para hoy ($hoy). </p>";
    exit ();
}

//sumar puntos
$sumaPuntos=$connection-> query ("UPDATE jugador j SET puntos = puntos + 1 where login in 
( SELECT login FROM respuestas r, solucion where respuesta = solucion AND r.fecha = $hoy);");


//resultados
$aciertos= $connection->query ("SELECT login, hora FROM respuestas r
INNER JOIN solucion s ON r.fecha=s.fecha
WHERE r.respuesta=s.solucion AND r.fecha='$hoy'");

$fallos= $connection->query ("SELECT login, hora FROM respuestas r
INNER JOIN solucion s ON r.fecha=s.fecha
WHERE r.respuesta!=s.solucion AND r.fecha='$hoy'");




echo "<html><body>";
echo "<h1>Fecha: $hoy</h1>";

echo "<h2>Jugadores acertantes: ".$aciertos->num_rows."</h2>";
echo "<table border='1'>";
echo "<tr><th>Login</th><th>Hora</th></tr>";

while ($row = $aciertos->fetch_assoc()) {
    echo "<tr><td>".$row['login']."</td><td>".$row['hora']."</td></tr>";
}

echo "</table>";

echo "<h2>Jugadores que han fallado: ".$fallos->num_rows."</h2>";
echo "<table border='1'>";
echo "<tr><th>Login</th><th>Hora</th></tr>";

while ($row = $fallos->fetch_assoc()) {
    echo "<tr><td>".$row['login']."</td><td>".$row['hora']."</td></tr>";
}
echo "</table>";

echo "</body></html>";

?>
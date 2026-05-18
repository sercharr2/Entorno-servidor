<?php
session_start();
include("conexion.php");

$query = "SELECT login, 
                 SUM(resultado=1) AS aciertos, 
                 SUM(resultado=0) AS fallos,
                 puntos
          FROM jugador
          GROUP BY login";
$result = $connection->query($query);

echo "<h1>Ranking de jugadores</h1>";
echo "<table border=1>";
echo "<tr><th>Usuario</th><th>Aciertos</th><th>Fallos</th><th>Puntos</th></tr>";
while ($fila = $result->fetch_assoc()) {
    echo "<tr><td>".$fila['login']."</td><td>".$fila['aciertos']."</td><td>".$fila['fallos']."</td><td>".$fila['puntos']."</td></tr>";
}
echo "</table>";
?>

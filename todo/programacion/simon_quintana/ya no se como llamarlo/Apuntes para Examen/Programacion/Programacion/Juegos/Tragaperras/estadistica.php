<?php
session_start();
include("conexion.php");

// Consulta para ver victorias y partidas de cada jugador
$query = "SELECT login, SUM(resultado) AS victorias, COUNT(*) AS partidas 
          FROM partidas GROUP BY login";
$result = $connection->query($query);

// Pintamos tabla con resultados
echo "<h1>Ranking de jugadores</h1>";
echo "<table border=1>";
echo "<tr><th>Usuario</th><th>Victorias</th><th>Partidas</th></tr>";
while ($fila = $result->fetch_assoc()) {
    echo "<tr><td>".$fila['login']."</td><td>".$fila['victorias']."</td><td>".$fila['partidas']."</td></tr>";
}
echo "</table>";

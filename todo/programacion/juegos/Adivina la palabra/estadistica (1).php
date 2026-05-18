<?php
session_start();
$hn = 'localhost';
$db = 'jerogrifico';
$un = 'jugador';
$pw = '';

$connection = new mysqli($hn, $un, $pw, $db);
 if ($connection->connect_error) die("Fatal Error");

 $error='';
 
//login,puntos aciertos fallols y jugadas de cada jufador

$query = "SELECT jugador.login, jugador.puntos,
                 SUM(partidas.resultado=1) AS aciertos,
                 SUM(partidas.resultado=0) AS fallos,
                 COUNT(partidas.id) AS jugadas
          FROM jugador
          LEFT JOIN partidas ON jugador.login = partidas.login
          GROUP BY jugador.login";
$result = $connection->query($query);

echo "<h1>Ranking de jugadores</h1>";
echo "<table border=1>";
echo "<tr><th>Usuario</th><th>Puntos</th><th>Aciertos</th><th>Fallos</th><th>Jugadas</th></tr>";
while ($fila = $result->fetch_assoc()) {
    echo "<tr><td>".$fila['login']."</td><td>".$fila['puntos']."</td><td>".$fila['aciertos']."</td><td>".$fila['fallos']."</td><td>".$fila['jugadas']."</td></tr>";
}
echo "</table>";
?>

<?php
session_start();
$hn = 'localhost';
$db = 'memoria';   // nombre de la BD
$un = 'jugador';   // usuario de la BD
$pw = '';          // contraseña
if ($connection->connect_error) die("Fatal Error");
$error = '';

// Consulta para ver victorias, derrotas y puntos
$query = "SELECT login, SUM(resultado=1) AS victorias, 
                 SUM(resultado=0) AS derrotas,
                 SUM(resultado=2) AS empates,
                 puntos
          FROM jugador
          GROUP BY login";
$result = $connection->query($query);

echo "<h1>Ranking de jugadores</h1>";
echo "<table border=1>";
echo "<tr><th>Usuario</th><th>Victorias</th><th>Derrotas</th><th>Empates</th><th>Puntos</th></tr>";
while ($fila = $result->fetch_assoc()) {
    echo "<tr><td>".$fila['login']."</td><td>".$fila['victorias']."</td><td>".$fila['derrotas']."</td><td>".$fila['empates']."</td><td>".$fila['puntos']."</td></tr>";
}
echo "</table>";

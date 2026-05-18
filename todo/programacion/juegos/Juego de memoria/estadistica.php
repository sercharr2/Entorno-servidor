<?php
session_start();
$hn = 'localhost';
$db = 'memoria';   // nombre de la BD
$un = 'jugador';   // usuario de la BD
$pw = '';          // contraseña

if ($connection->connect_error) die("Fatal Error");
$error = '';

$query = "SELECT login, SUM(resultado) AS aciertos, COUNT(*) AS intentos 
          FROM partidas GROUP BY login";
$result = $connection->query($query);

echo "<table border=1>";
echo "<tr><th>Usuario</th><th>Parejas encontradas</th><th>Intentos</th></tr>";
while ($fila = $result->fetch_assoc()) {
    echo "<tr><td>".$fila['login']."</td><td>".$fila['aciertos']."</td><td>".$fila['intentos']."</td></tr>";
}
echo "</table>";

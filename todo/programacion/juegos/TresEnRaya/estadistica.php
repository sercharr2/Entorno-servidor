<?php
session_start();

$hn = 'localhost';
$db = 'tresenraya';   // nombre de la BD (ajústalo al examen)
$un = 'jugador';      // usuario de la BD
$pw = '';             // contraseña
if ($connection->connect_error) die("Fatal Error");

$error = '';
// Si no hay usuario en sesión, vuelve al login
if (!isset($_SESSION['login'])) {
    header("Location: index.php");
    exit();
}
// Consulta para ver victorias y partidas de cada jugador
$query = "SELECT login, SUM(resultado) AS victorias, COUNT(*) AS partidas 
          FROM partidas GROUP BY login";
$result = $connection->query($query);

// Pintamos tabla con resultados
echo "<table border=1>";
echo "<tr><th>Usuario</th><th>Victorias</th><th>Partidas</th></tr>";
while ($fila = $result->fetch_assoc()) {
    echo "<tr><td>".$fila['login']."</td><td>".$fila['victorias']."</td><td>".$fila['partidas']."</td></tr>";
}
echo "</table>";

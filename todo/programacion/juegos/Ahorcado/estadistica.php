<?php
session_start();

// Datos de conexión a la base de datos
$hn = 'localhost';   // servidor
$db = 'ahorcado';    // nombre de la base de datos (ajústalo al examen)
$un = 'jugador';     // usuario de la BD
$pw = '';            // contraseña del usuario

// Si falla la conexión, se muestra error y se corta el programa
if ($connection->connect_error) die("Fatal Error");

$error = ''; //variable para mostrar mensahes de error

// Consulta para ver aciertos y partidas de cada jugador
$query = "SELECT login, SUM(acierto) AS aciertos, COUNT(*) AS partidas 
          FROM partidas GROUP BY login";
$result = $connection->query($query);

// Pintar tabla con resultados
echo "<table border=1>";
echo "<tr><th>Usuario</th><th>Aciertos</th><th>Partidas</th></tr>";
while ($fila = $result->fetch_assoc()) {
    echo "<tr><td>".$fila['login']."</td><td>".$fila['aciertos']."</td><td>".$fila['partidas']."</td></tr>";
}
echo "</table>";

<?php
session_start();
$hn = 'localhost';
$db = 'memoria';   // nombre de la BD
$un = 'jugador';   // usuario de la BD
$pw = '';          // contraseña

if ($connection->connect_error) die("Fatal Error");
$error = '';

$login = $_SESSION['login'];
echo "¡Enhorabuena $login, has encontrado una pareja!";

// Guardar resultado en BD
$query = "INSERT INTO partidas (login, resultado, fecha) 
          VALUES ('$login', 1, CURDATE())";
$connection->query($query);

// Reiniciar levantadas
$_SESSION['levantadas'] = [];
?>
<a href="inicio.php">Seguir jugando</a>
<a href="estadistica.php">Ver estadísticas</a>

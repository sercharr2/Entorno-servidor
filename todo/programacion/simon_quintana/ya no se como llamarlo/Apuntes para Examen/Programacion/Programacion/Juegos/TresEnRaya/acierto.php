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

$login = $_SESSION['login'];

echo "¡Enhorabuena $login, has ganado!";

// Guardamos resultado en BD (1 = victoria)
$query = "INSERT INTO partidas (login, resultado, fecha) 
          VALUES ('$login', 1, CURDATE())";
$connection->query($query);

// Reiniciamos tablero para nueva partida
unset($_SESSION['tablero']);
?>
<a href="inicio.php">Volver a jugar</a>
<a href="estadistica.php">Ver estadísticas</a>

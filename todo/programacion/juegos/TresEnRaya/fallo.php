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
};

$login = $_SESSION['login'];

echo "Lo sentimos $login, has perdido o empatado.";

// Guardamos resultado en BD (0 = derrota/empate)
$query = "INSERT INTO partidas (login, resultado, fecha) 
          VALUES ('$login', 0, CURDATE())";
$connection->query($query);

// Reiniciamos tablero
unset($_SESSION['tablero']);
?>
<a href="inicio.php">Volver a jugar</a>
<a href="estadistica.php">Ver estadísticas</a>

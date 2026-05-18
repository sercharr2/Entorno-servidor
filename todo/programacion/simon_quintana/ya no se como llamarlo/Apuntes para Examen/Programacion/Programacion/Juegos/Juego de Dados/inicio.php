<?php
session_start();
$hn = 'localhost';
$db = 'memoria';   // nombre de la BD
$un = 'jugador';   // usuario de la BD
$pw = '';          // contraseña
if ($connection->connect_error) die("Fatal Error");
$error = '';
if (!isset($_SESSION['login'])) {
    header("Location: index.php");
    exit();
}

echo "Bienvenido ".$_SESSION['login']."<br>";
echo "<form action='jugar.php' method='post'>";
echo "<button type='submit' name='tirar' value='1'>Lanzar dados 🎲</button>";
echo "</form>";
?>
<a href="estadistica.php">Ver estadísticas</a>
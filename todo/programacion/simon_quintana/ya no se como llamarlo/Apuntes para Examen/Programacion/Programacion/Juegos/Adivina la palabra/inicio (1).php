<?php
session_start();
$hn = 'localhost';
$db = 'jerogrifico';
$un = 'jugador';
$pw = '';

$connection = new mysqli($hn, $un, $pw, $db);
 if ($connection->connect_error) die("Fatal Error");

 $error='';
if (!isset($_SESSION['login'])) {
    header("Location: index.php");
    exit();
}

// Seleccionar palabra aleatoria de la tabla palabras
$query = "SELECT palabra FROM palabras ORDER BY RAND() LIMIT 1";
$result = $connection->query($query);
$fila = $result->fetch_assoc();
$_SESSION['palabra'] = $fila['palabra'];
$_SESSION['intentos'] = 6; // número de intentos permitidos
$_SESSION['progreso'] = str_repeat("_", strlen($_SESSION['palabra']));

echo "Bienvenido ".$_SESSION['login']."<br>";
echo "<h2>Palabra oculta: ".$_SESSION['progreso']."</h2>";
?>
<a href="jugar.php">Jugar</a>

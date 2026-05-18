
<?php
// inicio.php

session_start();

$hn = 'localhost';
$db = 'tresenraya';   // nombre de la BD (ajústalo al examen)
$un = 'jugador';      // usuario de la BD
$pw = '';             // contraseña
if ($connection->connect_error) die("Fatal Error");

$error = '';

if (!isset($_SESSION['login'])) header("Location: index.php");

echo "Bienvenido, ".$_SESSION['login']."<br>";
echo "Turno: ".$_SESSION['turno']."<br>";

// Pintamos el tablero como un formulario con botones
echo "<form action='jugar.php' method='post'>";
for ($i=0; $i<9; $i++) {
    $valor = $_SESSION['tablero'][$i];   // Valor actual de la casilla ("" o X/O)
    echo "<button type='submit' name='casilla' value='$i' style='width:50px;height:50px;'>$valor</button>";
    if (($i+1)%3==0) echo "<br>";        // Salto de línea cada 3 casillas
}
echo "</form>";
?>
<a href="estadistica.php">Ver estadísticas</a>
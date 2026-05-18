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

$login = $_SESSION['login'];
$palabra = $_SESSION['palabra'];

echo "Lo sentimos $login, has fallado. La palabra era $palabra.";
// Guardar resultado en la BD
$query = "INSERT INTO partidas (login, palabra, acierto, fecha) 
          VALUES ('$login', '$palabra', 0, CURDATE())";
$connection->query($query);
?>
<a href="inicio.php">Volver a jugar</a>
<a href="estadistica.php">Ver estadísticas</a>

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

$login = $_SESSION['login'];

// Tirada de dados con rand()
$dadoJugador = rand(1,6);
$dadoMaquina = rand(1,6);

// Mostrar resultados
echo "<h1>Tirada de dados</h1>";
echo "<p>Jugador ($login): $dadoJugador</p>";
echo "<p>Máquina: $dadoMaquina</p>";

$puntosGanados = 0; // variable para sumar/restar puntos

// Comparación con if/else clásico
if ($dadoJugador > $dadoMaquina) {
    echo "<p>¡Has ganado! +1 punto</p>";
    $puntosGanados = 1;
    $query = "INSERT INTO partidas (login, resultado, fecha) VALUES ('$login', 1, CURDATE())";
    $connection->query($query);

} elseif ($dadoJugador < $dadoMaquina) {
    echo "<p>Has perdido. −1 punto</p>";
    $puntosGanados = -1;
    $query = "INSERT INTO partidas (login, resultado, fecha) VALUES ('$login', 0, CURDATE())";
    $connection->query($query);

} else {
    echo "<p>Empate. 0 puntos</p>";
    $puntosGanados = 0;
    $query = "INSERT INTO partidas (login, resultado, fecha) VALUES ('$login', 2, CURDATE())";
    $connection->query($query);
}

// Actualizar puntos del jugador
$update = "UPDATE jugador SET puntos = puntos + $puntosGanados WHERE login='$login'";
$connection->query($update);
?>
<a href="inicio.php">Volver a jugar</a>
<a href="estadistica.php">Ver estadísticas</a>

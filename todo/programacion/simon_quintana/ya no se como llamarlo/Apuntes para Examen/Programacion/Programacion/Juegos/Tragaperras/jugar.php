<?php
session_start();
$hn = 'localhost';
$db = 'tragaperras';   // nombre de la BD
$un = 'jugador';       // usuario de la BD
$pw = '';              // contraseña
if ($connection->connect_error) die("Error de conexión");
$error = '';

if (!isset($_SESSION['login'])) {
    header("Location: index.php");
    exit();
}

// Array de imágenes disponibles (colócalas en una carpeta del proyecto)
$simbolos = ["cereza.png","limon.png","campana.png","estrella.png","diamante.png"];

// Generar tres tiradas aleatorios usando rand()
$r1 = $simbolos[rand(0, count($simbolos)-1)];  //se usa -1 porque el array tiene 5 elementos pero va del 0-4, si saliera de numero random el 5, daria error
$r2 = $simbolos[rand(0, count($simbolos)-1)];
$r3 = $simbolos[rand(0, count($simbolos)-1)];

// Mostrar resultado en pantalla
echo "<h1>Resultado:</h1>";
echo "<img src='$r1' width='80'> <img src='$r2' width='80'> <img src='$r3' width='80'>";

$login = $_SESSION['login'];
$puntosGanados = 0;   // variable para calcular puntos

// Lógica extendida
if ($r1 == $r2 && $r2 == $r3) {
    // Tres iguales → premio distinto según símbolo
    switch ($r1) {
        case "diamante.png":
            echo "<p>¡Jackpot! Tres diamantes, +10 puntos</p>";
            $puntosGanados = 10;
            break;
        case "estrella.png":
            echo "<p>¡Tres estrellas! +5 puntos</p>";
            $puntosGanados = 5;
            break;
        default:
            echo "<p>¡Tres iguales! +3 puntos</p>";
            $puntosGanados = 3;
    }
    $resultado = 1;

} elseif ($r1 == $r2 || $r1 == $r3 || $r2 == $r3) {
    // Dos iguales → premio según símbolo repetido
    $simboloRepetido = ($r1 == $r2 || $r1 == $r3) ? $r1 : $r2;
    if ($simboloRepetido == "diamante.png") {
        echo "<p>¡Dos diamantes! +4 puntos</p>";
        $puntosGanados = 4;
    } else {
        echo "<p>¡Dos iguales! +2 puntos</p>";
        $puntosGanados = 2;
    }
    $resultado = 1;

} elseif ($r1 != $r2 && $r2 != $r3 && $r1 != $r3) {
    // Tres distintos → premio de consolación
    echo "<p>Tres distintos, premio de consolación: +1 punto</p>";
    $puntosGanados = 1;
    $resultado = 1;

} else {
    // Ninguna combinación
    echo "<p>Lo sentimos, no hay premio. -1 punto</p>";
    $puntosGanados = -1;
    $resultado = 0;
}

// Guardar partida
$query = "INSERT INTO partidas (login, resultado, fecha) VALUES ('$login', $resultado, CURDATE())";
$connection->query($query);

// Actualizar puntos
$update = "UPDATE jugador SET puntos = puntos + $puntosGanados WHERE login='$login'";
$connection->query($update);

?>
<a href="inicio.php">Volver a jugar</a>
<a href="estadistica.php">Ver estadísticas</a>
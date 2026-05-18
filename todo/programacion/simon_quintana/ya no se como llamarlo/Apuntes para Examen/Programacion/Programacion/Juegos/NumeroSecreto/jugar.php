<?php

session_start();
$hn = 'localhost';
$db = 'bdoposicion'; 
$un = 'root';
$pw = '';
$connection = new mysqli($hn, $un, $pw, $db);

if ($connection->connect_error) die("Fatal Error");

$mensaje = ""; 

$login = $_SESSION['login'];
$secreto = $_SESSION['secreto']; // recuperamos numero secreto que se guardo en inicio
$intento = $_POST['intento']; // recogemos numero que el usuario introdujo en el formulario

echo "<h1>Número secreto: $secreto</h1>";
echo "<h2>Tu intento: $intento</h2>";

if ($intento == $secreto) {
    echo "<p>¡Has acertado! +1 punto</p>";
    $connection->query("UPDATE jugador SET puntos = puntos+1 WHERE login='$login'");
    $connection->query("INSERT INTO partidas (login, resultado, numero, intento, fecha) 
                        VALUES ('$login', 1, $secreto, $intento, CURDATE())");
    header("Location: acierto.php");
    exit();
} else {
    echo "<p>Has fallado. −1 punto</p>";
    $connection->query("UPDATE jugador SET puntos = puntos-1 WHERE login='$login'");
    $connection->query("INSERT INTO partidas (login, resultado, numero, intento, fecha) 
                        VALUES ('$login', 0, $secreto, $intento, CURDATE())");
    header("Location: fallo.php");
    exit();
}
?>

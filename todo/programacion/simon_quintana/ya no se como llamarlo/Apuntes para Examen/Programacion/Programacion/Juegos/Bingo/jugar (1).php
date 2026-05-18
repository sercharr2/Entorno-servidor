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

// Inicializar cartón si no existe
if (!isset($_SESSION['carton'])) { // Si todavía no existe el cartón en la sesión
    $_SESSION['carton'] = []; // Creamos un array vacío
    while (count($_SESSION['carton']) < 15) { // Queremos 15 números en el cartón
        $num = rand(1,90); // Generamos un número aleatorio entre 1 y 90
        if (!in_array($num, $_SESSION['carton'])) { //evitamos repetur numero
            $_SESSION['carton'][] = $num; //añadir numero al carton
        }
    }
}

//sacar numero del bombo
// Número aleatorio del bombo
$numero = rand(1,90);

echo "<h1>Número sacado: $numero</h1>";

// Buscar el número en el cartón con un for 
$encontrado = false;
for ($i = 0; $i < count($_SESSION['carton']); $i++) {
    if ($_SESSION['carton'][$i] == $numero) {
        $encontrado = true;
        break; // salimos del bucle en cuanto lo encontramos
    }
}

// Decisión
if ($encontrado) {
    echo "<p>¡Número en tu cartón! +1 punto</p>";
    //actualizan puntos del jugador en la bd
    $connection->query("UPDATE jugador SET puntos = puntos+1 WHERE login='$login'");
    //regisdtramos la jugada en la tabla de partidas 
    $connection->query("INSERT INTO partidas (login, resultado, numero, fecha) 
                        VALUES ('$login', 1, $numero, CURDATE())");
    header("Location: acierto.php");
    exit();
} else {
    echo "<p>No está en tu cartón. −1 punto</p>";
    $connection->query("UPDATE jugador SET puntos = puntos-1 WHERE login='$login'");
    $connection->query("INSERT INTO partidas (login, resultado, numero, fecha) 
                        VALUES ('$login', 0, $numero, CURDATE())");
    header("Location: fallo.php");
    exit();
}

// Mostrar cartón
echo "<h2>Tu cartón</h2>";
echo "<table border=1>";
for ($i = 0; $i < count($_SESSION['carton']); $i++) {
    echo "<td>".$_SESSION['carton'][$i]."</td>";// Pintamos cada número en una celda
} 
echo "</table>";
?>

<a href="jugar.php">Sacar otro número</a><br>
<a href="estadistica.php">Ver estadísticas</a>
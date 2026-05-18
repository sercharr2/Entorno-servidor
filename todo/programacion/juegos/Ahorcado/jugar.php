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

if (!isset($_SESSION['login'])) {
    header("Location: index.php");
    exit();
}

$palabra = $_SESSION['palabra'];
$progreso = $_SESSION['progreso'];
$fallos = $_SESSION['fallos'];
$letras_usadas = $_SESSION['letras_usadas'];

if (isset($_POST['letra'])) {
    $letra = strtolower($_POST['letra']);

    // Evitar repetir letra
    if (!in_array($letra, $letras_usadas)) {
        $letras_usadas[] = $letra;
        $acierto = false;

        for ($i = 0; $i < strlen($palabra); $i++) {
            if ($palabra[$i] == $letra) {
                $progreso[$i] = $letra;
                $acierto = true;
            }
        }

        if (!$acierto) {
            $fallos++;
        }
    }
    $_SESSION['progreso'] = $progreso;
    $_SESSION['fallos'] = $fallos;
    $_SESSION['letras_usadas'] = $letras_usadas;
}

// Mostrar progreso
echo "<h2>Palabra: $progreso</h2>";
echo "<p>Letras usadas: ".implode(", ", $letras_usadas)."</p>";

// Comprobar fin de juego
if ($progreso == $palabra) {
    echo "<p>¡Has acertado! La palabra era $palabra.</p>";
    echo '<a href="inicio.php">Volver a jugar</a>';
    exit();
} elseif ($fallos >= 6) {
    echo "<p>Has perdido. La palabra era $palabra.</p>";
    echo '<a href="inicio.php">Volver a jugar</a>';
    exit();
}
?>

<form method="post" action="jugar.php">
    Introduce una letra: <input type="text" name="letra" maxlength="1">
    <input type="submit" value="Probar">
</form>

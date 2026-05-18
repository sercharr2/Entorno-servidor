<?php
session_start();
$hn = 'localhost';
$db = 'jerogrifico';
$un = 'jugador';
$pw = '';

$connection = new mysqli($hn, $un, $pw, $db);
 if ($connection->connect_error) die("Fatal Error");

 $error='';
 
$login = $_SESSION['login'];
$palabra = $_SESSION['palabra'];
$progreso = $_SESSION['progreso'];
$intentos = $_SESSION['intentos'];

if (isset($_POST['letra'])) {
    $letra = strtolower($_POST['letra']);
    $nuevoProgreso = $progreso;
    $acierto = false;

    // Comprobar letra en palabra
    for ($i = 0; $i < strlen($palabra); $i++) {
        if ($palabra[$i] == $letra) {
            $nuevoProgreso[$i] = $letra;
            $acierto = true;
        }
    }

    $_SESSION['progreso'] = $nuevoProgreso;

    if ($acierto) {
        // Guardar jugada en BD como acierto
        $connection->query("INSERT INTO partidas (login, resultado, fecha) 
                            VALUES ('$login', 1, CURDATE())");
    } else {
        $_SESSION['intentos']--;
        // Guardar jugada en BD como fallo
        $connection->query("INSERT INTO partidas (login, resultado, fecha) 
                            VALUES ('$login', 0, CURDATE())");
    }

    // Comprobar si ha ganado o perdido
    if ($_SESSION['progreso'] == $palabra) {
        $connection->query("UPDATE jugador SET puntos=puntos+1 WHERE login='$login'");
        header("Location: acierto.php");
        exit();
    } elseif ($_SESSION['intentos'] <= 0) {
        $connection->query("UPDATE jugador SET puntos=puntos-1 WHERE login='$login'");
        header("Location: fallo.php");
        exit();
    }
}
?>

<h2>Palabra: <?php echo $_SESSION['progreso']; ?></h2>
<p>Intentos restantes: <?php echo $_SESSION['intentos']; ?></p>
<form method="post" action="jugar.php">
    Introduce una letra: <input type="text" name="letra" maxlength="1">
    <input type="submit" value="Probar">
</form>

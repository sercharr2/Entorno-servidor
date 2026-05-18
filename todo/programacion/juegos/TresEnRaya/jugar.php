<?php
session_start();

$hn = 'localhost';
$db = 'tresenraya';   // nombre de la BD (ajústalo al examen)
$un = 'jugador';      // usuario de la BD
$pw = '';             // contraseña
if ($connection->connect_error) die("Fatal Error");

$error = '';
// Si no hay usuario en sesión, vuelve al login
if (!isset($_SESSION['login'])) {
    header("Location: index.php");
    exit();
}

if (isset($_POST['casilla'])) {
    $c = $_POST['casilla'];   // Casilla pulsada por el usuario


    // Si la casilla está vacía, se marca con el turno actual
    if ($_SESSION['tablero'][$c] == "") {
        $_SESSION['tablero'][$c] = $_SESSION['turno'];

    // Cambiar turno usando if/else en lugar de operador ternario
    if ($_SESSION['turno'] == "X") {
            $_SESSION['turno'] = "O";   // Si era X, ahora pasa a O
    } else {
            $_SESSION['turno'] = "X";   // Si era O, ahora pasa a X
        }
    }

    // Comprobar si hay ganador
    if (hayGanador($_SESSION['tablero'])) {
        // Si el último turno fue del usuario (X), gana él
        if ($_SESSION['turno']=="O") {
            header("Location: acierto.php");
        } else {
            header("Location: fallo.php");
        }
        exit();
    }

    // Comprobar empate: si no quedan casillas vacías
    $empate = true;
    for ($i=0; $i<9; $i++) {
        if ($_SESSION['tablero'][$i] == "") {
            $empate = false;
            break;
        }
    }
    if ($empate) {
        header("Location: fallo.php");
        exit();
    }
}
header("Location: inicio.php");

// Función para comprobar si hay ganador
function hayGanador($tablero) {
    $lineas = [
        [0,1,2],[3,4,5],[6,7,8], // filas
        [0,3,6],[1,4,7],[2,5,8], // columnas
        [0,4,8],[2,4,6]          // diagonales
    ];
    foreach ($lineas as $l) {
        if ($tablero[$l[0]] != "" &&
            $tablero[$l[0]] == $tablero[$l[1]] &&
            $tablero[$l[1]] == $tablero[$l[2]]) {
            return true; // Hay ganador
        }
    }
    return false;
}

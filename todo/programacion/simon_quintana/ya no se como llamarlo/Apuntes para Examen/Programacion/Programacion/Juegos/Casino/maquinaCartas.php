<?php
session_start();

if (!isset($_SESSION['puntos'])) {
    $_SESSION['puntos'] = 0;
}
if (!isset($_SESSION['historial'])) {
    $_SESSION['historial'] = [];
}

function carta() { return rand(1, 13); }

if (!isset($_POST['jugar'])) {
    echo '<h1>Máquina de cartas</h1>';
    echo '<form method="post" action="cartas.php"><button name="jugar" value="1">Repartir</button></form>';
    echo '<p>Puntos: '.$_SESSION['puntos'].'</p>';
    exit;
}

$c1 = carta(); $c2 = carta(); $c3 = carta();
$msg = '';

if ($c1 === $c2 && $c2 === $c3) {
    $_SESSION['puntos'] += 10;
    $msg = "[$c1, $c2, $c3] -> ¡Tres iguales! +10 puntos";
} elseif ($c1 === $c2 || $c1 === $c3 || $c2 === $c3) {
    $_SESSION['puntos'] += 5;
    $msg = "[$c1, $c2, $c3] -> Dos iguales. +5 puntos";
} else {
    $_SESSION['puntos'] -= 1;
    $msg = "[$c1, $c2, $c3] -> Todas distintas. -1 punto";
}

$_SESSION['historial'][] = $msg;

echo '<h1>Máquina de cartas</h1>';
echo '<p>'.$msg.'</p>';
echo '<p>Puntos: '.$_SESSION['puntos'].'</p>';
echo '<form method="post" action="cartas.php"><button name="jugar" value="1">Repartir</button></form>';

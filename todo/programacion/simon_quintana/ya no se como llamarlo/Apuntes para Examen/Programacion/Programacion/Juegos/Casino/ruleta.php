<?php
session_start();

// Inicializar puntos e historial si no existen
if (!isset($_SESSION['puntos'])) {
    $_SESSION['puntos'] = 0;
}
if (!isset($_SESSION['historial'])) {
    $_SESSION['historial'] = [];
}

if (!isset($_POST['jugar'])) {
    // Formulario: elegir número 1–10
    echo '<h1>Ruleta simple</h1>';
    echo '<form method="post" action="ruleta.php">';
    echo 'Elige un número (1-10): <input type="number" name="numero" min="1" max="10" required>';
    echo '<input type="submit" name="jugar" value="Girar">';
    echo '</form>';

    // Mostrar puntos e historial
    echo '<p>Puntos: '.$_SESSION['puntos'].'</p>';
    if (!empty($_SESSION['historial'])) {
        echo '<h3>Historial</h3>';
        foreach ($_SESSION['historial'] as $h) {
            echo $h.'<br>';
        }
    }
    exit;
}

// Lógica de juego
$eleccion = (int)$_POST['numero'];
if ($eleccion < 1 || $eleccion > 10) {
    echo 'Número inválido. Debe ser 1–10. <a href="ruleta.php">Volver</a>';
    exit;
}

$bola = rand(1, 10);
if ($eleccion === $bola) {
    $_SESSION['puntos'] += 5;
    $msg = "Has elegido $eleccion. Salió $bola. ¡Acertaste! +5 puntos.";
} else {
    $_SESSION['puntos'] -= 1;
    $msg = "Has elegido $eleccion. Salió $bola. Fallaste. -1 punto.";
}
$_SESSION['historial'][] = $msg;

// Mostrar resultado
echo '<h2>'.$msg.'</h2>';
echo '<p>Puntos: '.$_SESSION['puntos'].'</p>';
echo '<a href="ruleta.php">Volver a jugar</a>';
?>
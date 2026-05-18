<?php
session_start();
require 'pintar_circulos.php';


if (!isset($_SESSION['colores-escogidos'])) {
    for ($i = 0; $i < $_SESSION['numero']; $i++) {
        $_SESSION['colores-escogidos'][$i] = 'black';
    }
    $_SESSION['pulsaciones'] = 0;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['color'])) {
    $color = $_POST['color'];
    $index = $_SESSION['pulsaciones'];

    if ($index < $_SESSION['numero']) {
        $_SESSION['colores-escogidos'][$index] = $color;
        $_SESSION['pulsaciones']++;
    }
}

pintar_circulos($_SESSION['colores-escogidos']);



if ($_SESSION['pulsaciones'] >= $_SESSION['numero']) {
    if ($_SESSION['colores-escogidos'] === $_SESSION['colores-correctos']) {
        header("Location:acierto.php");
        exit;
    } else {
        header("Location:fallo.php");
        exit;
    }
}


echo <<<END
<form method="post" action="jugar.php">
    <h1>SIMÓN</h1>
        <h2>Pulsa los botones en el orden correspondiente</h2>
END;
//generar los botones segun los colores seleccionados
$todos_colores=array('red','blue','yellow','green','purple','orange','pink','brown');
$colores_disponibles = array_slice($todos_colores, 0, $_SESSION['numero-colores']);

foreach ($colores_disponibles as $color) {
    $nombre = strtoupper($color);
    echo "<button type='submit' name='color' value='$color' style='background-color:$color; border:2px solid black; margin-right:10px;'>$nombre</button>";
}

echo '</form>';
?>
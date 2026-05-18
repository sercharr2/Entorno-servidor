<?php
session_start();
include "pintar-circulos copy.php";

    echo "<h2>Enhorabuena, has acertado la combinación!</h2>";
    pintar_circulos(
        $_SESSION['combinacioncorrecta'][0],
        $_SESSION['combinacioncorrecta'][1],
        $_SESSION['combinacioncorrecta'][2],
        $_SESSION['combinacioncorrecta'][3]
    );

    // Reiniciar para volver a jugar
    $_SESSION['jugada'] = [];

    echo "<a href='dificultad.php'>Volver a jugar</a>";

?>


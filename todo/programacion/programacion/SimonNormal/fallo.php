<?php
session_start();
include "pintar-circulos.php";

echo "<h2>Lo sentimos, has fallado</h2>";

echo "<p>Combinación correcta:</p>";
    pintar_circulos(
        $_SESSION['combinacioncorrecta'][0],
        $_SESSION['combinacioncorrecta'][1],
        $_SESSION['combinacioncorrecta'][2],
        $_SESSION['combinacioncorrecta'][3]
    );

    echo "<p>Tu combinación:</p>";
    pintar_circulos(
        $_SESSION['jugada'][0],
        $_SESSION['jugada'][1],
        $_SESSION['jugada'][2],
        $_SESSION['jugada'][3]
    );

     // Reiniciar para volver a jugar
    $_SESSION['jugada'] = [];

    echo "<a href='inicio.php'>Volver a jugar</a><br>";
    echo "<a href='estadistica.php'>Estadistica</a>";

?>
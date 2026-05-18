<?php

session_start();
include "pintar-circulos.php";

$colores = array("red", "green", "blue", "yellow");
$combinacion = array();

for ($i = 0; $i < 4; $i++) {
    $combinacion[] = $colores[array_rand($colores)];
}

$_SESSION['combinacioncorrecta'] = $combinacion;
$_SESSION['jugada'] = [];



echo <<<_END
<html>
    <body>
        <h1>SIMÓN</h1>
            <h2>Memoriza la combinación</h2>

_END;

pintar_circulos($combinacion[0], $combinacion[1], $combinacion[2], $combinacion[3]);

echo <<<_END
    <form action="jugar.php" method="post">
        <input type="submit" name="submit" value="Vamos a jugar">
    </form>
    </body>
</html>
_END;
?>
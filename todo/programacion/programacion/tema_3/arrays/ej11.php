<?php
/*
    Ejercicio:
    Mostrar las películas vistas por mes.
    Meses: enero=9, febrero=12, marzo=0, abril=17
    Si un mes tiene 0 películas NO debe mostrarse.
*/

$peliculas = array(
    "enero" => 9,
    "febrero" => 12,
    "marzo" => 0,
    "abril" => 17
);

foreach ($peliculas as $mes => $cantidad) {
    if ($cantidad > 0) {
        echo "En $mes se vieron $cantidad películas.<br>";
    }
}
?>

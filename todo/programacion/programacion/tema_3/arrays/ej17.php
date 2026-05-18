<?php
/*
    Ejercicio 17:
    Rellenar 3 arrays, unirlos con array_merge() y mostrarlos.
*/

$a1 = array(1, 2, 3);
$a2 = array(4, 5, 6);
$a3 = array(7, 8, 9);

// Unir los arrays
$unido = array_merge($a1, $a2, $a3);

// Mostrar resultado
foreach ($unido as $valor) {
    echo $valor . " ";
}
?>

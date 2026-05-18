<?php
/*
    Ejercicio 18:
    Unir los 3 arrays usando array_push()
*/

$a1 = array(1, 2, 3);
$a2 = array(4, 5, 6);
$a3 = array(7, 8, 9);

$unido2 = array(); // array vacío

// Insertar todos los valores usando array_push y operador spread (...)
array_push($unido2, ...$a1);
array_push($unido2, ...$a2);
array_push($unido2, ...$a3);

// Mostrar resultado
foreach ($unido2 as $valor) {
    echo $valor . " ";
}
?>

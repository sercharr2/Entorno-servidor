<?php
/*
    Ejercicio:
    Cargar un vector e imprimir los valores del array asociativo usando foreach.
*/

$e[1] = 90;
$e[30] = 7;
$e['e'] = 99;
$e['hola'] = 43;

// Mostrar contenido del array
foreach ($e as $indice => $valor) {
    echo "Índice: $indice → Valor: $valor<br>";
}
?>

<?php
/*
    Ejercicio:
    Crear un array con ciudades SIN asignar índices.
    Luego mostrar cada índice y su valor.
*/

$ciudades = array("Madrid", "Barcelona", "Londres", "New York", "Los Ángeles", "Chicago");

// Recorrer y mostrar
foreach ($ciudades as $indice => $valor) {
    echo "La ciudad con el índice $indice tiene el nombre de $valor.<br>";
}
?>

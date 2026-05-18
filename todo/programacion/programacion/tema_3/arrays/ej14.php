<?php
/*
    Ejercicio 14 (versión con índices asociativos):
    Crear un array de ciudades usando índices propios (MD, BCN, LDN, NY, LA, CH)
    y mostrar cada índice junto a su ciudad.
*/

$ciudades = array(
    "MD"  => "Madrid",
    "BCN" => "Barcelona",
    "LDN" => "Londres",
    "NY"  => "New York",
    "LA"  => "Los Ángeles",
    "CH"  => "Chicago"
);

// Mostrar contenido del array
foreach ($ciudades as $indice => $valor) {
    echo "El índice del array que contiene como valor $valor es $indice.<br>";
}
?>

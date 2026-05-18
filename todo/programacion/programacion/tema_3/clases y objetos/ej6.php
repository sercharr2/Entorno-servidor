<?php
/*
    EJERCICIO 6 – Práctica 4
*/

require_once "coche.php";

// Coche verde de 2100 kg
$coche = new Coche("Verde", 2100);

// 2 cadenas + una persona
$coche->añadir_cadenas_nieve();
$coche->añadir_cadenas_nieve();
$coche->añadir_persona(80);

// cambios de color
$coche->setColor("Azul");
$coche->quitar_cadenas_nieve();
$coche->quitar_cadenas_nieve();
$coche->setColor("Negro");

// Mostrar todo
Vehiculo::ver_atributo($coche);

echo "<br>Cambios de color: " . Vehiculo::$numero_cambio_color;
?>

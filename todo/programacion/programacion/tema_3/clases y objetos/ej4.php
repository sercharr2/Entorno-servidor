<?php
/*
    EJERCICIO 4 – Práctica 4
*/

require_once "vehiculo.php";
require_once "coche.php";
require_once "dos_ruedas.php";
require_once "camion.php";

// Coche verde 1400 kg
$coche = new Coche("Verde", 1400);
$coche->añadir_persona(65);
$coche->añadir_persona(65);

echo "Coche verde:<br>";
Vehiculo::ver_atributo($coche);

// Coche rojo con cadenas
$coche2 = new Coche("Rojo", 1400);
$coche2->añadir_cadenas_nieve();
$coche2->añadir_cadenas_nieve();

echo "<br>Coche rojo:<br>";
Vehiculo::ver_atributo($coche2);

// Dos ruedas
$moto = new Dos_ruedas("Negro", 120);
$moto->añadir_persona(80);
$moto->poner_gasolina(20);

echo "<br>Dos ruedas:<br>";
Vehiculo::ver_atributo($moto);

// Camión
$camion = new Camion("Azul", 10000);
$camion->añadir_remolque(5);
$camion->añadir_persona(80);

echo "<br>Camión:<br>";
Vehiculo::ver_atributo($camion);
?>

<?php
/*
    Mostrar.php – Ejercicio 5 (corregido)
*/

require_once "dos_ruedas.php";
require_once "camion.php";

// --- Dos ruedas rojo de 150 kg ---
$m = new Dos_ruedas("Rojo", 150);
$m->añadir_persona(70);           // añade 70 + 2 (casco) según definición
$m->setColor("Verde");            // cambia a verde
$m->setCilindrada(1000);          // usa setter en vez de acceder directamente

echo "<strong>Dos ruedas:</strong><br />";
Vehiculo::ver_atributo($m);
echo "<br />Peso total (getPeso): " . $m->getPeso() . "<br />";

// --- Camión blanco 6000 kg ---
$c = new Camion("Blanco", 6000);
$c->añadir_persona(84);
$c->setColor("Azul");
$c->setNumeroPuertas(2);          // usa setter
echo "<br /><strong>Camión:</strong><br />";
Vehiculo::ver_atributo($c);
?>

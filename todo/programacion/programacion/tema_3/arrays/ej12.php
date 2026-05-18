<?php
/*
    Ejercicio:
    Crear un array asociativo con datos de una persona y mostrarlos.
*/

$persona = array(
    "Nombre" => "Pedro Torres",
    "Dirección" => "C/Mayor, 37",
    "Teléfono" => "123456789"
);

foreach ($persona as $campo => $valor) {
    echo "$campo: $valor<br>";
}
?>

<?php
/*
    EJERCICIO 3 – Práctica 4

    Operaciones:
      • Crear accesos y constructor en Vehículo
      • Implementar toString
      • Modificar circula()
      • Añadir persona modifica peso
      • Crear un vehículo negro de 1500 kg
*/

require_once "vehiculo.php";

$v = new Vehiculo("Negro", 1500);

echo "Información inicial:<br>";
Vehiculo::ver_atributo($v);

$v->circula();
$v->añadir_persona(70);

echo "<br>Nuevo peso:<br>";
Vehiculo::ver_atributo($v);
?>

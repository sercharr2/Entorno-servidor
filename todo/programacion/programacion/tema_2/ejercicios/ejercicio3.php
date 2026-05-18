<?php
/*
Determinar la cantidad de dinero que recibirá un trabajador por concepto de las
horas extras trabajadas en una empresa, sabiendo que cuando las horas de
trabajo exceden de 40, el resto se consideran horas extras y que estas se pagan al
doble de una hora normal cuando no exceden de 8; si las horas extras exceden de
8 se pagan las primeras 8 al doble de lo que se pagan las horas normales y el resto
al triple.
*/


// Datos de entrada
$horasTrabajadas = 55;   // Ejemplo
$pagoHora = 10;          // Pago por hora normal

// Cálculo
if ($horasTrabajadas > 40) {
    $horasExtras = $horasTrabajadas - 40;
} else {
    $horasExtras = 0;
}

if ($horasExtras <= 8) {
    // Todas las horas extras se pagan al doble
    $pagoExtras = $horasExtras * ($pagoHora * 2);
} else {
    // 8 horas al doble, el resto al triple
    $pagoExtras = (8 * ($pagoHora * 2)) + (($horasExtras - 8) * ($pagoHora * 3));
}

echo "Horas trabajadas: $horasTrabajadas<br>";
echo "Horas extras: $horasExtras<br>";
echo "Pago por horas extras: $$pagoExtras";

?>

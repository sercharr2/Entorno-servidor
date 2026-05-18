<?php
/*Escriba un programa a partir de un número entero generado de forma aleatoria
indique si es primo. Un número primo es aquel que es divisible por el mismo y la
unidad.
*/

// Generar número aleatorio entre 1 y 1000
$num = rand(1, 1000);

echo "Número generado: $num <br>";

// Caso especial: 1 no es primo
if ($num == 1) {
    echo "El número 1 NO es primo.";
    exit;
}

// Verificar si es primo
$esPrimo = true;

for ($i = 2; $i <= sqrt($num); $i++) {
    if ($num % $i == 0) {
        $esPrimo = false;
        break;
    }
}

// Mostrar resultado
if ($esPrimo) {
    echo "El número $num ES primo.";
} else {
    echo "El número $num NO es primo.";
}

?>

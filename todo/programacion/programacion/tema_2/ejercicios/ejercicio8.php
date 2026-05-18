<?php

/*Calcular si un número entero generado de forma aleatoria entre 1 y 1000 es
perfecto. Un número perfecto es aquel que la suma de sus divisores es él mismo,
por ejemplo el 6, sus divisores son 1,2,3 la suma de los mismos es 6.
*/

// Generar número aleatorio entre 1 y 1000
$num = rand(1, 1000);

echo "Número generado: $num <br>";

// Calcular suma de divisores propios
$suma = 0;

for ($i = 1; $i < $num; $i++) {
    if ($num % $i == 0) {
        $suma += $i;
    }
}

// Verificar si es perfecto
if ($suma == $num) {
    echo "El número $num ES un número perfecto.";
} else {
    echo "El número $num NO es un número perfecto.";
}

?>

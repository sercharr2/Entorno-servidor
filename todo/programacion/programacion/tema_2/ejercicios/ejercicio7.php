<?php

/*Hacer un programa que calcule todos los números primos entre 1 y 50 y los
muestre por pantalla. Un número primo es un número entero que sólo es
divisible por 1 y por sí mismo. */

echo "Números primos entre 1 y 50:<br>";

for ($num = 2; $num <= 50; $num++) {
    
    $esPrimo = true;

    // Verificar si el número es primo
    for ($i = 2; $i <= sqrt($num); $i++) {
        if ($num % $i == 0) {
            $esPrimo = false;
            break;
        }
    }

    if ($esPrimo) {
        echo $num . "<br>";
    }
}

?>

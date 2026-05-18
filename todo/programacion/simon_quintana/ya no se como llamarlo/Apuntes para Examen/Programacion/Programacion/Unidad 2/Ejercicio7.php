<?php
// Programa para calcular números primos entre 1 y 50

for ($num = 2; $num <= 50; $num++) {
    $esPrimo = true;

    // Verificamos divisores desde 2 hasta la raíz cuadrada de $num
    for ($i = 2; $i <= sqrt($num); $i++) {
        if ($num % $i == 0) {
            $esPrimo = false;
            break;
        }
    }

    if ($esPrimo) {
        echo $num . " ";
    }
}
?>
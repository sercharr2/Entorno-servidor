<?php
/*
4. Identificar entre dos números aleatorios cual es el mayor y si este es par o impar.
Buscar información previamente para generar números aleatorios y usarla para
resolver el ejercicio.


NOTA: en PHP existen varias funciones para generar números aleatorios.
Para propósitos generales se recomienda usar random_int() (disponible en PHP 7+)
porque genera enteros con buena uniformidad y es criptográficamente seguro.
Como alternativa, mt_rand() o rand() pueden usarse en entornos no críticos.
*/

// Generar dos números aleatorios entre 1 y 100
$num1 = rand(1, 100);
$num2 = rand(1, 100);

// Mostrar los números generados
echo "Número 1: $num1 <br>";
echo "Número 2: $num2 <br><br>";

// Identificar el número mayor
if ($num1 > $num2) {
    $mayor = $num1;
} elseif ($num2 > $num1) {
    $mayor = $num2;
} else {
    echo "Ambos números son iguales: $num1";
    exit; // Termina aquí porque no hay mayor
}

// Verificar si el mayor es par o impar
if ($mayor % 2 == 0) {
    $tipo = "par";
} else {
    $tipo = "impar";
}

echo "El número mayor es: $mayor y es $tipo.";

?>

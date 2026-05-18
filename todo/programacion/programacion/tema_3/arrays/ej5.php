<?php
/* Generar de forma aleatoria una matriz de 3x5 con valores numéricos.
a. Imprimir todos los elementos en forma sucesiva tomándolos por fila.
b. Igual al anterior pero por columna*/

$matriz = array();
for ($i = 0; $i < 3; $i++) {
    for ($j = 0; $j < 5; $j++) {
        $matriz[$i][$j] = rand(1, 99); // números aleatorios entre 1 y 99
    }
}

//apartado A
echo "<b>Imprimir por filas:</b><br>";
for ($i = 0; $i < 3; $i++) {
    for ($j = 0; $j < 5; $j++) {
        echo $matriz[$i][$j] . " ";
    }
    echo "<br>";
}

//apartado B

echo "<b>Imprimir por filas:</b><br>";
for ($i = 0; $i < 5; $i++) {
    for ($j = 0; $j < 3; $j++) {
        echo $matriz[$j][$i] . " ";
    }
    echo "<br>";
}
?>
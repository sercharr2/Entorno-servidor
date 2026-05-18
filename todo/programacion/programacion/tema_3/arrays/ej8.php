<?php

/*
   ENUNCIADO:
   Hacer un algoritmo que llene una matriz de 10x10 con valores aleatorios 
   y determine la posición [fila, columna] del número mayor almacenado 
   en la matriz.
*/

// Generar matriz 10x10 con números aleatorios
$matriz = array();

for ($i = 0; $i < 10; $i++) {
    for ($j = 0; $j < 10; $j++) {
        $matriz[$i][$j] = rand(1, 999); // valores entre 1 y 999
    }
}

// Inicializar el mayor con el primer elemento
$mayor = $matriz[0][0];
$filaMayor = 0;
$colMayor = 0;

// Buscar el número mayor y su posición
for ($i = 0; $i < 10; $i++) {
    for ($j = 0; $j < 10; $j++) {
        if ($matriz[$i][$j] > $mayor) {
            $mayor = $matriz[$i][$j];
            $filaMayor = $i;
            $colMayor = $j;
        }
    }
}

// Mostrar matriz (opcional)
echo "<b>Matriz generada:</b><br>";
for ($i = 0; $i < 10; $i++) {
    for ($j = 0; $j < 10; $j++) {
        echo $matriz[$i][$j] . " ";
    }
    echo "<br>";
}

echo "<br>";

// Mostrar resultados
echo "<b>El número mayor es:</b> $mayor<br>";
echo "<b>Posición:</b> Fila $filaMayor, Columna $colMayor<br>";

?>

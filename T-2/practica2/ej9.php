<?php

$matrizC4 = [];

// Llenar la matriz 20x20 con valores aleatorios entre 0 y 100
for ($i = 0; $i <= 19; $i++) {
    for ($j = 0; $j <= 19; $j++) {
        $matrizC4[$i][$j] = rand(0, 100);
    }
}

// Inicializar arreglo para las sumas de las columnas
$sumC = array_fill(0, 20, 0);
$max = 0;
$columna = 0;

// Imprimir la matriz y calcular la suma de las columnas
for ($i = 0; $i <= 19; $i++) {
    for ($j = 0; $j <= 19; $j++) {
        echo($matrizC4[$i][$j] . "|");
        $sumC[$j] += $matrizC4[$i][$j]; // Sumar por columna
    }
    echo("<br>");
}

// Determinar la columna con la suma mayor
for ($j = 0; $j <= 19; $j++) {
    if ($sumC[$j] >= $max) {
        $max = $sumC[$j];
        $columna = $j;
    }
}

echo("<br>La columna con la suma mayor es: $columna <br>La suma de sus valores es: $max");

?>

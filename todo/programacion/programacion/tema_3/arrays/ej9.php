<?php

/*
    ENUNCIADO:
    Llenar una matriz de 20x20 con valores aleatorios. 
    Sumar las columnas e imprimir la columna que tuvo la máxima suma 
    y la suma de esa columna.
*/

// Crear matriz 20x20 con valores aleatorios
$matriz = array();

for ($i = 0; $i < 20; $i++) {
    for ($j = 0; $j < 20; $j++) {
        $matriz[$i][$j] = rand(1, 100); // valores entre 1 y 100
    }
}

// Sumar cada columna
$sumasColumnas = array_fill(0, 20, 0);

for ($j = 0; $j < 20; $j++) {
    for ($i = 0; $i < 20; $i++) {
        $sumasColumnas[$j] += $matriz[$i][$j];
    }
}

// Encontrar la columna con la suma máxima
$maxSuma = $sumasColumnas[0];
$colMax = 0;

for ($j = 1; $j < 20; $j++) {
    if ($sumasColumnas[$j] > $maxSuma) {
        $maxSuma = $sumasColumnas[$j];
        $colMax = $j;
    }
}

// Mostrar sumas de columnas (opcional)
echo "<b>Sumas de cada columna:</b><br>";
for ($j = 0; $j < 20; $j++) {
    echo "Columna $j = " . $sumasColumnas[$j] . "<br>";
}

echo "<br>";

// Mostrar resultados
echo "<b>La columna con mayor suma es la columna:</b> $colMax<br>";
echo "<b>Suma máxima:</b> $maxSuma<br>";

?>

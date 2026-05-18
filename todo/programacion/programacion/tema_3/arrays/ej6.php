<?php

/*Generar de forma aleatoria una matriz de 4*5 con valores numéricos, determinar
fila y columna del elemento mayor. */

$matriz = array();
for ($i = 0; $i < 4; $i++) {
    for ($j = 0; $j < 5; $j++) {
        $matriz[$i][$j] = rand(1, 99); // números aleatorios entre 1 y 99
    }
}

// Variables para almacenar el mayor
$mayor = $matriz[0][0];
$filaMayor = 0;
$colMayor = 0;

// Buscar el elemento mayor
for ($i = 0; $i < 4; $i++) {
    for ($j = 0; $j < 5; $j++) {
        if ($matriz[$i][$j] > $mayor) {
            $mayor = $matriz[$i][$j];
            $filaMayor = $i;
            $colMayor = $j;
        }
    }
}

// Mostrar matriz (opcional)
echo "<b>Matriz generada:</b><br>";
for ($i = 0; $i < 4; $i++) {
    for ($j = 0; $j < 5; $j++) {
        echo $matriz[$i][$j] . " ";
    }
    echo "<br>";
}

echo "<br>";

// Mostrar resultado
echo "El elemento mayor es: <b>$mayor</b><br>";
echo "Fila: <b>$filaMayor</b><br>";
echo "Columna: <b>$colMayor</b><br>";

?>
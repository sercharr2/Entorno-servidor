<?php

/*Genera una matriz de 4*4 de forma aleatoria con números enteros desordenados
mostrar en un renglón los elementos almacenados en la diagonal principal y en el
siguiente los de la diagonal secundaria. */


// Generar matriz 4x4 con números enteros aleatorios
$matriz = array();

for ($i = 0; $i < 4; $i++) {
    for ($j = 0; $j < 4; $j++) {
        $matriz[$i][$j] = rand(1, 99); // números aleatorios entre 1 y 99
    }
}

// Mostrar matriz completa (opcional)
echo "<b>Matriz 4x4 generada:</b><br>";
for ($i = 0; $i < 4; $i++) {
    for ($j = 0; $j < 4; $j++) {
        echo $matriz[$i][$j] . " ";
    }
    echo "<br>";
}

echo "<br>";

// Mostrar diagonal principal
echo "<b>Diagonal principal:</b><br>";
for ($i = 0; $i < 4; $i++) {
    echo $matriz[$i][$i] . " ";
}

echo "<br><br>";

// Mostrar diagonal secundaria
echo "<b>Diagonal secundaria:</b><br>";
for ($i = 0; $i < 4; $i++) {
    echo $matriz[$i][3 - $i] . " ";
}

?>

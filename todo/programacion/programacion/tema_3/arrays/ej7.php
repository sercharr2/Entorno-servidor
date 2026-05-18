<?php

/*Generar una matriz de 3x4 y generar un vector que contenga los valores máximos
de cada fila y otro que contenga los promedios de los mismos. Imprimir ambos
vectores a razón de uno por renglón.*/

// Generar matriz 3x4 con valores aleatorios
$matriz = array();

for ($i = 0; $i < 3; $i++) {
    for ($j = 0; $j < 4; $j++) {
        $matriz[$i][$j] = rand(1, 99);  // valores de ejemplo
    }
}

// Vectores para máximos y promedios
$maximos = array();
$promedios = array();

// Recorrer filas para obtener máximos y promedios
for ($i = 0; $i < 3; $i++) {

    $maximo = $matriz[$i][0];
    $suma = 0;

    for ($j = 0; $j < 4; $j++) {
        $valor = $matriz[$i][$j];
        $suma += $valor;

        if ($valor > $maximo) {
            $maximo = $valor;
        }
    }

    $maximos[$i] = $maximo;
    $promedios[$i] = $suma / 4;
}

// Mostrar matriz (opcional)
echo "<b>Matriz generada:</b><br>";
for ($i = 0; $i < 3; $i++) {
    for ($j = 0; $j < 4; $j++) {
        echo $matriz[$i][$j] . " ";
    }
    echo "<br>";
}

echo "<br>";

// Mostrar vector de máximos
echo "<b>Vector de máximos por fila:</b><br>";
for ($i = 0; $i < 3; $i++) {
    echo $maximos[$i] . " ";
}

echo "<br><br>";

// Mostrar vector de promedios
echo "<b>Vector de promedios por fila:</b><br>";
for ($i = 0; $i < 3; $i++) {
    echo $promedios[$i] . " ";
}

?>
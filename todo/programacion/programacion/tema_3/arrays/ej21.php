<?php
/*
    Ejercicio 21:
    Ordenar un array de menor a mayor y mostrarlo en una tabla.
*/

$numeros = array(3,2,8,123,5,1);

// Ordenar de menor a mayor
sort($numeros);

// Mostrar en tabla
echo "<table border='1' cellpadding='5'>";
echo "<tr><th>Valor</th></tr>";

foreach ($numeros as $valor) {
    echo "<tr><td>$valor</td></tr>";
}

echo "</table>";
?>

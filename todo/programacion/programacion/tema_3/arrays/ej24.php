<?php
/*
    Ejercicio 24:
    Array de deportes + recorrido con for y manejo del puntero interno.
*/

$deportes = array("futbol", "baloncesto", "natación", "tenis");

// Recorrer con un for
echo "<h3>Recorrido con for:</h3>";
for ($i = 0; $i < count($deportes); $i++) {
    echo $deportes[$i] . "<br>";
}

// Total de valores
echo "<br>Total de valores: " . count($deportes) . "<br><br>";

// Puntero al primer elemento
reset($deportes);
echo "Valor actual (primer elemento): " . current($deportes) . "<br>";

// Avanzar una posición
next($deportes);
echo "Valor actual (segunda posición): " . current($deportes) . "<br>";

// Puntero al último elemento
end($deportes);
echo "Valor actual (último elemento): " . current($deportes) . "<br>";

// Retroceder una posición
prev($deportes);
echo "Valor actual (penúltimo elemento): " . current($deportes) . "<br>";
?>

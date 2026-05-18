<?php
/*
    Ejercicio 22:
    Crear array, mostrar, contar elementos, borrar una posición y eliminar el array.
*/

$valores = array(
    5 => 1,
    12 => 2,
    13 => 56,
    "x" => 42
);

// Mostrar contenido inicial
echo "<h3>Contenido inicial:</h3>";
print_r($valores);
echo "<br><br>";

// Número de elementos
echo "Número de elementos: " . count($valores) . "<br><br>";

// Borrar contenido de la posición 5
unset($valores[5]);

// Mostrar de nuevo
echo "<h3>Contenido después de borrar posición 5:</h3>";
print_r($valores);
echo "<br><br>";

// Eliminar array completo
unset($valores);

echo "El array ha sido eliminado.";
?>

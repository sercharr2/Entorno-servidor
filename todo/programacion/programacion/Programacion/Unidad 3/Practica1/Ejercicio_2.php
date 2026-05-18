<?php

$academia = array(array(1, 14, 8, 3), array(6, 19, 7, 2), array(3, 13, 4, 1));

// Contamos cuántas filas y columnas hay.
$filas = count($academia);
$columnas = count($academia[0]);

// Recorremos por columnas.
for ($col = 0; $col < $columnas; $col++) {
   
    for ($fila = 0; $fila < $filas; $fila++) {
       
        echo $academia[$fila][$col] . "<br>";
    }
    echo "<br>"; 
}
?>
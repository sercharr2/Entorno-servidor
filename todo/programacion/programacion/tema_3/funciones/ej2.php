<?php
/*
    2. Almacena la función anterior en el fichero matematicas.php.
       Crea un fichero que la incluya y la utilice.
*/
include "ej1.php";

$resultado = resolverEcuacion2Grado(1, -3, 2);

if ($resultado === FALSE) {
    echo "No hay soluciones reales.";
} else {
    echo "Soluciones: ";
    print_r($resultado);
}
?>

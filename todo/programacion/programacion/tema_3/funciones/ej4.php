<?php
/*
    4. Escribe una función que reciba un array de números y un número, el límite.
       La función tiene que devolver un nuevo array que contenga solo los elementos
       del array original menores que el límite.
*/
function filtrarMenores($array, $limite) {
    $resultado = [];

    foreach ($array as $num) {
        if ($num < $limite) {
            $resultado[] = $num;
        }
    }

    return $resultado;
}
?>

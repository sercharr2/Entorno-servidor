<?php
/*
    3. Escribe una función que reciba una cadena y compruebe si es un palíndromo.
*/

function esPalindromo($cad) {
    $normal = strtolower(str_replace(' ', '', $cad));
    $invertida = strrev($normal);
    return $normal === $invertida;
}
?>

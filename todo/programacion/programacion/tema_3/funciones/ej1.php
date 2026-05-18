<?php
/*
    Función para resolver una ecuación de segundo grado.
    La función recibe los coeficientes a, b y c de la ecuación
    ax² + bx + c = 0 y devuelve un array con las soluciones reales.
    Si no existen soluciones reales, devuelve FALSE.
*/

function resolverEcuacion2Grado($a, $b, $c) {
    // Si 'a' es 0, no es una ecuación de segundo grado
    if ($a == 0) {
        return FALSE;
    }

    $discriminante = $b*$b - 4*$a*$c;

    // Si el discriminante es negativo, no hay soluciones reales
    if ($discriminante < 0) {
        return FALSE;
    }

    // Cálculo de las soluciones
    $x1 = (-$b + sqrt($discriminante)) / (2 * $a);
    $x2 = (-$b - sqrt($discriminante)) / (2 * $a);

    // Si las soluciones son iguales, devolver solo una
    if ($x1 == $x2) {
        return array($x1);
    }

    return array($x1, $x2);
}
?>

<?php
/*
5. Crear un programa partir de 3 valores, a b y c que corresponden a los tres
coeficientes de una ecuación de segundo grado muestre las soluciones de la
misma La solución de la ecuación de segundo grado depende del signo de b2-4ac:
 si b2-4ac es negativo no hay soluciones
 si es nulo, hay sólo una solución -b/2a
 si es positivo, hay dos soluciones: (-b+sqrt(b2-4ac))/(2a) y (-bsqrt(b2-4ac))/(2a)
*/

// Valores de ejemplo (puedes cambiarlos)
$a = 1;
$b = -3;
$c = 2;

// Cálculo del discriminante
$discriminante = $b * $b - 4 * $a * $c;

echo "Ecuación: {$a}x² + {$b}x + {$c} = 0<br>";
echo "Discriminante: $discriminante<br><br>";

// Evaluar el discriminante
if ($discriminante < 0) {
    echo "No hay soluciones reales porque el discriminante es negativo.";
} elseif ($discriminante == 0) {
    $solucion = -$b / (2 * $a);
    echo "Hay una única solución: x = $solucion";
} else {
    $sol1 = (-$b + sqrt($discriminante)) / (2 * $a);
    $sol2 = (-$b - sqrt($discriminante)) / (2 * $a);

    echo "Hay dos soluciones:<br>";
    echo "x₁ = $sol1<br>";
    echo "x₂ = $sol2<br>";
}

?>

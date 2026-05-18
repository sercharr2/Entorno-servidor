<?php
$num1 = 10;
$num2 = 5;

if ($num1 == $num2) {
    $resultado = $num1 * $num2;
} elseif ($num1 > $num2) {
    $resultado = $num1 - $num2;
} else {
    $resultado = $num1 + $num2;
}

echo "El resultado es: " . $resultado;
?>

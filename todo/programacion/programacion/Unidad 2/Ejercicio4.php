<?php

$num1 = rand(1, 100);
$num2 = rand(1, 100);

echo "Numero 1: $num1"; 
"<br>";
echo "Numero 2: $num2"; 
"<br>";

if ($num1 > $num2) {
    $mayor = $num1;
} else ($num2 > $num1) {
    $mayor = $num2;
} 

if ($mayor % 2 == 0) {
        echo "El numero mayor es $mayor y es PAR";
    } else {
        echo "El numero mayor es $mayor y es IMPAR";
    } else {
    echo "Ambos numeros son iguales";
}
?>

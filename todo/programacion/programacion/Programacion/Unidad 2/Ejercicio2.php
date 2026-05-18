<?php
$num1 = 2;
$num2= 8;
$num3 = 6;

if ($num1 > $num2 and $num1 > $num3) {
echo "El numero mas grande es:" . $num1;

}  elseif ($num2 > $num1 and $num2> $num3) {
    echo "El numero mas grande es: " . $num2;

}   elseif ($num3 > $num1 and $num3> $num2) {
    echo "El numero mas grande es: " . $num3;
}

?>
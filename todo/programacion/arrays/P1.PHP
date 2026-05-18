<?php

/*Ejercicio1*/
$variable1=2;
$variable2=4;

if ($variable1 == $variable2){
    $resultado=$variable1*$variable2;
    echo $resultado;
}
else if ($variable1 > $variable2){
    $resultado=$variable1-$variable2;
    echo $resultado;
}
else if ($variable1<$variable2){
    $resultado=$variable1+$variable2;
    echo $resultado;
}

/* Ejercicio2*/
$num1=0;
$num2=1;
$num3=2;

if ($num1>$num2 && $num1>$num3){
    echo "El numero 1 es el mayor número de todos";
    echo "<br>";
}
else if ($num2>$num1 && $num2>$num3){
    echo "El numero 2 es el mayor número de todos";
}
else if ($num3>$num1 && $num3>$num2){
    echo "El numero 3 es el mayor número de todos";
}

/* Ejercicio3*/
$HorasTotal=40;
$PhoraExtra=60;
$HorasTrabajadas=120;
$diferencia=$HorasTotal-$HorasTrabajadas;
if ($diferencia<8){
    $paga = 8 * $PhoraExtra * 2 * ($diferencia - 8) * $PhoraExtra * 3;
}else{
    $paga=$diferencia*$PhoraExtra*2;
}
echo "Horas trabajas: $HorasTrabajadas";
echo "Horas extra: $diferencia";
echo "Dinero extra: $paga";

/* Ejercicio4*/
$numero1 = rand(1, 100); // genera un número aleatorio entre 1 y 100
$numero2=rand(1, 100);

echo "El número 1 es: $numero1";
echo "<br>";
echo "El número 2 es: $numero2";
echo "<br>";

if ($numero1>$numero2){
    $mayor=$numero1;
    echo "El número mayor es: $mayor";
    echo "<br>";
}else if ($numero2>$numero1){
    $mayor=$numero2;
    echo "El número mayor es: $mayor";
    echo "<br>";
}else{
    echo "Los dos números son iguales";
    echo "<br>";
}

if ($mayor%2==0){
    echo "El número mayor es par";
    echo "<br>";
}else{
    echo "El número mayor es impar";
    echo "<br>";
}

/*Ejercicio 5 */
// Coeficientes
$a = 2;
$b = 5;
$c = 3;

// Calculamos el discriminante
$discriminante = $b * $b - 4 * $a * $c;

if ($discriminante < 0) {
    echo "No hay soluciones reales.";
} elseif ($discriminante == 0) {
    $x = -$b / (2 * $a);
    echo "Hay una única solución: x = " . $x;
} else {
    $sqrt_discriminante = sqrt($discriminante);
    $x1 = (-$b + $sqrt_discriminante) / (2 * $a);
    $x2 = (-$b - $sqrt_discriminante) / (2 * $a);
    echo "Hay dos soluciones: x1 = " . $x1 . " y x2 = " . $x2;
}

/*Ejercicio 6*/
 for ($i = 0 ; $i <= 50 ; $i+=5){

 echo $i; 
 }

 /*Ejercicio 7*/

 for ($i = 0 ; $i <= 50 ; $i+=2){

 echo "$i <br>"; 
 } 

 /*Ejercicio 8*/
 // Generar número aleatorio
$numero = rand(1, 1000);

$suma = 0;

for ($i = 1; $i <= $numero / 2; $i++) {
    if ($numero % $i == 0) {
        $suma += $i;
    }
}

echo "Número generado: $numero <br>";

if ($suma == $numero) {
    echo "$numero es un número perfecto.";
} else {
    echo "$numero no es un número perfecto.";
}

/* Ejercicio 9*/

$numero = rand(1, 100); 
$esPrimo = false;
if ($numero < 0 ) {
    echo "El número debe ser positivo";
    $esPrimo=false;
}else{
    for ($i = 2; $i < $numero; $i++) {
        if ($numero % $i == 0) {
            $esPrimo = false;
            break;
        }
    }
}
if ($esPrimo) {
    echo "$numero es primo";
} else {
    echo "$numero no es primo";
}

/*Ejercicio 10*/
for ($i=1;$i<=9;$i++){
    echo "<br>";
    for ($j=1;$j<=9;$j++){
        if ($i!=$j){
        echo "($i,$j)";
        }
    }
}

?>
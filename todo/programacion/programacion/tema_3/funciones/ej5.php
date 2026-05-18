<?php
/*
    5. Escribe un script para probar algunas de las funciones mostradas debajo.
       El script ha de contener al menos tres funciones de cada bloque:

       - Funciones de variables: isset(), is_null(), empty(), is_int(), is_array(),
         intval(), floatval(), boolval(), strval(), etc.

       - Funciones de cadenas: strlen(), explode(), implode(), strcmp(),
         strtolower(), strtoupper(), strpos(), etc.
*/

include "ej1.php";
include "ej3.php"; // aquí incluirías las funciones del punto 3 y 4
include "ej4.php";

echo "<h3>Pruebas con funciones de variables</h3>";

$var1 = 10;
$var2 = null;
$var3 = [];

echo "isset(\$var1): " . (isset($var1) ? "TRUE" : "FALSE") . "<br>";
echo "is_null(\$var2): " . (is_null($var2) ? "TRUE" : "FALSE") . "<br>";
echo "empty(\$var3): " . (empty($var3) ? "TRUE" : "FALSE") . "<br>";

echo "<br><h3>Pruebas con funciones de cadenas</h3>";

$cadena = "Hola Mundo";
$cadena2 = "hola mundo";

echo "strlen(): " . strlen($cadena) . "<br>";
echo "strtolower(): " . strtolower($cadena) . "<br>";
echo "strcmp(): " . strcmp($cadena, $cadena2) . "<br>";

echo "<br><h3>Prueba palíndromo</h3>";
echo esPalindromo("Anita lava la tina") ? "Es palíndromo" : "No es palíndromo";

echo "<br><h3>Prueba filtrado de array</h3>";
print_r(filtrarMenores([1,5,10,3,8], 6));
?>

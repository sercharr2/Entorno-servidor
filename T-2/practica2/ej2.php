<?php

/*3 filas que representarán al Nivel básico, medio y de perfeccionamiento y 4
columnas en las que figurarán los idiomas (0 = Inglés, 1 = Francés, 2 = Alemán y 3
= Ruso)*/

$alumnos = array(

    "basico" => array(
        "ingles" => 10,
        "frances"=> 2,
        "aleman"=> 6,
        "ruso"=> 9),
    "medio" => array(
        "ingles" => 18,
       "frances"=> 9,
       "aleman"=> 5,
        "ruso"=> 4),
    "perfecionamiento" => array(
       "ingles" => 8,
        "frances"=> 10,
        "aleman"=> 22,
        "ruso"=> 3),

);

foreach ($alumnos as $nivel => $idiomas) {
    foreach ($idiomas as $idioma => $num) {
        echo "$idioma : $num | ";
    }
    echo"<br>";
}

?>
<?php

$numeros = array();

$num = 1;

for($i = 1; $i <= 10; $i++) {

    if ($num % 2 == 0) {

        array_push($numeros, $num);

    }else{$i--;}
    $num++;
}


foreach($numeros as $indice => $valor){

 echo "$valor<br>";

 }

?>
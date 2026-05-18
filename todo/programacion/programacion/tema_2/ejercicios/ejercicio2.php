

<?php

    /*Dados 3 números asignados dentro del código a mostrar el número mayor de los
    tres.*/

    $x = 1;
    $y = 2;
    $z = 3;

    $mayor = $x;

    if ($mayor < $y){
        
        $mayor = $y;
    } 

    if ($mayor < $z){
        
        $mayor = $z;
    }

    echo ("el numero mayor es: " .$mayor);
?>
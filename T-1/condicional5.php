<?php

    $a = 1;
    $b = 2;
    $c = 3;

    $resultado = ($b*2) - (4*$a*$c);

    if($resultado<0){

        echo("la ecuacion no tiene solucion");

    }elseif($resultado>0){

        echo("hay dos soluciones: \n1º: ".((-$b+sqrt($b*2-4*$a*$c))/(2*$a))."\n2º: ".((-$b*sqrt($b*2-4*$a*$c))/(2*$a)));

    }else{

        echo("tiene una solucion: ".(-$b/2*$a));

    }

?>
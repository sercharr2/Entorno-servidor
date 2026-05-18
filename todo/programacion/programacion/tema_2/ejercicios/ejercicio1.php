


<?php

    /* Dados 2 números asignados dentro del código a variables realizar el siguiente
    cálculo: si son iguales que los multiplique, si el primero es mayor que el segundo
    que los reste y si no que los sume. Mostrar el resultado en pantalla.*/ 

    $x = 5;
    $y = 6;

    if ($x == $y){

        $multiplicacion = $x *$y;
        echo ("la multiplicacion de los numeros es:" .$multiplicacion);

    }else if ($x > $y){

        $resta = $x - $y;
        echo ("la resta de los dos numeros es:" .$resta);

    }else if ($x < $y){

        $suma = $x + $y;
        echo ("la suma de los dos numeros es:" .$suma);
    }

?>
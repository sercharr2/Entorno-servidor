<?php

$num1 = rand();
$num2 = rand();

if($num1> $num2){

    echo($num1." es mayor ");

    if(($num1%2) == 0){

        echo($num1." es par");

    }

    else{

        echo($num1." es impar");

    }

}elseif($num2>$num1){

    echo($num2." es mayor ");

    if(($num2%2) == 0){

        echo($num2." es par");

    }

    else{

        echo($num2." es impar");


    }
}else{

    echo("los dos numeros son iguales");

}


?>
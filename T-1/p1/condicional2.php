<?php

$num1 = 6;
$num2 = 7;
$num3 = 4;

if($num1 > $num2){

    if($num1 > $num3){

        echo($num1." es mayor");

    }

    else{

        echo($num3." es mayor");

    }

}

else{

    if($num2 > $num3){

        echo($num2." es mayor");

    }

    else{

        echo($num3." es mayor");

    }

}

?>
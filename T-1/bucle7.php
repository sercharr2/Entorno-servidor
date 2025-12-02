<?php

for($i=1; $i<=50; $i++){

    $esPrimo = true;

    for($j=2; $j<$i; $j++){

        if($i%$j == 0){

            $esPrimo = false;

        }

    }

    if($esPrimo){

        echo($i."<br>");

    }

}

?>
<?php

    $n = rand(0,1000);
    $count = $n ; 
    $div = 0;

    while($count>0){

        if((($n%$count)==0) && $count != $n){

            $div+=$count;

            echo($count."<br>");

        }
        $count--;
    }

    if($div == $n){

        echo("es perfecto");

    }else{

        echo("no es perfecto");

    }

?>
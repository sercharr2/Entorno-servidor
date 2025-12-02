<?php

    $n = rand();
    $count = $n ; 
    $div = 0;

   while($count>0){

        if((($n%$count)==0)){

            $div+=$count;

            echo($count."<br>");

        }
        $count--;
    }

    if($div == ($n+1)){

        echo("es primo");

    }else{

        echo("no es primo");

    }

?>
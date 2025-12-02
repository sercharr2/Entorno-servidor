<?php

$horas = 49;
$pago ;

if($horas > 40){

    if(($horas - 40) <= 8){

       $pago = ($horas-40)*2;

        echo("le van ha pagar ".($pago+40)." horas");

    }

    else{

        $pago = (8*2)+(($horas-48)*3);

        echo("le van ha pagar ".($pago+40)." horas");

    }

}

else{

    echo("no hizo horas extras");

}

?>
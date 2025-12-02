<?php

$coche = array(32, 11, 45, 22, 78, -3, 9, 66, 5);

echo"$coche[5]<br>";

$importe = array( 32.583, 11.239, 45.781, 22.237);

echo"$coche[1] y $coche[3]<br>";

$confirmado = array(true, true, false, true, false, false);

if($confirmado[0] == true) {

    echo "true<br>";

}else{
    echo "false<br>";
}

$jugador= array("Crovic", "Antic", "Malic", "Zulic", "Rostrich");

echo "La alineación del equipo está compuesta por $jugador[0], $jugador[1], $jugador[2], $jugador[3] y $jugador[4]";


?>
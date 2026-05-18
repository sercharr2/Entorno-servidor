<?php

/* Declara un array de strings de nombre $jugador e introduce en él 5 elementos
que sean "Crovic", "Antic", "Malic", "Zulic" y "Rostrich". A continuación usando el
operador de concatenación haz que se muestre la frase: <<La alineación del
equipo está compuesta por Crovic, Antic, Malic, Zulic y Rostrich.>>
*/

$jugador = array("crovic", "antic", "malic", "zulic", "rostrich");

echo "La alineación del equipo está compuesta por " 
     . $jugador[0] . ", " 
     . $jugador[1] . ", " 
     . $jugador[2] . ", " 
     . $jugador[3] . " y " 
     . $jugador[4] . ".";
?>
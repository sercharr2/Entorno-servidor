<?php
$gente = array (
 array(
 'Familia' => 'Los Simpson',
 'Padre' => 'Homer',
 'Madre' => 'Marge',
 'Hijos' => array('Bart', 'Lisa' , 'Maggie')
 ),
 array(
 'Familia' => 'Los Griffin',
 'Padre' => 'Peter',
 'Madre' => 'Lois',
 'Hijos' => array('Chris', 'Meg' , 'Stewie')
 )
 );

 /* foreach ($gente as $familiares) {

    foreach ($familiares as $campo => $valor) {

        echo "$campo : <br>";

        if($campo == "Hijos"){

            foreach($valor as $hijo => $nombre){

                echo "$hijo : $nombre<br>";

            }

        }else{echo "$valor<br>";}

    }
    echo "-------------<br>";
}*/

foreach ($gente as $familiares) {
    echo "<ul>";
    foreach ($familiares as $campo => $valor) {
        if ($campo == "Hijos") {
            echo "<li>$campo:";
            echo "<ul>";
            foreach ($valor as $nombre) {
                echo "<li>$nombre</li>";
            }
            echo "</ul></li>";
        } else {
            echo "<li>$campo: $valor</li>";
        }
    }
    echo "</ul>";
    echo "<hr>";
}
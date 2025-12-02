<?php

 $paper = array("a","e","c","z","d","b");
 $number = array(9,56,9,324,745,1,532,4);

 $palabra = explode(' ', "Ricardo estupido numero 2 Marcos es el primero");
 $letra = str_split("Ricardo estupido numero 2 Marcos es el primero");


 sort($paper);
 sort($number);

foreach($paper as $indice => $valor){

 echo "$valor | ";

 }

 echo("<br>");

foreach($number as $indice => $valor){

 echo "$valor | ";

 }

 echo("<br>");
 echo("<br>");

 print_r($palabra);

    echo("<br>");
    echo("<br>");

 print_r($letra);

    echo("<br>");
    echo("<br>");

    /*
    array_find
    
    array_count
    */ 


?>
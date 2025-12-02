<?php
/* $personas = array("nombre","apellido","apellido2");


 $persona1 = array("nombre"=>"yolanda" ,"apellido"=>"iglesias" ,"apellido2"=>"suarez" );
 $persona2 = array("nombre"=>"juan" ,"apellido"=>"lopez" ,"apellido2"=>"blanco" );*/

/* $personas = array(

    $persona1 = "persona1" => array(

        "nombre"=> "yolanda",
        "apellido1"=> "igelsias",
        "apellido2"=> "suarez"

    ),
    $persona2 = "persona2" => array(

        "nombre"=> "juan",
        "apellido1"=> "lopez",
        "apellido2"=> "blanco"

    )

 );*/

/*echo("persona1:<br>");
 foreach($persona1 as $indice => $valor)
 {
 echo "$indice : $valor <br>";

 }
echo("-------------<br>");

echo("persona2:<br>");
  foreach($persona2 as $indice => $valor)
 {
 echo "$indice : $valor <br>";

 }*/

/* foreach ($personas as $indice){

    echo("<br>");

    foreach($indice as $nombres => $valor){

        echo("$nombres : $valor<br>");

    }

 }*/

// Mostrar persona1 y persona2 con sus datos
$personas = array(
    "persona1" => array(
        "nombre"=> "yolanda",
        "apellido1"=> "igelsias",
        "apellido2"=> "suarez"
    ),
    "persona2" => array(
        "nombre"=> "juan",
        "apellido1"=> "lopez",
        "apellido2"=> "blanco"
    )
);

foreach ($personas as $nombrePersona => $datosPersona) {
    echo "$nombrePersona:<br>";
    foreach ($datosPersona as $campo => $valor) {
        echo "$campo : $valor<br>";
    }
    echo "-------------<br>";
}
?>
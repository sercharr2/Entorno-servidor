<?php//bucle for
 for ($count = 1 ; $count <= 5 ; ++$count){
 echo " hellow world ";
 echo $count;
}

?> 

<?php//array de 3 dimensiones

    $persa = array(0,1,2);
    $siames = array(0,1);
        $gatos = array($siames,$persa);

    $bulldog = array(0,1,2,3);
    $caniche = array(0,1,2);
        $perros = array($bulldog,$caniche);

    $animales = array($perros,$gatos);
?> 
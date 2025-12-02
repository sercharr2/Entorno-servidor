<?php

switch($_POST['operacion']) {

    case 'suma':
        $resultado = $_POST['num1'] + $_POST['num2'];
        echo("El resultado de la suma es: ".$resultado);
        break;
    case 'resta':
        $resultado = $_POST['num1'] - $_POST['num2'];
        echo("El resultado de la resta es: ".$resultado);
        break;
    case 'multiplicacion':
        $resultado = $_POST['num1'] * $_POST['num2'];
        echo("El resultado de la multiplicacion es: ".$resultado);
        break;
    case 'division':
        $resultado = $_POST['num1'] / $_POST['num2'];
        echo("El resultado de la division es: ".$resultado);
        break;


}
 
?>
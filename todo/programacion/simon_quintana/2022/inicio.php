<?php
session_start();

require_once 'pinta-circulos.php';

if(isset($_SESSION['nombre'])){

    $usuario = $_SESSION['nombre'];

    $colors = ["green","red","blue","yellow"];

    $solucion = [];

    for($i = 0; $i < 4; $i++){
        $solucion[$i] = $colors[rand(0,3)];
    }

    $_SESSION['solucion'] = $solucion;

} else {

    header("Location: index.php");

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1><strong>SIMÓN</strong></h1>
    <?php
        if($usuario != ""){
            echo "<h2 style='font-weight:bold;'>Hola $usuario, memoriza la combinación</p> <br>";
        } 
        echo pintarCirculos($solucion);
    ?>
    <form action="jugar.php" method="post">
        <button type="submit">Jugar</button>
    </form>
</body>
</html>
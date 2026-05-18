<?php

session_start();

require_once 'pinta-circulos.php';
$nombre = $_SESSION['nombre'];
$solucion = $_SESSION['solucion'];
if(!isset($_SESSION['jugada'])){

    $_SESSION['jugada'] = [];

} 

$colorPrin = ["black","black","black","black"];

if(isset($_POST['color'])){

    $_SESSION['jugada'][] = $_POST['color'];

}

for($i = 0; $i < count($_SESSION['jugada']); $i++){

    $colorPrin[$i] = $_SESSION['jugada'][$i];

    }

if(count($_SESSION['jugada']) == 4){

    if($_SESSION['jugada'] == $solucion){

        header("Location: acierto.php");
        $_SESSION['jugada'] = [];

    } else if($_SESSION['jugada'] != $solucion){

        header("Location: fallo.php");
    }

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
    <form action="jugar.php" method="post">
    <h1><strong>SIMÓN</strong></h1>
    <?php
        echo "<h2 style='font-weight:bold;'>$nombre pulsa los botones en el orden correspondiente</p> <br>";
        echo pintarCirculos($colorPrin);
    ?>
    
        <br>
        <button type="submit" value="red" name="color" style="background-color: red;">ROJO</button>
        <button type="submit" value="blue" name="color" style="background-color: red;">AZUL</button>
        <button type="submit" value="yellow" name="color" style="background-color: red;">AMARILLO</button>
        <button type="submit" value="green" name="color" style="background-color: red;">VERDE</button>
    </form>
</body>
</html>
<?php
if (isset($_POST['incrementar'])) {


    session_start();
    $usuario = $_SESSION['usuario'];
    $contador = $_SESSION['contador'];
    $random = $_SESSION['random'];
    $emojis = $_SESSION['emojis'];

    array_push($random , rand(0,4));

    echo <<<_END
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de la agenda</title>
    <style>
    
        div{ border: 1px solid black;}

    </style>
</head>
<body>
    <h1> Agenda:</h1>
    <br>
    
    <div>
        <p>Hola $usuario, cuanros contactos deseas grabar?</p>
        <br>
        <p>Puedes grabar entre 1 y 5. Por cada pulsación en Incrementar grabarás un usuario más.</p>
        <br>
        <p>cuando el numero sea el deseado pulsa Grabar.</p>
    </div>
    <div>
_END;

    for ($i = 0; $i < 5; $i++) {
        
        if ($random[0] == 0) {

            echo $emojis[0];

        } else if ($random[1] == 1) {

            echo $emojis[1];

        } else if ($random[2] == 2) {

            echo $emojis[2];

        } else if ($random[3] == 3) {

            echo $emojis[3];

        } else if ($random[4] == 4) {

            echo $emojis[4];

        }
    }

    echo <<<_END
    </div>
    <form method="post" action="inicio.php">
            <input type="submit" value = "incrementar" name="incrementar">
    </form>
    <form method="post" action="agenda.php">
            <input type="submit" value = "grabar">
    </form>
_END;


} else {

    session_start();
    $usuario = $_SESSION['usuario'];
    $emojis = [
        "<img src='./materiales/OIP0.jfif' alt='5'>",
        "<img src='./materiales/OIP1.jfif' alt='5'>",
        "<img src='./materiales/OIP2.jfif' alt='5'>",
        "<img src='./materiales/OIP3.jfif' alt='5'>",
        "<img src='./materiales/OIP4.jfif' alt='5'>"
    ];

    $random = [];
    array_push($random , rand(0,4));
    $contador = 1;

    $_SESSION['contador'] = $contador;
    $_SESSION['random'] = $random;
    $_SESSION['emojis'] = $emojis;


    echo <<<_END
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de la agenda</title>
    <style>
    
        div{ border: 1px solid black;}

    </style>
</head>
<body>
    <h1> Agenda:</h1>
    <br>
    
    <div>
        <p>Hola $usuario, cuanros contactos deseas grabar?</p>
        <br>
        <p>Puedes grabar entre 1 y 5. Por cada pulsación en Incrementar grabarás un usuario más.</p>
        <br>
        <p>cuando el numero sea el deseado pulsa Grabar.</p>
    </div>
    <div>
_END;

    for ($i = 0; $i < 5; $i++) {
        
        if ($random[0] == 0) {

            echo $emojis[0];

        } else if ($random[1] == 1) {

            echo $emojis[1];

        } else if ($random[2] == 2) {

            echo $emojis[2];

        } else if ($random[3] == 3) {

            echo $emojis[3];

        } else if ($random[4] == 4) {

            echo $emojis[4];

        }
    }

    echo <<<_END
    </div>
    <form method="post" action="inicio.php">
            <input type="submit" value = "incrementar" name="incrementar">
    </form>
    <form method="post" action="agenda.php">
            <input type="submit" value = "grabar">
    </form>
_END;
}

?>
<?php
session_start();
include "pintar-circulos.php";

//asegurarse de que jugada esta creado
if (!isset($_SESSION['jugada'])) {
    $_SESSION['jugada'] = [];
}

//guardar colores en el array jugada
if (isset($_POST['color'])) {
    $color = $_POST['color'];
    $_SESSION['jugada'][] = $color;
}



//pintar circulos segun botones pulsados
if (count($_SESSION['jugada']) !== 4) {
        $colores = ['black', 'black', 'black', 'black'];
            for ($i = 0; $i < count($_SESSION['jugada']); $i++) {
                $colores[$i] = $_SESSION['jugada'][$i];
            }
        pintar_circulos($colores[0], $colores[1], $colores[2], $colores[3]);
}



//llamar script de respuesta
if(count($_SESSION['jugada']) === 4){
    if ($_SESSION['jugada'] === $_SESSION['combinacioncorrecta']) {
        header("Location: acierto.php");
        exit();
    } else {
        header("Location: fallo.php");
        exit();
    }
   
}


echo <<<_END
<html>
    <body>
        <h1>SIMÓN</h1>
            <h2>Pulsa los botones en el orden correspondiente</h2>
_END;


echo <<<_END
    <form action="jugar.php" method="post">
        <input type="submit" name="color" value="red" style=background-color:red>
        <input type="submit" name="color" value="green" style=background-color:green>
        <input type="submit" name="color" value="blue" style=background-color:blue>
        <input type="submit" name="color" value="yellow" style=background-color:yellow>
    </form>
    </body>
</html>
_END;





?>
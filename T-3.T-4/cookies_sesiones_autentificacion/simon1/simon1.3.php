<?php
if (isset($_POST["finalizar"])) {

    session_start();
    $colores = $_SESSION['color'];
    $circulos = $_SESSION['circulo'];
    $respuesta = $_SESSION['respuesta'];
    $acierto = true;


    for ($i = 0; $i < 4; $i++) {

        if ($acierto) {

            if ($respuesta[$i] == $colores[$i]) {

                $acierto = true;

            } else
                $acierto = false;

        }else{$i = 4;}



    }
    if ($acierto) {

        echo <<<_END
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Simón</h1>
        <h2> acertaste !!!!</h2> 
_END;
    } else {

        echo <<<_END
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Simón</h1>
        <h2> Fallaste :(</h2> 
_END;

    
    echo "<div style='display:flex; gap:10px; align-items:center;'>";
    echo "<p>secuencia original: </p>";

    for ($z = 0; $z < 4; $z++) {

        if ($colores[$z] == 0) {

            echo $circulos[0];

        } else if ($colores[$z] == 1) {

            echo $circulos[1];

        } else if ($colores[$z] == 2) {

            echo $circulos[2];

        } else if ($colores[$z] == 3) {

            echo $circulos[3];

        } else if ($colores[$z] == 4) {
            echo $circulos[4];
        }
    }

    echo "</div> <br>";

    echo "<div style='display:flex; gap:10px; align-items:center;'>";
    echo "<p>tu secuencia: </p>";

    for ($z = 0; $z < 4; $z++) {

        if ($respuesta[$z] == 0) {

            echo $circulos[0];

        } else if ($respuesta[$z] == 1) {

            echo $circulos[1];

        } else if ($respuesta[$z] == 2) {

            echo $circulos[2];

        } else if ($respuesta[$z] == 3) {

            echo $circulos[3];

        } else if ($respuesta[$z] == 4) {
            echo $circulos[4];
        }
    }
 }

    echo "</div>";

    echo <<<_END
    <br>
    <form method="get" action="simon1.php" style="margin-top:16px;">
    <button type="submit">Volver a jugar</button>
    </form>

_END;



}
?>
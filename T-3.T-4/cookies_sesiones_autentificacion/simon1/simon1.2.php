<?php
if (isset($_POST["rojo"]) || isset($_POST["azul"]) || isset($_POST["amarillo"]) || isset($_POST["verde"])) {

    session_start();
    $colores = $_SESSION['color'];
    $circulos = $_SESSION['circulo'];
    $respuesta = $_SESSION['respuesta'];
    $i = $_SESSION['bucle']++;

    if($i >= 4) {

        $_SESSION['bucle']--;

    }

        if (isset($_POST["rojo"])) {

            $respuesta[$i] = 0;

        } else if (isset($_POST["azul"])) {

            $respuesta[$i] = 1;

        } else if (isset($_POST["amarillo"])) {

            $respuesta[$i] = 2;

        } else if (isset($_POST["verde"])) {

            $respuesta[$i] = 3;

        }
        $_SESSION['respuesta'] = $respuesta;

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
        <h2> pulsa los botones en el orden correspondiente:</h2> 
_END;

        echo "<div style='display:flex; gap:10px; align-items:center;'>";

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

        echo "</div>";

        echo <<<_END
    <br>
    <form method="post" action="simon1.2.php">

        <input type="submit" value = "rojo" name = "rojo">
        <input type="submit" value = "azul" name = "azul">
        <input type="submit" value = "amarillo" name = "amarillo">
        <input type="submit" value = "verde" name = "verde">
        
        
    </form>
    <br><br>
    <form method="post" action="simon1.3.php">
        <input type="submit" value = "finalizar" name = "finalizar">
    </form>


_END;
    }
 else {

    session_start();
    $colores = $_SESSION['color'];
    $circulos = $_SESSION['circulo'];

    $respuesta = [4, 4, 4, 4];
    $_SESSION['respuesta'] = $respuesta;

    $j = 0;
    $_SESSION['bucle'] = $j;

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
        <h2> pulsa los botones en el orden correspondiente:</h2> 
_END;

    echo "<div style='display:flex; gap:10px; align-items:center;'>";

    for ($i = 0; $i < 4; $i++) {

        if ($respuesta[$i] == 0) {

            echo $circulos[0];

        } else if ($respuesta[$i] == 1) {

            echo $circulos[1];

        } else if ($respuesta[$i] == 2) {

            echo $circulos[2];

        } else if ($respuesta[$i] == 3) {

            echo $circulos[3];

        } else if ($respuesta[$i] == 4) {
            echo $circulos[4];
        }
    }

    echo "</div>";

    echo <<<_END
    <br>
    <form method="post" action="simon1.2.php">

        <input type="submit" value = "rojo" name = "rojo">
        <input type="submit" value = "azul" name = "azul">
        <input type="submit" value = "amarillo" name = "amarillo">
        <input type="submit" value = "verde" name = verde>
    </form>

_END;
}


?>
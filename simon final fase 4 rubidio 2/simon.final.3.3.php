<?php
if (isset($_POST["finalizar"])) {

    session_start();
    $colores = $_SESSION['color'];
    $circulos = $_SESSION['circulo'];
    $respuesta = $_SESSION['respuesta'];
    $acierto = true;

    $nombre = $_SESSION['nombre'];
    $clave = $_SESSION['clave'];
    $codigo = $_SESSION['codigo'];

    $conn = new mysqli('localhost', 'root', '', 'bdsimon');
    if ($conn->connect_error)
        die("Fatal Error");


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
    <title>Simon final</title>
</head>
<body>
    <h1>Simón</h1>
        <h2> acertaste $nombre !!!!</h2> 
_END;

    $query = "INSERT INTO `jugadas` (`codigousu`, `acierto`) VALUES ($codigo, '1')";
    $result = $conn->query($query);
    if (!$result)
        die("Fatal Error");

    } else {

        echo <<<_END
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simon final</title>
</head>
<body>
    <h1>Simón</h1>
        <h2> Fallaste $nombre :(</h2> 
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
    echo "<p>secuencia de  $nombre: </p>";

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

     $query = "INSERT INTO `jugadas` (`codigousu`, `acierto`) VALUES ($codigo, '0')";
    $result = $conn->query($query);
    if (!$result)
        die("Fatal Error");

 }

    echo "</div>";

    echo <<<_END
    <br>
    <form method="get" action="simon.final.php" style="margin-top:16px;">
    <button type="submit">Volver a jugar</button>
    </form>
    <form method="get" action="estadisticas.php" style="margin-top:16px;">
    <button type="submit">Ver estadisticas</button>
    </form>

_END;



}
?>
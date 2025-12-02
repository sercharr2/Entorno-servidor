<?php
session_start();

// recuperar datos de sesión (con valores por defecto seguros)
$colores = isset($_SESSION['color']) ? $_SESSION['color'] : [];
$circulos = isset($_SESSION['circulo']) ? $_SESSION['circulo'] : [];
$respuesta = isset($_SESSION['respuesta']) ? $_SESSION['respuesta'] : [];
$cantidadCirculo = isset($_SESSION['cantidadCirculo']) ? intval($_SESSION['cantidadCirculo']) : max( count($colores), count($respuesta) );
$botones = isset($_SESSION['botones']) ? $_SESSION['botones'] : [];

if (isset($_POST["finalizar"])) {

    // comprobar acierto: comparar posición por posición
    $acierto = true;
    for ($i = 0; $i < $cantidadCirculo; $i++) {
        $esperado = isset($colores[$i]) ? intval($colores[$i]) : null;
        $dado = isset($respuesta[$i]) ? intval($respuesta[$i]) : null;

        // si falta respuesta o no coincide, marcar como fallo
        if ($dado === null || $dado !== $esperado) {
            $acierto = false;
            break;
        }
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

    
    echo "<div style='display:flex; gap:10px; align-items:center; flex-wrap: wrap;'>";
    echo "<p>secuencia original: </p>";

    for ($z = 0; $z < $cantidadCirculo; $z++) {

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

    echo "<div style='display:flex; gap:10px; align-items:center; flex-wrap: wrap;'>";
    echo "<p>tu secuencia: </p>";

    for ($z = 0; $z < $cantidadCirculo; $z++) {

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
    <form method="get" action="dificultad.simon.2.php" style="margin-top:16px;">
    <button type="submit">Volver a jugar</button>
    </form>

_END;




}
else{

    session_start();
    
    $colores = $_SESSION['color'];
    $circulos = $_SESSION['circulo'];
    $cantidadCirculo = $_SESSION['cantidadCirculo'];
    $cantidadColor = $_SESSION['cantidadColor'];
    $respuesta = $_SESSION['respuesta'];
    $botones = $_SESSION['botones'];
    $i = $_SESSION['bucle']++;
    
    if($i >= $cantidadCirculo) {

        $_SESSION['bucle']--;

    }

    // inicializar array de visualización de círculos si no existe
    if (!isset($_SESSION['circuloDisplay'])||$i==0) {
        $display = [];
        for ($p = 0; $p < $cantidadCirculo; $p++) {
            $display[$p] = $circulos[0]; // círculo negro por defecto
        }
        $_SESSION['circuloDisplay'] = $display;
    }
    $display = $_SESSION['circuloDisplay'];

    // detectar qué botón dinámico se pulsó (keys en $_SESSION['colorR'])
    $foundIndex = null;
    $colorR = isset($_SESSION['colorR']) ? $_SESSION['colorR'] : [];

    for ($k = 0; $k < count($colorR); $k++) {
        $btnName = $colorR[$k];
        if (isset($_POST[$btnName])) {
            $foundIndex = $k;
            break;
        }
    }

    // si se ha pulsado un color válido, guardarlo y actualizar el círculo correspondiente
    if ($foundIndex !== null && $i < $cantidadCirculo) {
        // guardamos 1..N para que coincida con $_SESSION['color'] (que usa 1..cantidadColor)
        $respuesta[$i] = $foundIndex + 1;

        // el array $circulos tiene el color en la posición $foundIndex+1
        $circuloIndex = $foundIndex + 1;
        if (isset($circulos[$circuloIndex])) {
            $display[$i] = $circulos[$circuloIndex];
        }

        $_SESSION['circuloDisplay'] = $display;
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

    echo "<div style='display:flex; gap:10px; align-items:center; flex-wrap: wrap;'>";

    // mostrar los círculos actuales (izquierda a derecha)
    for ($k = 0; $k < $cantidadCirculo; $k++) {
        echo $display[$k];
    }

    echo "</div>";
    echo "$i";

    echo <<<_END
    <br>
    <form method="post" action="simon3.3.php">

    _END;

        for ($i = 0; $i < count($botones); $i++) {

        echo"$botones[$i]";

    }
        
   echo<<<_END
    </form>
    <br><br>
    <form method="post" action="simon3.3.php">
        <input type="submit" value = "finalizar" name = "finalizar">
    </form>
_END;  
    
}
?>
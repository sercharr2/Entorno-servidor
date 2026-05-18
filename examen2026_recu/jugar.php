<?php
session_start();
    require_once 'db.php';

    if (!isset($_SESSION['login'])) {
        header("Location: entrada.php");
        exit();
    }

if(isset($_POST["girar"])){

    $simbolos=$_SESSION["simbolos"];
    $r1=$_SESSION["r1"];
    $r2=$_SESSION["r2"];
    $r3=$_SESSION["r3"];
    $puntosGanados=$_SESSION["puntosGanado"];
    $_SESSION["tiradas"]++;
    $login = $_SESSION['login'];
    $tiradas=$_SESSION["tiradas"];

    // Generar tres tiradas aleatorios usando rand()
    $r1 = $simbolos[rand(1, count($simbolos)-1)];  //se usa -1 porque el array tiene 5 elementos pero va del 0-4, si saliera de numero random el 5, daria error
    $r2 = $simbolos[rand(1, count($simbolos)-1)];
    $r3 = $simbolos[rand(1, count($simbolos)-1)];

    // Lógica extendida
if ($r1 == $r2 && $r2 == $r3) {
    // Tres iguales → premio distinto según símbolo
    $puntosGanados += 10;
    $resultado = 1;

    } elseif ($r1 == $r2 || $r1 == $r3 || $r2 == $r3) {
        // Dos iguales → premio según símbolo repetido
        $puntosGanados += 5;
        $resultado = 1;

    }else {
        // Ninguna combinación
        $puntosGanados += -1;
        $resultado = 0;
    }

    echo "<h1>Bienvenid@, $login:</h1>";

    echo<<<_END
        <h2>Puntos ganados en esta partida: $puntosGanados</h2>
        <h3>Tiradas: $tiradas</h3>
    _END;

// Mostrar resultado en pantalla
    echo "<h1>Resultado:</h1>";
    echo "<img src='$r1' width='150'> <img src='$r2' width='150'> <img src='$r3' width='150'>";

    echo<<<_END
        <form method="post" action="jugar.php">
                <input type="submit" name="girar" value="girar">
        </form>

        <form method="post" action="resultado">
            <input type="submit" value="cobrar/actualizar puntos">
        </form>
    _END;

    $_SESSION["puntosGanado"] = $puntosGanados;
    

}else{

    // Array de imágenes disponibles (colócalas en una carpeta del proyecto)
    $simbolos = ["cubierta.png","fruta0.png","fruta1.png","fruta2.png","fruta3.png"];

    $r1 = $simbolos[0];
    $r2 = $simbolos[0];
    $r3 = $simbolos[0];

    $login = $_SESSION['login'];
    // Mostrar resultado en pantalla
    $puntosGanados = 0;
    $tiradas = 0 ;   // variable para calcular puntos
    echo "<h1>Bienvenid@, $login:</h1>";

    echo<<<_END
        <h2>Puntos ganados en esta partida: $puntosGanados</h2>
        <h3>Tiradas: $tiradas</h3>
    _END;

    echo "<img src='$r1' width='150'> <img src='$r2' width='150'> <img src='$r3' width='150'>";

    echo<<<_END
        <form method="post" action="jugar.php">
                <input type="submit" name="girar" value="Girar Maquina">
        </form>
    _END;

    $_SESSION["simbolos"]=$simbolos;
    $_SESSION["r1"]=$r1;
    $_SESSION["r2"]=$r2;
    $_SESSION["r3"]=$r3;
    $_SESSION["puntosGanado"]=$puntosGanados;
    $_SESSION["tiradas"] = $tiradas;

}

?>
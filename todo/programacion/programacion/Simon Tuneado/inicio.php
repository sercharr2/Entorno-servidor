<?php

session_start();

unset($_SESSION['colores-escogidos']);
unset($_SESSION['colores-correctos']); 

if (!isset($_POST['numero']) || !isset($_POST['numero-colores'])) {
    echo "Error: No se han recibido los datos del formulario.";
    exit;
}

$_SESSION['numero'] = intval($_POST['numero']);
$_SESSION['numero-colores'] = intval($_POST['numero-colores']);

$todos_colores = array('red','blue','yellow','green','purple','orange','pink','brown');

//seleccionamos solo los colores permitidos por el jugador
$colores_disponibles=array_slice($todos_colores,0,$_SESSION['numero-colores']);
for ($i = 0; $i < $_SESSION['numero']; $i++) {
    $_SESSION['colores-correctos'][$i] = $colores_disponibles[rand(0,count ($colores_disponibles)-1)];
}

echo <<<_END
<html>
    <body>
        <h1>SIMÓN</h1>
            <h2>Memoriza la combinación</h2>

_END;

require 'pintar_circulos.php';
pintar_circulos($_SESSION['colores-correctos']);


echo <<<_END
    <form action="jugar.php" method="post">
        <input type="submit" name="submit" value="Vamos a jugar">
    </form>
    </body>
</html>
_END;
?>
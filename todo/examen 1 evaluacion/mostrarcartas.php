<?php

session_start();
require_once('autenticacion.php');


if (!isset($_SESSION['login'])) {
    header("Location: autentificacion.php");
    exit();
}
if (isset($_SESSION['login'])) {
    $login=$_SESSION['login'];

    $query="SELECT nombre FROM jugador WHERE login='$login'";
    $result=$connection->query($query);
    $row=$result->fetch_assoc();
    $nombre=$row['nombre'];
}else{
    $nombre=$login;
}

    if (isset($_POST['solucion'])) {
    $solucion = $_POST['solucion'];
    $hoy = date("Y-m-d");   
    $hora = date("H:i:s");  

    }


$connection->close();

echo <<<_END
<html>
    <body>
        <h1>BIENVENID@ $nombre</h1>
            <form action="jugar.php" method="post">
                <h2>Cartas levantadas:</h2>
                <input type="text" name="cartas"><br><br>

                <input type="submit" formaction="registro.php" value="levantar carta 1">
                <input type="submit" formaction="registro.php" value="levantar carta 2">
                <input type="submit" formaction="registro.php" value="levantar carta 3">
                <input type="submit" formaction="registro.php" value="levantar carta 4">
                <input type="submit" formaction="registro.php" value="levantar carta 5">
                <input type="submit" formaction="registro.php" value="levantar carta 6">

                <h2>pareja:</h2>
                <input type="text" name="carta1">
                <input type="text" name="carta2">
                <input type="submit" formaction="registro.php" value="Comprobar">

            </form>
            <p>$error</p>
    </body>
</html>
_END;

/*
  function colocar_cartas($c1, $c2, $c3, $c4, $c5, $c6) {
    $colores = array($c1, $c2, $c3, $c4, $c5, $c6);

        $random = rand(1, 3);

        switch($random){
        case 1: 
            echo "<img src="imagenes/copas_03.jpg" alt="3copas" width="500" height="500">";
            echo "<img src="imagenes/copas_02.jpg" alt="2copas" width="500" height="500">";
            echo "<img src="imagenes/copas_02.jpg" alt="2copas" width="500" height="500">";
            echo "<img src="imagenes/copas_03.jpg" alt="3copas" width="500" height="500">";
            echo "<img src="imagenes/copas_05.jpg" alt="5copas" width="500" height="500">";
            echo "<img src="imagenes/copas_05.jpg" alt="5copas" width="500" height="500">";

        case 2:
            echo "<img src="imagenes/copas_02.jpg" alt="2copas" width="500" height="500">";
            echo "<img src="imagenes/copas_02.jpg" alt="2copas" width="500" height="500">";
            echo "<img src="imagenes/copas_05.jpg" alt="5copas" width="500" height="500">";
            echo "<img src="imagenes/copas_03.jpg" alt="3copas" width="500" height="500">";
            echo "<img src="imagenes/copas_05.jpg" alt="5copas" width="500" height="500">";
            echo "<img src="imagenes/copas_03.jpg" alt="3copas" width="500" height="500">";

        case 3:
            echo "<img src="imagenes/copas_02.jpg" alt="2copas" width="500" height="500">";
            echo "<img src="imagenes/copas_03.jpg" alt="3copas" width="500" height="500">";
            echo "<img src="imagenes/copas_05.jpg" alt="5copas" width="500" height="500">";
            echo "<img src="imagenes/copas_05.jpg" alt="5copas" width="500" height="500">";
            echo "<img src="imagenes/copas_03.jpg" alt="3copas" width="500" height="500">";
            echo "<img src="imagenes/copas_02.jpg" alt="2copas" width="500" height="500">";
        
      }

    
}
 */

?>
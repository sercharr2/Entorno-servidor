<?php
session_start();

require_once 'pinta-circulos.php';

$solucion = $_SESSION['solucion'];
$usuario = $_SESSION['nombre'];
$codigouser = $_SESSION['codigousu'];
require_once 'login.php';

$conn = new mysqli($hn, $un, $pw, $db);
if ($conn->connect_error) die("Error fatal de conexión");

$sql = "INSERT INTO jugadas (codigousu, acierto) VALUES ($codigouser, 1)";

$conn->query($sql);

if(isset($_POST['accion'])){

    if($_POST['accion'] == "jugar"){
        unset($_SESSION['solucion']);
        unset($_SESSION['jugada']);
        header("Location: inicio.php");
    } else {
        header("Location: estadisticas.php");
    }
}

?>

<form method="post">

    <h1><strong>SIMÓN</strong></h1>
    <?php
        if($usuario != ""){
            echo "<h2 style='font-weight:bold;'>$usuario enhorabuena, has acertado</p> <br>";
        } 
        echo pintarCirculos($solucion);
    ?>
        <button type="submit" name="accion" value="jugar">Volver a jugar</button>
        <button type="submit" name="accion" value="estadistica">Estadisticas</button>

</form>
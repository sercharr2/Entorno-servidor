<?php
session_start();
$hn = 'localhost';
$db = 'jerogrifico';
$un = 'jugador';       // ahora sí existe
$pw = '';   // la contraseña que le diste
$connection = new mysqli($hn, $un, $pw, $db);


if (!isset($_SESSION['login'])) {
    header("Location: index.php");
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

echo <<<_END
<html>
    <body>
        <h3>Bienvenido $nombre. !</h3>
    <img src="imagen/20240216.jpg" alt="Jerogrifico del dia">
    <form method="post" action="inicio.php">
        <label>Solución al jerogrífico:</label>
        <input type="text" name="solucion" required>
        <input type="submit"  value="Enviar">
    </form>

    <a href="">Ver puntos por jugador</a>
    <a href="">Resultados del día</a>
    </body>
</html>
_END;
?>
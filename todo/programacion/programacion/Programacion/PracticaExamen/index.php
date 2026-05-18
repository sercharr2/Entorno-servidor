<?php
session_start();
$hn = 'localhost';
$db = 'agenda';
$un = 'root';
$pw = '';



$connection = new mysqli($hn, $un, $pw, $db);
 if ($connection->connect_error) die("Fatal Error");

 $error='';


 if (isset($_POST['submit'])) {
    if (!empty($_POST['nombre']) && !empty($_POST['clave'])){
    $nombre = $_POST['nombre'];
    $_SESSION['usuario'] = $nombre;
     $clave = $_POST['clave'];

     $query = "SELECT * FROM usuarios WHERE Nombre = '$nombre' AND Clave = '$clave'";
     $result = $connection->query($query);
     if (!$result) die("Fatal Error");
     $rows = $result->num_rows;
     if ($rows == 1) {
         $_SESSION['nombre'] = $nombre;
         header("Location: inicio.php");
         exit();
     }else {
         $error = "Usuario o contraseña incorrectos";
     }
    $result->close();

    }
 }

    $connection->close();
echo <<<_END
<html>
    <body>
        <h1>AGENDA</h1>
            <h2>Ingresa tus datos</h2>
            <form action="index.php" method="post">
                <label for="nombre">Usuario:</label><br>
                <input type="text" name="nombre"><br><br>
                <label for="clave">Clave:</label><br>
                <input type="password" name="clave"><br><br>
                <input type="submit" name="submit" value="Entrar">
            </form>
            <p>$error</p>
    </body>
</html>
_END;  
<?php
session_start();

$hn = 'localhost';
$db = 'jerogrifico';
$un = 'jugador';
$pw = '';



$connection = new mysqli($hn, $un, $pw, $db);
 if ($connection->connect_error) die("Fatal Error");

 $error='';


 if (isset($_POST['submit'])) {
    if (!empty($_POST['login']) && !empty($_POST['clave'])){
    $login = $_POST['login'];
    $_SESSION['login'] = $login;
     $clave = $_POST['clave'];

     $query = "SELECT * FROM jugador WHERE login = '$login' AND clave = '$clave'";
     $result = $connection->query($query);
     if (!$result) die("Fatal Error");
     $rows = $result->num_rows;
     if ($rows == 1) {
         $_SESSION['login'] = $login;
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
        <h1>Iniciar sesión</h1>
            <form action="index.php" method="post">
                <label for="login">Usuario:</label><br>
                <input type="text" name="login"><br><br>
                <label for="clave">Contraseña:</label><br>
                <input type="password" name="clave"><br><br>
                <input type="submit" name="submit" value="Entrar">
            </form>
            <p>$error</p>
    </body>
</html>
_END;
?>
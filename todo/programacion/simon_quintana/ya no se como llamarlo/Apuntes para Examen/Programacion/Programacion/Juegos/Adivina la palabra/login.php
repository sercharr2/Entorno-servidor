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
    $login = $_POST['login'];
    $clave = $_POST['clave'];

    // Comprobar si usuario existe
    $query = "SELECT * FROM jugador WHERE login='$login' AND clave='$clave'";
    $result = $connection->query($query);

    if ($result->num_rows == 1) {
        $_SESSION['login'] = $login;
        header("Location: inicio.php");
        exit();
    } else {
        $error = "Usuario o contraseña incorrectos";
    }
}
?>
<html>
<body>
<h1>Adivina la Palabra </h1>
<form method="post" action="index.php">
    Usuario: <input type="text" name="login"><br>
    Clave: <input type="password" name="clave"><br>
    <input type="submit" name="submit" value="Entrar">
</form>
<p style="color:red;"><?php echo $error; ?></p>
</body>
</html>

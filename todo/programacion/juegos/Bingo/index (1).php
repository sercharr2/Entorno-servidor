<?php
session_start();

$hn = 'localhost';
$db = 'bdoposicion'; 
$un = 'root';
$pw = '';
$connection = new mysqli($hn, $un, $pw, $db);

if ($connection->connect_error) die("Fatal Error");

$mensaje = ""; 

$error = '';

if (isset($_POST['submit'])) {
    if (!empty($_POST['login']) && !empty($_POST['clave'])) {
        $login = $_POST['login'];
        $clave = $_POST['clave'];

        $query = "SELECT * FROM jugador WHERE login='$login' AND clave='$clave'";
        $result = $connection->query($query);

        if ($result->num_rows == 1) {
            $_SESSION['login'] = $login;
            header("Location: inicio.php");
            exit();
        } else {
            $error = "Usuario o contraseña incorrectos";
        }
    } else {
        $error = "Debes introducir usuario y contraseña";
    }
}
?>

<html>
<body>
    <h1>Bingo </h1>
    <form action="index.php" method="post">
        Usuario: <input type="text" name="login"><br><br>
        Clave: <input type="password" name="clave"><br><br>
        <input type="submit" name="submit" value="Entrar">
    </form>
    <p style="color:red;"><?php echo $error; ?></p>
</body>
</html>

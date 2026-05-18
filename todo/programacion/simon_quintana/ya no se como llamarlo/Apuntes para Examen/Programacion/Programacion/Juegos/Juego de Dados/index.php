<?php
session_start();
$hn = 'localhost';
$db = 'memoria';   // nombre de la BD
$un = 'jugador';   // usuario de la BD
$pw = '';          // contraseña

$connection = new mysqli($hn, $un, $pw, $db);
if ($connection->connect_error) die("Fatal Error");
$error = '';

// Si el formulario se ha enviado
if (isset($_POST['submit'])) {
    // Comprobamos que los campos no estén vacíos
    if (!empty($_POST['login']) && !empty($_POST['clave'])) {
        $login = $_POST['login'];
        $clave = $_POST['clave'];

        // Consulta a la tabla jugador para validar credenciales
        $query = "SELECT * FROM jugador WHERE login='$login' AND clave='$clave'";
        $result = $connection->query($query);

        // Si existe un usuario con esas credenciales
        if ($result->num_rows == 1) {
            // Guardamos el login en la sesión
            $_SESSION['login'] = $login;

            // Redirigimos al inicio del juego
            header("Location: inicio.php");
            exit();
        } else {
            // Si no coincide, mostramos error
            $error = "Usuario o contraseña incorrectos";
        }
        $result->close();
    } else {
        $error = "Debes introducir usuario y contraseña";
    }
}
$connection->close();
?>

<html>
<body>
    <h1>Juego de los Dados </h1>
    <form action="index.php" method="post">
        Usuario: <input type="text" name="login"><br><br>
        Clave: <input type="password" name="clave"><br><br>
        <input type="submit" name="submit" value="Entrar">
    </form>
    <p style="color:red;"><?php echo $error; ?></p>
</body>
</html>
?>
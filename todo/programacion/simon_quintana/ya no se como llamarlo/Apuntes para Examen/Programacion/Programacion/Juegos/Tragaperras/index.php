<?php
session_start();

$hn = 'localhost';
$db = 'tragaperras';   // nombre de la BD
$un = 'jugador';       // usuario de la BD
$pw = '';              // contraseña

// Crear conexión con MySQL
$connection = new mysqli($hn, $un, $pw, $db);

// Si falla la conexión, se muestra error y se corta el programa
if ($connection->connect_error) die("Error de conexión");
$error = '';

if (isset($_POST['submit'])) {
    if (!empty($_POST['login']) && !empty($_POST['clave'])) {
        $login = $_POST['login'];
        $clave = $_POST['clave'];

        // Consulta a la tabla jugador para validar credenciales
        $query = "SELECT * FROM jugador WHERE login='$login' AND clave='$clave'";
        $result = $connection->query($query);

        if ($result->num_rows == 1) {
            // Guardamos usuario en sesión
            $_SESSION['login'] = $login;

            // Redirigimos al inicio del juego
            header("Location: inicio.php");
            exit();
        } else {
            $error = "Usuario o contraseña incorrectos";
        }
        $result->close();
    }
}
$connection->close();
?>
<html>
<body>
    <h1>Iniciar sesión</h1>
    <form action="index.php" method="post">
        Usuario: <input type="text" name="login"><br><br>
        Clave: <input type="password" name="clave"><br><br>
        <input type="submit" name="submit" value="Entrar">
    </form>
    <p><?php echo $error; ?></p>
</body>
</html>

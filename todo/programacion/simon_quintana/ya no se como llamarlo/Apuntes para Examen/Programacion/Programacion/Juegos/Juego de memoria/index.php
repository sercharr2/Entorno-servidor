<?php
session_start();
$hn = 'localhost';
$db = 'memoria';   // nombre de la BD
$un = 'jugador';   // usuario de la BD
$pw = '';          // contraseña

$connection = new mysqli($hn, $un, $pw, $db);
if ($connection->connect_error) die("Fatal Error");
$error = '';

if (isset($_POST['submit'])) {
    if (!empty($_POST['login']) && !empty($_POST['clave'])) {
        $login = $_POST['login'];
        $clave = $_POST['clave'];

        $query = "SELECT * FROM jugador WHERE login='$login' AND clave='$clave'";
        $result = $connection->query($query);

        if ($result->num_rows == 1) {
            $_SESSION['login'] = $login;

            // Inicializar mazo con rand()
            $imagenes = ["img1","img1","img2","img2","img3","img3","img4","img4"];
            $_SESSION['mazo'] = [];

            while (count($imagenes) > 0) {
                $pos = rand(0, count($imagenes)-1);       // índice aleatorio
                $_SESSION['mazo'][] = $imagenes[$pos];    // añadir carta al mazo
                array_splice($imagenes, $pos, 1);         // eliminar carta usada
            }

            $_SESSION['levantadas'] = []; // cartas levantadas

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

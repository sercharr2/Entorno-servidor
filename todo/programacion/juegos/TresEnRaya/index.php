<?php
session_start();

$hn = 'localhost';
$db = 'tresenraya';   // nombre de la BD (ajústalo al examen)
$un = 'jugador';      // usuario de la BD
$pw = '';             // contraseña

$connection = new mysqli($hn, $un, $pw, $db);
if ($connection->connect_error) die("Fatal Error");


$error = '';


if (isset($_POST['submit'])) {
    if (!empty($_POST['login']) && !empty($_POST['clave'])) {
        $login = $_POST['login'];
        $clave = $_POST['clave'];

        $query = "SELECT * FROM jugador WHERE login='$login' AND clave='$clave'";
        $result = $connection->query($query);
        if (!$result) die("Fatal Error");

        if ($result->num_rows == 1) {
            $_SESSION['login'] = $login;

            // Inicializar tablero vacío con un bucle for
            $_SESSION['tablero'] = [];
            for ($i=0; $i<9; $i++) {
                $_SESSION['tablero'][$i] = ""; //cada casilla empieza vacia
            }

            // Turno inicial → el usuario juega con "X"
            $_SESSION['turno'] = "X";

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
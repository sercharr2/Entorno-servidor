<?php
session_start();

// Datos de conexión a la base de datos
$hn = 'localhost';   // servidor
$db = 'ahorcado';    // nombre de la base de datos (ajústalo al examen)
$un = 'jugador';     // usuario de la BD
$pw = '';            // contraseña del usuario

// Crear conexión con MySQL
$connection = new mysqli($hn, $un, $pw, $db);

// Si falla la conexión, se muestra error y se corta el programa
if ($connection->connect_error) die("Fatal Error");

$error = ''; //variable para mostrar mensahes de error

// Si se ha pulsado el botón "Entrar"
if (isset($_POST['submit'])) {
    //comprobar que ls campos no esten vacios
    if (!empty($_POST['login']) && !empty($_POST['clave'])) {
        $login = $_POST['login']; //usuario introducir
        $clave = $_POST['clave']; //clave instroducida

        //consulta a la tabla jugador para validar credenciales
        $query = "SELECT * FROM jugador WHERE login='$login' AND clave='$clave'";
        $result = $connection->query($query);
        if (!$result) die("Fatal Error");

        //si existe un usuario con esas credenciales
        if ($result->num_rows == 1) {
            $_SESSION['login'] = $login; //guardar usuario en sesion
            $_SESSION['palabra'] = "la que sea"; //palabra a adivinar
            $_SESSION['progreso'] = str_repeat("_", strlen($_SESSION['palabra'])); //giones bajos
            $_SESSION['fallos'] = 0; //contador de fallos
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


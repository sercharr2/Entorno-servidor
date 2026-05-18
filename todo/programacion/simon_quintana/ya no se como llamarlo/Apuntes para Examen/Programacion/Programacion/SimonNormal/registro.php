<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$hn = 'localhost';
$db = 'bdsimon';
$un = 'root';
$pw = '';

$connection = new mysqli($hn, $un, $pw, $db);
if ($connection->connect_error) die("Error de conexión");

$error = '';

if (isset($_POST['submit'])) {
    if (!empty($_POST['usuario']) && !empty($_POST['clave']) && !empty($_POST['clave2'])) {
        $usuario = $_POST['usuario'];
        $clave = $_POST['clave'];
        $clave2 = $_POST['clave2'];

        if ($clave !== $clave2) {
            $error = "Las contraseñas no coinciden";
        } else {
            $query = "SELECT * FROM usuarios WHERE Nombre = '$usuario'";
            $result = $connection->query($query);
            if (!$result) die("Error en la consulta");

            if ($result->num_rows == 0) {
                $query2 = "INSERT INTO usuarios (Nombre, Clave) VALUES ('$usuario', '$clave')";
                if (!$connection->query($query2)) die("Error al crear el usuario");
                header("Location: login.php");
                exit();
            } else {
                $error = "El usuario ya existe";
            }
            $result->close();
        }
    } else {
        $error = "Por favor, completa todos los campos";
    }
}

echo <<<_END
<html>
    <body>
        <h1>SIMÓN</h1>
        <h2>Crear cuenta</h2>
        <form action="registro.php" method="post">
            <label for="usuario">Usuario:</label><br>
            <input type="text" name="usuario"><br><br>
            <label for="clave">Contraseña:</label><br>
            <input type="password" name="clave"><br><br>
            <label for="clave2">Repetir contraseña:</label><br>
            <input type="password" name="clave2"><br><br>
            <input type="submit" name="submit" value="Enviar">
            <p style="color:red;">$error</p>
        </form>
    </body>
</html>
_END;
?>

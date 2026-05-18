<?php
    session_start();
    if(isset($_POST["boton"])){
        $nombre = $_POST["usuario"] ?? '';
        $clave = $_POST["clave"] ?? '';

        // Datos de conexión
        $hn = 'localhost';
        $db = 'jeroglifico';
        $un = 'jugador';
        $pw = '';

        $conn = new mysqli($hn, $un, $pw, $db);
        if ($conn->connect_error) die("Error de conexión: " . $conn->connect_error);

        $sql = "SELECT * FROM jugador WHERE login = ? AND clave = ?;";
        $stmt = $conn->prepare($sql); 
        $stmt->bind_param("ss", $nombre, $clave);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if($resultado->num_rows == 1){
            $_SESSION["usuario"] = $nombre;
            header("Location: inicio.php");
            exit;
        } else {
            echo "Credenciales Incorrectas. Intentelo de nuevo";
        }

    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jeroglifico</title>
</head>
<body>
    <h1>Iniciar Sesion</h1>
    <form action="index.php" method="post">
            <label for="usuario">Usuario: </label>
            <input type="text" id="usuario" name="usuario">

            <br><br>
            <label for="clave">Contraseña: </label>
            <input type="password" id="clave" name="clave">

            <br><br>
            <input type="submit" name="boton" value="Entrar">
    </form>
</body>
</html>
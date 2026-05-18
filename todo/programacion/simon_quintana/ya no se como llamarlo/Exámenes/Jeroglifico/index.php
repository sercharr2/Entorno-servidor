<?php

function sanitizeString($var)
{
    $var = strip_tags($var);
    $var = htmlentities($var);
    $var = stripslashes($var);
    return $var;
}

require_once 'login.php';

$conn = new mysqli($hn, $un, $pw, $db);
if ($conn->connect_error) die("Fatal Error");

$error = "";

if(isset($_POST['usuario']) && isset($_POST['contraseña'])){
    if(empty($_POST['usuario']) || empty($_POST['contraseña'])){
        $error = "Por favor, complete todos los campos.";
    } else {
        $usuario = sanitizeString($_POST['usuario']);
        $contraseña = sanitizeString($_POST['contraseña']);

        $sql = "SELECT * FROM jugador WHERE login=? AND clave=?";

        $stmt = $conn->prepare($sql);

        $stmt->bind_param('ss', $usuario, $contraseña);

        $stmt->execute();

        $result = $stmt->get_result();

        if($result->num_rows > 0){
            $filas = $result->fetch_assoc();
            session_start();
            $_SESSION['usuario'] = $usuario;
            $_SESSON['contraseña'] = $contraseña;
            $_SESSION['nombre'] = $filas['nombre'];
            header("Location: inicio.php");
            exit();
        } else if($_SERVER["REQUEST_METHOD"] == "POST"){
            $error = "Usuario o contraseña incorrectos";
        }
    }
    
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>INICIAR SESION</h1><br>
    <form method="post">
        <?php if($error != "") echo "<p style='color: red;'>$error</p><br>"  ?>
        Usuario: <input type="text" name="usuario"><br><br>
        Contraseña: <input type="password" name="contraseña"><br><br>
        <input type="submit" value="Iniciar Sesion">
        
    </form>
</body>
</html>
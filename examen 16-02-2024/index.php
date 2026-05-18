<?php

if (isset($_POST["usuario"]) && $_POST["contrasenia"]) {

    session_start();
    $_SESSION['usuario'] = htmlspecialchars($_POST['usuario'], ENT_QUOTES);
    $_SESSION['contrasenia'] = htmlspecialchars($_POST['contrasenia'], ENT_QUOTES);
    $inicioConfirmado = false;

    $conn = new mysqli('localhost:3307', 'jugador', '', 'jeroglifico');
    if ($conn->connect_error)
        die("Fatal Error");

    $query = "SELECT login, clave, nombre FROM jugador";
    $result = $conn->query($query);
    if (!$result)
        die("Fatal Error");

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if ($row['login'] == $_SESSION['usuario'] && $row['clave'] == $_SESSION['contrasenia']) {
                $inicioConfirmado = true;
                $_SESSION["nombre"] = $row["nombre"];
            }
        }
    }

    $conn->close();

    if ($inicioConfirmado) {
        header("Location: inicio.php");
        exit();
    } else {
        echo <<<_END
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de sesión</title>
</head>
<body>
    <h1>Iniciar sesión</h1>
    <p style="color:red;">Credenciales incorrectas. Inténtalo de nuevo.</p>
    <form method="post" action="index.php">
        <label>Usuario:</label>
        <input type="text" name="usuario" required>
        <br><br>
        <label>Contraseña:</label>
        <input type="password" name="contrasenia" required>
        <br><br>
        <input type="submit" value="Entrar">
    </form>
</body>
</html>
_END;
    }

} else {

    echo <<<_END
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de sesión</title>
</head>
<body>
    <h1>Iniciar sesión</h1>
    <form method="post" action="index.php">
        <label>Usuario:</label>
        <input type="text" name="usuario" required>
        <br><br>
        <label>Contraseña:</label>
        <input type="password" name="contrasenia" required>
        <br><br>
        <input type="submit" value="Entrar">
    </form>
</body>
</html>
_END;
}
?>

<?php

if (isset($_POST["inicio"])) {

    $usuario    = $_POST["usuario"];
    $contrasenia = $_POST["contrasenia"];

    // Conexión con root para verificar credenciales y obtener el rol
    $conn = new mysqli('localhost', 'root', '', 'entrada');
    if ($conn->connect_error)
        die("Fatal Error");

    $query  = "SELECT rol FROM usuarios WHERE usuario = '$usuario' AND contrasena = '$contrasenia'";
    $result = $conn->query($query);

    if ($result->num_rows == 0) {

        // Usuario o contraseña incorrectos
        echo <<<_END
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <p style="color:red;">*usuario o contraseña fallidos</p>
    <form method="post" action="ejercicio3.php">
        <label>Usuario:</label>
        <input type="text" name="usuario">
        <br><br>
        <label>Contraseña:</label>
        <input type="password" name="contrasenia">
        <br><br>
        <input type="submit" name="inicio" value="Iniciar sesión">
    </form>
</body>
</html>
_END;

    } else {

        // Obtener el rol del usuario
        $row = $result->fetch_assoc();
        $rol = $row['rol'];
        $conn->close();

        // Conectarse como el usuario de BD correspondiente al rol
        // Las contraseñas de los usuarios BD son: consultor→consultor123, grabador→grabador123
        $passRol = ($rol == 'consultor') ? 'consultor123' : 'grabador123';
        $conn2 = new mysqli('localhost', $rol, $passRol, 'entrada');
        if ($conn2->connect_error)
            die("Fatal Error");

        // Intentar insertar un nuevo registro
        $queryInsert = "INSERT INTO usuarios (usuario, contrasena, nombre, apellidos, email, rol) 
                        VALUES ('Sergio', '123', 'Sergio', 'Charro', 'sss@gmail.com', 'consultor')";

        // Activar excepciones para capturar errores de permisos
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        try {
            $conn2->query($queryInsert);
            echo "<p style='color:green;'>Añadido correctamente</p>";
        } catch (\mysqli_sql_exception $e) {
            echo "<p style='color:red;'>*No tienes permisos para realizar esta operación</p>";
        }

        $conn2->close();
    }

} else {

    echo <<<_END
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <form method="post" action="ejercicio3.php">
        <label>Usuario:</label>
        <input type="text" name="usuario">
        <br><br>
        <label>Contraseña:</label>
        <input type="password" name="contrasenia">
        <br><br>
        <input type="submit" name="inicio" value="Iniciar sesión">
    </form>
</body>
</html>
_END;
}
?>

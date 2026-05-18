<?php
    session_start();

    $hn = 'localhost';
    $db = 'agenda';
    $un = 'root';
    $pw = '';

    $conn = new mysqli($hn, $un, $pw, $db);
    if ($conn->connect_error) die("Error de conexión: " . $conn->connect_error);

    $sql = "SELECT Codigo FROM usuarios WHERE Nombre = ?";
    $stmt = $conn->prepare($sql);
    if(!$stmt){
        die("Error en prepare: " . $conn->error);
    }
    $stmt->bind_param("s", $_SESSION["nombre"]);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $usuario = $resultado->fetch_assoc();
    $codUsuario = $usuario["Codigo"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda</title>
</head>
<body>
    <h1>Agenda</h1>
    <?php
        echo "Hola " .$_SESSION["nombre"];
    ?>
    <form method="post">
        <?php
            for ($i = 0; $i < $_SESSION["contador"]; $i++) {
                echo "<h3>Contacto " . ($i + 1) . "</h3>";
                echo 'Nombre: <input type="text" name="nombre'.$i.'"><br>';
                echo 'Email: <input type="email" name="email'.$i.'"><br>';
                echo 'Teléfono: <input type="text" name="telefono'.$i.'"><br><br>';
            }

            if(isset($_POST["grabar"])){
                for($i=0; $i < $_SESSION["contador"]; $i++){
                    $nombre = $_POST["nombre$i"] ?? "";
                    $email = $_POST["email$i"] ?? "";
                    $telefono = $_POST["telefono$i"] ?? "";

                    $sqlInsert = "INSERT INTO contactos (nombre, email, telefono, codusuario) VALUES (?, ?, ?, ?)";
                    $stmtInsert = $conn->prepare($sqlInsert);
                    if(!$stmtInsert){
                        die("Error en prepare de INSERT: " . $conn->error);
                    }
                    $stmtInsert->bind_param("sssi", $nombre, $email, $telefono, $codUsuario);

                    if(!$stmtInsert->execute()){
                        echo "Error al ejecutar INSERT: " . $stmtInsert->error . "<br>";
                    } else {
                        echo "Datos Guardados Correctamente<br>";
                    }
                }
                header("Location: grabado.php");
            }
        ?>
        <br>
        <input type="submit" name="grabar" value="Grabar">
    </form>
</body>
</html>
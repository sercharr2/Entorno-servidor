<?php
    session_start();
    if(isset($_POST["boton"])){
        $dni = $_POST["dni"] ?? '';
        $_SESSION["dni"] = $dni;

        // Datos de Conexion 
        $hn = 'localhost';
        $db = 'oposicion';
        $un = 'root';
        $pw = '';

        $conn = new mysqli($hn, $un, $pw, $db);
        if ($conn->connect_error) die("Error de conexión: " . $conn->connect_error);

        // Buscar Alumno
        $sql = "SELECT * FROM alumno WHERE dniA = ?;";
        $stmt = $conn->prepare($sql);
        if($stmt){
            $stmt-> bind_param("s", $dni);
            $stmt->execute();
            $resultado = $stmt->get_result();

            if($resultado->num_rows == 1){
                $row = $resultado->fetch_assoc();
                $_SESSION["nombre"] = $row['nombreA'] ?? '';
                $stmt->close();
                $conn->close();
                header("Location: ejercicio3.php");
                exit;
            }
            $stmt->close();
        }

        // Buscar Profesor
        $sql = "SELECT * FROM profesor WHERE dniP = ?;";
        $stmt = $conn->prepare($sql);
        if($stmt){
            $stmt-> bind_param("s", $dni);
            $stmt->execute();
            $resultado = $stmt->get_result();

            if($resultado->num_rows == 1){
                $row = $resultado->fetch_assoc();
                $_SESSION["nombre"] = $row['nombreP'] ?? '';
                $stmt->close();
                $conn->close();
                header("Location: ejercicio2.php");
                exit;
            }
            $stmt->close();
        }
        if($resultado->num_rows == 0){
            echo "<p>DNI no encontrado</p>";
        }
        $conn->close();
    }
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio1</title>
</head>
<body>
    <form action="ejercicio1.php" method="post">
        <label for="dni">DNI: </label>
        <input type="text" id="dni" name="dni">

        <br><br>
        <input type="submit" name="boton" value="Entrar">
    </form>
</body>
</html>
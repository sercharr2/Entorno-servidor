<?php
session_start();
require_once 'datos_oposicion.php';

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $DNI = trim($_POST['DNI']);

    // Conexión a la base de datos
    $conn = new mysqli($hn, $un, $pw, $db);
    if ($conn->connect_error) die("Error al conectar: " . $conn->connect_error);

    // Consulta en alumno
    $query1 = "SELECT * FROM alumno WHERE dniA = '$DNI'";
    $result1 = $conn->query($query1);

    // Consulta en profesor
    $query2 = "SELECT * FROM profesor WHERE dniP = '$DNI'";
    $result2 = $conn->query($query2);

    if ($result1 && $result1->num_rows === 1) {
        $_SESSION['dni'] = $DNI;
        $_SESSION['rol'] = 'alumno';
        header("Location: ejercicio2.php"); // módulo matricular
        exit;
    } elseif ($result2 && $result2->num_rows === 1) {
        $_SESSION['dni'] = $DNI;
        $_SESSION['rol'] = 'profesor';
        header("Location: ejercicio2.php"); // módulo cursos impartidos
        exit;
    } else {
        $errors[] = "DNI incorrecto o usuario no existente.";
    }

    $conn->close();
}   

?>

<!DOCTYPE html>
<html>
<head>
<title>Validación DNI</title>
</head>
<body>
<div class="container">
    <div class="d-flex min-vh-100">
        <div class="col-md-4 form login-form">
        <?php
        // Mostrar errores
        if (!empty($errors)) {
            echo '<p style="color:red;">' . implode('<br>', $errors) . '</p>';
        }
        ?>
        <form action="" method="POST" autocomplete="off">
            <div class="contenedor" style="border:1px double black; padding:10px; display:flex; flex-direction:column; width:200px;">
                <div class="form-group mb-3">
                    <label>DNI:</label><br>
                    <input type="text" name="DNI" class="form-control" style=" border-radius: 5px; border-color: lightblue;" placeholder="DNI" required>
                </div>
                <br>
                <div class="form-group mb-3" style="display: flex; justify-content: flex-end; ">
                    <input type="submit" class="form-control btn btn-primary" style="background-color: lightblue; border-radius: 5px;" value="Entrar">
                </div>
            </div>
        </form>
        </div>
    </div>
</div>
</body>
</html>

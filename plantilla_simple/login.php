<?php

if (isset($_POST["dni"])) {

    session_start();
    $_SESSION['dni'] = $_POST['dni'];

    $conn = new mysqli('localhost', 'root', '', 'oposicion');
    if ($conn->connect_error)
        die("Error al conectar");

    // Buscar en alumno
    $query = "SELECT * FROM alumno WHERE dniA = '{$_SESSION['dni']}'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $_SESSION['rol'] = 'alumno';
        header("Location: ejercicio.php");
        exit;
    }

    // Buscar en profesor
    $query = "SELECT * FROM profesor WHERE dniP = '{$_SESSION['dni']}'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $_SESSION['rol'] = 'profesor';
        header("Location: ejercicio.php");
        exit;
    }

    $error = "DNI no encontrado";
    $conn->close();
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 400px;
        }
        h1 { color: #333; text-align: center; margin-bottom: 30px; }
        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        input[type="submit"] {
            background: #667eea;
            color: white;
            cursor: pointer;
            font-weight: bold;
        }
        input[type="submit"]:hover { background: #764ba2; }
        .error { color: red; margin-bottom: 15px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Iniciar Sesión</h1>
        
        <?php if (isset($error)): ?>
            <p class="error">❌ <?php echo $error; ?></p>
        <?php endif; ?>
        
        <form method="post" action="">
            <input type="text" name="dni" placeholder="Ingrese su DNI" required autofocus>
            <input type="submit" value="Entrar">
        </form>
    </div>
</body>
</html>

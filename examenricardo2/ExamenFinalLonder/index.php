<?php
session_start();

require 'conexion.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['usuario'];
    $clave  = $_POST['password'];

    if (!empty($nombre) && !empty($clave)) {
        $sql  = "SELECT id, usuario, password, rol FROM usuarios WHERE usuario = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $nombre);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows == 1) {
            $usuario = $resultado->fetch_assoc();

            if ($clave === $usuario['password']) {
                $_SESSION['usuario'] = $usuario['usuario'];
                $_SESSION['id']      = $usuario['id'];
                $_SESSION['rol']     = $usuario['rol']; // Guardamos el rol en sesión
                $stmt->close();
                header("Location: inicio.php");
                exit();
            } else {
                $error = "Usuario o contraseña incorrectos.";
            }
        } else {
            $error = "Usuario o contraseña incorrectos.";
        }
        $stmt->close();
    } else {
        $error = "Todos los campos son obligatorios.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .form-container { max-width: 400px; margin: 100px auto; }
    </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-6">
            <div class="form-container bg-white shadow p-4 rounded-2">
                <h2 class="text-center mb-3">Iniciar Sesión</h2>

                <?php if (!empty($error)): ?>
                    <p class="text-center text-danger">
                        <span>&#10007;</span> <?php echo htmlspecialchars($error); ?>
                    </p>
                <?php endif; ?>

                <form method="POST">
                    <div class="mb-3">
                        <label for="usuario" class="form-label">Usuario:</label>
                        <input type="text" class="form-control" name="usuario" id="usuario" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña:</label>
                        <input type="password" class="form-control" name="password" id="password" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Entrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>

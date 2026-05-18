<?php
session_start();

// Si no hay sesión activa, redirigir al login
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

require 'conexion.php';

$usuario_sesion = $_SESSION['usuario'];
$rol            = $_SESSION['rol'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
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
                <h2 class="text-center mb-3">
                    Bienvenido, <?php echo htmlspecialchars($usuario_sesion); ?>!
                </h2>

                <?php if ($rol === "director"): ?>
                    <p class="text-center">Tu perfil es de <strong>director/a</strong></p>
                    <a href="insertar_notas.php" class="btn btn-primary w-100 mb-3">&#10010; Insertar Nota</a>
                    <a href="mostrar_notas.php"  class="btn btn-primary w-100 mb-3">&#128221; Mostrar Notas</a>
                <?php else: ?>
                    <p class="text-center">Tu perfil es de <strong>alumno/a</strong></p>
                    <a href="resultado_alumno.php" class="btn btn-primary w-100 mb-3">&#128203; Ver Mis Notas</a>
                <?php endif; ?>

                <a href="index.php" class="btn btn-danger w-100 mb-3">&#128275; Cerrar Sesión</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>

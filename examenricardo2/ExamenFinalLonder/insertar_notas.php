<?php
session_start();

// Si no hay sesión activa, redirigir al login
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

require 'conexion.php';

$mensaje = "";
$tipo_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_alumno  = trim($_POST['id_alumno']);
    $asignatura = trim($_POST['asignatura']);
    $fecha      = trim($_POST['fecha']);
    $nota       = trim($_POST['nota']);

    // a) Validar que no hay campos vacíos
    if (empty($id_alumno) || empty($asignatura) || empty($fecha) || empty($nota)) {
        $mensaje      = "Todos los campos son obligatorios.";
        $tipo_mensaje = "danger";

    // a) Validar que la nota esté entre 0 y 10
    } elseif (!is_numeric($nota) || $nota < 0 || $nota > 10) {
        $mensaje      = "La nota debe ser un número entre 0 y 10.";
        $tipo_mensaje = "danger";

    } else {
        // b) Comprobar que quien inserta tiene rol director
        $rol_sesion = $_SESSION['rol'];
        if ($rol_sesion !== "director") {
            $mensaje      = "Usted no es director, no puede insertar.";
            $tipo_mensaje = "danger";

        } else {
            // c) y d) Comprobar existencia del alumno en ambas tablas
            $existe_usuarios = false;
            $existe_alumnos  = false;

            $sql_u = "SELECT id FROM usuarios WHERE id = ?";
            $stmt_u = $conn->prepare($sql_u);
            $stmt_u->bind_param("i", $id_alumno);
            $stmt_u->execute();
            $res_u = $stmt_u->get_result();
            if ($res_u->num_rows > 0) {
                $existe_usuarios = true;
            }
            $stmt_u->close();

            $sql_a = "SELECT id FROM alumnos WHERE id = ?";
            $stmt_a = $conn->prepare($sql_a);
            $stmt_a->bind_param("i", $id_alumno);
            $stmt_a->execute();
            $res_a = $stmt_a->get_result();
            if ($res_a->num_rows > 0) {
                $existe_alumnos = true;
            }
            $stmt_a->close();

            // e) No existe en ninguna tabla
            if (!$existe_usuarios && !$existe_alumnos) {
                $mensaje      = "El alumno NO existe en la tabla alumnos y tampoco en usuarios.";
                $tipo_mensaje = "danger";

            // c) No existe en usuarios
            } elseif (!$existe_usuarios) {
                $mensaje      = "El alumno NO existe en la tabla usuarios.";
                $tipo_mensaje = "danger";

            // d) No existe en alumnos
            } elseif (!$existe_alumnos) {
                $mensaje      = "El alumno NO existe en la tabla alumnos.";
                $tipo_mensaje = "danger";

            } else {
                // f) Insertar la nota correctamente
                $sql_ins = "INSERT INTO notas (alumno, asignatura, fecha, nota) VALUES (?, ?, ?, ?)";
                $stmt_ins = $conn->prepare($sql_ins);
                $stmt_ins->bind_param("issd", $id_alumno, $asignatura, $fecha, $nota);

                if ($stmt_ins->execute()) {
                    $mensaje      = "Nota insertada correctamente.";
                    $tipo_mensaje = "success";
                } else {
                    $mensaje      = "Error al insertar: " . $conn->error;
                    $tipo_mensaje = "danger";
                }
                $stmt_ins->close();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insertar Nota</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .form-container { max-width: 400px; margin: 80px auto; }
    </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-6">
            <div class="form-container bg-white shadow p-4 rounded-2">
                <h2 class="text-center mb-3">Insertar Nota</h2>

                <?php if (!empty($mensaje)): ?>
                    <div class="alert alert-<?php echo $tipo_mensaje; ?>" role="alert">
                        <?php echo htmlspecialchars($mensaje); ?>
                    </div>
                <?php endif; ?>

                <form method="POST">
                    <div class="mb-3">
                        <label for="id_alumno" class="form-label">ID del Alumno:</label>
                        <input type="number" class="form-control" name="id_alumno" id="id_alumno" required>
                    </div>
                    <div class="mb-3">
                        <label for="asignatura" class="form-label">Asignatura:</label>
                        <input type="text" class="form-control" name="asignatura" id="asignatura" required>
                    </div>
                    <div class="mb-3">
                        <label for="fecha" class="form-label">Fecha:</label>
                        <input type="date" class="form-control" name="fecha" id="fecha" required>
                    </div>
                    <div class="mb-3">
                        <label for="nota" class="form-label">Nota (0-10):</label>
                        <input type="number" step="0.01" min="0" max="10" class="form-control" name="nota" id="nota" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Insertar Nota</button>
                    </div>
                </form>

                <div class="mt-3">
                    <a href="inicio.php" class="btn btn-secondary w-100">&#8592; Volver</a>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>

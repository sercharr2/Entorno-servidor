<?php
session_start();

// Si no hay sesión activa, redirigir al login
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

require 'conexion.php';

// a) Comprobar que quien accede tiene rol alumno
$rol = $_SESSION['rol'];
if ($rol !== "alumno") {
    echo "<!DOCTYPE html><html lang='es'><head><meta charset='UTF-8'>
          <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css' rel='stylesheet'>
          </head><body><div class='container mt-5'>
          <div class='alert alert-danger'>Usted no es alumno, no puede acceder a este listado.</div>
          <a href='inicio.php' class='btn btn-secondary'>&#8592; Volver</a>
          </div></body></html>";
    exit();
}

// b) Obtener el nombre del alumno logueado
$id_usuario = $_SESSION['id'];

$sql_nombre = "SELECT CONCAT(nombre, ' ', apellidos) AS nombre_completo FROM alumnos WHERE id = ?";
$stmt_nombre = $conn->prepare($sql_nombre);
$stmt_nombre->bind_param("i", $id_usuario);
$stmt_nombre->execute();
$res_nombre = $stmt_nombre->get_result();
$alumno_data = $res_nombre->fetch_assoc();
$nombre_alumno = $alumno_data ? $alumno_data['nombre_completo'] : $_SESSION['usuario'];
$stmt_nombre->close();

// c) Obtener las notas del alumno logueado
$sql_notas = "SELECT asignatura, nota FROM notas WHERE alumno = ? ORDER BY asignatura";
$stmt_notas = $conn->prepare($sql_notas);
$stmt_notas->bind_param("i", $id_usuario);
$stmt_notas->execute();
$res_notas = $stmt_notas->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Notas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        thead th { background-color: #6f42c1; color: white; text-align: center; }
        tbody tr:nth-child(odd)  { background-color: #f3eeff; }
        tbody tr:nth-child(even) { background-color: #ffffff; }
        td, th { text-align: center; vertical-align: middle; }
        .container { max-width: 600px; }
    </style>
</head>
<body>
<div class="container mt-5">
    <!-- b) Mostrar el nombre del alumno -->
    <h2 class="text-center mb-4">
        <?php echo htmlspecialchars($nombre_alumno); ?>, tus notas son:
    </h2>

    <!-- c) Mostrar el listado de notas -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Asignatura</th>
                <th>Nota</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($res_notas->num_rows > 0): ?>
                <?php while ($fila = $res_notas->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($fila['asignatura']); ?></td>
                        <td><?php echo number_format($fila['nota'], 2); ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="2" class="text-center text-muted">No tienes notas registradas.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <?php $stmt_notas->close(); ?>

    <div class="text-center mt-3">
        <a href="inicio.php" class="btn btn-secondary">&#8592; Volver</a>
    </div>
</div>
</body>
</html>

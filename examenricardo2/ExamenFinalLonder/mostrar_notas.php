<?php
session_start();

// Si no hay sesión activa, redirigir al login
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

require 'conexion.php';

// a) Comprobar que quien accede tiene rol director
$rol = $_SESSION['rol'];
if ($rol !== "director") {
    echo "<!DOCTYPE html><html lang='es'><head><meta charset='UTF-8'>
          <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css' rel='stylesheet'>
          </head><body><div class='container mt-5'>
          <div class='alert alert-danger'>Usted no es director, no puede ver las notas de los alumnos.</div>
          <a href='inicio.php' class='btn btn-secondary'>&#8592; Volver</a>
          </div></body></html>";
    exit();
}

// b) Obtener todas las asignaturas distintas (columnas de la matriz)
$sql_asig   = "SELECT DISTINCT asignatura FROM notas ORDER BY asignatura";
$res_asig   = $conn->query($sql_asig);
$asignaturas = [];
while ($fila = $res_asig->fetch_assoc()) {
    $asignaturas[] = $fila['asignatura'];
}

// Obtener todos los alumnos ordenados por apellidos
$sql_alum  = "SELECT id, CONCAT(apellidos, ', ', nombre) AS nombre_completo FROM alumnos ORDER BY apellidos";
$res_alum  = $conn->query($sql_alum);
$alumnos   = [];
while ($fila = $res_alum->fetch_assoc()) {
    $alumnos[] = $fila;
}

// c) Obtener todas las notas en un array bidimensional [id_alumno][asignatura] = nota
$sql_notas  = "SELECT alumno, asignatura, nota FROM notas";
$res_notas  = $conn->query($sql_notas);
$notas      = [];
while ($fila = $res_notas->fetch_assoc()) {
    $notas[$fila['alumno']][$fila['asignatura']] = number_format($fila['nota'], 2);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notas de los Alumnos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        thead th { background-color: #6f42c1; color: white; text-align: center; }
        tbody tr:nth-child(odd)  { background-color: #f3eeff; }
        tbody tr:nth-child(even) { background-color: #ffffff; }
        td, th { text-align: center; vertical-align: middle; }
        td:first-child { text-align: left; font-weight: 500; }
    </style>
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center mb-4">Notas de los Alumnos</h2>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Alumno</th>
                    <?php foreach ($asignaturas as $asig): ?>
                        <th><?php echo htmlspecialchars($asig); ?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($alumnos as $alumno): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($alumno['nombre_completo']); ?></td>
                        <?php foreach ($asignaturas as $asig): ?>
                            <td>
                                <?php
                                    $id = $alumno['id'];
                                    echo isset($notas[$id][$asig]) ? $notas[$id][$asig] : '-';
                                ?>
                            </td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="text-center mt-3">
        <a href="inicio.php" class="btn btn-secondary">&#8592; Volver</a>
    </div>
</div>
</body>
</html>

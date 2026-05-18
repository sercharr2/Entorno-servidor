<?php
session_start();
require_once('conexion.php');

// Verificar si el alumno está logueado
if (!isset($_SESSION['login'])) {
    header("Location: entrada.php");
    exit();
}

$login = $_SESSION['login'];
$mensaje = '';
$error = '';
$dni = '';
$codigo_curso = '';

// Obtener el DNI del alumno logueado desde la BD
$stmt = $conn->prepare("SELECT dni FROM jugador WHERE login = ?");
$stmt->bind_param("s", $login);
$stmt->execute();
$result = $stmt->get_result();
if ($row = $result->fetch_assoc()) {
    $dni = $row['dni'];
} else {
    die("Error: No se pudo obtener el DNI del alumno.");
}
$stmt->close();

// Procesar el formulario cuando se envía
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $codigo_curso = trim($_POST['codigo_curso'] ?? '');

    // Validación: campo no vacío
    if (empty($codigo_curso)) {
        $error = "El código del curso no puede estar vacío.";
    } else {
        // Comprobar si el código de curso existe en la tabla cursos
        $stmt = $conn->prepare("SELECT codigo FROM cursos WHERE codigo = ?");
        $stmt->bind_param("s", $codigo_curso);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 0) {
            $error = "El código de curso '$codigo_curso' no existe.";
            $codigo_curso = ''; // Vaciar el campo
        } else {
            // Intentar insertar la matrícula
            $stmt->close();
            $insert = $conn->prepare("INSERT INTO matriculas (dni_alumno, codigo_curso) VALUES (?, ?)");
            $insert->bind_param("ss", $dni, $codigo_curso);
            if ($insert->execute()) {
                $mensaje = "La matrícula del alumno $dni en el curso $codigo_curso se ha realizado correctamente.";
                $codigo_curso = ''; // Limpiar campo tras éxito
            } else {
                // Posible error: clave duplicada (ya matriculado) u otro
                if ($conn->errno == 1062) {
                    $error = "El alumno ya está matriculado en este curso.";
                } else {
                    $error = "El proceso no se ha podido realizar. Error: " . $conn->error;
                }
            }
            $insert->close();
        }
        if (isset($stmt)) $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Matriculación</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; }
        .form-group { margin-bottom: 15px; }
        label { display: inline-block; width: 120px; font-weight: bold; }
        input[type="text"] { padding: 5px; width: 200px; }
        input[type="submit"] { padding: 8px 20px; background: #007bff; color: white; border: none; cursor: pointer; }
        .error { color: red; margin-bottom: 15px; }
        .success { color: green; margin-bottom: 15px; }
    </style>
</head>
<body>
    <h2>Matriculación en Cursos</h2>
    <p>Alumno logueado: <strong><?php echo htmlspecialchars($login); ?></strong></p>

    <?php if ($mensaje): ?>
        <div class="success"><?php echo htmlspecialchars($mensaje); ?></div>
    <?php endif; ?>
    <?php if ($error): ?>
        <div class="error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="form-group">
            <label for="dni">DNI:</label>
            <input type="text" id="dni" name="dni" value="<?php echo htmlspecialchars($dni); ?>" readonly>
        </div>
        <div class="form-group">
            <label for="codigo_curso">Código Curso:</label>
            <input type="text" id="codigo_curso" name="codigo_curso" value="<?php echo htmlspecialchars($codigo_curso); ?>" required>
        </div>
        <input type="submit" value="Matricular">
    </form>
    <p><a href="mostrarcartas.php">Volver al juego</a></p>
</body>
</html>
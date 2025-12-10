<?php
/**
 * EJEMPLO PRÁCTICO COMPLETO
 * Sistema de gestión de cursos y matrículas
 * Similar al ejercicio2.php pero usando las plantillas
 */

session_start();
require_once 'plantilla_validacion.php';  // Importar validador

// =============== VARIABLES GLOBALES ===============
$hn = 'localhost';
$un = 'root';
$pw = '';
$db = 'oposicion';

// =============== CONEXIÓN ===============
$conn = new mysqli($hn, $un, $pw, $db);
if ($conn->connect_error) {
    die("Error al conectar: " . $conn->connect_error);
}

// =============== VERIFICAR SESIÓN ===============
if (!isset($_SESSION['dni'])) {
    // Si no está logueado, procesar login
    $errors = [];
    $dni = $_POST['dni'] ?? '';
    
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
        
        if (empty($dni)) {
            $errors[] = "DNI es obligatorio";
        } else {
            // Buscar en alumno
            $query = "SELECT * FROM alumno WHERE dniA = '$dni'";
            $result = $conn->query($query);
            
            if ($result && $result->num_rows === 1) {
                $_SESSION['dni'] = $dni;
                $_SESSION['rol'] = 'alumno';
                $conn->close();
                header("Location: " . $_SERVER['PHP_SELF']);
                exit;
            }
            
            // Buscar en profesor
            $query = "SELECT * FROM profesor WHERE dniP = '$dni'";
            $result = $conn->query($query);
            
            if ($result && $result->num_rows === 1) {
                $_SESSION['dni'] = $dni;
                $_SESSION['rol'] = 'profesor';
                $conn->close();
                header("Location: " . $_SERVER['PHP_SELF']);
                exit;
            }
            
            $errors[] = "DNI no encontrado";
        }
    }
    
    // Si no está logueado, mostrar login
    if (empty($_SESSION['dni'])) {
        ?>
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Login</title>
            <style>
                * { margin: 0; padding: 0; box-sizing: border-box; }
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
                h1 { color: #333; margin-bottom: 30px; text-align: center; }
                input {
                    width: 100%;
                    padding: 10px;
                    margin-bottom: 15px;
                    border: 1px solid #ddd;
                    border-radius: 5px;
                }
                button {
                    width: 100%;
                    padding: 10px;
                    background: #667eea;
                    color: white;
                    border: none;
                    border-radius: 5px;
                    cursor: pointer;
                }
                button:hover { background: #764ba2; }
                .error { color: red; margin-bottom: 15px; }
            </style>
        </head>
        <body>
            <div class="container">
                <h1>Iniciar Sesión</h1>
                <?php foreach ($errors as $error): ?>
                    <p class="error">❌ <?php echo htmlspecialchars($error); ?></p>
                <?php endforeach; ?>
                <form method="POST">
                    <input type="text" name="dni" placeholder="Ingrese su DNI" value="<?php echo htmlspecialchars($dni); ?>" required autofocus>
                    <button type="submit" name="login">Entrar</button>
                </form>
            </div>
        </body>
        </html>
        <?php
        exit;
    }
}

// =============== YA LOGUEADO ===============

$dni = $_SESSION['dni'];
$rol = $_SESSION['rol'];
$mensaje = "";
$errors = [];

// =============== LÓGICA SEGÚN ROL ===============

if ($rol === 'profesor') {
    // VISTA PROFESOR - Mostrar cursos que imparte
    $query = "SELECT * FROM profesor WHERE dniP = '$dni'";
    $result = $conn->query($query);
    $profesor = $result->fetch_assoc();
    
    $query = "SELECT * FROM curso WHERE profesor = '$dni'";
    $result = $conn->query($query);
    $cursos = [];
    while ($row = $result->fetch_assoc()) {
        $cursos[] = $row;
    }
    
    $total_horas = array_sum(array_column($cursos, 'numhoras'));
    
} elseif ($rol === 'alumno') {
    // VISTA ALUMNO - Formulario de matrícula
    
    // Obtener datos del alumno
    $query = "SELECT * FROM alumno WHERE dniA = '$dni'";
    $result = $conn->query($query);
    $alumno = $result->fetch_assoc();
    
    // Procesar formulario de matrícula
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['matricular'])) {
        
        // Validar usando la clase Validador
        $v = new Validador($_POST);
        $v->obligatorio('curso', 'Código Curso');
        $v->obligatorio('pruebaA', 'Prueba A');
        $v->obligatorio('pruebaB', 'Prueba B');
        $v->obligatorio('tipo', 'Tipo');
        $v->obligatorio('inscripcion', 'Fecha Inscripción');
        
        if (!$v->tiene_errores()) {
            $codigo_curso = $_POST['curso'];
            
            // Verificar que el curso existe
            $query = "SELECT * FROM curso WHERE codigocurso = '$codigo_curso'";
            $result = $conn->query($query);
            
            if ($result && $result->num_rows > 0) {
                // Verificar que no esté ya matriculado
                $query = "SELECT * FROM matricula WHERE dnialumno = '$dni' AND codcurso = '$codigo_curso'";
                $result = $conn->query($query);
                
                if ($result->num_rows === 0) {
                    // Insertar matrícula
                    $query = "INSERT INTO matricula (dnialumno, codcurso, pruebaA, pruebaB, tipo, inscripcion)
                             VALUES ('$dni', '$codigo_curso', '{$_POST['pruebaA']}', '{$_POST['pruebaB']}', '{$_POST['tipo']}', '{$_POST['inscripcion']}')";
                    
                    if ($conn->query($query)) {
                        $mensaje = "<p style='color:green;'><b>✓ La matrícula del alumno $dni en el curso $codigo_curso se ha realizado correctamente.</b></p>";
                        // Limpiar formulario
                        $_POST['curso'] = $_POST['pruebaA'] = $_POST['pruebaB'] = $_POST['tipo'] = $_POST['inscripcion'] = '';
                    } else {
                        $errors[] = "No se ha podido realizar la matrícula";
                    }
                } else {
                    $errors[] = "El alumno $dni ya está matriculado en el curso $codigo_curso";
                }
            } else {
                $errors[] = "El curso $codigo_curso no existe";
                $_POST['curso'] = '';  // Limpiar campo
            }
        } else {
            $errors = array_merge($errors, $v->obtener_errores());
        }
    }
    
    // Obtener matrículas del alumno
    $query = "SELECT m.*, c.nombrecurso FROM matricula m 
              INNER JOIN curso c ON m.codcurso = c.codigocurso 
              WHERE m.dnialumno = '$dni'";
    $result = $conn->query($query);
    $matriculas = [];
    while ($row = $result->fetch_assoc()) {
        $matriculas[] = $row;
    }
}

$conn->close();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo ucfirst($rol); ?> - Sistema de Gestión</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }
        h1 { color: #333; margin-bottom: 20px; }
        .info-panel {
            background: #f0f4ff;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            border-left: 4px solid #667eea;
        }
        .info-panel p { margin: 5px 0; }
        .info-panel strong { color: #667eea; }
        .error {
            background: #ffe6e6;
            border: 1px solid #ff6b6b;
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 15px;
            color: #c92a2a;
        }
        .success {
            background: #e6ffe6;
            border: 1px solid #27ae60;
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 15px;
            color: #27ae60;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }
        input, select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        input:focus, select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 5px rgba(102, 126, 234, 0.3);
        }
        button {
            background: #667eea;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }
        button:hover { background: #764ba2; }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table th {
            background: #667eea;
            color: white;
            padding: 10px;
            text-align: left;
        }
        table td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        table tr:hover { background: #f5f5f5; }
        .logout {
            text-align: right;
            margin-top: 20px;
        }
        .logout a {
            background: #c92a2a;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
        }
        .logout a:hover { background: #a91f1f; }
    </style>
</head>
<body>
    <div class="container">
        <h1>
            <?php if ($rol === 'profesor'): ?>
                👨‍🏫 Panel de Profesor
            <?php else: ?>
                👨‍🎓 Panel de Alumno
            <?php endif; ?>
        </h1>
        
        <!-- Info Panel -->
        <div class="info-panel">
            <p><strong>DNI:</strong> <?php echo htmlspecialchars($dni); ?></p>
            <?php if ($rol === 'profesor' && isset($profesor)): ?>
                <p><strong>Profesor:</strong> <?php echo htmlspecialchars($profesor['nombreP']); ?></p>
            <?php elseif ($rol === 'alumno' && isset($alumno)): ?>
                <p><strong>Alumno:</strong> <?php echo htmlspecialchars($alumno['nombreA']); ?></p>
            <?php endif; ?>
        </div>
        
        <!-- Mostrar mensajes -->
        <?php if (!empty($errors)): ?>
            <?php foreach ($errors as $error): ?>
                <div class="error">❌ <?php echo htmlspecialchars($error); ?></div>
            <?php endforeach; ?>
        <?php endif; ?>
        
        <?php if (!empty($mensaje)): ?>
            <div class="success"><?php echo $mensaje; ?></div>
        <?php endif; ?>
        
        <!-- CONTENIDO SEGÚN ROL -->
        
        <?php if ($rol === 'profesor'): ?>
            <!-- VISTA PROFESOR -->
            <h2>Cursos que imparte</h2>
            
            <?php if (!empty($cursos)): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>Inicio</th>
                            <th>Fin</th>
                            <th>Horas</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cursos as $curso): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($curso['codigocurso']); ?></td>
                                <td><?php echo htmlspecialchars($curso['nombrecurso']); ?></td>
                                <td><?php echo htmlspecialchars($curso['fechaini']); ?></td>
                                <td><?php echo htmlspecialchars($curso['fechafin']); ?></td>
                                <td><?php echo htmlspecialchars($curso['numhoras']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="info-panel" style="margin-top: 20px;">
                    <p><strong>Total de horas impartidas:</strong> <?php echo $total_horas; ?> horas</p>
                </div>
            <?php else: ?>
                <p>No imparte ningún curso.</p>
            <?php endif; ?>
        
        <?php elseif ($rol === 'alumno'): ?>
            <!-- VISTA ALUMNO -->
            <h2>Formulario de Matrícula</h2>
            
            <form method="POST" style="background: #f9f9f9; padding: 20px; border-radius: 5px;">
                <div class="form-group">
                    <label>Código Curso:</label>
                    <input type="text" name="curso" value="<?php echo htmlspecialchars($_POST['curso'] ?? ''); ?>" placeholder="Ej: 0001">
                </div>
                
                <div class="form-group">
                    <label>Prueba A (0-100):</label>
                    <input type="number" name="pruebaA" value="<?php echo htmlspecialchars($_POST['pruebaA'] ?? ''); ?>" min="0" max="100">
                </div>
                
                <div class="form-group">
                    <label>Prueba B (0-100):</label>
                    <input type="number" name="pruebaB" value="<?php echo htmlspecialchars($_POST['pruebaB'] ?? ''); ?>" min="0" max="100">
                </div>
                
                <div class="form-group">
                    <label>Tipo:</label>
                    <select name="tipo">
                        <option value="">-- Seleccionar --</option>
                        <option value="Oficial" <?php echo ($_POST['tipo'] ?? '') === 'Oficial' ? 'selected' : ''; ?>>Oficial</option>
                        <option value="Libre" <?php echo ($_POST['tipo'] ?? '') === 'Libre' ? 'selected' : ''; ?>>Libre</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Fecha Inscripción:</label>
                    <input type="date" name="inscripcion" value="<?php echo htmlspecialchars($_POST['inscripcion'] ?? ''); ?>">
                </div>
                
                <button type="submit" name="matricular">Matricular</button>
            </form>
            
            <h2 style="margin-top: 30px;">Mis Matrículas</h2>
            <?php if (!empty($matriculas)): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Curso</th>
                            <th>Nombre</th>
                            <th>Prueba A</th>
                            <th>Prueba B</th>
                            <th>Tipo</th>
                            <th>Inscripción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($matriculas as $mat): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($mat['codcurso']); ?></td>
                                <td><?php echo htmlspecialchars($mat['nombrecurso']); ?></td>
                                <td><?php echo htmlspecialchars($mat['pruebaA']); ?></td>
                                <td><?php echo htmlspecialchars($mat['pruebaB']); ?></td>
                                <td><?php echo htmlspecialchars($mat['tipo']); ?></td>
                                <td><?php echo htmlspecialchars($mat['inscripcion']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No está matriculado en ningún curso.</p>
            <?php endif; ?>
        <?php endif; ?>
        
        <!-- Cerrar Sesión -->
        <div class="logout">
            <a href="?logout=1">Cerrar Sesión</a>
        </div>
    </div>
</body>
</html>

<?php
// Procesar logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
?>

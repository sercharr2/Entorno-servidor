<?php

session_start();

// Verificar sesión
if (!isset($_SESSION['dni'])) {
    header("Location: login.php");
    exit;
}

$dni = $_SESSION['dni'];
$rol = $_SESSION['rol'];

$conn = new mysqli('localhost', 'root', '', 'oposicion');
if ($conn->connect_error)
    die("Error al conectar");

// =============== PROFESOR ===============
if ($rol === 'profesor') {
    
    // Obtener datos profesor
    $query = "SELECT * FROM profesor WHERE dniP = '$dni'";
    $result = $conn->query($query);
    $profesor = $result->fetch_assoc();
    
    // Obtener cursos
    $query = "SELECT * FROM curso WHERE profesor = '$dni'";
    $result = $conn->query($query);
    
    $totalHoras = 0;
    
    echo <<<_END
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Profesor</title>
        <style>
            body { font-family: Arial, sans-serif; padding: 20px; }
            table { border-collapse: collapse; width: 100%; margin: 20px 0; }
            th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
            th { background: #667eea; color: white; }
            tr:hover { background: #f5f5f5; }
            .info { background: #f0f4ff; padding: 15px; border-radius: 5px; margin-bottom: 20px; }
            .info strong { color: #667eea; }
            a { color: blue; text-decoration: none; }
        </style>
    </head>
    <body>
        <h1>Panel de Profesor</h1>
        
        <div class="info">
            <p><strong>DNI:</strong> {$profesor['dniP']}</p>
            <p><strong>Nombre:</strong> {$profesor['nombreP']}</p>
        </div>
        
        <h2>Cursos que imparte</h2>
        <table>
            <tr>
                <th>Código</th>
                <th>Nombre</th>
                <th>Inicio</th>
                <th>Fin</th>
                <th>Horas</th>
            </tr>
    _END;
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $totalHoras += $row['numhoras'];
            echo "<tr>";
            echo "<td>{$row['codigocurso']}</td>";
            echo "<td>{$row['nombrecurso']}</td>";
            echo "<td>{$row['fechaini']}</td>";
            echo "<td>{$row['fechafin']}</td>";
            echo "<td>{$row['numhoras']}</td>";
            echo "</tr>";
        }
    }
    
    echo <<<_END
        </table>
        
        <div class="info">
            <p><strong>Total de horas:</strong> $totalHoras</p>
        </div>
        
        <br>
        <a href="?logout=1">Cerrar Sesión</a>
    </body>
    </html>
    _END;
}

// =============== ALUMNO ===============
elseif ($rol === 'alumno') {
    
    // Obtener datos alumno
    $query = "SELECT * FROM alumno WHERE dniA = '$dni'";
    $result = $conn->query($query);
    $alumno = $result->fetch_assoc();
    
    // Procesar formulario
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['matricular'])) {
        
        $curso = $_POST['curso'] ?? '';
        $pruebaA = $_POST['pruebaA'] ?? '';
        $pruebaB = $_POST['pruebaB'] ?? '';
        $tipo = $_POST['tipo'] ?? '';
        $inscripcion = $_POST['inscripcion'] ?? '';
        
        // Validar campos
        if (empty($curso) || empty($pruebaA) || empty($pruebaB) || empty($tipo) || empty($inscripcion)) {
            $error = "No puede haber campos vacíos";
        } else {
            // Verificar que el curso existe
            $query_check = "SELECT * FROM curso WHERE codigocurso = '$curso'";
            $result_check = $conn->query($query_check);
            
            if ($result_check->num_rows == 0) {
                $error = "El curso $curso no existe";
                $curso = '';
            } else {
                // Verificar que no esté ya matriculado
                $query_check = "SELECT * FROM matricula WHERE dnialumno = '$dni' AND codcurso = '$curso'";
                $result_check = $conn->query($query_check);
                
                if ($result_check->num_rows > 0) {
                    $error = "Ya está matriculado en este curso";
                } else {
                    // Insertar
                    $query_insert = "INSERT INTO matricula (dnialumno, codcurso, pruebaA, pruebaB, tipo, inscripcion)
                                    VALUES ('$dni', '$curso', '$pruebaA', '$pruebaB', '$tipo', '$inscripcion')";
                    
                    if ($conn->query($query_insert)) {
                        $mensaje = "La matrícula del alumno $dni en el curso $curso se ha realizado correctamente";
                        $curso = $pruebaA = $pruebaB = $tipo = $inscripcion = '';
                    } else {
                        $error = "No se ha podido realizar la matrícula";
                    }
                }
            }
        }
    }
    
    echo <<<_END
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Alumno</title>
        <style>
            body { font-family: Arial, sans-serif; padding: 20px; max-width: 900px; margin: 0 auto; }
            table { border-collapse: collapse; width: 100%; margin: 20px 0; }
            th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
            th { background: #667eea; color: white; }
            tr:hover { background: #f5f5f5; }
            .info { background: #f0f4ff; padding: 15px; border-radius: 5px; margin-bottom: 20px; }
            .info strong { color: #667eea; }
            .form-group { margin-bottom: 15px; }
            label { display: block; margin-bottom: 5px; font-weight: bold; }
            input, select { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 5px; }
            input[type="submit"] { background: #667eea; color: white; cursor: pointer; font-weight: bold; }
            input[type="submit"]:hover { background: #764ba2; }
            .error { color: red; padding: 10px; background: #ffe6e6; border-radius: 5px; margin-bottom: 15px; }
            .success { color: green; padding: 10px; background: #e6ffe6; border-radius: 5px; margin-bottom: 15px; }
            a { color: blue; text-decoration: none; }
        </style>
    </head>
    <body>
        <h1>Panel de Alumno</h1>
        
        <div class="info">
            <p><strong>DNI:</strong> {$alumno['dniA']}</p>
            <p><strong>Nombre:</strong> {$alumno['nombreA']}</p>
        </div>
    _END;
    
    if (isset($error)) {
        echo "<p class='error'>❌ $error</p>";
    }
    
    if (isset($mensaje)) {
        echo "<p class='success'>✓ $mensaje</p>";
    }
    
    echo <<<_END
        <h2>Formulario de Matrícula</h2>
        
        <form method="POST" style="background: #f9f9f9; padding: 20px; border-radius: 5px;">
            <div class="form-group">
                <label>Código Curso:</label>
                <input type="text" name="curso" value="{$_POST['curso'] ?? ''}" placeholder="Ej: 0001">
            </div>
            
            <div class="form-group">
                <label>Prueba A (0-100):</label>
                <input type="number" name="pruebaA" value="{$_POST['pruebaA'] ?? ''}" min="0" max="100">
            </div>
            
            <div class="form-group">
                <label>Prueba B (0-100):</label>
                <input type="number" name="pruebaB" value="{$_POST['pruebaB'] ?? ''}" min="0" max="100">
            </div>
            
            <div class="form-group">
                <label>Tipo:</label>
                <select name="tipo">
                    <option value="">-- Seleccionar --</option>
                    <option value="Oficial" {$_POST['tipo'] === 'Oficial' ? 'selected' : ''}>Oficial</option>
                    <option value="Libre" {$_POST['tipo'] === 'Libre' ? 'selected' : ''}>Libre</option>
                </select>
            </div>
            
            <div class="form-group">
                <label>Fecha Inscripción:</label>
                <input type="date" name="inscripcion" value="{$_POST['inscripcion'] ?? ''}">
            </div>
            
            <input type="submit" name="matricular" value="Matricular">
        </form>
        
        <h2>Mis Matrículas</h2>
        <table>
            <tr>
                <th>Curso</th>
                <th>Nombre</th>
                <th>Prueba A</th>
                <th>Prueba B</th>
                <th>Tipo</th>
                <th>Inscripción</th>
            </tr>
    _END;
    
    // Obtener matrículas
    $query = "SELECT m.*, c.nombrecurso FROM matricula m 
              INNER JOIN curso c ON m.codcurso = c.codigocurso 
              WHERE m.dnialumno = '$dni'";
    $result = $conn->query($query);
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['codcurso']}</td>";
            echo "<td>{$row['nombrecurso']}</td>";
            echo "<td>{$row['pruebaA']}</td>";
            echo "<td>{$row['pruebaB']}</td>";
            echo "<td>{$row['tipo']}</td>";
            echo "<td>{$row['inscripcion']}</td>";
            echo "</tr>";
        }
    }
    
    echo <<<_END
        </table>
        
        <br>
        <a href="?logout=1">Cerrar Sesión</a>
    </body>
    </html>
    _END;
}

$conn->close();

// Procesar logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit;
}

?>

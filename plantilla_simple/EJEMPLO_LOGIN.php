<?php
/**
 * EJEMPLO REAL - Sistema de Matrícula de Cursos
 * Basado en Simon Final Fase 4
 * 
 * Archivos necesarios:
 * - login.php (lo que ves aquí)
 * - ejercicio.php (el panel de profesor/alumno)
 * - datos_conexion.php (funciones de BD)
 */

if (isset($_POST["dni"])) {

    session_start();
    $_SESSION['dni'] = $_POST['dni'];

    $conn = new mysqli('localhost', 'root', '', 'oposicion');
    if ($conn->connect_error)
        die("Error al conectar");

    // Buscar en tabla alumno
    $query = "SELECT * FROM alumno WHERE dniA = '{$_SESSION['dni']}'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $_SESSION['rol'] = 'alumno';
        header("Location: ejercicio.php");
        exit;
    }

    // Buscar en tabla profesor
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
    <title>Iniciar Sesión</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        
        .login-container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 400px;
        }
        
        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 30px;
            font-size: 28px;
        }
        
        .subtitle {
            text-align: center;
            color: #666;
            margin-bottom: 30px;
            font-size: 14px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 600;
            font-size: 14px;
        }
        
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }
        
        input[type="text"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 5px rgba(102, 126, 234, 0.3);
        }
        
        button {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
        }
        
        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        
        .alert {
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 5px;
            background: #f8d7da;
            border: 1px solid #c92a2a;
            color: #721c24;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>🔐 Iniciar Sesión</h1>
        <p class="subtitle">Ingrese su DNI para continuar</p>
        
        <?php if (isset($error)): ?>
            <div class="alert">
                ✕ <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label for="dni">DNI:</label>
                <input 
                    type="text" 
                    id="dni" 
                    name="dni" 
                    placeholder="Ej: 12345678A"
                    value="<?php echo htmlspecialchars($_POST['dni'] ?? ''); ?>"
                    required
                    autofocus
                >
            </div>
            
            <button type="submit">Entrar</button>
        </form>
    </div>
</body>
</html>

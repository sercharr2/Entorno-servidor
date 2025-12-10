<?php
/**
 * PLANTILLA RÁPIDA - Login Simple
 * Copiar y adaptar para nuevos ejercicios
 */

session_start();
require_once 'datos_conexion.php';

// =============== INICIALIZAR VARIABLES ===============
$errors = [];
$dni = $_POST['dni'] ?? '';

// =============== PROCESAR LOGIN ===============
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['buscar'])) {
    
    // Validar DNI
    if (empty($dni)) {
        $errors[] = "El DNI es obligatorio";
    } else {
        // Conectar y verificar
        $conn = new mysqli($hn, $un, $pw, $db);
        if ($conn->connect_error) {
            die("Error al conectar: " . $conn->connect_error);
        }
        
        // Buscar en tabla alumno
        $query_alumno = "SELECT * FROM alumno WHERE dniA = '$dni'";
        $result_alumno = $conn->query($query_alumno);
        
        if ($result_alumno && $result_alumno->num_rows === 1) {
            $_SESSION['dni'] = $dni;
            $_SESSION['rol'] = 'alumno';
            header("Location: ejercicio2.php");
            exit;
        }
        
        // Buscar en tabla profesor
        $query_profesor = "SELECT * FROM profesor WHERE dniP = '$dni'";
        $result_profesor = $conn->query($query_profesor);
        
        if ($result_profesor && $result_profesor->num_rows === 1) {
            $_SESSION['dni'] = $dni;
            $_SESSION['rol'] = 'profesor';
            header("Location: ejercicio2.php");
            exit;
        }
        
        // No encontrado
        $errors[] = "DNI incorrecto o usuario no existente";
        $conn->close();
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistema de Gestión</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        
        .login-container {
            background: white;
            padding: 50px;
            border-radius: 10px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 400px;
        }
        
        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 10px;
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
            transition: border-color 0.3s;
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
            transition: transform 0.2s;
        }
        
        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        
        .alert {
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 5px;
            border-left: 4px solid;
        }
        
        .alert-error {
            background: #f8d7da;
            border-color: #c92a2a;
            color: #721c24;
        }
        
        .alert-success {
            background: #d4edda;
            border-color: #27ae60;
            color: #155724;
        }
        
        .error-list {
            list-style: none;
            padding: 0;
        }
        
        .error-list li {
            padding: 5px 0;
        }
        
        .error-list li:before {
            content: "✕ ";
            margin-right: 8px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>🔐 Iniciar Sesión</h1>
        <p class="subtitle">Ingrese su DNI para continuar</p>
        
        <!-- Mostrar errores -->
        <?php if (!empty($errors)): ?>
            <div class="alert alert-error">
                <ul class="error-list">
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        
        <!-- Formulario de login -->
        <form method="POST" action="">
            <div class="form-group">
                <label for="dni">DNI:</label>
                <input 
                    type="text" 
                    id="dni" 
                    name="dni" 
                    placeholder="Ej: 12345678A"
                    value="<?php echo htmlspecialchars($dni); ?>"
                    required
                    autofocus
                >
            </div>
            
            <button type="submit" name="buscar">Entrar</button>
        </form>
    </div>
</body>
</html>

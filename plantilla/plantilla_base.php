<?php
/**
 * PLANTILLA BASE - Sistema de Gestión con Login
 * Patrón común para ejercicios de autenticación y operaciones CRUD
 * 
 * Características:
 * - Login seguro con validación
 * - Gestión de sesiones
 * - Conexión a base de datos
 * - Formularios con validación
 * - Mensajes de error/éxito
 */

session_start();
require_once 'datos_conexion.php';

// =============== VARIABLES GLOBALES ===============
$errors = [];
$mensaje = "";
$usuario_logueado = false;
$DNI = $_SESSION['dni'] ?? '';
$rol = $_SESSION['rol'] ?? '';

// =============== CONEXIÓN A BASE DE DATOS ===============
$conn = new mysqli($hn, $un, $pw, $db);
if ($conn->connect_error) {
    die("Error al conectar: " . $conn->connect_error);
}

// =============== LÓGICA DE LOGIN ===============
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $login = trim($_POST['login'] ?? '');
    $clave = trim($_POST['clave'] ?? '');
    
    // Validar que no estén vacíos
    if (empty($login)) {
        $errors[] = "El usuario es obligatorio";
    }
    if (empty($clave)) {
        $errors[] = "La contraseña es obligatoria";
    }
    
    // Si no hay errores, consultar BD
    if (empty($errors)) {
        $query = "SELECT * FROM usuarios WHERE login = '$login' AND clave = '$clave'";
        $result = $conn->query($query);
        
        if ($result && $result->num_rows === 1) {
            $row = $result->fetch_assoc();
            $_SESSION['login'] = $login;
            $_SESSION['codigo'] = $row['codigo'] ?? '';
            $_SESSION['nombre'] = $row['nombre'] ?? '';
            $_SESSION['rol'] = $row['rol'] ?? '';
            
            $usuario_logueado = true;
            $mensaje = "<p style='color:green;'><b>Bienvenido " . htmlspecialchars($login) . "</b></p>";
        } else {
            $errors[] = "Usuario o contraseña incorrectos";
        }
    }
    
    $conn->close();
}

// =============== LÓGICA POSTERIOR AL LOGIN ===============
if ($usuario_logueado || !empty($_SESSION['login'])) {
    $_SESSION['login'] = $_SESSION['login'] ?? '';
    
    // AQUÍ INSERTAMOS LA LÓGICA ESPECÍFICA DEL EJERCICIO
    // Ejemplo: Diferentes vistas según rol
    
    if ($_SESSION['rol'] === 'profesor') {
        // Lógica para profesor
    } elseif ($_SESSION['rol'] === 'alumno') {
        // Lógica para alumno
    }
}

// =============== FUNCIÓN AUXILIAR: VALIDAR CAMPO VACÍO ===============
function validar_campo($campo, $nombre) {
    global $errors;
    if (empty(trim($campo))) {
        $errors[] = "$nombre es obligatorio";
        return false;
    }
    return true;
}

// =============== FUNCIÓN AUXILIAR: VALIDAR FORMATO ===============
function validar_formato($campo, $patron, $nombre) {
    global $errors;
    if (!preg_match($patron, $campo)) {
        $errors[] = "Formato inválido en $nombre";
        return false;
    }
    return true;
}

// =============== FUNCIÓN AUXILIAR: MOSTRAR MENSAJES ===============
function mostrar_mensajes($errors, $mensaje = "") {
    $html = "";
    
    if (!empty($errors)) {
        $html .= "<div style='color:red; background:#ffe6e6; padding:10px; border-radius:5px; margin:10px 0;'>";
        $html .= "<b>Errores:</b><ul>";
        foreach ($errors as $error) {
            $html .= "<li>" . htmlspecialchars($error) . "</li>";
        }
        $html .= "</ul></div>";
    }
    
    if (!empty($mensaje)) {
        $html .= "<div style='color:green; background:#e6ffe6; padding:10px; border-radius:5px; margin:10px 0;'>";
        $html .= $mensaje;
        $html .= "</div>";
    }
    
    return $html;
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Gestión</title>
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
        
        .container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 500px;
        }
        
        h1 {
            color: #333;
            margin-bottom: 30px;
            text-align: center;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: bold;
        }
        
        input[type="text"],
        input[type="password"],
        input[type="email"],
        input[type="date"],
        select,
        textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            font-family: Arial, sans-serif;
        }
        
        input:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 5px rgba(102, 126, 234, 0.5);
        }
        
        button {
            width: 100%;
            padding: 12px;
            background: #667eea;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s;
        }
        
        button:hover {
            background: #764ba2;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        
        table th, table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        
        table th {
            background: #667eea;
            color: white;
        }
        
        table tr:hover {
            background: #f5f5f5;
        }
        
        .info-panel {
            background: #f0f4ff;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            border-left: 4px solid #667eea;
        }
        
        .info-panel p {
            margin: 5px 0;
            color: #333;
        }
        
        .info-panel strong {
            color: #667eea;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if (empty($_SESSION['login'])): ?>
            <!-- PANTALLA DE LOGIN -->
            <h1>Iniciar Sesión</h1>
            
            <?php echo mostrar_mensajes($errors, $mensaje); ?>
            
            <form method="post" action="">
                <div class="form-group">
                    <label for="login">Usuario:</label>
                    <input type="text" id="login" name="login" placeholder="Ingrese su usuario" required>
                </div>
                
                <div class="form-group">
                    <label for="clave">Contraseña:</label>
                    <input type="password" id="clave" name="clave" placeholder="Ingrese su contraseña" required>
                </div>
                
                <button type="submit" name="login">Entrar</button>
            </form>
        
        <?php else: ?>
            <!-- PANTALLA DESPUÉS DEL LOGIN -->
            <h1>Bienvenido <?php echo htmlspecialchars($_SESSION['login']); ?></h1>
            
            <div class="info-panel">
                <p><strong>Usuario:</strong> <?php echo htmlspecialchars($_SESSION['login']); ?></p>
                <p><strong>Rol:</strong> <?php echo htmlspecialchars($_SESSION['rol'] ?? 'No asignado'); ?></p>
            </div>
            
            <?php echo mostrar_mensajes($errors, $mensaje); ?>
            
            <!-- AQUÍ VA EL CONTENIDO ESPECÍFICO SEGÚN EL EJERCICIO -->
            
            <form method="get" action="">
                <button type="submit" name="logout">Cerrar Sesión</button>
            </form>
        
        <?php endif; ?>
    </div>
</body>
</html>

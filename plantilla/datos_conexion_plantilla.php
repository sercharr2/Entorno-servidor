<?php
/**
 * CONFIGURACIÓN BASE - datos_conexion.php
 * Reutilizar en todos los proyectos
 */

// =============== CONFIGURACIÓN DE BD ===============
$hn = 'localhost';          // Host
$un = 'root';               // Usuario
$pw = '';                   // Contraseña
$db = 'nombre_base_datos';  // Nombre de la BD

// =============== CONFIGURACIÓN GENERAL ===============
define('IDIOMA', 'es');
define('ZONA_HORARIA', 'Europe/Madrid');
define('FORMATO_FECHA', 'Y-m-d');
define('FORMATO_HORA', 'H:i:s');

date_default_timezone_set(ZONA_HORARIA);

// =============== MENSAJES COMUNES ===============
define('MSG_CONEXION_ERROR', 'Error al conectar a la base de datos');
define('MSG_CONSULTA_ERROR', 'Error en la consulta a la base de datos');
define('MSG_CAMPOS_VACIOS', 'No puede haber campos vacíos');
define('MSG_REGISTRO_CREADO', 'El registro se ha creado correctamente');
define('MSG_REGISTRO_ACTUALIZADO', 'El registro se ha actualizado correctamente');
define('MSG_REGISTRO_ELIMINADO', 'El registro se ha eliminado correctamente');
define('MSG_REGISTRO_NO_EXISTE', 'El registro no existe');
define('MSG_REGISTRO_DUPLICADO', 'El registro ya existe');
define('MSG_OPERACION_FALLIDA', 'La operación no se pudo realizar');

// =============== COLORES Y ESTILOS ===============
define('COLOR_EXITO', '#27ae60');
define('COLOR_ERROR', '#c92a2a');
define('COLOR_ADVERTENCIA', '#f39c12');
define('COLOR_INFO', '#3498db');

// =============== ESTILOS CSS COMUNES ===============
define('ESTILOS_BASE', '
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    
    body {
        font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        padding: 20px;
    }
    
    .container {
        max-width: 1200px;
        margin: 0 auto;
        background: white;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.2);
    }
    
    h1 { color: #333; margin: 20px 0; }
    h2 { color: #555; margin: 15px 0; }
    p { line-height: 1.6; color: #666; }
    
    .form-group {
        margin-bottom: 20px;
    }
    
    label {
        display: block;
        margin-bottom: 8px;
        color: #333;
        font-weight: 600;
    }
    
    input[type="text"],
    input[type="password"],
    input[type="email"],
    input[type="number"],
    input[type="date"],
    input[type="time"],
    select,
    textarea {
        width: 100%;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 14px;
        font-family: Arial, sans-serif;
        transition: border-color 0.3s;
    }
    
    input:focus,
    select:focus,
    textarea:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 5px rgba(102, 126, 234, 0.5);
    }
    
    button, input[type="submit"] {
        padding: 12px 30px;
        background: #667eea;
        color: white;
        border: none;
        border-radius: 5px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.3s;
    }
    
    button:hover, input[type="submit"]:hover {
        background: #764ba2;
    }
    
    .btn-success { background: #27ae60; }
    .btn-success:hover { background: #1e8449; }
    
    .btn-danger { background: #c92a2a; }
    .btn-danger:hover { background: #a91f1f; }
    
    .btn-warning { background: #f39c12; }
    .btn-warning:hover { background: #d68910; }
    
    .btn-info { background: #3498db; }
    .btn-info:hover { background: #2980b9; }
    
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
        font-weight: 600;
    }
    
    table tr:hover {
        background: #f5f5f5;
    }
    
    .alert {
        padding: 15px;
        margin: 15px 0;
        border-radius: 5px;
        border-left: 4px solid;
    }
    
    .alert-success {
        background: #d4edda;
        border-color: #27ae60;
        color: #155724;
    }
    
    .alert-error, .alert-danger {
        background: #f8d7da;
        border-color: #c92a2a;
        color: #721c24;
    }
    
    .alert-warning {
        background: #fff3cd;
        border-color: #f39c12;
        color: #856404;
    }
    
    .alert-info {
        background: #d1ecf1;
        border-color: #3498db;
        color: #0c5460;
    }
    
    .info-panel {
        background: #ecf0f1;
        padding: 15px;
        border-radius: 5px;
        border-left: 4px solid #667eea;
        margin: 15px 0;
    }
    
    .info-panel p {
        margin: 5px 0;
    }
    
    .info-panel strong {
        color: #667eea;
    }
');

// =============== ESTILOS PARA TABLAS ===============
define('ESTILOS_TABLA', '
    table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
        background: white;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    
    table thead {
        background: #667eea;
        color: white;
    }
    
    table th {
        padding: 15px;
        text-align: left;
        font-weight: 600;
    }
    
    table td {
        padding: 12px 15px;
        border-bottom: 1px solid #eee;
    }
    
    table tbody tr:hover {
        background: #f5f5f5;
    }
    
    table .acciones {
        text-align: center;
    }
    
    table .acciones a {
        margin: 0 5px;
        padding: 5px 10px;
        background: #667eea;
        color: white;
        text-decoration: none;
        border-radius: 3px;
        font-size: 12px;
    }
    
    table .acciones a:hover {
        background: #764ba2;
    }
');

// =============== FUNCIÓN PARA CONECTAR A BD ===============
function conectar_bd() {
    global $hn, $un, $pw, $db;
    
    $conn = new mysqli($hn, $un, $pw, $db);
    
    if ($conn->connect_error) {
        die("Error al conectar: " . $conn->connect_error);
    }
    
    $conn->set_charset("utf8");
    return $conn;
}

// =============== FUNCIÓN PARA CERRAR SESIÓN ===============
function cerrar_sesion() {
    session_destroy();
    header("Location: index.php");
    exit;
}

// =============== FUNCIÓN PARA REDIRIGIR ===============
function redirigir($url, $tiempo = 0) {
    if ($tiempo > 0) {
        header("Refresh: $tiempo; url=$url");
    } else {
        header("Location: $url");
    }
    exit;
}

?>

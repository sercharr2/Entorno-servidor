<?php
/**
 * ============================================================================
 * PLANTILLA MAESTRA PHP - EXAMEN RECUPERACIÓN DAW
 * Contiene: Conexión, Autenticación, Sesiones, Formularios, BD y Tablas
 * ============================================================================
 */

// ==========================================
// 1. GESTIÓN DE SESIONES Y ARRANQUE
// ==========================================
// Siempre debe ir al principio de los archivos que necesiten recordar datos
session_start();

// Ejemplo de inicialización de un juego/variables si no existen en la sesión
if (!isset($_SESSION["juego_iniciado"])) {
    $_SESSION["juego_iniciado"] = true;
    $_SESSION["puntuacion"] = 0;
    $_SESSION["intentos"] = 0;
    
    // Generar combinaciones aleatorias (útil para el Simón o Cartas)
    $colores = ['red', 'blue', 'yellow', 'green'];
    shuffle($colores); // Desordena el array
    $_SESSION["combinacion_secreta"] = $colores;
}

// ==========================================
// 2. CONEXIÓN A LA BASE DE DATOS
// ==========================================
$servername = "localhost";
$username = "root";
$password = ""; // Cambiar si en clase usáis contraseña
$dbname = "nombre_de_tu_base_de_datos"; // CAMBIAR ESTO EN EL EXAMEN

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// ==========================================
// 3. PROCESAMIENTO DE FORMULARIOS (POST)
// ==========================================
$mensaje_error = "";
$mensaje_exito = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // A. LOGIN DE USUARIO (Extraído del ej. Cartas y Jeroglífico)
    if (isset($_POST["login"]) && isset($_POST["clave"])) {
        $login = $_POST["login"];
        $clave = $_POST["clave"];
        
        $stmt = $conn->prepare("SELECT * FROM jugador WHERE login=? AND clave=?");
        $stmt->bind_param("ss", $login, $clave); // 'ss' significa dos Strings
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            $_SESSION["usuario_logueado"] = $login;
            $_SESSION["nombre_usuario"] = $row["nombre"];
            // header("Location: inicio.php"); // Redirigir si es correcto
            // exit();
        } else {
            $mensaje_error = "Credenciales incorrectas.";
        }
        $stmt->close();
    }
    
    // B. MANEJO DE BOTONES DINÁMICOS (Ej: Levantar Carta o Pulsar Color)
    if (isset($_POST["boton_juego"])) {
        $valor_pulsado = $_POST["boton_juego"]; // Ej: "boton 1" o "red"
        $_SESSION["intentos"]++;
        
        // Lógica de comprobación del juego iría aquí
    }
}

// ==========================================
// 4. OPERACIONES DE BASE DE DATOS (CRUD)
// ==========================================

// -> INSERTAR DATOS (Ej: Guardar una jugada o matricula)
function guardarJugada($conn, $login, $acierto) {
    // $acierto puede ser 1 (ganado) o 0 (perdido)
    $stmt = $conn->prepare("INSERT INTO jugadas (login, acierto, fecha) VALUES (?, ?, CURDATE())");
    $stmt->bind_param("si", $login, $acierto); // s=string, i=integer
    if($stmt->execute()) {
        return true;
    }
    return false;
}

// -> ACTUALIZAR DATOS (Ej: Sumar/Restar puntos al jugador)
function actualizarPuntos($conn, $login, $puntos_a_sumar, $intentos) {
    $stmt = $conn->prepare("UPDATE jugador SET puntos = puntos + ?, extra = extra + ? WHERE login = ?");
    $stmt->bind_param("iis", $puntos_a_sumar, $intentos, $login);
    $stmt->execute();
}

// ==========================================
// 5. RENDERIZADO DE HTML Y TABLAS ESTADÍSTICAS
// ==========================================
// Es muy común que pidan mostrar una tabla con gráficos (barras de progreso).

$nombre = isset($_SESSION["nombre_usuario"]) ? $_SESSION["nombre_usuario"] : "Invitado";

// Usamos Heredoc (<<<_END) para imprimir HTML de forma cómoda
echo <<<_END
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Examen PHP</title>
    <style>
        body { font-family: Arial, sans-serif; padding:20px; }
        .carta { margin: 10px; padding: 20px; border: 1px solid black; display: inline-block; cursor: pointer; }
        table { border-collapse: collapse; width: 80%; margin-top: 20px; }
        th, td { border: 1px solid #bbb; padding: 8px; text-align: left; }
        th { background: #f3f3f3; }
        .barra-grafico { background-color: skyblue; height: 20px; }
    </style>
</head>
<body>

    <h1>Bienvenid@, $nombre</h1>
_END;

// Mostrar mensajes de error o éxito
if ($mensaje_error != "") echo "<h3 style='color:red;'>$mensaje_error</h3>";
if ($mensaje_exito != "") echo "<h3 style='color:green;'>$mensaje_exito</h3>";

echo <<<_END
    <form method="POST" action="">
        <label>Usuario:</label>
        <input type="text" name="login" required><br><br>
        <label>Contraseña:</label>
        <input type="password" name="clave" required><br><br>
        <input type="submit" value="Enviar">
    </form>
    
    <hr>
    
    <form method="POST" action="">
_END;

        // Generar 4 o 6 botones dinámicos
        for ($i = 1; $i <= 4; $i++) {
            echo "<button type='submit' name='boton_juego' value='boton_$i' class='carta'>Botón $i</button>";
        }

echo <<<_END
    </form>
    
    <hr>

    <h2>Estadísticas de Usuarios</h2>
    <table>
        <tr>
            <th>Nombre</th>
            <th>Puntos</th>
            <th>Gráfica</th>
        </tr>
_END;

// Obtener datos para la tabla
$query = "SELECT nombre, puntos FROM jugador ORDER BY puntos DESC";
$resultado = $conn->query($query);

if ($resultado && $resultado->num_rows > 0) {
    while ($row = $resultado->fetch_assoc()) {
        $nombre_jugador = $row['nombre'];
        $puntos_jugador = $row['puntos'];
        
        // Multiplicamos los puntos para que la barra se vea en pantalla (ej: 1 punto = 10px)
        $ancho_barra = $puntos_jugador * 10; 

        echo <<<_END
        <tr>
            <td>$nombre_jugador</td>
            <td>$puntos_jugador</td>
            <td>
                <div class='barra-grafico' style='width: {$ancho_barra}px;'></div>
            </td>
        </tr>
_END;
    }
} else {
    echo "<tr><td colspan='3'>No hay datos disponibles</td></tr>";
}

echo <<<_END
    </table>
</body>
</html>
_END;

// Cerrar conexión al final del script
$conn->close();
?>
<?php
/**
 * PLANTILLA CRUD - Operaciones comunes con Base de Datos
 * Incluye: SELECT, INSERT, UPDATE, DELETE con validación
 */

// =============== CREAR REGISTRO ===============
function crear_registro($conn, $tabla, $campos, $valores) {
    /**
     * Ejemplo:
     * $campos = ['nombre', 'email', 'edad'];
     * $valores = ['Juan', 'juan@email.com', 25];
     * crear_registro($conn, 'usuarios', $campos, $valores);
     */
    
    $campos_str = implode(', ', $campos);
    $valores_str = implode("', '", array_map(function($v) use ($conn) {
        return $conn->real_escape_string($v);
    }, $valores));
    
    $query = "INSERT INTO $tabla ($campos_str) VALUES ('$valores_str')";
    
    if ($conn->query($query)) {
        return true;
    } else {
        throw new Exception("Error al insertar: " . $conn->error);
    }
}

// =============== LEER REGISTROS ===============
function leer_registros($conn, $tabla, $condicion = "") {
    /**
     * Ejemplo:
     * $registros = leer_registros($conn, 'usuarios', "edad > 18");
     * $todos = leer_registros($conn, 'usuarios');
     */
    
    $query = "SELECT * FROM $tabla";
    
    if (!empty($condicion)) {
        $query .= " WHERE $condicion";
    }
    
    $result = $conn->query($query);
    
    if (!$result) {
        throw new Exception("Error en la consulta: " . $conn->error);
    }
    
    $registros = [];
    while ($row = $result->fetch_assoc()) {
        $registros[] = $row;
    }
    
    return $registros;
}

// =============== ACTUALIZAR REGISTRO ===============
function actualizar_registro($conn, $tabla, $campos, $condicion) {
    /**
     * Ejemplo:
     * $campos = ['nombre' => 'Carlos', 'edad' => 30];
     * actualizar_registro($conn, 'usuarios', $campos, "id = 1");
     */
    
    $set_clauses = [];
    foreach ($campos as $campo => $valor) {
        $valor_escapado = $conn->real_escape_string($valor);
        $set_clauses[] = "$campo = '$valor_escapado'";
    }
    
    $set_str = implode(', ', $set_clauses);
    $query = "UPDATE $tabla SET $set_str WHERE $condicion";
    
    if ($conn->query($query)) {
        return true;
    } else {
        throw new Exception("Error al actualizar: " . $conn->error);
    }
}

// =============== ELIMINAR REGISTRO ===============
function eliminar_registro($conn, $tabla, $condicion) {
    /**
     * Ejemplo:
     * eliminar_registro($conn, 'usuarios', "id = 1");
     */
    
    $query = "DELETE FROM $tabla WHERE $condicion";
    
    if ($conn->query($query)) {
        return true;
    } else {
        throw new Exception("Error al eliminar: " . $conn->error);
    }
}

// =============== VERIFICAR EXISTENCIA ===============
function existe_registro($conn, $tabla, $condicion) {
    /**
     * Ejemplo:
     * if (existe_registro($conn, 'usuarios', "email = 'juan@email.com'")) {
     *     echo "El usuario ya existe";
     * }
     */
    
    $query = "SELECT COUNT(*) as total FROM $tabla WHERE $condicion";
    $result = $conn->query($query);
    
    if (!$result) {
        throw new Exception("Error en la consulta: " . $conn->error);
    }
    
    $row = $result->fetch_assoc();
    return $row['total'] > 0;
}

// =============== CONTAR REGISTROS ===============
function contar_registros($conn, $tabla, $condicion = "") {
    /**
     * Ejemplo:
     * $total = contar_registros($conn, 'usuarios', "edad > 18");
     */
    
    $query = "SELECT COUNT(*) as total FROM $tabla";
    
    if (!empty($condicion)) {
        $query .= " WHERE $condicion";
    }
    
    $result = $conn->query($query);
    
    if (!$result) {
        throw new Exception("Error en la consulta: " . $conn->error);
    }
    
    $row = $result->fetch_assoc();
    return $row['total'];
}

// =============== VALIDACIONES COMUNES ===============

function validar_dni($dni) {
    return preg_match('/^\d{8}[A-Z]$/', $dni) || preg_match('/^\d{1,9}$/', $dni);
}

function validar_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

function validar_numero($numero, $minimo = null, $maximo = null) {
    if (!is_numeric($numero)) return false;
    
    if ($minimo !== null && $numero < $minimo) return false;
    if ($maximo !== null && $numero > $maximo) return false;
    
    return true;
}

function validar_fecha($fecha, $formato = 'Y-m-d') {
    $date = DateTime::createFromFormat($formato, $fecha);
    return $date && $date->format($formato) === $fecha;
}

function validar_longitud($texto, $minimo = 1, $maximo = null) {
    $len = strlen($texto);
    
    if ($len < $minimo) return false;
    if ($maximo !== null && $len > $maximo) return false;
    
    return true;
}

// =============== EJEMPLO DE USO COMPLETO ===============

/*

// Conexión
$conn = new mysqli('localhost', 'root', '', 'mibasedatos');
if ($conn->connect_error) die("Error: " . $conn->connect_error);

// CREAR
try {
    crear_registro($conn, 'usuarios', 
        ['nombre', 'email', 'edad'],
        ['Juan', 'juan@email.com', 25]
    );
    echo "Usuario creado";
} catch (Exception $e) {
    echo $e->getMessage();
}

// LEER
try {
    $usuarios = leer_registros($conn, 'usuarios', "edad > 18");
    foreach ($usuarios as $usuario) {
        echo $usuario['nombre'] . " - " . $usuario['email'] . "<br>";
    }
} catch (Exception $e) {
    echo $e->getMessage();
}

// ACTUALIZAR
try {
    actualizar_registro($conn, 'usuarios', 
        ['nombre' => 'Carlos', 'edad' => 30],
        "id = 1"
    );
    echo "Usuario actualizado";
} catch (Exception $e) {
    echo $e->getMessage();
}

// ELIMINAR
try {
    eliminar_registro($conn, 'usuarios', "id = 1");
    echo "Usuario eliminado";
} catch (Exception $e) {
    echo $e->getMessage();
}

// VERIFICAR
if (existe_registro($conn, 'usuarios', "email = 'juan@email.com'")) {
    echo "El usuario ya existe";
}

// CONTAR
$total = contar_registros($conn, 'usuarios');
echo "Total de usuarios: " . $total;

$conn->close();

*/
?>

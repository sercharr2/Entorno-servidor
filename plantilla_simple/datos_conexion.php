<?php

// =============== DATOS DE CONEXIÓN ===============
$hn = 'localhost';
$un = 'root';
$pw = '';
$db = 'nombre_base_datos';

// =============== FUNCIONES BÁSICAS ===============

function conectar() {
    global $hn, $un, $pw, $db;
    $conn = new mysqli($hn, $un, $pw, $db);
    if ($conn->connect_error) die("Error al conectar");
    return $conn;
}

function existe($conn, $tabla, $condicion) {
    $query = "SELECT COUNT(*) as total FROM $tabla WHERE $condicion";
    $result = $conn->query($query);
    $row = $result->fetch_assoc();
    return $row['total'] > 0;
}

function obtener($conn, $tabla, $condicion) {
    $query = "SELECT * FROM $tabla WHERE $condicion LIMIT 1";
    $result = $conn->query($query);
    return $result->fetch_assoc();
}

function obtener_todos($conn, $tabla, $condicion = "") {
    $query = "SELECT * FROM $tabla";
    if (!empty($condicion)) {
        $query .= " WHERE $condicion";
    }
    $result = $conn->query($query);
    
    $datos = [];
    while ($row = $result->fetch_assoc()) {
        $datos[] = $row;
    }
    return $datos;
}

?>

<?php

//abrir conexion con la base de datos
require_once 'ej.inicioSesion.php';
$conn = new mysqli($hn, $un, $pw, $db);
if ($conn->connect_error)
    die("Fatal Error");

//consulta
$query = "SELECT * FROM usuarios";
$result = $conn->query($query);
if (!$result)
    die("Fatal Error");

// obtencion de consulta: recorrer filas correctamente (fetch_assoc una vez por fila)
if ($result->num_rows > 0) {
    // usar while para iterar cada fila y evitar avanzar el puntero varias veces
    while ($row = $result->fetch_assoc()) {
        // usar el operador ?? para evitar warnings si la columna no existe
        echo 'Codigo: ' . htmlspecialchars($row['Codigo']) . '<br>';
        echo 'Nombre: ' . htmlspecialchars($row['Nombre']) . '<br>';
        echo 'Clave: ' . htmlspecialchars($row['Clave']) . '<br>';
        echo 'Rol: ' . htmlspecialchars($row['Rol']) . '<br><br>';
    }
} else {
    echo "No hay resultados.";
}

//cierra conexion
$result->close();
$conn->close();

?>
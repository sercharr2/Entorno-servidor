<?php
$servidor = "localhost";
$usuario = "root";
$password = "";
$base_datos = "bdnotas";

$conn = new mysqli($servidor, $usuario, $password, $base_datos);

if ($conn->connect_error) {
    die("Error en la conexión: " . $conn->connect_error);
}
// Se elimina el echo "Conexión exitosa" para no romper las redirecciones con header()
?>

<?php
session_start();

$conn = new mysqli("localhost", "root", "", "pictogramasphp");
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Recoger datos — nombres de campo igual que en el form de insertar.php
    $idpersona = isset($_POST['idpersona']) ? (int)$_POST['idpersona'] : 0;
    $idimagen  = isset($_POST['idimagen'])  ? (int)$_POST['idimagen']  : 0;
    $fecha     = trim($_POST['fecha'] ?? '');
    $hora      = trim($_POST['hora']  ?? '');

    // Validación básica
    if ($idpersona === 0 || $idimagen === 0 || empty($fecha) || empty($hora)) {
        $_SESSION['msg']      = 'Error: rellena todos los campos y selecciona un pictograma.';
        $_SESSION['msg_tipo'] = 'error';
        header('Location: insertar.php');
        exit();
    }

    // e) INSERT en la tabla agenda con los nombres de columna reales
    //    agenda(id, fecha, hora, idpersona, idimagen, created_at, updated_at)
    $sql  = "INSERT INTO agenda (fecha, hora, idpersona, idimagen) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssii", $fecha, $hora, $idpersona, $idimagen);

    if ($stmt->execute()) {
        $nuevo_id = $conn->insert_id;
        $_SESSION['msg']      = "✅ Entrada #$nuevo_id guardada correctamente en la agenda.";
        $_SESSION['msg_tipo'] = 'ok';
    } else {
        $_SESSION['msg']      = 'Error al guardar: ' . $stmt->error;
        $_SESSION['msg_tipo'] = 'error';
    }

    $stmt->close();
    $conn->close();

    // c) Redirigir a insertar.php → permite hacer una segunda inserción
    header('Location: insertar.php');
    exit();

} else {
    // Acceso directo sin POST → volver al formulario
    header('Location: insertar.php');
    exit();
}
?>
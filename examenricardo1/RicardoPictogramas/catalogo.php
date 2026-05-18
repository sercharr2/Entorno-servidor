<?php
session_start();

$conn = new mysqli("localhost", "root", "", "pictogramasphp");
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Tabla real: imagenes | columnas: idimagen, imagen (ruta), descripcion, categoria
$resultado = $conn->query("SELECT idimagen, imagen, descripcion, categoria FROM imagenes ORDER BY idimagen");
$imagenes  = [];
while ($fila = $resultado->fetch_assoc()) {
    $imagenes[] = $fila;
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Catálogo de Pictogramas</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        h2   { margin-bottom: 16px; }

        /* b) tabla */
        table { border-collapse: collapse; width: 100%; }
        th, td {
            border: 1px solid black;
            padding: 10px;
            text-align: center;
            vertical-align: middle;
        }
        th { background-color: #f0f0f0; }

        /* a) imagen */
        img { width: 120px; height: 120px; object-fit: contain; }

        /* c) ruta */
        .ruta { font-size: 11px; color: #555; word-break: break-all; }

        .btn {
            display: inline-block; margin-top: 18px;
            padding: 9px 20px; background-color: #4a90d9;
            color: white; text-decoration: none; border-radius: 4px;
        }
        .btn:hover { background-color: #357ab8; }
    </style>
</head>
<body>
    <h2>Listado de Pictogramas</h2>

    <?php if (empty($imagenes)): ?>
        <p>No hay imágenes en la base de datos.</p>
    <?php else: ?>

    <!-- b) tabla de 4 columnas -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Imagen</th>       <!-- a) -->
                <th>Descripción</th>
                <th>Ruta</th>         <!-- c) -->
            </tr>
        </thead>
        <tbody>
        <?php foreach ($imagenes as $img): ?>
            <tr>
                <td><?php echo $img['idimagen']; ?></td>

                <!-- a) mostrar imagen -->
                <td>
                    <img src="<?php echo htmlspecialchars(trim($img['imagen'])); ?>"
                         alt="<?php echo htmlspecialchars($img['descripcion']); ?>">
                </td>

                <td><?php echo htmlspecialchars($img['descripcion']); ?></td>

                <!-- c) mostrar ruta -->
                <td class="ruta"><?php echo htmlspecialchars(trim($img['imagen'])); ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <?php endif; ?>

    <a class="btn" href="insertar.php">➕ Nueva entrada en agenda</a>
</body>
</html>
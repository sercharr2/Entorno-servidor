<?php
session_start();

$conn = new mysqli("localhost", "root", "", "pictogramasphp");
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// JOIN entre agenda, personas e imagenes usando los nombres de columna reales
$sql = "
    SELECT 
        a.id,
        p.nombre      AS persona_nombre,
        p.apellidos   AS persona_apellidos,
        i.descripcion AS picto_desc,
        i.imagen      AS picto_ruta,
        a.fecha,
        a.hora
    FROM agenda a
    JOIN personas p ON a.idpersona = p.idpersona
    JOIN imagenes i ON a.idimagen  = i.idimagen
    ORDER BY a.fecha DESC, a.hora DESC
";

$resultado = $conn->query($sql);
$entradas  = [];
while ($fila = $resultado->fetch_assoc()) {
    $entradas[] = $fila;
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agenda</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        h2   { margin-bottom: 16px; }
        table { border-collapse: collapse; width: 100%; }
        th, td {
            border: 1px solid black; padding: 10px;
            text-align: center; vertical-align: middle;
        }
        th { background-color: #f0f0f0; }
        img { width: 70px; height: 70px; object-fit: contain; }
        .btn {
            display: inline-block; padding: 8px 18px;
            background-color: #4a90d9; color: white;
            text-decoration: none; border-radius: 4px; margin-bottom: 16px;
            margin-right: 8px;
        }
        .btn:hover { background-color: #357ab8; }
        .total { margin-top: 10px; color: #555; }
    </style>
</head>
<body>
    <h2>📋 Agenda</h2>

    <a class="btn" href="insertar.php">➕ Nueva entrada</a>
    <a class="btn" href="catalogo.php">🖼 Ver catálogo</a>

    <?php if (empty($entradas)): ?>
        <p>No hay entradas en la agenda todavía.</p>
    <?php else: ?>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Persona</th>
                <th>Pictograma</th>
                <th>Imagen</th>
                <th>Fecha</th>
                <th>Hora</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($entradas as $e): ?>
            <tr>
                <td><?php echo $e['id']; ?></td>
                <td><?php echo htmlspecialchars($e['persona_nombre'] . ' ' . $e['persona_apellidos']); ?></td>
                <td><?php echo htmlspecialchars($e['picto_desc']); ?></td>
                <td>
                    <img src="<?php echo htmlspecialchars(trim($e['picto_ruta'])); ?>"
                         alt="<?php echo htmlspecialchars($e['picto_desc']); ?>">
                </td>
                <td><?php echo date('d/m/Y', strtotime($e['fecha'])); ?></td>
                <td><?php echo substr($e['hora'], 0, 5); ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <p class="total">Total: <?php echo count($entradas); ?> entrada(s)</p>

    <?php endif; ?>
</body>
</html>
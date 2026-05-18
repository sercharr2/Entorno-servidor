<?php
session_start();

$conn = new mysqli("localhost", "root", "", "pictogramasphp");
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// a) Fecha y hora del sistema
$fechaSistema = date('Y-m-d');
$horaSistema  = date('H:i');

// Franjas horarias cada 30 min de 08:00 a 20:00
$franjas = [];
for ($h = 8; $h <= 20; $h++) {
    $franjas[] = sprintf('%02d:00', $h);
    if ($h < 20) $franjas[] = sprintf('%02d:30', $h);
}
// Franja más cercana a la hora actual
$minActual    = (int)date('H') * 60 + (int)date('i');
$franjaCercana = $franjas[0];
$menorDiff    = PHP_INT_MAX;
foreach ($franjas as $f) {
    [$fh, $fm] = explode(':', $f);
    $diff = abs($minActual - ((int)$fh * 60 + (int)$fm));
    if ($diff < $menorDiff) { $menorDiff = $diff; $franjaCercana = $f; }
}

// Personas de la BD — clave real: idpersona
$personas = [];
$res = $conn->query("SELECT idpersona, nombre, apellidos FROM personas ORDER BY nombre");
while ($fila = $res->fetch_assoc()) {
    $personas[] = $fila;
}

// Imágenes de la BD — tabla real: imagenes, clave: idimagen, ruta: imagen
$imagenes = [];
$res2 = $conn->query("SELECT idimagen, imagen, descripcion FROM imagenes ORDER BY idimagen");
while ($fila = $res2->fetch_assoc()) {
    $imagenes[] = $fila;
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Insertar entrada en Agenda</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; max-width: 900px; }
        h2   { margin-bottom: 16px; }

        .campo { margin-bottom: 14px; }
        .campo label {
            display: inline-block; width: 90px; font-weight: bold;
        }
        .campo input,
        .campo select {
            padding: 6px 10px; font-size: 14px;
            border: 1px solid #aaa; border-radius: 4px;
        }
        .info-hora { color: #555; font-size: 13px; margin-left: 6px; }

        /* b) tabla de pictogramas */
        table { border-collapse: collapse; margin-top: 10px; width: 100%; }
        th, td {
            border: 1px solid black; padding: 10px;
            text-align: center; vertical-align: middle;
        }
        th { background-color: #f0f0f0; }
        img { width: 100px; height: 100px; object-fit: contain; }

        /* d) radio button */
        input[type="radio"] { width: 18px; height: 18px; cursor: pointer; }

        .btn-submit {
            display: inline-block; margin-top: 18px;
            padding: 10px 28px; background-color: #28a745;
            color: white; border: none; border-radius: 4px;
            font-size: 15px; cursor: pointer;
        }
        .btn-submit:hover { background-color: #1e7e34; }

        .msg-ok {
            background: #d4edda; color: #155724;
            border: 1px solid #c3e6cb;
            padding: 10px 16px; border-radius: 4px; margin-bottom: 16px;
        }
        .msg-error {
            background: #f8d7da; color: #721c24;
            border: 1px solid #f5c6cb;
            padding: 10px 16px; border-radius: 4px; margin-bottom: 16px;
        }
        .nav a { color: #4a90d9; text-decoration: none; margin-right: 14px; }
        .nav a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <h2>Añadir datos a la Agenda</h2>

    <!-- Mensaje de éxito/error que viene de registrar_entrada.php  (apartado c) -->
    <?php if (isset($_SESSION['msg'])): ?>
        <div class="<?php echo $_SESSION['msg_tipo'] === 'ok' ? 'msg-ok' : 'msg-error'; ?>">
            <?php echo htmlspecialchars($_SESSION['msg']); ?>
        </div>
        <?php unset($_SESSION['msg'], $_SESSION['msg_tipo']); ?>
    <?php endif; ?>

    <!-- action → registrar_entrada.php que inserta y redirige aquí (apartado c) -->
    <form method="POST" action="registrar_entrada.php">

        <!-- a) Fecha del sistema (editable) -->
        <div class="campo">
            <label for="fecha">Fecha:</label>
            <input type="date" name="fecha" id="fecha"
                   value="<?php echo $fechaSistema; ?>" required>
        </div>

        <!-- a) Hora — desplegable de franjas, preselecciona la más cercana -->
        <div class="campo">
            <label for="hora">Hora:</label>
            <select name="hora" id="hora" required>
                <?php foreach ($franjas as $f): ?>
                    <option value="<?php echo $f; ?>"
                        <?php echo $f === $franjaCercana ? 'selected' : ''; ?>>
                        <?php echo $f; ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <span class="info-hora">(Hora del sistema: <?php echo $horaSistema; ?>)</span>
        </div>

        <!-- a) Desplegable de personas cargado desde la BD -->
        <div class="campo">
            <label for="persona">Persona:</label>
            <select name="idpersona" id="persona" required>
                <option value="">— Selecciona —</option>
                <?php foreach ($personas as $p): ?>
                    <option value="<?php echo $p['idpersona']; ?>">
                        <?php echo htmlspecialchars($p['nombre'] . ' ' . $p['apellidos']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- b) Tabla con ID e imagen  +  d) radio button -->
        <p><strong>Selecciona un pictograma:</strong></p>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Imagen</th>         <!-- b) imagen -->
                    <th>Descripción</th>
                    <th>Seleccionar</th>    <!-- d) radio -->
                </tr>
            </thead>
            <tbody>
                <?php foreach ($imagenes as $img): ?>
                <tr>
                    <!-- b) ID de la imagen -->
                    <td><?php echo $img['idimagen']; ?></td>

                    <!-- b) imagen -->
                    <td>
                        <img src="<?php echo htmlspecialchars(trim($img['imagen'])); ?>"
                             alt="<?php echo htmlspecialchars($img['descripcion']); ?>">
                    </td>

                    <td><?php echo htmlspecialchars($img['descripcion']); ?></td>

                    <!-- d) solo se puede marcar uno -->
                    <td>
                        <input type="radio"
                               name="idimagen"
                               value="<?php echo $img['idimagen']; ?>"
                               required>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- e) botón que graba en agenda -->
        <button type="submit" class="btn-submit">💾 Añadir entrada en agenda</button>

    </form>

    <p class="nav" style="margin-top:16px;">
        <a href="catalogo.php">← Ver catálogo</a>
        <a href="mostrar_agenda.php">📋 Ver agenda</a>
    </p>
</body>
</html>
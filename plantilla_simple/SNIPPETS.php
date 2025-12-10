<?php
/**
 * SNIPPETS - Código para copiar y pegar
 * Patrones comunes que necesitarás
 */

// =============== SNIPPET 1: TABLA BÁSICA ===============
/*
echo <<<_END
<table>
    <tr>
        <th>Columna 1</th>
        <th>Columna 2</th>
    </tr>
_END;

while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>{$row['campo1']}</td>";
    echo "<td>{$row['campo2']}</td>";
    echo "</tr>";
}

echo "</table>";
*/

// =============== SNIPPET 2: VALIDAR CAMPO OBLIGATORIO ===============
/*
if (empty($_POST['campo'])) {
    $error = "El campo es obligatorio";
}
*/

// =============== SNIPPET 3: VERIFICAR EXISTENCIA EN BD ===============
/*
$query = "SELECT * FROM tabla WHERE condicion = 'valor'";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    echo "Existe";
} else {
    echo "No existe";
}
*/

// =============== SNIPPET 4: INSERTAR EN BD ===============
/*
$query = "INSERT INTO tabla (campo1, campo2) VALUES ('valor1', 'valor2')";

if ($conn->query($query)) {
    echo "Insertado correctamente";
} else {
    echo "Error al insertar";
}
*/

// =============== SNIPPET 5: ACTUALIZAR EN BD ===============
/*
$query = "UPDATE tabla SET campo1 = 'nuevo_valor' WHERE id = 1";

if ($conn->query($query)) {
    echo "Actualizado correctamente";
} else {
    echo "Error al actualizar";
}
*/

// =============== SNIPPET 6: ELIMINAR DE BD ===============
/*
$query = "DELETE FROM tabla WHERE id = 1";

if ($conn->query($query)) {
    echo "Eliminado correctamente";
} else {
    echo "Error al eliminar";
}
*/

// =============== SNIPPET 7: CONTADOR DE REGISTROS ===============
/*
$query = "SELECT COUNT(*) as total FROM tabla WHERE condicion = 'valor'";
$result = $conn->query($query);
$row = $result->fetch_assoc();
echo "Total: " . $row['total'];
*/

// =============== SNIPPET 8: SUMA DE VALORES ===============
/*
$query = "SELECT SUM(campo) as total FROM tabla WHERE condicion = 'valor'";
$result = $conn->query($query);
$row = $result->fetch_assoc();
echo "Total: " . $row['total'];
*/

// =============== SNIPPET 9: FORMULARIO BÁSICO ===============
/*
<form method="POST">
    <input type="text" name="campo1" placeholder="Valor 1">
    <input type="text" name="campo2" placeholder="Valor 2">
    <input type="submit" value="Enviar">
</form>
*/

// =============== SNIPPET 10: IF-ELSE SIMPLE ===============
/*
if (isset($_POST['boton'])) {
    // Hacer algo
    echo "Botón presionado";
} else {
    // Mostrar formulario
    echo "Presiona el botón";
}
*/

// =============== SNIPPET 11: MOSTRAR MENSAJES ===============
/*
if (isset($error)) {
    echo "<p style='color: red;'>$error</p>";
}

if (isset($mensaje)) {
    echo "<p style='color: green;'>$mensaje</p>";
}
*/

// =============== SNIPPET 12: LISTA DESPLEGABLE ===============
/*
<select name="opciones">
    <option value="">-- Seleccionar --</option>
    <option value="opcion1">Opción 1</option>
    <option value="opcion2">Opción 2</option>
</select>
*/

// =============== SNIPPET 13: VALORES POR DEFECTO EN FORMULARIO ===============
/*
<input type="text" name="campo" value="<?php echo $_POST['campo'] ?? ''; ?>">
*/

// =============== SNIPPET 14: SALTAR A OTRA PÁGINA ===============
/*
header("Location: otra_pagina.php");
exit;
*/

// =============== SNIPPET 15: VERIFICAR SESIÓN ===============
/*
session_start();

if (!isset($_SESSION['dni'])) {
    header("Location: login.php");
    exit;
}

$dni = $_SESSION['dni'];
*/

// =============== SNIPPET 16: CERRAR SESIÓN ===============
/*
session_destroy();
header("Location: login.php");
exit;
*/

// =============== SNIPPET 17: JOIN DE DOS TABLAS ===============
/*
$query = "SELECT m.*, c.nombrecurso FROM matricula m 
          INNER JOIN curso c ON m.codcurso = c.codigocurso 
          WHERE m.dnialumno = '1111'";
*/

// =============== SNIPPET 18: BUSCAR CON WHERE ===============
/*
$query = "SELECT * FROM tabla WHERE campo1 = 'valor' AND campo2 = 'otro'";
*/

// =============== SNIPPET 19: ORDENAR RESULTADOS ===============
/*
$query = "SELECT * FROM tabla ORDER BY campo ASC";  // Ascendente
$query = "SELECT * FROM tabla ORDER BY campo DESC"; // Descendente
*/

// =============== SNIPPET 20: LIMITAR RESULTADOS ===============
/*
$query = "SELECT * FROM tabla LIMIT 10";        // Primeros 10
$query = "SELECT * FROM tabla LIMIT 5, 10";     // Del 5 al 10
*/

?>

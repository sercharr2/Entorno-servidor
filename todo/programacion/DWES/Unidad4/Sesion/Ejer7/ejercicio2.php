<?php
    session_start();
    echo "<br>PROFESOR:    " .$_SESSION["dni"] ." NOMBRE:  " .$_SESSION["nombre"];

    $dni = $_SESSION["dni"] ?? '';

    // Datos de Conexion
    $hn = 'localhost';
    $db = 'oposicion';
    $un = 'root';
    $pw = '';

    $conn = new mysqli($hn, $un, $pw, $db);
    if ($conn->connect_error) die("Error de conexión: " . $conn->connect_error);

    // Consulta SQL
    $sql = "
            SELECT c.codigocurso, c.nombrecurso, c.maxalumnos, c.fechaini, c.fechafin, c.numhoras, c.profesor
            FROM curso c
            WHERE c.profesor = ?;
            ";
    $stmt = $conn->prepare($sql);
    $stmt-> bind_param("s", $dni);
    $stmt->execute();

    $resultado = $stmt->get_result();

    $data = [];
    if($resultado && $resultado-> num_rows > 0){
        while($row = $resultado->fetch_assoc()){
            $data[] = $row;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio2</title>
</head>
<body>
    <br><br>
    <table border="1">
        <tr>
            <th>Codigo Del Curso</th>
            <th>Nombre Del Curso</th>
            <th>Max Alumnos</th>
            <th>Fecha Inicio</th>
            <th>Fecha Fin</th>
            <th>Num Horas</th>
            <th>Profesor</th>
        </tr>
        <?php foreach ($data as $row): ?>
        <tr>
            <td><?= $row['codigocurso'] ?></td>
            <td><?= $row['nombrecurso'] ?></td>
            <td><?= $row['maxalumnos'] ?></td>
            <td><?= $row['fechaini'] ?></td>
            <td><?= $row['fechafin'] ?></td>
            <td><?= $row['numhoras'] ?></td>
            <td><?= $row['profesor'] ?></td>
        </tr>
        <?php endforeach; ?>
    </table>

    <?php
        $sql2 = "SELECT SUM(numhoras) AS total_horas FROM curso WHERE profesor = ?;";
        $stmt2 = $conn->prepare($sql2);
        $stmt2-> bind_param("s", $dni);
        $stmt2->execute();
        $resultado2 = $stmt2->get_result();

        if ($resultado2 && $fila2 = $resultado2->fetch_assoc()) { //Obtiene consulta ok y fila de resultados
            $total_horas = $fila2['total_horas'] ?? 0;  // si es null pone 0
        }

        echo "<br>Numero de horas totales: " .$total_horas ; 
    ?>
</body>
</html>
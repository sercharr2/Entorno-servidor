<?php
session_start();
require_once 'datos_oposicion.php';

// conexión
$conn = new mysqli($hn, $un, $pw, $db);
if ($conn->connect_error) die("Error al conectar: " . $conn->connect_error);

$DNI = $_SESSION['dni'] ?? '';
$usuario = $_SESSION['rol'] ?? '';

/* ------------------------ PROFESOR ------------------------ */
if ($usuario == 'profesor') {
    $query = "SELECT codigocurso, nombrecurso, fechaini, fechafin, numhoras, nombreP, dniP
              FROM profesor, curso
              WHERE dniP = '$DNI'";

    $result = $conn->query($query);
    if (!$result) die("Error en la consulta: " . $conn->error);

    $totalHoras = 0;
    $nombreProfesor = "";

    $primeraFila = $result->fetch_assoc();
    if ($primeraFila) $nombreProfesor = $primeraFila['nombreP'];

    $result->data_seek(0);

    echo "<table>";
    echo "<td style='background-color: green;'><b>Profesor (DNI):</b> $DNI</td>
        <td style='background-color: orange;'><b>Nombre:</b> $nombreProfesor</td>";
    echo "</table><br>";

    echo "<table border='1'>";
    echo "<tr>
            <th>Código Curso</th>
            <th>Nombre Curso</th>
            <th>Fecha Inicio</th>
            <th>Fecha Fin</th>
            <th>Número de Horas</th>
            <th>Profesor</th>
          </tr>";

    while ($row = $result->fetch_assoc()) {
        $totalHoras += $row['numhoras'];
        echo "<tr>
                <td>{$row['codigocurso']}</td>
                <td>{$row['nombrecurso']}</td>
                <td>{$row['fechaini']}</td>
                <td>{$row['fechafin']}</td>
                <td>{$row['numhoras']}</td>
                <td>{$row['dniP']}</td>
              </tr>";
    }

    echo "</table>";
    echo "<br><table><td style='background-color: green;'><b>Total de horas impartidas:</b></td>
        <td style='background-color: green;'><b>$totalHoras</b></td></table>";
}

/* ------------------------ Alumno ------------------------ */
elseif ($usuario == 'alumno') {

    // Inicializar variables
    $mensaje = "";
    $curso = "";
    $pruebaA = "";
    $pruebaB = "";
    $tipo = "";
    $inscripcion = "";
    $nombre ="";

 $sqlAlumno = "SELECT nombreA FROM alumno WHERE dniA = '$DNI'";
$resultAlumno = $conn->query($sqlAlumno);

if ($resultAlumno->num_rows > 0) {
    $rowAlumno = $resultAlumno->fetch_assoc();
    $nombre = $rowAlumno['nombreA']; // Aquí debe coincidir con el nombre de la columna
} else {
    $nombre = "Desconocido";
}


    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $curso = $_POST['curso'] ?? '';
        $pruebaA = $_POST['pruebaA'] ?? '';
        $pruebaB = $_POST['pruebaB'] ?? '';
        $tipo = $_POST['tipo'] ?? '';
        $inscripcion = $_POST['inscripcion'] ?? '';

        // Validación de campos vacíos
        if ($curso == "" || $pruebaA == "" || $pruebaB == "" || $tipo == "" || $inscripcion == "") {
            $mensaje = "<p style='color:red;'><b>No puede haber campos vacíos.</b></p>";
        } else {
            // Comprobar si el curso existe
            $sqlCurso = "SELECT codigocurso FROM curso WHERE codigocurso = '$curso'";
            $resultCurso = $conn->query($sqlCurso);

            if ($resultCurso->num_rows == 0) {
                $mensaje = "<p style='color:red;'><b>El curso $curso no existe.</b></p>";
                $curso = "";
            } else {
                // Comprobar si ya está matriculado
                $sqlCheck = "SELECT * FROM matricula WHERE dnialumno='$DNI' AND codcurso='$curso'";
                $resultCheck = $conn->query($sqlCheck);

                if ($resultCheck->num_rows > 0) {
                    $mensaje = "<p style='color:red;'><b>El alumno $DNI ya está matriculado en el curso $curso.</b></p>";
                } else {
                    // Insertar matrícula
                    $sqlInsert = "INSERT INTO matricula (dnialumno, codcurso, pruebaA, pruebaB, tipo, inscripcion)
                                  VALUES ('$DNI', '$curso','$pruebaA', '$pruebaB', '$tipo', '$inscripcion')";
                    if ($conn->query($sqlInsert)) {
                        $mensaje = "<p style='color:green;'><b>La matrícula del alumno $DNI en el curso $curso se ha realizado correctamente.</b></p>";
                        $curso = $pruebaA = $pruebaB = $tipo = $inscripcion = "";
                    } else {
                        $mensaje = "<p style='color:red;'><b>No se ha podido realizar la matrícula.</b></p>";
                    }
                }
            }
        }
    }

// FORMULARIO
    echo "<form method='post' action=''><table border= '1'><td>
    <table>
    <td style='background-color: orange;'><b>DNI Alumno:</b> $DNI</td> 
    <td style='background-color: green;'><b>Nombre:</b> $nombre</td></table>
    
     <p><label>Código Curso: </label>
          <input type='text' name='curso' value='$curso'></p>

    <p><label>PruebaA: </label>
          <input type='text' name='pruebaA' value='$pruebaA'></p>

    <p><label>PruebaB: </label>
          <input type='text' name='pruebaB' value='$pruebaB'></p>

    <p><label>Tipo: </label>
          <input type='text' name='tipo' value='$tipo'></p>

    <p><label>Inscripción: </label>
          <input type='text' name='inscripcion' value='$inscripcion'></p>

    <p><input type='submit' value='Matricular' style='background-color:lightblue; border-radius:5px;'></p>
    </form>
        </table></td>";
    echo $mensaje;
}

$conn->close();
?>

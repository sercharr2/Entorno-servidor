<?php
session_start();
$hn = 'localhost';
$db = 'oposicion';
$un = 'root';
$pw = '';
$connection = new mysqli($hn, $un, $pw, $db);
if ($connection->connect_error) die("Fatal Error");

// Consulta de cursos del profesor
$query = "SELECT * 
          FROM curso
          WHERE profesor = '".$_SESSION['dni']."'";

// Consulta de total de horas del profesor
$query2 = "SELECT SUM(numhoras) as totalhoras 
           FROM curso
           WHERE profesor = '".$_SESSION['dni']."'";

$result = $connection->query($query);
$result2 = $connection->query($query2);

// Obtener total de horas
$row2 = $result2->fetch_assoc();
$_SESSION['totalhoras2'] = $row2['totalhoras'];  // <-- corregido

echo <<<_END
<html>
    <body>
        <h1></h1>
        <h2>Estadistica</h2>
_END;

echo <<<_END
   <table border=1 >
        <tr>
            <th>Código curso</th>
            <th>Nombre curso</th>
            <th>maxalumnos</th>
            <th>fechaini</th>
            <th>fechafin</th>
            <th>numhoras</th>
            <th>profesor</th>
        </tr>
_END;

// Mostrar datos del profesor y total de horas
print("PROFESOR DNI: "); 
echo htmlentities($_SESSION['dni']);

print(" &nbsp;&nbsp;NOMBRE: ");
echo htmlentities($_SESSION['nombreP']);

print(" &nbsp;&nbsp;Total de Horas: ");
echo htmlentities($_SESSION['totalhoras2']);

            $rows = $result->num_rows;
            for ($j = 0 ; $j < $rows ; ++$j) {
                $result->data_seek($j);
                $row = $result->fetch_assoc();
echo "<br>";

                    echo "<br>";
                    echo "<tr>";
                    echo '<td>' . htmlspecialchars($row['codigocurso']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['nombrecurso']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['maxalumnos']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['fechaini']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['fechafin']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['numhoras']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['profesor']) . '</td>';

                    echo "</tr>";
}

                
        
        $result->close();
    echo<<<_END
   
_END;
    
    $connection->close();

?>
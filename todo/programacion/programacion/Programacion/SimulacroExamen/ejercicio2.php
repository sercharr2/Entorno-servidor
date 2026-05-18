<?php
session_start();
$hn = 'localhost';
$db = 'oposicion';
$un = 'root';
$pw = '';
    $connection = new mysqli($hn, $un, $pw, $db);
    if ($connection->connect_error) die("Fatal Error");
    $query="Select codigocurso, nombrecurso, maxalumnos, fechaini, fechafin, numhoras, profesor
        FROM curso
        WHERE profesor = '".$_SESSION['dni']."'";
$result = $connection->query($query);
echo <<<_END
<html>
    <body>
        <h1></h1>
            <h2>Estadistica</h2>
_END;
echo <<<_END
   <table border=1 >
        <tr>
            <th>Código usuario</th>
            <th>Nombre curso</th>
            <th>maxalumnos</th>
            <th>fechaini</th>
            <th>fechafin</th>
            <th>numhoras</th>
            <th>profesor</th>



        </tr>
_END;
print("PROFESOR: "); 
echo htmlentities($_SESSION['dni']);
print(" PROFESOR: ");
echo htmlentities($_SESSION['nombreP']);

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
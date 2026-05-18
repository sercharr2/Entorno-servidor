<?php
session_start();
include "pintar-circulos.php";

echo "<h1>Bienvenid@,  .$_SESSION <h2>"
//fallo
echo "<h2>Fallo posiciones .$acierto1 y .$acierto2 despues de .$intentos</h2>";

echo "<p>Combinación correcta:</p>";
    cartas(
        $_SESSION['combinacioncorrecta'][0],
        $_SESSION['combinacioncorrecta'][1],
        $_SESSION['combinacioncorrecta'][2],
        $_SESSION['combinacioncorrecta'][3]
    );

    echo "<a href='estadistica.php'>Estadistica</a>";

//acierto
session_start();
include "pintar-circulos.php";

$hn = 'localhost';
$db = 'bdsimon';
$un = 'root';
$pw = '';



$connection = new mysqli($hn, $un, $pw, $db);
 if ($connection->connect_error) die("Fatal Error");
 $usuario = $_SESSION['usuario'];
    $query = "SELECT Codigo FROM usuarios WHERE Nombre = '$usuario'";
    $result = $connection->query($query);
    if (!$result) die("Fatal Error");
    $row=$result->fetch_assoc();
    $codigousu = $row['Codigo'];

    $query2 = "INSERT INTO jugadas (codigousu, acierto) VALUES ($codigousu, 1)";
        if (!$connection->query($query2)) die("Fatal Error");

        $result->close();
        $connection->close();

    echo "<h2>$_SESSION[usuario], enhorabuena has acertado la combinación!</h2>";
    cartas(
        $_SESSION['combinacioncorrecta'][0],
        $_SESSION['combinacioncorrecta'][1],
        $_SESSION['combinacioncorrecta'][2],
        $_SESSION['combinacioncorrecta'][3]
    );


?>

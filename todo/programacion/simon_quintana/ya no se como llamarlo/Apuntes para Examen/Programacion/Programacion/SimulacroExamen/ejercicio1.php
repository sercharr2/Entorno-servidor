<?php  
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


$hn = 'localhost';
$db = 'oposicion';
$un = 'root';
$pw = '';


$connection = new mysqli($hn, $un, $pw, $db);
 if ($connection->connect_error) die("Fatal Error");

$error='';

if (isset($_POST['submit'])) {

    if (!empty($_POST['dni'])) {

        $dni = $_POST['dni'];
        $_SESSION['dni'] = $dni;

        // Consultas
        $query  = "SELECT nombreP FROM profesor WHERE dniP = '$dni'";
        $query2 = "SELECT nombreA FROM alumno WHERE dniA = '$dni'";

        $result  = $connection->query($query);
        $result2 = $connection->query($query2);

        if (!$result || !$result2) die("Fatal Error");

        $rows  = $result->num_rows;
        $rows2 = $result2->num_rows;

        // Si es profesor
        if ($rows == 1) {
            $row = $result->fetch_assoc();
            $_SESSION['nombreP'] = $row['nombreP']; // <--- AHORA SÍ SE GUARDA BIEN

            header("Location: ejercicio2.php");
            exit();
        }

        // Si es alumno
        if ($rows2 == 1) {
            $row2 = $result2->fetch_assoc();
            $_SESSION['nombreA'] = $row2['nombreA']; // <--- AHORA SÍ SE GUARDA BIEN

            header("Location: ejercicio3.php");
            exit();
        }

        // Si no existe
        $error = "Usuario o contraseña incorrectos";

        $result->close();
        $result2->close();
    }
}

    $connection->close();
echo <<<_END
<html>
    <body>
        <h1></h1>
            <h2>Ingresa tus datos</h2>
            <form action="ejercicio1.php" method="post">
                <label for="dni">DNI:</label><br>
                <input type="text" name="dni"><br><br>
                <input type="submit" name="submit" value="Entrar">
            </form>
            <p>$error</p>
    </body>
</html>
_END;

?>
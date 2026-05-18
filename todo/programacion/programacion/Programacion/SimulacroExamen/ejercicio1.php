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
    if (!empty($_POST['dni']) ){
    $dni = $_POST['dni'];
    $_SESSION['dni'] = $dni;

     $query = "SELECT nombreP FROM profesor WHERE dniP = '$dni'";
     $nombreP = $_POST['nombreP'];
     $query2 = "SELECT nombreA FROM alumno WHERE dniA = '$dni'";
     $nombreA = $_POST['nombreA'];

     $_SESSION['nombreP'] = $nombreP;
     $_SESSION['nombreA'] = $nombreA;

     $result = $connection->query($query);
     $result2 = $connection->query($query2);
     if (!$result || !$result2) die("Fatal Error");
     $rows = $result->num_rows;
     $rows2 = $result2->num_rows;

     if ($rows == 1) {
         $_SESSION['dni'] = $dni;
         header("Location: ejercicio2.php");
         exit();
     }else if ($rows2 == 1) {
         $_SESSION['dni'] = $dni;

         header("Location: ejercicio3.php");
         exit();
     }else {
         $error = "Usuario o contraseña incorrectos";
     }
    $result->close();

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
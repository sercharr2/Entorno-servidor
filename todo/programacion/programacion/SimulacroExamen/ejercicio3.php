<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$hn = 'localhost';
$db = 'oposicion';
$un = 'root';
$pw = '';

$connection = new mysqli($hn, $un, $pw, $db);
if ($connection->connect_error) die("Error de conexión");
$query="SELECT nombreP FROM profesor WHERE dniP ='$_SESSION[dni]'";
$result = $connection->query($query);

$error = '';

if (isset($_POST['enviar'])) {
   $dni = $_SESSION['nombre'];
   $todo_ok = true;

   for ($i=0;$i<count($_SESSION['imagenes']);$i++){
       $dni   = $_POST['dni'][$i];
       $codcurso    = $_POST['codcurso'][$i];
       $pruebaA = $_POST['pruebaA'][$i];
       $pruebaB = $_POST['pruebaB'][$i];
       $tipo = $_POST['tipo'][$i];
       $inscripcion = $_POST['inscripcion'][$i];

       if ($dni=='' || $codcurso=='' || $pruebaA=='' || $pruebaB=='' || $tipo=='' || $inscripcion==''){
           $todo_ok = false;
           $mensaje = "Faltan datos en alguno de los contactos.";
           break;
       }else{
        $query="INSERT INTO matricula (dnialumno,codcurso,pruebaA,pruebaB,tipo,inscripcion,  ) VALUES ('$dni', '$codcurso', '$pruebaA', '$pruebaB', '$tipo', '$inscripcion', (SELECT Codigo FROM usuarios WHERE Nombre='$usuario'))";
        $result = $connection->query($query);
        if (!$result) die ("Fatal Error");
       }
   }
        if ($todo_ok){
       $_SESSION['num'] = count($_SESSION['imagenes']);
        header("Location: ejercicio1.php");
        exit();
}

    }
print("ALUMNO: ");
echo htmlentities($_SESSION['dni']);
echo htmlentities($_SESSION['nombreA']);
echo <<<_END
<html>
    <body>
        <h1></h1>
        <h2></h2>
        <form action="ejercicio3.php" method="post">
            <label for="dni">DNI:</label>
            <input type="text" name="dni"><br><br>
            <label for="codcurso">COD CURSO:</label>
            <input type="password" name="codcurso"><br><br>
            <label for="pruebaA">PRUEBA A:</label>
            <input type="password" name="pruebaA"><br><br>
            <label for="usuario">PRUEBA B:</label>
            <input type="text" name="usuario"><br><br>
            <label for="tipo">TIPO:</label>
            <input type="password" name="tipo"><br><br>
            <label for="inscripcion">INSCRIPCION:</label>
            <input type="password" name="inscripcion"><br><br>
            <input type="submit" name="grabar" value="Enviar">
            <p style="color:red;">$error</p>
            
        </form>
    </body>
</html>

_END;
?>

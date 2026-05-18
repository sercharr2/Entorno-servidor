<?php
session_start();

if (!isset($_SESSION['nombre'])) {
    header("Location: index.php");
    exit();
}
if (!isset($_SESSION['imagenes']) || count($_SESSION['imagenes']) == 0) {
    header("Location: inicio.php");
    exit();
}

$hn = 'localhost';
$db = 'agenda';
$un = 'root';
$pw = '';
$connection = new mysqli($hn, $un, $pw, $db);
if ($connection->connect_error) die("Fatal Error");


$mensaje='';

if (isset($_POST['grabar'])) {
   $usuario = $_SESSION['nombre'];
   $todo_ok = true;

   for ($i=0;$i<count($_SESSION['imagenes']);$i++){
       $nombre   = $_POST['nombre'][$i];
       $email    = $_POST['email'][$i];
       $telefono = $_POST['telefono'][$i];

       
       if ($nombre=='' || $email=='' || $telefono==''){
           $todo_ok = false;
           $mensaje = "Faltan datos en alguno de los contactos.";
           break;
       }else{
        $query="INSERT INTO contactos (nombre,email,telefono,codusuario) VALUES ('$nombre', '$email', '$telefono', (SELECT Codigo FROM usuarios WHERE Nombre='$usuario'))";
        $result = $connection->query($query);
        if (!$result) die ("Fatal Error");
       }
   }
        if ($todo_ok){
     $_SESSION['num'] = count($_SESSION['imagenes']);  
        header("Location: grabado.php");
        exit();
}

    }

?>
<html>
    <body>
        <h2>AGENDA</h2>
        <P> Hola <?php echo $_SESSION['nombre']; ?></P>
        <form action="agenda.php" method="post">
            <?php
            for ($i=0;$i<count($_SESSION['imagenes']);$i++){
            echo "<h3>Contacto ".($i+1)."</h3>";
            echo "Nombre: <input type='text' name='nombre[$i]'><br>";
            echo "Email: <input type='text' name='email[$i]'><br>";
            echo "Teléfono: <input type='text' name='telefono[$i]'><br>";
            echo "</div>";
            }
            ?>
            <input type="submit" name="grabar" value="GRABAR">
        </form>
        <?php
        if ($mensaje != ''){
            echo "<p style='color:red;'>$mensaje</p>";
        }
        ?>
    </body>
</html>

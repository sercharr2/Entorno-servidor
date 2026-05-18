<?php

$hn = 'localhost';
$db = 'validacion';
$un = 'root';
$pw = '';



$connection = new mysqli($hn, $un, $pw, $db);
 if ($connection->connect_error) die("Fatal Error");

 $errorNombre='';
 $errorEmail='';
 $errorpass='';
 $errorpassConf='';
 $errorWeb='';
 $errorGenero='';

 $nombre = '';
 $email = '';
 $clave = '';
$confirmarContrasena='';
 $url = '';
 $comentario = '';
 $genero = '';

if (isset($_POST['submit'])) {
        if (empty($_POST['nombre'])){
            $errorNombre = '*El campo nombre es obligatorio';
        }elseif (!preg_match('/^[a-zA-Z\s]+$/', $_POST['nombre'])){
            $errorNombre = 'Solo se permiten letras y espacios';
        }else {
            $nombre = $_POST['nombre'];
        }

        if (empty($_POST['email'])){
            $errorEmail = '*El email es obligatorio';
        }elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
            $errorEmail = 'Formato de email no valido';
        }else {
            $email = $_POST['email'];
        }

        if (empty($_POST['genero'])){
            $errorGenero = '*Seleccione un genero';
        }else {
            $genero = $_POST['genero'];
        }

        if(!empty($_POST['url'])){
            if(!filter_var($_POST['url'], FILTER_VALIDATE_URL)){
                $errorWeb = 'La URL introducida no es valida';
            }
        }else{
            $url= $_POST['url'];
        }

        if (empty($_POST['clave'])){
            $errorpass = '*La contraseña es obligatoria';
        }elseif (!preg_match ('/^(?=.*[A-Za-z])(?=.*\d)(?=.*[^A-Za-z0-9]).+$/', $_POST['clave'])){
            $errorpass = 'Debe tener una letra, un número y un caracter especial';
        } else {
            $clave = $_POST['clave'];
        }

        if (empty($_POST['confirmar_contrasena'])){
            $errorpassConf = 'Debe confirmar la contraseña';
        } elseif ($_POST['clave'] != $_POST['confirmar_contrasena']){
            $errorpassConf = 'Las contraseñas no coinciden';
        }else {
            $confirmarContrasena = $_POST['confirmar_contrasena'];
        }


         if ($errorNombre=='' && $errorEmail=='' && $errorpass=='' && $errorpassConf=='' && $errorWeb=='' && $errorGenero==''){
        $pass=password_hash($clave, PASSWORD_DEFAULT);
 $query = "INSERT INTO usuarios (nombre, email, clave, url, comentario, genero)
              VALUES ('$nombre', '$email','$pass', '$url', '$comentario', '$genero')";  

    $result = $connection->query($query);
    if (!$result) {
        echo "<p style='color:red'>Error al guardar los datos: " . $connection->error . "</p>";
    } else {
        echo "<p style='color:green'>Datos guardados correctamente.</p>";
    }

    }
}
   
 echo <<<_END
<html>
    <body>
        <h2>Formulario de validación</h2>
        <form action="formulario.php" method="post">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre"><span style="color:red">$errorNombre</span><br><br>
            <label for="email">Email</label>
            <input type="email" name="email"><span style="color:red">$errorEmail</span><br><br>
            <label for="contrasena">Contraseña</label>
            <input type="password" name="clave" id="clave"><span style="color:red">$errorpass</span><br><br>
            <label for="confirmar-contrasena">Confirmar contraseña</label>
            <input type="password" name="confirmar_contrasena"><span style="color:red">$errorpassConf</span><br><br>
            <label for ="url">Website</label>
            <input type="text" name="url"><span style="color:red">$errorWeb</span><br><br>
            <label for="comentario">Comentario</label>
            <textarea id="comentario" name="comentario" rows="5" cols="50"></textarea><br><br>
            <label for ="genero">Genero</label>
            <input type="radio" name="genero" value="Masculino">Masculino
            <input type="radio" name="genero" value="Femenino">Femenino <span style="color:red">$errorGenero</span><br><br>
            <input type="submit" name="submit" value="Enviar">
        </form>
    </body>
</html>

_END;

echo "<br><br>";
echo "$nombre";
echo "<br><br>";
echo "$email";
echo "<br><br>";
echo "$url";
echo "<br><br>";
echo "$comentario";
echo "<br><br>";
echo "$genero";

?>
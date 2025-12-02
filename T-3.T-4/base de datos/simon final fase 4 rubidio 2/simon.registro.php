<?php

if(isset($_POST["contraseniaR"]) && isset($_POST["verificaContrasenia"])&& isset($_POST["usuarioR"])){

    $usuarioV = true;
$contraseniaV = false;
$contraseniaEx = '';
$usuarioEx = '';
echo $_POST["contraseniaR"].'  '.$_POST["verificaContrasenia"].'   '.isset($_POST["usuarioR"]).'   ';

if($_POST["contraseniaR"] == $_POST["verificaContrasenia"]){

    $contraseniaV = true;

}

    $conn = new mysqli('localhost', 'root', '', 'bdsimon');
    if ($conn->connect_error)
        die("Fatal Error");


    $query = "SELECT Nombre FROM usuarios";
    $result = $conn->query($query);
    if (!$result)
        die("Fatal Error");

    if ($result->num_rows > 0) {
        // usar while para iterar cada fila y evitar avanzar el puntero varias veces
        while ($row = $result->fetch_assoc()) {

            $nombre1 = $row['Nombre'];

            if ($nombre1 == $_POST['usuarioR']) {

                $usuarioV = false;

            }

        }
    }
    if($usuarioV == false){

       $usuarioEx = "<p style='color: red'>usuario existente, intente con otro</p>";

    }
    if($contraseniaV == false){

        $contraseniaEx = "<p style='color: red'>Eror al introducir la contraseña</p>";

    }
    if($contraseniaV && $usuarioV){

        $nombre = $_POST["usuarioR"];
    $clave = $_POST["contraseniaR"];

    $query = "INSERT INTO `usuarios` (`Nombre`, `Clave`,`Rol`) VALUES ('$nombre','$clave',0)";
    $result = $conn->query($query);
    if (!$result)
        die("Fatal Error");

    echo<<<_END

        <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Simon</title>
</head>
<body>
    <h1>Simón</h1>
        <h2> Registro de sesión:</h2>
        <p>Registro completado</p>
        <p>Pulse el boton para volver al inicio de sesión</p>
    <br>
    <form method="get" action="simon.final.php" style="margin-top:16px;">
    <button type="submit">volver al inicio</button>
    </form>

_END;

    }else{

         echo <<<_END
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Simon</title>
</head>
<body>
    <h1>Simón</h1>
        <h2> Registro de sesión:</h2>
        <p>llena los campos usuario y contraseña con las nuevas credenciales</p>
    <br>
    <form method="post" action="simon.registro.php">
_END;

       echo "<lavel>Usuario</lavel>";
        echo'<input type="text" name="usuarioR" required>' .$usuarioEx ;
        
        
        echo'<lavel>Contraseña</lavel>';
        echo'<input type="password" name="contraseniaR" required><br><br>';
        

        echo'<lavel>Repite la contraseña</lavel>';
        echo'<input type="password" name="verificaContrasenia" required>';
        echo $contraseniaEx;
        echo'<br>';


echo <<<_END

        <input type="submit" value = "Registrarse">

    </form>
    <form method="get" action="simon.final.php" style="margin-top:16px;">
    <button type="submit">volver al inicio</button>
    </form>


_END;


    }

}    
else{

     echo <<<_END
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Simon</title>
</head>
<body>
    <h1>Simón</h1>
        <h2> Registro de sesión:</h2>
        <p>llena los campos usuario y contraseña con las nuevas credenciales</p>
    <br>
    <form method="post" action="simon.registro.php">

        <lavel>Usuario</lavel>
        <input type="text" name="usuarioR" required>
        <br><br>
        
        <lavel>Contraseña</lavel>
        <input type="password" name="contraseniaR" required>
        <br><br>

        <lavel>Repite la contraseña</lavel>
        <input type="password" name="verificaContrasenia" required>
        <br><br>

        <input type="submit" value = "Registrarse">

    </form>
    <form method="get" action="simon.final.php" style="margin-top:16px;">
    <button type="submit">volver al inicio</button>
    </form>


_END;

}
?>
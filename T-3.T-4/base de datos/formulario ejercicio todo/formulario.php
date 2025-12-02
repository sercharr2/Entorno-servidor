<?php

if(isset($_POST["input"])){

    $usuarioV = false;
$contraseniaV = false;
$verificaContraseniaV = false;
$emailV = false;
$websiteV = false;
//variables si no existen
$usuarioE='';
$contraseniaE='';
$verificaContraseniaE='';
$emailE='';
$genderE='';
$websiteE='';

$regexUsuario4 = '/^[a-zA-Z]{3,20}$/';
$regexPassword3 = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/';

echo $_POST["contraseniaR"].'  '.$_POST["verificaContraseniaR"].'   '.$_POST["usuarioR"].'   '.$_POST["emailR"].'   '.$_POST["websiteR"].'   '.$_POST["commentR"].'  '.$_POST["genderR"];

if(isset($_POST["usuarioR"]) && isset($_POST["contraseniaR"]) && isset($_POST["verificaContraseniaR"]) &&isset($_POST["emailR"]) && isset($_POST["genderR"])){

    if($_POST["contraseniaR"] == $_POST["verificaContraseniaR"]){

    $verificaContraseniaV = true;

    }else{
        $verificaContraseniaV = false;
    }

    $conn = new mysqli('localhost', 'root', '', 'bdformulario');
    if ($conn->connect_error)
        die("Fatal Error");


    $query = "SELECT Usuario FROM usuarios";
    $result = $conn->query($query);
    if (!$result)
        die("Fatal Error");

    if ($result->num_rows > 0) {
        // usar while para iterar cada fila y evitar avanzar el puntero varias veces
        while ($row = $result->fetch_assoc()) {

            $nombre1 = $row['Usuario'];

            if ($nombre1 == $_POST['usuarioR']) {

                $usuarioV = true;

            }
        }
    }

    if($usuarioV == false){

       $usuarioE = "<p style='color: red'>*usuario existente, intente con otro</p>";

    }
    if($verificaContraseniaV == false){

        $verificaContraseniaE = "<p style='color: red'>*Eror al introducir la contraseña</p>";

    }

    if(($usuarioV == true) && !(preg_match($regexUsuario4, $_POST['usuarioR'])) ){

        $usuarioE = "<p style='color: red'>*usuario no valido, deve tener solo letras y estar en 3 y 20 caracteres</p>";
        $usuarioV = false;

    }

    if(!preg_match($regexPassword3,$_POST['contraseniaR'])){

        $contraseniaE = "<p style='color: red'>*contraseña no valida, deve tener minimo de 8 caracteres con almenos 1 letra mayuscula, una minuscula, un numero y un caracter especial</p>";
        $contraseniaV = false;

    }else{

        $contraseniaV = true;

    }
    
    if(!filter_var($_POST['emailR'],FILTER_VALIDATE_EMAIL)){

        $emailE = "<p style='color: red'>*email no valido</p>";
        $emailV = false;

    }else{

        $emailV = true;

    }

    if(!filter_var($_POST['websiteR'],FILTER_VALIDATE_URL)){

        $websiteE = "<p style='color: red'>*Url no valida</p>";
        $websiteV = false;

    }else{

        $websiteV = true;

    }
    if($_POST['websiteR'] == null || $_POST['websiteR'] == ''){

        $websiteV = true;

    }


    if($contraseniaV && $usuarioV && $verificaContraseniaV && $emailV && $websiteV){

    $usuario = $_POST["usuarioR"];
    $contraseña = password_hash($_POST["contraseniaR"], PASSWORD_DEFAULT);//$hash = password_hash($clave, PASSWORD_DEFAULT);
    $email = $_POST["emailR"];
    $website = $_POST["websiteR"];
    $gender= $_POST["genderR"];
    $comment= htmlspecialchars($_POST['commentR'], ENT_QUOTES);

    $query = "INSERT INTO `usuario` (`Usuario`, `Contrasenia`,`Gender`,`Email`,`Website`,`Comment`) VALUES ('$usuario','$contraseña','$gender','$email','$website','$comment')";
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
        <h2> PHP form Validation Example</h2>
        <p>Registro completado</p>
        <p>Pulse el boton para volver al inicio</p>
    <br>
    <form method="get" action="formulario.php" style="margin-top:16px;">
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
    <h1>PHP form Validation Example</h1>
    <br>
    <form method="post" action="formulario.php">
_END;

       echo "<lavel>Usuario:</lavel>";
        echo'<input type="text" name="usuarioR">' .$usuarioE ;

        echo'<lavel>E-mail:</lavel>';
        echo'<input type="email" name="emailR">'.$emailE;

        echo'<lavel>Website:</lavel>';
        echo'<input type="text" name="websiteR">'.$websiteE;

        echo'<lavel>Comment:</lavel>';
        echo "<textarea name='commentR'></textarea> <br><br>";

        echo'<lavel>Gender:</lavel>';
        echo"<input type='radio' name='genderR' value='m'>";
        echo"<label>Male</label><br>";
        echo"<input type='radio' name='genderR' value='f'>";
        echo"<label>Female</label><br><br>";
        
        
        echo'<lavel>Contraseña:</lavel>';
        echo'<input type="password" name="contraseniaR">'.$contraseniaE;
        

        echo'<lavel>Repite la contraseña:</lavel>';
        echo'<input type="password" name="verificaContraseniaR">'.$verificaContraseniaE;
        echo'<br>';


echo <<<_END

        <input type="submit" name="input" value = "Registrarse">

    </form>

_END;

        }
    }else{if(!isset($_POST["usuarioR"])|| $_POST["usuarioR"]==''){

        $usuarioE = "Se deve introducir el usuario.";

    }if(!isset($_POST["contraseniaR"])|| $_POST["contraseniaR"]==''){

        $contraseniaE = "Se deve introducir la contraseña.";

    }if(!isset($_POST["verificaContraseniaR"])|| $_POST["verificaContraseniaR"]==''){

        $verificaContraseniaE = "Se deve introducir la contraseña por segunda vez.";

    }if(!isset($_POST["emailR"])|| $_POST["emailR"]==''){

        $emailE = "Se deve introducir el email.";

    }if(!isset($_POST["genderR"])|| $_POST["genderR"]==''){

        $genderE = "Se deve introducir el genero.";

    }

    echo <<<_END
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Simon</title>
</head>
<body>
    <h1>PHP form Validation Example</h1>
    <br>
    <form method="post" action="formulario.php">
_END;

       echo "<lavel>Usuario:</lavel>";
        echo'<input type="text" name="usuarioR">' .$usuarioE ;

        echo'<lavel>E-mail:</lavel>';
        echo'<input type="email" name="emailR">'.$emailE;

        echo'<lavel>Website:</lavel>';
        echo'<input type="text" name="websiteR"><br><br>';

        echo'<lavel>Comment:</lavel>';
        echo "<textarea name='commentR'></textarea> <br><br>";

        echo'<lavel>Gender:</lavel>';
        echo"<input type='radio' name='genderR' value='m'>";
        echo"<label>Male</label><br>";
        echo"<input type='radio' name='genderR' value='f'>";
        echo"<label>Female</label>".$genderE;
        
        
        echo'<lavel>Contraseña:</lavel>';
        echo'<input type="password" name="contraseniaR">'.$contraseniaE;
        

        echo'<lavel>Repite la contraseña:</lavel>';
        echo'<input type="password" name="verificaContraseniaR">'.$verificaContraseniaE;


echo <<<_END

        <input type="submit" name="input" value = "Registrarse">

    </form>

_END;

}
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
    <h1>PHP form Validation Example</h1>
    <form method="post" action="formulario.php">

       <lavel>Usuario:</lavel>
        <input type="text" name="usuarioR"><br><br>

        <lavel>E-mail:</lavel>
        <input type="email" name="emailR"><br><br>

        <lavel>Website:</lavel>
        <input type="text" name="websiteR"><br><br>

        <lavel>Comment:</lavel>
        <textarea name='commentR'></textarea><br><br>

        <lavel>Gender:</lavel>
        <input type='radio' name='genderR' value='m'>
        <label>Male</label>
        <input type='radio' name='genderR' value='f'>
        <label>Female</label><br><br>
        
        
        <lavel>Contraseña:</lavel>
        <input type="password" name="contraseniaR"><br><br>
        

        <lavel>Repite la contraseña:</lavel>
        <input type="password" name="verificaContraseniaR">
        <br><br>

        <input type="submit" name="input" value = "Registrarse">

    </form>

_END;

}
?>
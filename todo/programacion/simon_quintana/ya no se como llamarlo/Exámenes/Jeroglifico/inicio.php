<?php

session_start();

        function sanitizeString($var)
        {
            $var = strip_tags($var);
            $var = htmlentities($var);
            $var = stripslashes($var);
            return $var;
        }
$error = "";

if(!isset($_SESSION['usuario'])){
    header("Location: index.php");
    exit();
} else {
    require_once 'login.php';

    $conn = new mysqli($hn, $un, $pw, $db);
    if ($conn->connect_error) die("Fatal Error");

    if(isset($_POST['solucion'])){

        if(!empty($_POST['solucion'])){

        $nombre = $_SESSION['nombre'];
        $login = $_SESSION['usuario'];

        

        $solucion = sanitizeString($_POST['solucion']);

        $sql = "INSERT INTO respuestas (fecha, login, hora, respuesta) VALUES (CURDATE(), '$login', CURTIME(), ?)";

        $stmt = $conn->prepare($sql);

        $stmt->bind_param('s',$solucion);

        $stmt->execute();
        $error = "Respuesta enviada correctamente.";
        $stmt->close();
        $conn->close();
            } else {
                $error = "Por favor, ingrese una solución válida.";
    }
}
} 

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Bienvenido, <?php echo $_SESSION['nombre']?>!</h1><br>
    <img src="20240216.jpg" alt="" width="300" height="300"><br><br>
    <form method="post">
        <?php if($error != "") echo "<p style='color: red;'>$error</p><br>"  ?>
        Solución del jeroglífico: <input type="text" name="solucion"><br><br>
        <input type="submit" value="Enviar"><br>
        <a href="puntos.php">Ver puntos por jugador</a><br>
        <a href="resultado.php">Resultados del día</a>
    </form>
</body>
</html>
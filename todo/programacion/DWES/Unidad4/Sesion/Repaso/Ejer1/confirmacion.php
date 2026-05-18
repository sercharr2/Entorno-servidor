<?php
    session_start();
    
    $nombre = $_SESSION["nombre"];
    $passwd = $_SESSION["passwd"];

    if(isset($_POST["btnSi"])){
        header("Location: login.php");
        exit;
    }

    if(isset($_POST["btnNo"])){
        header("Location: inicio.php");
        exit;
    }
''
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h4>Los datos introducidos son los siguientes:</h4>
    <p>Usuario: <?php echo $nombre ?></p>
    <p>Contraseña: <?php echo $passwd ?></p>

    <p>¿Son correctos?</p>
    <form action="confirmacion.php" method="POST">
        <input type="submit" name="btnSi" value="Si">
        <input type="submit" name="btnNo" value="No">
    </form>
    
</body>
</html>
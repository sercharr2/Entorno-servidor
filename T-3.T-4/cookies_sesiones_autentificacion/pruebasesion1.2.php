<?php // formtest2.php
 if (isset($_POST['jugador1'])&&isset($_POST['jugador2'])&&isset($_POST['jugador3'])){

}

else{
       echo <<<_END
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
  <form method="post" action="pruebasesion1.3.php">
   
    <label>jugador1:</label>
        <input type="text" name="jugador1" required>
        <br><br>
    <label>jugador2:</label>
        <input type="text" name="jugador2" required>
        <br><br>
    <label>jugador3:</label>
        <input type="text" name="jugador3" required>
        <br><br>

    <input type="submit" value = "jugar">
 </form>
</body>
</html>
_END;

session_start();
        $_SESSION['nombre'] = $_POST['nombre'];

}
?>
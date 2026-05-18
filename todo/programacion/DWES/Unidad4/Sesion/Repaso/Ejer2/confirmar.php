<?php
    session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmar</title>
</head>
<body>
    <h1>Felicidades</h1>
    <h4>Usted acaba de adquirir</h4>

    <?php 
        foreach ($_SESSION["carrito"] as $id => $cantidad) {
            echo $cantidad ." " .$id ."<br>";
        }        
    ?>

    <h4>Gracias por su compra.</h4>
    <form action="formulario.php" method="POST">
        <input type="submit"  value="Terminar">
    </form>
</body>
</html>
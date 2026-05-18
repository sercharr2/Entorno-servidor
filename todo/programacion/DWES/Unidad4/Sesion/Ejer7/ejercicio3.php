<?php
    session_start();
    echo "<br>ALUMNO:    " .$_SESSION["dni"] ." NOMBRE:  " .$_SESSION["nombre"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio3</title>
</head>
<body>
    <br><br>
    <form action="ejercicio3.php" method="post">
        <label for="nombre">DNI: </label>
        <span>
            <?php
                echo $_SESSION["dni"];
            ?>
        </span>

        <br><br>
        <label for="passwd">COD CURSO: </label>
        <input type="text" id="codcurso" name="codcurso">  

        <br><br>
        <label for="email">PRUEBA A: </label>
        <input type="number" id="pruebaA" name="pruebaA">

        <br><br>
        <label for="website">PRUEBA B: </label>
        <input type="number" id="pruebaB" name="pruebaB">

        <br><br>
        <label for="comentario">TIPO: </label>
        <input type="text" id="tipo" name="tipo">
    
        <br><br>
        <label for="genero">INSCRIPCIÓN: </label>
        <input type="date" id="inscripcion" name="inscripcion"> 

        <br><br>
        <input type="submit" name="boton" value="GUARDAR">
    </form>
</body>
</html>
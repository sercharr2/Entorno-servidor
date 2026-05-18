<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grabado</title>
</head>
<body>
    <h1>Agenda</h1>
    <?php
        session_start();
        echo "Hola " .$_SESSION["nombre"];
        echo "<br>Se han introducido " .$_SESSION["contador"] ." de " .$_SESSION["nombre"];
    ?>
    <br><form action="index.php" method="post" style="display:inline;">
        <input type="submit" value="Volver a iniciar sesion">
    </form>
    <br><form action="inicio.php" method="post" style="display:inline;">
        <input type="submit" value="Introducir mas contactos">
    </form>
    <br><form action="totales.php" method="post" style="display:inline;">
        <input type="submit" value="Total de contactos guardados">
    </form>
</body>
</html>
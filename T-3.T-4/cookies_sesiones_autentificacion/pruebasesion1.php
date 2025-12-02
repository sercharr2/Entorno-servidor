<?php // formtest2.php
if (isset($_POST['nombre'])) {

} else {
    echo <<<_END
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
 <form method="post" action="pruebasesion1.2.php">

    <label>Nombre:</label>
        <input type="text" name="nombre" required>
        <br><br>

    <input type="submit" value = "jugar">
 </form>
 </form>
</body>
</html>
_END;
}
?>
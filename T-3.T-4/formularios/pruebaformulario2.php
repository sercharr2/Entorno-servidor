<?php // formtest2.php
 if (isset($_POST['n1']) && isset($_POST['n2'])) echo "suma: ".($_POST["n1"]+$_POST["n2"]);
else
 
 
echo <<<_END
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
   
    <form method="post" action="pruebaformulario2.php">
     numero 1: 
     <input type="number" name="n1">
     <br>
     numero 2:
     <input type="number" name="n2">
     <br>
    <input type="submit" value= "suma">
 </form>
</body>
</html>
_END;
?>
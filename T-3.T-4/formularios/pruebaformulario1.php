<?php // formtest2.php
 if (isset($_POST['name'])) echo "$_POST[name]";
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
   
    <form method="post" action="pruebaformulario1.php">
     What is your name?
     <input type="text" name="name">
    <input type="submit">
 </form>
</body>
</html>
_END;
?>
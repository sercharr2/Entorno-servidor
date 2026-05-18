<?php
$vector = [];

for ($i = 0; $i < 4; $i++) {
    $vector[] = rand(0, 1);
}
$vector1 = [8, 4, 2, 1];
$producto = array_sum(array_map(fn($x, $y) => $x * $y, $vector, $vector1));

echo "El valor en decimal del numero binario es : $producto";
?>
<html>
<head>
    <title></title>
</head>
<body>
    <form method="post" action="">
        <label for="num1">Número 1:</label>
        <input id="num1" name="num1">
        <br><br>
<img src="img/foto.jpg" alt="Descripción de la imagen">
     
    
        <label for="num2">Número 2:</label>
        <input id="num2" name="num2">
        <br><br>

        <input type="submit" id="button" name="boton" value="Enviar">
    </form>
</body>
</html>
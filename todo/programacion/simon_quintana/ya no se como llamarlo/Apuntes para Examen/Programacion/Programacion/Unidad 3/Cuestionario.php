<?php
if (isset($_POST['num1']) && isset($_POST['num2'])) {
    $num1 = intval($_POST['num1']);
    $num2 = intval($_POST['num2']);
    $resultado = $num1 + $num2;

    echo "El resultado es: $resultado";
} else {
    echo <<<_END
<html>
<head>
    <title>Form Test</title>
</head>
<body>
    <form method="post" action="Ejemplo_Suma_Formulario.php">
        <label for="num1">Número 1:</label>
        <input id="num1" name="num1">
        <br><br>

        <label for="num2">Número 2:</label>
        <input id="num2" name="num2">
        <br><br>

        <input type="submit" id="button" name="boton" value="Enviar">
    </form>
</body>
</html>
_END;
}
?>

<?php
// Tercera versión del formulario de suma

echo <<<END
<html>
<head>
    <title>Form Test</title>
</head>
<body>
    <form method="post" action="pruebaformulario5.php">
        <p>Pon 2 números para sumar:</p>
        <br><br>

        <label>Número 1:</label>
        <input type="number" name="Numero1" required>
        <br><br>

        <label>Número 2:</label>
        <input type="number" name="Numero2" required>
        <br><br>

        <label for="operacion">Operación:</label>
        <select id="operacion" name="operacion" required>
            <option value="suma">Suma (+)</option>
            <option value="resta">Resta (-)</option>
            <option value="multiplicacion">Multiplicación (×)</option>
            <option value="division">División (÷)</option>
        </select>
        <br><br>

        <input type="submit" value="calcula">
    </form>
</body>
</html>
END;

if (isset($_POST['Numero1']) && isset($_POST['Numero2']) && isset($_POST['operacion'])) {
    switch($_POST['operacion']) {

    case 'suma':
        $resultado = $_POST['Numero1'] + $_POST['Numero2'];
        echo("El resultado de la suma es: ".$resultado);
        break;
    case 'resta':
        $resultado = $_POST['Numero1'] - $_POST['Numero2'];
        echo("El resultado de la resta es: ".$resultado);
        break;
    case 'multiplicacion':
        $resultado = $_POST['Numero1'] * $_POST['Numero2'];
        echo("El resultado de la multiplicacion es: ".$resultado);
        break;
    case 'division':
        $resultado = $_POST['Numero1'] / $_POST['Numero2'];
        echo("El resultado de la division es: ".$resultado);
        break;


}
}
?>

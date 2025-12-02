<?php
// Tercera versión del formulario de suma

echo <<<END
<html>
<head>
    <title>Form Test</title>
</head>
<body>
    <form method="post" action="pruebaformulario3.2.php">
        <p>Pon 2 números para sumar:</p>
        <br><br>

        <label>Número 1:</label>
        <input type="number" name="Numero1" required>
        <br><br>

        <label>Número 2:</label>
        <input type="number" name="Numero2" required>
        <br><br>

        <input type="submit" value="Sumar">
    </form>
</body>
</html>
END;

if (isset($_POST['Numero1']) && isset($_POST['Numero2'])) {
    $suma = $_POST['Numero1'] + $_POST['Numero2'];
    echo "La suma de ambos números es: $suma";
}
?>

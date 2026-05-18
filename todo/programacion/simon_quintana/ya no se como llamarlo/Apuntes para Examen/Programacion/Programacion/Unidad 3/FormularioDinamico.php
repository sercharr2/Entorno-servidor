<?php
// Si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "<h2>Resultados:</h2>";

    // Recorremos los 10 números enviados
    for ($i = 0; $i < 10; $i++) {
        $num = htmlspecialchars($_POST['numeros'][$i]);
        echo "El número " . ($i + 1) . " es $num<br>";
    }

} else {
    // Mostramos el formulario inicial con 10 campos
    echo <<<_END
<html>
<head>
    <title>Formulario Dinámico</title>
</head>
<body>
    <h2>Introduce 10 números</h2>
    <form method="post" action="FormularioDinamico.php">
_END;

    // Generamos los 10 inputs con un bucle
    for ($i = 1; $i <= 10; $i++) {
        echo "<label for='num$i'>Número $i:</label> ";
        echo "<input type='number' id='num$i' name='numeros[]' required><br><br>";
    }

    // Botón de envío
    echo <<<_END
        <input type="submit" value="Mostrar los numeros">
    </form>
</body>
</html>
_END;
}
?>

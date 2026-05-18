<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 1) Si ya se enviaron los números: mostrar resultados
    if (isset($_POST['numeros']) && is_array($_POST['numeros'])) {
        echo "<h2>Resultados:</h2>";
        for ($i = 0; $i < count($_POST['numeros']); $i++) {
            $num = htmlspecialchars((string)$_POST['numeros'][$i], ENT_QUOTES, 'UTF-8');
            echo "El número " . ($i + 1) . " es $num<br>";
        }

    // 2) Si se envió la cantidad: generar esa cantidad de inputs
    } elseif (isset($_POST['cantidad'])) {
        $cantidad = (int) $_POST['cantidad'];

        echo <<<_END
<html>
<head>
    <title>Formulario Dinámico</title>
</head>
<body>
    <h2>Introduce $cantidad números</h2>
  
_END;

        // Generamos inputs según la cantidad
        for ($i = 1; $i <= $cantidad; $i++) {
            echo "<label for='num$i'>Número $i:</label> ";
            echo "<input type='number' id='num$i' name='numeros[]' required><br><br>";
        }

        echo <<<_END
        <input type="submit" value="Mostrar los números">
    </form>
</body>
</html>
_END;
    }

} else {
    // 0) Formulario inicial: pedir la cantidad
    echo <<<_END
<html>
<head>
    <title>Formulario Dinámico</title>
</head>
<body>
    <h2>¿Cuántos números quieres introducir?</h2>
        <label for="cantidad">Cantidad:</label>
        <input type="number" id="cantidad" name="cantidad" min="1" required>
        <input type="submit" value="Continuar">
    </form>
</body>
</html>
_END;
}
?>


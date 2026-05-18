<?php

// Comprobamos si se han enviado los 6 campos del formulario
$campos = ["00","01","10","11","20","21"];
$enviado = true;
foreach ($campos as $c) {
    if (!isset($_POST[$c])) { $enviado = false; break; }
}

if ($enviado) {

    $error = false;
    $errortext = "";

    // Validar que todos los valores estén entre 1 y 100
    foreach ($campos as $c) {
        $v = $_POST[$c];
        if ($v < 1 || $v > 100) {
            $error = true;
            $errortext = "<p style='color:red;'>*El valor debe estar entre 1 y 100</p>";
            break;
        }
    }

    if ($error) {

        // Mostrar formulario con mensaje de error
        echo <<<_END
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ejercicio 1</title>
</head>
<body>
    <form method="post" action="ejercicio1.php">
        <table border="1">
_END;
        for ($i = 0; $i <= 2; $i++) {
            echo "<tr>";
            for ($j = 0; $j <= 1; $j++) {
                echo "<td><label>E.$i.$j</label> <input type='number' name='{$i}{$j}' required></td>";
            }
            echo "</tr>";
        }
        echo <<<_END
        </table>
        $errortext
        <input type="submit" value="Calcular">
    </form>
</body>
</html>
_END;

    } else {

        // Mostrar resultados en binario
        echo <<<_END
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultado</title>
</head>
<body>
_END;
        foreach ($campos as $c) {
            $n   = $_POST[$c];
            $bin = decbin($n);
            echo "<p>$n = '$bin'</p>\n";
        }
        echo "</body></html>";
    }

} else {

    // Primera carga: mostrar formulario vacío
    echo <<<_END
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ejercicio 1</title>
</head>
<body>
    <form method="post" action="ejercicio1.php">
        <table border="1">
_END;
    for ($i = 0; $i <= 2; $i++) {
        echo "<tr>";
        for ($j = 0; $j <= 1; $j++) {
            echo "<td><label>E.$i.$j</label> <input type='number' name='{$i}{$j}' required></td>";
        }
        echo "</tr>";
    }
    echo <<<_END
        </table>
        <input type="submit" value="Calcular">
    </form>
</body>
</html>
_END;
}
?>

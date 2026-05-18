<?php
session_start();

// a) Generar número aleatorio de 0 a 15 (4 bits)
$decimal = rand(0, 15);

// b) Guardar en sesión para comparar después
$_SESSION['numero'] = $decimal;

// a) Vector con el número binario de 4 posiciones
$binario = [
    ($decimal >> 3) & 1,   // bit 3 → potencia 8
    ($decimal >> 2) & 1,   // bit 2 → potencia 4
    ($decimal >> 1) & 1,   // bit 1 → potencia 2
    ($decimal >> 0) & 1,   // bit 0 → potencia 1
];

// b) Segundo vector con potencias de 2
$potencias = [8, 4, 2, 1];

// Calcular el decimal (verificación)
$decimalCalculado = 0;
for ($i = 0; $i < 4; $i++) {
    $decimalCalculado += $binario[$i] * $potencias[$i];
}

// String binario para mostrar
$binStr = implode('', $binario);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Adivina el número en decimal</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; }
        h1   { font-size: 2em; }

        /* c) Representación gráfica de las cartas */
        .cartas {
            display: flex;
            gap: 10px;
            margin: 20px 0;
        }
        .carta {
            width: 80px;
            height: 120px;
            border: 2px solid #333;
            border-radius: 8px;
            display: flex;
            flex-wrap: wrap;
            align-content: center;
            justify-content: center;
            gap: 5px;
            padding: 6px;
            box-sizing: border-box;
            background-color: #fff;
        }
        .carta.vacia {
            background-color: #f0f0f0;
        }
        .punto {
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background-color: #c00;
        }
    </style>
</head>
<body>

    <h1>Adivina el número en decimal</h1>
    <p><strong>El número en BINARIO: <?= $binStr ?></strong></p>

    <!-- c) Representación gráfica de las cartas -->
    <div class="cartas">
<?php
for ($i = 0; $i < 4; $i++) {
    if ($binario[$i] == 1) {
        echo "        <div class=\"carta\">\n";
        // Mostrar tantos puntos como vale la potencia
        for ($p = 0; $p < $potencias[$i]; $p++) {
            echo "            <div class=\"punto\"></div>\n";
        }
        echo "        </div>\n";
    } else {
        echo "        <div class=\"carta vacia\"></div>\n";
    }
}
?>
    </div>

    <!-- Formulario para que el jugador introduzca su respuesta -->
    <form method="post" action="ejercicio21.php">
        <label>Número decimal:</label>
        <input type="number" name="respuesta" required>
        <input type="submit" value="Enviar">
    </form>

</body>
</html>

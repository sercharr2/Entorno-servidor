<?php
session_start();
require 'pintar_circulos.php';

$colores_correctos = $_SESSION['colores-correctos'];
$colores_escogidos = $_SESSION['colores-escogidos'];

echo "<h2>Lo sentimos, has fallado</h2>";
echo "<p>Combinación correcta:</p>";
pintar_circulos($colores_correctos);

echo "<p>Tu combinación:</p>";
pintar_circulos($colores_escogidos);

echo '<br><a href="dificultad.php">Volver a jugar</a>';
?>
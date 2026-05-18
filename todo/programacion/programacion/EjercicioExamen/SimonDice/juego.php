<?php
session_start();
require_once __DIR__ . '/pintar-circulos.php';

/* Paleta de 4 colores */
$paleta = ['red','blue','yellow','green'];

/* Generar 4 colores aleatorios (rand(0,3) — el rand original estaba mal) */
$seq = [
  $paleta[rand(0,3)],
  $paleta[rand(0,3)],
  $paleta[rand(0,3)],
  $paleta[rand(0,3)]
];


$_SESSION['sim_seq'] = $seq;
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Simón — Inicio</title>
</head>
<body style="font-family: Arial, sans-serif; text-align:center;">
  <h1>SIMÓN</h1>
  <h3>Memoriza la combinación</h3>

  <?php pintar_circulos($seq[0], $seq[1], $seq[2], $seq[3]); ?>

  <form action="juego.php" method="get" style="margin-top:16px;">
    <button type="submit">VAMOS A JUGAR</button>
  </form>
</body>
</html>

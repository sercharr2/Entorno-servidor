<?php

if(isset($_POST["filtro"])){

session_start();
$nombre = $_SESSION['nombre'];
$cantidadColor = $_POST['cantidadColor'];
$cantidadCirculo = $_POST['cantidadCirculo'];

$conn = new mysqli('localhost', 'root', '', 'bdsimon2');
if ($conn->connect_error)
    die("Fatal Error");

$query = "SELECT * FROM jugadas";
$result = $conn->query($query);
if (!$result)
    die("Fatal Error");

echo<<<_END

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8" />
<title>Gráfica de aciertos</title>
<style>
  body { font-family: Arial, sans-serif; padding:20px; }
  table { border-collapse: collapse; width: 720px; max-width:100%; }
  th, td { border: 1px solid #bbb; padding: 6px 8px; text-align: left; vertical-align: middle; }
  th { background:#f3f3f3; }
  .num { width:80px; text-align:center; white-space: nowrap; }
  .bar-wrap { width: 280px; min-width:140px; }
  .bar-bg {
    height: 18px;
    border-radius: 4px;
    background:#eee;
    position: relative;
    overflow: hidden;
  }
  .bar {
    height: 100%;
    border-radius: 4px;
    background: linear-gradient(90deg,#1f77b4,#0b66a3);
    box-shadow: inset 0 -2px 0 rgba(0,0,0,0.2);
  }
  caption { font-weight: bold; margin-bottom:8px; text-align:left; }
</style>
</head>
<body>
    <h1>Simón</h1>
        <h2> $nombre, los resultados de Simón por ususario son:</h2> 
<table>
  <caption></caption>
  <thead>
    <tr>
      <th>Código jugada</th>
      <th>Codigo usuario</th>
      <th class="num">Número Circulo</th>
      <th class="num">Número Colores</th>
      <th class="num">acierto</th>
    </tr>

_END;


if ($result->num_rows > 0) {
    // usar while para iterar cada fila y evitar avanzar el puntero varias veces
    while ($row = $result->fetch_assoc()) {

      if($cantidadCirculo == null || $cantidadCirculo<0){

        if($row['numColores']== $cantidadColor){
      
        echo '<tr>';

        echo '<td>' . htmlspecialchars($row['codjugada']) . '</td>';
        echo '<td>' . htmlspecialchars($row['codigousu']) . '</td>';
        echo '<td>' . htmlspecialchars($row['numCirculos']) . '</td>';
        echo '<td>' . htmlspecialchars($row['numColores']) . '</td>';
        echo '<td>' . htmlspecialchars($row['acierto']) . '</td>';

        echo '</tr>';

      }elseif($cantidadColor == null || $cantidadColor<0){

        if($row['numCirculo']== $cantidadCirculo){
      
        echo '<tr>';

        echo '<td>' . htmlspecialchars($row['codjugada']) . '</td>';
        echo '<td>' . htmlspecialchars($row['codigousu']) . '</td>';
        echo '<td>' . htmlspecialchars($row['numCirculos']) . '</td>';
        echo '<td>' . htmlspecialchars($row['numColores']) . '</td>';
        echo '<td>' . htmlspecialchars($row['acierto']) . '</td>';

        echo '</tr>';
      }

      }elseif($cantidadCirculo == null || $cantidadCirculo<0 || $cantidadColor == null || $cantidadColor<0){

         echo '<tr>';

        echo '<td>' . htmlspecialchars($row['codjugada']) . '</td>';
        echo '<td>' . htmlspecialchars($row['codigousu']) . '</td>';
        echo '<td>' . htmlspecialchars($row['numCirculos']) . '</td>';
        echo '<td>' . htmlspecialchars($row['numColores']) . '</td>';
        echo '<td>' . htmlspecialchars($row['acierto']) . '</td>';

        echo '</tr>';

      }else{

        if(($row['numCirculos']== $cantidadCirculo)&&($row['numColores']== $cantidadColor)){
      
        echo '<tr>';

        echo '<td>' . htmlspecialchars($row['codjugada']) . '</td>';
        echo '<td>' . htmlspecialchars($row['codigousu']) . '</td>';
        echo '<td>' . htmlspecialchars($row['numCirculos']) . '</td>';
        echo '<td>' . htmlspecialchars($row['numColores']) . '</td>';
        echo '<td>' . htmlspecialchars($row['acierto']) . '</td>';

        echo '</tr>';
      }

      }
    }
    } 
    }else {
    echo "No hay resultados.";
    }

echo<<<_END


  </thead>
  <tbody id="table-body">
  </tbody>
</table>

<form method="get" action="estadisticas.jugada.php" style="margin-top:16px;">
      <label>Nivel de dificultad: </label>
        <label>Circulos</label>
        <input type="number" name="cantidadCirculo" min="1">
        <label>Colores</label>
        <input type="number" name="cantidadColor" min="1">
    <button type="submit" name="filtro">filtrar</button>
  </form>

<form method="get" action="estadisticas.jugador.php" style="margin-top:16px;">
    <button type="submit">estadisticas por jugador</button>
    </form>
<form method="get" action="estadisticas.jugada.php" style="margin-top:16px;">
    <button type="submit">estadisticas por jugada</button>
    </form>

    <br>
<form method="get" action="simon.final.php" style="margin-top:16px;">
    <button type="submit">Volver a jugar</button>
    </form>

_END;

}
else{
session_start();
$nombre = $_SESSION['nombre'];

$conn = new mysqli('localhost', 'root', '', 'bdsimon2');
if ($conn->connect_error)
    die("Fatal Error");

$query = "SELECT * FROM jugadas";
$result = $conn->query($query);
if (!$result)
    die("Fatal Error");

echo<<<_END

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8" />
<title>Gráfica de aciertos</title>
<style>
  body { font-family: Arial, sans-serif; padding:20px; }
  table { border-collapse: collapse; width: 720px; max-width:100%; }
  th, td { border: 1px solid #bbb; padding: 6px 8px; text-align: left; vertical-align: middle; }
  th { background:#f3f3f3; }
  .num { width:80px; text-align:center; white-space: nowrap; }
  .bar-wrap { width: 280px; min-width:140px; }
  .bar-bg {
    height: 18px;
    border-radius: 4px;
    background:#eee;
    position: relative;
    overflow: hidden;
  }
  .bar {
    height: 100%;
    border-radius: 4px;
    background: linear-gradient(90deg,#1f77b4,#0b66a3);
    box-shadow: inset 0 -2px 0 rgba(0,0,0,0.2);
  }
  caption { font-weight: bold; margin-bottom:8px; text-align:left; }
</style>
</head>
<body>
    <h1>Simón</h1>
        <h2> $nombre, los resultados de Simón por ususario son:</h2> 
<table>
  <caption></caption>
  <thead>
    <tr>
      <th>Código jugada</th>
      <th>Codigo usuario</th>
      <th class="num">Número Circulos</th>
      <th class="num">Número Colores</th>
      <th class="num">acierto</th>
    </tr>

_END;


if ($result->num_rows > 0) {
    // usar while para iterar cada fila y evitar avanzar el puntero varias veces
    while ($row = $result->fetch_assoc()) {
        
        echo '<tr>';

        echo '<td>' . htmlspecialchars($row['codjugada']) . '</td>';
        echo '<td>' . htmlspecialchars($row['codigousu']) . '</td>';
        echo '<td>' . htmlspecialchars($row['numCirculos']) . '</td>';
        echo '<td>' . htmlspecialchars($row['numColores']) . '</td>';
        echo '<td>' . htmlspecialchars($row['acierto']) . '</td>';

    }
} else {
    echo "No hay resultados.";
}

echo<<<_END


  </thead>
  <tbody id="table-body">
  </tbody>
</table>

<form method="get" action="estadisticas.jugada.php" style="margin-top:16px;">
      <label>Nivel de dificultad: </label>
        <label>Circulos</label>
        <input type="number" name="cantidadCirculo" min="1">
        <label>Colores</label>
        <input type="number" name="cantidadColor" min="1">
    <button type="submit" name="filtro">filtrar</button>
  </form>

<form method="get" action="estadisticas.jugador.php" style="margin-top:16px;">
    <button type="submit">estadisticas por jugador</button>
    </form>
<form method="get" action="estadisticas.jugada.php" style="margin-top:16px;">
    <button type="submit">estadisticas por jugada</button>
    </form>

    <br>
<form method="get" action="simon.final.php" style="margin-top:16px;">
    <button type="submit">Volver a jugar</button>
    </form>

_END;
}

?>
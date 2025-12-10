<?php
session_start();
$nombre = $_SESSION['nombre'];

$conn = new mysqli('localhost', 'root', '', 'bdsimon2');
if ($conn->connect_error)
    die("Fatal Error");

$query = "SELECT * FROM usuarios";
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
      <th>Código usuario</th>
      <th>Nombre</th>
      <th class="num">Número aciertos</th>
      <th class="num">Número intentos</th>
      <th>Gráfica</th>
    </tr>

_END;


if ($result->num_rows > 0) {
    // usar while para iterar cada fila y evitar avanzar el puntero varias veces
    while ($row = $result->fetch_assoc()) {
        
        echo '<tr>';

        echo '<td>' . htmlspecialchars($row['Codigo']) . '</td>';
        $codigo = $row['Codigo'];
        echo '<td>' . htmlspecialchars($row['Nombre']) . '</td>';

        $query2 = "SELECT SUM(acierto) FROM `jugadas` WHERE codigousu = '$codigo';";
        $result2 = $conn->query($query2);
        if (!$result2)
            die("Fatal Error");

        $row2 = $result2->fetch_assoc();

        $aciertos = $row2['SUM(acierto)'];


        $query3 = "SELECT COUNT(acierto) FROM `jugadas` WHERE codigousu = '$codigo';";
        $result3 = $conn->query($query3);
        if (!$result3)
            die("Fatal Error");

        $row3 = $result3->fetch_assoc();

        $intentos = $row3['COUNT(acierto)'];

        echo '<td class="num">' . htmlspecialchars($aciertos) . '</td>';
        echo '<td class="num">' . htmlspecialchars($intentos) . '</td>';

        echo<<<_END
            <td>
                <div class="bar-wrap">
                    <div class="bar-bg">
        _END;

        echo '<div class="bar" style="width: '.($aciertos/$intentos)*100 .'% "></div>';

        echo<<<_END
        </div>
            </div>
                </td>
        _END;

        echo '</tr>';

    }
} else {
    echo "No hay resultados.";
}

echo<<<_END


  </thead>
  <tbody id="table-body">
  </tbody>
</table>

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

?>
<?php
session_start();

if (!isset($_SESSION['nombre'])) {
    header("Location: index.php");
    exit();
}

$usuario = $_SESSION['nombre'];

$hn = 'localhost';
$db = 'agenda';
$un = 'root';
$pw = '';
$connection = new mysqli($hn, $un, $pw, $db);
if ($connection->connect_error) die("Fatal Error");

$query="Select u.codigo,u.nombre, COUNT(c.codusuario) AS total
        FROM usuarios u
        LEFT JOIN contactos c ON u.codigo=c.codusuario
        GROUP BY u.codigo,u.nombre";
$result = $connection->query($query);
if (!$result) die ("Fatal Error");
?>

<html>
    <body>
        <h2>AGENDA</h2>
        <p>Hola <?php echo $usuario; ?></p>

        <a href="index.php">Volver al loguearse</a><br>
        <a href="inicio.php">Introducir más contactos para <?php echo $usuario; ?></a><br><br>

        <table border="1" cellpadding="5">
            <tr>
                <th>Código usuario</th>
                <th>Nombre</th>
                <th>Número de contactos</th>
                <th>Gráfica</th>
            </tr>
  <?php
    while ($row = $result->fetch_assoc()) {
      echo "<tr>";
      echo "<td>" . $row['codigo'] . "</td>";
      echo "<td>" . $row['nombre'] . "</td>";
      echo "<td>" . $row['total'] . "</td>";

    $ancho = $row['total'] * 10;
    echo "<td><div style='background-color:blue; height:20px; width:" . $ancho . "px;'></div></td>";
    echo "</tr>";
    }
   $result->close();
   $connection->close();
?>
        </table>
    </body>
</html>
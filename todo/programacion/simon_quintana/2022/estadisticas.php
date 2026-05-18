<?php
session_start();
require_once 'login.php';

$conn = new mysqli($hn, $un, $pw, $db);
if ($conn->connect_error) die("Error fatal de conexión");

$sql = "SELECT usuarios.Nombre, usuarios.Codigo, COUNT(jugadas.acierto) as acierto
        FROM usuarios INNER JOIN jugadas 
        WHERE acierto = 1 AND jugadas.codigousu = usuarios.Codigo 
        GROUP BY usuarios.Nombre";

$result = $conn->query($sql)

?>
<style>

table {
            border-collapse: collapse;
            width: 80%;
            margin: 20px auto;
        }
        th, td {
            border: 1px solid black;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }

.barra-grafica {
            background-color: blue; /* Color de la barra */
            height: 20px;           /* Altura fija */
        }</style>
<table>
        <thead>
            <tr>
                <th>Código usuario</th>
                <th>Nombre</th>
                <th>Número aciertos</th>
                <th>Gráfica</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Recorremos los resultados de la base de datos
            while ($fila = $result->fetch_assoc()) {
                $codigo = $fila['Codigo'];
                $nombre = $fila['Nombre'];
                $aciertos = $fila['acierto'];

                // CALCULO DE LA GRÁFICA 
                // Multiplicamos los aciertos por un número (ej. 20px) para que la barra se vea bien.
                // Si tiene 2 aciertos, la barra medirá 40px.
                $ancho_barra = $aciertos * 20; 
                ?>
                <tr>
                    <td><?php echo $codigo; ?></td>
                    <td><?php echo $nombre; ?></td>
                    <td><?php echo $aciertos; ?></td>
                    <td style="text-align: left;"> <div class="barra-grafica" style="width: <?php echo $ancho_barra; ?>px;"></div>
                    </td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>

    <div style="text-align: center;">
        <a href="inicio.php">Volver a jugar</a>
    </div>

</body>
</html>
<?php
$conn->close();
?>
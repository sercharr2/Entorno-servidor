

<?php
session_start();
require_once 'db.php';

 $puntosGanados=$_SESSION["puntosGanado"];
 $tiradas=$_SESSION["tiradas"];
 $login = $_SESSION['login'];

// Actualizar puntos
    $query = "UPDATE jugadores SET puntos = puntos + ?, extra = extra + ? WHERE login=?";
        $result = $conexion->prepare($query);

        $result -> bind_param("iis",$puntosGanados,$tiradas,$login);
        $result -> execute();

echo "<h1>Bienvenid@, $login:</h1>";

    if($puntosGanados<0){

        echo("Mala suerte. Has perdido ".$puntosGanados." puntos");

    }else{

        echo("Buena suerte. Has ganado ".$puntosGanados." puntos");

    }

    echo<<<_END
        <h2>Puntos ganados: $puntosGanados</h2>
        <h3>Total de jugadas: $tiradas</h3>
    _END;

// Consulta para ver victorias y partidas de cada jugador
$query = "SELECT login,puntos,extra
          FROM jugadores GROUP BY login";
$result = $conexion->query($query);

// Pintamos tabla con resultados
echo "<h1>Puntos por jugador</h1>";
echo "<table border=1>";
echo "<tr><th>Usuario</th><th>Puntos</th><th>Extra(tiradas)</th></tr>";
while ($fila = $result->fetch_assoc()) {
    echo "<tr><td>".$fila['login']."</td><td>".$fila['puntos']."</td><td>".$fila['extra']."</td></tr>";
}
echo "</table>";

echo<<<_END
    <br>
        <form method="post" action="entrada.php">
                <input type="submit" value="volver a jugar">
        </form>
    _END;

?>
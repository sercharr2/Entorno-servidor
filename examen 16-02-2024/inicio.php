<?php

if (isset($_POST["enviar"])) {

    session_start();
    $login = $_SESSION["usuario"];
    $nombre = $_SESSION["nombre"];
    $fecha = date("Y-m-d");
    $hora = date("H:i:s");
    $respuesta = $_POST["solucion"];
    $_SESSION["respuesta"] = $respuesta;
    $error = '';
    $repdiaria = true;

    $conn = new mysqli('localhost:3307', 'jugador', '', 'jeroglifico');
    if ($conn->connect_error)
        die("Fatal Error");

    // Comprobar si el jugador ya ha respondido hoy
    $query3 = "SELECT fecha, login FROM respuestas WHERE fecha = '$fecha' AND login = '$login'";
    $result3 = $conn->query($query3);
    if (!$result3)
        die("Fatal Error");

    if ($result3->num_rows > 0) {
        $repdiaria = false;
    }

    if ($repdiaria) {
        $stmt = $conn->prepare("INSERT INTO respuestas (fecha, login, hora, respuesta) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $fecha, $login, $hora, $respuesta);
        if (!$stmt->execute()) {
            die("Fallo en INSERT");
        }
        $stmt->close();
    } else {
        $error = "<p style='color: red;'>*Hoy $nombre ya introdujo una respuesta</p>";
    }

    $conn->close();

    echo <<<_END
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jeroglífico</title>
    <style>
        img { width: 500px; }
    </style>
</head>
<body>
    <h2>Bienvenido, $nombre</h2>
    <h2>JEROGLÍFICO</h2>

    <img src="./imagen/20240216.jpg" alt="Jeroglífico del día">

    <br>

    <form method="post" action="inicio.php">
        <label>Solución al jeroglífico:</label>
        <input type="text" name="solucion">
        <br>
        <input type="submit" name="enviar" value="Enviar">
    </form>

    $error

    <br>

    <form method="post" action="puntos.php">
        <input type="submit" name="puntos" value="Ver puntos por jugador">
    </form>

    <form method="post" action="resultado.php">
        <input type="submit" name="resultado" value="Resultados del día">
    </form>

</body>
</html>
_END;

} else {

    session_start();
    $nombre = $_SESSION["nombre"];

    echo <<<_END
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jeroglífico</title>
    <style>
        img { width: 500px; }
    </style>
</head>
<body>
    <h2>Bienvenido, $nombre</h2>
    <h2>JEROGLÍFICO</h2>

    <img src="./imagen/20240216.jpg" alt="Jeroglífico del día">

    <br>

    <form method="post" action="inicio.php">
        <label>Solución al jeroglífico:</label>
        <input type="text" name="solucion">
        <br>
        <input type="submit" name="enviar" value="Enviar">
    </form>

    <br>

    <form method="post" action="puntos.php">
        <input type="submit" name="puntos" value="Ver puntos por jugador">
    </form>

    <form method="post" action="resultado.php">
        <input type="submit" name="resultado" value="Resultados del día">
    </form>

</body>
</html>
_END;
}
?>

<?php

if (isset($_POST["usuario"]) && $_POST["contrasenia"]) {

    session_start();
    $_SESSION['usuario'] = $_POST['usuario'];
    $_SESSION['contrasenia'] = $_POST['contrasenia'];
    $nombre;
    $clave;
    $inicioConfirmado = false;

    $conn = new mysqli('localhost', 'root', '', 'bdsimon');
    if ($conn->connect_error)
        die("Fatal Error");


    $query = "SELECT * FROM usuarios";
    $result = $conn->query($query);
    if (!$result)
        die("Fatal Error");

    if ($result->num_rows > 0) {
        // usar while para iterar cada fila y evitar avanzar el puntero varias veces
        while ($row = $result->fetch_assoc()) {

            $nombre = $row['Nombre'];
            $clave = $row['Clave'];

            if ($nombre == $_SESSION['usuario'] && $clave == $_SESSION['contrasenia']) {

                $inicioConfirmado = true;

            }

        }
    }

    if ($inicioConfirmado) {

        $colores = [];
        $circulos = [

            "<div style='width: 100px; height: 100px; background-color: red; border-radius: 50%;'></div>",
            "<div style='width: 100px; height: 100px; background-color: blue; border-radius: 50%;'></div>",
            "<div style='width: 100px; height: 100px; background-color: yellow; border-radius: 50%;'></div>",
            "<div style='width: 100px; height: 100px; background-color: green; border-radius: 50%;'></div>",
            "<div style='width: 100px; height: 100px; background-color: black; border-radius: 50%;'></div>"

        ];

        for ($i = 0; $i < 4; $i++) {

            $colores[$i] = rand(0, 3);

        }

        $_SESSION['color'] = $colores;
        $_SESSION['circulo'] = $circulos;

        echo <<<_END
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Simón</h1>
        <h2> memoriza la combinacion de colores:</h2>
_END;

        echo "<div style='display:flex; gap:10px; align-items:center;'>";

        for ($i = 0; $i < 4; $i++) {

            if ($colores[$i] == 0) {

                echo $circulos[0];

            } else if ($colores[$i] == 1) {

                echo $circulos[1];

            } else if ($colores[$i] == 2) {

                echo $circulos[2];

            } else if ($colores[$i] == 3) {

                echo $circulos[3];

            }
        }

        echo "</div>";

        echo <<<_END
    <br>
    <form method="post" action="simon.final.2.php">

        <input type="submit" value = "jugar">
    </form>

_END;

    } else {

        echo "usuario o contraseña incorrectos";
        echo <<<_END
    <br>
    <form method="get" action="simon.final.php" style="margin-top:16px;">
    <button type="submit">Volver a jugar</button>
    </form>

_END;

    }

} else {

    echo <<<_END
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Simón</h1>
        <h2> Inicio de sesión:</h2>
        <p>llena los campos usuario y contraseña correctas para continuar</p>
    <br>
    <form method="post" action="simon.final.php">

        <lavel>Usuario</lavel>
        <input type="text" name="usuario">
        <br><br>
        
        <lavel>Contraseña</lavel>
        <input type="password" name="contrasenia">
        <br><br>

        <input type="submit" value = "jugar">

    </form>

_END;

}
?>
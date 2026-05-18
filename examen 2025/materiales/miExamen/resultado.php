<?php

session_start();

    $nlevantadas= $_SESSION["nlevantadas"];
   $carta1= $_SESSION["carta1"];
   $carta2= $_SESSION["carta2"];
    $nombre= $_SESSION["nombre"];
    $resultado = $_SESSION["resultado"];
    $login = $_SESSION["login"];

    $respuesta = "";

    $conn = new mysqli('localhost', 'root', '', 'cartas');
        if ($conn->connect_error)
            die("Fatal Error");


    if($resultado){

        $respuesta = "<h2>Acierto posiciones $carta1 y $carta2 después de $nlevantadas intentos</h2> <h3>se le sumara 1 punto asi como $nlevantadas intentos</h3>";

        $query = "UPDATE `jugador` SET `puntos`= puntos + 1,`extra`= extra + $nlevantadas WHERE login like '$login'";
        $result = $conn->query($query);

    }else{

        $respuesta = "<h2>Fallo posiciones $carta1 y $carta2 después de $nlevantadas intentos</h2> <h3>se le restara 1 punto asi como $nlevantadas intentos</h3>";

        $query = "UPDATE `jugador` SET `puntos`= puntos - 1,`extra`= extra - $nlevantadas WHERE login like '$login'";
        $result = $conn->query($query);

    }

    $query2 = "SELECT nombre, puntos, extra FROM jugador";
        $result2 = $conn->query($query2);


echo<<<_END
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>resultado</title>
            </head>
            <body>

                <h1>Bienvenid@, $nombre</h1>
                $respuesta
                <br>
                <h1>Puntos por jugador</h1>
                <br>
                <table>
                    <tr>
                        <th>Nombre</th>
                        <th>Puntos</th>
                        <th>Extra</th>
                    </tr>
            _END;


            if ($result2->num_rows > 0) {
        // usar while para iterar cada fila y evitar avanzar el puntero varias veces
        while ($row = $result2->fetch_assoc()) {

           $nombre =  $row['nombre'];
            $puntos = $row['puntos'];
            $extra = $row['extra'];

            echo<<<_END

                <tr>
                    <th>$nombre</th>
                    <th>$puntos</th>
                    <th>$extra</th>
                </tr>
                
            _END;

        }
    }
            
            echo<<<_END
            </table>
            </body>
            </html>
        _END;

?>
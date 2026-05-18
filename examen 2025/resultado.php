<?php

session_start();

    $levantadas= $_SESSION["levantadas"];
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

        $respuesta = "<h2>Acierto posiciones $carta1 y $carta2 después de $levantadas intentos</h2> <h3>se le sumara 1 punto asi como $levantadas intentos</h3>";

        $query = "UPDATE `jugador` SET `puntos`= puntos + 1,`extra`= extra + ? WHERE login like ?";
        $result = $conn->prepare($query);

        $result -> bind_param("is",$levantadas,$login);
        $result -> execute();

    }else{

        $respuesta = "<h2>Fallo posiciones $carta1 y $carta2 después de $levantadas intentos</h2> <h3>se le restara 1 punto asi como $levantadas intentos</h3>";

        $query = "UPDATE `jugador` SET `puntos`= puntos - 1,`extra`= extra - ? WHERE login like ?";
        $result = $conn->prepare($query);

        $result -> bind_param("is",$levantadas,$login);
        $result -> execute();

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
                <style>
                
                    body { font-family: Arial, sans-serif; padding:20px; }
                    table { border-collapse: collapse; width: 720px; max-width:100%; }
                    th, td { border: 1px solid #bbb; padding: 6px 8px; text-align: left; vertical-align: middle; }
                    th { background:#f3f3f3; }

                </style>
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
                    </tr >
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
<?php

if (isset($_POST["boton1"]) || isset($_POST["boton2"]) || isset($_POST["boton3"]) || isset($_POST["boton4"])|| isset($_POST["boton5"])|| isset($_POST["boton6"])) {

    session_start();
        $nlevantadas=$_SESSION["nlevantadas"];
        $nombre=$_SESSION["nombre"];
        $cartas=$_SESSION["cartas"] ;
        $cartasSolucion=$_SESSION["cartasSolucion"];
        $cartasmostrar=$_SESSION["cartasmostrar"];

        $nlevantadas++;

        if (isset($_POST["boton1"])) {

            $respuesta[1] = $cartasmostrar[1];

        } else if (isset($_POST["boton2"])) {

            $respuesta[2] = $cartasmostrar[2];

        } else if (isset($_POST["boton3"])) {

            $respuesta[3] = $cartasmostrar[3];

        } else if (isset($_POST["boton4"])) {

            $respuesta[4] = $cartasmostrar[4];

        }else if (isset($_POST["boton5"])) {

            $respuesta[5] = $cartasmostrar[5];

        }else if (isset($_POST["boton6"])) {

            $respuesta[6] = $cartasmostrar[6];

        }

        $_SESSION['respuesta'] = $respuesta;

        echo<<<_END
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>mostrarcatas</title>
            </head>
            <body>
                <h1>bienvenid@, $nombre</h1>
                <h2>Cartas levantadas: $nlevantadas</h2>

                <form method = "post" action="mostrarcartas.php">
        _END;

                for($i=1; $i<=6; $i++){

                    echo<<<_END
                    
                         <input type="button" name="boton$i" value="Levantar carta $i">

                    _END;

                }        

        echo<<<_END
                </form> 
                <br>
                <form method = "post" action="resultado.php">
                    <lavel>Pareja<lavel>
                        <input type="number" name="carta1" min = "1" max = "6">
                        <input type="number" name="carta2" min = "1" max = "6">

                    <input type="submit" name="inicio" value = "comprobar">
                </form>

                
                <br>
            _END;    
                
            for ($i = 0; $i < 6; $i++){

                if($cartasmostrar[$i]== 0){

                    echo $cartas[0];

                }else if($cartasmostrar[$i]== 1){

                    echo $cartas[1];

                }else if($cartasmostrar[$i]== 2){

                    echo $cartas[2];

                }
                else if($cartasmostrar[$i]== 3){

                    echo $cartas[3];

                }
            }

            echo<<<_END
            </body>
            </html>
        _END;

    }
 else {
    session_start();

    $login = $_SESSION["login"];
    $nlevantadas = 0;
    $cartasmostrar = [0,0,0,0,0,0];
    $cartas = [

        "<img src='materiales/boca_abajo.jpg' width='150' height='200'>",
        "<img src='materiales/copas_02.jpg' width='150' height='200'>",
        "<img src='materiales/copas_03.jpg' width='150' height='200'>",
        "<img src='materiales/copas_05.jpg' width='150' height='200'>"

    ];

    $cartasSolucion=[0,0,0,0,0,0];
    
    
    for ($i = 0; $i <= 6; $i++){
        
        $nr = rand(1,3);

            $cartasSolucion[$i] = $nr;

        echo $cartasSolucion[$i];
    }

    $conn = new mysqli('localhost', 'root', '', 'cartas');
        if ($conn->connect_error)
            die("Fatal Error");


        $query = "SELECT nombre FROM jugador WHERE login like '$login'";
        $result = $conn->query($query);

        if ($result->num_rows == 1){

            $row = $result->fetch_assoc();
            $nombre = $row["nombre"];

        }
        $_SESSION["nlevantadas"] = $nlevantadas;
        $_SESSION["carta1"] = $_POST["carta1"];
        $_SESSION["carta2"] = $_POST["carta2"];
        $_SESSION["nombre"] = $nombre;
        $_SESSION["cartas"] = $cartas;
        $_SESSION["cartasSolucion"] = $cartasSolucion;
        $_SESSION["cartasmostrar"] = $cartasmostrar;


     echo<<<_END
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>mostrarcatas</title>
            </head>
            <body>
                <h1>bienvenid@, $nombre</h1>
                <h2>Cartas levantadas: $nlevantadas</h2>

                <form method = "post" action="mostrarcartas.php">
        _END;

                for($i=1; $i<=6; $i++){

                    echo<<<_END
                    
                         <input type="button" name="boton$i" value="Levantar carta $i">

                    _END;

                }        

        echo<<<_END
                /form> 
                <br>
                <form method = "post" action="resultado.php">
                    <lavel>Pareja<lavel>
                        <input type="number" name="carta1" min = "1" max = "6">
                        <input type="number" name="carta2" min = "1" max = "6">

                    <input type="submit" name="inicio" value = "comprobar">
                </form>

                
                <br>
            _END;    
                
            for ($i = 0; $i < 6; $i++){

                if($cartasmostrar[$i]== 0){

                    echo $cartas[0];

                }else if($cartasmostrar[$i]== 1){

                    echo $cartas[1];

                }else if($cartasmostrar[$i]== 2){

                    echo $cartas[2];

                }
                else if($cartasmostrar[$i]== 3){

                    echo $cartas[3];

                }
            }

            echo<<<_END
            </body>
            </html>
        _END;
    }

?>
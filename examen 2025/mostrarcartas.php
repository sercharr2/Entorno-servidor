<?php
    if(isset($_POST["boton"])){

        session_start();

        $_SESSION["levantadas"]++;
        $login = $_SESSION["login"];  
        $boton = $_POST["boton"];
        $mostrarcartas = $_SESSION["mostrarcartas"];
        $solucion = $_SESSION["solucion"];
        $cartas = $_SESSION["cartas"];
        $nombre = $_SESSION["nombre"];
        $levantadas = $_SESSION["levantadas"];

        echo<<<_END
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>mostrarcartas</title>
        </head>
        <body>

            <h1>bienvenid@,$nombre</h1>
            <br>
            <h2>Cartas levantadas : <span style='border: 1px solid #000000ff; margin: 10px; padding-left:25px; padding-right:25px;'>$levantadas</span><h2>
            <br>
            <form method = "post" action="mostrarcartas.php">
        _END;

        for($i=1; $i<=6; $i++){

            echo "<input type='submit' value='boton $i' name='boton' style = 'margin: 10px; padding-left:25px; padding-right:25px;'>";

        }


        echo<<<_END
                </form>
                
                <form method = "post" action="mostrarcartas.php">

                    <lavel>Pareja</lavel>
                    <input type="number" name="carta1" min="1" max="6">
                    <input type="number" name="carta2" min="1" max="6">
                    <input type="submit" name="comprobar" value = "comprobar">

                </form>
                
            </body>
            </html>
        _END;

        if($boton == "boton 1"){

            $mostrarcartas[0] = $solucion[0];
            
            for($i=0; $i<=5; $i++){

                if($i!= 0){

                    $mostrarcartas[$i] = 0;

                }

            }
        }elseif($boton == "boton 2"){

                $mostrarcartas[1] = $solucion[1];
                
                for($i=0; $i<=5; $i++){

                    if($i!= 1){

                        $mostrarcartas[$i] = 0;

                    }
                }

            }elseif($boton == "boton 3"){

                $mostrarcartas[2] = $solucion[2];
                
                for($i=0; $i<=5; $i++){

                    if($i!= 2){

                        $mostrarcartas[$i] = 0;

                    }
                }

            }elseif($boton == "boton 4"){

                $mostrarcartas[3] = $solucion[3];
                
                for($i=0; $i<=5; $i++){

                    if($i!= 3){

                        $mostrarcartas[$i] = 0;

                    }
                }

            }elseif($boton == "boton 5"){

                $mostrarcartas[4] = $solucion[4];
                
                for($i=0; $i<=5; $i++){

                    if($i!= 4){

                        $mostrarcartas[$i] = 0;

                    }
                }

            }elseif($boton == "boton 6"){

                $mostrarcartas[5] = $solucion[5];
                
                for($i=0; $i<=5; $i++){

                    if($i!= 5){

                        $mostrarcartas[$i] = 0;

                    }
                }

            }

            for($i=0; $i<=5; $i++){

            if($mostrarcartas[$i] == 0){

                echo $cartas[0];

            }
            if( $mostrarcartas[$i] == 1){

                echo $cartas[1];

            }
            if( $mostrarcartas[$i] == 2){

                echo $cartas[2];

            }if( $mostrarcartas[$i] == 3){

                echo $cartas[3];

            }

        }

    }elseif(isset($_POST["comprobar"])){

        session_start();

        $carta1 = $_POST["carta1"] - 1;
        $carta2 = $_POST["carta2"] - 1;
        $resultado;
  
        $solucion = $_SESSION["solucion"];

        if($solucion[$carta1] == $solucion[$carta2]){

            $resultado = true;

        }else{

            $resultado = false;

        }

        $_SESSION["resultado"] = $resultado;
        $_SESSION["carta1"] = $carta1;
        $_SESSION["carta2"] = $carta2;

        header("Location: resultado.php");
        exit();

    }else{

    $levantadas = 0;
        
    session_start();
    
    $_SESSION["levantadas"] = $levantadas;
    $login = $_SESSION["login"];

    
    $conn = new mysqli('localhost', 'root', '', 'cartas');
    if ($conn->connect_error)
        die("Fatal Error");

    $query = "SELECT nombre FROM jugador WHERE login LIKE ?";
    $result = $conn->prepare($query);

    $result -> bind_param("s",$login);
    $result -> execute();

    $result -> bind_result($nombre);

    if(!$result -> fetch()){

        echo "<p style='color:red;'>*error al obtener nombre</p>";

    }

    $_SESSION["nombre"] = $nombre;

    echo<<<_END
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>mostrarcartas</title>
        </head>
        <body>

            <h1>bienvenid@,$nombre</h1>
            <br>
            <h2>Cartas levantadas : <span style='border: 1px solid #000000ff; margin: 10px; padding-left:25px; padding-right:25px;'>$levantadas</span><h2>
            <br>
            <form method = "post" action="mostrarcartas.php">
    _END;

    for($i=1; $i<=6; $i++){

        echo "<input type='submit' value='boton $i' name='boton' style = 'margin: 10px; padding-left:25px; padding-right:25px;'>";

    }


    echo<<<_END
            </form>
            
            <form method = "post" action="mostrarcartas.php">

                <lavel>Pareja</lavel>
                <input type="number" name="carta1" min="1" max="6">
                <input type="number" name="carta2" min="1" max="6">
                <input type="submit" name="comprobar" value = "comprobar">

            </form>
            
        </body>
        </html>
    _END;

    $cartas = [

        '<img src="materiales/boca_abajo.jpg" style = "margin: 10px; padding-left:5px; padding-right:5px;" width="275px" height= "400px">',
        '<img src="materiales/copas_02.jpg" style = "margin: 10px; padding-left:5px; padding-right:5px;" width="275px" height= "400px">',
        '<img src="materiales/copas_03.jpg" style = "margin: 10px; padding-left:5px; padding-right:5px;" width="275px" height= "400px">',
        '<img src="materiales/copas_05.jpg" style = "margin: 10px; padding-left:5px; padding-right:5px;" width="275px" height= "400px">'

    ];

    $solucion = [1,1,2,2,3,3];
    shuffle($solucion);

    $mostrarcartas = [0,0,0,0,0,0];

    $_SESSION["mostrarcartas"] = $mostrarcartas;
    $_SESSION["solucion"] = $solucion;
    $_SESSION["cartas"] = $cartas;

    for($i=0; $i<=5; $i++){

            if($mostrarcartas[$i] == 0){

                echo $cartas[0];

            }
            if( $mostrarcartas[$i] == 1){

                echo $cartas[1];

            }
            if( $mostrarcartas[$i] == 2){

                echo $cartas[2];

            }if( $mostrarcartas[$i] == 3){

                echo $cartas[3];

            }

        }
    }


?>
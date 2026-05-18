<?php

    if(isset($_POST["mandar_letra"])){

        session_start();

        $nletras = $_SESSION["nletras"];
        $palabra_secreta = $_SESSION["palabra_secreta"];

        $barras = $_SESSION["barras"] ;
        $letrasFalladas = $_SESSION["letrasFalladas"];
        $intentos = $_SESSION["intentos"];
        $acierto = false;

        $palabra_completa = false;

        for ($i=0; $i < count($palabra_secreta); $i++) {

            if($palabra_secreta[$i]==$_POST["letra"]){

                $acierto = true;

                $barras[$i] = $_POST["letra"];

            }

        }

        if(!$acierto){

            $intentos--;
            $letrasFalladas++;

        }

        $_SESSION["barras"] = $barras;
        $_SESSION["intentos"] = $intentos;
        $_SESSION["letrasFalladas"] = $letrasFalladas;

        for ($i=0; $i < count($palabra_secreta); $i++) {

            if(implode($barras)==implode($palabra_secreta)){

                $palabra_completa = true;

            }

        }

        if($palabra_completa){

            echo<<<_END

                <!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Document</title>
                </head>
                <body>
                    <h1>Ahorcado</h1>
                    <h2>letras falladas:$letrasFalladas</h2>
                    <h2>Intentos:$intentos</h2>
            _END;

            for ($i=0; $i < count($palabra_secreta); $i++) {

                echo($barras[$i]);

            }
            echo("<br><br>");

            echo<<<_END

                <h1>Acertaste!!!<h1>

            </body>
            </html>
            _END;

        }else if($intentos == 0){

            echo<<<_END

                <!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Document</title>
                </head>
                <body>
                    <h1>Ahorcado</h1>
                    <h2>letras falladas:$letrasFalladas</h2>
                    <h2>Intentos:$intentos</h2>
            _END;

            for ($i=0; $i < count($palabra_secreta); $i++) {

                echo($barras[$i]);

            }
            echo("<br><br>");

            echo<<<_END

                <h1>Perdiste!!!<h1>

            </body>
            </html>
            _END;

        }else{
            echo<<<_END

                <!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Document</title>
                </head>
                <body>
                    <h1>Ahorcado</h1>
                    <h2>letras falladas:$letrasFalladas</h2>
                    <h2>Intentos:$intentos</h2>
            _END;

            for ($i=0; $i < count($palabra_secreta); $i++) {

                echo($barras[$i]);

            }
            echo("<br><br>");

            echo<<<_END

                <form method="post" action="jugar.php">

                    <input type="text" name="letra" maxlength="1">
                    <input type="submit" name="mandar_letra" value="letra">

                </form>    
            </body>
            </html>
            _END;
    
        }

    }else{

        session_start();

        $nletras = $_SESSION["nletras"];
        $palabra_secreta = $_SESSION["palabra_secreta"];

        $barras=[];
        $letrasFalladas = 0;
        $intentos = 6;
        $acierto = true;

        echo<<<_END

            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Document</title>
            </head>
            <body>
                <h1>Ahorcado</h1>
                <h2>letras falladas:$letrasFalladas</h2>
                <h2>Intentos:$intentos</h2>
        _END;

        for ($i=0; $i < count($palabra_secreta); $i++) {

            $barras[$i] = "-";

            echo($barras[$i]);

        }
        echo("<br><br>");
        for ($i=0; $i < count($palabra_secreta); $i++) {

            $barras[$i] = "-";

            echo($palabra_secreta[$i]);

        }

        echo<<<_END

            <form method="post" action="jugar.php">

                <input type="text" name="letra" maxlength="1">
                <input type="submit" name="mandar_letra" value="letra">

            </form>    
        </body>
        </html>
        _END;

        $_SESSION["barras"] = $barras;
        $_SESSION["letrasFalladas"]=$letrasFalladas;
        $_SESSION["intentos"]=$intentos;

    }

?>



    

<?php

    session_start();

    $palabras = ["manzana","pera","limon","fresa","rabano"];

    $numa = rand(0,4);

    $palabra_secreta= str_split($palabras[$numa]);

    $nletras = count($palabra_secreta);

    $_SESSION["nletras"] = $nletras;
    $_SESSION["palabra_secreta"] = $palabra_secreta;

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
            <h2>Se a seleccionado una palabra secreta</h2>
            <h2>dispones de 6 intentos para aberriguar la palabra </h2>

            <form method="post" action="jugar.php">
                <input type="submit" value="jugar">
            </form>
        </body>
        </html>
    _END;

?>
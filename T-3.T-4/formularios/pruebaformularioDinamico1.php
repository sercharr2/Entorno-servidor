<?php
// Tercera versión del formulario de suma


    if (isset($_POST["mostrar"])){

        for ($i = 0; $i < 10; $i++){

            echo ("<br>El numero $i es: ". $_POST["n$i"]."<br>");

        }

    }else{

        echo <<<END
            <html>
             <head>
                <title>Form Test</title>
             </head>
             <body>
             <form method="post" action="pruebaformularioDinamico1.php">
        END;


        for ($i = 0; $i < 10; $i++) {

            echo <<<END

                <label>Número $i:</label>
                <input type="number" name="n$i" required>
                <br><br>

            END;

        }

        echo <<<END

                 <input type="submit" value="Mostrar" name ="mostrar">
                </form>
            </body>
         </html>
        END;

    }


?>

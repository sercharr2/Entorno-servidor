<?php

if (isset($_POST["mostrar"])){

        session_start();

        for ($i = 0; $i < $_SESSION['numero']; $i++){

            echo ("<br>El numero $i es: ". $_POST["n$i"]."<br>");

        }

    }else{

        echo <<<END
            <html>
             <head>
                <title>Form Test</title>
             </head>
             <body>
             <form method="post" action="pruebaformularioDinamico1.2.php">
        END;

        session_start();
        $_SESSION['numero'] = $_POST['numC'];

        for ($i = 0; $i < $_POST['numC']; $i++) {

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
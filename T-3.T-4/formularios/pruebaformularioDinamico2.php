<?php
// Tercera versión del formulario de suma
    if(isset($_POST["numC"])) {

        

    }else{


         echo <<<END
            <html>
             <head>
                <title>Form Test</title>
             </head>
             <body>
             <form method="post" action="pruebaformularioDinamico1.2.php"

                <label>Número:</label>
                <input type="number" name="numC" required>
                <br><br>

                 <input type="submit" value="Mostrar" name ="mostrar1">
                </form>
            </body>
         </html>
        END;


    }

?>

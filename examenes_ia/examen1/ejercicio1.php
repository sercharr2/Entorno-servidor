<?php
if(isset($_POST["calcular"])){

    $numValidos = true;

 for($i=0;$i<=2;$i++){

        for($j=0;$j<=2;$j++){

            if(!(is_int(intval($_POST["caja$i$j"])) && $_POST["caja$i$j"]>10 && $_POST["caja$i$j"]<50)){

                $numValidos = false;

            } 
        }
    }

            if($numValidos){

                for($i=0;$i<=2;$i++){

                    for($j=0;$j<=2;$j++){

                        $num = $_POST["caja$i$j"];
                        $numhex = dechex($num);

                        echo("$num == $numhex <br><br>");

                    }
                }

            }else{

                 echo <<<_END

                    <!DOCTYPE html>
                    <html lang="en">
                    <head>
                        <meta charset="UTF-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <title>Document</title>
                    </head>
                    <body>
                        <h1>Algun numero de los introducidos no es valido</h1>

                        <form method="post" action="ejercicio1.php">
                _END;

                for($i=0;$i<=2;$i++){

                    for($j=0;$j<=2;$j++){

                        echo("<input type='text' name='caja$i$j'>");

                    }
                    echo("<br><br>");
                }

                echo <<<_END
                        <input type='submit' name='calcular' value='calcular'> 

                        </form>
                        
                    </body>
                    </html>
                _END;

            }

      

}else{

    echo <<<_END

        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Document</title>
        </head>
        <body>

            <form method="post" action="ejercicio1.php">
    _END;

    for($i=0;$i<=2;$i++){

        for($j=0;$j<=2;$j++){

            echo("<input type='text' name='caja$i$j'>");

        }
        echo("<br><br>");
    }

    echo <<<_END
               <input type='submit' name='calcular' value='calcular'> 

            </form>
            
        </body>
        </html>
    _END;

}
?>



            
        
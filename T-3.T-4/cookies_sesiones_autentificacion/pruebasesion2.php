<?php

if (isset($_POST['n'])) {
        session_start();

        $numD = intval($_SESSION['numD']);
        $n = intval($_POST['n']);

    if($n == $numD){
        echo'<h1>Acertaste</h1>';
    }else{
        echo '<h1>Fallaste</h1>';
    }

    echo '<form method="get" action="pruebasesion2.php" style="margin-top:16px;">';
    echo '<button type="submit">Volver a jugar</button>';
    echo '</form>';

} else{

       $numB =[];
    $imagenes=[

        "<img src='/img/8diamantes.png' width='150' height='200' backgroundcolor= 'black'>",
        "<img src='/img/4diamantes.png' width='150' height='200' backgroundcolor= 'black'>",
        "<img src='/img/2diamantes.jpg' width='150' height='200' backgroundcolor= 'black'>",
        "<img src='/img/1diamantes.jpg' width='150' height='200' backgroundcolor= 'black'>"

    ];

    for ($i = 0; $i < 4; $i++){

        $numB[$i] = rand(0,1);

    }

    $num = 0;

    for ($i = 0; $i < count($numB); $i++){

        if($numB[$i] == 0){

        }else{

            if(4-$i==1){

                $num += pow(2,0);

            }else if(4-$i==2){

                $num += pow(2,1);

            }else if(4-$i==3){

                $num += pow(2,2);

            }else if(4-$i==4){

                $num += pow(2,3);

            }

        }

    }

    echo $num."<br>";

    session_start();
        $_SESSION['numD'] = $num;

    echo <<<_END
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Adivina el numero en decimal por el numero de las cartas</h1>
        <h2> El numero binario es: 
_END;

for ($i = 0; $i < 4; $i++){

        echo $numB[$i];
    }
echo "</h2>";

for ($i = 0; $i < 4; $i++){

        if($numB[$i]==1){

            echo $imagenes[$i];

        }
    }

echo <<<_END
    
    <form method="post" action="pruebasesion2.php">
        <label>Número en decimal:</label>
            <input type="number" name="n" required>
        <input type="submit" value = "jugar">
    </form>

_END;

}



?>


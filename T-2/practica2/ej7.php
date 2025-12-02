<?php

$matriz = [];
$maxFila = [];
$promedioFila = [];


for($i = 0; $i<=2; $i++){

    for($j = 0; $j<=3;$j++){

        $matriz[$i][$j] = rand(0,100);

    }

}

$max=0;
$promedio = 0;

for($i = 0; $i<=2; $i++){

    for($j = 0; $j<=3;$j++){

        echo($matriz[$i][$j]."|");

        $promedio += $matriz[$i][$j];

        if($matriz[$i][$j] >= $max){

            $max = $matriz[$i][$j];

        }

    }

    array_push($maxFila, $max);
    $max = 0;

    array_push($promedioFila, ($promedio/4));
    $promedio = 0;

    echo("<br>");
}

echo("<br>");
echo("<br>");

for($i = 0; $i<= 2; $i++){

    echo($maxFila[$i]."|");

}

echo("<br>");
echo("<br>");

for($i = 0; $i<= 2; $i++){

    echo($promedioFila[$i]."|");

}


?>
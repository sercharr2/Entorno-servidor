<?php

$matrizC4 = [];


for($i = 0; $i<=3; $i++){

    for($j = 0; $j<=4;$j++){

        $matrizC4[$i][$j] = rand(0,100);

    }

}

$max=0;
$x;
$y;

for($i = 0; $i<=3; $i++){

    for($j = 0; $j<=3;$j++){

        echo($matrizC4[$i][$j]."|");

        if($matrizC4[$i][$j] >= $max){

            $max = $matrizC4[$i][$j];
            $x = $i;
            $y = $j;

        }

    }
    echo("<br>");
}
echo("<br>el numero mayor es : $max <br> x: $x <br> y: $y");

?>
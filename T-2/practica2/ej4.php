<?php

$matrizC4 = [];
$Dprincipal= [];
$Dsecunadaria = [];

for($i = 1; $i<=4; $i++){

    for($j = 1; $j<=4;$j++){

        $matrizC4[$i][$j] = rand(0,100);

        if($i == $j){

            array_push($Dprincipal, $matrizC4[$i][$j]);

        }
        if($i + $j == 6 - 1){

            array_push($Dsecunadaria, $matrizC4[$i][$j]);

        }

    }

}

foreach ($matrizC4 as $f => $c) {
    foreach ($c as $c => $num) {
        echo "$num | ";
    }
    echo"<br>";
}

echo"<br>";
echo"<br>";


echo "Diagonal principal: " . implode(" ", $Dprincipal) . "<br>";
echo "Diagonal secundaria: " . implode(" ", $Dsecunadaria) . "<br>";

?>
<?php

$matrizC4 = [];


for($i = 0; $i<=2; $i++){

    for($j = 0; $j<=4;$j++){

        $matrizC4[$i][$j] = rand(0,100);

    }

}

foreach ($matrizC4 as $f => $c) {
    foreach ($c as $c => $num) {
        echo "$num | ";
    }
    echo"<br>";
}


echo"<br>por filas: <br>";


foreach ($matrizC4 as $f => $c) {
    foreach ($c as $c => $num) {
        echo "$num | ";
    }
}


echo"<br>por columna: <br>";

for($i = 0; $i<=4; $i++){

    for($j = 0; $j<=2;$j++){

        echo($matrizC4[$j][$i]."|");

    }

}


?>
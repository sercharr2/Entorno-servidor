<?php

$num = 323.122345;

echo round($num,0,PHP_ROUND_HALF_UP);
echo "\n    |  ";
echo round($num,3,PHP_ROUND_HALF_DOWN);
echo "\n   |   ";
echo round($num,-1,PHP_ROUND_HALF_EVEN);

?>
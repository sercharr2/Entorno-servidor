<?php

function pintar_circulos($colores) {
    echo "<div style='display:flex; gap:10px; margin:20px;'>";
    foreach ($colores as $color) {
        echo "<div style='width:100px; height:100px; border-radius:50%; background-color:$color; border:2px solid #000;'></div>";
    }
    echo "</div>";
}

?>
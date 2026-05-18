<?php
// pintar-circulos.php
function pintar_circulos($col1, $col2, $col3, $col4) {
    $cols = [$col1, $col2, $col3, $col4];
    echo '<div style="display:flex; gap:16px; justify-content:center; align-items:center; margin:20px 0;">';
    foreach ($cols as $c) {
        echo '<div title="'.htmlspecialchars($c).'" style="
            width:60px;height:60px;border-radius:50%;
            background:'.$c.'; border:3px solid #222;"></div>';
    }
    echo '</div>';
}

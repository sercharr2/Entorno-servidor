<?php
/*
    Ejercicio 15:
    Crear array de nombres y mostrar cantidad y lista <ul>.
*/

$nombres = array("Pedro", "Ismael", "Sonia", "Clara", "Susana", "Alfonso", "Teresa");

// Cantidad de elementos
echo "El array contiene " . count($nombres) . " elementos.<br><br>";

// Lista HTML
echo "<ul>";
foreach ($nombres as $nombre) {
    echo "<li>$nombre</li>";
}
echo "</ul>";
?>

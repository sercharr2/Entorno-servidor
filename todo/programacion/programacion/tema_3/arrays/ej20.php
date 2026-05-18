<?php
/*
    Ejercicio 20:
    Crear un array asociativo y mostrarlo en una tabla.
    Luego eliminar el estadio asociado al Real Madrid
    y volver a mostrar los valores en una lista numerada.
*/

// Array asociativo de equipos y estadios
$estadios = array(
    "Real Madrid" => "Santiago Bernabéu",
    "Barcelona" => "Camp Nou",
    "Atlético de Madrid" => "Metropolitano",
    "Sevilla" => "Ramón Sánchez-Pizjuán"
);

// Mostrar la tabla original
echo "<h3>Tabla original de equipos y estadios</h3>";
echo "<table border='1' cellpadding='5'>";
echo "<tr><th>Equipo</th><th>Estadio</th></tr>";

foreach ($estadios as $equipo => $estadio) {
    echo "<tr><td>$equipo</td><td>$estadio</td></tr>";
}

echo "</table><br>";


// ✔ Eliminar estadio del Real Madrid
unset($estadios["Real Madrid"]);


// Mostrar nuevamente en lista numerada
echo "<h3>Lista después de eliminar el estadio del Real Madrid</h3>";
echo "<ol>";

foreach ($estadios as $equipo => $estadio) {
    echo "<li>$equipo → $estadio</li>";
}

echo "</ol>";
?>

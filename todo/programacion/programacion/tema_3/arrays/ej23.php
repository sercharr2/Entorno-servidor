<?php
/*
    Ejercicio 23:
    Crear un array multidimensional para 2 familias:
    Los Simpson y Los Griffin.
*/

$familias = array(
    "Los Simpson" => array(
        "Padre" => "Homer",
        "Madre" => "Marge",
        "Hijos" => array("Bart", "Lisa", "Maggie")
    ),
    "Los Griffin" => array(
        "Padre" => "Peter",
        "Madre" => "Lois",
        "Hijos" => array("Meg", "Chris", "Stewie")
    )
);

// Mostrar valores en una lista
echo "<ul>";

foreach ($familias as $nombreFamilia => $miembros) {
    echo "<li><b>$nombreFamilia:</b><ul>";
    echo "<li>Padre: " . $miembros["Padre"] . "</li>";
    echo "<li>Madre: " . $miembros["Madre"] . "</li>";

    echo "<li>Hijos:<ul>";
    foreach ($miembros["Hijos"] as $hijo) {
        echo "<li>$hijo</li>";
    }
    echo "</ul></li>";

    echo "</ul></li>";
}

echo "</ul>";
?>

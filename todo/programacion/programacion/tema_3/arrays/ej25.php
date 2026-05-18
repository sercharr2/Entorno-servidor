<?php
/*
    Ejercicio 25:
    Crear un array multidimensional para guardar amigos clasificados por ciudades.
    Mostrar en cada ciudad qué amigos tiene.
*/

$amigos = array(

    "Madrid" => array(
        array(
            "nombre" => "Pedro",
            "edad" => 32,
            "telefono" => "91-999.99.99"
        )
    ),

    "Barcelona" => array(
        array(
            "nombre" => "Susana",
            "edad" => 34,
            "telefono" => "93-000.00.00"
        )
    ),

    "Toledo" => array(
        array(
            "nombre" => "Sonia",
            "edad" => 42,
            "telefono" => "925-09.09.09"
        )
    )
);

// Mostrar los valores
echo "<h2>Listado de amigos por ciudad:</h2>";

foreach ($amigos as $ciudad => $listaAmigos) {
    echo "<h3>$ciudad:</h3>";
    echo "<ul>";

    foreach ($listaAmigos as $datos) {
        echo "<li>";
        echo "Nombre: {$datos['nombre']}, ";
        echo "Edad: {$datos['edad']}, ";
        echo "Teléfono: {$datos['telefono']}";
        echo "</li>";
    }

    echo "</ul>";
}
?>

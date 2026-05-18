<?php
/*
    Ejercicio 16:
    Crear dos arrays con índices alfanuméricos, unirlos y mostrarlos en tabla.
*/

$lenguajes_cliente = array(
    "JS"  => "JavaScript",
    "HTML" => "HTML",
    "CSS" => "CSS"
);

$lenguajes_servidor = array(
    "PHP" => "PHP",
    "PY"  => "Python",
    "RB"  => "Ruby"
);

// Unirlos en uno solo
$lenguajes = array_merge($lenguajes_cliente, $lenguajes_servidor);

// Mostrar en una tabla
echo "<table border='1' cellpadding='5'>";
echo "<tr><th>Índice</th><th>Lenguaje</th></tr>";

foreach ($lenguajes as $indice => $valor) {
    echo "<tr><td>$indice</td><td>$valor</td></tr>";
}

echo "</table>";
?>

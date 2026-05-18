<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Si el formulario fue enviado, mostramos los resultados
    $nombre = htmlspecialchars($_POST['nombre'] ?? '', ENT_QUOTES, 'UTF-8');
    $apellido = htmlspecialchars($_POST['apellido'] ?? '', ENT_QUOTES, 'UTF-8');
    $edad = htmlspecialchars($_POST['edad'] ?? '', ENT_QUOTES, 'UTF-8');
    $profesion = htmlspecialchars($_POST['Profesion'] ?? '', ENT_QUOTES, 'UTF-8');
    $genero = htmlspecialchars($_POST['genero'] ?? '', ENT_QUOTES, 'UTF-8');

    echo "<h2>Datos ingresados:</h2>";
    echo "Nombre: $nombre<br>";
    echo "Apellido: $apellido<br>";
    echo "Edad: $edad<br>";
    echo "Profesión: $profesion<br>";
    echo "Género: $genero<br>";

} else {
    // Si no se ha enviado, mostramos el formulario
    echo <<<_END
<html>
<head>
    <title>Formulario de Datos Personales</title>
</head>
<body>
    <h2>Introduce tus datos personales</h2>
    <form method="post" action="">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required><br><br>

        <label for="apellido">Apellido:</label>
        <input type="text" id="apellido" name="apellido" required><br><br>

        <label for="edad">Edad:</label>
        <input type="number" id="edad" name="edad" min="0" required><br><br>

         <label for="Profesion">Profesión:</label>
         <select name="Profesion" id="Profesion">
           <option value="Profesor">Profesor</option>
           <option value="Policia">Policía</option>
           <option value="Carnicero">Carnicero</option>
           <option value="Limpiador">Limpiador</option>
         </select> <br><br>
         <label for="genero">Género:</label> 
            <input type="radio" id="h" name="genero" value="Hombre" required>
            Hombre
            <input type="radio" id="m" name="genero" value="Mujer" required>
            Mujer <br><br>
        
        
        <input type="submit" value="Enviar"> 
    </form>
</body>
</html>
_END;
}
?>

<?php

if (isset($_POST['nombre']) && isset($_POST['apellidos']) && isset($_POST['edad'])&& isset($_POST['profesion']) && isset($_POST['sexo'])&& (isset($_POST['google'])||isset($_POST['safari'])||isset($_POST['firefox']))) {

//if($_SERVER["REQUEST_METHOD"]=="POST"){    

    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellidos'];
    $edad = $_POST['edad'];
    $profesion = $_POST['profesion'];
    $sexo = $_POST['sexo'];

    echo <<<END
            <html>
             <head>
                <title>Form Test</title>
             </head>
             <body>

                <h1> respuestas </h1>

                <p>Nombre: $nombre</p>
                <p>Apellidos: $apellido</p>
                <p>Edad: $edad</p>
                <p>Profesion: $profesion</p>
                <p>sexo: $sexo</p>
                <p>Navegadores: </p>
                <ul>
         END;    
         
            if(isset($_POST['google'])){

                echo("<li>google</li>");

            }if(isset($_POST['safari'])){

                echo("<li>safari</li>");

            }if(isset($_POST['firefox'])){

                echo("<li>firefox</li>");

            }
                
                 
            <<<END

            </ul>
             </body>
             </html>

            END;
            
       

}else{

    
echo <<<END
<html>
<head>
    <title>Form Test</title>
</head>
<body>
    <form method="post" action="pruebaformulario6.php">
        <p>Llena el formulario para emviarlo</p>
        <br><br>

        <label>Nombre:</label>
        <input type="text" name="nombre" required>
        <br><br>

        <label>Apellidos:</label>
        <input type="text" name="apellidos" required>
        <br><br>

        <label>Edad:</label>
        <input type="number" name="edad" required max ='120'>
        <br><br>

        <label for="profesion">Profesion:</label>
        <select id="profesion" name="profesion" required>
            <option value="arquero">arquero</option>
            <option value="bombero">bombero</option>
            <option value="carpintero">carpintero</option>
            <option value="desempleado">desempleado</option>
        </select>
        <br><br>

        <label>Sexo:</label>
        <input type="radio" id="m" name="sexo" value="Masculino">
            <label for="m">Masculino</label>
        <input type="radio" id="f" name="sexo" value="Femenino">
            <label for="f">Femenino</label>
        <input type="radio" id="h" name="sexo" value="Helicoptero apache">
            <label for="h">Helicoptero apache</label>
        <br><br>


        <label>Navegador:</label>
        <input type="checkbox" id="google" name="google" value="google">
            <label for="google"> google</label>
        <input type="checkbox" id="safari" name="safari" value="safari">
            <label for="safari"> safari</label>
        <input type="checkbox" id="firefox" name="firefox" value="firefox">
            <label for="firefox"> firefox</label>
        <br><br>


        <input type="submit" value="enviar">
    </form>
</body>
</html>
END;

}
?>

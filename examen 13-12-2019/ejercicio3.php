<?php

    if(isset($_POST["inicio"])){

        $usuario = $_POST["usuario"];
        $contrasenia = $_POST["contrasenia"];

        $conn = new mysqli('localhost', 'root', '', 'usuarios');
        if ($conn->connect_error)
            die("Fatal Error");

        $query = "SELECT rol FROM usuarios WHERE usuario like '$usuario' AND contrasena like '$contrasenia'";
        $result = $conn->query($query);

        if ($result->num_rows == 0){
            
            echo<<<_END
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Document</title>
            </head>
            <body>
                <p style='color:red;'>*usuario o contraseña fallidos</p>
                <form method = "post" action="ejercicio3.php">
            
                    <lavel>usuario:<lavel>
                    <input type="text" name="usuario">

                    <lavel>contraseña:<lavel>
                    <input type="text" name="contrasenia">

                    <input type="submit" name="inicio" value = "iniciar sesion">

                </form>    
            </body>
            </html>
        _END;

        }else{

            $row = $result->fetch_assoc();
            $rol = $row['rol'];

            $conn2 = new mysqli('localhost', "$rol", '', 'usuarios');
            if ($conn2->connect_error)
                die("Fatal Error");

            try{

            $query = "INSERT INTO `usuarios` (`usuario`, `contrasena`, `nombre`, `apellidos`, `email`, `rol`) VALUES ('Sergio', '123', 'Sergio', 'Charro', 'sss@gmail.com', 'consultor')";
            $result = $conn2->query($query);
                echo "<p style='color:green;'>añadido correctamente</p>";

            }catch(mysqli_sql_exception){

                echo "<p style='color:red;'>*no tienes permisos</p>";

            }
        
        }
            

    }else{

        echo<<<_END
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Document</title>
            </head>
            <body>
                <form method = "post" action="ejercicio3.php">
            
                    <lavel>usuario:<lavel>
                    <input type="text" name="usuario">

                    <lavel>contraseña:<lavel>
                    <input type="text" name="contrasenia">

                    <input type="submit" name="inicio" value = "iniciar sesion">

                </form>    
            </body>
            </html>
        _END;
    }
?>

<?php
    session_start();
    // Reinicia El Contador
    if($_SERVER['REQUEST_METHOD'] === 'GET') {
        $_SESSION['contador'] = 1;
    }

    // Array De Imagenes
    $img[0] = './imagenes/OIP0.jfif'; 
    $img[1] = './imagenes/OIP1.jfif'; 
    $img[2] = './imagenes/OIP2.jfif'; 
    $img[3] = './imagenes/OIP3.jfif'; 
    $img[4] = './imagenes/OIP4.jfif'; 

    // Inicializando Contador, Empieza Mostrando 1 Imagen
    if(!isset($_SESSION["contador"])){
        $_SESSION["contador"] = 1;
    }

    // Cada Vez Que Se Incremente Y Sea Menos De 5 El Contador Suma
    if(isset($_POST["incrementar"])){
        if($_SESSION["contador"] < 5){
            $_SESSION["contador"]++;
        }
    }

    // Cuando Le De A Grabar, Pase De Pagina
    if(isset($_POST["grabar"])){
        header("Location: agenda.php");
        exit;
    }
    // Si Llega A 5 Tambien Pasa
    if($_SESSION["contador"]==5){
        header("Location: agenda.php");
        exit;           
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda</title>
</head>
<body>
    <h1>Agenda</h1>
    <?php
        echo "Hola " .$_SESSION["nombre"] ." cuantos contactos deseas grabar?";
        echo "<br>Puedes grabar entre 1 y 5. Por cada pulsacion en INCREMENTAR grabaras un usario mas. ";
        echo "<br>Cuando el número sea el deseado pulsa GRABAR<br><br>";

        // Bucle Imprimir Imagenes
        for($i = 0; $i < $_SESSION["contador"]; $i++){
            $indice = rand(0,4);
            echo '<img src="' . $img[$indice] . '" alt="Descripción de la imagen" width="100" height="100">';
        }
    ?>
    <br><br>
    <form method="post">
        <input type="submit" name="incrementar" value="INCREMENTAR">
        <input type="submit" name="grabar" value="GRABAR"> 
    </form>
</body>
</html>
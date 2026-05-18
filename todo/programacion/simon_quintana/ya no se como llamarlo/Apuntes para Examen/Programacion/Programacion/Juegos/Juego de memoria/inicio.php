<?php
session_start();
$hn = 'localhost';
$db = 'memoria';   // nombre de la BD
$un = 'jugador';   // usuario de la BD
$pw = '';          // contraseña

if ($connection->connect_error) die("Fatal Error");
$error = '';

if (!isset($_SESSION['login'])) {
    header("Location: index.php");
    exit();
}

echo "Bienvenido ".$_SESSION['login']."<br>";
echo "<form action='jugar.php' method='post'>";

//recorre el mazo de cartas 
for ($i=0; $i<count($_SESSION['mazo']); $i++) {
    // Usamos if/else 
    if (in_array($i, $_SESSION['levantadas'])) { //si la carta esta levantada, muestra el valor real
        $valor = $_SESSION['mazo'][$i];   
    } else { //sino muestra una x
        $valor = "X";                     // Mostrar carta oculta
    }
    //cada carta es un boton que envia su posicion al ficheron jugar
    echo "<button type='submit' name='carta' value='$i' style='width:80px;height:80px;'>$valor</button>";

    // cada 4 cartas hace un salto de linea
    if (($i+1)%4==0) echo "<br>";
}
echo "</form>";
?>
<a href="estadistica.php">Ver estadísticas</a>
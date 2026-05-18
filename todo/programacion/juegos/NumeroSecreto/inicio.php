<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: index.php");
    exit();
}

// Generamos el número secreto y lo guardamos en sesión
$_SESSION['secreto'] = rand(1,10);

echo "Bienvenido ".$_SESSION['login']."<br>";
echo "<h2>He pensado un número entre 1 y 10</h2>";
echo "<form action='jugar.php' method='post'>";
echo "Tu intento: <input type='number' name='intento' min='1' max='10'>";
echo "<input type='submit' value='Comprobar'>";
echo "</form>";
?>
<a href="estadistica.php">Ver estadísticas</a>

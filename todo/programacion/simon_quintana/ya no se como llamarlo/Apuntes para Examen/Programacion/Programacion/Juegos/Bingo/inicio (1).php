<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: index.php");
    exit();
}

echo "Bienvenido ".$_SESSION['login']."<br>";
echo "<a href='jugar.php'>Sacar número 🎱</a><br>";
echo "<a href='estadistica.php'>Ver estadísticas</a>";
?>

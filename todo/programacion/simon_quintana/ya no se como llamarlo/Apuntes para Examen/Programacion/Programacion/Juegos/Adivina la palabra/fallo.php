<?php
session_start();
echo "<h1>Has fallado </h1>";
echo "<p>La palabra era: ".$_SESSION['palabra']."</p>";
echo "<p>Tu progreso fue: ".$_SESSION['progreso']."</p>";
?>
<a href="inicio.php">Volver a jugar</a><br>
<a href="estadistica.php">Ver estadísticas</a>

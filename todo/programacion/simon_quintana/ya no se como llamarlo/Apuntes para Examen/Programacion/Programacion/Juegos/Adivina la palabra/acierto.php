<?php
session_start();
echo "<h1>¡Has acertado la palabra!</h1>";
echo "<p>La palabra era: ".$_SESSION['palabra']."</p>";
?>
<a href="inicio.php">Volver a jugar</a><br>
<a href="estadistica.php">Ver estadísticas</a>

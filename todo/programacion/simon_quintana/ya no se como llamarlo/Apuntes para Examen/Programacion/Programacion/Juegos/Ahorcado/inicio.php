<?php
session_start();
//si no hay usuairo en sesion vuekve a login
if (!isset($_SESSION['login'])) {
    header("Location: index.php");
    exit();
}
//mostrar usuario y profresion actual de la palabta
echo "Bienvenido, " . $_SESSION['login'];
echo "<br>Palabra a adivinar: " . $_SESSION['progreso'];
?>
<!-- Formulario para introducir una letra -->
<form action="jugar.php" method="post">
    Introduce letra: <input type="text" name="letra" maxlength="1">
    <input type="submit" name="submit" value="Probar">
</form>
<a href="estadistica.php">Ver estadísticas</a>

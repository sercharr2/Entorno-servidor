<?php

session_start();

echo <<<_END
<html>
    <body>
        <h2>Dificultad Simon</h2>
        <form action="inicio.php" method="post">
            <p>Numero de circulos con los que jugar</p>
            <select name="numero">
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
            </select><br><br>
            
        <p>Numero de colores con los que jugar</p>
        <select name="numero-colores">
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
        </select><br><br>
        <input type="submit" value="Jugar">
        </form>
    </body>
</html>

_END;


?>
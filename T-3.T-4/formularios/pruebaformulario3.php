<?php
$suma = null;

if (isset($_POST['numero1']) && isset($_POST['numero2'])) {
    $suma = $_POST['numero1'] + $_POST['numero2'];
}
?>

<html>
<body>
<?php
if (!is_null($suma)) {
    echo "<h1>Resultado: $suma</h1>";
}
?>

<form action="" method="post">
    <div>
        <label for="numero1">Número 1</label>
        <input type="number" id="numero1" name="numero1" placeholder="Primer número" required min="0" />
    </div>

    <div>
        <label for="numero2">Número 2</label>
        <input type="number" id="numero2" name="numero2" placeholder="Segundo número" required min="0" />
    </div>

    <button type="submit">Sumar</button>
</form>
</body>
</html>

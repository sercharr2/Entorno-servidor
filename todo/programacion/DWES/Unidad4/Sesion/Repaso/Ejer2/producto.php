<?php
    session_start();
    if(isset($_POST["nombre"])){
        $_SESSION["nombre"] = $_POST["nombre"];
    }

    $nombre = $_SESSION["nombre"] ?? '';

    // Array Productos
    $productos = [
        "monitor" => ["nombre" => "Monitor", "descripcion" => "22 pulgadas", "precio" => 210],
        "movil" => ["nombre" => "Movil", "descripcion" => "4g", "precio" => 300],
        "mp4" => ["nombre" => "Mp4", "descripcion" => "20gb", "precio" => 13],
        "raton" => ["nombre" => "Raton", "descripcion" => "6000 dpi", "precio" => 20],
        "alfombrilla" => ["nombre" => "Alfombrilla", "descripcion" => "negra", "precio" => 30],
        "usb" => ["nombre" => "Usb", "descripcion" => "2gb", "precio" => 5]
    ];

    // Inizializar Carrito
    if(!isset($_SESSION["carrito"])){
        $_SESSION["carrito"] = [];
    }

    // Añadir Producto
    if(isset($_POST["add"])){ 
        $id = $_POST["add"]; // guarda en $id el valor del boton

        if(!isset($_SESSION["carrito"][$id])){
            $_SESSION["carrito"][$id] = 1; // Si el producto no esta en el carrito pone "1"
        } else {
            $_SESSION["carrito"][$id]++; // Si esta le suma
        }
    }

    // Quitar Producto
    if(isset($_POST["remove"])){
        $id = $_POST["remove"]; // guarda en $id el producto a borrar

        if(isset($_SESSION["carrito"][$id])){ 
            $_SESSION["carrito"][$id]--; // Si el producto esta en el carrito le resta 1
            
            if($_SESSION["carrito"][$id] <= 0){
                unset($_SESSION["carrito"][$id]); // Si despues queda 0 o menos, lo borra del carrito
            }
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Producto</title>
</head>
<body>
    <h3>Bienvenido, <?php echo $nombre; ?> </h3>
    <table border="1">
        <tr>
            <th>Producto</th>
            <th>Descripción</th>
            <th>Precio</th>
            <th></th>
        </tr>

        <?php foreach ($productos as $id => $p): ?> <!-- Recorre el array productos 
            $id clave del producto
            $p nombre, producto, precio
            -->
        <tr>
        <!-- Cada iteracion una fila con los datos -->
            <td><?= $p["nombre"] ?></td>
            <td><?= $p["descripcion"] ?></td>
            <td><?= $p["precio"] ?>€</td>
            <td>
            <!-- Envia POST y añade el producto -->
                <form method="POST">
                    <button type="submit" name="add" value="<?= $id ?>">Añadir al carrito</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

    <h3>Carrito</h3>
    <!-- Verifica si el array carrito esta vacio -->
    <?php if (empty($_SESSION["carrito"])): ?>
        <p>El carrito está vacío.</p>
    <?php else: ?>

    <table border="1">
        <tr>
            <th>Producto</th>
            <th>Unidades</th>
            <th>Quitar</th>
        </tr>

        <!-- Recorrer productos del carrito
            $id identificador del producto(monitor)
            $cantidad numero de unidades
        -->
        <?php foreach ($_SESSION["carrito"] as $id => $cantidad): ?>
        <tr>
            <td><?= $productos[$id]["nombre"] ?></td>
            <td><?= $cantidad ?></td>
            <td>
                <form method="POST">
                    <button type="submit" name="remove" value="<?= $id ?>">-</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

    <form action="confirmar.php" method="POST">
        <button type="submit">Confirmar Compra</button>
    </form>
    <?php endif; ?>
</body>
</html>

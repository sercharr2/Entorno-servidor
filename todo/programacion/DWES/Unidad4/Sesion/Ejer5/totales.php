<?php   
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Totales</title>
</head>
<body>
    <h1>Agenda</h1>
    <?php
        echo "Hola " .$_SESSION["nombre"];
        $hn = 'localhost';
        $db = 'agenda';
        $un = 'root';
        $pw = '';
    
        $conn = new mysqli($hn, $un, $pw, $db);
        if ($conn->connect_error) die("Error de conexión: " . $conn->connect_error);
    
        // Consulta SQL para obtener registros
        $sql = "
                SELECT u.Codigo, u.Nombre,
                    COUNT(c.codusuario) AS total_contactos
                FROM usuarios u
                LEFT JOIN contactos c ON u.codigo = c.codusuario
                GROUP BY u.codigo, u.nombre
                ";
        $result = $conn->query($sql);
    
        $data = [];
        if($result && $result-> num_rows > 0){
            while($row = $result->fetch_assoc()){
                $data[] = $row;
            }
        }
    ?>
    <table border="1">
        <tr>
            <th>Código Usuario</th>
            <th>Nombre</th>
            <th>Número De Contactos</th>
            <th>Gráfica</th>
        </tr>
        <?php foreach ($data as $row): ?>
        <tr>
            <td><?= $row['Codigo'] ?></td>
            <td><?= $row['Nombre'] ?></td>
            <td><?= $row['total_contactos'] ?></td>
            <td>
                <?php
                    for($i = 0; $i < $row['total_contactos']; $i++){
                        echo "🔴";
                    }
                ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
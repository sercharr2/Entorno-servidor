<?php
session_start();
require_once 'datos_Jeroglificos.php';


$loginErr = $claveErr = '';
$login = $clave ='';
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = trim($_POST['login']);
    $clave = trim($_POST['clave']);
    
        if (empty($login)) {
        $loginErr = "* El nombre es obligatorio";
    } elseif (!preg_match('/^[a-zA-Z ]{4,20}$/', $login)) {
        $loginErr = "* Solo letras y espacios, 4-20 caracteres";
    }

    if (empty($clave)) {
        $claveErr = "* La contraseña es obligatoria";
    } elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $clave)) {
        $claveErr = "* Contraseña requiere mínimo 8 caracteres con 1 mayúscula, 1 minúscula, 1 número y 1 símbolo";
    

    // Conexión a la base de datos
    $conn = new mysqli($hn, $un, $pw, $db);
    if ($conn->connect_error) die("Error al conectar: " . $conn->connect_error);

    // Consulta simple 
    $query = "SELECT * FROM jugador WHERE login = '$login' AND clave = '$clave'";
    $result = $conn->query($query);


    //condicional que relaciona codigousu con el codigo 
    if ($result && $result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $_SESSION['login'] = $login;
        $_SESSION['codigousu'] = $row['Codigo'];
        header("Location: inicio.php");
        exit;

    } else {
        $errors[] = "Usuario o contraseña incorrectos.";
    }
    $conn->close();
}
}
        $login_val = empty($loginErr) ? htmlspecialchars($login) : '';
?>

<!DOCTYPE html>
<html>
<head>
  <title>Inicio de sesión</title>
</head>
<body>
  <div class="container">
    <div class="d-flex min-vh-100">
      <div class="row d-flex flex-grow-1 justify-content-center align-items-center">
        <div class="col-md-4 form login-form">
          <form action="inicio.php" method="POST" autocomplete="off">
            <h2 class="text-center">Inicio de sesión</h2>

            <?php
            if (count($errors) > 0) {
                echo "<div class='alert alert-danger'>";
                foreach ($errors as $error) {
                    echo $error . "<br>";
                }
                echo "</div>";
            }
            ?>

            <div class="form-group mb-3">
                <input type="text" name="login" placeholder="Nombre" value="<?php echo $login_val; ?>">
                <span style="color:red;"><?php echo $loginErr; ?></span>
            </div>
            <div class="form-group mb-3">
                <input type="password" name="clave" class="form-control" placeholder="Contraseña" >
            </div>
            <div class="form-group mb-3">
                <input type="submit" class="form-control btn btn-primary" value="Acceder">
            </div>
          </form>
          <br><a href="">Crear cuenta</a><br>
          <br><a href="">Ver estadísticas</a><br>
        </div>
      </div>
    </div>
  </div>  
</body>
</html>

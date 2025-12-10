# 📋 PLANTILLAS DE EJERCICIOS - Guía Rápida

## 📁 Archivos disponibles

### 1. **plantilla_login_simple.php** ⭐ MÁS USADO
Plantilla de login basado en DNI que redirige según el rol (alumno/profesor)

**Características:**
- Busca en tabla `alumno` o `profesor`
- Asigna rol automáticamente
- Interfaz moderna y responsive
- Manejo de errores

**Uso rápido:**
```php
// Copiar archivo y adaptar la consulta según tu BD
// Cambiar: tabla alumno/profesor y columnas (dniA/dniP)
```

---

### 2. **plantilla_base.php**
Plantilla completa con login integrado + sesiones

**Incluye:**
- Sistema de login con usuario/contraseña
- Gestión de sesiones
- Validación de formularios
- Estructura HTML/CSS lista
- Funciones auxiliares

**Cuándo usar:**
- Ejercicios que requieren login con usuario/contraseña
- Cuando necesitas vistas diferentes por rol

---

### 3. **plantilla_crud.php**
Funciones reutilizables para operaciones de base de datos

**Funciones disponibles:**
```php
crear_registro($conn, $tabla, $campos, $valores)
leer_registros($conn, $tabla, $condicion)
actualizar_registro($conn, $tabla, $campos, $condicion)
eliminar_registro($conn, $tabla, $condicion)
existe_registro($conn, $tabla, $condicion)
contar_registros($conn, $tabla, $condicion)
```

**Ejemplo:**
```php
// Crear
crear_registro($conn, 'matricula', 
    ['dnialumno', 'codcurso', 'pruebaA'],
    ['1111', '0001', 80]
);

// Leer
$matriculas = leer_registros($conn, 'matricula', "dnialumno = '1111'");

// Actualizar
actualizar_registro($conn, 'matricula',
    ['pruebaA' => 85],
    "dnialumno = '1111' AND codcurso = '0001'"
);

// Verificar existencia
if (existe_registro($conn, 'matricula', "dnialumno = '1111' AND codcurso = '0001'")) {
    echo "Ya está matriculado";
}
```

---

### 4. **plantilla_validacion.php**
Clase `Validador` para validar formularios de forma elegante

**Métodos principales:**
```php
$v = new Validador($_POST);

// Campos obligatorios
$v->obligatorio('campo', 'Nombre del campo');

// Validaciones específicas
$v->email('email');
$v->dni('dni');
$v->numero('edad', 18, 100);  // Con min y max
$v->fecha('fecha_nac', 'Y-m-d');
$v->patron('telefono', '/^\d{9}$/', 'Debe tener 9 dígitos');
$v->minimo('contraseña', 8);
$v->maximo('nombre', 50);
$v->coincide('pass', 'pass2', 'Contraseñas');

// Verificar
if (!$v->tiene_errores()) {
    // Guardar datos
} else {
    echo $v->mostrar_errores();
}

// Obtener valor seguro
echo $v->obtener('nombre');  // Con htmlspecialchars
```

---

### 5. **datos_conexion_plantilla.php**
Configuración centralizada para todos los proyectos

**Incluye:**
- Datos de conexión (host, usuario, contraseña, BD)
- Constantes de mensajes
- Estilos CSS reutilizables
- Funciones auxiliares (`conectar_bd()`, `cerrar_sesion()`, `redirigir()`)

**Uso:**
```php
// En tu archivo
require_once 'datos_conexion.php';

$conn = conectar_bd();
// Ya está conectado
```

---

## 🚀 Flujo típico de un ejercicio

### 1. **Crear estructura del proyecto**
```
proyecto/
├── index.php                    (Login)
├── ejercicio.php                (Lógica principal)
├── datos_conexion.php           (Copiar de plantilla_conexion.php)
└── materiales/
    └── base_datos.sql
```

### 2. **Archivo index.php (login)**
```php
<?php
session_start();
require_once 'datos_conexion.php';

$errors = [];
$dni = $_POST['dni'] ?? '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = conectar_bd();
    
    // Buscar en alumno
    $query = "SELECT * FROM alumno WHERE dniA = '$dni'";
    $result = $conn->query($query);
    
    if ($result && $result->num_rows === 1) {
        $_SESSION['dni'] = $dni;
        $_SESSION['rol'] = 'alumno';
        header("Location: ejercicio.php");
        exit;
    }
    
    $errors[] = "DNI no encontrado";
    $conn->close();
}
?>
<!-- Copiar HTML de plantilla_login_simple.php -->
```

### 3. **Archivo ejercicio.php (lógica)**
```php
<?php
session_start();
require_once 'datos_conexion.php';

// Verificar sesión
if (!isset($_SESSION['dni'])) {
    header("Location: index.php");
    exit;
}

$conn = conectar_bd();
$dni = $_SESSION['dni'];
$rol = $_SESSION['rol'];

// VALIDAR FORMULARIO
$v = new Validador($_POST);
// ... validaciones ...

if ($_SERVER["REQUEST_METHOD"] == "POST" && !$v->tiene_errores()) {
    // GUARDAR EN BD
    crear_registro($conn, 'tabla', ['campos'], ['valores']);
}

// MOSTRAR DATOS
$registros = leer_registros($conn, 'tabla', "condicion");
?>
<!DOCTYPE html>
<html>
<head>
    <style><?php echo ESTILOS_BASE; ?></style>
</head>
<body>
    <div class="container">
        <?php echo $v->mostrar_errores(); ?>
        
        <!-- Formulario -->
        <form method="POST">
            <!-- Campos -->
        </form>
        
        <!-- Tabla de datos -->
        <table>
            <thead>
                <tr>
                    <th>Columna 1</th>
                    <th>Columna 2</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($registros as $reg): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($reg['campo']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
```

---

## 💡 Patrones comunes encontrados en exámenes

### Patrón 1: Mostrar datos según rol
```php
if ($rol === 'profesor') {
    // Mostrar cursos del profesor
    $query = "SELECT * FROM curso WHERE profesor = '$dni'";
} elseif ($rol === 'alumno') {
    // Mostrar formulario de matrícula
    // ...
}
```

### Patrón 2: Validar que existe en BD antes de insertar
```php
if (existe_registro($conn, 'curso', "codigocurso = '$codigo'")) {
    // Guardar
} else {
    $errors[] = "El curso no existe";
}
```

### Patrón 3: Evitar duplicados
```php
if (!existe_registro($conn, 'matricula', "dnialumno = '$dni' AND codcurso = '$curso'")) {
    crear_registro($conn, 'matricula', [...], [...]);
} else {
    $errors[] = "Ya está matriculado";
}
```

### Patrón 4: Calcular totales
```php
// Suma
$query = "SELECT SUM(numhoras) as total FROM curso WHERE profesor = '$dni'";
$result = $conn->query($query);
$row = $result->fetch_assoc();
echo "Total de horas: " . $row['total'];
```

---

## 🎯 Checklist para cada ejercicio

- [ ] Copiar `datos_conexion.php` de plantilla
- [ ] Crear `index.php` con login
- [ ] Crear archivo principal con lógica
- [ ] Validar todos los campos del formulario
- [ ] Verificar existencia en BD antes de insertar
- [ ] Usar `htmlspecialchars()` al mostrar datos
- [ ] Usar `$conn->real_escape_string()` en consultas
- [ ] Manejar errores con try/catch
- [ ] Mostrar mensajes de éxito/error
- [ ] Probar con datos válidos e inválidos

---

## 📝 Ejemplo rápido completo

**Crear sistema de registro de usuarios:**

1. Copiar `datos_conexion.php`
2. Crear `index.php`:
```php
<?php
session_start();
require_once 'datos_conexion.php';
require_once 'plantilla_validacion.php';

$v = new Validador($_POST);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $v->obligatorio('nombre');
    $v->email('email');
    $v->numero('edad', 18, 100);
    
    if (!$v->tiene_errores()) {
        $conn = conectar_bd();
        crear_registro($conn, 'usuarios', 
            ['nombre', 'email', 'edad'],
            [$_POST['nombre'], $_POST['email'], $_POST['edad']]
        );
        $conn->close();
        echo "Usuario creado";
    }
}
?>
<!DOCTYPE html>
<html>
<body>
    <div class="container">
        <?php echo $v->mostrar_errores(); ?>
        <form method="POST">
            <input name="nombre" placeholder="Nombre" value="<?php echo $v->obtener('nombre'); ?>">
            <input name="email" placeholder="Email" value="<?php echo $v->obtener('email'); ?>">
            <input name="edad" type="number" placeholder="Edad" value="<?php echo $v->obtener('edad'); ?>">
            <button>Registrar</button>
        </form>
    </div>
</body>
</html>
```

---

## ⚠️ IMPORTANTE - Seguridad

**NUNCA hacer esto:**
```php
// ❌ MAL
$query = "SELECT * FROM usuarios WHERE id = " . $_POST['id'];
```

**HACER ESTO:**
```php
// ✅ BIEN
$id = intval($_POST['id']);  // Para números
$query = "SELECT * FROM usuarios WHERE id = " . $id;

// ✅ O MEJOR
$email = $conn->real_escape_string($_POST['email']);
$query = "SELECT * FROM usuarios WHERE email = '$email'";
```

---

## 🔗 Relación entre archivos

```
datos_conexion.php
    ↓
Proporciona: $hn, $un, $pw, $db, constantes, estilos, funciones
    ↓
Usado por: index.php, ejercicio.php
    ↓
Junto con: plantilla_validacion.php (validar)
           plantilla_crud.php (operaciones BD)
```

---

**¡Ahora estás listo para resolver ejercicios rápidamente!** ✨

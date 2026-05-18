# 📋 PLANTILLAS SIMPLIFICADAS

## 🎯 Objetivo
Plantillas ultra simples basadas en el estilo de "Simon Final Fase 4". Directo, sin complicaciones.

---

## 📁 Archivos

### 1. **login.php** - Pantalla de Login
- Pide DNI
- Busca en tabla `alumno` o `profesor`
- Asigna rol y redirige a `ejercicio.php`

**Adaptar:**
```php
// Cambiar el nombre de la BD
$conn = new mysqli('localhost', 'root', '', 'MI_BASE_DATOS');
```

---

### 2. **ejercicio.php** - Lógica Principal
- Verifica sesión
- Muestra panel diferente para profesor y alumno
- Profesor: lista de cursos que imparte
- Alumno: formulario de matrícula + lista de matrículas

**Para profesor:**
- Solo muestra cursos donde `profesor = DNI`
- Calcula total de horas

**Para alumno:**
- Formulario con validación
- Verifica que curso existe
- Verifica que no esté duplicado
- Muestra matrículas

---

### 3. **datos_conexion.php** - Funciones Básicas

**Usar así:**
```php
require_once 'datos_conexion.php';

$conn = conectar();

// Verificar existencia
if (existe($conn, 'alumno', "dniA = '1111'")) {
    echo "El alumno existe";
}

// Obtener un registro
$alumno = obtener($conn, 'alumno', "dniA = '1111'");
echo $alumno['nombreA'];

// Obtener todos
$cursos = obtener_todos($conn, 'curso', "profesor = '111'");
foreach ($cursos as $curso) {
    echo $curso['nombrecurso'];
}
```

---

## 🚀 Cómo Usar

### 1. Copiar archivos
```
proyecto/
├── login.php
├── ejercicio.php
└── datos_conexion.php
```

### 2. Adaptaciones necesarias
En `login.php` y `ejercicio.php`, cambiar:
```php
$conn = new mysqli('localhost', 'root', '', 'oposicion');  // Tu BD aquí
```

Y cambiar nombres de tablas si es necesario:
```php
// De esto:
$query = "SELECT * FROM alumno WHERE dniA = '$dni'";

// A esto (si tus columnas son diferentes):
$query = "SELECT * FROM estudiantes WHERE id = '$dni'";
```

### 3. Listo!
Abre `login.php` y empieza a usar.

---

## 💡 Ejemplos Rápidos

### Agregar otra vista (ej: administrador)
En `ejercicio.php`, después de `elseif ($rol === 'alumno')`:
```php
elseif ($rol === 'admin') {
    // Tu lógica aquí
    echo "<h1>Panel de Administrador</h1>";
}
```

### Agregar validación extra
```php
if (empty($curso)) {
    $error = "El curso es obligatorio";
} elseif (strlen($curso) < 4) {
    $error = "El código debe tener al menos 4 caracteres";
}
```

### Mostrar contador de registros
```php
$total = obtener_todos($conn, 'matricula', "dnialumno = '$dni'");
echo "Total de matrículas: " . count($total);
```

---

## 📝 Checklist

- [ ] Copiar los 3 archivos
- [ ] Cambiar nombre de la BD en `login.php` y `ejercicio.php`
- [ ] Probar login
- [ ] Probar vista de profesor
- [ ] Probar vista de alumno
- [ ] Probar formulario de matrícula
- [ ] Probar logout

---

## ⚠️ IMPORTANTE

**Validación básica (lo mínimo):**
```php
if (empty($campo)) {
    $error = "Campo obligatorio";
}
```

**Más strict:**
```php
if (empty($campo) || strlen($campo) < 3) {
    $error = "Campo inválido";
}
```

**Con regex:**
```php
if (!preg_match('/^\d{8,9}$/', $campo)) {
    $error = "DNI inválido";
}
```

---

## 🎨 Personalizar estilos

Los estilos están adentro de cada archivo. Cambiar colores:

```css
/* De esto: */
background: #667eea;

/* A esto: */
background: #333;
```

Colores sugeridos:
- Azul: `#667eea`
- Rojo: `#c92a2a`
- Verde: `#27ae60`
- Gris: `#666`

---

¡Eso es! Mucho más simple. 🚀

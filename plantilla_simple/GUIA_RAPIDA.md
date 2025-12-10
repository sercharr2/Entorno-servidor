# ⚡ GUÍA RÁPIDA - Usar las Plantillas en 5 Minutos

## 1️⃣ Copiar Archivos
```
Tu proyecto/
├── login.php          (copiar de plantilla_simple/login.php)
├── ejercicio.php      (copiar de plantilla_simple/ejercicio.php)
└── datos_conexion.php (copiar de plantilla_simple/datos_conexion.php)
```

---

## 2️⃣ Adaptar BD

**En `login.php` línea 13:**
```php
// Cambiar esto:
$conn = new mysqli('localhost', 'root', '', 'oposicion');

// A tu BD:
$conn = new mysqli('localhost', 'root', '', 'tu_base_datos');
```

**En `ejercicio.php` línea 16:**
```php
// Idem
```

---

## 3️⃣ Cambiar Nombres de Tablas y Columnas

Si tus tablas tienen otros nombres, cambiar:

```php
// En login.php:
$query = "SELECT * FROM alumno WHERE dniA = '...'";     // Tu tabla + columna
$query = "SELECT * FROM profesor WHERE dniP = '...'";   // Tu tabla + columna

// En ejercicio.php:
$query = "SELECT * FROM profesor WHERE dniP = '$dni'";
$query = "SELECT * FROM curso WHERE profesor = '$dni'";
// etc
```

---

## 4️⃣ Listo!

Abre en navegador:
```
http://localhost/tu_proyecto/login.php
```

---

## 📝 Ejemplos de Cambios Comunes

### Cambiar tabla de alumnos
```php
// Si tu tabla se llama "estudiantes" en lugar de "alumno"
$query = "SELECT * FROM estudiantes WHERE id = '{$_SESSION['dni']}'";
```

### Cambiar columna de DNI
```php
// Si en lugar de dniA usas dni o id
$query = "SELECT * FROM alumno WHERE dni = '{$_SESSION['dni']}'";
```

### Agregar más campos al formulario
En `ejercicio.php`, agregar dentro del formulario:
```html
<div class="form-group">
    <label>Calificación:</label>
    <input type="number" name="calificacion" min="0" max="10">
</div>
```

Y procesar en la validación:
```php
if (empty($_POST['calificacion'])) {
    $error = "Calificación es obligatoria";
}
```

### Cambiar validación
```php
// En lugar de validar todos los campos:
if (empty($curso) || empty($pruebaA) || empty($pruebaB) || empty($tipo) || empty($inscripcion)) {

// Solo validar algunos:
if (empty($curso) || empty($pruebaA)) {
    $error = "Curso y Prueba A son obligatorios";
}
```

---

## 🔧 Troubleshooting

**Error: "No se puede conectar"**
- Verificar que MySQL está corriendo
- Verificar que escribiste bien el nombre de la BD

**Error: "DNI no encontrado"**
- Verificar que el DNI existe en la BD
- Verificar que escribiste bien los nombres de tablas

**Error: "La matrícula no se guardó"**
- Ver que todos los campos estén llenos
- Verificar que el código del curso existe
- Verificar que no esté duplicado

---

## 💾 Backup

Si algo sale mal, todo está en `plantilla_simple/` así que podes copiar de nuevo.

---

## 🎓 Para Aprender

Leer los archivos en este orden:
1. `README.md` - Entender qué hace cada archivo
2. `login.php` - Ver cómo funciona el login
3. `ejercicio.php` - Ver cómo se muestran los datos
4. `VALIDACIONES.php` - Ver ejemplos de validación
5. `SNIPPETS.php` - Tener código listo para copiar

---

¡Eso es todo! 🚀

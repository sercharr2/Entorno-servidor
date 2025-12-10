<?php
/**
 * VALIDACIONES COMUNES
 * Copiar y pegar según necesites
 */

// =============== VALIDACIÓN 1: CAMPO OBLIGATORIO ===============
/*
if (empty($_POST['dni'])) {
    $error = "DNI es obligatorio";
}
*/

// =============== VALIDACIÓN 2: CAMPO VACÍO O NULL ===============
/*
if (!isset($_POST['campo']) || trim($_POST['campo']) == '') {
    $error = "El campo no puede estar vacío";
}
*/

// =============== VALIDACIÓN 3: LONGITUD MÍNIMA ===============
/*
if (strlen($_POST['campo']) < 5) {
    $error = "Mínimo 5 caracteres";
}
*/

// =============== VALIDACIÓN 4: LONGITUD MÁXIMA ===============
/*
if (strlen($_POST['campo']) > 50) {
    $error = "Máximo 50 caracteres";
}
*/

// =============== VALIDACIÓN 5: SOLO NÚMEROS ===============
/*
if (!is_numeric($_POST['numero'])) {
    $error = "Solo se permiten números";
}
*/

// =============== VALIDACIÓN 6: NÚMERO EN RANGO ===============
/*
$edad = intval($_POST['edad']);
if ($edad < 18 || $edad > 100) {
    $error = "La edad debe estar entre 18 y 100";
}
*/

// =============== VALIDACIÓN 7: EMAIL ===============
/*
if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $error = "Email no válido";
}
*/

// =============== VALIDACIÓN 8: DNI (SIMPLE) ===============
/*
if (!preg_match('/^\d{8,9}$/', $_POST['dni'])) {
    $error = "DNI debe tener 8 o 9 dígitos";
}
*/

// =============== VALIDACIÓN 9: TELÉFONO ===============
/*
if (!preg_match('/^\d{9,10}$/', $_POST['telefono'])) {
    $error = "Teléfono debe tener 9 o 10 dígitos";
}
*/

// =============== VALIDACIÓN 10: FECHA VÁLIDA ===============
/*
$fecha = $_POST['fecha'];
$d = DateTime::createFromFormat('Y-m-d', $fecha);
if (!$d || $d->format('Y-m-d') !== $fecha) {
    $error = "Fecha no válida";
}
*/

// =============== VALIDACIÓN 11: SOLO LETRAS ===============
/*
if (!preg_match('/^[a-zA-Z\s]+$/', $_POST['nombre'])) {
    $error = "Solo se permiten letras";
}
*/

// =============== VALIDACIÓN 12: ALFANUMÉRICO ===============
/*
if (!preg_match('/^[a-zA-Z0-9]+$/', $_POST['codigo'])) {
    $error = "Solo letras y números";
}
*/

// =============== VALIDACIÓN 13: CONTRASEÑA FUERTE ===============
/*
if (strlen($_POST['clave']) < 8) {
    $error = "Contraseña debe tener mínimo 8 caracteres";
}
*/

// =============== VALIDACIÓN 14: DOS CAMPOS IGUALES ===============
/*
if ($_POST['clave'] !== $_POST['clave2']) {
    $error = "Las contraseñas no coinciden";
}
*/

// =============== VALIDACIÓN 15: MÚLTIPLES VALIDACIONES ===============
/*
$errores = [];

if (empty($_POST['nombre'])) {
    $errores[] = "Nombre es obligatorio";
}

if (empty($_POST['email'])) {
    $errores[] = "Email es obligatorio";
}

if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $errores[] = "Email no válido";
}

if (!empty($errores)) {
    foreach ($errores as $error) {
        echo "<p style='color: red;'>$error</p>";
    }
}
*/

// =============== VALIDACIÓN COMPLETA PARA FORMULARIO ===============
/*
$errores = [];

// Validar todos los campos
if (empty($_POST['dni'])) {
    $errores[] = "DNI es obligatorio";
} elseif (!preg_match('/^\d{8,9}$/', $_POST['dni'])) {
    $errores[] = "DNI inválido";
}

if (empty($_POST['nombre'])) {
    $errores[] = "Nombre es obligatorio";
} elseif (strlen($_POST['nombre']) < 3) {
    $errores[] = "Nombre debe tener mínimo 3 caracteres";
}

if (empty($_POST['email'])) {
    $errores[] = "Email es obligatorio";
} elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $errores[] = "Email no válido";
}

// Si hay errores, detener
if (!empty($errores)) {
    foreach ($errores as $error) {
        echo "<p style='color: red;'>$error</p>";
    }
} else {
    // Proceder con la lógica
    // Guardar en BD, etc.
}
*/

// =============== USAR CON ISSET ===============
/*
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['enviar'])) {
    
    // Validar
    if (empty($_POST['campo'])) {
        $error = "Campo obligatorio";
    } else {
        // Procesar
    }
}
*/

// =============== TABLA DE VALIDACIONES RÁPIDAS ===============

/*

VALIDACIÓN              CÓDIGO
─────────────────────────────────────────────────────
Obligatorio             if (empty($_POST['x']))
Longitud mín            if (strlen($_POST['x']) < 5)
Longitud máx            if (strlen($_POST['x']) > 50)
Solo números            if (!is_numeric($_POST['x']))
Número 1-100            if ($x < 1 || $x > 100)
Email                   if (!filter_var($x, FILTER_VALIDATE_EMAIL))
DNI simple              if (!preg_match('/^\d{8,9}$/', $x))
Teléfono                if (!preg_match('/^\d{9,10}$/', $x))
Fecha Y-m-d             DateTime::createFromFormat('Y-m-d', $x)
Solo letras             if (!preg_match('/^[a-zA-Z\s]+$/', $x))
Letras+números          if (!preg_match('/^[a-zA-Z0-9]+$/', $x))
Iguales                 if ($_POST['x'] !== $_POST['y'])
En lista                if (!in_array($x, ['opt1', 'opt2']))

*/

?>

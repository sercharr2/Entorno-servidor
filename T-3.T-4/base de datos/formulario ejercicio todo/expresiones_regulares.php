<?php
 
# =============================
# REGEX PARA USUARIOS
# =============================
 
# 1. Usuario con letras, números, guion y guion bajo (3–16 caracteres)
$regexUsuario1 = '/^[a-zA-Z0-9_-]{3,16}$/';
 
# 2. Solo letras y números (4–20 caracteres)
$regexUsuario2 = '/^[a-zA-Z0-9]{4,20}$/';
 
# 3. Usuario tipo email
$regexUsuario3 = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[A-Z]{2,}$/i';
 
# 4. Usuario solo letras (3–20 caracteres)
$regexUsuario4 = '/^[a-zA-Z]{3,20}$/';
 
# 5. Usuario con letras, números y espacios (3–30)
$regexUsuario5 = '/^[a-zA-Z0-9 ]{3,30}$/';
 
 
 
# =============================
# REGEX PARA CONTRASEÑAS
# =============================
 
# 1. Mínimo 8 caracteres (sencilla)
$regexPassword1 = '/^.{8,}$/';
 
# 2. Mínimo 8 caracteres, al menos una letra y un número
$regexPassword2 = '/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/';
 
# 3. Contraseña fuerte:
#    - Min 8 caracteres
#    - 1 minúscula
#    - 1 mayúscula
#    - 1 número
#    - 1 símbolo
$regexPassword3 = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/';
 
# 4. Contraseña muy fuerte:
#    - 12+ caracteres
#    - Mayúscula, minúscula, número y 2 símbolos
$regexPassword4 = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=(?:.*[@$!%*?&]){2,}).{12,}$/';
 
# 5. Solo letras y números (8–20)
$regexPassword5 = '/^[A-Za-z0-9]{8,20}$/';
 
# 6. Contraseña con espacios permitidos, mínimo 10 chars
$regexPassword6 = '/^[\S ]{10,}$/';
 
 
 
?>
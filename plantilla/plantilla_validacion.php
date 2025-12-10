<?php
/**
 * PLANTILLA DE VALIDACIÓN - Patrones comunes en ejercicios
 * Reutilizable para validar formularios en ejercicios
 */

// =============== CLASE VALIDADOR ===============
class Validador {
    private $errores = [];
    private $datos = [];
    
    public function __construct($datos = []) {
        $this->datos = $datos;
    }
    
    // Agregar dato
    public function agregar_dato($clave, $valor) {
        $this->datos[$clave] = $valor;
    }
    
    // Validar campo obligatorio
    public function obligatorio($campo, $nombre = "") {
        $nombre = $nombre ?: $campo;
        
        if (!isset($this->datos[$campo]) || empty(trim($this->datos[$campo]))) {
            $this->errores[$campo] = "$nombre es obligatorio";
            return false;
        }
        return true;
    }
    
    // Validar que no esté vacío o nulo
    public function no_vacio($campo, $nombre = "") {
        $nombre = $nombre ?: $campo;
        
        if (empty($this->datos[$campo])) {
            $this->errores[$campo] = "$nombre no puede estar vacío";
            return false;
        }
        return true;
    }
    
    // Validar formato de email
    public function email($campo) {
        if (!filter_var($this->datos[$campo], FILTER_VALIDATE_EMAIL)) {
            $this->errores[$campo] = "El email no es válido";
            return false;
        }
        return true;
    }
    
    // Validar formato DNI
    public function dni($campo) {
        if (!preg_match('/^\d{8}[A-Z]$/', $this->datos[$campo]) && 
            !preg_match('/^\d{1,9}$/', $this->datos[$campo])) {
            $this->errores[$campo] = "DNI inválido";
            return false;
        }
        return true;
    }
    
    // Validar longitud mínima
    public function minimo($campo, $minimo) {
        if (strlen($this->datos[$campo]) < $minimo) {
            $this->errores[$campo] = "Mínimo $minimo caracteres";
            return false;
        }
        return true;
    }
    
    // Validar longitud máxima
    public function maximo($campo, $maximo) {
        if (strlen($this->datos[$campo]) > $maximo) {
            $this->errores[$campo] = "Máximo $maximo caracteres";
            return false;
        }
        return true;
    }
    
    // Validar que sea un número
    public function numero($campo, $minimo = null, $maximo = null) {
        if (!is_numeric($this->datos[$campo])) {
            $this->errores[$campo] = "Debe ser un número";
            return false;
        }
        
        if ($minimo !== null && $this->datos[$campo] < $minimo) {
            $this->errores[$campo] = "El valor mínimo es $minimo";
            return false;
        }
        
        if ($maximo !== null && $this->datos[$campo] > $maximo) {
            $this->errores[$campo] = "El valor máximo es $maximo";
            return false;
        }
        
        return true;
    }
    
    // Validar fecha
    public function fecha($campo, $formato = 'Y-m-d') {
        $date = DateTime::createFromFormat($formato, $this->datos[$campo]);
        if (!$date || $date->format($formato) !== $this->datos[$campo]) {
            $this->errores[$campo] = "Fecha inválida (formato: $formato)";
            return false;
        }
        return true;
    }
    
    // Validar formato personalizado (regex)
    public function patron($campo, $regex, $mensaje = "") {
        $mensaje = $mensaje ?: "Formato inválido";
        
        if (!preg_match($regex, $this->datos[$campo])) {
            $this->errores[$campo] = $mensaje;
            return false;
        }
        return true;
    }
    
    // Validar que dos campos coincidan
    public function coincide($campo1, $campo2, $nombre = "") {
        $nombre = $nombre ?: "$campo1 y $campo2";
        
        if ($this->datos[$campo1] !== $this->datos[$campo2]) {
            $this->errores[$campo1] = "$nombre no coinciden";
            return false;
        }
        return true;
    }
    
    // Validar que el valor esté en una lista permitida
    public function en_lista($campo, $lista, $nombre = "") {
        $nombre = $nombre ?: $campo;
        
        if (!in_array($this->datos[$campo], $lista)) {
            $this->errores[$campo] = "$nombre no válido";
            return false;
        }
        return true;
    }
    
    // Obtener errores
    public function obtener_errores() {
        return $this->errores;
    }
    
    // ¿Hay errores?
    public function tiene_errores() {
        return count($this->errores) > 0;
    }
    
    // Obtener valor seguro
    public function obtener($campo, $predeterminado = "") {
        return isset($this->datos[$campo]) ? htmlspecialchars($this->datos[$campo]) : $predeterminado;
    }
    
    // Mostrar errores en HTML
    public function mostrar_errores() {
        if (empty($this->errores)) {
            return "";
        }
        
        $html = "<div style='background:#ffe6e6; border:1px solid #ff6b6b; padding:15px; border-radius:5px; margin:15px 0;'>";
        $html .= "<h4 style='color:#c92a2a; margin-top:0;'>Errores encontrados:</h4>";
        $html .= "<ul style='color:#c92a2a; margin:10px 0;'>";
        
        foreach ($this->errores as $error) {
            $html .= "<li>$error</li>";
        }
        
        $html .= "</ul></div>";
        
        return $html;
    }
}

// =============== EJEMPLO DE USO ===============

/*

// Simular datos POST
$datos = [
    'nombre' => 'Juan',
    'email' => 'juan@email.com',
    'dni' => '12345678A',
    'edad' => '25',
    'fecha_nac' => '2000-01-15',
    'telefono' => '612345678'
];

// Crear validador
$validador = new Validador($datos);

// Validar campos
$validador->obligatorio('nombre', 'Nombre');
$validador->email('email');
$validador->dni('dni');
$validador->numero('edad', 18, 100);
$validador->fecha('fecha_nac');
$validador->patron('telefono', '/^\d{9,10}$/', 'Teléfono debe tener 9-10 dígitos');

// Verificar si hay errores
if (!$validador->tiene_errores()) {
    echo "Datos válidos, proceder a guardar";
} else {
    echo $validador->mostrar_errores();
}

// Obtener valor seguro para mostrar en formulario
echo $validador->obtener('nombre');

*/
?>

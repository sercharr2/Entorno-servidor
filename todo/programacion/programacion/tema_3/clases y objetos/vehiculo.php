<?php
/*
    vehiculo.php - Clase base

    Contiene: constantes, constructor, métodos básicos y ver_atributo() mejorado.
*/

class Vehiculo {
    protected $color;
    protected $peso;
    protected $numero_cadenas_nieve = 0;
    const SALTO_DE_LINEA = "<br />";

    // según el enunciado 5/6, podría ser protegido; aquí lo dejamos público para facilitar acceso
    public static $numero_cambio_color = 0;

    public function __construct($color, $peso) {
        $this->color = $color;
        $this->setPeso($peso);
    }

    public function circula() {
        echo "El vehículo circula" . self::SALTO_DE_LINEA;
    }

    public function setColor($color) {
        $this->color = $color;
        self::$numero_cambio_color++;
    }

    public function getColor() {
        return $this->color;
    }

    public function setPeso($peso) {
        // límite máximo implementado (ej6): 2100. Si no quieres límite aquí, quítalo.
        $this->peso = ($peso > 2100) ? 2100 : $peso;
    }

    public function getPeso() {
        return $this->peso;
    }

    public function añadir_persona($peso_persona) {
        $this->peso += $peso_persona;
    }

    public function poner_gasolina($litros) {
        $this->peso += $litros; // 1 litro = 1 kg según enunciado
    }

    public function añadir_cadenas_nieve() {
        $this->numero_cadenas_nieve++;
    }

    public function quitar_cadenas_nieve() {
        if ($this->numero_cadenas_nieve > 0) {
            $this->numero_cadenas_nieve--;
        }
    }

    public function getNumeroCadenasNieve() {
        return $this->numero_cadenas_nieve;
    }

    /**
     * Muestra todos los atributos (públicos/protegidos/privados) de un objeto.
     * Usa Reflection para acceder incluso a propiedades no públicas.
     */
    public static function ver_atributo($objeto) {
        $refClass = new ReflectionObject($objeto);
        $props = $refClass->getProperties();

        foreach ($props as $prop) {
            $prop->setAccessible(true); // permite leer protected/private
            $name = $prop->getName();
            $value = $prop->getValue($objeto);
            echo "$name: " . (is_null($value) ? 'NULL' : $value) . self::SALTO_DE_LINEA;
        }
    }
}
?>

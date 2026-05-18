<?php
require_once "vehiculo.php";

class Cuatro_ruedas extends Vehiculo {
    protected $numero_puertas = 0;

    public function añadir_persona($peso_persona) {
        $this->peso += $peso_persona;
    }

    public function setNumeroPuertas($n) {
        $this->numero_puertas = (int)$n;
    }

    public function getNumeroPuertas() {
        return $this->numero_puertas;
    }
}
?>

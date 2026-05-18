<?php
require_once "vehiculo.php";

class Dos_ruedas extends Vehiculo {
    protected $cilindrada = null;

    // Sobrescribe añadir_persona: añade peso + 2 kg casco
    public function añadir_persona($peso_persona) {
        $this->peso += $peso_persona + 2;
    }

    // Accesores para cilindrada
    public function setCilindrada($cil) {
        $this->cilindrada = $cil;
    }

    public function getCilindrada() {
        return $this->cilindrada;
    }
}
?>

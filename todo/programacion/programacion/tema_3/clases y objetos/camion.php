<?php
require_once "cuatro_ruedas.php";

class Camion extends Cuatro_ruedas {
    protected $longitud = 0;

    public function añadir_remolque($longitud_remolque) {
        $this->longitud += $longitud_remolque;
    }

    public function setLongitud($l) {
        $this->longitud = $l;
    }

    public function getLongitud() {
        return $this->longitud;
    }
}
?>

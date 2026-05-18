<?php
/*
    Clase Coche – hereda Cuatro_ruedas
*/

require_once "cuatro_ruedas.php";

class Coche extends Cuatro_ruedas {

    public function añadir_persona($peso_persona) {
        parent::añadir_persona($peso_persona);

        if ($this->peso >= 1500 && $this->numero_cadenas_nieve <= 2) {
            echo "Atención, ponga 4 cadenas para la nieve.<br>";
        }
    }
}
?>

<?php
/*
    EJERCICIO 2 – Práctica 4

    Crear las cinco clases del esquema teniendo en cuenta la herencia.
    Todos los métodos son públicos y los atributos privados.
*/

class Vehiculo {
    private $color;
    private $peso;

    public function circula() {
        echo "El vehículo circula<br>";
    }
}

class Dos_ruedas extends Vehiculo {
    private $cilindrada;
}

class Cuatro_ruedas extends Vehiculo {
    private $numero_puertas;
}

class Coche extends Cuatro_ruedas { }

class Camion extends Cuatro_ruedas {
    private $longitud;
}
?>

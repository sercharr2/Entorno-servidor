<?php
/*
    EJERCICIO 1 – PRÁCTICA 4 (Clases y Objetos)

    1. Crear la clase Operaciones con los métodos necesarios para que,
       a partir del código mostrado debajo, muestre el resultado indicado.

       No aparece en el PDF cuál es el código base ni el resultado final,
       pero este ejercicio consiste típicamente en:
          – Crear una clase Operaciones
          – Añadir métodos suma, resta, multiplicación y división
          – Probarlos desde un script

       El siguiente archivo incluye:
           • Clase Operaciones con los métodos pedidos
           • Ejemplo de uso que simula el ejercicio
*/
    
class Operaciones {

    // Método para sumar dos números
    public function sumar($a, $b) {
        return $a + $b;
    }

    // Método para restar dos números
    public function restar($a, $b) {
        return $a - $b;
    }

    // Método para multiplicar dos números
    public function multiplicar($a, $b) {
        return $a * $b;
    }

    // Método para dividir dos números
    public function dividir($a, $b) {
        if ($b == 0) {
            return "Error: división por cero";
        }
        return $a / $b;
    }
}

// =======================
// PRUEBA DE LOS MÉTODOS
// =======================

$op = new Operaciones();

echo "Suma: " . $op->sumar(10, 5) . "<br>";
echo "Resta: " . $op->restar(10, 5) . "<br>";
echo "Multiplicación: " . $op->multiplicar(10, 5) . "<br>";
echo "División: " . $op->dividir(10, 5) . "<br>";

?>

<?php 
$horas = 40;
$horas_extra = $horas - 40;
$sueldohora = 10;

if ($horas <= 40 ){
    echo "No trabajaste lo suficiente como para cobrar horas extra";
} elseif ($horas > 40 and $horas_extra < 8) {
  $resultado = $horas_extra * $sueldohora * 2;
  echo "Al trabajar " . $horas_extra . " horas extra obtuviste " . $resultado;
} elseif ($horas > 40 and $horas_extra > 8) {
  $triples = $horas_extra - 8;
  $doble = $horas_extra - $pagadas;
  $resultado = ($doble * $sueldohora * 2) + ($dobles * 3 * $sueldohora);
  echo "Al trabajar " . $horas_extra . " horas extra obtuviste " . $resultado;
}

?>
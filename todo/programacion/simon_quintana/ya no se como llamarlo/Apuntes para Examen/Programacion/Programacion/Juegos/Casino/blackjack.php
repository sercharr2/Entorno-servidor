<?php
session_start();

function carta() { return rand(1, 11); }
function suma($mano) { return array_sum($mano); }

// Inicializar partida
if (!isset($_SESSION['jugador'])) {
    $_SESSION['jugador'] = [carta(), carta()];
    $_SESSION['banca'] = [carta()];
    $_SESSION['fin'] = false;
}

$jugador = $_SESSION['jugador'];
$banca = $_SESSION['banca'];
$fin = $_SESSION['fin'];

// Acciones
if (isset($_POST['accion']) && !$fin) {
    if ($_POST['accion'] === 'pedir') {
        $jugador[] = carta();
        if (suma($jugador) > 21) $fin = true;
    } elseif ($_POST['accion'] === 'plantarse') {
        while (suma($banca) < 17) {
            $banca[] = carta();
        }
        $fin = true;
    }
    $_SESSION['jugador'] = $jugador;
    $_SESSION['banca'] = $banca;
    $_SESSION['fin'] = $fin;
}

// Resolución
$resultado = '';
if ($fin) {
    $sj = suma($jugador);
    $sb = suma($banca);
    if ($sj > 21) {
        $resultado = 'Te pasaste de 21. Pierdes.';
    } elseif ($sb > 21) {
        $resultado = 'La banca se pasó de 21. ¡Ganas!';
    } elseif ($sj > $sb) {
        $resultado = 'Tu suma es mayor que la banca. ¡Ganas!';
    } elseif ($sj < $sb) {
        $resultado = 'Tu suma es menor que la banca. Pierdes.';
    } else {
        $resultado = 'Empate.';
    }
}

// Vista
echo '<h1>Blackjack simplificado</h1>';
echo '<p>Jugador: ['.implode(', ', $jugador).'] = '.suma($jugador).'</p>';
echo '<p>Banca: ['.implode(', ', $banca).'] = '.suma($banca).'</p>';

if (!$fin) {
    echo '<form method="post" action="blackjack.php">
            <button type="submit" name="accion" value="pedir">Pedir</button>
            <button type="submit" name="accion" value="plantarse">Plantarse</button>
          </form>';
} else {
    echo '<h2>'.$resultado.'</h2>';
    echo '<form method="post" action="reset_blackjack.php"><button>Reiniciar partida</button></form>';
}

<?php
session_start();

if (empty($_SESSION['palabra_secreta'])) {
    header('Location: ahorcado.php');
    exit;
}

$palabra_secreta = $_SESSION['palabra_secreta'];
$nletras         = $_SESSION['nletras'];
$pista           = $_SESSION['pista'] ?? '';

// Inicializar estado si es la primera vez
if (!isset($_SESSION['barras'])) {
    $_SESSION['barras']         = array_fill(0, $nletras, '_');
    $_SESSION['intentos']       = 6;
    $_SESSION['letrasFalladas'] = [];
}

$barras         = $_SESSION['barras'];
$intentos       = $_SESSION['intentos'];
$letrasFalladas = $_SESSION['letrasFalladas'];

// Procesar letra enviada
$mensaje = '';
if (isset($_POST['mandar_letra'])) {
    $letra = strtoupper(trim($_POST['letra'] ?? ''));

    if (!preg_match('/^[A-ZÑ]$/', $letra)) {
        $mensaje = 'Introduce una sola letra válida.';
    } elseif (in_array($letra, $letrasFalladas) || in_array($letra, $barras)) {
        $mensaje = 'Ya usaste esa letra.';
    } else {
        $acierto = false;
        for ($i = 0; $i < $nletras; $i++) {
            if ($palabra_secreta[$i] === $letra) {
                $barras[$i] = $letra;
                $acierto = true;
            }
        }
        if (!$acierto) {
            $letrasFalladas[] = $letra;
            $intentos--;
        }
        $_SESSION['barras']         = $barras;
        $_SESSION['intentos']       = $intentos;
        $_SESSION['letrasFalladas'] = $letrasFalladas;
    }
}

$fallos          = count($letrasFalladas);
$palabra_completa = ($barras === $palabra_secreta);
$perdido          = ($intentos <= 0);

// Partes del ahorcado: cabeza, cuerpo, brazo_izq, brazo_der, pierna_izq, pierna_der
$partes = [
    '<circle class="st-body" cx="140" cy="62" r="20"/>',
    '<line class="st-body" x1="140" y1="82" x2="140" y2="148"/>',
    '<line class="st-body" x1="140" y1="102" x2="112" y2="128"/>',
    '<line class="st-body" x1="140" y1="102" x2="168" y2="128"/>',
    '<line class="st-body" x1="140" y1="148" x2="112" y2="190"/>',
    '<line class="st-body" x1="140" y1="148" x2="168" y2="190"/>',
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ahorcado con IA</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            min-height: 100vh;
            display: flex; align-items: center; justify-content: center;
            background: #0f0f11;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            color: #e5e5e7;
        }
        .card {
            background: #1c1c1e;
            border-radius: 28px;
            box-shadow: 0 0 0 1px rgba(255,255,255,.08), 0 32px 80px rgba(0,0,0,.8);
            width: 100%;
            max-width: 680px;
            overflow: hidden;
        }

        /* ── TABLERO ── */
        .board { display: flex; }

        .gallows-side {
            flex: 0 0 200px;
            background: #111113;
            display: flex; align-items: center; justify-content: center;
            padding: 28px 16px;
        }
        .hangman-svg { width: 100%; max-width: 180px; }
        .hangman-svg line,
        .hangman-svg circle { fill: none; stroke-linecap: round; stroke-linejoin: round; }
        .st-gallows { stroke: #48484a; stroke-width: 5; }
        .st-rope    { stroke: #636366; stroke-width: 3; }
        .st-body    { stroke: #e5e5e7; stroke-width: 4; }

        .play-side {
            flex: 1; min-width: 0;
            padding: 28px 24px 32px;
            display: flex; flex-direction: column; gap: 16px;
        }

        .badge {
            display: inline-flex; align-items: center; gap: 6px;
            font-size: 11px; font-weight: 700; letter-spacing: 1.5px;
            text-transform: uppercase; color: #bf5af2;
            background: rgba(191,90,242,.12);
            border: 1px solid rgba(191,90,242,.3);
            border-radius: 8px; padding: 4px 10px; width: fit-content;
        }

        .pista-box {
            font-size: 13px; color: #bf5af2;
            background: rgba(191,90,242,.08);
            border: 1px solid rgba(191,90,242,.2);
            border-radius: 8px; padding: 7px 12px;
        }
        .pista-box strong { font-weight: 700; }

        .intentos-row { display: flex; align-items: baseline; gap: 6px; }
        .intentos-label { font-size: 13px; color: #636366; }
        .intentos-num   { font-size: 26px; font-weight: 600; color: #bf5af2; }
        .intentos-de    { font-size: 13px; color: #48484a; }

        .word-display { display: flex; flex-wrap: wrap; gap: 7px; }
        .lbox {
            width: 36px; height: 46px; border-radius: 8px;
            background: #2c2c2e; border: 1px solid #3a3a3c;
            display: flex; align-items: center; justify-content: center;
            font-size: 20px; font-weight: 700;
        }
        .lbox.found  { color: #30d158; }
        .lbox.hidden { color: transparent; }
        .lbox.missed { color: #ff453a; background: rgba(255,69,58,.1); border-color: #ff453a; }

        .section-label {
            font-size: 11px; font-weight: 600; letter-spacing: 1.5px;
            text-transform: uppercase; color: #48484a; margin-bottom: 6px;
        }
        .wrong-letters { display: flex; flex-wrap: wrap; gap: 6px; min-height: 34px; }
        .wletter {
            width: 34px; height: 34px; border-radius: 7px;
            background: rgba(255,69,58,.15); border: 1px solid #ff453a;
            display: flex; align-items: center; justify-content: center;
            font-size: 15px; font-weight: 700; color: #ff453a;
        }

        .letter-form { display: flex; gap: 10px; align-items: center; }
        .letter-input {
            width: 54px; height: 54px;
            background: #2c2c2e; border: 2px solid #3a3a3c; border-radius: 12px;
            color: #fff; font-size: 26px; font-weight: 700;
            text-align: center; text-transform: uppercase; outline: none;
        }
        .letter-input:focus { border-color: #bf5af2; }
        .btn-send {
            height: 54px; padding: 0 22px;
            background: #bf5af2; color: #fff;
            border: none; border-radius: 12px;
            font-size: 16px; font-weight: 600; cursor: pointer;
        }
        .btn-send:active { filter: brightness(1.2); }

        .msg { font-size: 13px; color: #ff9f0a; }

        /* ── FIN ── */
        .end-screen {
            padding: 52px 40px;
            display: flex; flex-direction: column; align-items: center;
            gap: 24px; text-align: center;
        }
        .end-title { font-size: 52px; font-weight: 800; letter-spacing: -2px; }
        .win  .end-title { color: #30d158; }
        .lose .end-title { color: #ff453a; }

        .word-reveal { display: flex; flex-wrap: wrap; gap: 7px; justify-content: center; }
        .end-sub { font-size: 14px; color: #636366; }
        .end-sub strong { color: #e5e5e7; }

        .btn-restart {
            height: 52px; padding: 0 44px;
            background: linear-gradient(135deg, #bf5af2, #5e5ce6);
            color: #fff; border: none; border-radius: 26px;
            font-size: 17px; font-weight: 600; cursor: pointer;
        }
        .btn-restart:active { filter: brightness(1.15); }
    </style>
</head>
<body>
<div class="card">

<?php if ($palabra_completa): ?>
    <!-- VICTORIA -->
    <div class="end-screen win">
        <div class="end-title">¡GANASTE!</div>
        <div class="word-reveal">
            <?php foreach ($barras as $l): ?>
                <div class="lbox found"><?= htmlspecialchars($l) ?></div>
            <?php endforeach; ?>
        </div>
        <p class="end-sub">Adivinaste la palabra con
            <strong><?= $fallos ?> <?= $fallos === 1 ? 'fallo' : 'fallos' ?></strong>.
        </p>
        <form method="get" action="ahorcado.php">
            <button class="btn-restart">Nueva palabra</button>
        </form>
    </div>

<?php elseif ($perdido): ?>
    <!-- DERROTA -->
    <div class="end-screen lose">
        <div class="end-title">¡PERDISTE!</div>
        <div class="word-reveal">
            <?php foreach ($palabra_secreta as $i => $l): ?>
                <div class="lbox <?= ($barras[$i] === $l) ? 'found' : 'missed' ?>">
                    <?= htmlspecialchars($l) ?>
                </div>
            <?php endforeach; ?>
        </div>
        <p class="end-sub">La palabra era: <strong><?= implode('', $palabra_secreta) ?></strong></p>
        <form method="get" action="ahorcado.php">
            <button class="btn-restart">Nueva palabra</button>
        </form>
    </div>

<?php else: ?>
    <!-- JUEGO -->
    <div class="board">
        <div class="gallows-side">
            <svg class="hangman-svg" viewBox="0 0 200 250" xmlns="http://www.w3.org/2000/svg">
                <line class="st-gallows" x1="5"   y1="240" x2="195" y2="240"/>
                <line class="st-gallows" x1="50"  y1="240" x2="50"  y2="15"/>
                <line class="st-gallows" x1="50"  y1="15"  x2="140" y2="15"/>
                <line class="st-rope"    x1="140" y1="15"  x2="140" y2="42"/>
                <?php for ($p = 0; $p < $fallos; $p++) echo $partes[$p]; ?>
            </svg>
        </div>

        <div class="play-side">
            <span class="badge">✦ Gemini AI</span>

            <?php if ($pista): ?>
            <div class="pista-box"><strong>Pista:</strong> <?= htmlspecialchars($pista) ?></div>
            <?php endif; ?>

            <div class="intentos-row">
                <span class="intentos-label">Intentos:</span>
                <span class="intentos-num"><?= $intentos ?></span>
                <span class="intentos-de">/ 6</span>
            </div>

            <div class="word-display">
                <?php foreach ($barras as $l): ?>
                    <div class="lbox <?= $l !== '_' ? 'found' : 'hidden' ?>">
                        <?= htmlspecialchars($l) ?>
                    </div>
                <?php endforeach; ?>
            </div>

            <div>
                <div class="section-label">Letras falladas</div>
                <div class="wrong-letters">
                    <?php foreach ($letrasFalladas as $l): ?>
                        <div class="wletter"><?= htmlspecialchars($l) ?></div>
                    <?php endforeach; ?>
                </div>
            </div>

            <?php if ($mensaje): ?>
                <p class="msg"><?= htmlspecialchars($mensaje) ?></p>
            <?php endif; ?>

            <form class="letter-form" method="post" action="jugar.php">
                <input class="letter-input" type="text" name="letra"
                       maxlength="1" placeholder="A" autocomplete="off" autofocus>
                <button class="btn-send" type="submit" name="mandar_letra">Enviar</button>
            </form>
        </div>
    </div>
<?php endif; ?>

</div>
</body>
</html>

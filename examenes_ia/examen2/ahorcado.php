<?php
session_start();
session_unset();

$apiKey = 'AIzaSyAsafAwAyTeZxVYTmsTMlCbJmRVUSbf0Dg';
$url    = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=' . $apiKey;

$prompt = 'Actua como un backend para un juego del ahorcado en español. '
        . 'Genera una palabra en español (sin espacios, sin tildes, solo letras A-Z) y una pista corta. '
        . 'Responde UNICAMENTE con JSON puro, sin texto adicional, sin bloques de codigo: '
        . '{"palabra": "...", "pista": "..."}';

$payload = json_encode([
    'contents' => [['parts' => [['text' => $prompt]]]],
]);

$ch = curl_init($url);
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST           => true,
    CURLOPT_POSTFIELDS     => $payload,
    CURLOPT_HTTPHEADER     => ['Content-Type: application/json'],
    CURLOPT_TIMEOUT        => 15,
    CURLOPT_SSL_VERIFYPEER => false,
]);
$raw = curl_exec($ch);

$palabra = null;
$pista   = null;
$error   = null;

if ($raw === false) {
    $error = 'No se pudo conectar con la IA de Gemini.';
} else {
    $data   = json_decode($raw, true);
    $text   = $data['candidates'][0]['content']['parts'][0]['text'] ?? null;
    if ($text) {
        $clean  = preg_replace('/^```(?:json)?\s*|\s*```$/m', '', trim($text));
        $result = json_decode($clean, true);
        if (is_array($result) && isset($result['palabra'], $result['pista'])) {
            $palabra = strtoupper(preg_replace('/[^A-Za-z]/', '', $result['palabra']));
            $pista   = $result['pista'];
        } else {
            $error = 'La IA devolvió una respuesta inesperada.';
        }
    } else {
        $error = $data['error']['message'] ?? 'Error desconocido de la API.';
    }
}

if ($palabra) {
    $_SESSION['palabra_secreta'] = str_split($palabra);
    $_SESSION['nletras']         = strlen($palabra);
    $_SESSION['pista']           = $pista;
}
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
            max-width: 480px;
            padding: 48px 40px 52px;
            display: flex; flex-direction: column; gap: 28px;
        }
        .badge {
            display: inline-flex; align-items: center; gap: 6px;
            font-size: 11px; font-weight: 700; letter-spacing: 1.5px;
            text-transform: uppercase; color: #bf5af2;
            background: rgba(191,90,242,.12);
            border: 1px solid rgba(191,90,242,.3);
            border-radius: 8px; padding: 4px 10px; width: fit-content;
        }
        h1 { font-size: 32px; font-weight: 800; letter-spacing: -1px; color: #e5e5e7; }
        .sub { font-size: 14px; color: #636366; line-height: 1.5; }

        .info-box {
            background: #2c2c2e; border-radius: 14px;
            padding: 18px 20px; display: flex; flex-direction: column; gap: 8px;
        }
        .info-row { display: flex; justify-content: space-between; align-items: center; }
        .info-label { font-size: 13px; color: #636366; }
        .info-val   { font-size: 14px; font-weight: 600; color: #e5e5e7; }
        .info-val.accent { color: #bf5af2; }

        .pista-box {
            background: rgba(191,90,242,.08);
            border: 1px solid rgba(191,90,242,.25);
            border-radius: 10px; padding: 12px 16px;
            font-size: 14px; color: #bf5af2; line-height: 1.5;
        }
        .pista-box strong { font-weight: 700; }

        .error-box {
            background: rgba(255,69,58,.08);
            border: 1px solid rgba(255,69,58,.3);
            border-radius: 10px; padding: 12px 16px;
            font-size: 14px; color: #ff453a; line-height: 1.5;
        }

        .btn {
            height: 52px; width: 100%;
            background: #bf5af2; color: #fff;
            border: none; border-radius: 14px;
            font-size: 16px; font-weight: 600; cursor: pointer;
            transition: filter .12s;
        }
        .btn:hover  { filter: brightness(1.1); }
        .btn:active { filter: brightness(1.2); }
        .btn:disabled { opacity: .4; cursor: default; filter: none; }

        .btn-secondary {
            height: 48px; width: 100%;
            background: #2c2c2e; color: #bf5af2;
            border: 1.5px solid rgba(191,90,242,.4);
            border-radius: 14px;
            font-size: 15px; font-weight: 600; cursor: pointer;
            transition: filter .12s;
        }
        .btn-secondary:hover { filter: brightness(1.1); }
    </style>
</head>
<body>
<div class="card">
    <div>
        <span class="badge">✦ Gemini AI</span>
        <h1 style="margin-top:12px">Ahorcado con IA</h1>
        <p class="sub" style="margin-top:8px">Gemini ha generado una palabra secreta. Tienes 6 intentos para adivinarla.</p>
    </div>

    <?php if ($error): ?>
        <div class="error-box"><?= htmlspecialchars($error) ?></div>
        <form method="get" action="ahorcado.php">
            <button class="btn-secondary">Reintentar</button>
        </form>
    <?php else: ?>
        <div class="info-box">
            <div class="info-row">
                <span class="info-label">Letras en la palabra</span>
                <span class="info-val accent"><?= strlen($palabra) ?></span>
            </div>
            <div class="info-row">
                <span class="info-label">Intentos disponibles</span>
                <span class="info-val">6</span>
            </div>
        </div>

        <div class="pista-box"><strong>Pista:</strong> <?= htmlspecialchars($pista) ?></div>

        <form method="post" action="jugar.php">
            <button class="btn">Empezar a jugar</button>
        </form>
    <?php endif; ?>
</div>
</body>
</html>

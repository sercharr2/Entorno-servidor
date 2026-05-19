<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<title>Juegos Laravel</title>
<style>
    body { font-family: sans-serif; max-width: 600px; margin: 2em auto; padding: 0 1em; }
    ul   { list-style: none; padding: 0; }
    li   { margin: 0.5em 0; }
    a    { display: block; padding: 0.6em 1em; background: #eee; text-decoration: none;
           color: #222; border-radius: 4px; }
    a:hover { background: #ddd; }
</style>
</head>
<body>
<h1>Juegos Laravel</h1>
<ul>
    <li><a href="{{ route('blackjack.jugar') }}">1. Blackjack / 21</a></li>
    <li><a href="{{ route('adivina.jugar') }}">2. Adivina el número (1-100)</a></li>
    <li><a href="{{ route('carrera.jugar') }}">3. Carrera de caballos</a></li>
    <li><a href="{{ route('yatzy.jugar') }}">4. Yatzy / póker de dados</a></li>
    <li><a href="{{ route('wordle.jugar') }}">5. Wordle</a></li>
    <li><a href="{{ route('mastermind.jugar') }}">6. Mastermind</a></li>
    <li><a href="{{ route('tres.jugar') }}">7. Tres en raya vs IA</a></li>
</ul>
</body>
</html>

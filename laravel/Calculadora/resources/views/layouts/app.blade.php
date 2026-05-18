<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>@yield('title', 'Juegos') — Laravel</title>
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            background: #000;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            font-family: -apple-system, BlinkMacSystemFont, 'SF Pro Display', 'Segoe UI', Helvetica, sans-serif;
        }


        .app-nav {
            position: sticky;
            top: 0;
            z-index: 100;
            background: rgba(28, 28, 30, 0.92);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, .07);
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 4px;
            padding: 10px 20px;
        }

        .nav-link {
            padding: 8px 20px;
            border-radius: 20px;
            color: #636366;
            text-decoration: none;
            font-size: 15px;
            font-weight: 500;
            white-space: nowrap;
            transition: background .12s, color .12s;
        }
        .nav-link:hover  { background: #2c2c2e; color: #e5e5e7; }
        .nav-link.active { background: #2c2c2e; color: #fff; font-weight: 600; }

        /* ── ÁREA DE CONTENIDO ── */
        .app-main {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 28px 16px;
        }
    </style>

    @yield('styles')
</head>
<body>

<nav class="app-nav">
    @php
        /**
         * Para añadir una nueva página, basta con añadir una entrada aquí:
         *   ['label' => 'Nombre', 'route' => 'nombre.ruta', 'match' => 'nombre.*'],
         */
        $navItems = [
            ['label' => 'Calculadora', 'route' => 'calculadora.calculadora', 'match' => 'calculadora.*'],
            ['label' => 'Sube-Baja',   'route' => 'sube-baja.subeBaja',      'match' => 'sube-baja.*'],
            ['label' => 'Ahorcado',    'route' => 'ahorcado.ahorcado',       'match' => 'ahorcado.*'],
            ['label' => 'Ahorcado IA',  'route' => 'ahorcado-ia.index',       'match' => 'ahorcado-ia.*'],
            ['label' => 'Hermeto',      'route' => 'hermeto.index',           'match' => 'hermeto.*'],
        ];
    @endphp

    @foreach ($navItems as $item)
        <a href="{{ route($item['route']) }}"
           class="nav-link {{ request()->routeIs($item['match']) ? 'active' : '' }}">
            {{ $item['label'] }}
        </a>
    @endforeach
</nav>

<main class="app-main">
    @yield('content')
</main>

</body>
</html>

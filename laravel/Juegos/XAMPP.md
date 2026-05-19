# Servir el proyecto solo con XAMPP (Apache + MySQL)

Servimos `Juegos/public/` directamente con un **Alias** de Apache.
No hace falta tocar `htdocs/`, ni juctions, ni `php artisan serve`.

## 1. Arrancar XAMPP

Inicia **Apache** y **MySQL** desde el panel de XAMPP.

## 2. Crear la base de datos

En `http://localhost/phpmyadmin` → "Nueva" → nombre `juegos`,
cotejamiento `utf8mb4_unicode_ci`.

(El `.env` ya apunta a `juegos` / `root` / sin password.)

## 3. Configurar el Alias en Apache

Edita `C:\xampp\apache\conf\httpd.conf` y añade **al final** del archivo:

```apache
Alias /juegos "E:/programacion/php/laravel/Posibles examenes Laravel/Juegos/public"

<Directory "E:/programacion/php/laravel/Posibles examenes Laravel/Juegos/public">
    Options Indexes FollowSymLinks
    AllowOverride All
    Require all granted
</Directory>
```

Importante: usa barras `/` en las rutas (Apache lo prefiere), aunque la
ruta sea de Windows.

Comprueba que en el mismo `httpd.conf` esté **activado** mod_rewrite
(busca y descomenta esta línea quitando el `#` del principio si lo tiene):

```apache
LoadModule rewrite_module modules/mod_rewrite.so
```

Guarda y **reinicia Apache** desde el panel de XAMPP.

## 4. Aplicar migraciones

Una sola vez, desde la carpeta del proyecto:

```cmd
cd /d "E:\programacion\php\laravel\Posibles examenes Laravel\Juegos"
C:\xampp\php\php.exe artisan migrate:fresh
```

## 5. Abrir el proyecto

```
http://localhost/juegos/
```

Cómo funciona internamente:

1. Apache recibe `/juegos/loquesea`.
2. El **Alias** lo manda físicamente a `Juegos/public/loquesea`.
3. El `.htaccess` de `public/` reenvía todo a `index.php`.
4. Laravel ve `REQUEST_URI=/juegos/...` y, como `APP_URL=http://localhost/juegos`,
   detecta el prefijo y enruta correctamente.

## Solución de problemas

- **"URL no encontrada"**: lo más típico es que falte el bloque `Alias`
  en `httpd.conf` o que no se haya reiniciado Apache después de editarlo.
- **500 / "AH00526"**: revisa que `AllowOverride All` esté presente en el
  `<Directory>` del Alias; sin eso Apache no aplica el `.htaccess`.
- **Página en blanco**: mira `storage/logs/laravel.log`, suele ser un
  fallo de BD (servicio MySQL apagado o base `juegos` no creada).
- **CSS / cartas se ven mal**: Ctrl+F5 para refrescar caché.
- **Reset de saldo Blackjack**: borra la fila en `partidas` desde
  phpMyAdmin o vuelve a hacer `php artisan migrate:fresh`.

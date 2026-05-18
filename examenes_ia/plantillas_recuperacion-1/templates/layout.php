<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Application</title>
    <link rel="stylesheet" href="/public/css/styles.css">
</head>
<body>
    <header>
        <h1>Welcome to My Application</h1>
        <nav>
            <ul>
                <li><a href="/">Home</a></li>
                <!-- Add more navigation links here -->
            </ul>
        </nav>
    </header>
    <main>
        <?php echo $content; ?>
    </main>
    <footer>
        <p>&copy; <?php echo date("Y"); ?> My Application. All rights reserved.</p>
    </footer>
</body>
</html>
# Plantillas Recuperacion

## Overview
This project is a simple PHP application designed to manage templates for recovery purposes. It follows the MVC (Model-View-Controller) architecture, providing a clear separation of concerns.

## Project Structure
```
plantillas_recuperacion
├── public
│   └── index.php
├── src
│   ├── Controller
│   │   └── HomeController.php
│   ├── Model
│   │   └── Template.php
│   ├── View
│   │   └── Renderer.php
│   └── Router.php
├── templates
│   ├── layout.php
│   └── home.php
├── config
│   └── config.php
├── tests
│   └── HomeControllerTest.php
├── composer.json
├── phpunit.xml
├── .env
└── README.md
```

## Installation
1. Clone the repository:
   ```
   git clone <repository-url>
   ```
2. Navigate to the project directory:
   ```
   cd plantillas_recuperacion
   ```
3. Install dependencies using Composer:
   ```
   composer install
   ```

## Configuration
- Copy the `.env.example` to `.env` and update the environment variables as needed.
- Configure your database settings in `config/config.php`.

## Usage
- Start the built-in PHP server:
   ```
   php -S localhost:8000 -t public
   ```
- Access the application in your web browser at `http://localhost:8000`.

## Testing
- Run tests using PHPUnit:
   ```
   ./vendor/bin/phpunit
   ```

## Contributing
Contributions are welcome! Please submit a pull request or open an issue for any enhancements or bug fixes.

## License
This project is licensed under the MIT License. See the LICENSE file for details.
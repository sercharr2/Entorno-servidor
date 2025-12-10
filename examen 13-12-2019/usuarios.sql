-- usuarios.sql
-- Crea la base de datos 'entrada', la tabla 'usuarios' e inserta 4 usuarios.
-- Además crea dos usuarios de base de datos con los permisos solicitados


-- 2) Crear la tabla 'usuarios'
DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `usuario` VARCHAR(50) NOT NULL,
  `contrasena` VARCHAR(100) NOT NULL,
  `nombre` VARCHAR(50) DEFAULT NULL,
  `apellidos` VARCHAR(100) DEFAULT NULL,
  `email` VARCHAR(100) DEFAULT NULL,
  `rol` ENUM('consultor','grabador') NOT NULL,
  PRIMARY KEY (`usuario`,`contrasena`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 3) Insertar los 4 usuarios pedidos
INSERT INTO `usuarios` (`usuario`,`contrasena`,`nombre`,`apellidos`,`email`,`rol`) VALUES
('Ana','Ana**','Ana','Lopez','aaa@gmail.com','consultor'),
('Maria','Maria**','Maria','Perez','bbb@gmail.com','grabador'),
('Carlos','Carlos**','Carlos','Fernandez','ccc@gmail.com','consultor'),
('Luis','Luis**','Luis','Suarez','ddd@gmail.com','grabador');

-- 4) Crear los dos usuarios de la base de datos y otorgar privilegios
-- Ajusta las contraseñas de conexión a lo que desees en tu entorno local.

-- Usuario consultor: solo puede leer la tabla 'usuarios'
CREATE USER IF NOT EXISTS 'consultor'@'localhost' IDENTIFIED BY 'consultor123';
GRANT SELECT ON `entrada`.`usuarios` TO 'consultor'@'localhost';

-- Usuario grabador: puede leer y escribir (INSERT) la tabla 'usuarios'
CREATE USER IF NOT EXISTS 'grabador'@'localhost' IDENTIFIED BY 'grabador123';
GRANT SELECT, INSERT ON `entrada`.`usuarios` TO 'grabador'@'localhost';

FLUSH PRIVILEGES;

-- NOTAS:
-- - Para probar localmente con XAMPP: importar este fichero desde phpMyAdmin o usar
--   mysql -u root -p < usuarios.sql
-- - Las contraseñas 'consultor123' y 'grabador123' son de ejemplo; cámbialas si lo deseas.
-- - El PRIMARY KEY compuesto (usuario, contrasena) sigue la especificación del enunciado.

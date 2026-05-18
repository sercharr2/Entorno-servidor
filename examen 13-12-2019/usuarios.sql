-- usuarios.sql
-- Base de datos: entrada
-- Tabla: usuarios
-- Usuarios BD: consultor (solo SELECT) y grabador (SELECT + INSERT)

-- 1) Crear y seleccionar la base de datos
CREATE DATABASE IF NOT EXISTS `entrada`
  DEFAULT CHARACTER SET utf8mb4;
USE `entrada`;

-- 2) Crear la tabla usuarios
DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `usuario`    VARCHAR(50)                    NOT NULL,
  `contrasena` VARCHAR(100)                   NOT NULL,
  `nombre`     VARCHAR(50)                    DEFAULT NULL,
  `apellidos`  VARCHAR(100)                   DEFAULT NULL,
  `email`      VARCHAR(100)                   DEFAULT NULL,
  `rol`        ENUM('consultor','grabador')   NOT NULL,
  PRIMARY KEY (`usuario`, `contrasena`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 3) Insertar los 4 usuarios del enunciado
INSERT INTO `usuarios` (`usuario`,`contrasena`,`nombre`,`apellidos`,`email`,`rol`) VALUES
('Ana',    'Ana**',    'Ana',    'Lopez',     'aaa@gmail.com', 'consultor'),
('Maria',  'Maria**',  'Maria',  'Perez',     'bbb@gmail.com', 'grabador'),
('Carlos', 'Carlos**', 'Carlos', 'Fernandez', 'ccc@gmail.com', 'consultor'),
('Luis',   'Luis**',   'Luis',   'Suárez',    'ddd@gmail.com', 'grabador');

-- 4) Crear los dos usuarios de base de datos con sus permisos

-- consultor: solo puede leer la tabla usuarios
DROP USER IF EXISTS 'consultor'@'localhost';
CREATE USER 'consultor'@'localhost' IDENTIFIED BY 'consultor123';
GRANT SELECT ON `entrada`.`usuarios` TO 'consultor'@'localhost';

-- grabador: puede leer y escribir (INSERT) la tabla usuarios
DROP USER IF EXISTS 'grabador'@'localhost';
CREATE USER 'grabador'@'localhost' IDENTIFIED BY 'grabador123';
GRANT SELECT, INSERT ON `entrada`.`usuarios` TO 'grabador'@'localhost';

FLUSH PRIVILEGES;

-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 07-06-2021 a las 08:56:30
-- Versión del servidor: 10.1.38-MariaDB
-- Versión de PHP: 7.3.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `oposicion`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumno`
--

CREATE TABLE `alumno` (
  `dniA` varchar(9) NOT NULL,
  `nombreA` varchar(20) DEFAULT NULL,
  `apellido1A` varchar(20) DEFAULT NULL,
  `apellido2A` varchar(20) DEFAULT NULL,
  `direccionA` varchar(30) DEFAULT NULL,
  `sexoA` varchar(1) DEFAULT NULL,
  `fechanacA` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `alumno`
--

INSERT INTO `alumno` (`dniA`, `nombreA`, `apellido1A`, `apellido2A`, `direccionA`, `sexoA`, `fechanacA`) VALUES
('1111', 'Carlos', 'Puerta', 'Perez', 'c/ P?, 21', 'V', '0000-00-00'),
('2222', 'Luisa', 'Sanchez', 'Donoso', 'c/ Sierpes, 1', 'M', '0000-00-00'),
('3333', 'Eva', 'Ramos', 'Prieto', 'c/ Rueda, 31', 'M', '0000-00-00'),
('4444', 'Luis', 'Paez', 'Garcia', 'c/ Martin Villa, 21', 'V', '0000-00-00'),
('5555', 'Ana', 'Padilla', 'Torres', 'c/ Tetuan, 2', 'M', '0000-00-00'),
('6666', 'Lola', 'Flores', 'Ruiz', 'c/ Real, 14', 'M', '0000-00-00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `curso`
--

CREATE TABLE `curso` (
  `codigocurso` varchar(5) NOT NULL,
  `nombrecurso` varchar(40) DEFAULT NULL,
  `maxalumnos` int(4) DEFAULT NULL,
  `fechaini` date DEFAULT NULL,
  `fechafin` date DEFAULT NULL,
  `numhoras` int(4) DEFAULT NULL,
  `profesor` varchar(9) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `curso`
--

INSERT INTO `curso` (`codigocurso`, `nombrecurso`, `maxalumnos`, `fechaini`, `fechafin`, `numhoras`, `profesor`) VALUES
('0001', 'Función Publica', 120, '2003-05-09', '2030-06-09', 400, '444'),
('0002', 'Los chiquillos', 180, '2013-05-09', '2030-08-09', 600, '222'),
('0003', 'Puentes Atirantados', 20, '2003-12-08', '2030-06-09', 800, '111'),
('0004', 'Vida familiar de los presos', 120, '2003-05-09', '2030-06-09', 400, '222'),
('0005', 'La Constitucion', 230, '2003-05-09', '2030-06-09', 100, '444'),
('0006', 'Programación Visual para todos', 80, '2003-09-09', '2030-09-09', 30, '555');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cursomanual`
--

CREATE TABLE `cursomanual` (
  `codcurso` varchar(5) NOT NULL,
  `referencia` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cursomanual`
--

INSERT INTO `cursomanual` (`codcurso`, `referencia`) VALUES
('0001', 'M001'),
('0001', 'M004'),
('0003', 'M005'),
('0004', 'M001'),
('0004', 'M003'),
('0005', 'M001'),
('0005', 'M004'),
('0006', 'M002'),
('0006', 'M006');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cursooposicion`
--

CREATE TABLE `cursooposicion` (
  `codcurso` varchar(5) NOT NULL,
  `codoposicion` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cursooposicion`
--

INSERT INTO `cursooposicion` (`codcurso`, `codoposicion`) VALUES
('0001', 'C-502'),
('0001', 'C-512'),
('0001', 'C-522'),
('0001', 'C-532'),
('0001', 'C-542'),
('0001', 'C-552'),
('0002', 'C-502'),
('0003', 'C-552'),
('0004', 'C-512'),
('0005', 'C-502'),
('0005', 'C-512'),
('0005', 'C-522'),
('0005', 'C-532'),
('0005', 'C-542'),
('0006', 'C-522');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `manual`
--

CREATE TABLE `manual` (
  `referencia` varchar(6) NOT NULL,
  `titulo` varchar(40) DEFAULT NULL,
  `autor` varchar(30) DEFAULT NULL,
  `fechapub` date DEFAULT NULL,
  `precio` int(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `manual`
--

INSERT INTO `manual` (`referencia`, `titulo`, `autor`, `fechapub`, `precio`) VALUES
('M001', 'El Derecho', 'Garzón', '2012-05-06', 23),
('M002', 'C y PHP: lo mismo es', 'Joseph Sunday', '2012-09-07', 12),
('M003', 'Los delincuentes y sus sentimientos', 'El Chori', '2012-07-08', 16),
('M004', 'Las Administraciones Publicas', 'Ruiz', '2012-07-07', 8),
('M005', 'Estatica y Dinamica', 'Calatrava', '2002-05-05', 43),
('M006', 'Problemas irresolubles en JSP', 'John Tagua', '2007-07-07', 25);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `matricula`
--

CREATE TABLE `matricula` (
  `dnialumno` varchar(9) NOT NULL,
  `codcurso` varchar(5) NOT NULL,
  `pruebaA` int(2) DEFAULT NULL,
  `pruebaB` int(2) DEFAULT NULL,
  `tipo` varchar(7) DEFAULT NULL,
  `inscripcion` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `matricula`
--

INSERT INTO `matricula` (`dnialumno`, `codcurso`, `pruebaA`, `pruebaB`, `tipo`, `inscripcion`) VALUES
('1111', '0001', 12, 8, 'Oficial', '2012-06-06'),
('1111', '0005', 18, 5, 'Oficial', '2012-07-06'),
('2222', '0003', 25, 28, 'Libre', '2012-08-06'),
('2222', '0005', 32, 28, 'Libre', '2012-09-06'),
('3333', '0006', 12, 15, 'Oficial', '2012-10-06'),
('4444', '0006', 18, 35, 'Oficial', '2012-11-06'),
('5555', '0001', 11, 38, 'Oficial', '2012-03-07'),
('5555', '0002', 32, 38, 'Libre', '2012-01-07'),
('5555', '0003', 11, 18, 'Oficial', '2012-02-07'),
('5555', '0005', 42, 48, 'Oficial', '2012-04-07'),
('5555', '0006', 20, 48, 'Oficial', '2012-12-06');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `oposicion`
--

CREATE TABLE `oposicion` (
  `codigo` varchar(6) NOT NULL,
  `nombre` varchar(40) DEFAULT NULL,
  `fechaexamen` date DEFAULT NULL,
  `organismo` varchar(30) DEFAULT NULL,
  `plazas` int(4) DEFAULT NULL,
  `categoria` varchar(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `oposicion`
--

INSERT INTO `oposicion` (`codigo`, `nombre`, `fechaexamen`, `organismo`, `plazas`, `categoria`) VALUES
('C-502', 'Maestros de Primaria', '2027-05-10', 'Consejeria Educacion', 1220, 'B'),
('C-512', 'Funcionario de Prisiones', '2020-06-10', 'Consejeria Justicia', 120, 'C'),
('C-522', 'Profesores de Informática', '2027-06-09', 'Consejeria Educacion', 12, 'A'),
('C-532', 'Jardineros del Estado', '2027-05-10', 'Ministerio Medio Ambiente', 10, 'D'),
('C-542', 'Administrativos', '2027-05-10', 'Ayuntamiento DH', 12, 'C'),
('C-552', 'Ingenieros del Ejercito', '2027-09-10', 'Ministerio Defensa', 120, 'A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesor`
--

CREATE TABLE `profesor` (
  `dniP` varchar(9) NOT NULL,
  `nombreP` varchar(20) DEFAULT NULL,
  `apellido1P` varchar(20) DEFAULT NULL,
  `apellido2P` varchar(20) DEFAULT NULL,
  `direccionP` varchar(30) DEFAULT NULL,
  `tituloP` varchar(30) DEFAULT NULL,
  `sueldoP` int(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `profesor`
--

INSERT INTO `profesor` (`dniP`, `nombreP`, `apellido1P`, `apellido2P`, `direccionP`, `tituloP`, `sueldoP`) VALUES
('111', 'Manuel', 'Lopez', 'Garcia', 'c/ Albeniz,12', 'Ingeniero de Caminos', 2000),
('222', 'Luis', 'Perez', 'Sanchez', 'c/ Huelva, 1', 'Licenciado en Psicologia', 1400),
('333', 'Ana', 'Garcia', 'Lopez', 'c/ Sevilla,2', 'Ingeniero de Caminos', 2200),
('444', 'Eva', 'Parra', 'Ruiz', 'c/ Astoria,7', 'Licenciado en Derecho', 1200),
('555', 'Federico', 'Flores', 'Alba', 'c/ Tarifa, 1', 'Ingeniero Inform?tico', 2500),
('666', 'Alberto', 'Moreno', 'Rodriguez', 'c/ Parra, 2', 'Ingeniero de Caminos', 2100);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alumno`
--
ALTER TABLE `alumno`
  ADD PRIMARY KEY (`dniA`);

--
-- Indices de la tabla `curso`
--
ALTER TABLE `curso`
  ADD PRIMARY KEY (`codigocurso`),
  ADD KEY `CUP_FK` (`profesor`);

--
-- Indices de la tabla `cursomanual`
--
ALTER TABLE `cursomanual`
  ADD PRIMARY KEY (`codcurso`,`referencia`),
  ADD KEY `CUM1_FK` (`referencia`);

--
-- Indices de la tabla `cursooposicion`
--
ALTER TABLE `cursooposicion`
  ADD PRIMARY KEY (`codcurso`,`codoposicion`),
  ADD KEY `COP2_FK` (`codoposicion`);

--
-- Indices de la tabla `manual`
--
ALTER TABLE `manual`
  ADD PRIMARY KEY (`referencia`);

--
-- Indices de la tabla `matricula`
--
ALTER TABLE `matricula`
  ADD PRIMARY KEY (`dnialumno`,`codcurso`),
  ADD KEY `MAC1_FK` (`codcurso`);

--
-- Indices de la tabla `oposicion`
--
ALTER TABLE `oposicion`
  ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `profesor`
--
ALTER TABLE `profesor`
  ADD PRIMARY KEY (`dniP`);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `curso`
--
ALTER TABLE `curso`
  ADD CONSTRAINT `CUP_FK` FOREIGN KEY (`profesor`) REFERENCES `profesor` (`dniP`) ON DELETE CASCADE;

--
-- Filtros para la tabla `cursomanual`
--
ALTER TABLE `cursomanual`
  ADD CONSTRAINT `CUC2_FK` FOREIGN KEY (`codcurso`) REFERENCES `curso` (`codigocurso`) ON DELETE CASCADE,
  ADD CONSTRAINT `CUM1_FK` FOREIGN KEY (`referencia`) REFERENCES `manual` (`referencia`) ON DELETE CASCADE;

--
-- Filtros para la tabla `cursooposicion`
--
ALTER TABLE `cursooposicion`
  ADD CONSTRAINT `COP1_FK` FOREIGN KEY (`codcurso`) REFERENCES `curso` (`codigocurso`) ON DELETE CASCADE,
  ADD CONSTRAINT `COP2_FK` FOREIGN KEY (`codoposicion`) REFERENCES `oposicion` (`codigo`) ON DELETE CASCADE;

--
-- Filtros para la tabla `matricula`
--
ALTER TABLE `matricula`
  ADD CONSTRAINT `MAA2_FK` FOREIGN KEY (`dnialumno`) REFERENCES `alumno` (`dniA`) ON DELETE CASCADE,
  ADD CONSTRAINT `MAC1_FK` FOREIGN KEY (`codcurso`) REFERENCES `curso` (`codigocurso`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
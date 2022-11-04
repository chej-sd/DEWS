-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 04-11-2022 a las 09:50:48
-- Versión del servidor: 5.7.36
-- Versión de PHP: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `ej_subastas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

DROP TABLE IF EXISTS `categorias`;
CREATE TABLE IF NOT EXISTS `categorias` (
  `id` int(11) NOT NULL,
  `categoria` varchar(30) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `index_categoria` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabla de categorias';

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `categoria`) VALUES
(1, 'flores'),
(2, 'pajaros'),
(3, 'muebles'),
(4, 'casas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagenes`
--

DROP TABLE IF EXISTS `imagenes`;
CREATE TABLE IF NOT EXISTS `imagenes` (
  `id` int(11) NOT NULL,
  `id_item` int(11) NOT NULL,
  `imagen` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_IMAGENES_ITEMS` (`id_item`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Imagenes';

--
-- Volcado de datos para la tabla `imagenes`
--

INSERT INTO `imagenes` (`id`, `id_item`, `imagen`) VALUES
(1, 2, 'imagen paloma'),
(2, 1, 'cactus3'),
(3, 1, 'cactus'),
(4, 1, 'cactus2');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `items`
--

DROP TABLE IF EXISTS `items`;
CREATE TABLE IF NOT EXISTS `items` (
  `id` int(11) NOT NULL,
  `id_cat` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `preciopartida` float NOT NULL,
  `descripcion` varchar(200) NOT NULL,
  `fechafin` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_ITEMS_CATEGORIA` (`id_cat`),
  KEY `FK_ITEMS_USUARIOS` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `items`
--

INSERT INTO `items` (`id`, `id_cat`, `id_user`, `nombre`, `preciopartida`, `descripcion`, `fechafin`) VALUES
(1, 1, 1, 'cactus', 12, 'flores de cactus', '2022-10-19 00:00:00'),
(2, 2, 2, 'paloma', 15, 'paloma blanca', '2022-10-19 00:00:00'),
(3, 3, 1, 'cama', 1200, 'mueble de habitcion', '2022-10-19 00:00:00'),
(4, 3, 2, 'comoda', 2000, 'mueble de salon', '2022-10-19 00:00:00'),
(5, 4, 1, 'bungalow', 120000, 'casas de campo', '2022-10-19 00:00:00'),
(6, 4, 2, 'cabaña', 15000, 'casas arbol', '2022-10-19 00:00:00'),
(7, 1, 1, 'monstera', 150, 'Planta de interior', '2023-01-01 00:00:00'),
(8, 1, 1, 'geranio', 150, 'Planta de interior', '2023-01-01 00:00:00'),
(9, 1, 1, 'Cala', 150, 'Planta de interior', '2023-01-01 00:00:00'),
(10, 4, 2, 'Gorrion rojo', 159, 'Un pÃ¡jaro de la naturaleza rojo', '2026-04-27 00:00:00'),
(11, 4, 2, 'Gorrion', 159, 'Un pÃ¡jaro de la naturaleza', '2026-04-27 00:00:00'),
(12, 4, 4, 'Chalet', 1990, 'Un chalet, villa.', '2024-11-19 00:00:00'),
(13, 4, 2, 'Elena', 5, 'una mujer pajaro.', '2024-10-17 00:00:00'),
(14, 4, 2, 'Aguila', 100, 'Un ave peligroso', '2025-10-28 18:06:00'),
(15, 3, 4, 'mesa', 105, 'mesa de ikea', '2023-01-05 07:01:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pujas`
--

DROP TABLE IF EXISTS `pujas`;
CREATE TABLE IF NOT EXISTS `pujas` (
  `id` int(11) NOT NULL,
  `id_item` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `cantidad` float NOT NULL,
  `fecha` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_ITEMS_PUJAS` (`id_item`),
  KEY `FK_ITEMS_USUARIO` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Información relacionada con las pujas';

--
-- Volcado de datos para la tabla `pujas`
--

INSERT INTO `pujas` (`id`, `id_item`, `id_user`, `cantidad`, `fecha`) VALUES
(1, 1, 1, 2, '2022-10-19'),
(2, 2, 2, 3, '2022-10-19'),
(3, 1, 1, 2, '2020-10-19'),
(4, 3, 2, 3, '2020-10-19'),
(5, 3, 1, 2, '2019-10-19'),
(6, 3, 2, 3, '2019-10-19'),
(11, 6, 2, 150000, '2021-10-10'),
(12, 5, 1, 600000, '2021-11-11'),
(13, 6, 1, 15000, '2021-10-16'),
(14, 5, 2, 6000, '2021-10-17'),
(15, 1, 1, 3, '2022-10-27'),
(16, 1, 1, 4, '2022-10-27'),
(17, 1, 1, 5, '2022-10-27'),
(18, 1, 1, 6, '2022-10-27'),
(19, 1, 2, 8, '2022-10-27'),
(20, 1, 2, 9, '2022-10-27'),
(21, 1, 2, 20, '2022-10-27'),
(22, 1, 2, 27, '2022-10-27'),
(23, 4, 2, 2, '2022-10-27'),
(24, 4, 2, 4, '2022-10-27'),
(25, 4, 2, 5, '2022-10-27'),
(26, 4, 2, 5, '2022-10-27'),
(27, 2, 4, 4, '2022-10-27'),
(28, 2, 4, 4, '2022-10-27'),
(29, 2, 4, 4, '2022-10-27'),
(30, 2, 4, 4, '2022-10-27'),
(31, 1, 4, 27, '2022-10-27'),
(32, 1, 4, 28, '2022-10-27'),
(33, 1, 4, 28, '2022-10-28'),
(34, 1, 4, 28, '2022-10-28'),
(35, 1, 4, 28, '2022-10-28'),
(36, 1, 4, 28, '2022-10-28');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) NOT NULL,
  `username` varchar(40) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `password` varchar(40) NOT NULL,
  `email` varchar(100) NOT NULL,
  `cadenaverificacion` varchar(100) NOT NULL,
  `activo` tinyint(4) NOT NULL,
  `falso` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabla con información de usuarios';

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `username`, `nombre`, `password`, `email`, `cadenaverificacion`, `activo`, `falso`) VALUES
(1, 'amaiadci', 'amaia', '123456', 'amaia.dlci@gmail.com', 'verific', 1, 0),
(2, 'admin', 'admin', 'admin', 'admin@admin.com', 'admin', 1, 1),
(3, 'Hola', 'Holaquetal', 'hola', 'holaquetal@gmail.com', 'T6u57bDrS49v0dBL', 0, 1),
(4, 'roger', 'roger enderson', 'roger', 'roger@gmail.com', 'x8B51QcikaUhkXv8', 1, 0);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `imagenes`
--
ALTER TABLE `imagenes`
  ADD CONSTRAINT `FK_IMAGENES_ITEMS` FOREIGN KEY (`id_item`) REFERENCES `items` (`id`);

--
-- Filtros para la tabla `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `FK_ITEMS_CATEGORIA` FOREIGN KEY (`id_cat`) REFERENCES `categorias` (`id`),
  ADD CONSTRAINT `FK_ITEMS_USUARIOS` FOREIGN KEY (`id_user`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `pujas`
--
ALTER TABLE `pujas`
  ADD CONSTRAINT `FK_ITEMS_PUJAS` FOREIGN KEY (`id_item`) REFERENCES `items` (`id`),
  ADD CONSTRAINT `FK_ITEMS_USUARIO` FOREIGN KEY (`id_user`) REFERENCES `usuarios` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

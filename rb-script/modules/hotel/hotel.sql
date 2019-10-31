-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 27-09-2019 a las 12:13:14
-- Versión del servidor: 5.6.39
-- Versión de PHP: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `emocion_restdb`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `hotel_config`
--

CREATE TABLE `hotel_config` (
  `hotel_option` varchar(100) NOT NULL,
  `hotel_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `hotel_extras`
--

CREATE TABLE `hotel_extras` (
  `reservacion_id` mediumint(4) NOT NULL,
  `producto_id` mediumint(4) NOT NULL,
  `cantidad` smallint(4) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `hotel_habitacion`
--

CREATE TABLE `hotel_habitacion` (
  `id` int(5) NOT NULL,
  `numero_habitacion` varchar(50) NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `detalles` text NOT NULL,
  `enseres` text NOT NULL,
  `servicios` text NOT NULL,
  `galeria_id` int(4) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `personas_max` smallint(3) NOT NULL,
  `estado` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `hotel_producto`
--

CREATE TABLE `hotel_producto` (
  `id` int(4) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `foto_id` smallint(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `hotel_reservacion`
--

CREATE TABLE `hotel_reservacion` (
  `id` int(4) NOT NULL,
  `fecha_llegada` datetime NOT NULL,
  `fecha_salida` datetime NOT NULL,
  `habitacion_id` int(4) NOT NULL,
  `cliente_id` int(4) NOT NULL,
  `personal_id` int(3) NOT NULL,
  `total_habitacion` decimal(10,2) NOT NULL,
  `total_adicionales` decimal(10,2) NOT NULL,
  `total_reservacion` decimal(10,2) NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT '1',
  `fecha_registro` datetime NOT NULL,
  `codigo_unico` varchar(20) NOT NULL,
  `fecha_ocupado` datetime NOT NULL,
  `fecha_finalizacion` datetime NOT NULL,
  `noches` tinyint(3) NOT NULL,
  `ocupantes_ids` text NOT NULL,
  `codigo_secreto_cliente` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `hotel_extras`
--
ALTER TABLE `hotel_extras`
  ADD UNIQUE KEY `extra_id` (`reservacion_id`,`producto_id`);

--
-- Indices de la tabla `hotel_habitacion`
--
ALTER TABLE `hotel_habitacion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `hotel_producto`
--
ALTER TABLE `hotel_producto`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `hotel_reservacion`
--
ALTER TABLE `hotel_reservacion`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `hotel_habitacion`
--
ALTER TABLE `hotel_habitacion`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `hotel_producto`
--
ALTER TABLE `hotel_producto`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `hotel_reservacion`
--
ALTER TABLE `hotel_reservacion`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

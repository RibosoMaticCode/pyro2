-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 27-09-2019 a las 15:36:37
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
-- Base de datos: `emocion_sistema`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `crm_customers`
--

CREATE TABLE `crm_customers` (
  `id` int(5) NOT NULL,
  `nombres` varchar(200) NOT NULL,
  `apellidos` varchar(200) NOT NULL,
  `photo_id` int(5) NOT NULL,
  `fecharegistro` datetime NOT NULL,
  `telefono` varchar(11) NOT NULL,
  `correo` varchar(200) NOT NULL,
  `direccion` varchar(250) NOT NULL,
  `face` varchar(150) NOT NULL,
  `insta` varchar(150) NOT NULL,
  `twitter` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `crm_historial`
--

CREATE TABLE `crm_historial` (
  `id` int(5) NOT NULL,
  `customer_id` int(5) NOT NULL,
  `fecha_registro` datetime NOT NULL,
  `detalles` mediumtext NOT NULL,
  `user_id` int(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `crm_notification`
--

CREATE TABLE `crm_notification` (
  `id` int(4) NOT NULL,
  `customer_id` int(4) NOT NULL,
  `mensaje` text NOT NULL,
  `fecha_registro` datetime NOT NULL,
  `sender_id` int(4) NOT NULL,
  `fecha_envio` datetime NOT NULL,
  `enviado` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `crm_visits`
--

CREATE TABLE `crm_visits` (
  `id` int(5) NOT NULL,
  `customer_id` int(5) NOT NULL,
  `fecha_visita` datetime NOT NULL,
  `observaciones` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `crm_customers`
--
ALTER TABLE `crm_customers`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `crm_historial`
--
ALTER TABLE `crm_historial`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `crm_notification`
--
ALTER TABLE `crm_notification`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `crm_visits`
--
ALTER TABLE `crm_visits`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `crm_customers`
--
ALTER TABLE `crm_customers`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `crm_historial`
--
ALTER TABLE `crm_historial`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `crm_notification`
--
ALTER TABLE `crm_notification`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `crm_visits`
--
ALTER TABLE `crm_visits`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

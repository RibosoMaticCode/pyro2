-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-10-2019 a las 15:37:47
-- Versión del servidor: 10.4.6-MariaDB
-- Versión de PHP: 7.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `pyro3_test`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plm_category`
--

CREATE TABLE `plm_category` (
  `id` int(4) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `nombre_enlace` varchar(60) NOT NULL,
  `foto_id` int(11) NOT NULL,
  `descripcion` text NOT NULL,
  `parent_id` mediumint(5) NOT NULL,
  `islink` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plm_comments`
--

CREATE TABLE `plm_comments` (
  `id` int(5) NOT NULL,
  `user_id` int(5) NOT NULL,
  `title` varchar(100) NOT NULL,
  `comment` text NOT NULL,
  `date_register` datetime NOT NULL,
  `product_id` int(5) NOT NULL,
  `state` tinyint(1) NOT NULL DEFAULT 0,
  `score` tinyint(1) NOT NULL,
  `img_ids` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plm_config`
--

CREATE TABLE `plm_config` (
  `id` int(4) NOT NULL,
  `plm_option` varchar(100) NOT NULL,
  `plm_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plm_orders`
--

CREATE TABLE `plm_orders` (
  `id` int(4) NOT NULL,
  `fecha_registro` datetime NOT NULL,
  `detalles` text NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `user_id` int(4) NOT NULL,
  `charge_id` varchar(150) NOT NULL,
  `codigo_unico` varchar(16) NOT NULL,
  `tiempo_envio` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plm_products`
--

CREATE TABLE `plm_products` (
  `id` int(5) NOT NULL,
  `nombre` varchar(250) NOT NULL,
  `nombre_key` varchar(250) NOT NULL,
  `precio` float NOT NULL,
  `marca` varchar(90) NOT NULL,
  `modelo` varchar(90) NOT NULL,
  `descuento` tinyint(3) NOT NULL,
  `precio_oferta` float NOT NULL,
  `foto_id` mediumint(5) NOT NULL,
  `galeria_id` mediumint(5) NOT NULL,
  `tipo_envio` varchar(100) NOT NULL,
  `fecha_registro` datetime NOT NULL,
  `descripcion` text NOT NULL,
  `usuario_id` mediumint(5) NOT NULL,
  `categoria` varchar(100) NOT NULL,
  `tiempo_envio` int(3) NOT NULL,
  `mostrar` tinyint(2) NOT NULL DEFAULT 1,
  `estado` tinyint(1) NOT NULL DEFAULT 1,
  `cantidad` int(5) NOT NULL,
  `sku` varchar(200) NOT NULL,
  `options` mediumtext NOT NULL,
  `options_variants` mediumtext NOT NULL,
  `salidas` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plm_products_variants`
--

CREATE TABLE `plm_products_variants` (
  `variant_id` int(5) NOT NULL,
  `product_id` mediumint(5) NOT NULL,
  `name` varchar(200) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `discount` tinyint(3) NOT NULL,
  `price_discount` float(10,2) NOT NULL,
  `state` tinyint(1) NOT NULL DEFAULT 1,
  `visible` tinyint(1) NOT NULL DEFAULT 1,
  `gallery_id` mediumint(5) NOT NULL,
  `image_id` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `plm_category`
--
ALTER TABLE `plm_category`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `plm_comments`
--
ALTER TABLE `plm_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `plm_config`
--
ALTER TABLE `plm_config`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `plm_orders`
--
ALTER TABLE `plm_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `plm_products`
--
ALTER TABLE `plm_products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre_key` (`nombre_key`);
ALTER TABLE `plm_products` ADD FULLTEXT KEY `busqueda` (`nombre`,`descripcion`,`marca`,`modelo`);

--
-- Indices de la tabla `plm_products_variants`
--
ALTER TABLE `plm_products_variants`
  ADD UNIQUE KEY `combo_id` (`variant_id`,`product_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `plm_category`
--
ALTER TABLE `plm_category`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `plm_comments`
--
ALTER TABLE `plm_comments`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `plm_config`
--
ALTER TABLE `plm_config`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `plm_orders`
--
ALTER TABLE `plm_orders`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `plm_products`
--
ALTER TABLE `plm_products`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-06-2019 a las 17:13:28
-- Versión del servidor: 10.1.37-MariaDB
-- Versión de PHP: 7.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `pyro3`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `blog_categories`
--

CREATE TABLE `blog_categories` (
  `id` int(11) NOT NULL,
  `nombre_enlace` varchar(100) NOT NULL DEFAULT '',
  `nombre` varchar(100) NOT NULL DEFAULT '',
  `descripcion` text NOT NULL,
  `categoria_id` int(7) NOT NULL DEFAULT '0',
  `nivel` int(7) NOT NULL DEFAULT '0',
  `photo_id` smallint(5) NOT NULL,
  `acceso` varchar(10) NOT NULL,
  `niveles` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `blog_config`
--

CREATE TABLE `blog_config` (
  `blog_option` varchar(200) NOT NULL,
  `blog_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `blog_fields`
--

CREATE TABLE `blog_fields` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `contenido` text NOT NULL,
  `tipo` varchar(10) NOT NULL DEFAULT 'imagen',
  `articulo_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `blog_posts`
--

CREATE TABLE `blog_posts` (
  `id` int(7) NOT NULL,
  `fecha_creacion` datetime NOT NULL DEFAULT '1000-01-01 00:00:00',
  `titulo` varchar(200) NOT NULL DEFAULT '',
  `titulo_enlace` varchar(200) NOT NULL DEFAULT '',
  `autor_id` int(7) NOT NULL,
  `tags` varchar(250) DEFAULT NULL,
  `contenido` text NOT NULL,
  `lecturas` int(7) NOT NULL DEFAULT '0',
  `comentarios` int(7) NOT NULL DEFAULT '0',
  `activo` char(1) DEFAULT 'A',
  `actcom` char(1) DEFAULT 'A',
  `portada` tinyint(1) NOT NULL DEFAULT '0',
  `actividad` tinyint(1) NOT NULL DEFAULT '0',
  `fecha_actividad` date NOT NULL DEFAULT '1000-01-01',
  `acceso` varchar(10) NOT NULL,
  `niveles` varchar(250) NOT NULL,
  `img_back` smallint(5) NOT NULL DEFAULT '0',
  `img_profile` smallint(5) DEFAULT '0',
  `gallery_id` mediumint(5) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `blog_posts_categories`
--

CREATE TABLE `blog_posts_categories` (
  `articulo_id` int(11) NOT NULL DEFAULT '0',
  `categoria_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `py_configuration`
--

CREATE TABLE `py_configuration` (
  `id` int(4) NOT NULL,
  `option_name` varchar(100) NOT NULL,
  `value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `py_files`
--

CREATE TABLE `py_files` (
  `id` int(11) NOT NULL,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `src` varchar(150) NOT NULL,
  `tn_src` varchar(150) NOT NULL,
  `type` varchar(100) NOT NULL,
  `album_id` tinyint(3) NOT NULL,
  `url` tinytext NOT NULL,
  `tipo` varchar(3) NOT NULL,
  `orden` smallint(6) NOT NULL,
  `usuario_id` mediumint(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `py_forms`
--

CREATE TABLE `py_forms` (
  `id` mediumint(5) NOT NULL,
  `name` varchar(250) NOT NULL,
  `name_id` varchar(250) NOT NULL,
  `estructure` text NOT NULL,
  `validations` text NOT NULL,
  `mails` text NOT NULL,
  `user_id` int(5) NOT NULL,
  `intro` text NOT NULL,
  `respuesta` text NOT NULL,
  `sender` VARCHAR(150) NOT NULL,
  `sender_mail` VARCHAR(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `py_galleries`
--

CREATE TABLE `py_galleries` (
  `id` int(7) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `nombre_enlace` varchar(250) NOT NULL,
  `galeria_grupo` varchar(200) NOT NULL,
  `tipo` varchar(4) NOT NULL,
  `descripcion` tinytext NOT NULL,
  `imagenes` int(7) NOT NULL,
  `fecha` datetime NOT NULL,
  `usuario_id` mediumint(7) NOT NULL,
  `photo_id` mediumint(5) NOT NULL,
  `private` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `py_log`
--

CREATE TABLE `py_log` (
  `id` int(7) NOT NULL,
  `usuario_id` tinyint(4) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `fecha` datetime NOT NULL,
  `observacion` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `py_menus`
--

CREATE TABLE `py_menus` (
  `id` smallint(4) NOT NULL,
  `nombre` varchar(75) NOT NULL,
  `tipo` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `py_menus_items`
--

CREATE TABLE `py_menus_items` (
  `id` int(11) NOT NULL,
  `nombre_enlace` varchar(100) NOT NULL DEFAULT '',
  `nombre` varchar(100) NOT NULL DEFAULT '',
  `url` tinytext NOT NULL,
  `menu_id` int(7) NOT NULL DEFAULT '0',
  `nivel` int(7) NOT NULL DEFAULT '0',
  `mainmenu_id` tinyint(5) NOT NULL,
  `tipo` varchar(3) NOT NULL,
  `style` varchar(50) NOT NULL,
  `img` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `py_messages`
--

CREATE TABLE `py_messages` (
  `id` int(7) NOT NULL,
  `remitente_id` int(5) NOT NULL,
  `asunto` varchar(150) NOT NULL,
  `contenido` text NOT NULL,
  `fecha_envio` datetime NOT NULL,
  `inactivo` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `py_messages_users`
--

CREATE TABLE `py_messages_users` (
  `mensaje_id` int(7) NOT NULL,
  `usuario_id` int(7) NOT NULL,
  `leido` tinyint(1) NOT NULL DEFAULT '0',
  `fecha_leido` datetime NOT NULL,
  `inactivo` tinyint(1) NOT NULL DEFAULT '0',
  `retenido` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `py_pages`
--

CREATE TABLE `py_pages` (
  `id` int(7) NOT NULL,
  `fecha_creacion` datetime NOT NULL DEFAULT '1000-01-01 00:00:00',
  `titulo` varchar(200) NOT NULL DEFAULT '',
  `titulo_enlace` varchar(200) NOT NULL DEFAULT '',
  `autor_id` int(7) NOT NULL,
  `tags` varchar(250) DEFAULT NULL,
  `contenido` text NOT NULL,
  `lecturas` int(7) NOT NULL DEFAULT 0,
  `show_header` tinyint(1) NOT NULL DEFAULT 1,
  `header_custom_id` varchar(250) NOT NULL DEFAULT '',
  `show_footer` tinyint(1) NOT NULL DEFAULT 1,
  `footer_custom_id` varchar(250) DEFAULT '',
  `description` tinytext NOT NULL,
  `type` smallint(3) NOT NULL DEFAULT 0,
  `allow_access` tinyint(1) NOT NULL DEFAULT 0,
  `password_view` varchar(50) NOT NULL DEFAULT '',
  `blocking_message` text NOT NULL,
  `image_id` smallint(5) NOT NULL DEFAULT 0,
  `allow_users_ids` tinytext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `py_pages_blocks`
--

CREATE TABLE `py_pages_blocks` (
  `id` int(11) NOT NULL,
  `nombre` varchar(250) NOT NULL,
  `contenido` text NOT NULL,
  `tipo` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `py_users`
--

CREATE TABLE `py_users` (
  `id` smallint(4) NOT NULL,
  `nickname` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `nombres` varchar(50) NOT NULL,
  `apellidos` varchar(50) NOT NULL,
  `ciudad` varchar(50) NOT NULL,
  `pais` varchar(20) NOT NULL,
  `telefono-movil` varchar(10) NOT NULL,
  `telefono-fijo` varchar(10) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `direccion` varchar(100) NOT NULL,
  `codigo_postal` varchar(40) NOT NULL,
  `fecharegistro` datetime NOT NULL,
  `fecha_activar` datetime NOT NULL,
  `ultimoacceso` datetime NOT NULL,
  `tipo` tinyint(1) NOT NULL DEFAULT '3',
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  `recovery` tinyint(1) NOT NULL DEFAULT '0',
  `sexo` char(1) NOT NULL,
  `photo_id` smallint(5) NOT NULL,
  `access` varchar(2) NOT NULL,
  `tw` tinytext NOT NULL,
  `fb` tinytext NOT NULL,
  `gplus` tinytext NOT NULL,
  `in` tinytext NOT NULL,
  `pin` tinytext NOT NULL,
  `insta` tinytext NOT NULL,
  `youtube` tinytext NOT NULL,
  `bio` tinytext NOT NULL,
  `grupo_id` smallint(5) NOT NULL,
  `meta` tinytext NOT NULL,
  `user_key` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `py_users_groups`
--

CREATE TABLE `py_users_groups` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `grupo_enlace` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `py_users_levels`
--

CREATE TABLE `py_users_levels` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text NOT NULL,
  `nivel_enlace` varchar(100) NOT NULL,
  `subnivel_enlace` varchar(100) NOT NULL,
  `permisos` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `blog_categories`
--
ALTER TABLE `blog_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `nombre_enlace` (`nombre_enlace`);

--
-- Indices de la tabla `blog_fields`
--
ALTER TABLE `blog_fields`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `blog_posts`
--
ALTER TABLE `blog_posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `titulo_enlace` (`titulo_enlace`);
ALTER TABLE `blog_posts` ADD FULLTEXT KEY `titulo` (`titulo`,`contenido`);

--
-- Indices de la tabla `py_configuration`
--
ALTER TABLE `py_configuration`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `py_files`
--
ALTER TABLE `py_files`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `py_forms`
--
ALTER TABLE `py_forms`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `py_galleries`
--
ALTER TABLE `py_galleries`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `py_log`
--
ALTER TABLE `py_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indices de la tabla `py_menus`
--
ALTER TABLE `py_menus`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `py_menus_items`
--
ALTER TABLE `py_menus_items`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `py_messages`
--
ALTER TABLE `py_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `py_messages_users`
--
ALTER TABLE `py_messages_users`
  ADD UNIQUE KEY `mensaje_id` (`mensaje_id`,`usuario_id`);

--
-- Indices de la tabla `py_pages`
--
ALTER TABLE `py_pages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `titulo_enlace` (`titulo_enlace`);
ALTER TABLE `py_pages` ADD FULLTEXT KEY `titulo` (`titulo`,`contenido`);

--
-- Indices de la tabla `py_pages_blocks`
--
ALTER TABLE `py_pages_blocks`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `py_users`
--
ALTER TABLE `py_users`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `py_users_groups`
--
ALTER TABLE `py_users_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indices de la tabla `py_users_levels`
--
ALTER TABLE `py_users_levels`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `blog_categories`
--
ALTER TABLE `blog_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `blog_fields`
--
ALTER TABLE `blog_fields`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `blog_posts`
--
ALTER TABLE `blog_posts`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `py_configuration`
--
ALTER TABLE `py_configuration`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `py_files`
--
ALTER TABLE `py_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `py_forms`
--
ALTER TABLE `py_forms`
  MODIFY `id` mediumint(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `py_galleries`
--
ALTER TABLE `py_galleries`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `py_log`
--
ALTER TABLE `py_log`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `py_menus`
--
ALTER TABLE `py_menus`
  MODIFY `id` smallint(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `py_menus_items`
--
ALTER TABLE `py_menus_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `py_messages`
--
ALTER TABLE `py_messages`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `py_pages`
--
ALTER TABLE `py_pages`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `py_pages_blocks`
--
ALTER TABLE `py_pages_blocks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `py_users`
--
ALTER TABLE `py_users`
  MODIFY `id` smallint(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `py_users_groups`
--
ALTER TABLE `py_users_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `py_users_levels`
--
ALTER TABLE `py_users_levels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

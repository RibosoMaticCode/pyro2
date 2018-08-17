-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-08-2018 a las 17:24:37
-- Versión del servidor: 10.1.32-MariaDB
-- Versión de PHP: 7.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `pyro205_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `albums`
--

CREATE TABLE `albums` (
  `id` int(7) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `nombre_enlace` varchar(250) NOT NULL,
  `galeria_grupo` varchar(200) NOT NULL,
  `tipo` varchar(4) NOT NULL,
  `descripcion` tinytext NOT NULL,
  `imagenes` int(7) NOT NULL,
  `fecha` datetime NOT NULL,
  `usuario_id` mediumint(7) NOT NULL,
  `photo_id` mediumint(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articulos`
--

CREATE TABLE `articulos` (
  `id` int(7) NOT NULL,
  `fecha_creacion` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `titulo` varchar(200) NOT NULL DEFAULT '',
  `titulo_enlace` varchar(200) NOT NULL DEFAULT '',
  `autor_id` int(7) NOT NULL,
  `tags` varchar(250) DEFAULT NULL,
  `contenido` text NOT NULL,
  `video` tinyint(1) NOT NULL,
  `video_embed` text NOT NULL,
  `lecturas` int(7) NOT NULL DEFAULT '0',
  `comentarios` int(7) NOT NULL DEFAULT '0',
  `activo` char(1) DEFAULT 'A',
  `actcom` char(1) DEFAULT 'A',
  `portada` tinyint(1) NOT NULL DEFAULT '0',
  `actividad` tinyint(1) NOT NULL DEFAULT '0',
  `fecha_actividad` date NOT NULL DEFAULT '0000-00-00',
  `acceso` varchar(10) NOT NULL,
  `niveles` varchar(250) NOT NULL,
  `img_back` smallint(5) NOT NULL DEFAULT '0',
  `img_profile` smallint(5) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articulos_albums`
--

CREATE TABLE `articulos_albums` (
  `articulo_id` int(11) NOT NULL,
  `album_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articulos_articulos`
--

CREATE TABLE `articulos_articulos` (
  `id` int(7) NOT NULL,
  `nombre_atributo` varchar(250) NOT NULL,
  `articulo_id_padre` smallint(7) NOT NULL,
  `articulo_id_hijo` smallint(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articulos_categorias`
--

CREATE TABLE `articulos_categorias` (
  `articulo_id` int(11) NOT NULL DEFAULT '0',
  `categoria_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bloques`
--

CREATE TABLE `bloques` (
  `id` int(11) NOT NULL,
  `nombre` varchar(250) NOT NULL,
  `contenido` text NOT NULL,
  `tipo` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
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
-- Estructura de tabla para la tabla `comentarios`
--

CREATE TABLE `comentarios` (
  `id` int(7) NOT NULL,
  `articulo_id` int(7) DEFAULT NULL,
  `nombre` varchar(50) NOT NULL DEFAULT '',
  `fecha` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `contenido` text NOT NULL,
  `mail` varchar(50) NOT NULL DEFAULT '',
  `web` varchar(50) NOT NULL DEFAULT '',
  `comentario_id` int(7) NOT NULL DEFAULT '0',
  `spam` int(1) NOT NULL DEFAULT '0',
  `activo` int(1) NOT NULL DEFAULT '0',
  `ip` varchar(15) NOT NULL,
  `source` varchar(20) NOT NULL,
  `url_referencia` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `forms`
--

CREATE TABLE `forms` (
  `id` mediumint(5) NOT NULL,
  `name` varchar(250) NOT NULL,
  `name_id` varchar(250) NOT NULL,
  `estructure` text NOT NULL,
  `validations` text NOT NULL,
  `user_id` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `log`
--

CREATE TABLE `log` (
  `id` int(7) NOT NULL,
  `usuario_id` tinyint(4) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `fecha` datetime NOT NULL,
  `observacion` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes`
--

CREATE TABLE `mensajes` (
  `id` int(7) NOT NULL,
  `remitente_id` int(5) NOT NULL,
  `asunto` varchar(150) NOT NULL,
  `contenido` text NOT NULL,
  `fecha_envio` datetime NOT NULL,
  `inactivo` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes_usuarios`
--

CREATE TABLE `mensajes_usuarios` (
  `mensaje_id` int(7) NOT NULL,
  `usuario_id` int(7) NOT NULL,
  `leido` tinyint(1) NOT NULL DEFAULT '0',
  `fecha_leido` datetime NOT NULL,
  `inactivo` tinyint(1) NOT NULL DEFAULT '0',
  `retenido` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menus`
--

CREATE TABLE `menus` (
  `id` smallint(4) NOT NULL,
  `nombre` varchar(75) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menus_items`
--

CREATE TABLE `menus_items` (
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
-- Estructura de tabla para la tabla `objetos`
--

CREATE TABLE `objetos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `contenido` text NOT NULL,
  `tipo` varchar(10) NOT NULL DEFAULT 'imagen',
  `articulo_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `opciones`
--

CREATE TABLE `opciones` (
  `id` int(4) NOT NULL,
  `opcion` varchar(100) NOT NULL,
  `valor` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paginas`
--

CREATE TABLE `paginas` (
  `id` int(7) NOT NULL,
  `fecha_creacion` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `titulo` varchar(200) NOT NULL DEFAULT '',
  `titulo_enlace` varchar(200) NOT NULL DEFAULT '',
  `autor_id` int(7) NOT NULL,
  `tags` varchar(250) DEFAULT NULL,
  `contenido` text NOT NULL,
  `lecturas` int(7) NOT NULL DEFAULT '0',
  `activo` char(1) DEFAULT 'D',
  `sidebar` tinyint(1) NOT NULL DEFAULT '1',
  `sidebar_align` varchar(10) NOT NULL DEFAULT 'right',
  `popup` tinyint(1) NOT NULL,
  `galeria_id` tinyint(4) NOT NULL,
  `addon` varchar(200) NOT NULL,
  `bloques` tinyint(1) NOT NULL,
  `menu_id` mediumint(5) NOT NULL,
  `show_header` tinyint(1) NOT NULL DEFAULT '1',
  `header_custom_id` varchar(250) NOT NULL DEFAULT '',
  `show_footer` tinyint(1) NOT NULL DEFAULT '1',
  `footer_custom_id` varchar(250) DEFAULT '',
  `description` tinytext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `photo`
--

CREATE TABLE `photo` (
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
-- Estructura de tabla para la tabla `staff`
--

CREATE TABLE `staff` (
  `id` int(5) NOT NULL,
  `name` varchar(250) NOT NULL,
  `email` varchar(200) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `position` varchar(100) NOT NULL,
  `area` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `photo_id` int(11) NOT NULL DEFAULT '0',
  `description` text NOT NULL,
  `num_order` mediumint(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `suscriptores`
--

CREATE TABLE `suscriptores` (
  `id` int(11) NOT NULL,
  `nombres` varchar(100) NOT NULL,
  `correo` varchar(150) NOT NULL,
  `fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
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
-- Estructura de tabla para la tabla `usuarios_grupos`
--

CREATE TABLE `usuarios_grupos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `grupo_enlace` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios_niveles`
--

CREATE TABLE `usuarios_niveles` (
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
-- Indices de la tabla `albums`
--
ALTER TABLE `albums`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `articulos`
--
ALTER TABLE `articulos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `titulo_enlace` (`titulo_enlace`);
ALTER TABLE `articulos` ADD FULLTEXT KEY `titulo` (`titulo`,`contenido`);

--
-- Indices de la tabla `articulos_articulos`
--
ALTER TABLE `articulos_articulos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `bloques`
--
ALTER TABLE `bloques`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `nombre_enlace` (`nombre_enlace`);

--
-- Indices de la tabla `forms`
--
ALTER TABLE `forms`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indices de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `menus_items`
--
ALTER TABLE `menus_items`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `objetos`
--
ALTER TABLE `objetos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `opciones`
--
ALTER TABLE `opciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `paginas`
--
ALTER TABLE `paginas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `titulo_enlace` (`titulo_enlace`);
ALTER TABLE `paginas` ADD FULLTEXT KEY `titulo` (`titulo`,`contenido`);

--
-- Indices de la tabla `photo`
--
ALTER TABLE `photo`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `suscriptores`
--
ALTER TABLE `suscriptores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios_grupos`
--
ALTER TABLE `usuarios_grupos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indices de la tabla `usuarios_niveles`
--
ALTER TABLE `usuarios_niveles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `albums`
--
ALTER TABLE `albums`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `articulos`
--
ALTER TABLE `articulos`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `articulos_articulos`
--
ALTER TABLE `articulos_articulos`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `bloques`
--
ALTER TABLE `bloques`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `forms`
--
ALTER TABLE `forms`
  MODIFY `id` mediumint(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `log`
--
ALTER TABLE `log`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `menus`
--
ALTER TABLE `menus`
  MODIFY `id` smallint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `menus_items`
--
ALTER TABLE `menus_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `objetos`
--
ALTER TABLE `objetos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `opciones`
--
ALTER TABLE `opciones`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT de la tabla `paginas`
--
ALTER TABLE `paginas`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de la tabla `photo`
--
ALTER TABLE `photo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT de la tabla `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `suscriptores`
--
ALTER TABLE `suscriptores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` smallint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `usuarios_grupos`
--
ALTER TABLE `usuarios_grupos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios_niveles`
--
ALTER TABLE `usuarios_niveles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

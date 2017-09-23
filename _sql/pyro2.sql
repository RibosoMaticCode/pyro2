-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `albums`
--

CREATE TABLE IF NOT EXISTS `albums` (
  `id` int(7) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(150) NOT NULL,
  `nombre_enlace` varchar(250) NOT NULL,
  `tipo` varchar(4) NOT NULL,
  `descripcion` tinytext NOT NULL,
  `imagenes` int(7) NOT NULL,
  `fecha` datetime NOT NULL,
  `usuario_id` mediumint(7) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articulos`
--

CREATE TABLE IF NOT EXISTS `articulos` (
  `id` int(7) NOT NULL AUTO_INCREMENT,
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
  `img_portada` varchar(200) NOT NULL DEFAULT '_default.jpg',
  `actividad` tinyint(1) NOT NULL DEFAULT '0',
  `fecha_actividad` date NOT NULL DEFAULT '0000-00-00',
  `galeria_id` tinyint(4) NOT NULL,
  `acceso` varchar(10) NOT NULL,
  `niveles` varchar(250) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `titulo_enlace` (`titulo_enlace`),
  FULLTEXT KEY `titulo` (`titulo`,`contenido`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articulos_albums`
--

CREATE TABLE IF NOT EXISTS `articulos_albums` (
  `articulo_id` int(11) NOT NULL,
  `album_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articulos_articulos`
--

CREATE TABLE IF NOT EXISTS `articulos_articulos` (
  `id` int(7) NOT NULL,
  `nombre_atributo` varchar(250) NOT NULL,
  `articulo_id_padre` smallint(7) NOT NULL,
  `articulo_id_hijo` smallint(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articulos_categorias`
--

CREATE TABLE IF NOT EXISTS `articulos_categorias` (
  `articulo_id` int(11) NOT NULL DEFAULT '0',
  `categoria_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE IF NOT EXISTS `categorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_enlace` varchar(100) NOT NULL DEFAULT '',
  `nombre` varchar(100) NOT NULL DEFAULT '',
  `descripcion` text NOT NULL,
  `categoria_id` int(7) NOT NULL DEFAULT '0',
  `nivel` int(7) NOT NULL DEFAULT '0',
  `photo_id` smallint(5) NOT NULL,
  `acceso` varchar(10) NOT NULL,
  `niveles` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `nombre_enlace` (`nombre_enlace`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentarios`
--

CREATE TABLE IF NOT EXISTS `comentarios` (
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
-- Estructura de tabla para la tabla `log`
--

CREATE TABLE IF NOT EXISTS `log` (
  `id` int(7) NOT NULL AUTO_INCREMENT,
  `usuario_id` tinyint(4) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `fecha` datetime NOT NULL,
  `observacion` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes`
--

CREATE TABLE IF NOT EXISTS `mensajes` (
  `id` int(7) NOT NULL AUTO_INCREMENT,
  `remitente_id` int(5) NOT NULL,
  `asunto` varchar(150) NOT NULL,
  `contenido` text NOT NULL,
  `fecha_envio` datetime NOT NULL,
  `inactivo` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes_usuarios`
--

CREATE TABLE IF NOT EXISTS `mensajes_usuarios` (
  `mensaje_id` int(7) NOT NULL,
  `usuario_id` int(7) NOT NULL,
  `leido` tinyint(1) NOT NULL DEFAULT '0',
  `fecha_leido` datetime NOT NULL,
  `inactivo` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menus`
--

CREATE TABLE IF NOT EXISTS `menus` (
  `id` smallint(4) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(75) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menus_items`
--

CREATE TABLE IF NOT EXISTS `menus_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_enlace` varchar(100) NOT NULL DEFAULT '',
  `nombre` varchar(100) NOT NULL DEFAULT '',
  `url` tinytext NOT NULL,
  `menu_id` int(7) NOT NULL DEFAULT '0',
  `nivel` int(7) NOT NULL DEFAULT '0',
  `mainmenu_id` tinyint(5) NOT NULL,
  `tipo` varchar(3) NOT NULL,
  `style` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `objetos`
--

CREATE TABLE IF NOT EXISTS `objetos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `contenido` text NOT NULL,
  `tipo` varchar(10) NOT NULL DEFAULT 'imagen',
  `articulo_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `opciones`
--

CREATE TABLE IF NOT EXISTS `opciones` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `blog_id` int(4) NOT NULL,
  `opcion` varchar(100) NOT NULL,
  `valor` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paginas`
--

CREATE TABLE IF NOT EXISTS `paginas` (
  `id` int(7) NOT NULL AUTO_INCREMENT,
  `fecha_creacion` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `titulo` varchar(200) NOT NULL DEFAULT '',
  `titulo_enlace` varchar(200) NOT NULL DEFAULT '',
  `autor_id` int(7) NOT NULL,
  `tags` varchar(250) DEFAULT NULL,
  `contenido` text NOT NULL,
  `lecturas` int(7) NOT NULL DEFAULT '0',
  `activo` char(1) DEFAULT 'D',
  `sidebar` tinyint(1) NOT NULL DEFAULT '1',
  `popup` tinyint(1) NOT NULL,
  `galeria_id` tinyint(4) NOT NULL,
  `addon` varchar(200) NOT NULL,
  `bloques` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `titulo_enlace` (`titulo_enlace`),
  FULLTEXT KEY `titulo` (`titulo`,`contenido`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `photo`
--

CREATE TABLE IF NOT EXISTS `photo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(250) NOT NULL,
  `description` text NOT NULL,
  `src` varchar(150) NOT NULL,
  `tn_src` varchar(150) NOT NULL,
  `type` varchar(100) NOT NULL,
  `album_id` tinyint(3) NOT NULL,
  `url` tinytext NOT NULL,
  `tipo` varchar(3) NOT NULL,
  `orden` smallint(6) NOT NULL,
  `usuario_id` mediumint(7) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` smallint(4) NOT NULL AUTO_INCREMENT,
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios_grupos`
--

CREATE TABLE IF NOT EXISTS `usuarios_grupos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `grupo_enlace` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios_niveles`
--

CREATE TABLE IF NOT EXISTS `usuarios_niveles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `nivel_enlace` varchar(100) NOT NULL,
  `permisos` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


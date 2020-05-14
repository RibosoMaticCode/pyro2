
CREATE TABLE `blog_categories` (
  `id` int(11) NOT NULL,
  `nombre_enlace` varchar(100) NOT NULL DEFAULT '',
  `nombre` varchar(100) NOT NULL DEFAULT '',
  `descripcion` text NOT NULL,
  `categoria_id` int(7) NOT NULL DEFAULT 0,
  `nivel` int(7) NOT NULL DEFAULT 0,
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
  `lecturas` int(7) NOT NULL DEFAULT 0,
  `comentarios` int(7) NOT NULL DEFAULT 0,
  `activo` char(1) DEFAULT 'A',
  `actcom` char(1) DEFAULT 'A',
  `portada` tinyint(1) NOT NULL DEFAULT 0,
  `actividad` tinyint(1) NOT NULL DEFAULT 0,
  `fecha_actividad` date NOT NULL DEFAULT '1000-01-01',
  `acceso` varchar(10) NOT NULL,
  `niveles` varchar(250) NOT NULL,
  `img_back` smallint(5) NOT NULL DEFAULT 0,
  `img_profile` smallint(5) DEFAULT 0,
  `gallery_id` mediumint(5) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `blog_posts_categories`
--

CREATE TABLE `blog_posts_categories` (
  `articulo_id` int(11) NOT NULL DEFAULT 0,
  `categoria_id` int(11) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `blog_posts_posts`
--

CREATE TABLE `blog_posts_posts` (
  `id` int(7) NOT NULL,
  `nombre_atributo` varchar(250) NOT NULL,
  `articulo_id_padre` smallint(7) NOT NULL,
  `articulo_id_hijo` smallint(7) NOT NULL
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
-- Indices de la tabla `blog_config`
--
ALTER TABLE `blog_config`
  ADD UNIQUE KEY `blog_option` (`blog_option`);

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
-- Indices de la tabla `blog_posts_posts`
--
ALTER TABLE `blog_posts_posts`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT de la tabla `blog_posts_posts`
--
ALTER TABLE `blog_posts_posts`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT;
COMMIT;

INSERT INTO `blog_config` (`blog_option`, `blog_value`) VALUES
('base_category', 'categoria'),
('base_publication', 'publicacion'),
('num_pubs_by_pages', '12'),
('objetos', ''),
('post_options', '{\"adj\":\"1\",\"edi\":\"1\",\"gal\":0,\"adi\":0,\"enl\":0,\"vid\":0,\"otr\":0,\"sub\":0}');
COMMIT;
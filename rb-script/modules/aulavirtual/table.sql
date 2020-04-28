
CREATE TABLE `aula_contenidos` (
  `id` mediumint(5) NOT NULL,
  `fecha_creacion` datetime NOT NULL,
  `titulo` varchar(200) NOT NULL,
  `url` varchar(250) NOT NULL,
  `contenido` text NOT NULL,
  `autor_id` mediumint(4) NOT NULL,
  `lecturas` mediumint(9) NOT NULL,
  `tipo` tinyint(3) NOT NULL DEFAULT 0,
  `acceso_permitir` tinyint(1) NOT NULL DEFAULT 0,
  `contrasena` varchar(50) NOT NULL DEFAULT '',
  `imagen_id` int(5) NOT NULL DEFAULT 0,
  `padre_id` int(4) NOT NULL DEFAULT 0,
  `allow_users_ids` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `aula_contenidos`
--
ALTER TABLE `aula_contenidos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `aula_contenidos`
--
ALTER TABLE `aula_contenidos`
  MODIFY `id` mediumint(5) NOT NULL AUTO_INCREMENT;
COMMIT;

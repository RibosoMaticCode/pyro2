CREATE TABLE `suscriptores_config` (
  `id` int(11) NOT NULL,
  `opcion` varchar(150) NOT NULL,
  `valor` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `suscriptores_config`
--

INSERT INTO `suscriptores_config` (`id`, `opcion`, `valor`) VALUES
(1, 'campos', '{\"Nombres\":\"show\", \"Correo\": \"show\", \"Telefono\": \"hide\"}');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `suscriptores_config`
--
ALTER TABLE `suscriptores_config`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `suscriptores_config`
--
ALTER TABLE `suscriptores_config`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;



CREATE TABLE `suscriptores` (
  `id` int(11) NOT NULL,
  `nombres` varchar(100) NOT NULL,
  `correo` varchar(150) NOT NULL,
  `fecha` datetime NOT NULL,
  `telefono` varchar(15) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `celular` varchar(12) NOT NULL,
  `direccion` varchar(50) NOT NULL,
  `detalles` text NOT NULL,
  `whatsapp` varchar(12) NOT NULL,
  `facebook` varchar(50) NOT NULL,
  `instagram` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `suscriptores`
--
ALTER TABLE `suscriptores`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `suscriptores`
--
ALTER TABLE `suscriptores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

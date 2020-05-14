
CREATE TABLE `sapiens_orders` (
  `id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `names` varchar(200) NOT NULL,
  `lastnames` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(12) NOT NULL,
  `career` varchar(100) NOT NULL,
  `school` varchar(100) NOT NULL,
  `book_title` varchar(100) NOT NULL,
  `book_url` tinytext NOT NULL,
  `delivery` tinyint(1) NOT NULL DEFAULT 0,
  `address` tinytext NOT NULL,
  `attended` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `sapiens_orders`
--
ALTER TABLE `sapiens_orders`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `sapiens_orders`
--
ALTER TABLE `sapiens_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

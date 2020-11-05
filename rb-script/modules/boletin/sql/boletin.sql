
CREATE TABLE `boletin_areas` (
  `id` mediumint(5) NOT NULL,
  `titulo` varchar(200) NOT NULL,
  `descripcion` text NOT NULL,
  `foto_id` mediumint(5) NOT NULL,
  `url` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `boletin_categorias` (
  `id` mediumint(5) NOT NULL,
  `area_id` mediumint(5) NOT NULL,
  `icon_id` mediumint(5) NOT NULL,
  `titulo` varchar(200) NOT NULL,
  `url` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `boletin_contenidos` (
  `id` mediumint(5) NOT NULL,
  `fecha_creacion` datetime NOT NULL,
  `titulo` varchar(200) NOT NULL,
  `url` tinytext NOT NULL,
  `contenido` text NOT NULL,
  `autor_id` mediumint(4) NOT NULL,
  `lecturas` mediumint(9) NOT NULL,
  `tipo` tinyint(3) NOT NULL DEFAULT 0,
  `acceso_permitir` tinyint(1) NOT NULL DEFAULT 0,
  `contrasena` varchar(50) NOT NULL DEFAULT '',
  `imagen_id` int(5) NOT NULL DEFAULT 0,
  `categoria_id` int(4) NOT NULL DEFAULT 0,
  `allow_users_ids` text NOT NULL,
  `pdfs` text NOT NULL,
  `videos` text NOT NULL,
  `video_live` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


ALTER TABLE `boletin_areas`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `boletin_categorias`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `boletin_contenidos`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `boletin_areas`
  MODIFY `id` mediumint(5) NOT NULL AUTO_INCREMENT;

ALTER TABLE `boletin_categorias`
  MODIFY `id` mediumint(5) NOT NULL AUTO_INCREMENT;

ALTER TABLE `boletin_contenidos`
  MODIFY `id` mediumint(5) NOT NULL AUTO_INCREMENT;
COMMIT;
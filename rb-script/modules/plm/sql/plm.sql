CREATE TABLE `plm_category` (
  `id` int(4) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `nombre_enlace` varchar(60) NOT NULL,
  `foto_id` int(11) NOT NULL,
  `descripcion` text NOT NULL,
  `parent_id` mediumint(5) NOT NULL,
  `islink` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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

CREATE TABLE `plm_config` (
  `id` int(4) NOT NULL,
  `plm_option` varchar(100) NOT NULL,
  `plm_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `plm_coupons` (
  `id` mediumint(5) NOT NULL,
  `code` varchar(80) NOT NULL,
  `description` tinytext NOT NULL,
  `type` tinyint(1) NOT NULL,
  `amount` mediumint(5) NOT NULL,
  `date_expired` datetime NOT NULL,
  `expensive_min` decimal(10,0) NOT NULL,
  `expensive_max` decimal(10,0) NOT NULL,
  `limit_by_user` int(11) NOT NULL DEFAULT 0,
  `date_register` datetime NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `plm_coupons_user` (
  `user_id` mediumint(5) NOT NULL,
  `coupon_id` mediumint(5) NOT NULL,
  `used` smallint(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `plm_orders` (
  `id` int(4) NOT NULL,
  `fecha_registro` datetime NOT NULL,
  `detalles` text NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `user_id` int(4) NOT NULL,
  `charge_id` varchar(150) NOT NULL,
  `codigo_unico` varchar(16) NOT NULL,
  `tiempo_envio` int(2) NOT NULL,
  `forma_pago` tinyint(1) NOT NULL DEFAULT 1,
  `client_names` varchar(200) NOT NULL,
  `client_address` varchar(200) NOT NULL,
  `client_email` varchar(150) NOT NULL,
  `client_phone` varchar(50) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `plm_products` (
  `id` int(5) NOT NULL,
  `nombre` varchar(250) NOT NULL,
  `nombre_largo` varchar(250) NOT NULL,
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
  `salidas` int(5) NOT NULL,
  `formato_fisico` tinyint(1) NOT NULL DEFAULT 0,
  `formato_digital` tinyint(1) NOT NULL DEFAULT 0,
  `url_archivo` tinytext NOT NULL,
  `orden` mediumint(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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


ALTER TABLE `plm_category`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `plm_comments`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `plm_config`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `plm_coupons`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `plm_coupons_user`
  ADD PRIMARY KEY (`user_id`,`coupon_id`);

ALTER TABLE `plm_orders`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `plm_products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre_key` (`nombre_key`);
ALTER TABLE `plm_products` ADD FULLTEXT KEY `busqueda` (`nombre`,`descripcion`,`marca`,`modelo`);

ALTER TABLE `plm_products_variants`
  ADD UNIQUE KEY `combo_id` (`variant_id`,`product_id`);


ALTER TABLE `plm_category`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT;

ALTER TABLE `plm_comments`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;

ALTER TABLE `plm_config`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT;

ALTER TABLE `plm_coupons`
  MODIFY `id` mediumint(5) NOT NULL AUTO_INCREMENT;

ALTER TABLE `plm_orders`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT;

ALTER TABLE `plm_products`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;

INSERT INTO `plm_config` (`id`, `plm_option`, `plm_value`) VALUES
(1, 'link_continue_purchase', ''),
(2, 'plm_charge', '0'),
(3, 'key_public', ''),
(4, 'key_private', ''),
(5, 'products_count_category', '12'),
(6, 'frontview_product', '2'),
(7, 'page_success', ''),
(8, 'page_error', 'h'),
(9, 'version', '1.1'),
(10, 'charge_card', ''),
(11, 'transfer_phone', ''),
(12, 'transfer_mail', ''),
(13, 'transfer_bank', ''),
(14, 'transfer_account', ''),
(15, 'show_cupons_form', '0'),
(16, 'theme_mini', '1'),
(17, 'allow_buy_without_login', '0');

CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `roles` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
	(1, 'Administrator', 'Acceso completo para insertar, eliminar o actualizar.', '2017-03-20 02:59:45', '2017-03-20 02:59:45'),
	(2, 'Usuario Administrativo', 'Usuario sin permisos para eliminar administradores, Acceso completo para insertar, eliminar o actualizar Objetivo.', '2017-03-20 02:59:45', '2017-03-20 02:59:45'),
	(3, 'Usuario App', 'Usuario estandar de la aplicación móvil. Acceso para Visualizar Objetivos.', '2017-04-16 04:48:53', '2017-04-16 04:48:54');

CREATE TABLE IF NOT EXISTS `targets` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `qr_id` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `latitude` decimal(10,8) NOT NULL,
  `longitude` decimal(11,8) NOT NULL,
  `min_mts` decimal(4,3) DEFAULT NULL,
  `facebook` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `twitter` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `instagram` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `youtube` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `type` tinyint(1) NOT NULL,
  `shared` bigint(20) NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `targets` (`id`, `qr_id`, `name`, `description`, `email`, `phone`, `latitude`, `longitude`, `min_mts`, `facebook`, `twitter`, `instagram`, `youtube`, `type`, `shared`, `url`, `created_at`, `updated_at`) VALUES
	(1, '58efe07c070156.06358825', 'Teatro José Peón Contreras', 'Es también el escenario teatral más antiguo de Mérida que recibió su nombre el 27 de diciembre de 1878 por iniciativa de los periódicos Semanario Yucateco y la Revista de Mérida, aunque el edificio actual, en la misma ubicación que los anteriores.', 'jojocojo@hotmail.com', '', 20.96952155, -89.62223890, 0.040, '', 'https://twitter.com/Scan_Share', 'https://www.instagram.com/scanandshare/', 'https://www.youtube.com/watch?v=fqMZr1b4das', 2, 0, 'http://www.scan-share.com.mx/', '2017-04-13 22:33:00', '2017-04-13 22:33:00'),
	(2, '58efe23d38fdf0.30130968', 'Parque Santa Lucia', 'El parque de Santa Lucía en Mérida, México es una plaza ubicada en el centro histórico de la ciudad capital del estado de Yucatán. Junto con la plaza principal o plaza grande de Mérida, es la más antigua de la ciudad.', 'jojocojo@hotmail.com', '9931735377', 20.97123842, -89.62258088, 0.035, 'https://www.facebook.com/SouvenirsAR/', '', 'https://www.instagram.com/scanandshare/', 'https://www.youtube.com/watch?v=fqMZr1b4das', 1, 0, '', '2017-04-13 22:40:29', '2017-04-13 22:40:29'),
	(3, '58efe6c0f09556.32300440', 'Tecnologico de Mérida', 'Instituto Tecnológico de Mérida es una institución pública de educación superior ubicado en el norte de la ciudad de Mérida, Yucatán, México. Su creación fue promovida e impulsada por diversos personajes e instituciones locales y federales.', '', '9931735377', 21.01252632, -89.62190094, 0.210, 'https://www.facebook.com/SouvenirsAR/', 'https://twitter.com/Scan_Share', '', 'https://www.youtube.com/watch?v=fqMZr1b4das', 1, 0, 'http://www.scan-share.com.mx/', '2017-04-13 22:59:44', '2017-04-13 22:59:44'),
	(4, '58efe89a800ce6.52853445', 'Motul de Carrillo Puerto', 'Motul de Carrillo Puerto es una ciudad del norte de Yucatán, México y cabecera del municipio Motul. Se encuentra a una distancia de 36 kilómetros en dirección noreste de la ciudad de Mérida.', 'jojocojo@hotmail.com', '', 21.09611134, -89.28274097, 2.500, '', 'https://twitter.com/Scan_Share', 'https://www.instagram.com/scanandshare/', '', 1, 0, 'http://www.scan-share.com.mx/', '2017-04-13 23:07:38', '2017-04-13 23:07:38'),
	(5, '58efea81cfaed9.12972621', 'Zoo Animaya', 'En el Parque Zoológico del Bicentenario Animaya diviértete creando tu propia aventura!. Entre grandiosos paisajes e increíbles especies vivirás un día al estilo', '', '9931735377', 20.98245709, -89.68715372, 0.500, ' ', ' ', ' ', ' ', 1, 0, ' ', '2017-04-13 23:15:45', '2017-04-21 21:07:42'),
	(6, '58efed6e179939.41277807', 'Mercado Lucas de Galvez', 'El 16 de septiembre de 1887  se inauguro con el nombre de  “Mercado de Gálvez”. Más tarde fue demolido para construir en su lugar otro mercado más amplio de mampostería y techo de lámina que fue inaugurado en 1909 y a su vez fue demolido en 1948.', 'jojocojo@hotmail.com', '9931735377', 20.96345286, -89.62120356, 0.100, 'https://www.facebook.com/SouvenirsAR/', 'https://twitter.com/Scan_Share', 'https://www.instagram.com/scanandshare/', 'https://www.youtube.com/watch?v=fqMZr1b4das', 2, 0, 'http://www.scan-share.com.mx/', '2017-04-13 23:28:14', '2017-04-13 23:28:14'),
	(7, '58efef04678a45.53163815', 'Tizimin', 'Tizimín es uno de los 106 municipios del estado mexicano de Yucatán. Tizimín es una ciudad ubicada en el municipio del mismo nombre, la cual se encuentra en la región noreste de Yucatán.', '', '9931735377', 21.14431056, -88.15067711, 3.000, 'https://www.facebook.com/SouvenirsAR/', 'https://twitter.com/Scan_Share', 'https://www.instagram.com/scanandshare/', 'https://www.youtube.com/watch?v=fqMZr1b4das', 1, 0, 'http://www.scan-share.com.mx/', '2017-04-13 23:35:00', '2017-04-13 23:35:00'),
	(8, '58eff121398415.90759382', 'Plaza Grande', 'Buen lugar para relajarse y pasar el rato con la familia, al rededor se pueden encontrar varios restaurantes, heladerías y demás cosas por hacer.', 'jojocojo@hotmail.com', '', 20.96709961, -89.62373021, 0.060, 'https://www.facebook.com/SouvenirsAR/', '', 'https://www.instagram.com/scanandshare/', 'https://www.youtube.com/watch?v=fqMZr1b4das', 1, 0, '', '2017-04-13 23:44:01', '2017-04-13 23:44:01'),
	(9, '58f0f9efadbf18.57057852', 'Ruinas de Uxmal', 'Es una antigua ciudad maya del periodo clásico. En la actualidad es uno de los más importantes yacimientos arqueológicos de la cultura maya, junto con los de Chichén Itzá y Tikal. Está localizada en el municipio de Santa Elena en el estado de Yucatán.', '', '9931735377', 20.35983571, -89.76789894, 1.800, '', 'https://twitter.com/Scan_Share', 'https://www.instagram.com/scanandshare/', '', 1, 0, 'http://www.scan-share.com.mx/', '2017-04-14 18:33:51', '2017-04-14 18:33:51'),
	(10, '58f0fb83726a63.96858498', 'Postal Principal Scan-Share', 'Mándanos tu Foto o video de tu viaje y sorpréndete con nuestros productos que HABLAN y cuentan Historias…TUS HISTORIAS', 'jojocojo@hotmail.com', '9931735377', 1.00000000, 1.00000000, 9.999, 'https://www.facebook.com/SouvenirsAR/', 'https://twitter.com/Scan_Share', 'https://www.instagram.com/scanandshare/', 'https://www.youtube.com/watch?v=fqMZr1b4das', 1, 0, 'http://www.scan-share.com.mx/', '2017-04-14 18:40:35', '2017-04-14 18:40:35');

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `birthdate` date DEFAULT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role_id` int(10) unsigned NOT NULL DEFAULT '2',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_role_id_foreign` (`role_id`),
  CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `users` (`id`, `name`, `lastname`, `email`, `birthdate`, `password`, `salt`, `remember_token`, `created_at`, `updated_at`, `role_id`) VALUES
	(17, 'José Joaquin', 'Contreras Jorge', 'jojocojo@msn.com', '1992-03-28', '$2y$12$2xzwcQ7TQV9JhI7wBfFukOeOecUHWaZcKKoga9L6ZRqR1nxUVDcLa', '$2y$12$2xzwcQ7TQV9JhI7wBfFukT', NULL, '2017-03-29 17:22:17', '2017-04-18 06:15:58', 1),
	(23, 'Luis', 'Lavalle', 'luis@hotmail.com', '2017-03-01', '$2y$12$RrahpVNB9rkB7TuDPBa4peRbPStYr/JWxk7nvr7qBO8nclMN9Am5.', '$2y$12$RrahpVNB9rkB7TuDPBa4pr', NULL, '2017-03-29 17:26:36', '2017-03-29 17:26:36', 2),
	(24, 'David Eduardo', 'Solis Leon', 'daed.solis@gmail.com', '1995-03-01', '$2y$12$V8Fzsk5fcoNmJPdObVZxx.Ic7W5TREgphrO7DLYwowSo88mzFuFG2', '$2y$12$V8Fzsk5fcoNmJPdObVZxxL', NULL, '2017-05-10 19:11:22', '2017-05-10 19:11:22', 1);

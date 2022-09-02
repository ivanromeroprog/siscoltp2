-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-09-2022 a las 13:32:37
-- Versión del servidor: 10.5.15-MariaDB-cll-lve
-- Versión de PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `siscoltp2`
--
CREATE DATABASE IF NOT EXISTS `siscoltp2` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `siscoltp2`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `id` int(11) NOT NULL,
  `dni` varchar(9) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellido` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefono` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `direccion` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`id`, `dni`, `nombre`, `apellido`, `telefono`, `direccion`) VALUES
(17, '15258655', 'Juan Pablo', 'Casella', '0323-15585759', 'pcas@gmail.com'),
(18, '74859996', 'Ivan', 'Mayorga', '0357', 'nadjasjdosdasd'),
(19, '14568569', 'Snico', 'Lucciano', '3554-6548954', 'Muylejos 1256'),
(20, '5874689', 'Miguel', 'Parrilla', '3776-5847569', 'LaCasa 569'),
(21, '82759772', 'Pedro', 'Suarez', '428597165', '25 de Mayo 1502 oeste');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_venta`
--

CREATE TABLE `detalle_venta` (
  `id` int(11) NOT NULL,
  `venta_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `costo_unitario` decimal(11,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `detalle_venta`
--

INSERT INTO `detalle_venta` (`id`, `venta_id`, `producto_id`, `cantidad`, `costo_unitario`) VALUES
(1, 1, 6, 11, '200.00'),
(2, 2, 6, 3, '200.00'),
(3, 3, 7, 2, '420.00'),
(4, 3, 8, 1, '100.00'),
(5, 4, 10, 3, '350.00'),
(6, 5, 10, 1, '350.00'),
(7, 5, 6, 21, '200.00'),
(8, 6, 10, 5, '350.00'),
(9, 7, 8, 2, '100.00'),
(10, 7, 7, 1, '420.00'),
(11, 8, 8, 1, '100.00'),
(12, 8, 7, 1, '420.00'),
(13, 9, 9, 1, '120.00'),
(14, 9, 8, 2, '100.00'),
(15, 9, 12, 5, '120.00'),
(16, 10, 14, 5, '500.00'),
(17, 11, 7, 1, '420.00'),
(18, 11, 6, 1, '200.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `messenger_messages`
--

CREATE TABLE `messenger_messages` (
  `id` bigint(20) NOT NULL,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `available_at` datetime NOT NULL,
  `delivered_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `precio` decimal(11,2) NOT NULL,
  `stock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id`, `nombre`, `descripcion`, `precio`, `stock`) VALUES
(6, '🥤 Vaso de plástico', 'Vaso de plástico marca Pepito Grillo', '200.00', 2),
(7, '☕ Café', 'Un Café', '420.00', 46),
(8, '🥐 Medialuna', 'Y una medialuna...', '100.00', 41),
(9, '🥚 Huevo Duro', 'Huevo Duro Huevo Duro Huevo Duro.', '120.00', 99),
(10, '🍟 Papas Fritas', 'Una Porción de papas fritas.', '350.00', 17),
(11, '🍠Batata', NULL, '50.00', 300),
(12, '🍪 Alfajor', 'Alfajor de chocolate, relleno dulce de leche, marca Guaymallen', '120.00', 45),
(14, '🍪 Galletitas de limón', 'Limón bañadas con chocolate', '500.00', 195);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `username` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dni` varchar(9) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellido` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefono` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `direccion` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `username`, `roles`, `password`, `email`, `dni`, `nombre`, `apellido`, `telefono`, `direccion`) VALUES
(2, 'test', '[\"ROLE_USER\"]', '$2y$13$VT2YjXPhe7rlv0OykZ6LkOiZlwc1bpiCIDsDEuqmkCfBlKQCCiDyS', 'test@test.com', '3256985', 'Nombre', 'Apellido', '1567890', 'Unadirección 456'),
(3, 'admin', '[\"ROLE_USER\"]', '$2y$13$5WSnb2o7NpTqzcB6F77eye98t3Ej0IS1KulL0m1Ms9/hdQagxytSO', 'admin@admin.com', '1212121', 'Admin', 'Admin', '3775-154879', 'Lugar 456'),
(4, 'testsem', '[\"ROLE_USER\"]', '$2y$13$O.ma1ixh7KtRh2.RfXk5kOgNDDs19xv/3iJyAaRtJ2E.mv.8XElHS', 'testsem@test.com', '11111111', 'Test', 'Seminario', '3854-569847', 'LaCasa 256');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta`
--

CREATE TABLE `venta` (
  `id` int(11) NOT NULL,
  `cliente_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `factura` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha` datetime NOT NULL,
  `total` decimal(11,2) NOT NULL,
  `estado` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo_factura` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `venta`
--

INSERT INTO `venta` (`id`, `cliente_id`, `usuario_id`, `factura`, `fecha`, `total`, `estado`, `tipo_factura`) VALUES
(1, 18, 2, '124578945', '2022-08-31 20:44:51', '2200.00', 'Anulada', 'C'),
(2, 18, 2, '132578945', '2022-08-31 20:48:22', '600.00', 'Anulada', 'C'),
(3, 17, 2, '789678945', '2022-08-31 21:03:16', '940.00', 'Normal', 'C'),
(4, 17, 4, '789674575', '2022-08-31 21:17:56', '1050.00', 'Normal', 'C'),
(5, 17, 2, '782348945', '2022-08-31 21:26:49', '4550.00', 'Normal', 'C'),
(6, 17, 2, '789678888', '2022-08-31 23:50:33', '1750.00', 'Normal', 'C'),
(7, 19, 4, '777778888', '2022-09-01 06:20:47', '620.00', 'Anulada', 'C'),
(8, 19, 4, '744778888', '2022-09-01 06:22:40', '520.00', 'Normal', 'C'),
(9, 17, 4, '111178888', '2022-09-01 13:44:52', '920.00', 'Normal', 'C'),
(10, 17, 4, '111178858', '2022-09-01 14:01:20', '2500.00', 'Normal', 'C'),
(11, 17, 2, '45678956', '2022-09-01 23:07:14', '620.00', 'Normal', 'C');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_F41C9B257F8F253B` (`dni`);

--
-- Indices de la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_5191A401F2A5805D` (`venta_id`),
  ADD KEY `IDX_5191A4017645698E` (`producto_id`);

--
-- Indices de la tabla `messenger_messages`
--
ALTER TABLE `messenger_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  ADD KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  ADD KEY `IDX_75EA56E016BA31DB` (`delivered_at`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_2265B05DF85E0677` (`username`),
  ADD UNIQUE KEY `UNIQ_2265B05D7F8F253B` (`dni`),
  ADD UNIQUE KEY `UNIQ_2265B05DE7927C74` (`email`);

--
-- Indices de la tabla `venta`
--
ALTER TABLE `venta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_8FE7EE55DE734E51` (`cliente_id`),
  ADD KEY `IDX_8FE7EE55DB38439E` (`usuario_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `messenger_messages`
--
ALTER TABLE `messenger_messages`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `venta`
--
ALTER TABLE `venta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  ADD CONSTRAINT `FK_5191A4017645698E` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`id`),
  ADD CONSTRAINT `FK_5191A401F2A5805D` FOREIGN KEY (`venta_id`) REFERENCES `venta` (`id`);

--
-- Filtros para la tabla `venta`
--
ALTER TABLE `venta`
  ADD CONSTRAINT `FK_8FE7EE55DB38439E` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`),
  ADD CONSTRAINT `FK_8FE7EE55DE734E51` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

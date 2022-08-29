-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         5.7.33 - MySQL Community Server (GPL)
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Volcando estructura para tabla tp2.cliente
DROP TABLE IF EXISTS `cliente`;
CREATE TABLE IF NOT EXISTS `cliente` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dni` varchar(9) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellido` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefono` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `direccion` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_F41C9B257F8F253B` (`dni`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla tp2.cliente: ~1 rows (aproximadamente)
DELETE FROM `cliente`;
INSERT INTO `cliente` (`id`, `dni`, `nombre`, `apellido`, `telefono`, `direccion`) VALUES
	(16, '123123555', 'sdfsdfsdfsdf', 'peoloco', NULL, 'José Pascual Arce 448');

-- Volcando estructura para tabla tp2.detalle_venta
DROP TABLE IF EXISTS `detalle_venta`;
CREATE TABLE IF NOT EXISTS `detalle_venta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `venta_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `costo_unitario` decimal(11,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_5191A401F2A5805D` (`venta_id`),
  KEY `IDX_5191A4017645698E` (`producto_id`),
  CONSTRAINT `FK_5191A4017645698E` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`id`),
  CONSTRAINT `FK_5191A401F2A5805D` FOREIGN KEY (`venta_id`) REFERENCES `venta` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla tp2.detalle_venta: ~0 rows (aproximadamente)
DELETE FROM `detalle_venta`;

-- Volcando estructura para tabla tp2.doctrine_migration_versions
DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Volcando datos para la tabla tp2.doctrine_migration_versions: ~3 rows (aproximadamente)
DELETE FROM `doctrine_migration_versions`;
INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
	('DoctrineMigrations\\Version20220818235735', '2022-08-18 23:58:15', 485),
	('DoctrineMigrations\\Version20220819000312', '2022-08-19 00:03:32', 84),
	('DoctrineMigrations\\Version20220822190242', '2022-08-22 19:03:56', 141);

-- Volcando estructura para tabla tp2.messenger_messages
DROP TABLE IF EXISTS `messenger_messages`;
CREATE TABLE IF NOT EXISTS `messenger_messages` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `available_at` datetime NOT NULL,
  `delivered_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  KEY `IDX_75EA56E016BA31DB` (`delivered_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla tp2.messenger_messages: ~0 rows (aproximadamente)
DELETE FROM `messenger_messages`;

-- Volcando estructura para tabla tp2.producto
DROP TABLE IF EXISTS `producto`;
CREATE TABLE IF NOT EXISTS `producto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` longtext COLLATE utf8mb4_unicode_ci,
  `precio` decimal(11,2) NOT NULL,
  `stock` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla tp2.producto: ~4 rows (aproximadamente)
DELETE FROM `producto`;
INSERT INTO `producto` (`id`, `nombre`, `descripcion`, `precio`, `stock`) VALUES
	(1, 'cosacoperte', NULL, 100.20, 0),
	(2, 'Cosa', 'Una Cosa', 125.00, 10),
	(3, 'Cosalala', '4a5sd4as5d44a5sd4as5d44a5sd4as5d44a5sd4as5d44a5sd4as5aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa4a5sd4as5d44a5sd4as5d44a5sd4as5d44a5sd4as5d44a5sd4as5d44a5sd4as5d44a5sd4as5d44a5sd4as5d44a5sd4as5d44a5sd4as5d44a5sd4as5d44a5sd4as5d44a5sd4as5d44a5sd4as5d44a5sd4as5d44a5sd4as5d44a5sd4as5d44a5sd4as5d44a5sd4as5d44a5sd4as5d44a5sd4as5d44a5sd4as5d44a5sd4as5d44a5sd4as5d4', 1522.00, 25),
	(4, 'rty rty rt y', NULL, 100.00, 110);

-- Volcando estructura para tabla tp2.usuario
DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dni` varchar(9) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellido` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefono` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `direccion` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_2265B05DF85E0677` (`username`),
  UNIQUE KEY `UNIQ_2265B05D7F8F253B` (`dni`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla tp2.usuario: ~2 rows (aproximadamente)
DELETE FROM `usuario`;
INSERT INTO `usuario` (`id`, `username`, `roles`, `password`, `email`, `dni`, `nombre`, `apellido`, `telefono`, `direccion`) VALUES
	(2, 'test', '["ROLE_USER"]', '$2y$13$VT2YjXPhe7rlv0OykZ6LkOiZlwc1bpiCIDsDEuqmkCfBlKQCCiDyS', 'test@test.com', '3256985', 'Nombre', 'Apellido', '1567890', 'una dirección'),
	(3, 'admin', '["ROLE_USER"]', '$2y$13$4Y2gLxxTAh.wqWXITesH6.FlXUVxWk4iCA6QU.z1BHXrHCROcZsgO', 'asdasdasd@asdasd.com', 'asdasdasd', 'asdasdasd', 'asdasdasd', NULL, NULL);

-- Volcando estructura para tabla tp2.venta
DROP TABLE IF EXISTS `venta`;
CREATE TABLE IF NOT EXISTS `venta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cliente_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `factura` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha` datetime NOT NULL,
  `total` decimal(11,2) NOT NULL,
  `estado` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_8FE7EE55DE734E51` (`cliente_id`),
  KEY `IDX_8FE7EE55DB38439E` (`usuario_id`),
  CONSTRAINT `FK_8FE7EE55DB38439E` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`),
  CONSTRAINT `FK_8FE7EE55DE734E51` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla tp2.venta: ~0 rows (aproximadamente)
DELETE FROM `venta`;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;

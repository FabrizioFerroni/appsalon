DROP DATABASE IF EXISTS `appsalon_mvc`;
CREATE DATABASE IF NOT EXISTS `appsalon_mvc` DEFAULT CHARACTER SET utf8;
USE `appsalon_mvc`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(60) NOT NULL,
  `apellido` VARCHAR(60) NOT NULL,
  `email` VARCHAR(100) NOT NULL UNIQUE,
  `password` VARCHAR(60) NOT NULL,
  `telefono` VARCHAR(15) NOT NULL,
  `admin` TINYINT(1) NOT NULL DEFAULT 0,
  `confirmado` TINYINT(1) NOT NULL DEFAULT 0,
  `token` VARCHAR(30) NULL,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;
CREATE TABLE IF NOT EXISTS `servicios` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(60) NOT NULL,
  `precio` DECIMAL(16, 2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;
CREATE TABLE IF NOT EXISTS `citas` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `fecha` DATE NOT NULL,
  `hora` Time NOT NULL,
  `usuarioId` INT(11) NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_citas_usuarios` FOREIGN KEY (`usuarioId`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE = InnoDB;
CREATE TABLE IF NOT EXISTS `citasservicios` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `citaId` INT(11)  NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_citasservicios_citas` FOREIGN KEY (`citaId`) REFERENCES `citas` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  `servicioId` INT(11) NULL,
  CONSTRAINT `fk_citasservicios_servicios` FOREIGN KEY (`servicioId`) REFERENCES `servicios` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE = InnoDB;
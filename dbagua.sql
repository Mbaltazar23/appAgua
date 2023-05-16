-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema dbagualuna
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema dbagualuna
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `dbagualuna` DEFAULT CHARACTER SET utf8 ;
USE `dbagualuna` ;

-- -----------------------------------------------------
-- Table `dbagualuna`.`repartidor`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbagualuna`.`repartidor` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NOT NULL,
  `ocupacion` TEXT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dbagualuna`.`producto`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbagualuna`.`producto` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(50) NULL,
  `precio` DOUBLE NOT NULL,
  `stock` INT NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dbagualuna`.`cliente`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbagualuna`.`cliente` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(50) NOT NULL,
  `empresa` VARCHAR(50) NOT NULL,
  `domicilio` VARCHAR(45) NOT NULL,
  `telefono` VARCHAR(15) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dbagualuna`.`orden`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbagualuna`.`orden` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `tipo` VARCHAR(50) NOT NULL,
  `fecha` VARCHAR(60) NULL,
  `repartidor_id` INT NOT NULL,
  `cliente_id` INT NOT NULL,
  `total` DOUBLE NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_orden_Repartidor1_idx` (`repartidor_id` ASC),
  INDEX `fk_orden_cliente1_idx` (`cliente_id` ASC),
  CONSTRAINT `fk_orden_Repartidor1`
    FOREIGN KEY (`repartidor_id`)
    REFERENCES `dbagualuna`.`repartidor` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_orden_cliente1`
    FOREIGN KEY (`cliente_id`)
    REFERENCES `dbagualuna`.`cliente` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dbagualuna`.`detalle_orden`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbagualuna`.`detalle_orden` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `fecha` VARCHAR(50) NULL,
  `orden_id` INT NOT NULL,
  `producto_id` INT NOT NULL,
  `stock` INT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_orden_producto1_idx` (`producto_id` ASC),
  INDEX `fk_detalle_orden_orden1_idx` (`orden_id` ASC),
  CONSTRAINT `fk_orden_producto1`
    FOREIGN KEY (`producto_id`)
    REFERENCES `dbagualuna`.`producto` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_detalle_orden_orden1`
    FOREIGN KEY (`orden_id`)
    REFERENCES `dbagualuna`.`orden` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;
-- Volcando datos para la tabla dbagualuna.cliente: ~4 rows (aproximadamente)
INSERT INTO `cliente` (`id`, `nombre`, `empresa`, `domicilio`, `telefono`) VALUES
	(1, 'juan', 'pepesuarez', 'domingo de 45', '+56934234534'),
	(2, 'guille', 'globax', 'cuarentaine', '+56975745575'),
	(3, 'topo', 'yunia', 'cuaresma', '+56945342345'),
	(4, 'diego', 'coca cola', 'katarsis', '+56975353365');

-- Volcando datos para la tabla dbagualuna.producto: ~2 rows (aproximadamente)
INSERT INTO `producto` (`id`, `nombre`, `precio`, `stock`) VALUES
	(1, 'Recarga 2 LT', 1800, 104),
	(2, 'Botella 500 cc', 600, 182);

-- Volcando datos para la tabla dbagualuna.repartidor: ~2 rows (aproximadamente)
INSERT INTO `repartidor` (`id`, `nombre`, `ocupacion`) VALUES
	(1, 'Centro', 'sectores urbanos'),
	(2, 'Lipigas', 'sectores rusticos');

-- Volcando datos para la tabla dbagualuna.orden: ~5 rows (aproximadamente)
INSERT INTO `orden` (`id`, `nro`, `tipo`, `fecha`, `repartidor_id`, `cliente_id`, `total`) VALUES
	(2, '2388', 'Guia', '2023-05-12 15:02:04', 1, 4, 2400),
	(3, '1621', 'Recarga Gratis', '2023-05-12 15:21:10', 2, 1, 9600),
	(4, '2866', 'Factura', '2023-05-12 15:23:36', 1, 4, 6600),
	(5, '9785', 'Factura', '2023-05-12 15:32:19', 2, 3, 7800),
	(6, '6123', 'Recarga Gratis', '2023-05-15 11:44:15', 1, 4, 9000),
	(7, '7303', 'Guia', '2023-05-16 18:46:33', 1, 2, 3000);
	
-- Volcando datos para la tabla dbagualuna.detalle_orden: ~10 rows (aproximadamente)
INSERT INTO `detalle_orden` (`id`, `fecha`, `orden_id`, `producto_id`, `stock`) VALUES
	(3, '2023-05-12 15:02:04', 2, 1, 1),
	(4, '2023-05-12 15:02:04', 2, 2, 1),
	(5, '2023-05-12 15:21:10', 3, 1, 4),
	(6, '2023-05-12 15:21:10', 3, 2, 4),
	(7, '2023-05-12 15:23:36', 4, 1, 3),
	(8, '2023-05-12 15:23:36', 4, 2, 2),
	(9, '2023-05-12 15:32:19', 5, 1, 3),
	(10, '2023-05-12 15:32:19', 5, 2, 4),
	(11, '2023-05-15 11:44:15', 6, 1, 4),
	(12, '2023-05-15 11:44:15', 6, 2, 3),
	(13, '2023-05-16 18:46:33', 7, 1, 1),
	(14, '2023-05-16 18:46:33', 7, 2, 2);

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;


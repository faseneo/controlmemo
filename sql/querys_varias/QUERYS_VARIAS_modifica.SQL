-- MySQL Workbench Synchronization
-- Generated: 2018-04-12 10:39
-- Model: New Model
-- Version: 1.0
-- Project: Name of the project
-- Author: Francisco

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

ALTER TABLE `controlmemo`.`memo_detalle` 
ADD COLUMN `memo_det_cc_codigo` INT(11) NOT NULL AFTER `memo_det_memo_id`,
DROP PRIMARY KEY,
ADD PRIMARY KEY (`memo_det_id`, `memo_det_proc_compra_id`, `memo_det_proveedor_id`, `memo_det_memo_detalle_estado_id`, `memo_det_memo_id`, `memo_det_cc_codigo`),
ADD INDEX `fk_memo_detalle_centro_costos1_idx` (`memo_det_cc_codigo` ASC);

ALTER TABLE `controlmemo`.`memo_detalle_estado` 
CHANGE COLUMN `memo_detalle_prioridad` `memo_detalle_prioridad` TINYINT(4) NOT NULL ;

ALTER TABLE `controlmemo`.`memo_estado` 
CHANGE COLUMN `memo_prioridad` `memo_prioridad` TINYINT(4) NOT NULL ;

ALTER TABLE `controlmemo`.`procedimiento_compra` 
ADD COLUMN `proc_prioridad` TINYINT(4) NOT NULL AFTER `proc_compra_tipo`;

CREATE TABLE IF NOT EXISTS `controlmemo`.`centro_costos` (
  `cc_codigo` INT(11) NOT NULL,
  `cc_nombre` VARCHAR(150) NULL DEFAULT NULL,
  `cc_dependencia_codigo` INT(11) NOT NULL,
  PRIMARY KEY (`cc_codigo`, `cc_dependencia_codigo`),
  INDEX `fk_centro_costos_dependencia1_idx` (`cc_dependencia_codigo` ASC),
  CONSTRAINT `fk_centro_costos_dependencia1`
    FOREIGN KEY (`cc_dependencia_codigo`)
    REFERENCES `controlmemo`.`dependencia` (`dependencia_codigo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

ALTER TABLE `controlmemo`.`memo_detalle` 
ADD CONSTRAINT `fk_memo_detalle_centro_costos1`
  FOREIGN KEY (`memo_det_cc_codigo`)
  REFERENCES `controlmemo`.`centro_costos` (`cc_codigo`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
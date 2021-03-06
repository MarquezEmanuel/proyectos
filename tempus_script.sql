-- MySQL Script generated by MySQL Workbench
-- 05/10/20 19:00:02
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema tempus
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema tempus
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `tempus` DEFAULT CHARACTER SET utf8 ;
USE `tempus` ;

-- -----------------------------------------------------
-- Table `tempus`.`asignatura`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tempus`.`asignatura` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nombreCorto` VARCHAR(10) NOT NULL,
  `nombreLargo` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `nombre_corto_UNIQUE` (`nombreCorto` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tempus`.`carrera`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tempus`.`carrera` (
  `id` VARCHAR(3) NOT NULL,
  `nombreCorto` VARCHAR(10) NOT NULL,
  `nombreLargo` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `nombre_largo_UNIQUE` (`nombreLargo` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tempus`.`aula`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tempus`.`aula` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(50) NOT NULL,
  `sector` VARCHAR(5) NOT NULL,
  PRIMARY KEY (`id`),
UNIQUE INDEX `nombre_sector_UNIQUE` (`sector`, `nombre`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tempus`.`docente`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tempus`.`docente` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `nombre_UNIQUE` (`nombre` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tempus`.`mesa_examen`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tempus`.`mesa_examen` (
  `id` INT NOT NULL,
  `idAsignatura` INT NOT NULL,
  `fechaCreacion` DATETIME NOT NULL,
  `observacion` VARCHAR(300) NULL,
  PRIMARY KEY (`id`, `idAsignatura`),
  INDEX `fk_mesa_examen_asignatura1_idx` (`idAsignatura` ASC),
  CONSTRAINT `fk_mesa_examen_asignatura1`
    FOREIGN KEY (`idAsignatura`)
    REFERENCES `tempus`.`asignatura` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tempus`.`carrera_mesa_examen`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tempus`.`carrera_mesa_examen` (
  `idCarrera` VARCHAR(3) NOT NULL,
  `idMesaExamen` INT NOT NULL,
  PRIMARY KEY (`idCarrera`, `idMesaExamen`),
  INDEX `fk_carrera_has_mesa_examen_mesa_examen1_idx` (`idMesaExamen` ASC),
  INDEX `fk_carrera_has_mesa_examen_carrera_idx` (`idCarrera` ASC),
  CONSTRAINT `fk_carrera_has_mesa_examen_carrera`
    FOREIGN KEY (`idCarrera`)
    REFERENCES `tempus`.`carrera` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_carrera_has_mesa_examen_mesa_examen1`
    FOREIGN KEY (`idMesaExamen`)
    REFERENCES `tempus`.`mesa_examen` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tempus`.`cursada`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tempus`.`cursada` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `idAsignatura` INT NOT NULL,
  `idCarrera` VARCHAR(3) NOT NULL,
  `anio` INT NOT NULL,
  `fechaCreacion` DATETIME NOT NULL,
  `observacion` VARCHAR(300) NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_cursada_carrera1_idx` (`idCarrera` ASC),
  INDEX `fk_cursada_asignatura1_idx` (`idAsignatura` ASC),
  CONSTRAINT `fk_cursada_carrera1`
    FOREIGN KEY (`idCarrera`)
    REFERENCES `tempus`.`carrera` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_cursada_asignatura1`
    FOREIGN KEY (`idAsignatura`)
    REFERENCES `tempus`.`asignatura` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tempus`.`tribunal`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tempus`.`tribunal` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `idPresidente` INT NOT NULL,
  `idVocal1` INT NOT NULL,
  `idVocal2` INT NULL,
  `idSuplente` INT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_tribunal_docente1_idx` (`idPresidente` ASC),
  INDEX `fk_tribunal_docente2_idx` (`idVocal1` ASC),
  INDEX `fk_tribunal_docente3_idx` (`idVocal2` ASC),
  INDEX `fk_tribunal_docente4_idx` (`idSuplente` ASC),
  CONSTRAINT `fk_tribunal_docente1`
    FOREIGN KEY (`idPresidente`)
    REFERENCES `tempus`.`docente` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tribunal_docente2`
    FOREIGN KEY (`idVocal1`)
    REFERENCES `tempus`.`docente` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tribunal_docente3`
    FOREIGN KEY (`idVocal2`)
    REFERENCES `tempus`.`docente` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tribunal_docente4`
    FOREIGN KEY (`idSuplente`)
    REFERENCES `tempus`.`docente` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tempus`.`llamado`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tempus`.`llamado` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `idAula` INT NOT NULL,
  `idMesaExamen` INT NOT NULL,
  `idTribunal` INT NOT NULL,
  `fecha` DATE NOT NULL,
  `fechaModificacion` DATETIME NULL,
  `hora` TIME NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_llamado_mesa_examen1_idx` (`idMesaExamen` ASC),
  INDEX `fk_llamado_tribunal1_idx` (`idTribunal` ASC),
  INDEX `fk_llamado_aula1_idx` (`idAula` ASC),
  CONSTRAINT `fk_llamado_mesa_examen1`
    FOREIGN KEY (`idMesaExamen`)
    REFERENCES `tempus`.`mesa_examen` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_llamado_tribunal1`
    FOREIGN KEY (`idTribunal`)
    REFERENCES `tempus`.`tribunal` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_llamado_aula1`
    FOREIGN KEY (`idAula`)
    REFERENCES `tempus`.`aula` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tempus`.`clase`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tempus`.`clase` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `idAula` INT NOT NULL,
  `idCursada` INT NOT NULL,
  `diaSemana` ENUM('1', '2', '3', '4', '5', '6', '7') NOT NULL DEFAULT '1',
  `horaInicio` TIME NOT NULL,
  `horaFin` TIME NOT NULL,
  `fechaModificacion` DATETIME NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_clase_cursada1_idx` (`idCursada` ASC),
  INDEX `fk_clase_aula1_idx` (`idAula` ASC),
  CONSTRAINT `fk_clase_cursada1`
    FOREIGN KEY (`idCursada`)
    REFERENCES `tempus`.`cursada` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_clase_aula1`
    FOREIGN KEY (`idAula`)
    REFERENCES `tempus`.`aula` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tempus`.`rol`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tempus`.`rol` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `nombre_UNIQUE` (`nombre` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tempus`.`permiso`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tempus`.`permiso` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `nombre_UNIQUE` (`nombre` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tempus`.`usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tempus`.`usuario` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(255) NOT NULL,
  `nombre` VARCHAR(255) NOT NULL,
  `metodo_login` VARCHAR(25) NOT NULL,
  `estado` ENUM('Activo', 'Inactivo') NOT NULL DEFAULT 'Activo',
  PRIMARY KEY (`id`),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tempus`.`rol_permiso`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tempus`.`rol_permiso` (
  `rol_id` INT NOT NULL,
  `permiso_id` INT NOT NULL,
  PRIMARY KEY (`rol_id`, `permiso_id`),
  INDEX `fk_rol_has_permiso_permiso1_idx` (`permiso_id` ASC),
  INDEX `fk_rol_has_permiso_rol1_idx` (`rol_id` ASC),
  CONSTRAINT `fk_rol_has_permiso_rol1`
    FOREIGN KEY (`rol_id`)
    REFERENCES `tempus`.`rol` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_rol_has_permiso_permiso1`
    FOREIGN KEY (`permiso_id`)
    REFERENCES `tempus`.`permiso` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tempus`.`rol_usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tempus`.`rol_usuario` (
  `rol_id` INT NOT NULL,
  `usuario_id` INT NOT NULL,
  PRIMARY KEY (`rol_id`, `usuario_id`),
  INDEX `fk_rol_has_usuario_usuario1_idx` (`usuario_id` ASC),
  INDEX `fk_rol_has_usuario_rol1_idx` (`rol_id` ASC),
  CONSTRAINT `fk_rol_has_usuario_rol1`
    FOREIGN KEY (`rol_id`)
    REFERENCES `tempus`.`rol` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_rol_has_usuario_usuario1`
    FOREIGN KEY (`usuario_id`)
    REFERENCES `tempus`.`usuario` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tempus`.`usuario_manual`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tempus`.`usuario_manual` (
  `usuario_id` INT NOT NULL,
  `clave` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`usuario_id`),
  INDEX `fk_usuario_manual_usuario1_idx` (`usuario_id` ASC),
  CONSTRAINT `fk_usuario_manual_usuario1`
    FOREIGN KEY (`usuario_id`)
    REFERENCES `tempus`.`usuario` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tempus`.`usuario_google`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tempus`.`usuario_google` (
  `usuario_id` INT NOT NULL,
  `google_id` VARCHAR(255) NULL,
  `imagen` VARCHAR(500) NULL,
  PRIMARY KEY (`usuario_id`),
  INDEX `fk_usuario_google_usuario1_idx` (`usuario_id` ASC),
  CONSTRAINT `fk_usuario_google_usuario1`
    FOREIGN KEY (`usuario_id`)
    REFERENCES `tempus`.`usuario` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

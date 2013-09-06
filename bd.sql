SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

DROP SCHEMA IF EXISTS `consultorio`;

CREATE SCHEMA IF NOT EXISTS `consultorio` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish2_ci ;
USE `consultorio` ;

-- -----------------------------------------------------
-- Table `consultorio`.`departamento`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `consultorio`.`departamento` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(45) NOT NULL ,
  `creacion` DATETIME NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `consultorio`.`municipio`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `consultorio`.`municipio` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(45) NOT NULL ,
  `iddepartamento` INT NOT NULL ,
  `creacion` DATETIME NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_municipio_departamento_idx` (`iddepartamento` ASC) ,
  CONSTRAINT `fk_municipio_departamento`
    FOREIGN KEY (`iddepartamento` )
    REFERENCES `consultorio`.`departamento` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `consultorio`.`paciente`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `consultorio`.`paciente` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nombres` VARCHAR(45) NOT NULL ,
  `apellidos` VARCHAR(45) NOT NULL ,
  `fecha_nacimiento` DATE NOT NULL ,
  `peso` DECIMAL NULL ,
  `altura` DECIMAL NULL ,
  `genero` INT NULL ,
  `idmunicipio` INT NULL ,
  `direccion` VARCHAR(255) NULL ,
  `telefono` VARCHAR(45) NULL ,
  `celular` VARCHAR(45) NULL ,
  `dui` VARCHAR(45) NULL ,
  `nit` VARCHAR(45) NULL ,
  `alergias` VARCHAR(255) NULL ,
  `tipo_sangre` VARCHAR(45) NULL ,
  `usuario` VARCHAR(45) NOT NULL ,
  `contrasena` VARCHAR(45) NOT NULL ,
  `estado` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_paciente_municipio_idx` (`idmunicipio` ASC) ,
  CONSTRAINT `fk_paciente_municipio`
    FOREIGN KEY (`idmunicipio` )
    REFERENCES `consultorio`.`municipio` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `consultorio`.`cargo`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `consultorio`.`cargo` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(45) NOT NULL ,
  `creacion` DATETIME NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `consultorio`.`especialidad`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `consultorio`.`especialidad` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(45) NOT NULL ,
  `creacion` DATETIME NOT NULL ,
  PRIMARY KEY (`id`, `creacion`, `nombre`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `consultorio`.`empleado`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `consultorio`.`empleado` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nombres` VARCHAR(45) NOT NULL ,
  `apellidos` VARCHAR(45) NOT NULL ,
  `fecha_nacimiento` DATE NOT NULL ,
  `genero` INT NOT NULL ,
  `idmunicipio` INT NOT NULL ,
  `direccion` VARCHAR(255) NULL ,
  `telefono` VARCHAR(45) NULL ,
  `celular` VARCHAR(45) NULL ,
  `dui` VARCHAR(45) NULL ,
  `nit` VARCHAR(45) NULL ,
  `idcargo` INT NOT NULL ,
  `idespecialidad` INT NOT NULL ,
  `creacion` DATETIME NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_empleado_municipio_idx` (`idmunicipio` ASC) ,
  INDEX `fk_empleado_cargo_idx` (`idcargo` ASC) ,
  INDEX `fk_empleado_especialidad_idx` (`idespecialidad` ASC) ,
  CONSTRAINT `fk_empleado_municipio`
    FOREIGN KEY (`idmunicipio` )
    REFERENCES `consultorio`.`municipio` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_empleado_cargo`
    FOREIGN KEY (`idcargo` )
    REFERENCES `consultorio`.`cargo` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_empleado_especialidad`
    FOREIGN KEY (`idespecialidad` )
    REFERENCES `consultorio`.`especialidad` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `consultorio`.`cita`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `consultorio`.`cita` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `idpaciente` INT NOT NULL ,
  `fecha` DATETIME NOT NULL ,
  `estado` INT NOT NULL ,
  `idempleado` INT NOT NULL ,
  `creacion` DATETIME NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_cita_paciente_idx` (`idpaciente` ASC) ,
  INDEX `fk_cita_empleado_idx` (`idempleado` ASC) ,
  CONSTRAINT `fk_cita_paciente`
    FOREIGN KEY (`idpaciente` )
    REFERENCES `consultorio`.`paciente` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_cita_empleado`
    FOREIGN KEY (`idempleado` )
    REFERENCES `consultorio`.`empleado` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `consultorio`.`consulta`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `consultorio`.`consulta` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `descripcion` VARCHAR(255) NOT NULL ,
  `diagnostico` VARCHAR(900) NOT NULL ,
  `idcita` INT NOT NULL ,
  `creacion` DATETIME NOT NULL ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `fk_consulta_cita`
    FOREIGN KEY (`id` )
    REFERENCES `consultorio`.`cita` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `consultorio`.`receta`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `consultorio`.`receta` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `idconsulta` INT NOT NULL ,
  `descripcion` VARCHAR(255) NULL ,
  `creacion` DATETIME NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_receta_consulta_idx` (`idconsulta` ASC) ,
  CONSTRAINT `fk_receta_consulta`
    FOREIGN KEY (`idconsulta` )
    REFERENCES `consultorio`.`consulta` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `consultorio`.`marca`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `consultorio`.`marca` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(45) NOT NULL ,
  `creacion` DATETIME NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `consultorio`.`medicina`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `consultorio`.`medicina` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(45) NOT NULL ,
  `descripcion` VARCHAR(255) NOT NULL ,
  `precio_unidad` DECIMAL NULL ,
  `idmarca` INT NOT NULL ,
  `existencia_minima` INT NULL ,
  `creacion` DATETIME NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_medicina_marca_idx` (`idmarca` ASC) ,
  CONSTRAINT `fk_medicina_marca`
    FOREIGN KEY (`idmarca` )
    REFERENCES `consultorio`.`marca` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `consultorio`.`detalle_receta`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `consultorio`.`detalle_receta` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `idreceta` INT NOT NULL ,
  `idmedicina` INT NOT NULL ,
  `creacion` DATETIME NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_medicina_receta_medicina_idx` (`idmedicina` ASC) ,
  INDEX `fk_medicina_receta_receta_idx` (`idreceta` ASC) ,
  CONSTRAINT `fk_medicina_receta_medicina`
    FOREIGN KEY (`idmedicina` )
    REFERENCES `consultorio`.`medicina` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_medicina_receta_receta`
    FOREIGN KEY (`idreceta` )
    REFERENCES `consultorio`.`receta` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `consultorio`.`producto_servicio`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `consultorio`.`producto_servicio` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(45) NOT NULL ,
  `descripcion` VARCHAR(255) NOT NULL ,
  `idmedicina` INT NOT NULL ,
  `precio` DECIMAL NOT NULL ,
  `tipo` ENUM('producto','servicio') NOT NULL ,
  `creacion` DATETIME NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_productos_servicios_medicina_idx` (`idmedicina` ASC) ,
  CONSTRAINT `fk_productos_servicios_medicina`
    FOREIGN KEY (`idmedicina` )
    REFERENCES `consultorio`.`medicina` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `consultorio`.`proveedor`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `consultorio`.`proveedor` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(45) NOT NULL ,
  `telefono` VARCHAR(45) NULL ,
  `correo` VARCHAR(45) NULL ,
  `direccion` VARCHAR(255) NULL ,
  `idmunicipio` INT NOT NULL ,
  `creacion` DATETIME NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_proveedor_municipio_idx` (`idmunicipio` ASC) ,
  CONSTRAINT `fk_proveedor_municipio`
    FOREIGN KEY (`idmunicipio` )
    REFERENCES `consultorio`.`municipio` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `consultorio`.`pago`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `consultorio`.`pago` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `idproveedor` INT NOT NULL ,
  `total` DECIMAL NOT NULL ,
  `numero_factura` VARCHAR(45) NOT NULL ,
  `fecha` DATE NOT NULL ,
  `creacion` DATETIME NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_pago_proveedor_idx` (`idproveedor` ASC) ,
  CONSTRAINT `fk_pago_proveedor`
    FOREIGN KEY (`idproveedor` )
    REFERENCES `consultorio`.`proveedor` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `consultorio`.`entrada`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `consultorio`.`entrada` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `idmedicina` INT NOT NULL ,
  `cantidad` DECIMAL NOT NULL ,
  `lote` VARCHAR(45) NULL ,
  `fecha_vencimiento` DATETIME NOT NULL ,
  `idpago` INT NOT NULL ,
  `estado` INT NOT NULL ,
  `total` DECIMAL NULL ,
  `creacion` DATETIME NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_entrada_medicina_idx` (`idmedicina` ASC) ,
  INDEX `fk_entrada_pago_idx` (`idpago` ASC) ,
  CONSTRAINT `fk_entrada_medicina`
    FOREIGN KEY (`idmedicina` )
    REFERENCES `consultorio`.`medicina` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_entrada_pago`
    FOREIGN KEY (`idpago` )
    REFERENCES `consultorio`.`pago` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `consultorio`.`devolucion`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `consultorio`.`devolucion` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `descripcion` VARCHAR(255) NOT NULL ,
  `identrada` INT NOT NULL ,
  `creacion` DATETIME NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_devolucion_entrada_idx` (`identrada` ASC) ,
  CONSTRAINT `fk_devolucion_entrada`
    FOREIGN KEY (`identrada` )
    REFERENCES `consultorio`.`entrada` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `consultorio`.`factura`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `consultorio`.`factura` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `fecha` DATE NOT NULL ,
  `descripcion` VARCHAR(255) NOT NULL ,
  `cantidad` INT NULL ,
  `total` DECIMAL NOT NULL ,
  `nombres_cliente` VARCHAR(255) NOT NULL ,
  `apellidos_cliente` VARCHAR(255) NOT NULL ,
  `tipo` INT NOT NULL ,
  `registro` VARCHAR(45) NULL ,
  `creacion` DATETIME NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `consultorio`.`detalle_factura`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `consultorio`.`detalle_factura` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `idfactura` INT NOT NULL ,
  `idproducto_servicio` INT NOT NULL ,
  `cantidad` INT NOT NULL ,
  `precio_unidad` DECIMAL NOT NULL ,
  `total` DECIMAL NOT NULL ,
  `creacion` DATETIME NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_detalle_factura_producto_servicio_idx` (`idproducto_servicio` ASC) ,
  INDEX `fk_detalle_factura_factura_idx` (`idfactura` ASC) ,
  CONSTRAINT `fk_detalle_factura_producto_servicio`
    FOREIGN KEY (`idproducto_servicio` )
    REFERENCES `consultorio`.`producto_servicio` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_detalle_factura_factura`
    FOREIGN KEY (`idfactura` )
    REFERENCES `consultorio`.`factura` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `consultorio`.`salida`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `consultorio`.`salida` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `idmedicina` INT NOT NULL ,
  `cantidad` INT NOT NULL ,
  `idfactura` INT NOT NULL ,
  `creacion` DATETIME NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_salida_medicina_idx` (`idmedicina` ASC) ,
  INDEX `fk_salida_factura_idx` (`idfactura` ASC) ,
  CONSTRAINT `fk_salida_medicina`
    FOREIGN KEY (`idmedicina` )
    REFERENCES `consultorio`.`medicina` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_salida_factura`
    FOREIGN KEY (`idfactura` )
    REFERENCES `consultorio`.`factura` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `consultorio`.`usuario`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `consultorio`.`usuario` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `cuenta` VARCHAR(45) NOT NULL ,
  `contrasena` VARCHAR(45) NOT NULL ,
  `rol` VARCHAR(45) NULL ,
  `idempleado` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `idempleado_UNIQUE` (`idempleado` ASC) ,
  CONSTRAINT `fk_usuario_empleado`
    FOREIGN KEY (`idempleado` )
    REFERENCES `consultorio`.`empleado` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

USE `consultorio` ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

INSERT INTO `departamento`(`id`,`nombre`,`creacion`) VALUES(1,'La Libertad',NOW());
INSERT INTO `municipio`(`id`,`nombre`,`iddepartamento`,`creacion`) VALUES(1,'Santa Tecla',1,NOW());
INSERT INTO `cargo`(`id`,`nombre`,`creacion`) VALUES(1,'Doctor',NOW());
INSERT INTO `especialidad`(`id`,`nombre`,`creacion`) VALUES(1,'Dentista',NOW());
INSERT INTO `empleado`(`id`,`nombres`,`apellidos`,`fecha_nacimiento`,`genero`,`idmunicipio`,`idcargo`,`idespecialidad`,`creacion`) VALUES(1,'Arturo','Cerna','1970-02-04',1,1,1,1,NOW());
INSERT INTO `usuario`(`id`,`cuenta`,`contrasena`,`rol`,`idempleado`) VALUES(1,'g3rcar',md5('test'),'ADMIN',1);


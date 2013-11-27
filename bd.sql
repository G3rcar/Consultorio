SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

DROP SCHEMA IF EXISTS `consultorio` ;
CREATE SCHEMA IF NOT EXISTS `consultorio` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `consultorio` ;

-- -----------------------------------------------------
-- Table `consultorio`.`login`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `consultorio`.`login` ;

CREATE  TABLE IF NOT EXISTS `consultorio`.`login` (
  `log_id` INT(8) NOT NULL AUTO_INCREMENT ,
  `log_usr` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_spanish2_ci' NOT NULL ,
  `log_pss` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_spanish2_ci' NOT NULL ,
  `log_est` VARCHAR(1) CHARACTER SET 'utf8' COLLATE 'utf8_spanish2_ci' NOT NULL ,
  PRIMARY KEY (`log_id`) )
ENGINE = InnoDB
AUTO_INCREMENT = 2;


-- -----------------------------------------------------
-- Table `consultorio`.`acceso`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `consultorio`.`acceso` ;

CREATE  TABLE IF NOT EXISTS `consultorio`.`acceso` (
  `acc_id` INT(8) NOT NULL AUTO_INCREMENT ,
  `acc_ult` DATETIME NOT NULL ,
  `acc_idlog` INT(8) NOT NULL ,
  PRIMARY KEY (`acc_id`) ,
  INDEX `fk_acceso_login_idx` (`acc_idlog` ASC) ,
  CONSTRAINT `fk_acceso_login`
    FOREIGN KEY (`acc_idlog` )
    REFERENCES `consultorio`.`login` (`log_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 5
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_spanish2_ci;


-- -----------------------------------------------------
-- Table `consultorio`.`cargo`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `consultorio`.`cargo` ;

CREATE  TABLE IF NOT EXISTS `consultorio`.`cargo` (
  `car_id` INT(8) NOT NULL AUTO_INCREMENT ,
  `car_es_doctor` ENUM('true','false') CHARACTER SET 'utf8' COLLATE 'utf8_spanish2_ci' NOT NULL DEFAULT 'false' ,
  `car_nom` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_spanish2_ci' NOT NULL ,
  `car_fecha_cre` DATETIME NOT NULL ,
  PRIMARY KEY (`car_id`) )
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_spanish2_ci;


-- -----------------------------------------------------
-- Table `consultorio`.`pais`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `consultorio`.`pais` ;

CREATE  TABLE IF NOT EXISTS `consultorio`.`pais` (
  `pai_id` INT(8) NOT NULL AUTO_INCREMENT ,
  `pai_nom` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_spanish2_ci' NOT NULL ,
  `pai_fecha_cre` DATETIME NOT NULL ,
  PRIMARY KEY (`pai_id`) )
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_spanish2_ci;


-- -----------------------------------------------------
-- Table `consultorio`.`departamento`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `consultorio`.`departamento` ;

CREATE  TABLE IF NOT EXISTS `consultorio`.`departamento` (
  `dep_id` INT(8) NOT NULL AUTO_INCREMENT ,
  `dep_nom` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_spanish2_ci' NOT NULL ,
  `dep_idpai` INT(8) NOT NULL ,
  `dep_fecha_cre` DATETIME NOT NULL ,
  PRIMARY KEY (`dep_id`) ,
  INDEX `fk_departamento_pais_idx` (`dep_idpai` ASC) ,
  CONSTRAINT `fk_departamento_pais`
    FOREIGN KEY (`dep_idpai` )
    REFERENCES `consultorio`.`pais` (`pai_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_spanish2_ci;


-- -----------------------------------------------------
-- Table `consultorio`.`municipio`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `consultorio`.`municipio` ;

CREATE  TABLE IF NOT EXISTS `consultorio`.`municipio` (
  `mun_id` INT(8) NOT NULL AUTO_INCREMENT ,
  `mun_nom` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_spanish2_ci' NOT NULL ,
  `mun_iddep` INT(8) NOT NULL ,
  `mun_fecha_crea` DATETIME NOT NULL ,
  PRIMARY KEY (`mun_id`) ,
  INDEX `fk_municipio_departamento_idx` (`mun_iddep` ASC) ,
  CONSTRAINT `fk_municipio_departamento`
    FOREIGN KEY (`mun_iddep` )
    REFERENCES `consultorio`.`departamento` (`dep_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_spanish2_ci;


-- -----------------------------------------------------
-- Table `consultorio`.`direccion`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `consultorio`.`direccion` ;

CREATE  TABLE IF NOT EXISTS `consultorio`.`direccion` (
  `dir_id` INT(8) NOT NULL AUTO_INCREMENT ,
  `dir_cond` VARCHAR(20) CHARACTER SET 'utf8' COLLATE 'utf8_spanish2_ci' NULL DEFAULT NULL ,
  `dir_cond2` VARCHAR(20) CHARACTER SET 'utf8' COLLATE 'utf8_spanish2_ci' NULL DEFAULT NULL ,
  `dir_calle` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_spanish2_ci' NOT NULL ,
  `dir_compcalle` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_spanish2_ci' NULL DEFAULT NULL ,
  `dir_casa` VARCHAR(10) CHARACTER SET 'utf8' COLLATE 'utf8_spanish2_ci' NULL DEFAULT NULL ,
  `dir_col` VARCHAR(20) CHARACTER SET 'utf8' COLLATE 'utf8_spanish2_ci' NULL DEFAULT NULL ,
  `dir_dist` VARCHAR(20) CHARACTER SET 'utf8' COLLATE 'utf8_spanish2_ci' NULL DEFAULT NULL ,
  `dir_ref` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_spanish2_ci' NULL DEFAULT NULL ,
  `dir_fecha_cre` DATETIME NOT NULL ,
  `dir_idmun` INT(8) NOT NULL ,
  PRIMARY KEY (`dir_id`) ,
  INDEX `fk_direccion_municipio_idx` (`dir_idmun` ASC) ,
  CONSTRAINT `fk_direccion_municipio`
    FOREIGN KEY (`dir_idmun` )
    REFERENCES `consultorio`.`municipio` (`mun_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_spanish2_ci;


-- -----------------------------------------------------
-- Table `consultorio`.`sucursal`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `consultorio`.`sucursal` ;

CREATE  TABLE IF NOT EXISTS `consultorio`.`sucursal` (
  `suc_id` INT(8) NOT NULL AUTO_INCREMENT ,
  `suc_nom` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_spanish2_ci' NOT NULL ,
  `suc_iddir` INT(8) NOT NULL ,
  PRIMARY KEY (`suc_id`) ,
  INDEX `fk_sucursal_direccion_idx` (`suc_iddir` ASC) ,
  CONSTRAINT `fk_sucursal_direccion`
    FOREIGN KEY (`suc_iddir` )
    REFERENCES `consultorio`.`direccion` (`dir_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_spanish2_ci;


-- -----------------------------------------------------
-- Table `consultorio`.`empleado`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `consultorio`.`empleado` ;

CREATE  TABLE IF NOT EXISTS `consultorio`.`empleado` (
  `emp_id` INT(8) NOT NULL AUTO_INCREMENT ,
  `emp_nom` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_spanish2_ci' NOT NULL ,
  `emp_ape` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_spanish2_ci' NOT NULL ,
  `emp_fecha_nac` DATE NOT NULL ,
  `emp_gen` ENUM('M','F') CHARACTER SET 'utf8' COLLATE 'utf8_spanish2_ci' NOT NULL ,
  `emp_fecha_cre` DATETIME NOT NULL ,
  `emp_idsuc` INT(8) NOT NULL ,
  `emp_idcar` INT(8) NOT NULL ,
  `emp_iddir` INT(8) NOT NULL ,
  `login_log_id` INT(8) NOT NULL ,
  PRIMARY KEY (`emp_id`) ,
  INDEX `fk_empleado_cargo_idx` (`emp_idcar` ASC) ,
  INDEX `fk_empleado_direccion_idx` (`emp_iddir` ASC) ,
  INDEX `fk_empleado_sucursal_idx` (`emp_idsuc` ASC) ,
  INDEX `fk_empleado_login1_idx` (`login_log_id` ASC) ,
  CONSTRAINT `fk_empleado_cargo`
    FOREIGN KEY (`emp_idcar` )
    REFERENCES `consultorio`.`cargo` (`car_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_empleado_direccion`
    FOREIGN KEY (`emp_iddir` )
    REFERENCES `consultorio`.`direccion` (`dir_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_empleado_sucursal`
    FOREIGN KEY (`emp_idsuc` )
    REFERENCES `consultorio`.`sucursal` (`suc_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_empleado_login1`
    FOREIGN KEY (`login_log_id` )
    REFERENCES `consultorio`.`login` (`log_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 2;


-- -----------------------------------------------------
-- Table `consultorio`.`tipo_sangre`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `consultorio`.`tipo_sangre` ;

CREATE  TABLE IF NOT EXISTS `consultorio`.`tipo_sangre` (
  `tps_id` INT(8) NOT NULL AUTO_INCREMENT ,
  `tps_tipo_san` VARCHAR(15) CHARACTER SET 'utf8' COLLATE 'utf8_spanish2_ci' NOT NULL ,
  `tps_fecha_crea` DATETIME NULL ,
  PRIMARY KEY (`tps_id`) )
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_spanish2_ci;


-- -----------------------------------------------------
-- Table `consultorio`.`paciente`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `consultorio`.`paciente` ;

CREATE  TABLE IF NOT EXISTS `consultorio`.`paciente` (
  `pac_id` INT(8) NOT NULL AUTO_INCREMENT ,
  `pac_nom` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_spanish2_ci' NOT NULL ,
  `pac_ape` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_spanish2_ci' NOT NULL ,
  `pac_fecha_nac` DATE NOT NULL ,
  `pac_peso` DECIMAL(8,2) NULL DEFAULT NULL ,
  `pac_alt` DECIMAL(8,2) NULL DEFAULT NULL ,
  `pac_gen` ENUM('M','F') CHARACTER SET 'utf8' COLLATE 'utf8_spanish2_ci' NOT NULL ,
  `pac_ale` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_spanish2_ci' NULL DEFAULT NULL ,
  `pac_est` VARCHAR(1) CHARACTER SET 'utf8' COLLATE 'utf8_spanish2_ci' NOT NULL ,
  `pac_iddir` INT(8) NOT NULL ,
  `pac_idtps` INT(8) NOT NULL ,
  `pac_correo` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_spanish2_ci' NULL ,
  `pac_contrasena` VARCHAR(45) NULL ,
  `pac_fecha_cre` DATETIME NOT NULL ,
  PRIMARY KEY (`pac_id`) ,
  INDEX `fk_paciente_direccion_idx` (`pac_iddir` ASC) ,
  INDEX `fk_paciente_tipo_sangre_idx` (`pac_idtps` ASC) ,
  CONSTRAINT `fk_paciente_direccion`
    FOREIGN KEY (`pac_iddir` )
    REFERENCES `consultorio`.`direccion` (`dir_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_paciente_tipo_sangre`
    FOREIGN KEY (`pac_idtps` )
    REFERENCES `consultorio`.`tipo_sangre` (`tps_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 1;


-- -----------------------------------------------------
-- Table `consultorio`.`solicitud_cita`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `consultorio`.`solicitud_cita` ;

CREATE  TABLE IF NOT EXISTS `consultorio`.`solicitud_cita` (
  `slc_id` INT(8) NOT NULL AUTO_INCREMENT ,
  `slc_desc` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_spanish2_ci' NOT NULL ,
  `slc_fecha_sol` DATETIME NOT NULL ,
  `slc_idpac` INT(8) NOT NULL ,
  `slc_fecha_cre` DATETIME NOT NULL ,
  PRIMARY KEY (`slc_id`) ,
  INDEX `fk_solicitud_cita_paciente_idx` (`slc_idpac` ASC) ,
  CONSTRAINT `fk_solicitud_cita_paciente`
    FOREIGN KEY (`slc_idpac` )
    REFERENCES `consultorio`.`paciente` (`pac_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_spanish2_ci;


-- -----------------------------------------------------
-- Table `consultorio`.`cita`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `consultorio`.`cita` ;

CREATE  TABLE IF NOT EXISTS `consultorio`.`cita` (
  `cit_id` INT(8) NOT NULL AUTO_INCREMENT ,
  `cit_fecha_cita` DATETIME NOT NULL ,
  `cit_com` VARCHAR(50) CHARACTER SET 'utf8' COLLATE 'utf8_spanish2_ci' NULL DEFAULT NULL ,
  `cit_estado` VARCHAR(1) CHARACTER SET 'utf8' COLLATE 'utf8_spanish2_ci' NOT NULL ,
  `cit_fecha_cre` DATETIME NOT NULL ,
  `cit_idemp` INT(8) NOT NULL ,
  `cit_idsuc` INT(8) NOT NULL ,
  `cit_idpac` INT(8) NOT NULL ,
  `cit_idslc` INT(8) NULL ,
  PRIMARY KEY (`cit_id`) ,
  INDEX `fk_cita_empleado_idx` (`cit_idemp` ASC) ,
  INDEX `fk_cita_sucursal_idx` (`cit_idsuc` ASC) ,
  INDEX `fk_cita_paciente_idx` (`cit_idpac` ASC) ,
  INDEX `fk_cita_solicitud_idx` (`cit_idslc` ASC) ,
  CONSTRAINT `fk_cita_empleado`
    FOREIGN KEY (`cit_idemp` )
    REFERENCES `consultorio`.`empleado` (`emp_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_cita_paciente`
    FOREIGN KEY (`cit_idpac` )
    REFERENCES `consultorio`.`paciente` (`pac_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_cita_sucursal`
    FOREIGN KEY (`cit_idsuc` )
    REFERENCES `consultorio`.`sucursal` (`suc_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_cita_solicitud`
    FOREIGN KEY (`cit_idslc` )
    REFERENCES `consultorio`.`solicitud_cita` (`slc_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_spanish2_ci;


-- -----------------------------------------------------
-- Table `consultorio`.`consulta`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `consultorio`.`consulta` ;

CREATE  TABLE IF NOT EXISTS `consultorio`.`consulta` (
  `con_id` INT(8) NOT NULL AUTO_INCREMENT ,
  `con_desc` VARCHAR(50) CHARACTER SET 'utf8' COLLATE 'utf8_spanish2_ci' NOT NULL ,
  `con_diag` VARCHAR(50) CHARACTER SET 'utf8' COLLATE 'utf8_spanish2_ci' NOT NULL ,
  `con_fecha_cre` DATETIME NOT NULL ,
  `con_idcit` INT(8) NOT NULL ,
  PRIMARY KEY (`con_id`) ,
  INDEX `fk_consulta_cita_idx` (`con_idcit` ASC) ,
  CONSTRAINT `fk_consulta_cita`
    FOREIGN KEY (`con_idcit` )
    REFERENCES `consultorio`.`cita` (`cit_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_spanish2_ci;


-- -----------------------------------------------------
-- Table `consultorio`.`facturacion`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `consultorio`.`facturacion` ;

CREATE  TABLE IF NOT EXISTS `consultorio`.`facturacion` (
  `fac_id` INT(8) NOT NULL AUTO_INCREMENT ,
  `fac_desc` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_spanish2_ci' NOT NULL ,
  `fac_fecha` DATE NOT NULL ,
  `fac_dir` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_spanish2_ci' NULL ,
  `fac_can` DOUBLE(8,2) NOT NULL ,
  `fac_tot` DOUBLE(8,2) NOT NULL ,
  `fac_nom_cli` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_spanish2_ci' NOT NULL ,
  `fac_ape_cli` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_spanish2_ci' NOT NULL ,
  `fac_tipo` VARCHAR(10) CHARACTER SET 'utf8' COLLATE 'utf8_spanish2_ci' NOT NULL ,
  `fac_registro` VARCHAR(10) CHARACTER SET 'utf8' COLLATE 'utf8_spanish2_ci' NULL ,
  `fac_idsuc` INT(8) NOT NULL ,
  `fac_fecha_cre` DATETIME NOT NULL ,
  PRIMARY KEY (`fac_id`) ,
  INDEX `fk_facturacion_sucursal_idx` (`fac_idsuc` ASC) ,
  CONSTRAINT `fk_facturacion_sucursal`
    FOREIGN KEY (`fac_idsuc` )
    REFERENCES `consultorio`.`sucursal` (`suc_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_spanish2_ci;


-- -----------------------------------------------------
-- Table `consultorio`.`marca`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `consultorio`.`marca` ;

CREATE  TABLE IF NOT EXISTS `consultorio`.`marca` (
  `mar_id` INT(8) NOT NULL AUTO_INCREMENT ,
  `mar_nom` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_spanish2_ci' NOT NULL ,
  PRIMARY KEY (`mar_id`) )
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_spanish2_ci;


-- -----------------------------------------------------
-- Table `consultorio`.`producto_categoria`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `consultorio`.`producto_categoria` ;

CREATE  TABLE IF NOT EXISTS `consultorio`.`producto_categoria` (
  `cat_id` INT(8) NOT NULL AUTO_INCREMENT ,
  `cat_nombre` INT(11) NOT NULL ,
  `cat_descripcion` INT(11) NOT NULL ,
  PRIMARY KEY (`cat_id`) )
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_spanish2_ci;


-- -----------------------------------------------------
-- Table `consultorio`.`producto`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `consultorio`.`producto` ;

CREATE  TABLE IF NOT EXISTS `consultorio`.`producto` (
  `pro_id` INT(8) NOT NULL AUTO_INCREMENT ,
  `pro_nom` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_spanish2_ci' NOT NULL ,
  `pro_salant_uni` INT(8) NOT NULL ,
  `pro_salant_mon` DOUBLE(8,2) NOT NULL ,
  `pro_costo_uni` DOUBLE(8,2) NOT NULL ,
  `pro_ult_cost` DOUBLE(8,2) NOT NULL ,
  `pro_existencia` INT(8) NOT NULL ,
  `pro_cant_min` INT(4) NOT NULL ,
  `pro_ult_ven` DATE NULL ,
  `pro_idsuc` INT(8) NOT NULL ,
  `pro_idmar` INT(8) NOT NULL ,
  `pro_fecha_venc` DATE NULL ,
  `producto_categoria_cat_id` INT(8) NOT NULL ,
  `pro_ubicacion` VARCHAR(45) NULL ,
  `pro_fila` VARCHAR(3) NULL ,
  `pro_fecha_cre` DATETIME NOT NULL ,
  PRIMARY KEY (`pro_id`, `producto_categoria_cat_id`) ,
  INDEX `fk_producto_sucursal_idx` (`pro_idsuc` ASC) ,
  INDEX `fk_producto_marca_idx` (`pro_idmar` ASC) ,
  INDEX `fk_producto_producto_categoria1_idx` (`producto_categoria_cat_id` ASC) ,
  CONSTRAINT `fk_producto_marca`
    FOREIGN KEY (`pro_idmar` )
    REFERENCES `consultorio`.`marca` (`mar_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_producto_sucursal`
    FOREIGN KEY (`pro_idsuc` )
    REFERENCES `consultorio`.`sucursal` (`suc_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_producto_producto_categoria1`
    FOREIGN KEY (`producto_categoria_cat_id` )
    REFERENCES `consultorio`.`producto_categoria` (`cat_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 1;


-- -----------------------------------------------------
-- Table `consultorio`.`detalle_facturacion`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `consultorio`.`detalle_facturacion` ;

CREATE  TABLE IF NOT EXISTS `consultorio`.`detalle_facturacion` (
  `dtf_id` INT(8) NOT NULL AUTO_INCREMENT ,
  `dtf_can` INT(8) NOT NULL ,
  `dtf_pre_uni` DOUBLE(8,2) NOT NULL ,
  `dtf_tot` DOUBLE(8,2) NOT NULL ,
  `dtf_idfac` INT(8) NOT NULL ,
  `dtf_idpro` INT(8) NOT NULL ,
  `dtf_fecha_cre` DATETIME NOT NULL ,
  PRIMARY KEY (`dtf_id`) ,
  INDEX `fk_detalle_facturacion_factura_idx` (`dtf_idfac` ASC) ,
  INDEX `fk_detalle_facturacion_producto_idx` (`dtf_idpro` ASC) ,
  CONSTRAINT `fk_detalle_facturacion_factura`
    FOREIGN KEY (`dtf_idfac` )
    REFERENCES `consultorio`.`facturacion` (`fac_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_detalle_facturacion_producto`
    FOREIGN KEY (`dtf_idpro` )
    REFERENCES `consultorio`.`producto` (`pro_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_spanish2_ci;


-- -----------------------------------------------------
-- Table `consultorio`.`receta`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `consultorio`.`receta` ;

CREATE  TABLE IF NOT EXISTS `consultorio`.`receta` (
  `rec_id` INT(8) NOT NULL AUTO_INCREMENT ,
  `rec_desc` VARCHAR(50) CHARACTER SET 'utf8' COLLATE 'utf8_spanish2_ci' NOT NULL ,
  `rec_idcon` INT(8) NOT NULL ,
  `rec_fecha_cre` DATETIME NOT NULL ,
  PRIMARY KEY (`rec_id`) ,
  INDEX `fk_receta_consulta_idx` (`rec_idcon` ASC) ,
  CONSTRAINT `fk_receta_consulta`
    FOREIGN KEY (`rec_idcon` )
    REFERENCES `consultorio`.`consulta` (`con_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_spanish2_ci;


-- -----------------------------------------------------
-- Table `consultorio`.`detalle_receta`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `consultorio`.`detalle_receta` ;

CREATE  TABLE IF NOT EXISTS `consultorio`.`detalle_receta` (
  `dtr_id` INT(8) NOT NULL AUTO_INCREMENT ,
  `dtr_idrec` INT(8) NOT NULL ,
  `dtr_desc` VARCHAR(50) CHARACTER SET 'utf8' COLLATE 'utf8_spanish2_ci' NOT NULL ,
  `dtr_fecha_cre` DATETIME NOT NULL ,
  PRIMARY KEY (`dtr_id`) ,
  INDEX `fk_detalle_receta_receta_idx` (`dtr_idrec` ASC) ,
  CONSTRAINT `fk_detalle_receta_receta`
    FOREIGN KEY (`dtr_idrec` )
    REFERENCES `consultorio`.`receta` (`rec_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_spanish2_ci;


-- -----------------------------------------------------
-- Table `consultorio`.`tipo_documento`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `consultorio`.`tipo_documento` ;

CREATE  TABLE IF NOT EXISTS `consultorio`.`tipo_documento` (
  `tip_id` INT(8) NOT NULL AUTO_INCREMENT ,
  `tip_nom` VARCHAR(20) CHARACTER SET 'utf8' COLLATE 'utf8_spanish2_ci' NOT NULL ,
  `tip_fecha_crea` DATETIME NOT NULL ,
  PRIMARY KEY (`tip_id`) )
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_spanish2_ci;


-- -----------------------------------------------------
-- Table `consultorio`.`documento`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `consultorio`.`documento` ;

CREATE  TABLE IF NOT EXISTS `consultorio`.`documento` (
  `doc_id` INT(8) NOT NULL AUTO_INCREMENT ,
  `doc_num` VARCHAR(20) CHARACTER SET 'utf8' COLLATE 'utf8_spanish2_ci' NOT NULL ,
  `doc_idtipo_doc` INT(8) NOT NULL ,
  PRIMARY KEY (`doc_id`) ,
  INDEX `fk_documento_tipodocumento_idx` (`doc_idtipo_doc` ASC) ,
  CONSTRAINT `fk_documento_tipodocumento`
    FOREIGN KEY (`doc_idtipo_doc` )
    REFERENCES `consultorio`.`tipo_documento` (`tip_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 1;


-- -----------------------------------------------------
-- Table `consultorio`.`historico_producto`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `consultorio`.`historico_producto` ;

CREATE  TABLE IF NOT EXISTS `consultorio`.`historico_producto` (
  `hsp_periodo` INT(8) NOT NULL AUTO_INCREMENT ,
  `hsp_mes` INT(8) NOT NULL ,
  `hsp_ult_cost` DOUBLE(8,2) NOT NULL ,
  `hsp_sal_uni` INT(8) NOT NULL ,
  `hsp_sal_mon` DOUBLE(8,2) NOT NULL ,
  `hsp_cos_uni` DOUBLE(8,2) NOT NULL ,
  `hsp_idpro` INT(8) NOT NULL ,
  `hsp_idsuc` INT(8) NOT NULL ,
  PRIMARY KEY (`hsp_periodo`, `hsp_mes`) ,
  INDEX `fk_historico_producto_producto_idx` (`hsp_idpro` ASC) ,
  INDEX `fk_historico_producto_sucursal_idx` (`hsp_idsuc` ASC) ,
  CONSTRAINT `fk_historico_producto_producto`
    FOREIGN KEY (`hsp_idpro` )
    REFERENCES `consultorio`.`producto` (`pro_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_historico_producto_sucursal`
    FOREIGN KEY (`hsp_idsuc` )
    REFERENCES `consultorio`.`sucursal` (`suc_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_spanish2_ci;


-- -----------------------------------------------------
-- Table `consultorio`.`tipo_movimiento`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `consultorio`.`tipo_movimiento` ;

CREATE  TABLE IF NOT EXISTS `consultorio`.`tipo_movimiento` (
  `tpm_id` INT(8) NOT NULL AUTO_INCREMENT ,
  `tpm_desc` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_spanish2_ci' NOT NULL ,
  `tpm_mov` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_spanish2_ci' NOT NULL ,
  PRIMARY KEY (`tpm_id`) )
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_spanish2_ci;


-- -----------------------------------------------------
-- Table `consultorio`.`movimiento`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `consultorio`.`movimiento` ;

CREATE  TABLE IF NOT EXISTS `consultorio`.`movimiento` (
  `mov_periodo` INT(8) NOT NULL AUTO_INCREMENT ,
  `mov_cos_uni` DOUBLE(8,2) NOT NULL ,
  `mov_fecha` DATE NOT NULL ,
  `mov_uni` INT(8) NOT NULL ,
  `mov_idsuc` INT(8) NOT NULL ,
  `mov_idpro` INT(8) NOT NULL ,
  `mov_idtipo` INT(8) NOT NULL ,
  PRIMARY KEY (`mov_periodo`) ,
  INDEX `fk_movimiento_tipo_idx` (`mov_idtipo` ASC) ,
  INDEX `fk_movimiento_sucursal_idx` (`mov_idsuc` ASC) ,
  INDEX `fk_movimiento_producto_idx` (`mov_idpro` ASC) ,
  CONSTRAINT `fk_movimiento_producto`
    FOREIGN KEY (`mov_idpro` )
    REFERENCES `consultorio`.`producto` (`pro_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_movimiento_sucursal`
    FOREIGN KEY (`mov_idsuc` )
    REFERENCES `consultorio`.`sucursal` (`suc_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_movimiento_tipo`
    FOREIGN KEY (`mov_idtipo` )
    REFERENCES `consultorio`.`tipo_movimiento` (`tpm_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_spanish2_ci;


-- -----------------------------------------------------
-- Table `consultorio`.`responsable`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `consultorio`.`responsable` ;

CREATE  TABLE IF NOT EXISTS `consultorio`.`responsable` (
  `res_id` INT(8) NOT NULL AUTO_INCREMENT ,
  `res_nom` VARCHAR(50) NOT NULL ,
  `res_ape` VARCHAR(50) NOT NULL ,
  `res_correo` VARCHAR(50) NOT NULL ,
  `res_idpac` INT(8) NOT NULL ,
  `res_fecha_crea` DATETIME NOT NULL ,
  PRIMARY KEY (`res_id`) ,
  INDEX `fk_paciente_responsable_paciente1_idx` (`res_idpac` ASC) ,
  CONSTRAINT `fk_paciente_responsable_paciente1`
    FOREIGN KEY (`res_idpac` )
    REFERENCES `consultorio`.`paciente` (`pac_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_spanish2_ci;


-- -----------------------------------------------------
-- Table `consultorio`.`proveedor`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `consultorio`.`proveedor` ;

CREATE  TABLE IF NOT EXISTS `consultorio`.`proveedor` (
  `prv_id` INT(8) NOT NULL AUTO_INCREMENT ,
  `prv_nom` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_spanish2_ci' NOT NULL ,
  `prv_cor` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_spanish2_ci' NULL ,
  `prv_iddir` INT(8) NOT NULL ,
  `prv_fecha_cre` DATETIME NOT NULL ,
  PRIMARY KEY (`prv_id`) ,
  INDEX `fk_proveedor_direccion_idx` (`prv_iddir` ASC) ,
  CONSTRAINT `fk_proveedor_direccion`
    FOREIGN KEY (`prv_iddir` )
    REFERENCES `consultorio`.`direccion` (`dir_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_spanish2_ci;


-- -----------------------------------------------------
-- Table `consultorio`.`rol`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `consultorio`.`rol` ;

CREATE  TABLE IF NOT EXISTS `consultorio`.`rol` (
  `rol_id` INT(8) NOT NULL AUTO_INCREMENT ,
  `rol_nom` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_spanish2_ci' NOT NULL ,
  `rol_desc` VARCHAR(50) CHARACTER SET 'utf8' COLLATE 'utf8_spanish2_ci' NOT NULL ,
  `rol_url` VARCHAR(20) NOT NULL ,
  PRIMARY KEY (`rol_id`) )
ENGINE = InnoDB
AUTO_INCREMENT = 2;


-- -----------------------------------------------------
-- Table `consultorio`.`telefono`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `consultorio`.`telefono` ;

CREATE  TABLE IF NOT EXISTS `consultorio`.`telefono` (
  `tel_id` INT(8) NOT NULL AUTO_INCREMENT ,
  `tel_nom` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_spanish2_ci' NOT NULL ,
  `tel_num` VARCHAR(10) CHARACTER SET 'utf8' COLLATE 'utf8_spanish2_ci' NOT NULL ,
  `tel_fecha_cre` DATETIME NOT NULL ,
  PRIMARY KEY (`tel_id`) )
ENGINE = InnoDB
AUTO_INCREMENT = 1;


-- -----------------------------------------------------
-- Table `consultorio`.`proveedor_telefono`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `consultorio`.`proveedor_telefono` ;

CREATE  TABLE IF NOT EXISTS `consultorio`.`proveedor_telefono` (
  `prtel_id` INT(8) NOT NULL ,
  `prtel_idtel` INT(8) NOT NULL ,
  `prtel_idprv` INT(8) NOT NULL ,
  PRIMARY KEY (`prtel_id`) ,
  INDEX `fk_telefono_proveedor_telefono1_idx` (`prtel_idtel` ASC) ,
  INDEX `fk_telefono_proveedor_proveedor1_idx` (`prtel_idprv` ASC) ,
  CONSTRAINT `fk_telefono_proveedor_telefono1`
    FOREIGN KEY (`prtel_idtel` )
    REFERENCES `consultorio`.`telefono` (`tel_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_telefono_proveedor_proveedor1`
    FOREIGN KEY (`prtel_idprv` )
    REFERENCES `consultorio`.`proveedor` (`prv_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COMMENT = '   ';


-- -----------------------------------------------------
-- Table `consultorio`.`empleado_documento`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `consultorio`.`empleado_documento` ;

CREATE  TABLE IF NOT EXISTS `consultorio`.`empleado_documento` (
  `edoc_id` INT(8) NOT NULL AUTO_INCREMENT ,
  `edoc_iddoc` INT(8) NOT NULL ,
  `edoc_idemp` INT(8) NOT NULL ,
  INDEX `fk_empleado_documento_empleado1_idx` (`edoc_idemp` ASC) ,
  INDEX `fk_documento_documento_idx` (`edoc_iddoc` ASC) ,
  PRIMARY KEY (`edoc_id`) ,
  CONSTRAINT `fk_edocumento_empleado`
    FOREIGN KEY (`edoc_idemp` )
    REFERENCES `consultorio`.`empleado` (`emp_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_edocumento_documento`
    FOREIGN KEY (`edoc_iddoc` )
    REFERENCES `consultorio`.`documento` (`doc_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `consultorio`.`empleado_telefono`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `consultorio`.`empleado_telefono` ;

CREATE  TABLE IF NOT EXISTS `consultorio`.`empleado_telefono` (
  `etel_id` INT(8) NOT NULL AUTO_INCREMENT ,
  `etel_idemp` INT(8) NOT NULL ,
  `etel_idtel` INT(8) NOT NULL ,
  PRIMARY KEY (`etel_id`) ,
  INDEX `fk_empleado_telefono_empleado1_idx` (`etel_idemp` ASC) ,
  INDEX `fk_empleado_telefono_telefono1_idx` (`etel_idtel` ASC) ,
  CONSTRAINT `fk_telefono_empleado`
    FOREIGN KEY (`etel_idemp` )
    REFERENCES `consultorio`.`empleado` (`emp_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_etelefono_telefono`
    FOREIGN KEY (`etel_idtel` )
    REFERENCES `consultorio`.`telefono` (`tel_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `consultorio`.`paciente_documento`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `consultorio`.`paciente_documento` ;

CREATE  TABLE IF NOT EXISTS `consultorio`.`paciente_documento` (
  `pdoc_id` INT(8) NOT NULL AUTO_INCREMENT ,
  `pdoc_iddoc` INT(8) NOT NULL ,
  `pdoc_idpac` INT(8) NOT NULL ,
  PRIMARY KEY (`pdoc_id`) ,
  INDEX `fk_paciente_documento_documento1_idx` (`pdoc_iddoc` ASC) ,
  INDEX `fk_paciente_documento_paciente1_idx` (`pdoc_idpac` ASC) ,
  CONSTRAINT `fk_pdocumento_documento`
    FOREIGN KEY (`pdoc_iddoc` )
    REFERENCES `consultorio`.`documento` (`doc_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_pdocumento_paciente`
    FOREIGN KEY (`pdoc_idpac` )
    REFERENCES `consultorio`.`paciente` (`pac_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `consultorio`.`responsable_documento`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `consultorio`.`responsable_documento` ;

CREATE  TABLE IF NOT EXISTS `consultorio`.`responsable_documento` (
  `rdoc_id` INT(8) NOT NULL AUTO_INCREMENT ,
  `rdoc_idres` INT(8) NOT NULL ,
  `rdoc_iddoc` INT(8) NOT NULL ,
  PRIMARY KEY (`rdoc_id`) ,
  INDEX `fk_paciente_responsable_documento_paciente_responsable1_idx` (`rdoc_idres` ASC) ,
  INDEX `fk_documento_documento_idx` (`rdoc_iddoc` ASC) ,
  CONSTRAINT `fk_rdocumento_responsable`
    FOREIGN KEY (`rdoc_idres` )
    REFERENCES `consultorio`.`responsable` (`res_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_rdocumento_documento`
    FOREIGN KEY (`rdoc_iddoc` )
    REFERENCES `consultorio`.`documento` (`doc_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `consultorio`.`paciente_telefono`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `consultorio`.`paciente_telefono` ;

CREATE  TABLE IF NOT EXISTS `consultorio`.`paciente_telefono` (
  `ptel_id` INT(8) NOT NULL AUTO_INCREMENT ,
  `ptel_idtel` INT(8) NOT NULL ,
  `ptel_idpac` INT(8) NOT NULL ,
  PRIMARY KEY (`ptel_id`) ,
  INDEX `fk_paciente_telefono_telefono1_idx` (`ptel_idtel` ASC) ,
  INDEX `fk_paciente_telefono_paciente1_idx` (`ptel_idpac` ASC) ,
  CONSTRAINT `fk_ptelefono_telefono`
    FOREIGN KEY (`ptel_idtel` )
    REFERENCES `consultorio`.`telefono` (`tel_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ptelefono_paciente`
    FOREIGN KEY (`ptel_idpac` )
    REFERENCES `consultorio`.`paciente` (`pac_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `consultorio`.`login_rol`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `consultorio`.`login_rol` ;

CREATE  TABLE IF NOT EXISTS `consultorio`.`login_rol` (
  `log_rol_id` INT(8) NOT NULL AUTO_INCREMENT ,
  `log_idlog` INT(8) NOT NULL ,
  `rol_idrol` INT(8) NOT NULL ,
  PRIMARY KEY (`log_rol_id`) ,
  INDEX `fk_login_rol_login1_idx` (`log_idlog` ASC) ,
  INDEX `fk_login_rol_rol1_idx` (`rol_idrol` ASC) ,
  CONSTRAINT `fk_login_login`
    FOREIGN KEY (`log_idlog` )
    REFERENCES `consultorio`.`login` (`log_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_login_rol`
    FOREIGN KEY (`rol_idrol` )
    REFERENCES `consultorio`.`rol` (`rol_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `consultorio`.`no_disponibilidad`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `consultorio`.`no_disponibilidad` ;

CREATE  TABLE IF NOT EXISTS `consultorio`.`no_disponibilidad` (
  `nod_id` INT(8) NOT NULL AUTO_INCREMENT ,
  `nod_dia` INT(8) NOT NULL ,
  `nod_hora_ini` TIME NOT NULL ,
  `nod_hora_fin` TIME NOT NULL ,
  `nod_fecha_cre` DATETIME NOT NULL ,
  `nod_idemp` INT(8) NOT NULL ,
  PRIMARY KEY (`nod_id`) ,
  INDEX `fk_nodisponibilidad_empleado_idx` (`nod_idemp` ASC) ,
  CONSTRAINT `fk_nodisponibilidad_empleado`
    FOREIGN KEY (`nod_idemp` )
    REFERENCES `consultorio`.`empleado` (`emp_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

USE `consultorio` ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;







INSERT INTO `pais`(`pai_id`,`pai_nom`,`pai_fecha_cre`) VALUES(1,'El Salvador',NOW());
INSERT INTO `departamento`(`dep_id`,`dep_nom`,`dep_idpai`,`dep_fecha_cre`) VALUES(1,'La Libertad',1,NOW());
INSERT INTO `municipio`(`mun_id`,`mun_nom`,`mun_iddep`,`mun_fecha_crea`) VALUES(1,'Santa Tecla',1,NOW());



INSERT INTO `cargo` VALUES (1,'true','Doctor','2013-10-13 22:47:27'),
  (2,'true','Dentista','0000-00-00 00:00:00'),
  (3,'false','Secretaria','0000-00-00 00:00:00');

INSERT INTO `direccion` VALUES (1,NULL,NULL,'Central',NULL,NULL,NULL,NULL,NULL,'2013-10-13 22:47:26',1),
(2,NULL,NULL,'Colonia',NULL,NULL,NULL,NULL,NULL,'2013-10-13 22:47:27',1),
(3,NULL,NULL,'Sanlo',NULL,NULL,NULL,NULL,NULL,'0000-00-00 00:00:00',1);




INSERT INTO `rol`(`rol_id`,`rol_nom`,`rol_desc`,`rol_url`) VALUES(1,'Departamentos','Mantenimiento de departamentos','departamentos.php');

INSERT INTO `login`(`log_id`,`log_usr`,`log_pss`,`log_est`) VALUES(1,'admin',md5('admin'),'a');
INSERT INTO `login`(`log_id`,`log_usr`,`log_pss`,`log_est`) VALUES(2,'cerna',md5('admin'),'a');
INSERT INTO `login`(`log_id`,`log_usr`,`log_pss`,`log_est`) VALUES(3,'secre',md5('admin'),'a');
INSERT INTO `login_rol`(`log_rol_id`,`log_idlog`,`rol_idrol`) VALUES(1,1,1);



INSERT INTO `sucursal`(`suc_id`,`suc_nom`,`suc_iddir`) VALUES(1,'Armenia',1);
INSERT INTO `empleado`(`emp_id`,`emp_nom`,`emp_ape`,`emp_fecha_nac`,`emp_gen`,`emp_fecha_cre`,`emp_idsuc`,`emp_idcar`,`emp_iddir`,`login_log_id`) 
VALUES (1,'Arturo Emanuel','Cerna Ciguienza','1970-02-04','M','2013-10-13 22:47:27',1,1,2,1),
(3,'César Josué','Alvarado Portillo','1965-01-01','M','2013-11-14 22:35:46',1,2,2,2),
(4,'Julia María','Castro López','1988-04-01','F','2013-11-14 22:39:24',1,3,2,3);




INSERT INTO `tipo_documento` VALUES (4,'DUI',NOW()),(5,'NIT',NOW()),(6,'NUP',NOW());
INSERT INTO `tipo_sangre` VALUES (1,'ORH +',NOW()),(2,'OR H -',NOW());

INSERT INTO `paciente`(`pac_id`,`pac_nom`,`pac_ape`,`pac_fecha_nac`,`pac_peso`,`pac_alt`,`pac_gen`,`pac_ale`,`pac_est`,`pac_iddir`,`pac_idtps`,`pac_correo`,`pac_contrasena`,`pac_fecha_cre`) 
VALUES (1,'Julia','Alcantará','1970-01-10',130.00,180.00,'F',NULL,'a',1,1,'juli.a@alca.com','12345',NOW());

INSERT INTO `cita`(`cit_id`,`cit_fecha_cita`,`cit_com`,`cit_estado`,`cit_fecha_cre`,`cit_idemp`,`cit_idsuc`,`cit_idpac`,`cit_idslc`) 
VALUES (9,'2013-10-17 10:40:00','','a','2013-10-14 22:45:23',1,1,1,NULL),
(10,'2013-10-16 08:40:00','','a','2013-10-19 09:03:23',1,1,1,NULL),
(29,'2013-11-21 08:30:00','','a','2013-11-21 19:56:56',1,1,1,NULL),
(30,'2013-11-23 08:20:00','','a','2013-11-21 22:18:18',1,1,1,NULL),
(31,'2013-11-21 07:00:00','','a','2013-11-21 22:24:23',1,1,1,NULL),
(32,'2013-11-21 07:40:00','','c','2013-11-21 22:24:59',3,1,1,NULL),
(33,'2013-11-21 10:40:00','','a','2013-11-21 22:30:52',3,1,1,NULL),
(34,'2013-11-25 07:40:00','Dolores de cabeza constantes','a','2013-11-25 01:27:54',1,1,1,NULL),
(35,'2013-11-26 08:20:00','','a','2013-11-25 01:56:46',1,1,1,NULL);



INSERT INTO `consulta` VALUES (1,'La paciente vino con problemas respiratorios','Gripe leve, debe reposar por lo menos 3 días','2013-11-25 00:04:01',33);

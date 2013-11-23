<<<<<<< HEAD
-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 19, 2013 at 12:04 PM
-- Server version: 5.5.8
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `consultorio`
--

-- --------------------------------------------------------

--
-- Table structure for table `acceso`
--

CREATE TABLE IF NOT EXISTS `acceso` (
  `acc_id` int(8) NOT NULL AUTO_INCREMENT,
  `acc_ult` datetime NOT NULL,
  `acc_idlog` int(8) NOT NULL,
  PRIMARY KEY (`acc_id`),
  KEY `fk_acceso_login_idx` (`acc_idlog`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `acceso`
--

INSERT INTO `acceso` (`acc_id`, `acc_ult`, `acc_idlog`) VALUES
(1, '2013-10-27 08:56:11', 1),
(2, '2013-11-01 23:32:21', 1),
(3, '2013-11-03 23:17:19', 1),
(4, '2013-11-18 23:48:44', 1);

-- --------------------------------------------------------

--
-- Table structure for table `cargo`
--

CREATE TABLE IF NOT EXISTS `cargo` (
  `car_id` int(8) NOT NULL AUTO_INCREMENT,
  `car_es_doctor` enum('true','false') COLLATE utf8_spanish2_ci NOT NULL DEFAULT 'false',
  `car_nom` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `car_fecha_cre` datetime NOT NULL,
  PRIMARY KEY (`car_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `cargo`
--

INSERT INTO `cargo` (`car_id`, `car_es_doctor`, `car_nom`, `car_fecha_cre`) VALUES
(1, 'true', 'Doctor', '2013-10-23 23:51:52');

-- --------------------------------------------------------

--
-- Table structure for table `cita`
--

CREATE TABLE IF NOT EXISTS `cita` (
  `cit_id` int(8) NOT NULL AUTO_INCREMENT,
  `cit_fecha_cita` datetime NOT NULL,
  `cit_com` varchar(50) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `cit_estado` varchar(1) COLLATE utf8_spanish2_ci NOT NULL,
  `cit_fecha_cre` datetime NOT NULL,
  `cit_idemp` int(8) NOT NULL,
  `cit_idsuc` int(8) NOT NULL,
  `cit_idpac` int(8) NOT NULL,
  `cit_idslc` int(8) NOT NULL,
  PRIMARY KEY (`cit_id`),
  KEY `fk_cita_empleado_idx` (`cit_idemp`),
  KEY `fk_cita_sucursal_idx` (`cit_idsuc`),
  KEY `fk_cita_paciente_idx` (`cit_idpac`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `cita`
--


-- --------------------------------------------------------

--
-- Table structure for table `consulta`
--

CREATE TABLE IF NOT EXISTS `consulta` (
  `con_id` int(8) NOT NULL AUTO_INCREMENT,
  `con_desc` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `con_diag` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `con_fecha_cre` datetime NOT NULL,
  `con_idcit` int(8) NOT NULL,
  PRIMARY KEY (`con_id`),
  KEY `fk_consulta_cita_idx` (`con_idcit`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `consulta`
--


-- --------------------------------------------------------

--
-- Table structure for table `departamento`
--

CREATE TABLE IF NOT EXISTS `departamento` (
  `dep_id` int(8) NOT NULL AUTO_INCREMENT,
  `dep_nom` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `dep_idpai` int(8) NOT NULL,
  PRIMARY KEY (`dep_id`),
  KEY `fk_departamento_pais_idx` (`dep_idpai`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `departamento`
--

INSERT INTO `departamento` (`dep_id`, `dep_nom`, `dep_idpai`) VALUES
(1, 'La Libertad', 1);

-- --------------------------------------------------------

--
-- Table structure for table `detalle_facturacion`
--

CREATE TABLE IF NOT EXISTS `detalle_facturacion` (
  `dtf_id` int(8) NOT NULL AUTO_INCREMENT,
  `dtf_can` int(8) NOT NULL,
  `dtf_pre_uni` double(8,2) NOT NULL,
  `dtf_tot` double(8,2) NOT NULL,
  `dtf_fecha_cre` datetime NOT NULL,
  `dtf_idfac` int(8) NOT NULL,
  `dtf_idpro` int(8) NOT NULL,
  PRIMARY KEY (`dtf_id`),
  KEY `fk_detalle_facturacion_factura_idx` (`dtf_idfac`),
  KEY `fk_detalle_facturacion_producto_idx` (`dtf_idpro`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `detalle_facturacion`
--


-- --------------------------------------------------------

--
-- Table structure for table `detalle_receta`
--

CREATE TABLE IF NOT EXISTS `detalle_receta` (
  `dtr_id` int(8) NOT NULL AUTO_INCREMENT,
  `dtr_desc` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `dtr_fecha_cre` datetime NOT NULL,
  `dtr_idrec` int(8) NOT NULL,
  PRIMARY KEY (`dtr_id`),
  KEY `fk_detalle_receta_receta_idx` (`dtr_idrec`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `detalle_receta`
--


-- --------------------------------------------------------

--
-- Table structure for table `direccion`
--

CREATE TABLE IF NOT EXISTS `direccion` (
  `dir_id` int(8) NOT NULL AUTO_INCREMENT,
  `dir_cond` varchar(20) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `dir_cond2` varchar(20) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `dir_calle` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `dir_compcalle` varchar(45) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `dir_casa` varchar(10) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `dir_col` varchar(20) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `dir_dist` varchar(20) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `dir_ref` varchar(45) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `dir_fecha_cre` datetime NOT NULL,
  `dir_idmun` int(8) NOT NULL,
  PRIMARY KEY (`dir_id`),
  KEY `fk_direccion_municipio_idx` (`dir_idmun`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `direccion`
--

INSERT INTO `direccion` (`dir_id`, `dir_cond`, `dir_cond2`, `dir_calle`, `dir_compcalle`, `dir_casa`, `dir_col`, `dir_dist`, `dir_ref`, `dir_fecha_cre`, `dir_idmun`) VALUES
(1, NULL, NULL, 'Central', NULL, NULL, NULL, NULL, NULL, '2013-10-23 23:51:52', 1),
(2, NULL, NULL, 'Colonia', NULL, NULL, NULL, NULL, NULL, '2013-10-23 23:51:52', 1);

-- --------------------------------------------------------

--
-- Table structure for table `documento`
--

CREATE TABLE IF NOT EXISTS `documento` (
  `doc_id` int(8) NOT NULL AUTO_INCREMENT,
  `doc_num` varchar(20) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `doc_idtipo_doc` int(8) DEFAULT NULL,
  `doc_idemp` int(8) DEFAULT NULL,
  `doc_idpac` int(8) DEFAULT NULL,
  PRIMARY KEY (`doc_id`),
  KEY `fk_documento_tipodocumento_idx` (`doc_idtipo_doc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `documento`
--


-- --------------------------------------------------------

--
-- Table structure for table `empleado`
--

CREATE TABLE IF NOT EXISTS `empleado` (
  `emp_id` int(8) NOT NULL AUTO_INCREMENT,
  `emp_nom` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `emp_ape` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `emp_fecha_nac` date NOT NULL,
  `emp_gen` enum('M','F') COLLATE utf8_spanish2_ci NOT NULL,
  `emp_fecha_cre` datetime NOT NULL,
  `emp_idsuc` int(8) NOT NULL,
  `emp_idcar` int(8) NOT NULL,
  `emp_iddir` int(8) NOT NULL,
  PRIMARY KEY (`emp_id`),
  KEY `fk_empleado_cargo_idx` (`emp_idcar`),
  KEY `fk_empleado_direccion_idx` (`emp_iddir`),
  KEY `fk_empleado_sucursal_idx` (`emp_idsuc`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `empleado`
--

INSERT INTO `empleado` (`emp_id`, `emp_nom`, `emp_ape`, `emp_fecha_nac`, `emp_gen`, `emp_fecha_cre`, `emp_idsuc`, `emp_idcar`, `emp_iddir`) VALUES
(1, 'Arturo', 'Cerna', '1970-02-04', 'M', '2013-10-23 23:51:52', 1, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `facturacion`
--

CREATE TABLE IF NOT EXISTS `facturacion` (
  `fac_id` int(8) NOT NULL AUTO_INCREMENT,
  `fac_desc` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `fac_fecha` date NOT NULL,
  `fac_dir` varchar(45) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `fac_can` double(8,2) NOT NULL,
  `fac_tot` double(8,2) NOT NULL,
  `fac_nom_cli` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `fac_ape_cli` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `fac_tipo` varchar(10) COLLATE utf8_spanish2_ci NOT NULL,
  `fac_registro` varchar(10) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `fac_fecha_cre` datetime NOT NULL,
  `fac_idsuc` int(8) NOT NULL,
  PRIMARY KEY (`fac_id`),
  KEY `fk_facturacion_sucursal_idx` (`fac_idsuc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `facturacion`
--


-- --------------------------------------------------------

--
-- Table structure for table `historico_producto`
--

CREATE TABLE IF NOT EXISTS `historico_producto` (
  `hsp_periodo` int(8) NOT NULL AUTO_INCREMENT,
  `hsp_mes` int(8) NOT NULL,
  `hsp_ult_cost` double(8,2) NOT NULL,
  `hsp_sal_uni` int(8) NOT NULL,
  `hsp_sal_mon` double(8,2) NOT NULL,
  `hsp_cos_uni` double(8,2) NOT NULL,
  `hsp_idpro` int(8) NOT NULL,
  `hsp_idsuc` int(8) NOT NULL,
  PRIMARY KEY (`hsp_periodo`,`hsp_mes`),
  KEY `fk_historico_producto_producto_idx` (`hsp_idpro`),
  KEY `fk_historico_producto_sucursal_idx` (`hsp_idsuc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `historico_producto`
--


-- --------------------------------------------------------

--
-- Table structure for table `hora_atencion`
--

CREATE TABLE IF NOT EXISTS `hora_atencion` (
  `hor_id` int(8) NOT NULL AUTO_INCREMENT,
  `hor_dia` int(2) NOT NULL,
  `hor_hora_ape` time NOT NULL,
  `hor_hora_cie` time NOT NULL,
  `hor_fecha_cre` datetime NOT NULL,
  `hor_idsuc` int(8) NOT NULL,
  PRIMARY KEY (`hor_id`),
  KEY `fk_hora_atencion_sucursal_idx` (`hor_idsuc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `hora_atencion`
--


-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE IF NOT EXISTS `login` (
  `log_id` int(8) NOT NULL AUTO_INCREMENT,
  `log_usr` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `log_pss` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `log_est` varchar(1) COLLATE utf8_spanish2_ci NOT NULL,
  `log_idemp` int(8) NOT NULL,
  `log_idrol` int(8) NOT NULL,
  PRIMARY KEY (`log_id`),
  KEY `fk_login_empleado_idx` (`log_idemp`),
  KEY `fk_login_rol_idx` (`log_idrol`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`log_id`, `log_usr`, `log_pss`, `log_est`, `log_idemp`, `log_idrol`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'a', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `marca`
--

CREATE TABLE IF NOT EXISTS `marca` (
  `mar_id` int(8) NOT NULL AUTO_INCREMENT,
  `mar_nom` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  PRIMARY KEY (`mar_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `marca`
--


-- --------------------------------------------------------

--
-- Table structure for table `movimiento`
--

CREATE TABLE IF NOT EXISTS `movimiento` (
  `mov_periodo` int(8) NOT NULL AUTO_INCREMENT,
  `mov_cos_uni` double(8,2) NOT NULL,
  `mov_fecha` date NOT NULL,
  `mov_uni` int(8) NOT NULL,
  `mov_idsuc` int(8) NOT NULL,
  `mov_idpro` int(8) NOT NULL,
  `mov_idtipo` int(8) NOT NULL,
  PRIMARY KEY (`mov_periodo`),
  KEY `fk_movimiento_tipo_idx` (`mov_idtipo`),
  KEY `fk_movimiento_sucursal_idx` (`mov_idsuc`),
  KEY `fk_movimiento_producto_idx` (`mov_idpro`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `movimiento`
--


-- --------------------------------------------------------

--
-- Table structure for table `municipio`
--

CREATE TABLE IF NOT EXISTS `municipio` (
  `mun_id` int(8) NOT NULL AUTO_INCREMENT,
  `mun_nom` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `mun_iddep` int(8) NOT NULL,
  PRIMARY KEY (`mun_id`),
  KEY `fk_municipio_departamento_idx` (`mun_iddep`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `municipio`
--

INSERT INTO `municipio` (`mun_id`, `mun_nom`, `mun_iddep`) VALUES
(1, 'Santa Tecla', 1);

-- --------------------------------------------------------

--
-- Table structure for table `no_disponibilidad`
--

CREATE TABLE IF NOT EXISTS `no_disponibilidad` (
  `nod_id` int(8) NOT NULL AUTO_INCREMENT,
  `nod_dia` int(2) NOT NULL,
  `nod_hora_ini` time NOT NULL,
  `nod_hora_fin` time NOT NULL,
  `nod_fecha_cre` datetime NOT NULL,
  `nod_idemp` int(8) NOT NULL,
  PRIMARY KEY (`nod_id`),
  KEY `fk_no_disponibilidad_empleado_idx` (`nod_idemp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `no_disponibilidad`
--


-- --------------------------------------------------------

--
-- Table structure for table `paciente`
--

CREATE TABLE IF NOT EXISTS `paciente` (
  `pac_id` int(8) NOT NULL AUTO_INCREMENT,
  `pac_nom` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `pac_ape` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `pac_fecha_nac` date NOT NULL,
  `pac_peso` decimal(8,2) DEFAULT NULL,
  `pac_alt` decimal(8,2) DEFAULT NULL,
  `pac_gen` enum('M','F') COLLATE utf8_spanish2_ci NOT NULL,
  `pac_ale` varchar(45) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `pac_correo` varchar(45) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `pac_est` varchar(1) COLLATE utf8_spanish2_ci NOT NULL,
  `pac_fecha_cre` datetime NOT NULL,
  `pac_iddir` int(8) NOT NULL,
  `pac_idtps` int(8) NOT NULL,
  PRIMARY KEY (`pac_id`),
  KEY `fk_paciente_direccion_idx` (`pac_iddir`),
  KEY `fk_paciente_tipo_sangre_idx` (`pac_idtps`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `paciente`
--


-- --------------------------------------------------------

--
-- Table structure for table `paciente_responsable`
--

CREATE TABLE IF NOT EXISTS `paciente_responsable` (
  `pac_resp_id` int(8) NOT NULL AUTO_INCREMENT,
  `pac_resp_nom` int(11) NOT NULL,
  `pac_resp_ape` int(11) NOT NULL,
  `pac_resp_fecha_resp` int(11) NOT NULL,
  `pac_resp_correo` int(11) NOT NULL,
  PRIMARY KEY (`pac_resp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `paciente_responsable`
--


-- --------------------------------------------------------

--
-- Table structure for table `pais`
--

CREATE TABLE IF NOT EXISTS `pais` (
  `pai_id` int(8) NOT NULL AUTO_INCREMENT,
  `pai_nom` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `pai_fecha_cre` datetime NOT NULL,
  PRIMARY KEY (`pai_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `pais`
--

INSERT INTO `pais` (`pai_id`, `pai_nom`, `pai_fecha_cre`) VALUES
(1, 'El Salvador', '2013-10-23 23:51:52');

-- --------------------------------------------------------

--
-- Table structure for table `producto`
--

CREATE TABLE IF NOT EXISTS `producto` (
  `pro_id` int(8) NOT NULL AUTO_INCREMENT,
  `pro_nom` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `pro_salant_uni` int(8) NOT NULL,
  `pro_salant_mon` double(8,2) NOT NULL,
  `pro_costo_uni` double(8,2) NOT NULL,
  `pro_ult_cost` double(8,2) NOT NULL,
  `pro_existencia` int(8) NOT NULL,
  `pro_cant_min` int(4) NOT NULL,
  `pro_ult_ven` date DEFAULT NULL,
  `pro_fecha_cre` datetime NOT NULL,
  `pro_idsuc` int(8) NOT NULL,
  `pro_idmar` int(8) NOT NULL,
  PRIMARY KEY (`pro_id`),
  KEY `fk_producto_sucursal_idx` (`pro_idsuc`),
  KEY `fk_producto_marca_idx` (`pro_idmar`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `producto`
--


-- --------------------------------------------------------

--
-- Table structure for table `producto_categoria`
--

CREATE TABLE IF NOT EXISTS `producto_categoria` (
  `cat_id` int(8) NOT NULL AUTO_INCREMENT,
  `cat_nombre` int(11) NOT NULL,
  `cat_descripcion` int(11) NOT NULL,
  PRIMARY KEY (`cat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `producto_categoria`
--


-- --------------------------------------------------------

--
-- Table structure for table `producto_fila`
--

CREATE TABLE IF NOT EXISTS `producto_fila` (
  `pro_fila_id` int(11) NOT NULL AUTO_INCREMENT,
  `pro_fila_nombre` varchar(10) COLLATE utf8_spanish2_ci NOT NULL,
  `pro_fila_descripcion` varchar(125) COLLATE utf8_spanish2_ci NOT NULL,
  PRIMARY KEY (`pro_fila_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `producto_fila`
--


-- --------------------------------------------------------

--
-- Table structure for table `producto_ubicacion`
--

CREATE TABLE IF NOT EXISTS `producto_ubicacion` (
  `pro_ubi_id` int(4) NOT NULL AUTO_INCREMENT,
  `pro_ubi_nombre` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `pro_ubi_descripcion` varchar(125) COLLATE utf8_spanish2_ci NOT NULL,
  PRIMARY KEY (`pro_ubi_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `producto_ubicacion`
--


-- --------------------------------------------------------

--
-- Table structure for table `proveedor`
--

CREATE TABLE IF NOT EXISTS `proveedor` (
  `prv_id` int(8) NOT NULL AUTO_INCREMENT,
  `prv_nom` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `prv_cor` varchar(45) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `prv_fecha_cre` datetime NOT NULL,
  `prv_iddir` int(8) NOT NULL,
  PRIMARY KEY (`prv_id`),
  KEY `fk_proveedor_direccion_idx` (`prv_iddir`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `proveedor`
--


-- --------------------------------------------------------

--
-- Table structure for table `receta`
--

CREATE TABLE IF NOT EXISTS `receta` (
  `rec_id` int(8) NOT NULL AUTO_INCREMENT,
  `rec_desc` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `rec_fecha_cre` datetime NOT NULL,
  `rec_idcon` int(8) NOT NULL,
  PRIMARY KEY (`rec_id`),
  KEY `fk_receta_consulta_idx` (`rec_idcon`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `receta`
--


-- --------------------------------------------------------

--
-- Table structure for table `rol`
--

CREATE TABLE IF NOT EXISTS `rol` (
  `rol_id` int(8) NOT NULL AUTO_INCREMENT,
  `rol_nom` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `rol_desc` varchar(50) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `rol_fecha_ini` date NOT NULL,
  `rol_fecha_fin` date DEFAULT NULL,
  `rol_est` enum('A','I') COLLATE utf8_spanish2_ci NOT NULL,
  PRIMARY KEY (`rol_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `rol`
--

INSERT INTO `rol` (`rol_id`, `rol_nom`, `rol_desc`, `rol_fecha_ini`, `rol_fecha_fin`, `rol_est`) VALUES
(1, 'ADMIN', 'Administrador', '2013-01-01', '2013-12-31', 'A');

-- --------------------------------------------------------

--
-- Table structure for table `solicitud_cita`
--

CREATE TABLE IF NOT EXISTS `solicitud_cita` (
  `slc_id` int(8) NOT NULL AUTO_INCREMENT,
  `slc_desc` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `slc_fecha_sol` datetime NOT NULL,
  `slc_fecha_cre` datetime NOT NULL,
  `slc_idpac` int(8) NOT NULL,
  PRIMARY KEY (`slc_id`),
  KEY `fk_solicitud_cita_paciente_idx` (`slc_idpac`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `solicitud_cita`
--


-- --------------------------------------------------------

--
-- Table structure for table `sucursal`
--

CREATE TABLE IF NOT EXISTS `sucursal` (
  `suc_id` int(8) NOT NULL AUTO_INCREMENT,
  `suc_nom` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `suc_iddir` int(8) NOT NULL,
  PRIMARY KEY (`suc_id`),
  KEY `fk_sucursal_direccion_idx` (`suc_iddir`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `sucursal`
--

INSERT INTO `sucursal` (`suc_id`, `suc_nom`, `suc_iddir`) VALUES
(1, 'Armenia', 1);

-- --------------------------------------------------------

--
-- Table structure for table `telefono`
--

CREATE TABLE IF NOT EXISTS `telefono` (
  `tel_id` int(8) NOT NULL AUTO_INCREMENT,
  `tel_nom` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `tel_num` varchar(10) COLLATE utf8_spanish2_ci NOT NULL,
  `tel_fecha_cre` datetime NOT NULL,
  `tel_idemp` int(8) NOT NULL,
  `tel_idpac` int(8) NOT NULL,
  `tel_idpro` int(8) NOT NULL,
  PRIMARY KEY (`tel_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `telefono`
--


-- --------------------------------------------------------

--
-- Table structure for table `tipo_documento`
--

CREATE TABLE IF NOT EXISTS `tipo_documento` (
  `tip_id` int(8) NOT NULL AUTO_INCREMENT,
  `tip_nom` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  PRIMARY KEY (`tip_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tipo_documento`
--

INSERT INTO `tipo_documento` (`tip_id`, `tip_nom`) VALUES
(1, '.kb');

-- --------------------------------------------------------

--
-- Table structure for table `tipo_movimiento`
--

CREATE TABLE IF NOT EXISTS `tipo_movimiento` (
  `tpm_id` int(8) NOT NULL AUTO_INCREMENT,
  `tpm_desc` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `tpm_mov` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `tpm_idsuc` int(8) NOT NULL,
  PRIMARY KEY (`tpm_id`),
  KEY `fk_tipo_movimiento_sucursal_idx` (`tpm_idsuc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `tipo_movimiento`
--


-- --------------------------------------------------------

--
-- Table structure for table `tipo_sangre`
--

CREATE TABLE IF NOT EXISTS `tipo_sangre` (
  `tps_id` int(8) NOT NULL AUTO_INCREMENT,
  `tps_tipo_san` varchar(15) COLLATE utf8_spanish2_ci NOT NULL,
  PRIMARY KEY (`tps_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tipo_sangre`
--

INSERT INTO `tipo_sangre` (`tps_id`, `tps_tipo_san`) VALUES
(1, 'orh ');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `acceso`
--
ALTER TABLE `acceso`
  ADD CONSTRAINT `fk_acceso_login` FOREIGN KEY (`acc_idlog`) REFERENCES `login` (`log_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `cita`
--
ALTER TABLE `cita`
  ADD CONSTRAINT `fk_cita_empleado` FOREIGN KEY (`cit_idemp`) REFERENCES `empleado` (`emp_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_cita_paciente` FOREIGN KEY (`cit_idpac`) REFERENCES `paciente` (`pac_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_cita_sucursal` FOREIGN KEY (`cit_idsuc`) REFERENCES `sucursal` (`suc_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `consulta`
--
ALTER TABLE `consulta`
  ADD CONSTRAINT `fk_consulta_cita` FOREIGN KEY (`con_idcit`) REFERENCES `cita` (`cit_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `departamento`
--
ALTER TABLE `departamento`
  ADD CONSTRAINT `fk_departamento_pais` FOREIGN KEY (`dep_idpai`) REFERENCES `pais` (`pai_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `detalle_facturacion`
--
ALTER TABLE `detalle_facturacion`
  ADD CONSTRAINT `fk_detalle_facturacion_factura` FOREIGN KEY (`dtf_idfac`) REFERENCES `facturacion` (`fac_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_detalle_facturacion_producto` FOREIGN KEY (`dtf_idpro`) REFERENCES `producto` (`pro_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `detalle_receta`
--
ALTER TABLE `detalle_receta`
  ADD CONSTRAINT `fk_detalle_receta_receta` FOREIGN KEY (`dtr_idrec`) REFERENCES `receta` (`rec_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `direccion`
--
ALTER TABLE `direccion`
  ADD CONSTRAINT `fk_direccion_municipio` FOREIGN KEY (`dir_idmun`) REFERENCES `municipio` (`mun_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `documento`
--
ALTER TABLE `documento`
  ADD CONSTRAINT `fk_documento_tipodocumento` FOREIGN KEY (`doc_idtipo_doc`) REFERENCES `tipo_documento` (`tip_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `empleado`
--
ALTER TABLE `empleado`
  ADD CONSTRAINT `fk_empleado_cargo` FOREIGN KEY (`emp_idcar`) REFERENCES `cargo` (`car_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_empleado_direccion` FOREIGN KEY (`emp_iddir`) REFERENCES `direccion` (`dir_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_empleado_sucursal` FOREIGN KEY (`emp_idsuc`) REFERENCES `sucursal` (`suc_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `facturacion`
--
ALTER TABLE `facturacion`
  ADD CONSTRAINT `fk_facturacion_sucursal` FOREIGN KEY (`fac_idsuc`) REFERENCES `sucursal` (`suc_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `historico_producto`
--
ALTER TABLE `historico_producto`
  ADD CONSTRAINT `fk_historico_producto_producto` FOREIGN KEY (`hsp_idpro`) REFERENCES `producto` (`pro_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_historico_producto_sucursal` FOREIGN KEY (`hsp_idsuc`) REFERENCES `sucursal` (`suc_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `hora_atencion`
--
ALTER TABLE `hora_atencion`
  ADD CONSTRAINT `fk_hora_atencion_sucursal` FOREIGN KEY (`hor_idsuc`) REFERENCES `sucursal` (`suc_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `login`
--
ALTER TABLE `login`
  ADD CONSTRAINT `fk_login_empleado` FOREIGN KEY (`log_idemp`) REFERENCES `empleado` (`emp_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_login_rol` FOREIGN KEY (`log_idrol`) REFERENCES `rol` (`rol_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `movimiento`
--
ALTER TABLE `movimiento`
  ADD CONSTRAINT `fk_movimiento_producto` FOREIGN KEY (`mov_idpro`) REFERENCES `producto` (`pro_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_movimiento_sucursal` FOREIGN KEY (`mov_idsuc`) REFERENCES `sucursal` (`suc_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_movimiento_tipo` FOREIGN KEY (`mov_idtipo`) REFERENCES `tipo_movimiento` (`tpm_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `municipio`
--
ALTER TABLE `municipio`
  ADD CONSTRAINT `fk_municipio_departamento` FOREIGN KEY (`mun_iddep`) REFERENCES `departamento` (`dep_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `no_disponibilidad`
--
ALTER TABLE `no_disponibilidad`
  ADD CONSTRAINT `fk_no_disponibilidad_empleado` FOREIGN KEY (`nod_idemp`) REFERENCES `empleado` (`emp_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `paciente`
--
ALTER TABLE `paciente`
  ADD CONSTRAINT `fk_paciente_direccion` FOREIGN KEY (`pac_iddir`) REFERENCES `direccion` (`dir_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_paciente_tipo_sangre` FOREIGN KEY (`pac_idtps`) REFERENCES `tipo_sangre` (`tps_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `fk_producto_marca` FOREIGN KEY (`pro_idmar`) REFERENCES `marca` (`mar_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_producto_sucursal` FOREIGN KEY (`pro_idsuc`) REFERENCES `sucursal` (`suc_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `proveedor`
--
ALTER TABLE `proveedor`
  ADD CONSTRAINT `fk_proveedor_direccion` FOREIGN KEY (`prv_iddir`) REFERENCES `direccion` (`dir_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `receta`
--
ALTER TABLE `receta`
  ADD CONSTRAINT `fk_receta_consulta` FOREIGN KEY (`rec_idcon`) REFERENCES `consulta` (`con_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `solicitud_cita`
--
ALTER TABLE `solicitud_cita`
  ADD CONSTRAINT `fk_solicitud_cita_paciente` FOREIGN KEY (`slc_idpac`) REFERENCES `paciente` (`pac_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `sucursal`
--
ALTER TABLE `sucursal`
  ADD CONSTRAINT `fk_sucursal_direccion` FOREIGN KEY (`suc_iddir`) REFERENCES `direccion` (`dir_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tipo_movimiento`
--
ALTER TABLE `tipo_movimiento`
  ADD CONSTRAINT `fk_tipo_movimiento_sucursal` FOREIGN KEY (`tpm_idsuc`) REFERENCES `sucursal` (`suc_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
=======
SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

DROP SCHEMA IF EXISTS `consultorio` ;
CREATE SCHEMA IF NOT EXISTS `consultorio` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish2_ci ;
USE `consultorio` ;

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
  PRIMARY KEY (`dep_id`) ,
  INDEX `fk_departamento_pais_idx` (`dep_idpai` ASC) ,
  CONSTRAINT `fk_departamento_pais`
    FOREIGN KEY (`dep_idpai` )
    REFERENCES `consultorio`.`pais` (`pai_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB

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
  PRIMARY KEY (`mun_id`) ,
  INDEX `fk_municipio_departamento_idx` (`mun_iddep` ASC) ,
  CONSTRAINT `fk_municipio_departamento`
    FOREIGN KEY (`mun_iddep` )
    REFERENCES `consultorio`.`departamento` (`dep_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB

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
  PRIMARY KEY (`emp_id`) ,
  INDEX `fk_empleado_cargo_idx` (`emp_idcar` ASC) ,
  INDEX `fk_empleado_direccion_idx` (`emp_iddir` ASC) ,
  INDEX `fk_empleado_sucursal_idx` (`emp_idsuc` ASC) ,
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
    ON UPDATE NO ACTION)
ENGINE = InnoDB

DEFAULT CHARACTER SET = utf8
COLLATE = utf8_spanish2_ci;


-- -----------------------------------------------------
-- Table `consultorio`.`rol`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `consultorio`.`rol` ;

CREATE  TABLE IF NOT EXISTS `consultorio`.`rol` (
  `rol_id` INT(8) NOT NULL AUTO_INCREMENT ,
  `rol_nom` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_spanish2_ci' NOT NULL ,
  `rol_desc` VARCHAR(50) CHARACTER SET 'utf8' COLLATE 'utf8_spanish2_ci' NULL DEFAULT NULL ,
  `rol_fecha_ini` DATE NOT NULL ,
  `rol_fecha_fin` DATE NULL DEFAULT NULL ,
  `rol_est` ENUM('A','I') CHARACTER SET 'utf8' COLLATE 'utf8_spanish2_ci' NOT NULL ,
  PRIMARY KEY (`rol_id`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_spanish2_ci;


-- -----------------------------------------------------
-- Table `consultorio`.`login`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `consultorio`.`login` ;

CREATE  TABLE IF NOT EXISTS `consultorio`.`login` (
  `log_id` INT(8) NOT NULL AUTO_INCREMENT ,
  `log_usr` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_spanish2_ci' NOT NULL ,
  `log_pss` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_spanish2_ci' NOT NULL ,
  `log_est` VARCHAR(1) CHARACTER SET 'utf8' COLLATE 'utf8_spanish2_ci' NOT NULL ,
  `log_idemp` INT(8) NOT NULL ,
  `log_idrol` INT(8) NOT NULL ,
  PRIMARY KEY (`log_id`) ,
  INDEX `fk_login_empleado_idx` (`log_idemp` ASC) ,
  INDEX `fk_login_rol_idx` (`log_idrol` ASC) ,
  CONSTRAINT `fk_login_empleado`
    FOREIGN KEY (`log_idemp` )
    REFERENCES `consultorio`.`empleado` (`emp_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_login_rol`
    FOREIGN KEY (`log_idrol` )
    REFERENCES `consultorio`.`rol` (`rol_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB

DEFAULT CHARACTER SET = utf8
COLLATE = utf8_spanish2_ci;


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
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_spanish2_ci;


-- -----------------------------------------------------
-- Table `consultorio`.`tipo_sangre`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `consultorio`.`tipo_sangre` ;

CREATE  TABLE IF NOT EXISTS `consultorio`.`tipo_sangre` (
  `tps_id` INT(8) NOT NULL AUTO_INCREMENT ,
  `tps_tipo_san` VARCHAR(15) CHARACTER SET 'utf8' COLLATE 'utf8_spanish2_ci' NOT NULL ,
  PRIMARY KEY (`tps_id`) )
ENGINE = InnoDB
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
  `pac_correo` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_spanish2_ci' NULL DEFAULT NULL ,
  `pac_est` VARCHAR(1) CHARACTER SET 'utf8' COLLATE 'utf8_spanish2_ci' NOT NULL ,
  `pac_fecha_cre` DATETIME NOT NULL ,
  `pac_iddir` INT(8) NOT NULL ,
  `pac_idtps` INT(8) NOT NULL ,
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
  `cit_idslc` INT(8) NOT NULL ,
  PRIMARY KEY (`cit_id`) ,
  INDEX `fk_cita_empleado_idx` (`cit_idemp` ASC) ,
  INDEX `fk_cita_sucursal_idx` (`cit_idsuc` ASC) ,
  INDEX `fk_cita_paciente_idx` (`cit_idpac` ASC) ,
  CONSTRAINT `fk_cita_empleado`
    FOREIGN KEY (`cit_idemp` )
    REFERENCES `consultorio`.`empleado` (`emp_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_cita_sucursal`
    FOREIGN KEY (`cit_idsuc` )
    REFERENCES `consultorio`.`sucursal` (`suc_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_cita_paciente`
    FOREIGN KEY (`cit_idpac` )
    REFERENCES `consultorio`.`paciente` (`pac_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
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
  `fac_dir` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_spanish2_ci' NULL DEFAULT NULL ,
  `fac_can` DOUBLE(8,2) NOT NULL ,
  `fac_tot` DOUBLE(8,2) NOT NULL ,
  `fac_nom_cli` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_spanish2_ci' NOT NULL ,
  `fac_ape_cli` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_spanish2_ci' NOT NULL ,
  `fac_tipo` VARCHAR(10) CHARACTER SET 'utf8' COLLATE 'utf8_spanish2_ci' NOT NULL ,
  `fac_registro` VARCHAR(10) CHARACTER SET 'utf8' COLLATE 'utf8_spanish2_ci' NULL DEFAULT NULL ,
  `fac_fecha_cre` DATETIME NOT NULL ,
  `fac_idsuc` INT(8) NOT NULL ,
  PRIMARY KEY (`fac_id`) ,
  INDEX `fk_facturacion_sucursal_idx` (`fac_idsuc` ASC) ,
  CONSTRAINT `fk_facturacion_sucursal`
    FOREIGN KEY (`fac_idsuc` )
    REFERENCES `consultorio`.`sucursal` (`suc_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
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
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_spanish2_ci;


-- -----------------------------------------------------
-- Table `consultorio`.`producto`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `consultorio`.`producto` ;

CREATE  TABLE IF NOT EXISTS `consultorio`.`producto` (
  `pro_id` INT(8) NOT NULL AUTO_INCREMENT ,
  `pro_nom` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_spanish2_ci' NOT NULL ,
  `pro_ubi` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_spanish2_ci' NULL DEFAULT NULL ,
  `pro_salant_uni` INT(8) NOT NULL ,
  `pro_salant_mon` DOUBLE(8,2) NOT NULL ,
  `pro_costo_uni` DOUBLE(8,2) NOT NULL ,
  `pro_ult_cost` DOUBLE(8,2) NOT NULL ,
  `pro_existencia` INT(8) NOT NULL ,
  `pro_ult_ven` DATE NULL DEFAULT NULL ,
  `pro_fecha_cre` DATETIME NOT NULL ,
  `pro_idsuc` INT(8) NOT NULL ,
  `pro_idmar` INT(8) NOT NULL ,
  PRIMARY KEY (`pro_id`) ,
  INDEX `fk_producto_sucursal_idx` (`pro_idsuc` ASC) ,
  INDEX `fk_producto_marca_idx` (`pro_idmar` ASC) ,
  CONSTRAINT `fk_producto_sucursal`
    FOREIGN KEY (`pro_idsuc` )
    REFERENCES `consultorio`.`sucursal` (`suc_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_producto_marca`
    FOREIGN KEY (`pro_idmar` )
    REFERENCES `consultorio`.`marca` (`mar_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_spanish2_ci;


-- -----------------------------------------------------
-- Table `consultorio`.`detalle_facturacion`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `consultorio`.`detalle_facturacion` ;

CREATE  TABLE IF NOT EXISTS `consultorio`.`detalle_facturacion` (
  `dtf_id` INT(8) NOT NULL AUTO_INCREMENT ,
  `dtf_can` INT(8) NOT NULL ,
  `dtf_pre_uni` DOUBLE(8,2) NOT NULL ,
  `dtf_tot` DOUBLE(8,2) NOT NULL ,
  `dtf_fecha_cre` DATETIME NOT NULL ,
  `dtf_idfac` INT(8) NOT NULL ,
  `dtf_idpro` INT(8) NOT NULL ,
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
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_spanish2_ci;


-- -----------------------------------------------------
-- Table `consultorio`.`receta`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `consultorio`.`receta` ;

CREATE  TABLE IF NOT EXISTS `consultorio`.`receta` (
  `rec_id` INT(8) NOT NULL AUTO_INCREMENT ,
  `rec_desc` VARCHAR(50) CHARACTER SET 'utf8' COLLATE 'utf8_spanish2_ci' NOT NULL ,
  `rec_fecha_cre` DATETIME NOT NULL ,
  `rec_idcon` INT(8) NOT NULL ,
  PRIMARY KEY (`rec_id`) ,
  INDEX `fk_receta_consulta_idx` (`rec_idcon` ASC) ,
  CONSTRAINT `fk_receta_consulta`
    FOREIGN KEY (`rec_idcon` )
    REFERENCES `consultorio`.`consulta` (`con_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_spanish2_ci;


-- -----------------------------------------------------
-- Table `consultorio`.`detalle_receta`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `consultorio`.`detalle_receta` ;

CREATE  TABLE IF NOT EXISTS `consultorio`.`detalle_receta` (
  `dtr_id` INT(8) NOT NULL AUTO_INCREMENT ,
  `dtr_desc` VARCHAR(50) CHARACTER SET 'utf8' COLLATE 'utf8_spanish2_ci' NOT NULL ,
  `dtr_fecha_cre` DATETIME NOT NULL ,
  `dtr_idrec` INT(8) NOT NULL ,
  PRIMARY KEY (`dtr_id`) ,
  INDEX `fk_detalle_receta_receta_idx` (`dtr_idrec` ASC) ,
  CONSTRAINT `fk_detalle_receta_receta`
    FOREIGN KEY (`dtr_idrec` )
    REFERENCES `consultorio`.`receta` (`rec_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_spanish2_ci;


-- -----------------------------------------------------
-- Table `consultorio`.`tipo_documento`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `consultorio`.`tipo_documento` ;

CREATE  TABLE IF NOT EXISTS `consultorio`.`tipo_documento` (
  `tip_id` INT(8) NOT NULL AUTO_INCREMENT ,
  `tip_nom` VARCHAR(20) CHARACTER SET 'utf8' COLLATE 'utf8_spanish2_ci' NOT NULL ,
  PRIMARY KEY (`tip_id`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_spanish2_ci;


-- -----------------------------------------------------
-- Table `consultorio`.`documento`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `consultorio`.`documento` ;

CREATE  TABLE IF NOT EXISTS `consultorio`.`documento` (
  `doc_id` INT(8) NOT NULL AUTO_INCREMENT ,
  `doc_num` VARCHAR(20) CHARACTER SET 'utf8' COLLATE 'utf8_spanish2_ci' NULL DEFAULT NULL ,
  `doc_idtipo_doc` INT(8) NULL DEFAULT NULL ,
  `doc_idemp` INT(8) NULL DEFAULT NULL ,
  `doc_idpac` INT(8) NULL DEFAULT NULL ,
  PRIMARY KEY (`doc_id`) ,
  INDEX `fk_documento_tipodocumento_idx` (`doc_idtipo_doc` ASC) ,
  CONSTRAINT `fk_documento_tipodocumento`
    FOREIGN KEY (`doc_idtipo_doc` )
    REFERENCES `consultorio`.`tipo_documento` (`tip_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_spanish2_ci;


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
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_spanish2_ci;


-- -----------------------------------------------------
-- Table `consultorio`.`hora_atencion`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `consultorio`.`hora_atencion` ;

CREATE  TABLE IF NOT EXISTS `consultorio`.`hora_atencion` (
  `hor_id` INT(8) NOT NULL AUTO_INCREMENT ,
  `hor_dia` INT(2) NOT NULL ,
  `hor_hora_ape` TIME NOT NULL ,
  `hor_hora_cie` TIME NOT NULL ,
  `hor_fecha_cre` DATETIME NOT NULL ,
  `hor_idsuc` INT(8) NOT NULL ,
  PRIMARY KEY (`hor_id`) ,
  INDEX `fk_hora_atencion_sucursal_idx` (`hor_idsuc` ASC) ,
  CONSTRAINT `fk_hora_atencion_sucursal`
    FOREIGN KEY (`hor_idsuc` )
    REFERENCES `consultorio`.`sucursal` (`suc_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_spanish2_ci;


-- -----------------------------------------------------
-- Table `consultorio`.`tipo_movimiento`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `consultorio`.`tipo_movimiento` ;

CREATE  TABLE IF NOT EXISTS `consultorio`.`tipo_movimiento` (
  `tpm_id` INT(8) NOT NULL AUTO_INCREMENT ,
  `tpm_desc` VARCHAR(45) NOT NULL ,
  `tpm_mov` VARCHAR(45) NOT NULL ,
  `tpm_idsuc` INT(8) NOT NULL ,
  PRIMARY KEY (`tpm_id`) ,
  INDEX `fk_tipo_movimiento_sucursal_idx` (`tpm_idsuc` ASC) ,
  CONSTRAINT `fk_tipo_movimiento_sucursal`
    FOREIGN KEY (`tpm_idsuc` )
    REFERENCES `consultorio`.`sucursal` (`suc_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


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
  CONSTRAINT `fk_movimiento_tipo`
    FOREIGN KEY (`mov_idtipo` )
    REFERENCES `consultorio`.`tipo_movimiento` (`tpm_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_movimiento_sucursal`
    FOREIGN KEY (`mov_idsuc` )
    REFERENCES `consultorio`.`sucursal` (`suc_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_movimiento_producto`
    FOREIGN KEY (`mov_idpro` )
    REFERENCES `consultorio`.`producto` (`pro_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_spanish2_ci;


-- -----------------------------------------------------
-- Table `consultorio`.`no_disponibilidad`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `consultorio`.`no_disponibilidad` ;

CREATE  TABLE IF NOT EXISTS `consultorio`.`no_disponibilidad` (
  `nod_id` INT(8) NOT NULL AUTO_INCREMENT ,
  `nod_dia` INT(2) NOT NULL ,
  `nod_hora_ini` TIME NOT NULL ,
  `nod_hora_fin` TIME NOT NULL ,
  `nod_fecha_cre` DATETIME NOT NULL ,
  `nod_idemp` INT(8) NOT NULL ,
  PRIMARY KEY (`nod_id`) ,
  INDEX `fk_no_disponibilidad_empleado_idx` (`nod_idemp` ASC) ,
  CONSTRAINT `fk_no_disponibilidad_empleado`
    FOREIGN KEY (`nod_idemp` )
    REFERENCES `consultorio`.`empleado` (`emp_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_spanish2_ci;


-- -----------------------------------------------------
-- Table `consultorio`.`proveedor`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `consultorio`.`proveedor` ;

CREATE  TABLE IF NOT EXISTS `consultorio`.`proveedor` (
  `prv_id` INT(8) NOT NULL AUTO_INCREMENT ,
  `prv_nom` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_spanish2_ci' NOT NULL ,
  `prv_cor` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_spanish2_ci' NULL DEFAULT NULL ,
  `prv_fecha_cre` DATETIME NOT NULL ,
  `prv_iddir` INT(8) NOT NULL ,
  PRIMARY KEY (`prv_id`) ,
  INDEX `fk_proveedor_direccion_idx` (`prv_iddir` ASC) ,
  CONSTRAINT `fk_proveedor_direccion`
    FOREIGN KEY (`prv_iddir` )
    REFERENCES `consultorio`.`direccion` (`dir_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_spanish2_ci;


-- -----------------------------------------------------
-- Table `consultorio`.`solicitud_cita`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `consultorio`.`solicitud_cita` ;

CREATE  TABLE IF NOT EXISTS `consultorio`.`solicitud_cita` (
  `slc_id` INT(8) NOT NULL AUTO_INCREMENT ,
  `slc_desc` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_spanish2_ci' NOT NULL ,
  `slc_fecha_sol` DATETIME NOT NULL ,
  `slc_fecha_cre` DATETIME NOT NULL ,
  `slc_idpac` INT(8) NOT NULL ,
  PRIMARY KEY (`slc_id`) ,
  INDEX `fk_solicitud_cita_paciente_idx` (`slc_idpac` ASC) ,
  CONSTRAINT `fk_solicitud_cita_paciente`
    FOREIGN KEY (`slc_idpac` )
    REFERENCES `consultorio`.`paciente` (`pac_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_spanish2_ci;


-- -----------------------------------------------------
-- Table `consultorio`.`telefono`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `consultorio`.`telefono` ;

CREATE  TABLE IF NOT EXISTS `consultorio`.`telefono` (
  `tel_id` INT(8) NOT NULL AUTO_INCREMENT ,
  `tel_nom` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_spanish2_ci' NOT NULL ,
  `tel_num` VARCHAR(10) CHARACTER SET 'utf8' COLLATE 'utf8_spanish2_ci' NOT NULL ,
  `tel_fecha_cre` DATETIME NOT NULL ,
  `tel_idemp` INT(8) NOT NULL ,
  `tel_idpac` INT(8) NOT NULL ,
  `tel_idpro` INT(8) NOT NULL ,
  PRIMARY KEY (`tel_id`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_spanish2_ci;

USE `consultorio` ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;


INSERT INTO `pais`(`pai_id`,`pai_nom`,`pai_fecha_cre`) VALUES(1,'El Salvador',NOW());
INSERT INTO `departamento`(`dep_id`,`dep_nom`,`dep_idpai`) VALUES(1,'La Libertad',1);
INSERT INTO `municipio`(`mun_id`,`mun_nom`,`mun_iddep`) VALUES(1,'Santa Tecla',1);

INSERT INTO `direccion`(`dir_id`,`dir_calle`,`dir_fecha_cre`,`dir_idmun`) VALUES(1,'Central',NOW(),1);
INSERT INTO `sucursal`(`suc_id`,`suc_nom`,`suc_iddir`) VALUES(1,'Armenia',1);


INSERT INTO `cargo`(`car_id`,`car_nom`,`car_es_doctor`,`car_fecha_cre`) VALUES(1,'Doctor','true',NOW());
INSERT INTO `direccion`(`dir_id`,`dir_calle`,`dir_fecha_cre`,`dir_idmun`) VALUES(2,'Colonia',NOW(),1);
INSERT INTO `empleado`(`emp_id`,`emp_nom`,`emp_ape`,`emp_fecha_nac`,`emp_gen`,`emp_idsuc`,`emp_idcar`,`emp_iddir`,`emp_fecha_cre`) 
VALUES(1,'Arturo','Cerna','1970-02-04','M',1,1,2,NOW());

INSERT INTO `rol`(`rol_id`,`rol_nom`,`rol_desc`,`rol_fecha_ini`,`rol_fecha_fin`,`rol_est`) VALUES(1,'ADMIN','Administrador','2013-01-01','2013-12-31','A');
INSERT INTO `login`(`log_id`,`log_usr`,`log_pss`,`log_est`,`log_idrol`,`log_idemp`) VALUES(1,'admin',md5('admin'),'a',1,1);
>>>>>>> origin/master

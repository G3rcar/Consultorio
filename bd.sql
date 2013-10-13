SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

DROP SCHEMA IF EXISTS `consultorio`;

CREATE SCHEMA IF NOT EXISTS `consultorio` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish2_ci ;
USE `consultorio` ;

create table empleado (emp_id	Int(8) Not null AUTO_INCREMENT,
                      emp_nom	Varchar(45) not null,
                      emp_ape	Varchar(45) not null,
                      emp_fecha_nac	Date not null,	
                      emp_gen	Varchar(1) not null,
                      emp_fecha_cre	Datetime not null,	
                      emp_idsuc	Int(8) not null,
                      emp_idcar	Int(8) not null,
                      emp_idesp	Int(8) not null,
                      emp_iddir	Int(8) not null,
                      primary key(emp_id))
                      ENGINE = InnoDB;

 create table direccion(dir_id	Int(8) not null AUTO_INCREMENT,
                        dir_cond	varchar(20) ,
                        dir_cond2	Varchar(20),
                        dir_calle	Varchar(45) not null,
                        dir_compcalle	varchar(45),
                        dir_casa	Varchar(10),
                        dir_col	Varchar(20),
                        dir_dist	Varchar(20),
                        dir_ref	varchar(45),
                        dir_fecha_cre	Datetime not null,	
                        dir_idmun	Int(8) not null,
                        primary key(dir_id))
                      ENGINE = InnoDB;

create table cargo (car_id	Int(8) not null AUTO_INCREMENT,
              car_nom	Varchar(45) not null,
              car_fecha_cre	Datetime not null,
              primary key(car_id))
                      ENGINE = InnoDB;	

create table telefono(tel_id	Int(8) not null AUTO_INCREMENT,
                      tel_nom	Varchar(45) not null,
                      tel_num	Varchar(10) not null,
                      tel_fecha_cre	Datetime not null,	
                      tel_idemp	Int(8) not null,
                      tel_idpac	Int(8) not null,
                      tel_idpro	Int(8) not null,
                      primary key(tel_id))
                      ENGINE = InnoDB;
                      
create table tipo_documento(tip_id	Int(8) not null AUTO_INCREMENT,
						tip_nom	Varchar(20) not null,
						primary key(tip_id))
                      ENGINE = InnoDB;
                            

create table documento(doc_id	Int(8) NOT NULL AUTO_INCREMENT,
                      doc_num	Varchar(20),
                      doc_idtipo_doc	Int(8),
                      doc_idemp	Int(8),
                      doc_idpac	Int(8),
                      primary key(doc_id))
                      ENGINE = InnoDB;
                      
create table login(log_id	Int(8) not null AUTO_INCREMENT,
                  log_usr	Varchar(45) not null,
                  log_pss	Varchar(45) not null,
                  log_est	Varchar(1) not null,
                  log_idemp	Int(8) not null,
                  log_idrol	Int(8) not null,
                  primary key(log_id))
                      ENGINE = InnoDB;                      

create table rol(rol_id	Int(8) not null AUTO_INCREMENT,
                rol_nom	Varchar(45) not null,
                rol_desc	Varchar(50),
                rol_fecha_ini	Date not null,	
                rol_fecha_fin	Date,	
                rol_est	Varchar(1) not null,
                primary key(rol_id))
                      ENGINE = InnoDB;
                
create table pais(pai_id	Int(8) not null AUTO_INCREMENT,
                  pai_nom	Varchar(45)not null,
                  primary key(pai_id))
                      ENGINE = InnoDB;
                      
create table departamento(dep_id	Int(8) not null AUTO_INCREMENT,
                          dep_nom	Varchar(45) not null,
                          dep_idpai	Int(8) not null,
                          primary key(dep_id))
                      ENGINE = InnoDB;
                      
create table municipio(mun_id	Int(8) not null AUTO_INCREMENT,
                        mun_nom	Varchar(45) not null,
                        mun_iddep	Int(8) not null,
                        primary key(mun_id))
                      ENGINE = InnoDB;
                        
create table tipo_sangre(tps_id	Int(8) not null AUTO_INCREMENT,
                         tps_tipo_san	Varchar(15) not null,
                         primary key(tps_id))
                      ENGINE = InnoDB;
                         
create table paciente(pac_id	Int(8) not null AUTO_INCREMENT,
                      pac_nom	Varchar(45) not null,
                      pac_ape	Varchar(45) not null,
                      pac_fecha_nac	Date not null,	
                      pac_peso	Decimal(8,2),
                      pac_alt	Decimal(8,2),
                      pac_gen	Varchar(1) not null,
                      pac_ale	Varchar(45),
                      pac_correo	Varchar(45),
                      pac_est	Varchar(1) not null,
                      pac_fecha_cre	Datetime not null,	
                      pac_iddir	Int(8) not null,
                      pac_idtps	Int(8) not null,
                      primary key(pac_id))
                      ENGINE = InnoDB;
                      
create table accesso(acc_id	Int(8) not null AUTO_INCREMENT,
                    acc_ult	Datetime not null,	
                    acc_idlog	Int(8) not null,
                    primary key(acc_id))
                      ENGINE = InnoDB;

create table sucursal(suc_id	Int(8) not null AUTO_INCREMENT,
                      suc_nom	Varchar(45) not null,
                      suc_iddir	Int(8) not null,
                      primary key(suc_id))
                      ENGINE = InnoDB;

create table  no_disponibilidad(nod_id	Int(8) not null AUTO_INCREMENT,
                                nod_dia	Int(2) not null,
                                nod_hora_ini	Time not null,	
                                nod_hora_fin	Time not null,	
                                nod_fecha_cre	Datetime not null,	
                                nod_idemp	Int(8) not null,
                                primary key(nod_id))
                      ENGINE = InnoDB;
                                
create table  hora_atencion(hor_id	Int(8) not null AUTO_INCREMENT,
                            hor_dia	Int(2) not null,
                            hor_hora_ape	Time not null,	
                            hor_hora_cie	Time not null,	
                            hor_fecha_cre	Datetime not null,	
                            hor_idsuc	Int(8) not null,
                            primary key(hor_id))
                      ENGINE = InnoDB;
                            
create table proveedor(prv_id	Int(8) not null AUTO_INCREMENT,
                        prv_nom	Varchar(45) not null,	
                        prv_cor	Varchar(45),
                        prv_fecha_cre	Datetime not null,	
                        prv_iddir	Int(8) not null,
                        primary key(prv_id))
                      ENGINE = InnoDB;
                      
create table solicitud_cita(slc_id	Int(8) not null AUTO_INCREMENT,
                            slc_desc	varchar(45) not null,
                            slc_fecha_sol	Datetime not null,	
                            slc_fecha_cre	Datetime not null,	
                            slc_idpac	Int(8) not null,
                            primary key(slc_id))
                      ENGINE = InnoDB;
                            
create table cita(cit_id	Int(8) not null AUTO_INCREMENT,
                  cit_fecha_cita	Date not null,	
                  cit_com	Varchar(50),
                  cit_estado	Varchar(1) not null,
                  cit_fecha_cre	Datetime not null,	
                  cit_idemp	Int(8) not null,
                  cit_idsuc	Int(8) not null,
                  cit_idpac	Int(8) not null,
                  cit_idslc	Int(8) not null,
                  primary key(cit_id))
                      ENGINE = InnoDB;
                  
create table consulta(con_id	Int(8) not null AUTO_INCREMENT,
                      con_desc	Varchar(50) not null,
                      con_diag	Varchar(50) not null,
                      con_fecha_cre	Datetime not null,	
                      con_idcit	Int(8) not null,
                      primary key(con_id))
                      ENGINE = InnoDB;

create table receta(rec_id	Int(8) not null AUTO_INCREMENT,
                    rec_desc	Varchar(50) not null,
                    rec_fecha_cre	Datetime not null,	
                    rec_idcon	Int(8) not null,
                    primary key(rec_id))
                      ENGINE = InnoDB;

create table detalle_receta(dtr_id	Int(8) not null AUTO_INCREMENT,
                            dtr_desc	Varchar(50) not null,
                            dtr_fecha_cre	Datetime not null,	
                            dtr_idrec	Int(8) not null,
                            primary key(dtr_id)
                            );
create table marca(mar_id	Int(8) not null AUTO_INCREMENT,
                    mar_nom	Varchar(45) not null,
                    primary key(mar_id))
                      ENGINE = InnoDB;
                    
create table producto(pro_id	Int(8) not null AUTO_INCREMENT,
                      pro_nom	Varchar(45) not null,
                      pro_ubi	Varchar(45),
                      pro_salant_uni	Int(8) not null,
                      pro_salant_mon	Double(8,2) not null,
                      pro_costo_uni	Double(8,2) not null,
                      pro_ult_cost	Double(8,2) not null,
                      pro_existencia	int(8) not null,
                      pro_ult_ven	Date,	
                      pro_fecha_cre	Datetime not null,	
                      pro_idsuc	Int(8) not null,
                      pro_idmar	Int(8) not null,
                      primary key(pro_id))
                      ENGINE = InnoDB;
                      
create table historico_producto(hsp_periodo	Int(8) not null AUTO_INCREMENT,
                                hsp_mes	Int(8) not null,
                                hsp_ult_cost	Double(8,2) not null,
                                hsp_sal_uni	Int(8) not null,
                                hsp_sal_mon	Double(8,2) not null,
                                hsp_cos_uni	Double(8,2) not null,
                                hsp_idpro	Int(8) not null,
                                hsp_idsuc	Int(8) not null,
                                primary key(hsp_periodo,hsp_mes))
                      ENGINE = InnoDB;
                                
create table tipo_movimiento(tpm_tipo_mov	Varchar(3) not null AUTO_INCREMENT,
                            tpm_desc	Varchar(45) not null,
                            tpm_mov	Varchar(1) not null,
                            tpm_idsuc	Int(8) not null,
                            primary key(tpm_tipo_mov))
                      ENGINE = InnoDB;
                            
create table movimiento(mov_periodo	Int(8) not null AUTO_INCREMENT,
                        mov_cos_uni	Double(8,2) not null,
                        mov_fecha	Date not null,	 
                        mov_uni	Int(8) not null,
                        mov_idsuc	Int(8) not null,
                        mov_idpro	Int(8) not null,
                        mov_tipo	Varchar(3) not null,
                        primary key(mov_periodo))
                      ENGINE = InnoDB;
                        
create table facturacion(fac_id	Int(8) not null AUTO_INCREMENT,
                        fac_desc	Varchar(45) not null,
                        fac_fecha	Date not null,	
                        fac_dir	Varchar(45),
                        fac_can	Double(8,2) not null,	
                        fac_tot	Double(8,2)	not null,
                        fac_nom_cli	Varchar(45)	not null,
                        fac_ape_cli	Varchar(45)	not null,
                        fac_tipo	Varchar(10)	not null,
                        fac_registro	Varchar(10) ,	
                        fac_fecha_cre	Datetime	not null,
                        fac_idsuc	Int(8) not null,
                        primary key(fac_id))
                      ENGINE = InnoDB;
                        
create table detalle_facturacion(dtf_id	Int(8) not null AUTO_INCREMENT,
                                dtf_can	Int(8) not null,
                                dtf_pre_uni	Double(8,2) not null,
                                dtf_tot	Double(8,2) not null,
                                dtf_fecha_cre	Datetime	not null,
                                dtf_idfac	Int(8) not null,
                                dtf_idpro	Int(8) not null,
                                primary key(dtf_id))
                      ENGINE = InnoDB;



USE `consultorio` ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;



INSERT INTO `pais`(`pai_id`,`pai_nom`) VALUES(1,'El Salvador');
INSERT INTO `departamento`(`dep_id`,`dep_nom`,`dep_idpai`) VALUES(1,'La Libertad',1);
INSERT INTO `municipio`(`mun_id`,`mun_nom`,`mun_iddep`) VALUES(1,'Santa Tecla',1);
INSERT INTO `cargo`(`car_id`,`car_nom`,`car_fecha_cre`) VALUES(1,'Doctor',NOW());
INSERT INTO `empleado`(`emp_id`,`emp_nom`,`emp_ape`,`emp_fecha_nac`,`emp_gen`,`emp_idsuc`,`emp_idcar`,`emp_idesp`,`emp_iddir`,`emp_fecha_cre`) 
VALUES(1,'Arturo','Cerna','1970-02-04',1,1,1,1,1,NOW());
INSERT INTO `login`(`log_id`,`log_usr`,`log_pss`,`log_est`,`log_idrol`,`log_idemp`) VALUES(1,'admin',md5('admin'),'a',1,1);


USE `bd_proyecto_salud`;
DROP procedure IF EXISTS `spConsultarDescripcionProcedimiento`;

DELIMITER $$
USE `bd_proyecto_salud`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarDescripcionProcedimiento`(IN filtro VARCHAR(1000))
begin
select idCup as id, nombreCup from tbl_cup where nombreCup LIKE concat('%',filtro,'%');

end$$

DELIMITER ;
--
USE `bd_proyecto_salud`;
DROP procedure IF EXISTS `spConsultarDescripcionIdProcedimiento`;

DELIMITER $$
USE `bd_proyecto_salud`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarDescripcionIdProcedimiento`(IN id INT(11))
begin
select nombreCup from tbl_cup where idCup = id;
end$$

DELIMITER ;

--
USE `bd_proyecto_salud`;
DROP procedure IF EXISTS `spConsultarCodigoIdProcedimiento`;

DELIMITER $$
USE `bd_proyecto_salud`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarCodigoIdProcedimiento`(IN id INT(11))
begin
select codigoCup from tbl_cup where idCup = id;
end$$

DELIMITER ;

--
USE `bd_proyecto_salud`;
DROP procedure IF EXISTS `spContarDescripcionProcedimiento`;

DELIMITER $$
USE `bd_proyecto_salud`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spContarDescripcionProcedimiento`(IN filtro VARCHAR(1000))
begin
select count(idCup) as cont from tbl_cup where nombreCup LIKE concat('%',filtro,'%');
end$$

DELIMITER ;

--
USE `bd_proyecto_salud`;
DROP procedure IF EXISTS `spConsultarCodigoProcedimientos`;

DELIMITER $$
USE `bd_proyecto_salud`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarCodigoProcedimientos`(IN filtro VARCHAR(45))
begin
select idCup as id, codigoCup from tbl_cup where codigoCup LIKE concat('%',filtro,'%');
end$$

DELIMITER ;



--
USE `bd_proyecto_salud`;
DROP procedure IF EXISTS `spContarCodigoProcedimiento`;

DELIMITER $$
USE `bd_proyecto_salud`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spContarCodigoProcedimiento`(IN filtro VARCHAR(45))
begin
select count(idCup) as cont from tbl_cup where codigoCup LIKE concat('%',filtro,'%');
end$$

DELIMITER ;

--
USE `bd_proyecto_salud`;
DROP procedure IF EXISTS `spConsultarDescripcionIdDiagnostico`;

DELIMITER $$
USE `bd_proyecto_salud`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarDescripcionIdDiagnostico`(IN id INT(11))
begin
select descripcionCIE10 from tbl_cie10 where idCIE10 = id;
end$$

DELIMITER ;


--
USE `bd_proyecto_salud`;
DROP procedure IF EXISTS `spConsultarCodigoIdDiagnostico`;

DELIMITER $$
USE `bd_proyecto_salud`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarCodigoIdDiagnostico`(IN id INT(11))
begin
select codigoCIE10 from tbl_cie10 where idCIE10 = id;
end$$

DELIMITER ;

--
USE `bd_proyecto_salud`;
DROP procedure IF EXISTS `spConsultarDescripcionDiagnostico`;

DELIMITER $$
USE `bd_proyecto_salud`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarDescripcionDiagnostico`(IN filtro VARCHAR(1000))
begin
select idCIE10 as id, descripcionCIE10 from tbl_cie10 where descripcionCIE10 LIKE concat('%',filtro,'%');
end$$

DELIMITER ;

--
USE `bd_proyecto_salud`;
DROP procedure IF EXISTS `spContarDiagnostico`;

DELIMITER $$
USE `bd_proyecto_salud`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spContarDiagnostico`(IN filtro VARCHAR(1000))
begin
select count(idCIE10) as cont from tbl_cie10 where descripcionCIE10 LIKE concat('%',filtro,'%');
 end$$

DELIMITER ;

--
USE `bd_proyecto_salud`;
DROP procedure IF EXISTS `spConsultarCodigoDiagnostico`;

DELIMITER $$
USE `bd_proyecto_salud`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarCodigoDiagnostico`(IN filtro VARCHAR(45))
begin
select idCIE10 as id, codigoCIE10 from tbl_cie10 where codigoCIE10 LIKE concat('%',filtro,'%');
end$$

DELIMITER ;

--
USE `bd_proyecto_salud`;
DROP procedure IF EXISTS `spContarCodigoDiagnostico`;

DELIMITER $$
USE `bd_proyecto_salud`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spContarCodigoDiagnostico`(IN filtro VARCHAR(45))
begin
select count(idCIE10) as cont from tbl_cie10 where codigoCIE10 LIKE concat('%',filtro,'%');
end$$

DELIMITER ;

--
USE `bd_proyecto_salud`;
DROP procedure IF EXISTS `spActualizarInformacionPersonal`;

DELIMITER $$
USE `bd_proyecto_salud`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spActualizarInformacionPersonal`(IN $estadoCivil VARCHAR(45),IN $ciudadResidencia VARCHAR(45),IN $barrioResidencia VARCHAR(45),IN $direccion VARCHAR(45),IN $correoElectronico VARCHAR(45),IN $telefonoFijo VARCHAR(45),IN $telefonoMovil VARCHAR(45),IN $empresa VARCHAR(45),IN $ocupacion VARCHAR(45),IN $idPaciente INT(11))
begin
UPDATE tbl_paciente set estadoCivil=$estadoCivil,ciudadResidencia=$ciudadResidencia,barrioResidencia=$barrioResidencia,direccion=$direccion,correoElectronico=$correoElectronico,telefonoFijo=$telefonoFijo,telefonoMovil=$telefonoMovil,empresa=$empresa,
ocupacion=$ocupacion where idPaciente= $idPaciente;
end$$

DELIMITER ;

--

DELIMITER $$
DROP procedure IF EXISTS `bd_proyecto_salud`.`spRegistrarTipoorigenatencionOtro` $$
USE `bd_proyecto_salud`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarTipoorigenatencionOtro`(IN descripcion VARCHAR(100))
begin
insert into tbl_tipoorigenatencion(descripcionOrigenAtencion,estadoTabla)
values(descripcion,'Inactivo');

end$$

DELIMITER ;
--

USE `bd_proyecto_salud`;
DROP procedure IF EXISTS `spUltimoDatoOrigenAtencion`;

DELIMITER $$
USE `bd_proyecto_salud`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spUltimoDatoOrigenAtencion`()
begin
select MAX(idTipoOrigenAtencion) as id from tbl_tipoorigenatencion;
end$$

DELIMITER ;



--
DELIMITER ;
USE `bd_proyecto_salud`;
DROP procedure IF EXISTS `spRegistrarHistoriaClinicaDmc`;

DELIMITER $$
USE `bd_proyecto_salud`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarHistoriaClinicaDmc`(IN fechaAtencion DATE, IN motivoAtencion TEXT, IN enfermedadActual TEXT,IN placaVehiculo VARCHAR(45), IN idTipoorigenAtencion INT(11),IN idCitaprogramacion INT(11),IN idPaciente INT(11),IN evolucion TEXT)
begin
insert into tbl_historiaclinica(fechaAtencion,motivoAtencion,enfermedadActual,placaVehiculo,idTipoorigenAtencion,idCitaprogramacion,idPaciente,evolucion)
values(fechaAtencion,motivoAtencion,enfermedadActual,placaVehiculo,idTipoOrigenAtencion,idCitaProgramacion,idPaciente,evolucion);
end$$

DELIMITER ;


--

USE `bd_proyecto_salud`;
DROP procedure IF EXISTS `spUltimoIdHistoriaClinica`;

DELIMITER $$
USE `bd_proyecto_salud`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spUltimoIdHistoriaClinica`()
begin
select max(idHistoriaClinica) as id from tbl_historiaclinica;
end $$
DELIMITER ;


--
USE `bd_proyecto_salud`;
DROP procedure IF EXISTS `spRegistrarAntecedentesDmc`;

DELIMITER $$
USE `bd_proyecto_salud`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarAntecedentesDmc`(IN descripcionAntecedente TEXT,IN	idTipoAntecedente  INT(11),IN idHistoriaClinica INT(11))
begin
insert into tbl_antecedentedmc(descripcionAntecedente,idTipoAntecedente,idHistoriaClinica)
values(descripcionAntecedente,idTipoAntecedente,idHistoriaClinica);
end$$

DELIMITER ;

--
USE `bd_proyecto_salud`;
DROP procedure IF EXISTS `spRegistrarExamenFisico`;

DELIMITER $$
USE `bd_proyecto_salud`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarExamenFisico`(IN descripcion TEXT, IN idtipoExamenFisico INT(11) ,IN estado VARCHAR(45), IN idHistoriaClinica INT(11))
begin

insert into tbl_examenfisicodmc(descripcionExamen,idtipoExamenFisico,estadoTablaExamen,idHistoriaClinica)
values(descripcion,idTipoExamenFisico,estado,idHistoriaClinica);
end$$

DELIMITER ;


--
USE `bd_proyecto_salud`;
DROP procedure IF EXISTS `spRegistrarDiagnostico`;

DELIMITER $$
USE `bd_proyecto_salud`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarDiagnostico`(IN descripcion TEXT, IN idCIE10 INT(11) ,IN idHistoriaClinica  INT(11))
begin

insert into tbl_diagnostico(descripcionDiagnostico,idCIE10,idHistoriaClinica)
 values(descripcion,idCIE10,idHistoriaClinica);

end$$

DELIMITER ;


--
USE `bd_proyecto_salud`;
DROP procedure IF EXISTS `spRegistrarProcedimiento`;

DELIMITER $$
USE `bd_proyecto_salud`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarProcedimiento`(IN descripcion VARCHAR(1000),IN idCUP INT(11),IN idHistoriaClinica INT(11))
begin

insert into tbl_procedimiento(descripcionProcedimiento,idCUP,idHistoriaClinica)
values(descripcion,idCUP,idHistoriaClinica);


end$$

DELIMITER ;


--
USE `bd_proyecto_salud`;
DROP procedure IF EXISTS `spRegistrarSignosVitales`;

DELIMITER $$
USE `bd_proyecto_salud`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarSignosVitales`(IN resultado DOUBLE,IN hora TIME,IN idValoracion INT(11), IN idHistoriaClinica INT(11))
begin

insert into tbl_signosvitales(resultado,hora,idValoracion,idHistoriaClinica)
 values(resultado,hora,idValoracion,idHistoriaClinica);


end$$

DELIMITER ;


--
USE `bd_proyecto_salud`;
DROP procedure IF EXISTS `spRegistrarMedicacionDmc`;

DELIMITER $$
USE `bd_proyecto_salud`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarMedicacionDmc`(IN dosis VARCHAR(45),IN hora TIME ,IN  viaAdministracion VARCHAR(45),IN cantidadUnidades INT(11) ,IN idDetalleKit INT(11), IN idHistoriaClinica INT(11))
begin

insert into tbl_medicamento(dosis,hora,viaAdministracion,cantidadUnidades,idDetalleKit,idHistoriaClinica)
values(dosis,hora,viaAdministracion,cantidadUnidades,idDetalleKit,idHistoriaClinica);


end$$

DELIMITER ;


--
USE `bd_proyecto_salud`;
DROP procedure IF EXISTS `spActualizarMedicacionDmc`;

DELIMITER $$
USE `bd_proyecto_salud`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spActualizarMedicacionDmc`(IN $cantidadUnidades INT(11), IN $idDetalleKit INT(11))
begin

update tbl_detallekit dt1,(select cantidadFinal-$cantidadUnidades as nuevaCantidad from tbl_detallekit
                           where idDetallekit = $idDetalleKit)as dt2 set dt1.cantidadFinal = dt2.nuevaCantidad
where idDetallekit = $idDetalleKit;


end$$

DELIMITER ;

--
USE `bd_proyecto_salud`;
DROP procedure IF EXISTS `spRegistrarTTratamiento`;

DELIMITER $$
USE `bd_proyecto_salud`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarTTratamiento`(IN Descripcion VARCHAR(1000))
begin
insert into tbl_tipotratamiento(Descripcion,categoriaItemTratamiento,estadoTabla)values(descripcion,'Básico','Inactivo');
end$$

DELIMITER ;
--

USE `bd_proyecto_salud`;
DROP procedure IF EXISTS `spUltimoIdTratamiento`;

DELIMITER $$
USE `bd_proyecto_salud`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spUltimoIdTratamiento`()
begin
select MAX(idTratamiento) as id from tbl_tratamientodmc;
end$$

DELIMITER ;


--
DELIMITER ;
USE `bd_proyecto_salud`;
DROP procedure IF EXISTS `spRegistrarDetalleTratamientoEquipoBiomedico`;

DELIMITER $$
USE `bd_proyecto_salud`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarDetalleTratamientoEquipoBiomedico`(IN descripcion VARCHAR(50),IN idTratamiento INT(11))
begin
insert into tbl_equipobiomedico(descripcion,idTratamiento) values(descripcion,idTratamiento);

end$$

DELIMITER ;



--
USE `bd_proyecto_salud`;
DROP procedure IF EXISTS `spRegistrarDetalletratamientodmcrecurso`;

DELIMITER $$
USE `bd_proyecto_salud`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarDetalletratamientodmcrecurso`(IN $idRecurso INT(11), IN $idTratamiento int(11))
BEGIN
    INSERT INTO `tbl_detalletratamientodmcrecurso`(`idRecurso`, `idTratamiento`) VALUES ($idRecurso, $idTratamiento);
    END$$

DELIMITER ;

--
USE `bd_proyecto_salud`;
DROP procedure IF EXISTS `spRegistrarFormulaMedica`;

DELIMITER $$
USE `bd_proyecto_salud`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarFormulaMedica`(IN recomendacion VARCHAR(1000),IN idHistoriaClinica INT(11))
begin
insert into tbl_formulamedica(recomendaciones,idHistoriaClinica) values(recomendacion,idHistoriaClinica);

end$$

DELIMITER ;

--
USE `bd_proyecto_salud`;
DROP procedure IF EXISTS `spUltimoIdFormula`;

DELIMITER $$
USE `bd_proyecto_salud`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spUltimoIdFormula`()
begin
select MAX(idFormulaMedica) as id from tbl_formulamedica;
end$$

DELIMITER ;


--
DELIMITER ;

USE `bd_proyecto_salud`;
DROP procedure IF EXISTS `spRegistrarFormulaMedicamento`;

DELIMITER $$
USE `bd_proyecto_salud`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarFormulaMedicamento`(IN dosificacion VARCHAR(100),IN descripcion VARCHAR(1000),IN cantidadMedicamento INT(11),IN idMedicamento INT(11),IN idFormulaMedica INT(11))
begin
insert into tbl_formulamedicamedicamentodmc(dosificacion,descripcion,cantidadMedicamento,idMedicamento,idFormulaMedica) values(dosificacion,descripcion,cantidadMedicamento,idMedicamento,idFormulaMedica);
end$$

DELIMITER ;

--
USE `bd_proyecto_salud`;
DROP procedure IF EXISTS `spRegistrarTExamenesEspecializados`;

DELIMITER $$
USE `bd_proyecto_salud`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarTExamenesEspecializados`(IN descripcion VARCHAR(1000))
begin
insert into tbl_tipoexamenespecializado(descripcion,estadoTabla) values(descripcion,'Inactivo');

end$$

DELIMITER ;

--
USE `bd_proyecto_salud`;
DROP procedure IF EXISTS `spUltimoIdTipoEspecializado`;

DELIMITER $$
USE `bd_proyecto_salud`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spUltimoIdTipoEspecializado`()
begin
select MAX(idTipoExamenEspecializado) as id from tbl_tipoexamenespecializado;
end$$

DELIMITER ;

--
USE `bd_proyecto_salud`;
DROP procedure IF EXISTS `spRegistrarExameneEspecializado`;

DELIMITER $$
USE `bd_proyecto_salud`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarExameneEspecializado`(IN historiaClinica INT(11),IN observacion TEXT,IN idTipoExamenEspecializado INT(11),IN descripcion TEXT)
begin
insert into tbl_examenespecializado(idHistoriaClinica,observaciones,idTipoExamenEspecializado,descripcion) values(historiaClinica,observacion,idTipoExamenEspecializado,descripcion);

end$$

DELIMITER ;

--
USE `bd_proyecto_salud`;
DROP procedure IF EXISTS `spRegistrarInterconsulta`;

DELIMITER $$
USE `bd_proyecto_salud`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarInterconsulta`(IN descripcionInterconsulta TEXT,IN  especialidad VARCHAR(100),IN idHistoriaClinica INT(11),IN fechaLimite DATE)
begin
insert into tbl_interconsulta(descripcionInterconsulta,especialidad,idHistoriaClinica,fechaLimite) values(descripcionInterconsulta,especialidad,idHistoriaClinica,fechaLimite);
end$$

DELIMITER ;

--
USE `bd_proyecto_salud`;
DROP procedure IF EXISTS `spRegistrarIncapacidad`;

DELIMITER $$
USE `bd_proyecto_salud`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarIncapacidad`(IN cantidadDias INT(11),IN prorroga VARCHAR(100),IN descripcionMotivo TEXT,IN idCIE10 INT(11),IN idHistoriaClinica INT(11))
begin
insert into tbl_incapacidad(cantidadDias,prorroga,descripcionMotivo,idCIE10,idHistoriaClinica) values(cantidadDias,prorroga,descripcionMotivo,idCIE10,idHistoriaClinica);
end$$

DELIMITER ;

--
USE `bd_proyecto_salud`;
DROP procedure IF EXISTS `spRegistrarOtroDmc`;

DELIMITER $$
USE `bd_proyecto_salud`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarOtroDmc`(IN descripcion TEXT,IN idHistoriaClinica INT(11))
begin

insert into tbl_otrodmc(descripcion,idHistoriaClinica) values(descripcion,idHistoriaClinica);

end$$

DELIMITER ;

--
USE `bd_proyecto_salud`;
DROP procedure IF EXISTS `spCambiarEstadoCita`;

DELIMITER $$
USE `bd_proyecto_salud`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spCambiarEstadoCita`( IN idCita INT(11))
begin

update tbl_cita set estadoTablaCita='Terminada' where idCita = idCita;
end$$

DELIMITER ;

--


--
USE `bd_proyecto_salud`;
DROP procedure IF EXISTS `spConsultarDiagnosticoDmc`;

DELIMITER $$
USE `bd_proyecto_salud`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarDiagnosticoDmc`(in $idAtencion INT)
BEGIN
  select descripcionDiagnostico,evolucion,codigoCIE10,descripcionCIE10,his.idHistoriaClinica
             from tbl_diagnostico as diag
             inner join tbl_historiaclinica as his
             on diag.idHistoriaClinica=his.idHistoriaClinica
             inner join tbl_cie10 as cie
             on diag.idCIE10=cie.idCIE10
             where diag.idHistoriaClinica=$idAtencion;
END$$

DELIMITER ;
--
USE `bd_proyecto_salud`;
DROP procedure IF EXISTS `spConsultarExamenesfisicoDmc`;

DELIMITER $$
USE `bd_proyecto_salud`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarExamenesfisicoDmc`(in $idAtencion INT)
BEGIN
  select estadoTablaExamen,descripcionExamen,descripcionExamenFisico,idHistoriaClinica
              from tbl_examenfisicodmc as exm
              inner join tbl_tipoexamenfisico as tipe
              on exm.idtipoExamenFisico=tipe.idtipoExamenFisico
              where idHistoriaClinica=$idAtencion;
END$$

DELIMITER ;



--
USE `bd_proyecto_salud`;
DROP procedure IF EXISTS `spConsultarAtencionOrigenDmc`;

DELIMITER $$
USE `bd_proyecto_salud`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarAtencionOrigenDmc`(in $idAtencion INT)
BEGIN
    select motivoAtencion,enfermedadActual,descripcionorigenAtencion,evolucion,idHistoriaClinica
    from tbl_historiaclinica as ht
    inner join tbl_tipoorigenatencion as tip on  ht.idTipoOrigenAtencion=tip.idTipoOrigenAtencion
    where ht.idHistoriaClinica=$idAtencion;
END$$

DELIMITER ;



--
USE `bd_proyecto_salud`;
DROP procedure IF EXISTS `spConsultarHoraSignosVitales`;

DELIMITER $$
USE `bd_proyecto_salud`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarHoraSignosVitales`(IN $idAtencion INT )
begin

select hora from tbl_signosvitales where idHistoriaClinica= $idAtencion limit 4;
end$$

DELIMITER ;
--
USE `bd_proyecto_salud`;
DROP procedure IF EXISTS `spConsultarMedicacionDmc`;

DELIMITER $$
USE `bd_proyecto_salud`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarMedicacionDmc`(IN $idAtencion INT)
begin

select his.dosis,his.hora,his.viaAdministracion,cantidadUnidades,nombre
              from tbl_medicamento as his
              inner join tbl_detallekit as det

              on his.idDetalleKit=det.idDetallekit
              inner join tbl_recurso as rec
              on det.idrecurso=rec.idrecurso
              where idHistoriaClinica = $idAtencion;
end$$

DELIMITER ;

--
USE `bd_proyecto_salud`;
DROP procedure IF EXISTS `spConsultarProcedimientoDmc`;

DELIMITER $$
USE `bd_proyecto_salud`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarProcedimientoDmc`(IN $idAtencion INT)
begin

select nombreCUP,codigoCup,descripcionProcedimiento,idHistoriaClinica,idProcedimiento
              from tbl_cup as cup
              inner join tbl_procedimiento as pro
              on cup.idCUP=pro.idCUP
              where idHistoriaClinica=$idAtencion;
end$$

DELIMITER ;

--
USE `bd_proyecto_salud`;
DROP procedure IF EXISTS `spConsultarPacienteIdDmc`;

DELIMITER $$
USE `bd_proyecto_salud`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarPacienteIdDmc`(IN $idAtencion INT)
begin

select  idPaciente
              from tbl_historiaclinica
              where idPaciente=$idAtencion;
end$$

DELIMITER ;

--
USE `bd_proyecto_salud`;
DROP procedure IF EXISTS `spConsultarResultadosSignosVitales`;

DELIMITER $$
USE `bd_proyecto_salud`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarResultadosSignosVitales`(IN $idAtencion INT)
begin
select resultado from tbl_signosvitales where idHistoriaClinica=$idAtencion;
end$$

DELIMITER ;

--

USE `bd_proyecto_salud`;
DROP procedure IF EXISTS `spConsultarAntecedentesDmc`;

DELIMITER $$
USE `bd_proyecto_salud`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarAntecedentesDmc`(in $idAtencion INT)
BEGIN
  SELECT tbl_tipo.descripcion,tbl_ant.idHistoriaClinica,tbl_ant.descripcionAntecedente
            from tbl_antecedentedmc as tbl_ant
            inner join tbl_tipoantecedente as tbl_tipo
            on tbl_ant.idTipoAntecedente=tbl_tipo.idTipoAntecedente
            where tbl_ant.idHistoriaClinica=$idAtencion
            order by tbl_ant.descripcionAntecedente desc;
END$$

DELIMITER ;

--
USE `bd_proyecto_salud`;
DROP procedure IF EXISTS `spRegistrarNotaenfermeria`;

DELIMITER $$
USE `bd_proyecto_salud`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarNotaenfermeria`(IN $descripcion varchar(200), IN $idPersona INT(11), IN $idProcedimiento INT(11))
BEGIN
    INSERT INTO `tbl_notaenfermeria`(`descripcion`, `idPersona`, `idProcedimiento`) VALUES ($descripcion, $idPersona, $idProcedimiento);
    END$$

DELIMITER ;

--
USE `bd_proyecto_salud`;
DROP procedure IF EXISTS `spConsultarProcedimientosNotas`;

DELIMITER $$
USE `bd_proyecto_salud`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarProcedimientosNotas`(IN $idAtencion INT)
begin

select nombreCUP,codigoCup,descripcionProcedimiento,his.idHistoriaClinica,idPaciente,enfer.descripcion,
              primerNombre,primerApellido,descripcionTdocumento,numeroDocumento,idNotaEnfermeria
              from tbl_cup as cup
              inner join tbl_procedimiento as pro
              on cup.idCUP=pro.idCUP
              inner join tbl_historiaclinica as his
              on pro.idHistoriaClinica=his.idHistoriaClinica
              inner join tbl_notaenfermeria as enfer
              on enfer.idProcedimiento=pro.idProcedimiento
              inner join tbl_persona as per
              on per.idPersona=enfer.idPersona
              inner join tbl_tipodocumento as doc
              on doc.idtipoDocumento=per.idtipoDocumento
              where pro.idHistoriaClinica=$idAtencion
              order by idNotaEnfermeria desc;
end$$

USE `bd_proyecto_salud`;
DROP procedure IF EXISTS `spConsultarPersonaAtencion`;

DELIMITER $$
USE `bd_proyecto_salud`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarPersonaAtencion`(IN `$idAtencion` INT)
  BEGIN
select per.primerNombre, ifnull(per.segundoNombre,'') as segundoNombre, per.primerApellido,per.segundoApellido, e.descripcionEspecialidad
            from tbl_cita as cit
             inner join tbl_cita_programacion as ctp
             on cit.idCita=ctp.idCita
             inner join tbl_historiaclinica as hist
             on ctp.idCitaprogramacion=hist.idCitaprogramacion
             inner join tbl_turnoprogramacion as turn
             on ctp.idTurnoProgramacion=turn.idTurnoProgramacion
        	inner join tbl_persona as per
             on per.idPersona=turn.idPersona
            INNER JOIN tbl_cuentausuario cu
            ON cu.idPersona = per.idPersona
            INNER JOIN tbl_personaespecialidad ps
            ON ps.idPersona = per.idPersona
            INNER JOIN tbl_especialidad e
            ON e.idEspecialidad = ps.idEspecialidad
            WHERE ps.estadoTablaEspecialidad ="Activo" and hist.idHistoriaClinica = $idAtencion;
	 END $$
     DELIMITER ;

     USE `bd_proyecto_salud`;
     DROP procedure IF EXISTS `spConsultarPacienteAtencion`;

     DELIMITER $$
     USE `bd_proyecto_salud`$$
     CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarPacienteAtencion`(IN `$idPaciente` INT)
       BEGIN
    SELECT * FROM tbl_paciente p
    INNER JOIN tbl_tipodocumento td ON td.idTipoDocumento = p.idtipoDocumento
    INNER JOIN tbl_tipoafiliacion ta ON ta.idTipoAfiliacion = p.idtipoAfiliacion
    WHERE idPaciente = $idPaciente;
END $$
DELIMITER;


USE `bd_proyecto_salud`;
DROP procedure IF EXISTS `spCambiarEstadoCitaCancelar`;

DELIMITER $$
USE `bd_proyecto_salud`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spCambiarEstadoCitaCancelar`(IN `$idCita` INT)
BEGIN
UPDATE tbl_cita SET estadoTablaCita='Cancelada' WHERE idCita= $idCita;
END $$
DELIMITER;

USE `bd_proyecto_salud`;
DROP procedure IF EXISTS `spCambiarCitaProceso`;

DELIMITER $$
USE `bd_proyecto_salud`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spCambiarCitaProceso`(IN `$idCita` INT)
BEGIN
UPDATE tbl_cita SET estadoTablaCita='Proceso' WHERE idCita=$idCita;
END $$
DELIMITER;

USE `bd_proyecto_salud`;
DROP procedure IF EXISTS `spConsultarPacienteAtencion`;

DELIMITER $$
USE `bd_proyecto_salud`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarPacienteAtencion`(IN `$idPaciente` INT)
BEGIN
SELECT p.idPaciente, p.numeroDocumento,p.fechaNacimiento, p.tipoSangre ,p.primerNombre,ifnull(p.segundoNombre,' ') as segundoNombre,
    p.primerApellido, p.segundoApellido,p.genero, p.estadoCivil, p.ciudadResidencia, p.barrioResidencia, p.direccion,
    p.telefonoFijo, p.telefonoMovil, p.correoElectronico, p.edadPaciente, td.descripcionTdocumento,ta.descripcionAfiliacion
    FROM tbl_paciente p
    INNER JOIN tbl_tipodocumento td ON td.idTipoDocumento = p.idtipoDocumento
    INNER JOIN tbl_tipoafiliacion ta ON ta.idTipoAfiliacion = p.idtipoAfiliacion
    WHERE idPaciente = $idPaciente;
INNER JOIN tbl_tipodocumento td ON td.idTipoDocumento = p.idtipoDocumento
INNER JOIN tbl_tipoafiliacion ta ON ta.idTipoAfiliacion = p.idtipoAfiliacion
WHERE idPaciente = $idPaciente;
END $$
DELIMITER;

USE `bd_proyecto_salud`;
DROP procedure IF EXISTS `spConsultarFechaAtencion`;

DELIMITER $$
USE `bd_proyecto_salud`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarFechaAtencion`(
  IN `$idAtencion` INT)
BEGIN
 SELECT fechaAtencion FROM `tbl_historiaclinica` WHERE idHistoriaClinica = $idAtencion;
END
$$

DELIMITER ;

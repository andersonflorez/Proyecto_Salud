DELIMITER $$
DROP PROCEDURE IF EXISTS `spRegistrarHistorialmora`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarHistorialmora`(IN $fechaHistorial date, IN $descripcionHistorial varchar(45), IN $idCita int(11))
BEGIN
     INSERT INTO `tbl_historialmora`(`fechaHistorial`, `descripcionHistorial`, `idCita`, `idMulta`) VALUES ($fechaHistorial, $descripcionHistorial, $idCita, (SELECT MAX(`idMulta`) FROM `tbl_multa` WHERE `estadoTabla` = 'Activo'));
    END$$
--

    DELIMITER ;

-- MAXIMO

-- LISTAR EQUIPOS
DELIMITER $$
DROP PROCEDURE IF EXISTS `spListarEquipoBiomedicoDmc`$$
create procedure spListarEquipoBiomedicoDmc()
begin
select idRecurso, nombre from tbl_recurso where idCategoriaRecurso = '2'  and estadoTablaRecurso = 'Activo';
end$$

-- LISTAR Medicamentos
DELIMITER $$
DROP PROCEDURE IF EXISTS `spListarMedicamentoDmc`$$
create procedure spListarMedicamentoDmc()
begin
select idRecurso, nombre from tbl_recurso where idCategoriaRecurso = '3' and estadoTablaRecurso = 'Activo';
end$$


-- ULTIMO TIPO TRATAMIENTO
DELIMITER $$
DROP PROCEDURE IF EXISTS `spUltimoIdTTratamiento`$$
create procedure spUltimoIdTTratamiento()
begin
select max(idTipoTratamiento) as id from tbl_tipotratamiento;
end$$




--
USE `bd_proyecto_salud`;
DROP procedure IF EXISTS `spListarMedicacion`;

DELIMITER $$
USE `bd_proyecto_salud`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarMedicacion`(IN idPersona VARCHAR(100))
begin
select dk.idDetalleKit,r.nombre,cantidadFinal as cantidadTotal
        from tbl_detallekit dk
        inner join tbl_recurso r
        on dk.idRecurso=r.idRecurso
        inner join tbl_asignacionkit ak
        on dk.idAsignacion = ak.idAsignacion
        where ak.idPersona = idPersona;
end$$

DELIMITER ;


--
USE `bd_proyecto_salud`;

DROP PROCEDURE IF EXISTS spConsultarCitaPersona;

USE `bd_proyecto_salud`//
DELIMITER //
CREATE PROCEDURE spConsultarCitaPersona(
    in _idCita int
    )
    BEGIN
    SELECT PA.idPaciente, PA.primerNombre, PA.primerApellido, ifnull(PA.segundoNombre,'') as 'segundoNombre',
     PA.segundoApellido,PA.numeroDocumento,C.horaInicial,C.horaFinal,C.direccionCita,
     CU.nombreCUP,CP.idCitaProgramacion,PA.barrioResidencia,z.descripcionZona,C.telefonoFijo1
     FROM tbl_cita C
     INNER JOIN tbl_paciente PA ON PA.idPaciente = C.idPaciente
     INNER JOIN tbl_cita_programacion CP ON C.idCita = CP.idcita
     INNER JOIN tbl_turnoprogramacion TP ON CP.idTurnoProgramacion = TP.idTurnoProgramacion
     INNER JOIN tbl_persona PE ON PE.idPersona = TP.idPersona
     INNER JOIN tbl_programacion P ON P.idProgramacion = TP.idProgramacion
     INNER JOIN tbl_turno T ON T.idTurno = TP.idTurno
     INNER JOIN tbl_Cup cu ON	CU.idCup = C.idCUP
     INNER JOIN tbl_zona z ON z.idZona = C.idZona
     WHERE C.idCita=_idCita;
     END //
     DELIMITER ;


--
USE `bd_proyecto_salud`;
DROP procedure IF EXISTS `spRegistrarTratamiento`;

DELIMITER $$
USE `bd_proyecto_salud`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarTratamiento`(IN descripcion VARCHAR(45),IN fecha VARCHAR(45),IN  dosis VARCHAR(45),IN idHistoriaClinica VARCHAR(45),IN idTipoTratamiento VARCHAR(45))
begin
insert into tbl_tratamientodmc(descripcionTratamiento,fechaTratamiento,dosisTratamiento,idHistoriaClinica,idTipoTratamiento) values(descripcion,fecha,dosis,idHistoriaClinica,idTipoTratamiento);
end$$

DELIMITER ;



--
USE `bd_proyecto_salud`;
DROP procedure IF EXISTS `spRegistrarDetalleTratamientoRecurso`;

DELIMITER $$
USE `bd_proyecto_salud`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarDetalleTratamientoRecurso`(IN idTratamiento VARCHAR(45),IN idRecurso VARCHAR(45))
begin
insert into tbl_detalletratamientodmcrecurso(idTratamiento,idRecurso) values(idTratamiento,idRecurso);

end$$

DELIMITER ;


--

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
DROP procedure IF EXISTS `spCambiarEstadoCitaProceso`;

DELIMITER $$
USE `bd_proyecto_salud`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spCambiarEstadoCitaProceso`(IN `$idCita` INT)
BEGIN
UPDATE tbl_cita SET estadoTablaCita='Proceso' WHERE idCita=$idCita;
END $$
DELIMITER;


--
USE `bd_proyecto_salud`;
DROP procedure IF EXISTS `spValidarCorreoElectronico`;

DELIMITER $$
USE `bd_proyecto_salud`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spValidarCorreoElectronico`(IN `$email` VARCHAR(100))
BEGIN
SELECT P.correoElectronico, cU.idUsuario
FROM tbl_persona P
INNER JOIN tbl_cuentausuario cU
ON P.idPersona = CU.idPersona
WHERE P.correoElectronico = $email
LIMIT 1;
END$$

DELIMITER ;


----


USE `bd_proyecto_salud`;
DROP procedure IF EXISTS `spConsultarProcedimientosNotas`;

DELIMITER $$
USE `bd_proyecto_salud`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarProcedimientosNotas`(IN $idProcedimiento INT)
begin

select pro.idProcedimiento, nombreCUP,codigoCup,descripcionProcedimiento,enfer.descripcion,
              primerNombre,primerApellido,descripcionTdocumento,numeroDocumento,idNotaEnfermeria
              from tbl_cup as cup
              inner join tbl_procedimiento as pro
              on cup.idCUP=pro.idCUP
              inner join tbl_notaenfermeria as enfer
              on enfer.idProcedimiento=pro.idProcedimiento
              inner join tbl_persona as per
              on per.idPersona=enfer.idPersona
              inner join tbl_tipodocumento as doc
              on doc.idtipoDocumento=per.idtipoDocumento
              where pro.idProcedimiento=$idProcedimiento
              order by idNotaEnfermeria desc;
end$$

DELIMITER ;


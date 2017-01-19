-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-06-2016 a las 19:47:26
-- Versión del servidor: 5.6.17
-- Versión de PHP: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `bd_proyecto_salud`
--
CREATE DATABASE IF NOT EXISTS `bd_proyecto_salud` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `bd_proyecto_salud`;

DELIMITER $$
--
-- Procedimientos
--
DROP PROCEDURE IF EXISTS `consultarPersonatodo`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `consultarPersonatodo`(IN $idPersona INT)
BEGIN
  SELECT  pe.primerNombre ,pe.segundoNombre, pe.primerApellido,pe.segundoApellido,pe.telefono,pe.direccion,pe.numeroDocumento,pe.sexo,pe.lugarNacimiento,pe.fechaNacimiento,pe.ciudad,pe.departamento,pe.correoElectronico,pe.estadotablaPersona,pe.pais,pe.grupoSanguineo,r.descripcionRol,pe.dependencia from tbl_persona pe inner join tbl_cuentausuario c on pe.idPersona = c.idPersona inner join tbl_rol r on r.idRol = c.idRol
   where pe.idPersona = $idPersona;
END$$

DROP PROCEDURE IF EXISTS `listarAllAutorizacion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `listarAllAutorizacion`(
$idParamedico INT,
$cedulaBusqueda VARCHAR(45)
)
BEGIN
SELECT * FROM tbl_temporalautorizacion WHERE idParamedico = $idParamedico AND cedulaPaciente = $cedulaBusqueda;
END$$

DROP PROCEDURE IF EXISTS `spActualizarCantidadRecurso`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spActualizarCantidadRecurso`(
    IN _cantidad INT(11),
    IN _idDetalleKit INT(11)
)
begin
UPDATE tbl_recurso recu,

      (SELECT re.cantidadRecurso +_cantidad AS nuevaCantidad,tbl_detallekit.idRecurso FROM tbl_detallekit
       INNER JOIN tbl_recurso re  ON tbl_detallekit.idrecurso = re.idrecurso
       WHERE idDetallekit = _idDetalleKit) AS dt2 SET recu.cantidadRecurso = dt2.nuevaCantidad

  WHERE recu.idrecurso = dt2.idRecurso;
END$$

DROP PROCEDURE IF EXISTS `spActualizarEstadoDetalleAsignacion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spActualizarEstadoDetalleAsignacion`( IN _idPersona int )
BEGIN
  UPDATE tbl_detalleasignacion SET estadoTabla = 'Inactivo' WHERE idPersona = _idPersona;
END$$

DROP PROCEDURE IF EXISTS `spActualizarEstadoNovedadReporte`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spActualizarEstadoNovedadReporte`(IN _idNovedad int )
BEGIN
  UPDATE tbl_novedadreporteinicial SET estadoNovedad = 'Atendida' where idNovedad = _idNovedad;
END$$

DROP PROCEDURE IF EXISTS `spActualizarEstadoPersona`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spActualizarEstadoPersona`(IN _idPersona int)
BEGIN
  UPDATE tbl_persona set estadoTablaPersona = 'Asignado ambulancia' where idPersona = _idPersona;
END$$

DROP PROCEDURE IF EXISTS `SpActualizarEstadoTemporal`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SpActualizarEstadoTemporal`(
  IN `$cedula` VARCHAR(200),
  IN `$fechaEnvio` DATETIME
 )
BEGIN
  UPDATE `tbl_temporalautorizacion` SET `estadoEvaluacion` = 'Cancelado' WHERE `fechaEnvio` = $fechaEnvio AND `cedulaPaciente` = $cedula;
END$$

DROP PROCEDURE IF EXISTS `spActualizarInformacionPersonal`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spActualizarInformacionPersonal`(IN $estadoCivil VARCHAR(45),IN $ciudadResidencia VARCHAR(45),IN $barrioResidencia VARCHAR(45),IN $direccion VARCHAR(45),IN $correoElectronico VARCHAR(45),IN $telefonoFijo VARCHAR(45),IN $telefonoMovil VARCHAR(45),IN $empresa VARCHAR(45),IN $ocupacion VARCHAR(45),IN $idPaciente INT(11))
begin
  UPDATE tbl_paciente set estadoCivil=$estadoCivil,ciudadResidencia=$ciudadResidencia,barrioResidencia=$barrioResidencia,direccion=$direccion,correoElectronico=$correoElectronico,telefonoFijo=$telefonoFijo,telefonoMovil=$telefonoMovil,empresa=$empresa,
  ocupacion=$ocupacion where idPaciente= $idPaciente;
end$$

DROP PROCEDURE IF EXISTS `spActualizarMedicacionDmc`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spActualizarMedicacionDmc`(IN $cantidadUnidades INT(11), IN $idDetalleKit INT(11))
begin
  update tbl_detallekit dt1,(select cantidadFinal-$cantidadUnidades as nuevaCantidad from tbl_detallekit
  where idDetallekit = $idDetalleKit)as dt2 set dt1.cantidadFinal = dt2.nuevaCantidad
  where idDetallekit = $idDetalleKit;
end$$

DROP PROCEDURE IF EXISTS `spAsignarMora`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spAsignarMora`(IN `$idPaciente` INT)
BEGIN
  SELECT
  tbl_paciente.idpaciente,
  tbl_multa.diasMulta,
  max(tbl_historialmora.fechaHistorial) as fechaHistorial
  FROM tbl_multa
  INNER JOIN tbl_historialmora
  ON tbl_multa.idMulta = tbl_historialmora.idMulta
  INNER JOIN tbl_cita
  ON tbl_historialmora.idCita = tbl_cita.idCita
  INNER JOIN tbl_paciente
  ON tbl_cita.idPaciente = tbl_paciente.idPaciente
  WHERE tbl_paciente.numeroDocumento = $idPaciente
  group by tbl_paciente.idpaciente,tbl_multa.diasMulta;
END$$

DROP PROCEDURE IF EXISTS `SpAsignarMoraPaciente`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SpAsignarMoraPaciente`(IN `$idPaciente` INT)
BEGIN
SELECT
  tbl_multa.idmulta,
  tbl_paciente.idpaciente,
  tbl_multa.diasMulta,
  tbl_historialmora.fechaHistorial
FROM tbl_multa
INNER JOIN tbl_historialmora
ON tbl_multa.idMulta = tbl_historialmora.idMulta INNER JOIN tbl_cita
ON tbl_historialmora.idCita = tbl_cita.idCita
INNER JOIN tbl_paciente
ON tbl_cita.idPaciente = tbl_paciente.idPaciente
WHERE
   tbl_paciente.idPaciente = $idPaciente;
END$$

DROP PROCEDURE IF EXISTS `spAutenticarMedico`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spAutenticarMedico`(
IN `$usuario` VARCHAR(45),
IN `$clave` VARCHAR(45)
)
BEGIN
SELECT TC.idUsuario FROM tbl_cuentausuario TC
INNER JOIN tbl_rol TR
ON TR.idRol = TC.idRol
WHERE TC.usuario = `$usuario` AND TC.clave = `$clave` AND TR.descripcionRol = 'Medico';
END$$

DROP PROCEDURE IF EXISTS `spCambiarCitaProceso`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spCambiarCitaProceso`(IN `$idCita` INT)
BEGIN
  UPDATE tbl_cita SET estadoTablaCita='Proceso' WHERE idCita=$idCita;
END$$

DROP PROCEDURE IF EXISTS `spCambiarEstadoAfectadoaccidentetransito`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spCambiarEstadoAfectadoaccidentetransito`(IN $idAfectadoAccidenteTransito INT, IN $estadoTabla varchar(50))
BEGIN
      UPDATE `tbl_afectadoaccidentetransito` SET `estadoTabla` = $estadoTabla WHERE `idAfectadoAccidenteTransito` = $idAfectadoAccidenteTransito;
      END$$

DROP PROCEDURE IF EXISTS `spCambiarEstadoAmbulancia`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spCambiarEstadoAmbulancia`(IN $idAmbulancia INT, IN $estadoTabla varchar(45))
BEGIN
      UPDATE `tbl_ambulancia` SET `estadoTabla` = $estadoTabla WHERE `idAmbulancia` = $idAmbulancia;
      END$$

DROP PROCEDURE IF EXISTS `spCambiarEstadoAsignacionkit`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spCambiarEstadoAsignacionkit`(IN $idAsignacion INT, IN $estadoTablaAsignacionKit varchar(45))
BEGIN
      UPDATE `tbl_asignacionkit` SET `estadoTablaAsignacionKit` = $estadoTablaAsignacionKit WHERE `idAsignacion` = $idAsignacion;
      END$$

DROP PROCEDURE IF EXISTS `spCambiarEstadoAsignacionpersonal`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spCambiarEstadoAsignacionpersonal`(IN $idAsignacionPersonal INT, IN $estadoTablaAsignacion varchar(45))
BEGIN
      UPDATE `tbl_asignacionpersonal` SET `estadoTablaAsignacion` = $estadoTablaAsignacion WHERE `idAsignacionPersonal` = $idAsignacionPersonal;
      END$$

DROP PROCEDURE IF EXISTS `spCambiarEstadoCategoriaautorizacion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spCambiarEstadoCategoriaautorizacion`(IN $idCategoriaAutorizacion INT, IN $estadoTabla varchar(50))
BEGIN
      UPDATE `tbl_categoriaautorizacion` SET `estadoTabla` = $estadoTabla WHERE `idCategoriaAutorizacion` = $idCategoriaAutorizacion;
      END$$

DROP PROCEDURE IF EXISTS `spCambiarEstadoCategoriarecurso`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spCambiarEstadoCategoriarecurso`(IN $idCategoriaRecurso INT, IN $estadoTabla varchar(50))
BEGIN
      UPDATE `tbl_categoriarecurso` SET `estadoTabla` = $estadoTabla WHERE `idCategoriaRecurso` = $idCategoriaRecurso;
      END$$

DROP PROCEDURE IF EXISTS `spCambiarEstadoCertificadoatencion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spCambiarEstadoCertificadoatencion`(IN $idCertificadoAtencion INT, IN $estadoTabla varchar(50))
BEGIN
      UPDATE `tbl_certificadoatencion` SET `estadoTabla` = $estadoTabla WHERE `idCertificadoAtencion` = $idCertificadoAtencion;
      END$$

DROP PROCEDURE IF EXISTS `spCambiarEstadoChat`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spCambiarEstadoChat`(IN $idUsuarioExterno INT)
BEGIN
  UPDATE `tbl_chat`
  SET `estadoTabla` = 0
  WHERE idUsuarioExterno = $idUsuarioExterno AND estadoTabla = 1;
END$$

DROP PROCEDURE IF EXISTS `spCambiarEstadoCie10`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spCambiarEstadoCie10`(IN $idCIE10 INT, IN $estadoTabla varchar(50))
BEGIN
      UPDATE `tbl_cie10` SET `estadoTabla` = $estadoTabla WHERE `idCIE10` = $idCIE10;
      END$$

DROP PROCEDURE IF EXISTS `spCambiarEstadoCita`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spCambiarEstadoCita`( IN $idCita INT(11))
begin
  update tbl_cita set estadoTablaCita='Terminada' where idCita = $idCita;
end$$

DROP PROCEDURE IF EXISTS `spCambiarEstadoCitaCancelar`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spCambiarEstadoCitaCancelar`(IN `$idCita` INT)
BEGIN
  UPDATE tbl_cita SET estadoTablaCita='Cancelada' WHERE idCita= $idCita;
END$$

DROP PROCEDURE IF EXISTS `spCambiarEstadoCitaProceso`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spCambiarEstadoCitaProceso`(IN `$idCita` INT)
BEGIN
  UPDATE tbl_cita SET estadoTablaCita='Proceso' WHERE idCita=$idCita;
END$$

DROP PROCEDURE IF EXISTS `spCambiarEstadoConfiguracion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spCambiarEstadoConfiguracion`(IN $idConfiguracion INT, IN $estadoTabla varchar(50))
BEGIN
      UPDATE `tbl_configuracion` SET `estadoTabla` = $estadoTabla WHERE `idConfiguracion` = $idConfiguracion;
      END$$

DROP PROCEDURE IF EXISTS `spCambiarEstadoCup`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spCambiarEstadoCup`(IN $idCUP INT, IN $estadoTabla varchar(50))
BEGIN
      UPDATE `tbl_cup` SET `estadoTabla` = $estadoTabla WHERE `idCUP` = $idCUP;
      END$$

DROP PROCEDURE IF EXISTS `spCambiarEstadoDetalleasignacion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spCambiarEstadoDetalleasignacion`(IN $idDetalleAsignacion INT, IN $estadoTabla varchar(50))
BEGIN
      UPDATE `tbl_detalleasignacion` SET `estadoTabla` = $estadoTabla WHERE `idDetalleAsignacion` = $idDetalleAsignacion;
      END$$

DROP PROCEDURE IF EXISTS `spCambiarEstadoDevolucion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spCambiarEstadoDevolucion`(IN $idDevolucion INT, IN $estadoTablaDevolucion varchar(45))
BEGIN
      UPDATE `tbl_devolucion` SET `estadoTablaDevolucion` = $estadoTablaDevolucion WHERE `idDevolucion` = $idDevolucion;
      END$$

DROP PROCEDURE IF EXISTS `spCambiarEstadoEnteexterno`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spCambiarEstadoEnteexterno`(IN $idEnteExterno INT, IN $estadoTabla varchar(50))
BEGIN
      UPDATE `tbl_enteexterno` SET `estadoTabla` = $estadoTabla WHERE `idEnteExterno` = $idEnteExterno;
      END$$

DROP PROCEDURE IF EXISTS `spCambiarEstadoEspecialidad`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spCambiarEstadoEspecialidad`(IN $idEspecialidad INT, IN $estadoTabla varchar(50))
BEGIN
      UPDATE `tbl_especialidad` SET `estadoTabla` = $estadoTabla WHERE `idEspecialidad` = $idEspecialidad;
      END$$

DROP PROCEDURE IF EXISTS `spCambiarEstadoEstadopaciente`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spCambiarEstadoEstadopaciente`(IN $idEstadoPaciente INT, IN $estadoTabla varchar(50))
BEGIN
      UPDATE `tbl_estadopaciente` SET `estadoTabla` = $estadoTabla WHERE `idEstadoPaciente` = $idEstadoPaciente;
      END$$

DROP PROCEDURE IF EXISTS `spCambiarEstadoEstandarkit`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spCambiarEstadoEstandarkit`(IN $idEstandarkit INT, IN $estadoTablaEstandarKit varchar(45))
BEGIN
      UPDATE `tbl_estandarkit` SET `estadoTablaEstandarKit` = $estadoTablaEstandarKit WHERE `idEstandarkit` = $idEstandarkit;
      END$$

DROP PROCEDURE IF EXISTS `spCambiarEstadoExamenfisicodmc`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spCambiarEstadoExamenfisicodmc`(IN $idExamenFisico INT, IN $estadoTablaExamen varchar(45))
BEGIN
      UPDATE `tbl_examenfisicodmc` SET `estadoTablaExamen` = $estadoTablaExamen WHERE `idExamenFisico` = $idExamenFisico;
      END$$

DROP PROCEDURE IF EXISTS `spCambiarEstadoMulta`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spCambiarEstadoMulta`(IN $idMulta INT, IN $estadoTabla varchar(50))
BEGIN
      UPDATE `tbl_multa` SET `estadoTabla` = $estadoTabla WHERE `idMulta` = $idMulta;
      END$$

DROP PROCEDURE IF EXISTS `spCambiarEstadoNovedadrecurso`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spCambiarEstadoNovedadrecurso`(IN $idNovedadRecurso INT, IN $estadoTablaNovedad varchar(45))
BEGIN
      UPDATE `tbl_novedadrecurso` SET `estadoTablaNovedad` = $estadoTablaNovedad WHERE `idNovedadRecurso` = $idNovedadRecurso;
      END$$

DROP PROCEDURE IF EXISTS `spCambiarEstadoPaciente`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spCambiarEstadoPaciente`(IN `$idPaciente` INT, IN `$idEstadoPaciente` INT)
BEGIN
  UPDATE `tbl_paciente` SET `idEstadoPaciente` = $idEstadoPaciente
  WHERE `tbl_paciente`.`idPaciente` = $idPaciente;
END$$

DROP PROCEDURE IF EXISTS `spCambiarEstadoPersona`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spCambiarEstadoPersona`(IN $idPersona INT, IN $estadoTablaPersona varchar(50))
BEGIN
      UPDATE `tbl_persona` SET `estadoTablaPersona` = $estadoTablaPersona WHERE `idPersona` = $idPersona;
      END$$

DROP PROCEDURE IF EXISTS `spCambiarEstadoPersonaespecialidad`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spCambiarEstadoPersonaespecialidad`(IN $idPersonaespecialidad INT, IN $estadoTablaEspecialidad varchar(50))
BEGIN
      UPDATE `tbl_personaespecialidad` SET `estadoTablaEspecialidad` = $estadoTablaEspecialidad WHERE `idPersonaespecialidad` = $idPersonaespecialidad;
      END$$

DROP PROCEDURE IF EXISTS `spCambiarEstadoProgramacion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spCambiarEstadoProgramacion`(IN $idPersona INT)
BEGIN
  UPDATE tbl_turnoprogramacion e set e.estadoTablaProgramacion = 'Inactivo'
  where e.idPersona = $idPersona;
END$$

DROP PROCEDURE IF EXISTS `spCambiarEstadoRecurso`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spCambiarEstadoRecurso`(IN $idrecurso INT, IN $estadoTablaRecurso varchar(50))
BEGIN
      UPDATE `tbl_recurso` SET `estadoTablaRecurso` = $estadoTablaRecurso WHERE `idrecurso` = $idrecurso;
      END$$

DROP PROCEDURE IF EXISTS `spCambiarEstadoReporteaph`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spCambiarEstadoReporteaph`(IN $idReporteAPH INT, IN $estadoTablaReporteAPH varchar(50))
BEGIN
      UPDATE `tbl_reporteaph` SET `estadoTablaReporteAPH` = $estadoTablaReporteAPH WHERE `idReporteAPH` = $idReporteAPH;
      END$$

DROP PROCEDURE IF EXISTS `spCambiarEstadoReporteinicial`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spCambiarEstadoReporteinicial`(IN $idReporteInicial INT, IN $estadoTablaReporteInicial varchar(50))
BEGIN
      UPDATE `tbl_reporteinicial` SET `estadoTablaReporteInicial` = $estadoTablaReporteInicial WHERE `idReporteInicial` = $idReporteInicial;
      END$$

DROP PROCEDURE IF EXISTS `spCambiarEstadoRol`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spCambiarEstadoRol`(IN $idRol INT, IN $estadoTabla varchar(50))
BEGIN
      UPDATE `tbl_rol` SET `estadoTabla` = $estadoTabla WHERE `idRol` = $idRol;
      END$$

DROP PROCEDURE IF EXISTS `spCambiarEstadoTipoafiliacion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spCambiarEstadoTipoafiliacion`(IN $idTipoAfiliacion INT, IN $estadoTabla varchar(50))
BEGIN
      UPDATE `tbl_tipoafiliacion` SET `estadoTabla` = $estadoTabla WHERE `idTipoAfiliacion` = $idTipoAfiliacion;
      END$$

DROP PROCEDURE IF EXISTS `spCambiarEstadoTipoantecedente`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spCambiarEstadoTipoantecedente`(IN $idTipoAntecedente INT, IN $estadoTabla varchar(50))
BEGIN
      UPDATE `tbl_tipoantecedente` SET `estadoTabla` = $estadoTabla WHERE `idTipoAntecedente` = $idTipoAntecedente;
      END$$

DROP PROCEDURE IF EXISTS `spCambiarEstadoTipoaseguramiento`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spCambiarEstadoTipoaseguramiento`(IN $idTipoAseguramiento INT, IN $estadoTabla varchar(50))
BEGIN
      UPDATE `tbl_tipoaseguramiento` SET `estadoTabla` = $estadoTabla WHERE `idTipoAseguramiento` = $idTipoAseguramiento;
      END$$

DROP PROCEDURE IF EXISTS `spCambiarEstadoTipoasignacion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spCambiarEstadoTipoasignacion`(IN $idTipoAsignacion INT, IN $estadoTabla varchar(50))
BEGIN
      UPDATE `tbl_tipoasignacion` SET `estadoTabla` = $estadoTabla WHERE `idTipoAsignacion` = $idTipoAsignacion;
      END$$

DROP PROCEDURE IF EXISTS `spCambiarEstadoTipodevolucion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spCambiarEstadoTipodevolucion`(IN $idTipoDevolucion INT, IN $estadoTabla varchar(50))
BEGIN
      UPDATE `tbl_tipodevolucion` SET `estadoTabla` = $estadoTabla WHERE `idTipoDevolucion` = $idTipoDevolucion;
      END$$

DROP PROCEDURE IF EXISTS `spCambiarEstadoTipodocumento`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spCambiarEstadoTipodocumento`(IN $idTipoDocumento INT, IN $estadoTabla varchar(50))
BEGIN
      UPDATE `tbl_tipodocumento` SET `estadoTabla` = $estadoTabla WHERE `idTipoDocumento` = $idTipoDocumento;
      END$$

DROP PROCEDURE IF EXISTS `spCambiarEstadoTipoevento`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spCambiarEstadoTipoevento`(IN $idTipoEvento INT, IN $estadoTabla varchar(50))
BEGIN
      UPDATE `tbl_tipoevento` SET `estadoTabla` = $estadoTabla WHERE `idTipoEvento` = $idTipoEvento;
      END$$

DROP PROCEDURE IF EXISTS `spCambiarEstadoTipoexamenespecializado`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spCambiarEstadoTipoexamenespecializado`(IN $idTipoExamenEspecializado INT, IN $estadoTabla varchar(45))
BEGIN
      UPDATE `tbl_tipoexamenespecializado` SET `estadoTabla` = $estadoTabla WHERE `idTipoExamenEspecializado` = $idTipoExamenEspecializado;
      END$$

DROP PROCEDURE IF EXISTS `spCambiarEstadoTipoexamenfisico`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spCambiarEstadoTipoexamenfisico`(IN $idtipoExamenFisico INT, IN $estadoTabla varchar(50))
BEGIN
      UPDATE `tbl_tipoexamenfisico` SET `estadoTabla` = $estadoTabla WHERE `idtipoExamenFisico` = $idtipoExamenFisico;
      END$$

DROP PROCEDURE IF EXISTS `spCambiarEstadoTipokit`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spCambiarEstadoTipokit`(IN $idTipoKit INT, IN $estadoTabla varchar(50))
BEGIN
      UPDATE `tbl_tipokit` SET `estadoTabla` = $estadoTabla WHERE `idTipoKit` = $idTipoKit;
      END$$

DROP PROCEDURE IF EXISTS `spCambiarEstadoTiponovedad`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spCambiarEstadoTiponovedad`(IN $idTipoNovedad INT, IN $estadoTabla varchar(50))
BEGIN
      UPDATE `tbl_tiponovedad` SET `estadoTabla` = $estadoTabla WHERE `idTipoNovedad` = $idTipoNovedad;
      END$$

DROP PROCEDURE IF EXISTS `spCambiarEstadoTipoorigenatencion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spCambiarEstadoTipoorigenatencion`(IN $idTipoOrigenAtencion INT, IN $estadoTabla varchar(50))
BEGIN
      UPDATE `tbl_tipoorigenatencion` SET `estadoTabla` = $estadoTabla WHERE `idTipoOrigenAtencion` = $idTipoOrigenAtencion;
      END$$

DROP PROCEDURE IF EXISTS `spCambiarEstadoTipotratamiento`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spCambiarEstadoTipotratamiento`(IN $idTipoTratamiento INT, IN $estadoTabla varchar(50))
BEGIN
      UPDATE `tbl_tipotratamiento` SET `estadoTabla` = $estadoTabla WHERE `idTipoTratamiento` = $idTipoTratamiento;
      END$$

DROP PROCEDURE IF EXISTS `spCambiarEstadoTipozona`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spCambiarEstadoTipozona`(IN $idTipoZona INT, IN $estadoTabla varchar(50))
BEGIN
      UPDATE `tbl_tipozona` SET `estadoTabla` = $estadoTabla WHERE `idTipoZona` = $idTipoZona;
      END$$

DROP PROCEDURE IF EXISTS `spCambiarEstadoTriage`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spCambiarEstadoTriage`(IN $idTriage INT, IN $estadoTabla varchar(50))
BEGIN
      UPDATE `tbl_triage` SET `estadoTabla` = $estadoTabla WHERE `idTriage` = $idTriage;
      END$$

DROP PROCEDURE IF EXISTS `spCambiarEstadoTurnoprogramacion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spCambiarEstadoTurnoprogramacion`(IN $idTurnoProgramacion INT, IN $estadoTablaProgramacion varchar(45))
BEGIN
      UPDATE `tbl_turnoprogramacion` SET `estadoTablaProgramacion` = $estadoTablaProgramacion WHERE `idTurnoProgramacion` = $idTurnoProgramacion;
      END$$

DROP PROCEDURE IF EXISTS `spCambiarEstadoZona`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spCambiarEstadoZona`(IN $idZona INT, IN $estadoTabla varchar(50))
BEGIN
      UPDATE `tbl_zona` SET `estadoTabla` = $estadoTabla WHERE `idZona` = $idZona;
      END$$

DROP PROCEDURE IF EXISTS `spCancelarCita`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spCancelarCita`(IN `$idCita` INT)
BEGIN
  update tbl_cita set estadoTablaCita = 'Cancelada' where idCita = $idCita;
END$$

DROP PROCEDURE IF EXISTS `spCancelarCitaRegistrarMora`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spCancelarCitaRegistrarMora`(IN `$fecha` DATE, IN `$descripcion` VARCHAR(45), IN `$idCita` INT)
BEGIN
 insert into tbl_historialmora(fechaHistorial,`descripcionHistorial`,`idCita`,`idMulta`) values($fecha,$descripcion,$idCita,(select max(idMulta) from tbl_multa where estadoTabla = 'Activo'));
END$$

DROP PROCEDURE IF EXISTS `spCancelarReporteinicial`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spCancelarReporteinicial`(IN $descripcion VARCHAR(300), IN $estadoReporte VARCHAR(50), IN $idChat INT)
BEGIN
  INSERT INTO `tbl_reporteinicial`(`informacionInicial`,`estadoTablaReporteInicial`,`idChat`)
  VALUES ($descripcion,$estadoReporte, $idChat);
END$$

DROP PROCEDURE IF EXISTS `spCitasAgendadas`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spCitasAgendadas`()
BEGIN
  SELECT  PE.primerNombre AS 'medico', PE.primerApellido AS 'medicoape', PA.idPaciente, PA.primerNombre AS 'paciente', PA.primerApellido,PA.numeroDocumento,C.horaInicial,C.horaFinal,P.Fecha_inicial AS 'fecha',C.direccionCita,CU.nombreCUP
  FROM tbl_cita C
  INNER JOIN tbl_paciente PA
  ON PA.idPaciente = C.idPaciente
  INNER JOIN tbl_cita_programacion CP
  ON C.idCita = CP.idcita
  INNER JOIN tbl_turnoprogramacion TP
  ON CP.idTurnoProgramacion = TP.idTurnoProgramacion
  INNER JOIN tbl_persona PE
  ON PE.idPersona = TP.idPersona
  INNER JOIN tbl_programacion P
  ON P.idProgramacion = TP.idProgramacion
  INNER JOIN tbl_turno T
  ON T.idTurno = TP.idTurno
  INNER JOIN tbl_Cup cu
  ON  CU.idCup = C.idCUP;
END$$

DROP PROCEDURE IF EXISTS `spCitasAsignadas`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spCitasAsignadas`(IN `$idPaciente` INT(11))
BEGIN
  SELECT COUNT(c.estadoTablaCita) as 'Citas_Asignadas', p.idEstadoPaciente FROM tbl_cita c inner join tbl_paciente p on p.idPaciente = c.idPaciente WHERE c.idPaciente=$idPaciente AND c.estadoTablaCita='Iniciada';
END$$

DROP PROCEDURE IF EXISTS `spConcultaPermisoAsignado`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConcultaPermisoAsignado`(IN `$descripcionRol` VARCHAR(45))
BEGIN
  SELECT v.descripcionVista
  FROM tbl_rolmodulovista rmv
  INNER JOIN tbl_rol r
  ON r.idRol = rmv.idRol
  INNER JOIN tbl_modulo m
  ON m.idModulo = rmv.idModulo
  INNER JOIN tbl_vista v
  ON v.idVista = rmv.idVista
  WHERE r.descripcionRol = $descripcionRol;
END$$

DROP PROCEDURE IF EXISTS `spConfiguracionAsignada`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConfiguracionAsignada`(IN $idCup INT)
BEGIN
SELECT tbl_configuracion.cantidadCitasDia,tbl_configuracion.cantidadCitasMes
FROM tbl_cup
INNER JOIN tbl_configuracion
ON tbl_cup.idConfiguracion=tbl_configuracion.idConfiguracion
WHERE tbl_cup.idCUP=$idCup AND tbl_configuracion.estadoTabla LIKE 'Activo';
END$$

DROP PROCEDURE IF EXISTS `spConfirmacionDatos`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConfirmacionDatos`(IN $numDoc varchar(45), IN $fechaNac date, IN $idTipoD INT(11))
BEGIN
  SELECT idPaciente, tbl_estadopaciente.descripcionEstadoPaciente, primerNombre, segundoNombre, primerApellido, segundoApellido, ciudadResidencia, barrioResidencia, direccion, correoElectronico, telefonoFijo, telefonoMovil
  FROM `tbl_paciente`
  INNER JOIN tbl_estadopaciente
  ON tbl_paciente.idEstadoPaciente = tbl_estadopaciente.idEstadoPaciente
  WHERE (numeroDocumento = `$numDoc` AND fechaNacimiento = `$fechaNac`) AND (idtipoDocumento = `$idTipoD` AND tbl_estadopaciente.estadoTabla LIKE 'Activo');
END$$

DROP PROCEDURE IF EXISTS `spConfirmarAsignacion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConfirmarAsignacion`(
    IN _idConsulta INT,
    IN _tipoCampo VARCHAR(45),
    IN _fecha DateTime
)
BEGIN
   	SET @fecha = _fecha;
    IF _tipoCampo = 'ambulancia' THEN

		SELECT det.*, RE.nombre
        FROM tbl_asignacionkit asi
        INNER JOIN tbl_detallekit det on asi.idAsignacion = det.idAsignacion
        INNER JOIN tbl_recurso RE ON det.idrecurso = RE.idrecurso
        WHERE  asi.fechaHoraAsignacion LIKE CONCAT('%', @fecha,'%') AND asi.idAmbulancia = _idConsulta;

       ELSEIF _tipoCampo = 'persona' THEN
		SELECT det.*, RE.nombre
        FROM tbl_asignacionkit asi
        INNER JOIN tbl_detallekit det on asi.idAsignacion = det.idAsignacion
        INNER JOIN tbl_recurso RE ON det.idrecurso = RE.idrecurso

        WHERE  asi.fechaHoraAsignacion LIKE CONCAT('%', @fecha,'%') AND asi.idPersona = _idConsulta;

          ELSE
		SELECT det.*, RE.nombre
        FROM tbl_asignacionkit asi
        INNER JOIN tbl_detallekit det on asi.idAsignacion = det.idAsignacion
        INNER JOIN tbl_recurso RE ON det.idrecurso = RE.idrecurso

      WHERE  asi.fechaHoraAsignacion LIKE CONCAT('%', @fecha,'%') AND asi.idPaciente = _idConsulta;
       END IF;
END$$

DROP PROCEDURE IF EXISTS `spConfirmarLlegada`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConfirmarLlegada`($idDespacho INT)
BEGIN
  UPDATE `tbl_despacho`
  SET `estadoDespacho`= 'En emergencia'
  WHERE idDespacho = $idDespacho;
END$$

DROP PROCEDURE IF EXISTS `spConsultaAuxEnfermeria`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultaAuxEnfermeria`(
  IN $ola INT, IN $FechaCapt DATE, IN $Hora TIME
)
BEGIN

  DECLARE idPersona INT;
  DECLARE PrimerN VARCHAR(45);
  DECLARE SegundoN VARCHAR(45);
  DECLARE PrimerA VARCHAR(45);
  DECLARE SegundoA VARCHAR(45);
  DECLARE descripcionRol VARCHAR(45);
  DECLARE IdTurnoP INT;

  DECLARE no_more_rows BOOLEAN;
  DECLARE loop_cntr INT DEFAULT 0;
  DECLARE num_rows INT DEFAULT 0;

  DECLARE friends_cur CURSOR FOR
SELECT DISTINCT tbl_persona.idPersona, tbl_persona.primerNombre, tbl_persona.segundoNombre,  tbl_persona.primerApellido, tbl_persona.segundoApellido,  tbl_rol.descripcionRol,tbl_turnoprogramacion.idTurnoProgramacion
  FROM  tbl_turnoprogramacion
  INNER JOIN tbl_turno
  ON tbl_turnoprogramacion.idTurno = tbl_turno.idTurno
  INNER JOIN tbl_programacion
  ON tbl_turnoprogramacion.idProgramacion = tbl_programacion.idProgramacion
  INNER JOIN tbl_persona
  ON tbl_turnoprogramacion.idPersona = tbl_persona.idPersona
  INNER JOIN tbl_cuentausuario
  ON tbl_persona.idPersona = tbl_cuentausuario.idPersona
  INNER JOIN tbl_rol
  ON tbl_cuentausuario.idRol = tbl_rol.idRol
  WHERE (tbl_rol.descripcionRol LIKE 'Auxiliar de enfermeria' AND tbl_rol.estadoTabla LIKE 'Activo') AND (tbl_persona.estadoTablaPersona LIKE 'Activo' AND tbl_persona.dependencia LIKE 'Domiciliaria') AND ($Hora BETWEEN tbl_turno.horaInicioTurno AND tbl_turno.horaFinalTurno) AND ($FechaCapt = tbl_programacion.Fecha_inicial) AND (tbl_turnoprogramacion.estadoTablaProgramacion LIKE 'Activo');

  DECLARE CONTINUE HANDLER FOR NOT FOUND
    SET no_more_rows = TRUE;

  CREATE TEMPORARY TABLE tbl_registrosTemporalesEnfermeroJ(
    idPerson INT,
    PNmbre varchar(45),
    SNombre varchar(45),
PApellido varchar(45),
SApellido varchar(45),
descripcionRol varchar(45),
IdTProgramacion INT
);

  OPEN friends_cur;
  select FOUND_ROWS() into num_rows;

  the_loop: LOOP

    FETCH  friends_cur
    INTO   idPersona,
           PrimerN,
           SegundoN,
           PrimerA,
           SegundoA,
           descripcionRol,
           IdTurnoP;

    IF no_more_rows THEN
        CLOSE friends_cur;
        LEAVE the_loop;
    END IF;

   IF NOT EXISTS(
       SELECT tbl_cita.fechaCita,tbl_cita.horaInicial
    FROM tbl_turnoprogramacion
    INNER JOIN tbl_cita_programacion
    ON tbl_turnoprogramacion.idTurnoProgramacion=tbl_cita_programacion.idTurnoProgramacion
INNER JOIN tbl_cita
    ON tbl_cita_programacion.idCita=tbl_cita.idCita
    WHERE
    idPersona=tbl_turnoprogramacion.idPersona
    AND tbl_cita.fechaCita=$FechaCapt
    AND tbl_cita.horaInicial=$Hora
    AND (tbl_cita.estadoTablaCita = 'Iniciada')) THEN

   INSERT INTO tbl_registrosTemporalesEnfermeroJ VALUES( idPersona,
           PrimerN,
           SegundoN,
           PrimerA,
           SegundoA,
           descripcionRol,
           IdTurnoP);
    END IF;

    SET loop_cntr = loop_cntr + 1;

  END LOOP the_loop;
SELECT * FROM tbl_registrosTemporalesEnfermeroJ;
END$$

DROP PROCEDURE IF EXISTS `spConsultaBasicadelTratamiento`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultaBasicadelTratamiento`(IN _idPaciente int)
BEGIN
  select hist.idHistoriaClinica,hist.fechaAtencion,pac.telefonoFijo,pac.primerNombre as 'NombrePaciente',pac.direccion, per.primerNombre
  from tbl_paciente as pac
  inner join tbl_cita as cit
  on pac.idPaciente = cit.idPaciente
  inner join tbl_cita_programacion as ctp
  on cit.idCita=ctp.idCita
  inner join tbl_historiaclinica as hist
  on ctp.idCitaprogramacion=hist.idCitaprogramacion
  inner join tbl_turnoprogramacion as turn
  on ctp.idTurnoProgramacion=turn.idTurnoProgramacion
  inner join tbl_persona as per
  on per.idPersona=turn.idPersona
  inner join tbl_tratamientodmc on hist.idHistoriaClinica = tbl_tratamientodmc.idHistoriaClinica
  inner join tbl_detalletratamientodmcrecurso dett on tbl_tratamientodmc.idTratamiento = dett.idTratamiento
  where hist.idPaciente=_idPaciente and estadoTablaCita='Terminada';
END$$

DROP PROCEDURE IF EXISTS `spConsultaBasicaTratamiento`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultaBasicaTratamiento`()
BEGIN
SELECT  PA.idPaciente,PA.primerNombre, PA.primerApellido, PA.segundoApellido,
    PA.numeroDocumento,PA.ciudadResidencia,PA.barrioResidencia,
    tbr.nombre, tbr.cantidadRecurso,tbt.descripcionTratamiento,tbt.fechaTratamiento
    FROM tbl_cita C
    INNER JOIN tbl_paciente PA ON PA.idPaciente = C.idPaciente
    INNER JOIN tbl_cita_programacion CP ON C.idCita = CP.idcita
    INNER JOIN tbl_turnoprogramacion TP ON CP.idTurnoProgramacion = TP.idTurnoProgramacion
    INNER JOIN tbl_persona PE ON PE.idPersona = TP.idPersona
    INNER JOIN tbl_programacion P ON P.idProgramacion = TP.idProgramacion
    INNER JOIN tbl_turno T ON T.idTurno = TP.idTurno
    INNER JOIN tbl_Cup cu ON	CU.idCup = C.idCUP
    INNER JOIN tbl_zona z ON z.idZona = C.idZona
    INNER JOIN tbl_historiaclinica tbh ON PA.idPaciente = tbh.idPaciente
    INNER JOIN tbl_tratamientodmc tbt ON tbh.idHistoriaClinica = tbt.idHistoriaClinica
    INNER JOIN tbl_detalletratamientodmcrecurso tbd ON tbt.idTratamiento = tbd.idDetalleTratamientodmcRecurso
    INNER JOIN tbl_recurso tbr ON tbd.idRecurso = tbr.idrecurso
    INNER JOIN tbl_categoriarecurso tbcg ON tbr.idCategoriaRecurso = tbcg.idCategoriaRecurso;
END$$

DROP PROCEDURE IF EXISTS `spConsultaCitasDia`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultaCitasDia`(IN $idPaciente INT(11), IN $fechaActual DATE)
BEGIN
SELECT
COUNT(tbl_cita.idCita) AS "Cantidad_Citas_Dia"
FROM
tbl_cita
WHERE
tbl_cita.idPaciente = $idPaciente
AND tbl_cita.fechaRegistro = $fechaActual;
END$$

DROP PROCEDURE IF EXISTS `spConsultaCitasMes`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultaCitasMes`(IN $idPaciente INT(11), IN $primerDiaM DATE, IN $ultimoDiaM DATE, IN $fechaActual DATE)
BEGIN
  SELECT COUNT(tbl_cita.idCita) AS "Cantidad_Citas_Mes"
  FROM tbl_cita
  WHERE tbl_cita.idPaciente=$idPaciente
AND ($fechaActual BETWEEN $primerDiaM AND $ultimoDiaM);
END$$

DROP PROCEDURE IF EXISTS `spConsultacitasU`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultacitasU`(IN $idPersona INT)
BEGIN
  SELECT PE.idPersona, PE.primerNombre as 'medico',PE.primerApellido as 'medicoape', PA.idPaciente, PA.primerNombre as 'paciente', PA.primerApellido,PA.numeroDocumento,C.horaInicial,C.horaFinal,P.Fecha_inicial as 'fecha',C.direccionCita,CU.nombreCUP FROM tbl_cita C INNER JOIN tbl_paciente PA ON PA.idPaciente = C.idPaciente INNER JOIN tbl_cita_programacion CP ON C.idCita = CP.idcita INNER JOIN tbl_turnoprogramacion TP ON CP.idTurnoProgramacion = TP.idTurnoProgramacion INNER JOIN tbl_persona PE ON PE.idPersona = TP.idPersona INNER JOIN tbl_programacion P ON P.idProgramacion = TP.idProgramacion INNER JOIN tbl_turno T ON T.idTurno = TP.idTurno INNER JOIN tbl_Cup cu ON CU.idCup = C.idCUP
  where PE.idPersona = $idPersona;
END$$

DROP PROCEDURE IF EXISTS `spConsultaConfiguracionCita`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultaConfiguracionCita`()
BEGIN
  SELECT tbl_configuracion.cantidadCitasDia, tbl_configuracion.cantidadCitasMes,
  tbl_configuracion.descripcionConfiguracion, tbl_configuracion.fechaConfiguracion
  FROM tbl_configuracion
  WHERE tbl_configuracion.estadoTabla LIKE 'Activo';
END$$

DROP PROCEDURE IF EXISTS `spConsultaDesIdProce`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultaDesIdProce`(IN `$id` INT)
BEGIN
  select nombreCup from tbl_cup where idCup = $id;
END$$

DROP PROCEDURE IF EXISTS `spConsultaDesProcedi`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultaDesProcedi`(IN `$filtro` VARCHAR(1000))
BEGIN
  select tbl_cup.idCup as id, tbl_cup.nombreCup
  from tbl_cup where tbl_cup.nombreCUP LIKE CONCAT('%',CONCAT($filtro, '%')) and
  idTipoCup = ( select tbl_tipocup.idTipoCup from tbl_tipocup where tbl_tipocup.descripcionCUP like 'Citas' ) or
  idTipoCup = (select tbl_tipocup.idTipoCup from tbl_tipocup where tbl_tipocup.descripcionCUP like 'Otro');
end$$

DROP PROCEDURE IF EXISTS `spConsultaEnfermerosJefe`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultaEnfermerosJefe`(
  IN $ola INT, IN $FechaCapt DATE, IN $Hora TIME
)
BEGIN
  DECLARE idPersona INT;
  DECLARE PrimerN VARCHAR(45);
  DECLARE SegundoN VARCHAR(45);
  DECLARE PrimerA VARCHAR(45);
  DECLARE SegundoA VARCHAR(45);
  DECLARE descripcionRol VARCHAR(45);
  DECLARE IdTurnoP INT;

  DECLARE no_more_rows BOOLEAN;
  DECLARE loop_cntr INT DEFAULT 0;
  DECLARE num_rows INT DEFAULT 0;

  DECLARE friends_cur CURSOR FOR
SELECT DISTINCT tbl_persona.idPersona,  tbl_persona.primerNombre, tbl_persona.segundoNombre,  tbl_persona.primerApellido, tbl_persona.segundoApellido,  tbl_rol.descripcionRol,tbl_turnoprogramacion.idTurnoProgramacion
  FROM  tbl_turnoprogramacion
  INNER JOIN tbl_turno
  ON tbl_turnoprogramacion.idTurno = tbl_turno.idTurno
  INNER JOIN tbl_programacion
  ON tbl_turnoprogramacion.idProgramacion = tbl_programacion.idProgramacion
  INNER JOIN tbl_persona
  ON tbl_turnoprogramacion.idPersona = tbl_persona.idPersona
  INNER JOIN tbl_cuentausuario
  ON tbl_persona.idPersona = tbl_cuentausuario.idPersona
  INNER JOIN tbl_rol
  ON tbl_cuentausuario.idRol = tbl_rol.idRol
  WHERE (tbl_rol.descripcionRol LIKE 'Enfermera jefe' AND tbl_rol.estadoTabla LIKE 'Activo') AND (tbl_persona.estadoTablaPersona LIKE 'Activo' AND tbl_persona.dependencia LIKE 'Domiciliaria') AND ($Hora BETWEEN tbl_turno.horaInicioTurno AND tbl_turno.horaFinalTurno) AND ($FechaCapt = tbl_programacion.Fecha_inicial) AND (tbl_turnoprogramacion.estadoTablaProgramacion LIKE 'Activo');

  DECLARE CONTINUE HANDLER FOR NOT FOUND
    SET no_more_rows = TRUE;

  CREATE TEMPORARY TABLE tbl_registrosTemporalesEnfermeroJ(
    idPerson INT,
    PNmbre varchar(45),
    SNombre varchar(45),
PApellido varchar(45),
SApellido varchar(45),
descripcionRol varchar(45),
IdTProgramacion INT
);

  OPEN friends_cur;
  select FOUND_ROWS() into num_rows;

  the_loop: LOOP

    FETCH  friends_cur
    INTO   idPersona,
           PrimerN,
           SegundoN,
           PrimerA,
           SegundoA,
           descripcionRol,
           IdTurnoP;

    IF no_more_rows THEN
        CLOSE friends_cur;
        LEAVE the_loop;
    END IF;

   IF NOT EXISTS(
       SELECT tbl_cita.fechaCita,tbl_cita.horaInicial
    FROM tbl_turnoprogramacion
    INNER JOIN tbl_cita_programacion
    ON tbl_turnoprogramacion.idTurnoProgramacion=tbl_cita_programacion.idTurnoProgramacion
INNER JOIN tbl_cita
    ON tbl_cita_programacion.idCita=tbl_cita.idCita
    WHERE
    idPersona=tbl_turnoprogramacion.idPersona
    AND tbl_cita.fechaCita=$FechaCapt
    AND tbl_cita.horaInicial=$Hora
    AND (tbl_cita.estadoTablaCita = 'Iniciada')) THEN

   INSERT INTO tbl_registrosTemporalesEnfermeroJ VALUES( idPersona,
           PrimerN,
           SegundoN,
           PrimerA,
           SegundoA,
           descripcionRol,
           IdTurnoP);
    END IF;

    SET loop_cntr = loop_cntr + 1;

  END LOOP the_loop;
SELECT * FROM tbl_registrosTemporalesEnfermeroJ;
END$$

DROP PROCEDURE IF EXISTS `spConsultaIdCita`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultaIdCita`()
BEGIN
  SELECT MAX(tbl_cita.idCita) AS 'idUltimo'
  FROM tbl_cita;
END$$

DROP PROCEDURE IF EXISTS `spConsultaIdProgram`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultaIdProgram`(IN $FechaCapt DATE, iN $Hora TIME)
BEGIN
  SELECT idTurnoProgramacion
  FROM tbl_turnoprogramacion
  INNER JOIN tbl_turno ON tbl_turnoprogramacion.idTurnoProgramacion = tbl_turno.idTurno
  INNER JOIN tbl_programacion ON tbl_turnoprogramacion.idTurnoProgramacion = tbl_programacion.idProgramacion
  WHERE ($Hora BETWEEN tbl_turno.horaInicioTurno AND tbl_turno.horaFinalTurno)  AND ($FechaCapt BETWEEN tbl_programacion.Fecha_inicial  AND tbl_programacion.Fecha_final) AND (tbl_turnoprogramacion.estadoTablaProgramacion LIKE 'Activo');
END$$

DROP PROCEDURE IF EXISTS `spConsultaMedicos`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultaMedicos`(
  IN $ola INT, IN $FechaCapt DATE, IN $Hora TIME
)
BEGIN
  DECLARE idPersona INT;
  DECLARE PrimerN VARCHAR(45);
  DECLARE SegundoN VARCHAR(45);
  DECLARE PrimerA VARCHAR(45);
  DECLARE SegundoA VARCHAR(45);
  DECLARE Especialidad VARCHAR(45);
  DECLARE IdTurnoP INT;

  DECLARE no_more_rows BOOLEAN;
  DECLARE loop_cntr INT DEFAULT 0;
  DECLARE num_rows INT DEFAULT 0;

  DECLARE friends_cur CURSOR FOR
SELECT DISTINCT tbl_persona.idPersona, tbl_persona.primerNombre, tbl_persona.segundoNombre, tbl_persona.primerApellido, tbl_persona.segundoApellido, tbl_especialidad.descripcionEspecialidad,tbl_turnoprogramacion.idTurnoProgramacion
FROM tbl_turnoprogramacion
INNER JOIN tbl_turno
ON tbl_turnoprogramacion.idTurno = tbl_turno.idTurno
INNER JOIN tbl_programacion
ON tbl_turnoprogramacion.idProgramacion = tbl_programacion.idProgramacion
INNER JOIN tbl_persona
ON tbl_turnoprogramacion.idPersona = tbl_persona.idPersona
INNER JOIN tbl_personaespecialidad
ON tbl_persona.idPersona = tbl_personaespecialidad.idPersona
INNER JOIN tbl_especialidad
ON tbl_personaespecialidad.idEspecialidad = tbl_especialidad.idEspecialidad
INNER JOIN tbl_cuentausuario
ON tbl_persona.idPersona = tbl_cuentausuario.idPersona
INNER JOIN tbl_rol
ON tbl_cuentausuario.idRol = tbl_rol.idRol
    WHERE (
        tbl_especialidad.estadoTabla LIKE 'Activo'
        AND tbl_personaespecialidad.estadoTablaEspecialidad LIKE 'Activo'
        AND tbl_rol.descripcionRol LIKE 'Medico' AND tbl_rol.estadoTabla LIKE 'Activo')
        AND(tbl_especialidad.descripcionEspecialidad <> 'Paramedico')
        AND (tbl_persona.estadoTablaPersona LIKE 'Activo' AND tbl_persona.dependencia  LIKE 'Domiciliaria')
        AND ($Hora BETWEEN tbl_turno.horaInicioTurno
        AND tbl_turno.horaFinalTurno) AND ($FechaCapt = tbl_programacion.Fecha_inicial)
        AND (tbl_turnoprogramacion.estadoTablaProgramacion LIKE 'Activo');
  DECLARE CONTINUE HANDLER FOR NOT FOUND
    SET no_more_rows = TRUE;

  CREATE TEMPORARY TABLE tbl_registrosTemporales(
    idPerson INT,
    PNmbre varchar(45),
    SNombre varchar(45),
PApellido varchar(45),
SApellido varchar(45),
Especial varchar(45),
IdTProgramacion INT
);

  OPEN friends_cur;
  select FOUND_ROWS() into num_rows;

  the_loop: LOOP

    FETCH  friends_cur
    INTO   idPersona,
           PrimerN,
           SegundoN,
           PrimerA,
           SegundoA,
           Especialidad,
           IdTurnoP;

    IF no_more_rows THEN
        CLOSE friends_cur;
        LEAVE the_loop;
    END IF;

   IF NOT EXISTS(
       SELECT tbl_cita.fechaCita,tbl_cita.horaInicial
    FROM tbl_turnoprogramacion
    INNER JOIN tbl_cita_programacion
    ON tbl_turnoprogramacion.idTurnoProgramacion=tbl_cita_programacion.idTurnoProgramacion
INNER JOIN tbl_cita
    ON tbl_cita_programacion.idCita=tbl_cita.idCita
    WHERE
    idPersona=tbl_turnoprogramacion.idPersona
    AND tbl_cita.fechaCita=$FechaCapt
    AND tbl_cita.horaInicial=$Hora
    AND (tbl_cita.estadoTablaCita = 'Iniciada')) THEN

   INSERT INTO tbl_registrosTemporales VALUES( idPersona,
           PrimerN,
           SegundoN,
           PrimerA,
           SegundoA,
           Especialidad,
           IdTurnoP);
    END IF;

    SET loop_cntr = loop_cntr + 1;

  END LOOP the_loop;
SELECT * FROM tbl_registrosTemporales;
END$$

DROP PROCEDURE IF EXISTS `spConsultaMedicosEspecial`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultaMedicosEspecial`(
  IN $ola INT, IN $FechaCapt DATE, IN $Hora TIME,IN $Especialidad VARCHAR(45)
)
BEGIN
  DECLARE idPersona INT;
  DECLARE PrimerN VARCHAR(45);
  DECLARE SegundoN VARCHAR(45);
  DECLARE PrimerA VARCHAR(45);
  DECLARE SegundoA VARCHAR(45);
  DECLARE Especialidad VARCHAR(45);
  DECLARE IdTurnoP INT;

  DECLARE no_more_rows BOOLEAN;
  DECLARE loop_cntr INT DEFAULT 0;
  DECLARE num_rows INT DEFAULT 0;

  DECLARE friends_cur CURSOR FOR
SELECT DISTINCT tbl_persona.idPersona, tbl_persona.primerNombre, tbl_persona.segundoNombre, tbl_persona.primerApellido, tbl_persona.segundoApellido, tbl_especialidad.descripcionEspecialidad,tbl_turnoprogramacion.idTurnoProgramacion
FROM tbl_turnoprogramacion
INNER JOIN tbl_turno
ON tbl_turnoprogramacion.idTurno = tbl_turno.idTurno
INNER JOIN tbl_programacion
ON tbl_turnoprogramacion.idProgramacion = tbl_programacion.idProgramacion
INNER JOIN tbl_persona
ON tbl_turnoprogramacion.idPersona = tbl_persona.idPersona
INNER JOIN tbl_personaespecialidad
ON tbl_persona.idPersona = tbl_personaespecialidad.idPersona
INNER JOIN tbl_especialidad
ON tbl_personaespecialidad.idEspecialidad = tbl_especialidad.idEspecialidad
INNER JOIN tbl_cuentausuario
ON tbl_persona.idPersona = tbl_cuentausuario.idPersona
INNER JOIN tbl_rol
ON tbl_cuentausuario.idRol = tbl_rol.idRol
    WHERE (
        tbl_especialidad.estadoTabla LIKE 'Activo'
        AND tbl_personaespecialidad.estadoTablaEspecialidad LIKE 'Activo'
        AND tbl_rol.descripcionRol LIKE 'Medico' AND tbl_rol.estadoTabla LIKE 'Activo')           AND(tbl_especialidad.descripcionEspecialidad <> 'Paramedico')
        AND (tbl_persona.estadoTablaPersona LIKE 'Activo' AND tbl_persona.dependencia  LIKE 'Domiciliaria')
       AND ($Hora BETWEEN tbl_turno.horaInicioTurno
       AND tbl_turno.horaFinalTurno) AND ($FechaCapt = tbl_programacion.Fecha_inicial)
       AND (tbl_turnoprogramacion.estadoTablaProgramacion LIKE 'Activo')
 AND(tbl_especialidad.descripcionEspecialidad LIKE CONCAT('%',CONCAT($Especialidad, '%')));

  DECLARE CONTINUE HANDLER FOR NOT FOUND
    SET no_more_rows = TRUE;

  CREATE TEMPORARY TABLE tbl_registrosTemporales(
    idPerson INT,
    PNmbre varchar(45),
    SNombre varchar(45),
PApellido varchar(45),
SApellido varchar(45),
Especial varchar(45),
IdTProgramacion INT
);

  OPEN friends_cur;
  select FOUND_ROWS() into num_rows;

  the_loop: LOOP

    FETCH  friends_cur
    INTO   idPersona,
           PrimerN,
           SegundoN,
           PrimerA,
           SegundoA,
           Especialidad,
           IdTurnoP;

    IF no_more_rows THEN
        CLOSE friends_cur;
        LEAVE the_loop;
    END IF;

   IF NOT EXISTS(
       SELECT tbl_cita.fechaCita,tbl_cita.horaInicial
    FROM tbl_turnoprogramacion
    INNER JOIN tbl_cita_programacion
    ON tbl_turnoprogramacion.idTurnoProgramacion=tbl_cita_programacion.idTurnoProgramacion
INNER JOIN tbl_cita
    ON tbl_cita_programacion.idCita=tbl_cita.idCita
    WHERE
    idPersona=tbl_turnoprogramacion.idPersona
    AND tbl_cita.fechaCita=$FechaCapt
    AND tbl_cita.horaInicial=$Hora
    AND (tbl_cita.estadoTablaCita = 'Iniciada')) THEN

   INSERT INTO tbl_registrosTemporales VALUES( idPersona,
           PrimerN,
           SegundoN,
           PrimerA,
           SegundoA,
           Especialidad,
           IdTurnoP);
    END IF;

    SET loop_cntr = loop_cntr + 1;

  END LOOP the_loop;
SELECT * FROM tbl_registrosTemporales;
END$$

DROP PROCEDURE IF EXISTS `spConsultaNombresAuxEnfermeria`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultaNombresAuxEnfermeria`(
  IN $ola INT, IN $FechaCapt DATE, IN $Hora TIME,IN $Nombres varchar (45)
)
BEGIN

  DECLARE idPersona INT;
  DECLARE PrimerN VARCHAR(45);
  DECLARE SegundoN VARCHAR(45);
  DECLARE PrimerA VARCHAR(45);
  DECLARE SegundoA VARCHAR(45);
  DECLARE descripcionRol VARCHAR(45);
  DECLARE IdTurnoP INT;

  DECLARE no_more_rows BOOLEAN;
  DECLARE loop_cntr INT DEFAULT 0;
  DECLARE num_rows INT DEFAULT 0;

  DECLARE friends_cur CURSOR FOR
SELECT DISTINCT tbl_persona.idPersona, tbl_persona.primerNombre, tbl_persona.segundoNombre,  tbl_persona.primerApellido, tbl_persona.segundoApellido,  tbl_rol.descripcionRol,tbl_turnoprogramacion.idTurnoProgramacion
  FROM  tbl_turnoprogramacion
  INNER JOIN tbl_turno
  ON tbl_turnoprogramacion.idTurno = tbl_turno.idTurno
  INNER JOIN tbl_programacion
  ON tbl_turnoprogramacion.idProgramacion = tbl_programacion.idProgramacion
  INNER JOIN tbl_persona
  ON tbl_turnoprogramacion.idPersona = tbl_persona.idPersona
  INNER JOIN tbl_cuentausuario
  ON tbl_persona.idPersona = tbl_cuentausuario.idPersona
  INNER JOIN tbl_rol
  ON tbl_cuentausuario.idRol = tbl_rol.idRol
  WHERE (tbl_rol.descripcionRol LIKE 'Auxiliar de enfermeria' AND tbl_rol.estadoTabla LIKE 'Activo') AND (tbl_persona.estadoTablaPersona LIKE 'Activo' AND tbl_persona.dependencia LIKE 'Domiciliaria') AND ($Hora BETWEEN tbl_turno.horaInicioTurno AND tbl_turno.horaFinalTurno) AND ($FechaCapt BETWEEN tbl_programacion.Fecha_inicial AND tbl_programacion.Fecha_final) AND (tbl_turnoprogramacion.estadoTablaProgramacion LIKE 'Activo')
   AND(tbl_persona.primerNombre LIKE CONCAT('%',CONCAT($Nombres, '%'))
OR tbl_persona.primerApellido LIKE CONCAT('%',CONCAT($Nombres, '%'))
);

  DECLARE CONTINUE HANDLER FOR NOT FOUND
    SET no_more_rows = TRUE;

  CREATE TEMPORARY TABLE tbl_registrosTemporalesEnfermeroJ(
    idPerson INT,
    PNmbre varchar(45),
    SNombre varchar(45),
PApellido varchar(45),
SApellido varchar(45),
descripcionRol varchar(45),
IdTProgramacion INT
);

  OPEN friends_cur;
  select FOUND_ROWS() into num_rows;

  the_loop: LOOP

    FETCH  friends_cur
    INTO   idPersona,
           PrimerN,
           SegundoN,
           PrimerA,
           SegundoA,
           descripcionRol,
           IdTurnoP;

    IF no_more_rows THEN
        CLOSE friends_cur;
        LEAVE the_loop;
    END IF;

   IF NOT EXISTS(
       SELECT tbl_cita.fechaCita,tbl_cita.horaInicial
    FROM tbl_turnoprogramacion
    INNER JOIN tbl_cita_programacion
    ON tbl_turnoprogramacion.idTurnoProgramacion=tbl_cita_programacion.idTurnoProgramacion
INNER JOIN tbl_cita
    ON tbl_cita_programacion.idCita=tbl_cita.idCita
    WHERE
    idPersona=tbl_turnoprogramacion.idPersona
    AND tbl_cita.fechaCita=$FechaCapt
    AND tbl_cita.horaInicial=$Hora
    AND (tbl_cita.estadoTablaCita = 'Iniciada')) THEN

   INSERT INTO tbl_registrosTemporalesEnfermeroJ VALUES( idPersona,
           PrimerN,
           SegundoN,
           PrimerA,
           SegundoA,
           descripcionRol,
           IdTurnoP);
    END IF;

    SET loop_cntr = loop_cntr + 1;

  END LOOP the_loop;
SELECT * FROM tbl_registrosTemporalesEnfermeroJ;
END$$

DROP PROCEDURE IF EXISTS `spConsultaNombresEnfermerosJefe`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultaNombresEnfermerosJefe`(
  IN $ola INT, IN $FechaCapt DATE, IN $Hora TIME,IN $Nombres varchar (45)
)
BEGIN
  DECLARE idPersona INT;
  DECLARE PrimerN VARCHAR(45);
  DECLARE SegundoN VARCHAR(45);
  DECLARE PrimerA VARCHAR(45);
  DECLARE SegundoA VARCHAR(45);
  DECLARE descripcionRol VARCHAR(45);
  DECLARE IdTurnoP INT;

  DECLARE no_more_rows BOOLEAN;
  DECLARE loop_cntr INT DEFAULT 0;
  DECLARE num_rows INT DEFAULT 0;

  DECLARE friends_cur CURSOR FOR
SELECT DISTINCT tbl_persona.idPersona,  tbl_persona.primerNombre, tbl_persona.segundoNombre,  tbl_persona.primerApellido, tbl_persona.segundoApellido,  tbl_rol.descripcionRol,tbl_turnoprogramacion.idTurnoProgramacion
  FROM  tbl_turnoprogramacion
  INNER JOIN tbl_turno
  ON tbl_turnoprogramacion.idTurno = tbl_turno.idTurno
  INNER JOIN tbl_programacion
  ON tbl_turnoprogramacion.idProgramacion = tbl_programacion.idProgramacion
  INNER JOIN tbl_persona
  ON tbl_turnoprogramacion.idPersona = tbl_persona.idPersona
  INNER JOIN tbl_cuentausuario
  ON tbl_persona.idPersona = tbl_cuentausuario.idPersona
  INNER JOIN tbl_rol
  ON tbl_cuentausuario.idRol = tbl_rol.idRol
  WHERE (tbl_rol.descripcionRol LIKE 'Enfermera jefe' AND tbl_rol.estadoTabla LIKE 'Activo') AND (tbl_persona.estadoTablaPersona LIKE 'Activo' AND tbl_persona.dependencia LIKE 'Domiciliaria') AND ($Hora BETWEEN tbl_turno.horaInicioTurno AND tbl_turno.horaFinalTurno) AND ($FechaCapt = tbl_programacion.Fecha_inicial) AND (tbl_turnoprogramacion.estadoTablaProgramacion LIKE 'Activo')
      AND(tbl_persona.primerNombre LIKE CONCAT('%',CONCAT($Nombres, '%'))
OR tbl_persona.primerApellido LIKE CONCAT('%',CONCAT($Nombres, '%'))
);

  DECLARE CONTINUE HANDLER FOR NOT FOUND
    SET no_more_rows = TRUE;

  CREATE TEMPORARY TABLE tbl_registrosTemporalesEnfermeroJ(
    idPerson INT,
    PNmbre varchar(45),
    SNombre varchar(45),
PApellido varchar(45),
SApellido varchar(45),
descripcionRol varchar(45),
IdTProgramacion INT
);

  OPEN friends_cur;
  select FOUND_ROWS() into num_rows;

  the_loop: LOOP

    FETCH  friends_cur
    INTO   idPersona,
           PrimerN,
           SegundoN,
           PrimerA,
           SegundoA,
           descripcionRol,
           IdTurnoP;

    IF no_more_rows THEN
        CLOSE friends_cur;
        LEAVE the_loop;
    END IF;

   IF NOT EXISTS(
       SELECT tbl_cita.fechaCita,tbl_cita.horaInicial
    FROM tbl_turnoprogramacion
    INNER JOIN tbl_cita_programacion
    ON tbl_turnoprogramacion.idTurnoProgramacion=tbl_cita_programacion.idTurnoProgramacion
INNER JOIN tbl_cita
    ON tbl_cita_programacion.idCita=tbl_cita.idCita
    WHERE
    idPersona=tbl_turnoprogramacion.idPersona
    AND tbl_cita.fechaCita=$FechaCapt
    AND tbl_cita.horaInicial=$Hora
    AND (tbl_cita.estadoTablaCita  = 'Iniciada')) THEN

   INSERT INTO tbl_registrosTemporalesEnfermeroJ VALUES( idPersona,
           PrimerN,
           SegundoN,
           PrimerA,
           SegundoA,
           descripcionRol,
           IdTurnoP);
    END IF;

    SET loop_cntr = loop_cntr + 1;

  END LOOP the_loop;
SELECT * FROM tbl_registrosTemporalesEnfermeroJ;
END$$

DROP PROCEDURE IF EXISTS `spConsultaNombresMedic`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultaNombresMedic`(
  IN $ola INT, IN $FechaCapt DATE, IN $Hora TIME,IN $Nombres varchar (45)
)
BEGIN

  DECLARE idPersona INT;
  DECLARE PrimerN VARCHAR(45);
  DECLARE SegundoN VARCHAR(45);
  DECLARE PrimerA VARCHAR(45);
  DECLARE SegundoA VARCHAR(45);
  DECLARE Especialidad VARCHAR(45);
  DECLARE IdTurnoP INT;

  DECLARE no_more_rows BOOLEAN;
  DECLARE loop_cntr INT DEFAULT 0;
  DECLARE num_rows INT DEFAULT 0;

  DECLARE friends_cur CURSOR FOR
SELECT DISTINCT tbl_persona.idPersona, tbl_persona.primerNombre, tbl_persona.segundoNombre, tbl_persona.primerApellido, tbl_persona.segundoApellido, tbl_especialidad.descripcionEspecialidad,tbl_turnoprogramacion.idTurnoProgramacion
FROM tbl_turnoprogramacion
INNER JOIN tbl_turno
ON tbl_turnoprogramacion.idTurno = tbl_turno.idTurno
INNER JOIN tbl_programacion
ON tbl_turnoprogramacion.idProgramacion = tbl_programacion.idProgramacion
INNER JOIN tbl_persona
ON tbl_turnoprogramacion.idPersona = tbl_persona.idPersona
INNER JOIN tbl_personaespecialidad
ON tbl_persona.idPersona = tbl_personaespecialidad.idPersona
INNER JOIN tbl_especialidad
ON tbl_personaespecialidad.idEspecialidad = tbl_especialidad.idEspecialidad
INNER JOIN tbl_cuentausuario
ON tbl_persona.idPersona = tbl_cuentausuario.idPersona
INNER JOIN tbl_rol
ON tbl_cuentausuario.idRol = tbl_rol.idRol
    WHERE (
        tbl_especialidad.estadoTabla LIKE 'Activo'
        AND tbl_personaespecialidad.estadoTablaEspecialidad LIKE 'Activo'
        AND tbl_rol.descripcionRol LIKE 'Medico' AND tbl_rol.estadoTabla LIKE 'Activo')           AND(tbl_especialidad.descripcionEspecialidad <> 'Paramedico')
        AND (tbl_persona.estadoTablaPersona LIKE 'Activo' AND tbl_persona.dependencia  LIKE 'Domiciliaria')
       AND ($Hora BETWEEN tbl_turno.horaInicioTurno
       AND tbl_turno.horaFinalTurno) AND ($FechaCapt = tbl_programacion.Fecha_inicial)
       AND (tbl_turnoprogramacion.estadoTablaProgramacion LIKE 'Activo')
       AND(tbl_persona.primerNombre LIKE CONCAT('%',CONCAT($Nombres, '%'))
OR tbl_persona.primerApellido LIKE CONCAT('%',CONCAT($Nombres, '%'))
);

  DECLARE CONTINUE HANDLER FOR NOT FOUND
    SET no_more_rows = TRUE;

  CREATE TEMPORARY TABLE tbl_registrosTemporales(
    idPerson INT,
    PNmbre varchar(45),
    SNombre varchar(45),
PApellido varchar(45),
SApellido varchar(45),
Especial varchar(45),
IdTProgramacion INT
);

  OPEN friends_cur;
  select FOUND_ROWS() into num_rows;

  the_loop: LOOP

    FETCH  friends_cur
    INTO   idPersona,
           PrimerN,
           SegundoN,
           PrimerA,
           SegundoA,
           Especialidad,
           IdTurnoP;

    IF no_more_rows THEN
        CLOSE friends_cur;
        LEAVE the_loop;
    END IF;

   IF NOT EXISTS(
       SELECT tbl_cita.fechaCita,tbl_cita.horaInicial
    FROM tbl_turnoprogramacion
    INNER JOIN tbl_cita_programacion
    ON tbl_turnoprogramacion.idTurnoProgramacion=tbl_cita_programacion.idTurnoProgramacion
INNER JOIN tbl_cita
    ON tbl_cita_programacion.idCita=tbl_cita.idCita
    WHERE
    idPersona=tbl_turnoprogramacion.idPersona
    AND tbl_cita.fechaCita=$FechaCapt
    AND tbl_cita.horaInicial=$Hora
    AND (tbl_cita.estadoTablaCita = 'Iniciada')) THEN

   INSERT INTO tbl_registrosTemporales VALUES( idPersona,
           PrimerN,
           SegundoN,
           PrimerA,
           SegundoA,
           Especialidad,
           IdTurnoP);
    END IF;

    SET loop_cntr = loop_cntr + 1;

  END LOOP the_loop;
SELECT * FROM tbl_registrosTemporales;
END$$

DROP PROCEDURE IF EXISTS `spConsultaParametrizadaAsignacionAmbulancia`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultaParametrizadaAsignacionAmbulancia`( IN _idAmbulancia int )
BEGIN
SELECT tba.idAmbulancia, tba.tipoAmbulancia,tbla.latitud, tbla.longitud,tblda.idPersona,concat(tblp.primerNombre,' ',tblp.primerApellido) as "Nombre_Completo", tblr.descripcionRol, tblda.idDetalleAsignacion, tbla.idAsignacionPersonal
  FROM tbl_ambulancia AS tba
  INNER JOIN tbl_asignacionpersonal AS tbla
  ON tba.idAmbulancia = tbla.idAmbulancia
  INNER JOIN tbl_detalleasignacion AS tblda
  ON tbla.idAsignacionPersonal = tblda.idAsignacionPersonal
  INNER JOIN tbl_persona AS tblp
  ON tblda.idPersona = tblp.idPersona
  INNER JOIN tbl_cuentausuario tblcu
  ON tblp.idPersona = tblcu.idPersona
  INNER JOIN tbl_rol tblr
  ON tblcu.idRol = tblr.idRol
  WHERE tba.idAmbulancia = _idAmbulancia AND tblda.estadoTabla = 'Activo';
END$$

DROP PROCEDURE IF EXISTS `spConsultaPersonaCorreo`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultaPersonaCorreo`(
    IN $correoElectronico varchar(50)
)
BEGIN
SELECT * FROM `tbl_persona` WHERE `correoElectronico` = $correoElectronico;
END$$

DROP PROCEDURE IF EXISTS `spConsultaPersonaD`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultaPersonaD`($numeroDocumento VARCHAR(45))
BEGIN
  SELECT * FROM `tbl_persona` WHERE `numeroDocumento` = $numeroDocumento;
END$$

DROP PROCEDURE IF EXISTS `spConsultaPersonaPro`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultaPersonaPro`(iN $idTurnoProgram INT)
BEGIN
  SELECT tbl_persona.primerNombre,tbl_persona.segundoNombre,tbl_persona.primerApellido,tbl_persona.segundoApellido
  FROM tbl_turnoprogramacion
  INNER JOIN tbl_persona
  ON tbl_turnoprogramacion.idPersona = tbl_persona.idPersona
  WHERE tbl_turnoprogramacion.idTurnoProgramacion = $idTurnoProgram;
END$$

DROP PROCEDURE IF EXISTS `spConsultaPersonaUsuario`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultaPersonaUsuario`(IN $usuario varchar(50))
BEGIN
  SELECT * FROM `tbl_cuentausuario` WHERE `usuario` = $usuario;
END$$

DROP PROCEDURE IF EXISTS `spConsultaProgramacionDias`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultaProgramacionDias`(IN $idPersona INT)
BEGIN
select p.Fecha_inicial
from tbl_Programacion p
inner join tbl_TurnoProgramacion tp
on p.idProgramacion = tp.idProgramacion
where tp.idPersona = $idPersona and tp.estadoTablaProgramacion = 'Activo';
END$$

DROP PROCEDURE IF EXISTS `spConsultarAcompanante`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarAcompanante`(IN `$identificacionA` INT)
BEGIN
  SELECT *
  FROM `tbl_acompanante`
  WHERE `identificacionA` = $identificacionA;
END$$

DROP PROCEDURE IF EXISTS `spConsultarAfectadoaccidentetransito`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarAfectadoaccidentetransito`(IN $idAfectadoAccidenteTransito INT)
BEGIN
    SELECT * FROM `tbl_afectadoaccidentetransito` WHERE `idAfectadoAccidenteTransito` = $idAfectadoAccidenteTransito;
    END$$

DROP PROCEDURE IF EXISTS `spConsultarAgenda`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarAgenda`(IN $idPersona INT)
BEGIN
  SELECT P.idPersona, Es.idEspecialidad , ES.idPersonaEspecialidad ,P.primerNombre, E.descripcionEspecialidad ,P.primerNombre,P.primerApellido,Es.idEspecialidad,T.horaInicioTurno,T.horaFinalTurno,PR.Fecha_inicial,PR.Fecha_final
  FROM tbl_persona P
  INNER JOIN tbl_personaEspecialidad Es
  ON p.idPersona = Es.idPersona
  INNER JOIN tbl_especialidad E
  ON Es.idEspecialidad = E.idEspecialidad
  INNER JOIN tbl_turnoprogramacion TP
  ON P.idPersona = TP.idPersona
  INNER JOIN tbl_turno T
  ON TP.idTurno = T.idTurno
  INNER JOIN tbl_programacion PR
  ON TP.idProgramacion = PR.idProgramacion
  WHERE P.idPersona = $idPersona;
END$$

DROP PROCEDURE IF EXISTS `spConsultarAgendaActual`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarAgendaActual`(IN $idPersona INT)
BEGIN
  SELECT P.idPersona,T.idTurno,tp.idTurnoProgramacion, Es.idEspecialidad , ES.idPersonaEspecialidad ,P.primerNombre, E.descripcionEspecialidad ,P.primerNombre,P.primerApellido,Es.idEspecialidad,max(T.horaInicioTurno) AS 'Horainicial',max(T.horaFinalTurno) AS 'Horafinal',max(PR.Fecha_inicial) AS 'Fechainicial',max(PR.Fecha_final) AS 'Fechafinal'
  FROM tbl_persona P
  INNER JOIN tbl_personaEspecialidad Es
  ON p.idPersona = Es.idPersona
  INNER JOIN tbl_especialidad E
  ON Es.idEspecialidad = E.idEspecialidad
  INNER JOIN tbl_turnoprogramacion TP
  ON P.idPersona = TP.idPersona
  INNER JOIN tbl_turno T
  ON TP.idTurno = T.idTurno
  INNER JOIN tbl_programacion PR
  ON TP.idProgramacion = PR.idProgramacion
  WHERE P.idPersona = $idPersona AND TP.estadoProgramacion = "ACTIVO" LIMIT 1;
END$$

DROP PROCEDURE IF EXISTS `spConsultarAllPersonas`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarAllPersonas`(IN `$numeroDocumento` VARCHAR(45))
BEGIN
  SELECT * FROM tbl_persona
  INNER JOIN tbl_cuentausuario
  ON tbl_persona.idPersona = tbl_cuentausuario.idPersona
  INNER JOIN tbl_rol
  ON tbl_rol.idRol = tbl_cuentausuario.idRol
  WHERE `numeroDocumento` = $numeroDocumento and descripcionRol <> 'Medico Externo';
END$$

DROP PROCEDURE IF EXISTS `spConsultarAmbulancia`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarAmbulancia`(IN $idAmbulancia INT)
BEGIN
    SELECT * FROM `tbl_ambulancia` WHERE `idAmbulancia` = $idAmbulancia;
    END$$

DROP PROCEDURE IF EXISTS `spConsultarAmbulanciaEstado`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarAmbulanciaEstado`(IN _idReportaInicial int)
BEGIN
  SELECT * FROM tbl_ambulancia a
  INNER JOIN tbl_despacho d ON a.idAmbulancia = d.idAmbulancia
  WHERE d.idReporteInicial = _idReportaInicial;
END$$

DROP PROCEDURE IF EXISTS `spConsultarAntecedenteaph`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarAntecedenteaph`(IN $idAntecedente INT)
BEGIN
    SELECT * FROM `tbl_antecedenteaph` WHERE `idAntecedente` = $idAntecedente;
    END$$

DROP PROCEDURE IF EXISTS `spConsultarAntecedentedmc`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarAntecedentedmc`(IN $idAntecedente INT)
BEGIN
    SELECT * FROM `tbl_antecedentedmc` WHERE `idAntecedente` = $idAntecedente;
    END$$

DROP PROCEDURE IF EXISTS `spConsultarAntecedentesAPH`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarAntecedentesAPH`(
  $idReporteAph INT
)
BEGIN
SELECT TAC.idTipoAntecedente, TAC.descripcion, IFNULL(ACA.especificacion, '') AS especificacion FROM tbl_antecedenteaph ACA
INNER JOIN tbl_reporteaph RA
ON RA.idReporteAPH = ACA.idReporteAPH
INNER JOIN tbl_tipoantecedente TAC
ON ACA.idTipoAntecendente = TAC.idTipoAntecedente
WHERE RA.idReporteAPH = $idReporteAph;
END$$

DROP PROCEDURE IF EXISTS `spConsultarAntecedentesDmc`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarAntecedentesDmc`(in $idAtencion INT)
BEGIN
  SELECT tbl_tipo.descripcion,tbl_ant.idHistoriaClinica,tbl_ant.descripcionAntecedente
  from tbl_antecedentedmc as tbl_ant
  inner join tbl_tipoantecedente as tbl_tipo
  on tbl_ant.idTipoAntecedente=tbl_tipo.idTipoAntecedente
  where tbl_ant.idHistoriaClinica=$idAtencion
  order by tbl_ant.descripcionAntecedente desc;
END$$

DROP PROCEDURE IF EXISTS `spConsultarAsignacionAmbulancia`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarAsignacionAmbulancia`()
BEGIN
  SELECT tba.idAmbulancia,tba.tipoAmbulancia, tblap.latitud,tblap.longitud,tblda.idPersona, tblp.primerNombre, tblp.primerApellido, tblr.descripcionRol,tblcu.idUsuario
  from tbl_ambulancia as tba
  left join tbl_asignacionpersonal as tblap
  on tba.idAmbulancia = tblap.idAmbulancia
  left join tbl_detalleasignacion as tblda
  on tblap.idAsignacionPersonal = tblda.idAsignacionPersonal
  left join tbl_persona as tblp
  on tblda.idPersona = tblp.idPersona
  LEFT JOIN tbl_cuentausuario tblcu
  ON tblcu.idPersona = tblp.idPersona
  INNER JOIN tbl_rol tblr
  ON tblcu.idRol = tblr.idRol
  WHERE tba.estadoTabla = 'Personal Asignado' and tblap.estadoTablaAsignacion = 'Activo';
END$$

DROP PROCEDURE IF EXISTS `spConsultarAsignaciones`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarAsignaciones`()
BEGIN
  SELECT tba.idAmbulancia, tba.tipoAmbulancia, tblp.primerNombre,tblp.primerApellido,tble.descripcionEspecialidad,tblda.idPersona, tblda.idDetalleAsignacion
  FROM tbl_ambulancia AS tba
  INNER JOIN tbl_asignacionpersonal AS tbla
  ON tba.idAmbulancia = tbla.idAmbulancia
  INNER JOIN tbl_detalleasignacion AS tblda
  ON tbla.idAsignacionPersonal = tblda.idAsignacionPersonal
  INNER JOIN tbl_persona AS tblp
  ON tblda.idPersona = tblp.idPersona
  INNER JOIN tbl_personaespecialidad AS tblpe
  ON tblp.idPersona = tblpe.idPersona
  INNER JOIN tbl_especialidad AS tble
  ON tblpe.idEspecialidad = tble.idEspecialidad
  WHERE tba.estadoTabla LIKE 'activo' AND tbla.estadoTablaAsignacion LIKE 'activo';
END$$

DROP PROCEDURE IF EXISTS `spConsultarAsignacionkit`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarAsignacionkit`(IN $idAsignacion INT)
BEGIN
    SELECT * FROM `tbl_asignacionkit` WHERE `idAsignacion` = $idAsignacion;
    END$$

DROP PROCEDURE IF EXISTS `spConsultarAsignacionpersonal`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarAsignacionpersonal`(IN $idAsignacionPersonal INT)
BEGIN
    SELECT * FROM `tbl_asignacionpersonal` WHERE `idAsignacionPersonal` = $idAsignacionPersonal;
    END$$

DROP PROCEDURE IF EXISTS `spConsultarAtencionDmc`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarAtencionDmc`(in idPaciente int)
BEGIN
  select idHistoriaClinica,fechaAtencion,horaInicial,telefonoFijo1,primerNombre,direccion
             from tbl_cita as cit
             inner join tbl_cita_programacion as ctp
             on cit.idCita=ctp.idCita
             inner join tbl_historiaclinica as hist
             on ctp.idCitaprogramacion=hist.idCitaprogramacion
             inner join tbl_turnoprogramacion as turn
             on ctp.idTurnoProgramacion=turn.idTurnoProgramacion
        inner join tbl_persona as per
             on per.idPersona=turn.idPersona
             where hist.idPaciente=idPaciente and estadoTablaCita='Terminada';
END$$

DROP PROCEDURE IF EXISTS `spConsultarAtencionOrigenDmc`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarAtencionOrigenDmc`(in $idAtencion INT)
BEGIN
  select motivoAtencion,enfermedadActual,descripcionorigenAtencion,evolucion,idHistoriaClinica
  from tbl_historiaclinica as ht
  inner join tbl_tipoorigenatencion as tip on  ht.idTipoOrigenAtencion=tip.idTipoOrigenAtencion
  where ht.idHistoriaClinica=$idAtencion;
END$$

DROP PROCEDURE IF EXISTS `spConsultarAutorizacion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarAutorizacion`(IN $idAutorizacion INT)
BEGIN
    SELECT * FROM `tbl_autorizacion` WHERE `idAutorizacion` = $idAutorizacion;
    END$$

DROP PROCEDURE IF EXISTS `spConsultarAutorizacionTemporal`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarAutorizacionTemporal`(
  $idAutorizacion INT
)
BEGIN
  SELECT TA.*,
  CONCAT(
      IFNULL(P.primerNombre, ''), ' ',
      IFNULL(P.segundoNombre, ''), ' ',
      IFNULL(P.primerApellido, ''), ' ',
      IFNULL(P.segundoApellido, '')) AS "nombreCompleto",
   P.correoElectronico, P.urlFoto, T.Descripcion
  FROM tbl_temporalautorizacion TA
  INNER JOIN tbl_cuentausuario C
  ON TA.idMedico = C.idUsuario
  INNER JOIN tbl_persona P
  ON C.idPersona = P.idPersona
  INNER JOIN tbl_tipotratamiento T
  ON TA.idTipoTratamiento = T.idTipoTratamiento
  WHERE TA.idTemporalAutorizacion = $idAutorizacion;
END$$

DROP PROCEDURE IF EXISTS `spConsultarCategoriaautorizacion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarCategoriaautorizacion`(IN $idCategoriaAutorizacion INT)
BEGIN
    SELECT * FROM `tbl_categoriaautorizacion` WHERE `idCategoriaAutorizacion` = $idCategoriaAutorizacion;
    END$$

DROP PROCEDURE IF EXISTS `spConsultarCategoriarecurso`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarCategoriarecurso`(IN $idCategoriaRecurso INT)
BEGIN
    SELECT * FROM `tbl_categoriarecurso` WHERE `idCategoriaRecurso` = $idCategoriaRecurso;
    END$$

DROP PROCEDURE IF EXISTS `spConsultarCertificadoatencion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarCertificadoatencion`(IN $idCertificadoAtencion INT)
BEGIN
    SELECT * FROM `tbl_certificadoatencion` WHERE `idCertificadoAtencion` = $idCertificadoAtencion;
    END$$

DROP PROCEDURE IF EXISTS `spConsultarChat`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarChat`(IN $idChat INT)
BEGIN
    SELECT * FROM `tbl_chat` WHERE `idChat` = $idChat;
    END$$

DROP PROCEDURE IF EXISTS `spConsultarChatsUsuario`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarChatsUsuario`(IN $idUsuarioExterno INT)
BEGIN
  SELECT * FROM `tbl_chat`
  WHERE `idUsuarioExterno` = $idUsuarioExterno AND estadoTabla = 0
  ORDER BY fechaHoraInicioChat DESC;
END$$

DROP PROCEDURE IF EXISTS `spConsultarCie10`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarCie10`(IN $idCIE10 INT)
BEGIN
    SELECT * FROM `tbl_cie10` WHERE `idCIE10` = $idCIE10;
    END$$

DROP PROCEDURE IF EXISTS `spConsultarCita`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarCita`(IN $idCita INT)
BEGIN
    SELECT * FROM `tbl_cita` WHERE `idCita` = $idCita;
    END$$

DROP PROCEDURE IF EXISTS `spConsultarCitaInner`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarCitaInner`(IN `$idPaciente` INT)
BEGIN
 SELECT tbl_cita.estadoTablaCita, tbl_cita.fechaCita, tbl_cita.horaInicial, tbl_cup.nombreCUP,tbl_cup.codigoCup,tbl_cita.idCita FROM tbl_cita INNER JOIN tbl_cup ON tbl_cup.idCUP = tbl_cita.idCUP
 WHERE tbl_cita.idPaciente =$idPaciente AND tbl_cita.estadoTablaCita = 'Iniciada';
END$$

DROP PROCEDURE IF EXISTS `spConsultarCitaPersona`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarCitaPersona`(in _idCita int)
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
END$$

DROP PROCEDURE IF EXISTS `spConsultarcitasprogramadas`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarcitasprogramadas`(IN $idPersona INT)
BEGIN
  SELECT P.idPersona ,Es.idRol,P.primerNombre, E.descripcionRol ,P.primerApellido,T.horaInicioTurno,T.horaFinalTurno,PR.Fecha_inicial,PR.Fecha_final FROM tbl_persona P inner join tbl_cuentausuario Es on p.idPersona = Es.idPersona inner join tbl_rol E on Es.idRol = E.idRol inner join tbl_turnoprogramacion TP on P.idPersona = TP.idPersona inner JOIN tbl_turno T on TP.idTurno = T.idTurno inner join tbl_programacion PR on TP.idProgramacion = PR.idProgramacion where P.idPersona = $idPersona and TP.estadoTablaProgramacion = "Inactivo";
END$$

DROP PROCEDURE IF EXISTS `spConsultarCita_programacion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarCita_programacion`(IN $idCitaprogramacion INT)
BEGIN
    SELECT * FROM `tbl_cita_programacion` WHERE `idCitaprogramacion` = $idCitaprogramacion;
    END$$

DROP PROCEDURE IF EXISTS `spConsultarClaveUsuario`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarClaveUsuario`(
  $Usuario varchar(45)
)
BEGIN
  SELECT TC.idUsuario,TC.clave,TR.descripcionRol FROM tbl_cuentausuario TC
  INNER JOIN tbl_rol TR
  ON TR.idRol = TC.idRol
  WHERE usuario = $Usuario;
END$$

DROP PROCEDURE IF EXISTS `spConsultarCodIdProce`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarCodIdProce`(IN `$id` INT)
BEGIN
  select codigoCup from tbl_cup where idCup = $id;
END$$

DROP PROCEDURE IF EXISTS `spConsultarCodigoCUPcita`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarCodigoCUPcita`(IN $filtro varchar(45))
BEGIN
  select tbl_cup.idCUP as id, tbl_cup.codigoCup as codigoCup
  from tbl_cup
  where tbl_cup.codigoCup LIKE CONCAT('%',CONCAT($filtro, '%')) and tbl_cup.idTipoCup=(SELECT tbl_tipocup.idTipoCup
  FROM tbl_tipocup
  WHERE tbl_tipocup.descripcionCUP LIKE 'Citas');
END$$

DROP PROCEDURE IF EXISTS `spConsultarCodigoDiagnostico`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarCodigoDiagnostico`(IN filtro VARCHAR(45))
begin
  select idCIE10 as id, codigoCIE10 from tbl_cie10 where codigoCIE10 LIKE concat('%',filtro,'%');
end$$

DROP PROCEDURE IF EXISTS `spConsultarCodigoIdCUPCita`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarCodigoIdCUPCita`(IN $id int(11))
BEGIN
  select tbl_cup.codigoCup as codigoCup
  from tbl_cup
  where tbl_cup.idCUP = $id and tbl_cup.idTipoCup=(SELECT tbl_tipocup.idTipoCup
  FROM tbl_tipocup
  WHERE tbl_tipocup.descripcionCUP LIKE 'Citas');
END$$

DROP PROCEDURE IF EXISTS `spConsultarCodigoIdDiagnostico`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarCodigoIdDiagnostico`(IN id INT(11))
begin
  select codigoCIE10 from tbl_cie10 where idCIE10 = id;
end$$

DROP PROCEDURE IF EXISTS `spConsultarCodigoIdProcedimiento`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarCodigoIdProcedimiento`(IN id INT(11))
begin
  select codigoCup from tbl_cup where idCup = id;
end$$

DROP PROCEDURE IF EXISTS `spConsultarCodigoProcedimientos`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarCodigoProcedimientos`(IN filtro VARCHAR(45))
begin
  select idCup as id, codigoCup from tbl_cup where codigoCup LIKE concat('%',filtro,'%');
end$$

DROP PROCEDURE IF EXISTS `spConsultarCodProcedi`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarCodProcedi`(IN `$filtro` VARCHAR(1000))
BEGIN
  select idCup as id,codigoCup from tbl_cup
  where idTipoCup = (select idTipoCup from tbl_tipocup where descripcionCUP like 'Citas' )
  or idTipoCup = (select idTipoCup from tbl_tipocup where descripcionCUP like 'Otro' )
  and codigoCup LIKE CONCAT('%',CONCAT($filtro, '%'));
END$$

DROP PROCEDURE IF EXISTS `spConsultarConfiguracion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarConfiguracion`(IN $idConfiguracion INT)
BEGIN
    SELECT * FROM `tbl_configuracion` WHERE `idConfiguracion` = $idConfiguracion;
    END$$

DROP PROCEDURE IF EXISTS `spConsultarCorreoPersonaP`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarCorreoPersonaP`(IN $idPersona INT)
BEGIN
  select `correoElectronico`
  from `tbl_persona`
  where `idPersona` = $idPersona;
END$$

DROP PROCEDURE IF EXISTS `spConsultarCuentausuario`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarCuentausuario`(IN $idUsuario INT)
BEGIN
    SELECT * FROM `tbl_cuentausuario` WHERE `idUsuario` = $idUsuario;
    END$$

DROP PROCEDURE IF EXISTS `spConsultarCuidadoantarribo`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarCuidadoantarribo`(IN $idCuidadoAntArribo INT)
BEGIN
    SELECT * FROM `tbl_cuidadoantarribo` WHERE `idCuidadoAntArribo` = $idCuidadoAntArribo;
    END$$

DROP PROCEDURE IF EXISTS `spConsultarCup`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarCup`(IN $idCUP INT)
BEGIN
    SELECT * FROM `tbl_cup` WHERE `idCUP` = $idCUP;
    END$$

DROP PROCEDURE IF EXISTS `spConsultarDatosNotificacion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarDatosNotificacion`($idPersona INT)
BEGIN
  SELECT  CONCAT(
      IFNULL(PE.primerNombre, ''), ' ',
      IFNULL(PE.segundoNombre, ''), ' ',
      IFNULL(PE.primerApellido, ''), ' ',
      IFNULL(PE.segundoApellido, '')) AS 'nombreCompleto',
      TA.fechaEnvio,
      TA.descripcionAutorizacion,
      TA.idTemporalAutorizacion,
      PE.urlFoto
FROM tbl_cuentausuario CU
INNER JOIN tbl_persona PE
ON CU.idPersona = PE.idPersona
INNER JOIN tbl_temporalAutorizacion TA
ON CU.idUsuario = TA.idParamedico
WHERE CU.idUsuario = $idPersona
ORDER BY TA.idTemporalAutorizacion DESC
LIMIT 1;
END$$

DROP PROCEDURE IF EXISTS `spConsultarDescripcionCUPcita`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarDescripcionCUPcita`(IN $filtro varchar(1000))
BEGIN
  select tbl_cup.idCUP as id, tbl_cup.nombreCUP as nombreCup
  from tbl_cup
  where tbl_cup.nombreCUP LIKE CONCAT('%',CONCAT($filtro, '%')) and idTipoCup=(SELECT tbl_tipocup.idTipoCup
  FROM tbl_tipocup
  WHERE tbl_tipocup.descripcionCUP LIKE 'Citas');
END$$

DROP PROCEDURE IF EXISTS `spConsultarDescripcionDiagnostico`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarDescripcionDiagnostico`(IN filtro VARCHAR(1000))
begin
  select idCIE10 as id, descripcionCIE10 from tbl_cie10 where descripcionCIE10 LIKE concat('%',filtro,'%');
end$$

DROP PROCEDURE IF EXISTS `spConsultarDescripcionIdCUPcita`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarDescripcionIdCUPcita`(IN $id int(11))
BEGIN
select tbl_cup.nombreCUP  as nombreCup
from tbl_cup
where tbl_cup.idCUP = $id and tbl_cup.idTipoCup=(SELECT tbl_tipocup.idTipoCup
FROM tbl_tipocup
WHERE tbl_tipocup.descripcionCUP LIKE 'Citas');
END$$

DROP PROCEDURE IF EXISTS `spConsultarDescripcionIdDiagnostico`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarDescripcionIdDiagnostico`(IN id INT(11))
begin
select descripcionCIE10 from tbl_cie10 where idCIE10 = id;
end$$

DROP PROCEDURE IF EXISTS `spConsultarDescripcionIdProcedimiento`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarDescripcionIdProcedimiento`(IN id INT(11))
begin
  select nombreCup from tbl_cup where idCup = id;
end$$

DROP PROCEDURE IF EXISTS `spConsultarDescripcionProcedimiento`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarDescripcionProcedimiento`(IN filtro VARCHAR(1000))
begin
  select idCup as id, nombreCup from tbl_cup where nombreCup LIKE concat('%',filtro,'%');
end$$

DROP PROCEDURE IF EXISTS `spConsultarDesfibrilacion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarDesfibrilacion`(IN $iddesfibrilacion INT)
BEGIN
    SELECT * FROM `tbl_desfibrilacion` WHERE `iddesfibrilacion` = $iddesfibrilacion;
    END$$

DROP PROCEDURE IF EXISTS `spConsultarDesfibrilacionAPH`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarDesfibrilacionAPH`(
  $idReporteAph INT
)
BEGIN
SELECT DES.horaDesfibrilacion, DES.joules FROM tbl_desfibrilacion DES
INNER JOIN tbl_reporteaph RA
ON RA.idReporteAPH = DES.idReporteAPH
WHERE RA.idReporteAPH = $idReporteAph;
END$$

DROP PROCEDURE IF EXISTS `spConsultarDespacho`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarDespacho`(IN $idDespacho INT)
BEGIN
    SELECT * FROM `tbl_despacho` WHERE `idDespacho` = $idDespacho;
    END$$

DROP PROCEDURE IF EXISTS `SpConsultarDespachoAPH`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SpConsultarDespachoAPH`($idDespacho int)
BEGIN
  SELECT asper.idAsignacionPersonal,desp.idDespacho,detas.idPersona,GROUP_CONCAT(per.primerNombre,' ',per.primerApellido)
          Nombres,asper.idAmbulancia,DATE_FORMAT(fechaHoraDespacho, '%T') fechaHoraDespacho,longitud,latitud,
          CONCAT(perdes.primerNombre, ' ', perdes.primerApellido)nombreDespachador
  FROM tbl_despacho desp
  INNER JOIN tbl_asignacionpersonal asper
  ON desp.idAmbulancia = asper.idAmbulancia
  INNER JOIN tbl_detalleasignacion detas
  ON asper.idAsignacionPersonal = detas.idAsignacionPersonal
  INNER JOIN tbl_persona per
  ON detas.idPersona = per.idPersona
  INNER JOIN tbl_persona perdes ON perdes.idPersona = desp.idPersona
  WHERE desp.idDespacho = $idDespacho AND LOWER(asper.estadoTablaAsignacion) = LOWER("activo");
END$$

DROP PROCEDURE IF EXISTS `spConsultarDetalleasignacion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarDetalleasignacion`(IN $idDetalleAsignacion INT)
BEGIN
    SELECT * FROM `tbl_detalleasignacion` WHERE `idDetalleAsignacion` = $idDetalleAsignacion;
    END$$

DROP PROCEDURE IF EXISTS `spConsultarDetallekit`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarDetallekit`(IN $idDetallekit INT)
BEGIN
    SELECT * FROM `tbl_detallekit` WHERE `idDetallekit` = $idDetallekit;
    END$$

DROP PROCEDURE IF EXISTS `spConsultarDetalletratamientodmcrecurso`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarDetalletratamientodmcrecurso`(IN $idDetalleTratamientodmcRecurso INT)
BEGIN
    SELECT * FROM `tbl_detalletratamientodmcrecurso` WHERE `idDetalleTratamientodmcRecurso` = $idDetalleTratamientodmcRecurso;
    END$$

DROP PROCEDURE IF EXISTS `spConsultarDevolucion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarDevolucion`(IN $idDevolucion INT)
BEGIN
    SELECT * FROM `tbl_devolucion` WHERE `idDevolucion` = $idDevolucion;
    END$$

DROP PROCEDURE IF EXISTS `spConsultarDiagnostico`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarDiagnostico`(IN $idDiagnostico INT)
BEGIN
    SELECT * FROM `tbl_diagnostico` WHERE `idDiagnostico` = $idDiagnostico;
    END$$

DROP PROCEDURE IF EXISTS `spConsultarDiagnosticoDmc`$$
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

DROP PROCEDURE IF EXISTS `spConsultarDiasMora`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarDiasMora`(IN `$idPaciente` INT)
BEGIN
 select tm.diasMulta, thm.fechaHistorial
 from tbl_multa tm inner join tbl_historialmora thm on thm.idMulta = tm.idMulta inner join tbl_cita tc on tc.idCita = thm.idCita inner join tbl_paciente tp on tp.idPaciente = tc.idPaciente where tp.idPaciente = $idPaciente;
END$$

DROP PROCEDURE IF EXISTS `spConsultarEmailPaciente`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarEmailPaciente`(IN $idPaciente INT)
BEGIN
  select correoElectronico from tbl_paciente where idPaciente = $idPaciente;
END$$

DROP PROCEDURE IF EXISTS `spConsultarEnteexterno`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarEnteexterno`(IN $idEnteExterno INT)
BEGIN
    SELECT * FROM `tbl_enteexterno` WHERE `idEnteExterno` = $idEnteExterno;
    END$$

DROP PROCEDURE IF EXISTS `spConsultarEnteexterno_reporteinicial`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarEnteexterno_reporteinicial`(IN idReporteInicial INT)
BEGIN
  SELECT ext.descripcionEnteExterno
  FROM tbl_enteexterno_reporteinicial tex
  INNER JOIN tbl_enteexterno ext
  ON tex.idEnteExterno = ext.idEnteExterno
  WHERE tex.idReporteInicial = idReporteInicial;
END$$

DROP PROCEDURE IF EXISTS `spConsultarEquipobiomedico`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarEquipobiomedico`(IN $idEquipoBiomedico INT)
BEGIN
    SELECT * FROM `tbl_equipobiomedico` WHERE `idEquipoBiomedico` = $idEquipoBiomedico;
    END$$

DROP PROCEDURE IF EXISTS `spConsultarEspecialidad`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarEspecialidad`(IN $idEspecialidad INT)
BEGIN
    SELECT * FROM `tbl_especialidad` WHERE `idEspecialidad` = $idEspecialidad;
    END$$

DROP PROCEDURE IF EXISTS `spConsultarEspecialidadPersona`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarEspecialidadPersona`(IN _idPersona int)
BEGIN
  SELECT tblr.descripcionRol
  from tbl_persona AS tblp
  INNER JOIN tbl_cuentausuario AS tblcu
  ON tblp.idPersona = tblcu.idPersona
  INNER JOIN tbl_rol AS tblr
  ON tblcu.idRol = tblr.idRol
  WHERE tblp.idPersona = _idPersona;
END$$

DROP PROCEDURE IF EXISTS `spConsultarEstadopaciente`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarEstadopaciente`(IN $idEstadoPaciente INT)
BEGIN
    SELECT * FROM `tbl_estadopaciente` WHERE `idEstadoPaciente` = $idEstadoPaciente;
    END$$

DROP PROCEDURE IF EXISTS `spConsultarEstandarkit`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarEstandarkit`(IN $idEstandarkit INT)
BEGIN
    SELECT * FROM `tbl_estandarkit` WHERE `idEstandarkit` = $idEstandarkit;
    END$$

DROP PROCEDURE IF EXISTS `spConsultarEvaluacionautorizacion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarEvaluacionautorizacion`(IN $idEvaluacionAutorizacion INT)
BEGIN
    SELECT * FROM `tbl_evaluacionautorizacion` WHERE `idEvaluacionAutorizacion` = $idEvaluacionAutorizacion;
    END$$

DROP PROCEDURE IF EXISTS `spConsultarExamenesfisicoDmc`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarExamenesfisicoDmc`(in $idAtencion INT)
BEGIN
  select estadoTablaExamen,descripcionExamen,descripcionExamenFisico,idHistoriaClinica
  from tbl_examenfisicodmc as exm
  inner join tbl_tipoexamenfisico as tipe
  on exm.idtipoExamenFisico=tipe.idtipoExamenFisico
  where idHistoriaClinica=$idAtencion;
END$$

DROP PROCEDURE IF EXISTS `spConsultarExamenespecializado`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarExamenespecializado`(IN $idExamenEspecializado INT)
BEGIN
    SELECT * FROM `tbl_examenespecializado` WHERE `idExamenEspecializado` = $idExamenEspecializado;
    END$$

DROP PROCEDURE IF EXISTS `spConsultarExamenfisicoaph`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarExamenfisicoaph`(IN $idExamenFisico INT)
BEGIN
    SELECT * FROM `tbl_examenfisicoaph` WHERE `idExamenFisico` = $idExamenFisico;
    END$$

DROP PROCEDURE IF EXISTS `spConsultarExamenfisicodmc`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarExamenfisicodmc`(IN $idExamenFisico INT)
BEGIN
    SELECT * FROM `tbl_examenfisicodmc` WHERE `idExamenFisico` = $idExamenFisico;
    END$$

DROP PROCEDURE IF EXISTS `spConsultarFechaAtencion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarFechaAtencion`( IN `$idAtencion` INT )
BEGIN
 SELECT fechaAtencion FROM `tbl_historiaclinica` WHERE idHistoriaClinica = $idAtencion;
END$$

DROP PROCEDURE IF EXISTS `spConsultarFormulamedica`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarFormulamedica`(IN $idFormulaMedica INT)
BEGIN
    SELECT * FROM `tbl_formulamedica` WHERE `idFormulaMedica` = $idFormulaMedica;
    END$$

DROP PROCEDURE IF EXISTS `spConsultarFormulamedicamedicamentodmc`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarFormulamedicamedicamentodmc`(IN $idFormulaMedicaMedicamentoDmc INT)
BEGIN
    SELECT * FROM `tbl_formulamedicamedicamentodmc` WHERE `idFormulaMedicaMedicamentoDmc` = $idFormulaMedicaMedicamentoDmc;
    END$$

DROP PROCEDURE IF EXISTS `SpConsultarGeolocalizacion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SpConsultarGeolocalizacion`(`$idDespacho` int)
BEGIN
  SELECT longitudEmergencia,latitudEmergencia,asig.longitud longitudAmbulancia,asig.latitud latitudAmbulancia
  FROM tbl_despacho desp
  INNER JOIN tbl_asignacionpersonal asig
  ON desp.idAmbulancia = asig.idAmbulancia
  WHERE desp.idDespacho = `$idDespacho` AND LOWER(asig.estadoTablaAsignacion) = LOWER("activo");
END$$

DROP PROCEDURE IF EXISTS `spConsultarHistoriaClinic`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarHistoriaClinic`()
BEGIN
  select  distinct his.idPaciente,primerNombre,ifnull(segundoNombre,'') as 'segundoNombre',
              primerApellido,ifnull(segundoApellido,'Ningun registro') as 'segundoApellido',descripcionTdocumento,numeroDocumento
              from tbl_historiaclinica as his
              inner join tbl_paciente as pac
              on his.idPaciente=pac.idPaciente
              inner join tbl_tipodocumento as doc
              on pac.idtipoDocumento=doc.idtipoDocumento;
END$$

DROP PROCEDURE IF EXISTS `spConsultarHistoriaclinica`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarHistoriaclinica`(IN $idHistoriaClinica INT)
BEGIN
    SELECT * FROM `tbl_historiaclinica` WHERE `idHistoriaClinica` = $idHistoriaClinica;
    END$$

DROP PROCEDURE IF EXISTS `spConsultarHistorialmora`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarHistorialmora`(IN $idHistorialMora INT)
BEGIN
    SELECT * FROM `tbl_historialmora` WHERE `idHistorialMora` = $idHistorialMora;
    END$$

DROP PROCEDURE IF EXISTS `spConsultarHistorialP`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarHistorialP`(IN $fehca date, $id int)
BEGIN
  select p.Fecha_inicial
  from `tbl_turnoprogramacion` t
  inner join `tbl_programacion` p
  on t.idProgramacion = p.idProgramacion
  where t.idPersona = $id and date_format(p.Fecha_final,'%m-%Y')= date_format($fehca,'%m-%Y') and (t.estadoTablaProgramacion = 'Activo' or t.estadoTablaProgramacion = 'Terminado');
END$$

DROP PROCEDURE IF EXISTS `spConsultarHorario`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarHorario`(IN $FechaCapt DATE)
BEGIN
SELECT DISTINCT tbl_turno.horaInicioTurno, tbl_turno.horaFinalTurno
FROM tbl_turnoprogramacion
INNER JOIN tbl_turno
ON tbl_turnoprogramacion.idTurno = tbl_turno.idTurno
INNER JOIN tbl_programacion
ON tbl_turnoprogramacion.idProgramacion = tbl_programacion.idProgramacion
    INNER JOIN tbl_persona
    ON tbl_turnoprogramacion.idPersona=tbl_persona.idPersona
    INNER JOIN tbl_cuentausuario
    ON tbl_persona.idPersona=tbl_cuentausuario.idPersona
    INNER JOIN tbl_rol
    ON tbl_cuentausuario.idRol=tbl_rol.idRol
    INNER JOIN tbl_personaespecialidad
ON tbl_persona.idPersona=tbl_personaespecialidad.idPersona
    INNER JOIN tbl_especialidad
    ON tbl_personaespecialidad.idEspecialidad=tbl_especialidad.idEspecialidad
WHERE
    ($FechaCapt = tbl_programacion.Fecha_inicial  AND tbl_turnoprogramacion.estadoTablaProgramacion LIKE 'Activo')
    AND (tbl_rol.descripcionRol LIKE "Medico" AND tbl_rol.estadoTabla LIKE "Activo")
    AND (tbl_personaespecialidad.estadoTablaEspecialidad LIKE "Activo" AND tbl_especialidad.estadoTabla LIKE "Activo");
END$$

DROP PROCEDURE IF EXISTS `spConsultarHoraSignosVitales`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarHoraSignosVitales`(IN $idAtencion INT )
begin
  select hora from tbl_signosvitales where idHistoriaClinica= $idAtencion limit 4;
end$$

DROP PROCEDURE IF EXISTS `spConsultarIdAmbulancia`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarIdAmbulancia`(IN `$idPersona` INT)
BEGIN
  SELECT ap.idAmbulancia
  FROM tbl_detalleasignacion da
  INNER JOIN tbl_asignacionpersonal ap
  ON ap.idAsignacionPersonal = da.idAsignacionPersonal
  WHERE da.idPersona = (SELECT idPersona FROM tbl_cuentausuario WHERE idUsuario = $idPersona) AND da.estadoTabla = "Activo";
END$$

DROP PROCEDURE IF EXISTS `spConsultaridEspecialidad`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultaridEspecialidad`(IN `$idPersona` INT)
BEGIN
  SELECT idEspecialidad FROM tbl_personaespecialidad WHERE idPersona = $idPersona;
END$$

DROP PROCEDURE IF EXISTS `spConsultarIdHistoriaClinicaDmc`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarIdHistoriaClinicaDmc`(in $idHistoriaClinica int)
BEGIN
  select idHistoriaClinica
  from tbl_historiaclinica
  where idHistoriaClinica=$idHistoriaClinica;
END$$

DROP PROCEDURE IF EXISTS `spConsultarIdPacienteDmc`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarIdPacienteDmc`(in $idPaciente int)
BEGIN
  select idPaciente
  from tbl_paciente
    where idPaciente=$idPaciente;
END$$

DROP PROCEDURE IF EXISTS `spConsultarIncapacidad`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarIncapacidad`(IN $idIncapacidad INT)
BEGIN
    SELECT * FROM `tbl_incapacidad` WHERE `idIncapacidad` = $idIncapacidad;
    END$$

DROP PROCEDURE IF EXISTS `SpConsultarInformeCita`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SpConsultarInformeCita`(IN `$idCita` INT)
BEGIN
  SELECT distinct CONCAT(pe.primerNombre,' ',pe.primerApellido) AS NombrePersona,ro.descripcionRol FROM tbl_cita ci INNER JOIN tbl_cita_programacion tcp ON $idCita=tcp.idCita INNER JOIN tbl_turnoprogramacion ttp ON tcp.idTurnoProgramacion=ttp.idTurnoProgramacion INNER JOIN tbl_persona pe ON ttp.idPersona=pe.idPersona INNER JOIN tbl_cuentausuario tcu ON pe.idPersona=tcu.idPersona INNER JOIN tbl_rol ro ON tcu.idRol =ro.idRol
  WHERE ro.descripcionRol like 'Medico' or ro.descripcionRol like 'Enfermera Jefe' or ro.descripcionRol like 'Auxiliar de Enfermeria';
END$$

DROP PROCEDURE IF EXISTS `spConsultarInterconsulta`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarInterconsulta`(IN $idInterconsulta INT)
BEGIN
    SELECT * FROM `tbl_interconsulta` WHERE `idInterconsulta` = $idInterconsulta;
    END$$

DROP PROCEDURE IF EXISTS `spConsultarLesion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarLesion`(IN $idLesion INT)
BEGIN
    SELECT * FROM `tbl_lesion` WHERE `idLesion` = $idLesion;
    END$$

DROP PROCEDURE IF EXISTS `spConsultarLlamada`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarLlamada`(IN $idLlamada INT)
BEGIN
    SELECT * FROM `tbl_llamada` WHERE `idLlamada` = $idLlamada;
    END$$

DROP PROCEDURE IF EXISTS `spConsultarMedicacionDmc`$$
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

DROP PROCEDURE IF EXISTS `spConsultarMedicamento`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarMedicamento`(IN $idmedicamento INT)
BEGIN
    SELECT * FROM `tbl_medicamento` WHERE `idmedicamento` = $idmedicamento;
    END$$

DROP PROCEDURE IF EXISTS `spConsultarMedicamentosAPH`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarMedicamentosAPH`(
  $idReporteAph INT
)
BEGIN
SELECT MED.idmedicamento, RE.nombre 'nombreRecurso', CTR.descripcionCategoriarecurso, MED.dosis, MED.cantidadUnidades, MED.viaAdministracion, MED.hora
FROM tbl_reporteaph RA
INNER JOIN tbl_medicamento MED
ON Ra.idReporteAPH = MED.idReporteAPH
INNER JOIN tbl_detallekit DTK
ON MED.idDetalleKit = DTK.idDetalleKit
INNER JOIN tbl_recurso RE
ON DTK.idRecurso = RE.idRecurso
INNER JOIN tbl_categoriarecurso CTR
ON RE.idCategoriaRecurso = CTR.idCategoriaRecurso
WHERE RA.idReporteAPH = $idReporteAph;
END$$

DROP PROCEDURE IF EXISTS `spConsultarMedicoExterno`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarMedicoExterno`()
BEGIN
  SELECT idRol as Rol FROM `tbl_rol` WHERE `descripcionRol` like ('%Medico Externo%');
END$$

DROP PROCEDURE IF EXISTS `spConsultarMensajeNotificacion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarMensajeNotificacion`(IN $idChat INT)
BEGIN
  SELECT CONCAT(p.primerNombre, ' ', p.primerApellido) 'nombre', m.mensaje, m.fechaHora
  FROM tbl_mensaje m
  INNER JOIN tbl_chat c
  ON m.idChat = c.idChat
  INNER JOIN tbl_cuentausuario cu
  ON c.idUsuarioExterno = cu.idUsuario
  INNER JOIN tbl_persona p
  ON p.idPersona = cu.idPersona
  WHERE c.idChat = $idChat AND tipo = 2
  ORDER BY fechaHora ASC
  LIMIT 1;
END$$

DROP PROCEDURE IF EXISTS `spConsultarMensajesChat`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarMensajesChat`(IN $idChat INT)
BEGIN
  SELECT mensaje, fechaHora, tipo
  FROM `tbl_mensaje`
  WHERE `idChat` = $idChat
  ORDER BY fechaHora ASC;
END$$

DROP PROCEDURE IF EXISTS `spConsultarModulo`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarModulo`(IN $idModulo INT)
BEGIN
    SELECT * FROM `tbl_modulo` WHERE `idModulo` = $idModulo;
    END$$

DROP PROCEDURE IF EXISTS `spConsultarModuloRol`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarModuloRol`(IN $idRol INT)
BEGIN
  SELECT DISTINCT m.idModulo, m.descripcionModulo, m.iconoModulo
  FROM tbl_rolModuloVista rmv
  INNER JOIN tbl_modulo m
  ON rmv.idModulo = m.idModulo
  INNER JOIN tbl_rol r
  ON rmv.idRol = r.idRol
  WHERE r.idRol = $idRol;
END$$

DROP PROCEDURE IF EXISTS `spConsultarModuloVista`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarModuloVista`(IN `$idRol` INT, IN `$idModulo` INT)
BEGIN
  SELECT v.idVista, v.descripcionVista, v.urlVista, v.iconoVista
  FROM tbl_rolModuloVista rmv
  INNER JOIN tbl_vista v
  ON rmv.idVista = v.idVista
  INNER JOIN tbl_modulo m
  ON rmv.idModulo = m.idModulo
  INNER JOIN tbl_rol r
  ON rmv.idRol = r.idRol
  WHERE r.idRol = $idRol
  AND m.idModulo = $idModulo
  AND v.estado = "Activo";
END$$

DROP PROCEDURE IF EXISTS `spConsultarMotivoconsulta`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarMotivoconsulta`(IN $idMotivoConsulta INT)
BEGIN
    SELECT * FROM `tbl_motivoconsulta` WHERE `idMotivoConsulta` = $idMotivoConsulta;
    END$$

DROP PROCEDURE IF EXISTS `spConsultarMotivoConsultaAPH`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarMotivoConsultaAPH`(
  $idReporteAph INT
)
BEGIN
SELECT MTC.idMotivoConsulta, MTC.descripcionMotivoConsulta, RMC.especificacion, MTC.TipoMotivoConsulta
FROM tbl_reporteaph RA
INNER JOIN tbl_reporteaph_motivoconsulta RMC
ON RMC.idReporteAPH = RA.idReporteAPH
INNER JOIN tbl_motivoconsulta MTC
ON MTC.idMotivoConsulta = RMC.idMotivoConsulta
WHERE RA.idReporteAPH = $idReporteAph;
END$$

DROP PROCEDURE IF EXISTS `spConsultarMulta`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarMulta`(IN $idMulta INT)
BEGIN
    SELECT * FROM `tbl_multa` WHERE `idMulta` = $idMulta;
    END$$

DROP PROCEDURE IF EXISTS `spConsultarNotaenfermeria`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarNotaenfermeria`(IN $idNotaEnfermeria INT)
BEGIN
    SELECT * FROM `tbl_notaenfermeria` WHERE `idNotaEnfermeria` = $idNotaEnfermeria;
    END$$

DROP PROCEDURE IF EXISTS `spConsultarNotificacionesChat`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarNotificacionesChat`(IN $idReceptor INT)
BEGIN
  SELECT *
  FROM tbl_chat
  WHERE idReceptorInicial = $idReceptor AND estadoTabla = 1 AND visto = 0;
END$$

DROP PROCEDURE IF EXISTS `spConsultarNovedadrecurso`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarNovedadrecurso`(IN $idNovedadRecurso INT)
BEGIN
    SELECT * FROM `tbl_novedadrecurso` WHERE `idNovedadRecurso` = $idNovedadRecurso;
    END$$

DROP PROCEDURE IF EXISTS `spConsultarNovedadreporteinicial`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarNovedadreporteinicial`(IN idReporte INT)
BEGIN
  SELECT descripcionNovedad, fechaHoraNovedad
  FROM `tbl_novedadreporteinicial`
  WHERE idReporteInicial = idReporte;
END$$

DROP PROCEDURE IF EXISTS `spConsultarNovedadreporteinicial_enteexterno`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarNovedadreporteinicial_enteexterno`(IN $idNovedadReporteInicialEnteExterno INT)
BEGIN
    SELECT * FROM `tbl_novedadreporteinicial_enteexterno` WHERE `idNovedadReporteInicialEnteExterno` = $idNovedadReporteInicialEnteExterno;
    END$$

DROP PROCEDURE IF EXISTS `spConsultarObservacion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarObservacion`(IN $idObservacion INT)
BEGIN
    SELECT * FROM `tbl_observacion` WHERE `idObservacion` = $idObservacion;
    END$$

DROP PROCEDURE IF EXISTS `spConsultarOtrodmc`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarOtrodmc`(IN $idOtro INT)
BEGIN
    SELECT * FROM `tbl_otrodmc` WHERE `idOtro` = $idOtro;
    END$$

DROP PROCEDURE IF EXISTS `spConsultarPaciente`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarPaciente`(IN $idPaciente INT)
BEGIN
    SELECT numeroDocumento,fechaNacimiento,tipoSangre,primerNombre,segundoNombre,primerApellido,segundoApellido,
    genero,estadoCivil,ciudadResidencia,barrioResidencia,direccion,telefonoFijo,telefonoMovil,correoElectronico,empresa,
    ocupacion,profesion,descripcionTdocumento,descripcionAfiliacion
    FROM `tbl_paciente` paciente
    INNER JOIN tbl_tipodocumento documento on
    documento.idTipoDocumento = paciente.idTipoDocumento
    INNER JOIN tbl_tipoafiliacion afiliacion on
    afiliacion.idTipoAfiliacion =paciente.idTipoAfiliacion
    WHERE `idPaciente` = $idPaciente;
    END$$

DROP PROCEDURE IF EXISTS `spConsultarPacienteAcompanante`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarPacienteAcompanante`(IN `$idPa` INT)
BEGIN
  SELECT *
  FROM `tbl_acompanante` a
  INNER JOIN tbl_paciente p
  ON p.idPaciente = a.idPaciente
  Where p.idPaciente = $idPa;
END$$

DROP PROCEDURE IF EXISTS `spConsultarPacienteAtencion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarPacienteAtencion`(IN `$idPaciente` INT)
BEGIN
  SELECT
  p.idPaciente,
  p.numeroDocumento,
  p.fechaNacimiento,
  p.tipoSangre,
  p.primerNombre,
  ifnull(p.segundoNombre,' ') as segundoNombre,
  p.primerApellido,
  p.segundoApellido,
  p.genero, p.estadoCivil,
  p.ciudadResidencia,
  p.barrioResidencia,
  p.direccion,
  p.telefonoFijo,
  p.telefonoMovil,
  p.correoElectronico,
  p.edadPaciente,
  td.descripcionTdocumento,
  ta.descripcionAfiliacion
  FROM tbl_paciente p
  INNER JOIN tbl_tipodocumento td ON td.idTipoDocumento = p.idtipoDocumento
  INNER JOIN tbl_tipoafiliacion ta ON ta.idTipoAfiliacion = p.idtipoAfiliacion
  WHERE idPaciente = $idPaciente;
END$$

DROP PROCEDURE IF EXISTS `spConsultarPacienteDocumento`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarPacienteDocumento`(IN `$numeroDocumento` VARCHAR(45))
BEGIN
  SELECT * FROM  tbl_paciente
  Where numeroDocumento = $numeroDocumento;
END$$

DROP PROCEDURE IF EXISTS `spConsultarPacienteDomiciliaria`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarPacienteDomiciliaria`(IN `$idPaciente` INT)
BEGIN
  select * from tbl_paciente where idPaciente = $idPaciente;
END$$

DROP PROCEDURE IF EXISTS `spConsultarPacienteIdDmc`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarPacienteIdDmc`(IN $idAtencion INT)
begin
  select  idPaciente
  from tbl_historiaclinica
  where idPaciente=$idAtencion;
end$$

DROP PROCEDURE IF EXISTS `spConsultarPerfil`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarPerfil`(
  $idUsuario INT
)
BEGIN
  SELECT p.idPersona, p.urlFoto,
  p.primerNombre, p.segundoNombre, p.primerApellido,     p.segundoApellido,p.idTipoDocumento, p.numeroDocumento,   p.fechaNacimiento, p.sexo, p.direccion, p.telefono,   p.correoElectronico, p.ciudad, p.departamento, p.pais, cu.usuario
  FROM
  tbl_persona p INNER JOIN tbl_cuentausuario cu
  ON p.idPersona = cu.idPersona
  WHERE cu.idUsuario = $idUsuario;
END$$

DROP PROCEDURE IF EXISTS `spConsultarPersona`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarPersona`(IN $idPersona INT)
BEGIN
    SELECT * FROM `tbl_persona` WHERE `idPersona` = $idPersona;
    END$$

DROP PROCEDURE IF EXISTS `spConsultarPersonaAtencion`$$
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
END$$

DROP PROCEDURE IF EXISTS `spConsultarpersonaconespecialidad`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarpersonaconespecialidad`()
BEGIN
  Select (select COUNT(pr.idProgramacion) FROM tbl_turnoprogramacion pr where pr.idPersona = pe.idPersona and pr.estadoTablaProgramacion = 'Activo') as pro, pe.idPersona, pe.primerNombre,pe.primerApellido,r.descripcionRol,pe.estadoTablaPersona,pe.dependencia from tbl_persona pe inner join tbl_cuentausuario c on pe.idPersona = c.idPersona inner join tbl_rol r on r.idRol = c.idRol where (r.descripcionRol = "Auxiliar de Enfermeria" or r.descripcionRol = "Enfermera Jefe" or r.descripcionRol= "Medico") and pe.estadoTablaPersona = "Activo" and pe.dependencia = "Domiciliaria";
END$$

DROP PROCEDURE IF EXISTS `spConsultarPersonaDocumento`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarPersonaDocumento`(IN `$numeroDocumento` VARCHAR(45))
BEGIN
  SELECT * FROM tbl_persona
  INNER JOIN tbl_cuentausuario
  ON tbl_persona.idPersona = tbl_cuentausuario.idPersona
  INNER JOIN tbl_rol
  ON tbl_rol.idRol = tbl_cuentausuario.idRol
  Where numeroDocumento = $numeroDocumento AND descripcionRol like ('%Medico Externo%');
END$$

DROP PROCEDURE IF EXISTS `spConsultarPersonaespecialidad`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarPersonaespecialidad`(IN $idPersonaespecialidad INT)
BEGIN
    SELECT * FROM `tbl_personaespecialidad` WHERE `idPersonaespecialidad` = $idPersonaespecialidad;
    END$$

DROP PROCEDURE IF EXISTS `spConsultarPersonalAsistencial`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarPersonalAsistencial`(IN `$idCita` INT)
BEGIN
  SELECT distinct ro.descripcionRol, CONCAT(pe.primerNombre,' ',pe.primerApellido) AS NombrePersona
  FROM tbl_cita ci
  INNER JOIN tbl_cita_programacion tcp ON tcp.idCita = ci.idCita
  INNER JOIN tbl_turnoprogramacion ttp ON ttp.idTurnoProgramacion = tcp.idTurnoProgramacion
  INNER JOIN tbl_persona pe ON pe.idPersona = ttp.idPersona
  INNER JOIN tbl_cuentausuario tcu ON tcu.idPersona = pe.idPersona
  INNER JOIN tbl_rol ro ON ro.idRol = tcu.idRol
  WHERE ci.idCita = $idCita and ro.descripcionRol
  like 'Medico' or ro.descripcionRol like 'Auxiliar de Enfermeria' or ro.descripcionRol like 'Enfermera Jefe';
END$$

DROP PROCEDURE IF EXISTS `spConsultarPersonaProgramacion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarPersonaProgramacion`(IN $id INT)
BEGIN
  SELECT p.primerNombre ,p.segundoNombre, p.primerApellido,p.segundoApellido,p.telefono,p.direccion,p.numeroDocumento,p.sexo,p.lugarNacimiento,p.fechaNacimiento,p.ciudad,p.departamento,p.correoElectronico,p.estadoPersona,p.pais,p.grupoSanguineo,p.dependencia,e.descripcionEspecialidad , e.idEspecialidad,es.idPersonaespecialidad
  FROM tbl_persona p
  INNER JOIN tbl_personaespecialidad es
  ON p.idPersona = es.idPersona
  INNER JOIN tbl_especialidad e
  ON es.idEspecialidad = e.idEspecialidad
  WHERE p.idPersona = $id;
END$$

DROP PROCEDURE IF EXISTS `spConsultarPersonatodo`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarPersonatodo`(IN $idPersona INT)
BEGIN
  SELECT  pe.primerNombre ,pe.segundoNombre, pe.primerApellido,pe.segundoApellido,pe.telefono,pe.direccion,pe.numeroDocumento,pe.sexo,pe.lugarNacimiento,pe.fechaNacimiento,pe.ciudad,pe.departamento,pe.correoElectronico,pe.estadotablaPersona,pe.pais,pe.grupoSanguineo,r.descripcionRol,pe.dependencia from tbl_persona pe inner join tbl_cuentausuario c on pe.idPersona = c.idPersona inner join tbl_rol r on r.idRol = c.idRol
  where pe.idPersona = $idPersona;
END$$

DROP PROCEDURE IF EXISTS `spConsultarPiel`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarPiel`(IN $idPiel INT)
BEGIN
    SELECT * FROM `tbl_piel` WHERE `idPiel` = $idPiel;
    END$$

DROP PROCEDURE IF EXISTS `spConsultarProcedimiento`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarProcedimiento`(IN $idProcedimiento INT)
BEGIN
    SELECT * FROM `tbl_procedimiento` WHERE `idProcedimiento` = $idProcedimiento;
    END$$

DROP PROCEDURE IF EXISTS `spConsultarProcedimientoDmc`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarProcedimientoDmc`(IN $idAtencion INT)
begin
  select nombreCUP,codigoCup,descripcionProcedimiento,idHistoriaClinica,idProcedimiento
  from tbl_cup as cup
  inner join tbl_procedimiento as pro
  on cup.idCUP=pro.idCUP
  where idHistoriaClinica=$idAtencion;
end$$

DROP PROCEDURE IF EXISTS `spConsultarProcedimientosDmc`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarProcedimientosDmc`(in $idHistoriaClinica int)
BEGIN
  select nombreCUP,codigoCup,descripcionProcedimiento,idHistoriaClinica
              from tbl_cup as cup
              inner join tbl_procedimiento as pro
              on cup.idCUP=pro.idCUP
              where idHistoriaClinica=$idHistoriaClinica;
END$$

DROP PROCEDURE IF EXISTS `spConsultarProcedimientosNotas`$$
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

DROP PROCEDURE IF EXISTS `spConsultarProgramacion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarProgramacion`(IN $fecha_inicial DATE, $fecha_final DATE)
BEGIN SELECT `idProgramacion` FROM `tbl_programacion` WHERE `Fecha_inicial` = $fecha_inicial

and `Fecha_final` = $fecha_final;
    END$$

DROP PROCEDURE IF EXISTS `spConsultarProgramacionCitaCalen`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarProgramacionCitaCalen`()
BEGIN
  SELECT DISTINCT DATE_FORMAT(tbl_programacion.Fecha_inicial,'%e') as DiasDisponibles,DATE_FORMAT(tbl_programacion.Fecha_inicial,'%c') as MesDisponible
  FROM tbl_turnoprogramacion
  INNER JOIN tbl_programacion
  ON tbl_turnoprogramacion.idProgramacion = tbl_programacion.idProgramacion
  INNER JOIN tbl_persona
  ON tbl_turnoprogramacion.idPersona=tbl_persona.idPersona
  INNER JOIN tbl_cuentausuario
  ON tbl_persona.idPersona=tbl_cuentausuario.idPersona
  INNER JOIN tbl_rol
  ON tbl_cuentausuario.idRol=tbl_rol.idRol
  INNER JOIN tbl_personaespecialidad
  ON tbl_persona.idPersona=tbl_personaespecialidad.idPersona
  INNER JOIN tbl_especialidad
  ON tbl_personaespecialidad.idEspecialidad=tbl_especialidad.idEspecialidad
  WHERE
  (tbl_turnoprogramacion.estadoTablaProgramacion LIKE 'Activo')
  AND (tbl_rol.descripcionRol LIKE "Medico" AND tbl_rol.estadoTabla LIKE "Activo")
  AND (tbl_personaespecialidad.estadoTablaEspecialidad LIKE "Activo" AND tbl_especialidad.estadoTabla LIKE "Activo");
END$$

DROP PROCEDURE IF EXISTS `spConsultarprogramacionconturno`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarprogramacionconturno`(IN $idPersona INT)
BEGIN
SELECT p.idPersona,TP.idProgramacion from tbl_persona p INNER JOIN tbl_turnoprogramacion TP on p.idPersona = TP.idPersona
where TP.estadoTablaProgramacion = "Activo" and p.idPersona = $idPersona;
END$$

DROP PROCEDURE IF EXISTS `spConsultarPuntolesion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarPuntolesion`(IN $idPuntoLesion INT)
BEGIN
    SELECT * FROM `tbl_puntolesion` WHERE `idPuntoLesion` = $idPuntoLesion;
    END$$

DROP PROCEDURE IF EXISTS `spConsultarReceptorInicial`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarReceptorInicial`(IN $idUsuario INT)
BEGIN
  SELECT cu.idUsuario, p.urlFoto,
  CONCAT(p.primerNombre, ' ', p.primerApellido) 'nombre',
  p.correoElectronico,
  p.direccion,
  p.telefono,
  (SELECT COUNT(idChat)
  FROM tbl_chat
  WHERE idReceptorInicial = cu.idUsuario) 'reportesRealizados',
  (SELECT COUNT(c.idChat)
  FROM tbl_chat c
  INNER JOIN tbl_reporteinicial ri
  ON ri.idChat = c.idChat
  WHERE c.idReceptorInicial = cu.idUsuario AND ri.estadoTablaReporteInicial LIKE 'finalizado') 'reportesFinalizados',
  (SELECT COUNT(c.idChat)
  FROM tbl_chat c
  INNER JOIN tbl_reporteinicial ri
  ON ri.idChat = c.idChat
  WHERE c.idReceptorInicial = cu.idUsuario AND ri.estadoTablaReporteInicial LIKE 'cancelado') 'reportesCancelados'
  FROM tbl_persona p
  INNER JOIN tbl_cuentausuario cu
  ON cu.idPersona = p.idPersona
  WHERE cu.idUsuario = $idUsuario;
END$$

DROP PROCEDURE IF EXISTS `spConsultarRecurso`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarRecurso`(IN $idrecurso INT)
BEGIN
    SELECT * FROM `tbl_recurso` WHERE `idrecurso` = $idrecurso;
    END$$

DROP PROCEDURE IF EXISTS `spConsultarReporteAPH`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarReporteAPH`( `$idReporteAph` INT)
BEGIN
SET @piel =
  (SELECT GROUP_CONCAT(PIL.descripcion)
   FROM tbl_reporteaph RA
   INNER JOIN tbl_examenfisicoaph EXF ON RA.idExamenFisico = EXF.idExamenFisico
   INNER JOIN tbl_piel PIL ON EXF.idExamenFisico = PIL.idExamenFisico
   WHERE RA.idreporteaph = `$idReporteAph`
 );
SET @CIE10 =
  (SELECT GROUP_CONCAT(DISTINCT CIE.codigoCIE10)
   FROM tbl_reporteaph RA
   INNER JOIN tbl_puntolesion PL ON RA.idreporteaph = PL.idreporteaph
   INNER JOIN tbl_lesion LE ON PL.idPuntoLesion = LE.idPuntoLesion
   INNER JOIN tbl_cie10 CIE ON LE.idCIE10 = CIE.idCIE10
   WHERE RA.idreporteaph = `$idReporteAph`
 );
 SET @personalAtencion =
  (SELECT GROUP_CONCAT(CONCAT(
    IFNULL(PER.primerNombre, ''), ' ',
    IFNULL(PER.segundoNombre, ''), ' ',
    IFNULL(PER.primerApellido, ''), ' ',
    IFNULL(PER.segundoApellido, '') ) SEPARATOR '-')
  FROM tbl_reporteaph RA INNER
  JOIN tbl_asignacionpersonal ASP ON ASP.idAsignacionPersonal = RA.idAsignacionPersonal
  INNER JOIN tbl_detalleasignacion DTA ON ASP.idAsignacionPersonal = DTA.idAsignacionPersonal
  INNER JOIN tbl_persona PER ON DTA.idPersona = PER.idPersona
  WHERE RA.idReporteAPH = $idReporteAph
);
SET @descripcionEvento = (
   SELECT GROUP_CONCAT(TEV.descripcionTipoEvento SEPARATOR ',')
   FROM tbl_tipoevento TEV
   INNER JOIN tbl_tipoevento_reporteinicial TEI ON TEV.idTipoEvento = TEI.idTipoEvento
   INNER JOIN tbl_reporteinicial RI ON TEI.idReporteInicial = RI.idReporteInicial
   INNER JOIN tbl_despacho DP ON RI.idReporteInicial = DP.idReporteInicial
   INNER JOIN tbl_reporteaph RA ON DP.idDespacho = RA.idDespacho
   WHERE RA.idReporteAPH = `$idReporteAph`
 );
 SET @idTiposEvento = (
    SELECT GROUP_CONCAT(TEV.idTipoEvento SEPARATOR ',')
    FROM tbl_tipoevento TEV
    INNER JOIN tbl_tipoevento_reporteinicial TEI ON TEV.idTipoEvento = TEI.idTipoEvento
    INNER JOIN tbl_reporteinicial RI ON TEI.idReporteInicial = RI.idReporteInicial
    INNER JOIN tbl_despacho DP ON RI.idReporteInicial = DP.idReporteInicial
    INNER JOIN tbl_reporteaph RA ON DP.idDespacho = RA.idDespacho
    WHERE RA.idReporteAPH = `$idReporteAph`
  );
SET @cuidadoAntesArribo = (
   SELECT GROUP_CONCAT(CAR.descripcionArribo)
   FROM tbl_reporteaph RA
   INNER JOIN tbl_cuidadoantarribo CAR ON RA.idReporteAph = CAR.idReporteAph
   WHERE RA.idreporteaph = `$idReporteAph`
 );
SELECT
    RI.informacionInicial,
    RI.ubicacionIncidente,
    RI.puntoReferencia,
    RI.fechaHoraAproximadaEmergencia,
    RI.fechaHoraEnvioReporteInicial,
    AM.placaAmbulancia,
    DP.fechaHoraDespacho,
    @idTiposEvento AS 'idTiposEvento',
    @descripcionEvento AS 'tipoEvento',
    TG.idTriage,
    TG.descripcionTriage,
    PA.idPAciente,
    CONCAT(PA.primerNombre,
            ' ',
            PA.segundoNombre,
            ' ',
            PA.primerApellido,
            ' ',
            PA.segundoApellido) AS 'nomrePaciente',
    TD.descripcionTDocumento,
    PA.numeroDocumento,
    PA.edadPaciente,
    PA.genero,
    PA.direccion,
    PA.ciudadResidencia,
    PA.correoElectronico,
    PA.barrioResidencia,
    PA.telefonoMovil,
    PA.telefonoFijo,
    PA.estadoCivil,
    PA.fechaNacimiento,
    PA.ocupacion,
    PA.url,
    @personalAtencion AS 'nombrePersonal',
    EXF.idExamenFisico,
    EXF.horaExamenFisico,
    EXF.estadoRespiracion,
    EXF.respiracion_min,
    EXF.SpO2,
    EXF.estadoPulso,
    EXF.pulsaciones_min,
    EXF.estadoPresionArterial,
    EXF.sistolica,
    EXF.diastolica,
    EXF.PAM,
    EXF.glucometria,
    EXF.conciencia,
    EXF.glasgow,
    EXF.estadoPupilaD,
    EXF.estadoPupilaI,
    EXF.gradoDilatacionPD,
    EXF.gradoDilatacionPI,
    EXF.estadoHemodinamico,
    EXF.especificacionVerbal,
    EXF.especificacionOcular,
    EXF.especificacionMotor,
    EXF.EspecifiqueExamenFisico,
    @cuidadoAntesArribo 'cuidadoAntesArribo',
    @piel AS 'piel',
    RA.idReporteAPH,
    RA.idPaciente,
    RA.placaVehiculo,
    RA.codigoAseguradora,
    RA.numeroPoliza,
    RA.ultimaIngesta,
    RA.descripcionTratamiento,
    RA.descripcionTratamientoAvanzado,
    RA.idTipoAseguramiento,
    RA.evaluacionResultado,
    RA.institucionReceptora,
    RA.situacionEntrega,
    RA.presionArterialEntrega,
    RA.pulsoEntrega,
    RA.respiracionEntrega,
    RA.complicaciones,
    RA.TAPHPresente,
    RA.TPAPHPresente,
    RA.otroPersonalControlM,
    RA.nombreOtroPersonalControlM,
    RA.protocolo,
    RA.idAcompanante,
    ACO.identificacionA,
    TPA.DescripcionTipoAseguramiento,
    ACT.idAfectadoAccidenteTransito,
    ACT.descripcionAfectadoAccidenteTransito,
    CU.usuario AS 'usuarioRecibe',
    CONCAT(IFNULL(PER.primerNombre, ''), ' ', IFNULL(PER.segundoNombre, '')) AS 'nombreRecibe',
    CONCAT(IFNULL(PER.primerApellido,''),' ', IFNULL(PER.segundoApellido, '')) AS 'apellidoRecibe',
    PER.numeroDocumento AS 'documentoRecibe',
    PER.urlFirma AS 'urlFirmaRecibe',
    PER.urlFoto AS 'urlFotoRecibe',
    CONCAT(IFNULL(PERA.primerNombre, ''), ' ', IFNULL(PERA.segundoNombre, '')) AS 'nombreAtiende',
    CONCAT(IFNULL(PERA.primerApellido, ''),' ', IFNULL(PERA.segundoApellido, '')) AS 'apellidoAtiende',
    PERA.numeroDocumento AS 'documentoAtiende',
    PERA.urlFirma AS 'urlFirmaAtiende',
    PERA.urlFoto AS 'urlFotoAtiende',
    RA.fechaHoraArriboEscena,
    RA.fechaHoraFinalizacion,
    RA.fechaHoraArriboIPS,
    CTA.idCertificadoAtencion,
    CTA.descripcionCertificadoAtencion
FROM
  tbl_reporteinicial RI
      INNER JOIN
  tbl_despacho DP ON RI.idReporteInicial = DP.idReporteInicial
      INNER JOIN
  tbl_ambulancia AM ON DP.idAmbulancia = AM.idAmbulancia
      INNER JOIN
  tbl_reporteaph RA ON DP.idDespacho = RA.idDespacho
      INNER JOIN
  tbl_triage TG ON RA.idTriage = TG.idTriage
      INNER JOIN
  tbl_paciente PA ON RA.idPaciente = PA.idPaciente
      INNER JOIN
  tbl_tipodocumento TD ON PA.idTipoDocumento = TD.idTipoDocumento
      INNER JOIN
  tbl_examenfisicoaph EXF ON RA.idExamenFisico = EXF.idExamenFisico
      INNER JOIN
  tbl_certificadoatencion CTA ON RA.idCertificadoAtencion = CTA.idCertificadoAtencion
      INNER JOIN
  tbl_tipoaseguramiento TPA ON RA.idTipoAseguramiento = TPA.idTipoAseguramiento
      LEFT JOIN
  tbl_afectadoaccidentetransito ACT ON RA.idAfectadoAccidenteTransito = ACT.idAfectadoAccidenteTransito
      LEFT JOIN
  tbl_cuentausuario CU ON RA.idPersonalRecibe = CU.idPersona
      LEFT JOIN
  tbl_persona PER ON PER.idPersona = CU.idPersona
      LEFT JOIN
  tbl_acompanante ACO ON RA.idAcompanante = ACO.idAcompanante
      INNER JOIN
  tbl_cuentausuario CUENTA ON RA.idParamedicoAtiende = CUENTA.idUsuario
  INNER JOIN tbl_persona PERA ON CUENTA.idPersona = PERA.idPersona

WHERE
    RA.idReporteAph = `$idReporteAph`;
END$$

DROP PROCEDURE IF EXISTS `spConsultarReporteaph_motivoconsulta`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarReporteaph_motivoconsulta`(IN $idAPHMC INT)
BEGIN
    SELECT * FROM `tbl_reporteaph_motivoconsulta` WHERE `idAPHMC` = $idAPHMC;
    END$$

DROP PROCEDURE IF EXISTS `spConsultarReporteinicial`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarReporteinicial`(IN $idReporteInicial INT)
BEGIN
    SELECT * FROM `tbl_reporteinicial` WHERE `idReporteInicial` = $idReporteInicial;
    END$$

DROP PROCEDURE IF EXISTS `SpConsultarReporteInicialAPH`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SpConsultarReporteInicialAPH`($idReporteI int)
BEGIN
  SELECT  GROUP_CONCAT(descripcionTipoEvento) descripcionTipoEvento,GROUP_CONCAT(tbl_tipoevento_reporteinicial.idTipoEvento)idTipoEvento ,tbl_tipoevento_reporteinicial.idReporteInicial,informacionInicial,DATE_FORMAT(fechaHoraAproximadaEmergencia, '%T') fechaHoraAproximadaEmergencia ,DATE_FORMAT(fechaHoraEnvioReporteInicial, '%T')fechaHoraEnvioReporteInicial,   ubicacionIncidente,puntoReferencia,numeroLesionados,CONCAT(perri.primerNombre, ' ', perri.primerApellido)ReceptorInicial,CONCAT(perue.primerNombre, ' ', perue.primerApellido)UsuarioExterno, perue.telefono as telefonousuarioExterno
  FROM tbl_reporteinicial
  INNER JOIN tbl_tipoevento_reporteinicial
  ON tbl_tipoevento_reporteinicial.idReporteInicial = tbl_reporteinicial.idReporteInicial
  INNER JOIN tbl_tipoevento
  ON tbl_tipoevento_reporteinicial.idTipoEvento = tbl_tipoevento.idTipoEvento
  INNER JOIN tbl_chat ON tbl_chat.idChat = tbl_reporteInicial.idChat
  INNER JOIN tbl_cuentausuario tblcuri ON tblcuri.idUsuario = tbl_chat.idReceptorInicial
  INNER JOIN tbl_persona perri ON perri.idPersona = tblcuri.idPersona
  INNER JOIN tbl_cuentausuario tblcuue on tblcuue.idUsuario = tbl_chat.idUsuarioExterno
  INNER JOIN tbl_persona perue ON perue.idPersona = tblcuue.idPersona
  WHERE tbl_reporteInicial.idReporteInicial = $idReporteI
  GROUP BY tbl_tipoevento_reporteinicial.idReporteInicial;
END$$

DROP PROCEDURE IF EXISTS `spConsultarRespuestaNotificacionTemporal`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarRespuestaNotificacionTemporal`()
BEGIN
select tc.usuario,tt.observacionRespuestaAutorizacion,tt.estadoEvaluacion,tt.cedulaPaciente,tt.fechaEvaluacion
from tbl_temporalautorizacion tt
inner join tbl_cuentausuario tc
on tt.idMedico = tc.idUsuario
inner join tbl_persona tp
on tp.idPersona = tc.idUsuario
order by tt.fechaEvaluacion DESC
limit 1;
END$$

DROP PROCEDURE IF EXISTS `spConsultarRestablecer`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarRestablecer`(IN $idRestablecer INT)
BEGIN
    SELECT * FROM `tbl_restablecer` WHERE `idRestablecer` = $idRestablecer;
    END$$

DROP PROCEDURE IF EXISTS `spConsultarResultadosSignosVitales`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarResultadosSignosVitales`(IN $idAtencion INT)
begin
  select resultado from tbl_signosvitales where idHistoriaClinica=$idAtencion;
end$$

DROP PROCEDURE IF EXISTS `spConsultarRol`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarRol`(IN $idRol INT)
BEGIN
    SELECT * FROM `tbl_rol` WHERE `idRol` = $idRol;
    END$$

DROP PROCEDURE IF EXISTS `spConsultarRolmodulovista`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarRolmodulovista`(IN $idRolModuloVista INT)
BEGIN
    SELECT * FROM `tbl_rolmodulovista` WHERE `idRolModuloVista` = $idRolModuloVista;
    END$$

DROP PROCEDURE IF EXISTS `spConsultarSignosvitales`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarSignosvitales`(IN $idSignosVitales INT)
BEGIN
    SELECT * FROM `tbl_signosvitales` WHERE `idSignosVitales` = $idSignosVitales;
    END$$

DROP PROCEDURE IF EXISTS `spConsultarSolicitud`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarSolicitud`(IN $idSolicitud INT)
BEGIN
    SELECT * FROM `tbl_solicitud` WHERE `idSolicitud` = $idSolicitud;
    END$$

DROP PROCEDURE IF EXISTS `spConsultarTestigo`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarTestigo`(IN $idTestigo INT)
BEGIN
    SELECT * FROM `tbl_testigo` WHERE `idTestigo` = $idTestigo;
    END$$

DROP PROCEDURE IF EXISTS `spConsultarTestigoAPH`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarTestigoAPH`(
  $idReporteAph INT
)
BEGIN
SELECT TES.nombreTestigo, TES.identificacionTestigo FROM tbl_testigo TES
INNER JOIN tbl_reporteaph RA
ON RA.idReporteAPH = TES.idReporteAPH
WHERE RA.idReporteAPH = $idReporteAph;
END$$

DROP PROCEDURE IF EXISTS `spConsultarTipoafiliacion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarTipoafiliacion`(IN $idTipoAfiliacion INT)
BEGIN
    SELECT * FROM `tbl_tipoafiliacion` WHERE `idTipoAfiliacion` = $idTipoAfiliacion;
    END$$

DROP PROCEDURE IF EXISTS `spConsultarTipoAmbulancia`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarTipoAmbulancia`(IN _idAmbulancia int)
BEGIN
  SELECT tipoAmbulancia
  FROM tbl_ambulancia
  WHERE idAmbulancia = _idAmbulancia;
END$$

DROP PROCEDURE IF EXISTS `spConsultarTipoantecedente`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarTipoantecedente`(IN $idTipoAntecedente INT)
BEGIN
    SELECT * FROM `tbl_tipoantecedente` WHERE `idTipoAntecedente` = $idTipoAntecedente;
    END$$

DROP PROCEDURE IF EXISTS `spConsultarTipoaseguramiento`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarTipoaseguramiento`(IN $idTipoAseguramiento INT)
BEGIN
    SELECT * FROM `tbl_tipoaseguramiento` WHERE `idTipoAseguramiento` = $idTipoAseguramiento;
    END$$

DROP PROCEDURE IF EXISTS `spConsultarTipoasignacion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarTipoasignacion`(IN $idTipoAsignacion INT)
BEGIN
    SELECT * FROM `tbl_tipoasignacion` WHERE `idTipoAsignacion` = $idTipoAsignacion;
    END$$

DROP PROCEDURE IF EXISTS `spConsultarTipocup`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarTipocup`(IN $idTipoCup INT)
BEGIN
    SELECT * FROM `tbl_tipocup` WHERE `idTipoCup` = $idTipoCup;
    END$$

DROP PROCEDURE IF EXISTS `spConsultarTipodevolucion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarTipodevolucion`(IN $idTipoDevolucion INT)
BEGIN
    SELECT * FROM `tbl_tipodevolucion` WHERE `idTipoDevolucion` = $idTipoDevolucion;
    END$$

DROP PROCEDURE IF EXISTS `spConsultarTipodocumento`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarTipodocumento`(IN $idTipoDocumento INT)
BEGIN
    SELECT * FROM `tbl_tipodocumento` WHERE `idTipoDocumento` = $idTipoDocumento;
    END$$

DROP PROCEDURE IF EXISTS `spConsultarTipoevento`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarTipoevento`(IN $idTipoEvento INT)
BEGIN
    SELECT * FROM `tbl_tipoevento` WHERE `idTipoEvento` = $idTipoEvento;
    END$$

DROP PROCEDURE IF EXISTS `spConsultarTipoevento_novedadreporteinicial`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarTipoevento_novedadreporteinicial`(IN $idTipoEventoNovedadReporteInicial INT)
BEGIN
    SELECT * FROM `tbl_tipoevento_novedadreporteinicial` WHERE `idTipoEventoNovedadReporteInicial` = $idTipoEventoNovedadReporteInicial;
    END$$

DROP PROCEDURE IF EXISTS `spConsultarTipoevento_reporteinicial`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarTipoevento_reporteinicial`(IN idReporteInicial INT)
BEGIN
  SELECT tpe.descripcionTipoEvento
  FROM tbl_tipoevento_reporteinicial ttr
  INNER JOIN tbl_tipoevento tpe
  ON ttr.idTipoEvento = tpe.idTipoEvento
  WHERE ttr.idReporteInicial = idReporteInicial;
END$$

DROP PROCEDURE IF EXISTS `spConsultarTipoexamenespecializado`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarTipoexamenespecializado`(IN $idTipoExamenEspecializado INT)
BEGIN
    SELECT * FROM `tbl_tipoexamenespecializado` WHERE `idTipoExamenEspecializado` = $idTipoExamenEspecializado;
    END$$

DROP PROCEDURE IF EXISTS `spConsultarTipoexamenfisico`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarTipoexamenfisico`(IN $idtipoExamenFisico INT)
BEGIN
    SELECT * FROM `tbl_tipoexamenfisico` WHERE `idtipoExamenFisico` = $idtipoExamenFisico;
    END$$

DROP PROCEDURE IF EXISTS `spConsultarTipokit`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarTipokit`(IN $idTipoKit INT)
BEGIN
    SELECT * FROM `tbl_tipokit` WHERE `idTipoKit` = $idTipoKit;
    END$$

DROP PROCEDURE IF EXISTS `spConsultarTiponovedad`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarTiponovedad`(IN $idTipoNovedad INT)
BEGIN
    SELECT * FROM `tbl_tiponovedad` WHERE `idTipoNovedad` = $idTipoNovedad;
    END$$

DROP PROCEDURE IF EXISTS `spConsultarTipoorigenatencion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarTipoorigenatencion`(IN $idTipoOrigenAtencion INT)
BEGIN
    SELECT * FROM `tbl_tipoorigenatencion` WHERE `idTipoOrigenAtencion` = $idTipoOrigenAtencion;
    END$$

DROP PROCEDURE IF EXISTS `spConsultarTipotratamiento`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarTipotratamiento`(IN $idTipoTratamiento INT)
BEGIN
    SELECT * FROM `tbl_tipotratamiento` WHERE `idTipoTratamiento` = $idTipoTratamiento;
    END$$

DROP PROCEDURE IF EXISTS `spConsultarTipozona`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarTipozona`(IN $idTipoZona INT)
BEGIN
    SELECT * FROM `tbl_tipozona` WHERE `idTipoZona` = $idTipoZona;
    END$$

DROP PROCEDURE IF EXISTS `spConsultarTratamientoaph`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarTratamientoaph`(IN $idtratamiento INT)
BEGIN
    SELECT * FROM `tbl_tratamientoaph` WHERE `idtratamiento` = $idtratamiento;
    END$$

DROP PROCEDURE IF EXISTS `spConsultarTratamientodmc`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarTratamientodmc`(IN $idTratamiento INT)
BEGIN
    SELECT * FROM `tbl_tratamientodmc` WHERE `idTratamiento` = $idTratamiento;
    END$$

DROP PROCEDURE IF EXISTS `spConsultarTratamientodmcrecurso`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarTratamientodmcrecurso`(IN $TratamientoDmcRecurso INT)
BEGIN
    SELECT * FROM `tbl_tratamientodmcrecurso` WHERE `TratamientoDmcRecurso` = $TratamientoDmcRecurso;
    END$$

DROP PROCEDURE IF EXISTS `spConsultarTratamientosAPH`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarTratamientosAPH`(
  $idReporteAph INT
)
BEGIN
SELECT  TTA.idTipoTratamiento, TTA.Descripcion, TTA.categoriaTratamientoAph,
TTA.categoriaItemTratamiento, TA.valor
FROM tbl_reporteaph RA
INNER JOIN tbl_tratamientoaph TA
ON TA.idReporteAPH = RA.idReporteAPH
INNER JOIN tbl_tipotratamiento TTA
ON TA.idTipoTratamiento = TTA.idTipoTratamiento
WHERE RA.idReporteAph = $idReporteAph;
END$$

DROP PROCEDURE IF EXISTS `spConsultarTriage`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarTriage`(IN $idTriage INT)
BEGIN
    SELECT * FROM `tbl_triage` WHERE `idTriage` = $idTriage;
    END$$

DROP PROCEDURE IF EXISTS `spConsultarTurno`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarTurno`(IN $idTurno INT)
BEGIN
    SELECT * FROM `tbl_turno` WHERE `idTurno` = $idTurno;
    END$$

DROP PROCEDURE IF EXISTS `spConsultarTurnoActivo`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarTurnoActivo`(IN $idPersona INT)
BEGIN
  SELECT P.idPersona,T.idTurno,tp.idTurnoProgramacion, Es.idrol,P.primerNombre, E.descripcionRol,P.primerApellido,P.segundoApellido ,max(T.horaInicioTurno) as 'Horainicial',max(T.horaFinalTurno) as'Horafinal',max(PR.Fecha_inicial) as 'Fechainicial',max(PR.Fecha_final) as 'Fechafinal',TP.estadoTablaProgramacion FROM tbl_persona P inner join tbl_cuentausuario Es on p.idPersona = Es.idPersona inner join tbl_rol E on ES.idRol = E.idRol inner join tbl_turnoprogramacion TP on P.idPersona = TP.idPersona inner JOIN tbl_turno T on TP.idTurno = T.idTurno inner join tbl_programacion PR on TP.idProgramacion = PR.idProgramacion where P.idPersona = $idPersona and TP.estadoTablaProgramacion = 'Activo' LIMIT 1;
END$$

DROP PROCEDURE IF EXISTS `spConsultarTurnoprogramacion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarTurnoprogramacion`(IN $idTurnoProgramacion INT)
BEGIN
    SELECT * FROM `tbl_turnoprogramacion` WHERE `idTurnoProgramacion` = $idTurnoProgramacion;
    END$$

DROP PROCEDURE IF EXISTS `spConsultarTurnosHP`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarTurnosHP`(IN $fecha date, $idPersona INT)
BEGIN
  select distinct t.horaInicioTurno, t.horaFinalTurno
  from tbl_turnoprogramacion tp
  inner join tbl_turno t
  on tp.idTurno = t.idTurno
  inner join tbl_programacion p
  on tp.idProgramacion = p.idProgramacion
  where tp.idPersona=$idPersona and date_format(p.Fecha_final,'%m-%Y')= date_format($fecha,'%m-%Y') and (tp.estadoTablaProgramacion = 'Activo' or tp.estadoTablaProgramacion = 'Terminado');
END$$

DROP PROCEDURE IF EXISTS `spConsultarTurnosP`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarTurnosP`(IN $idPersona INT)
BEGIN
  select distinct t.horaInicioTurno, t.horaFinalTurno
  from tbl_turnoprogramacion tp
  inner join tbl_turno t
  on tp.idTurno = t.idTurno
  where tp.estadoTablaProgramacion = 'Activo' and tp.idPersona = $idPersona;
END$$

DROP PROCEDURE IF EXISTS `spConsultarUsuario`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarUsuario`()
BEGIN
  SELECT idRol as Rol FROM tbl_rol WHERE descripcionRol = UPPER('Usuario');
END$$

DROP PROCEDURE IF EXISTS `spConsultarUsuarioExterno`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarUsuarioExterno`(IN $idUsuario INT)
BEGIN
  SELECT cu.idPersona, p.urlFoto,
  CONCAT(p.primerNombre, ' ', p.primerApellido) 'nombre',
  p.correoElectronico,
  p.direccion,
  p.telefono,
  (SELECT COUNT(idChat)
  FROM tbl_chat
  WHERE idUsuarioExterno = cu.idUsuario) 'reportesRealizados',
  (SELECT COUNT(c.idChat)
  FROM tbl_chat c
  INNER JOIN tbl_reporteinicial ri
  ON ri.idChat = c.idChat
  WHERE c.idUsuarioExterno = cu.idUsuario AND ri.estadoTablaReporteInicial LIKE 'finalizado') 'reportesFinalizados',
  (SELECT COUNT(c.idChat)
  FROM tbl_chat c
  INNER JOIN tbl_reporteinicial ri
  ON ri.idChat = c.idChat
  WHERE c.idUsuarioExterno = cu.idUsuario AND ri.estadoTablaReporteInicial LIKE 'cancelado') 'reportesCancelados'
  FROM tbl_persona p
  INNER JOIN tbl_cuentausuario cu
  ON cu.idPersona = p.idPersona
  WHERE cu.idUsuario = $idUsuario;
END$$

DROP PROCEDURE IF EXISTS `spConsultarValoracion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarValoracion`(IN $idValoracion INT)
BEGIN
    SELECT * FROM `tbl_valoracion` WHERE `idValoracion` = $idValoracion;
    END$$

DROP PROCEDURE IF EXISTS `spConsultarViaComunicacionAPH`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarViaComunicacionAPH`(
  $idReporteAph INT
)
BEGIN
SELECT VC.idViaComunicacionControlMedico, VC.viaComunicacion
FROM tbl_viacomunicacioncontrolmedico VC
INNER JOIN tbl_reporteaph RA
ON RA.idReporteAPH = VC.idReporteAPH
WHERE RA.idReporteAPH = $idReporteAph;
END$$

DROP PROCEDURE IF EXISTS `spConsultarViacomunicacioncontrolmedico`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarViacomunicacioncontrolmedico`(IN $idViaComunicacionControlMedico INT)
BEGIN
    SELECT * FROM `tbl_viacomunicacioncontrolmedico` WHERE `idViaComunicacionControlMedico` = $idViaComunicacionControlMedico;
    END$$

DROP PROCEDURE IF EXISTS `spConsultarVista`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarVista`(IN $idVista INT)
BEGIN
    SELECT * FROM `tbl_vista` WHERE `idVista` = $idVista;
    END$$

DROP PROCEDURE IF EXISTS `spConsultarZona`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarZona`(IN $idTipoZ INT)
BEGIN
  SELECT idZona, descripcionZona
  FROM tbl_zona
  WHERE idTipoZona = $idTipoZ AND estadoTabla LIKE 'Activo';
END$$

DROP PROCEDURE IF EXISTS `spContarCodigoCUPcita`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spContarCodigoCUPcita`(IN $filtro varchar(45))
BEGIN
  select count(tbl_cup.idCUP) as cont
  from tbl_cup
  where tbl_cup.codigoCup LIKE CONCAT('%',CONCAT($filtro, '%')) and tbl_cup.idTipoCup=(SELECT tbl_tipocup.idTipoCup
  FROM tbl_tipocup
  WHERE tbl_tipocup.descripcionCUP LIKE 'Citas');
END$$

DROP PROCEDURE IF EXISTS `spContarCodigoDiagnostico`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spContarCodigoDiagnostico`(IN filtro VARCHAR(45))
begin
  select count(idCIE10) as cont from tbl_cie10 where codigoCIE10 LIKE concat('%',filtro,'%');
end$$

DROP PROCEDURE IF EXISTS `spContarCodigoProcedimiento`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spContarCodigoProcedimiento`(IN filtro VARCHAR(45))
begin
  select count(idCup) as cont from tbl_cup where codigoCup LIKE concat('%',filtro,'%');
end$$

DROP PROCEDURE IF EXISTS `spContarCodProcedimi`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spContarCodProcedimi`(IN `$filtro` VARCHAR(1000))
BEGIN
 select count(idCup) ascont from tbl_cup where codigoCup LIKE CONCAT('%',CONCAT($filtro, '%'));
END$$

DROP PROCEDURE IF EXISTS `spContarDescripcionCUPcita`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spContarDescripcionCUPcita`(IN $filtro varchar(1000))
BEGIN
  select count(tbl_cup.idCUP) as cont
  from tbl_cup
  where tbl_cup.nombreCUP LIKE CONCAT('%',CONCAT($filtro, '%')) and tbl_cup.idTipoCup=(SELECT tbl_tipocup.idTipoCup
  FROM tbl_tipocup
  WHERE tbl_tipocup.descripcionCUP LIKE 'Citas');
END$$

DROP PROCEDURE IF EXISTS `spContarDescripcionProcedimiento`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spContarDescripcionProcedimiento`(IN filtro VARCHAR(1000))
begin
  select count(idCup) as cont from tbl_cup where nombreCup LIKE concat('%',filtro,'%');
end$$

DROP PROCEDURE IF EXISTS `spContarDescripProce`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spContarDescripProce`(IN `$filtro` VARCHAR(1000))
BEGIN
 select count(idCup) ascont from tbl_cup where nombreCup LIKE CONCAT('%',CONCAT($filtro, '%'));
END$$

DROP PROCEDURE IF EXISTS `spContarDiagnostico`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spContarDiagnostico`(IN filtro VARCHAR(1000))
begin
  select count(idCIE10) as cont from tbl_cie10 where descripcionCIE10 LIKE concat('%',filtro,'%');
end$$

DROP PROCEDURE IF EXISTS `SpContarNotificacionesDespacho`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SpContarNotificacionesDespacho`($idDespacho int)
BEGIN
  SELECT COUNT(idAmbulancia) 'Numero'
  FROM tbl_despacho
  WHERE   idDespacho = $idDespacho;
END$$

DROP PROCEDURE IF EXISTS `spCosnultarAsignacionAmbulancia`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spCosnultarAsignacionAmbulancia`(in _idAmbulancia int)
BEGIN
SELECT tba.idAmbulancia, tba.tipoAmbulancia,tbla.latitud, tbla.longitud,tblda.idPersona,concat(tblp.primerNombre,' ',tblp.primerApellido) as 'Nombre_Completo', tble.descripcionEspecialidad
  FROM tbl_ambulancia AS tba
  INNER JOIN tbl_asignacionpersonal AS tbla
  ON tba.idAmbulancia = tbla.idAmbulancia
  INNER JOIN tbl_detalleasignacion AS tblda
  ON tbla.idAsignacionPersonal = tblda.idAsignacionPersonal
  INNER JOIN tbl_persona AS tblp
  ON tblda.idPersona = tblp.idPersona
  INNER JOIN tbl_personaespecialidad AS tblpe
  ON tblp.idPersona = tblpe.idPersona
  INNER JOIN tbl_especialidad AS tble
  ON tblpe.idEspecialidad = tble.idEspecialidad
  WHERE tba.idAmbulancia = _idAmbulancia;
END$$

DROP PROCEDURE IF EXISTS `SpDescripcionNotificacionesDespacho`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SpDescripcionNotificacionesDespacho`($idDespacho int)
BEGIN
  SELECT GROUP_CONCAT(tte.idTipoEvento)idTipoEvento, GROUP_CONCAT(tte.descripcionTipoEvento)descripciontipoevento, td.idAmbulancia,tri.idReporteInicial,informacionInicial,fechaHoraAproximadaEmergencia,fechaHoraEnvioReporteInicial, ubicacionIncidente,puntoReferencia,numeroLesionados
  FROM tbl_despacho td
  INNER JOIN tbl_reporteinicial tri
  ON td.idReporteInicial = tri.idReporteInicial
  INNER JOIN tbl_tipoevento_reporteinicial tdte
  ON td.idReporteInicial = tdte.idReporteInicial
  INNER JOIN tbl_tipoevento tte
  ON tdte.idTipoEvento = tte.idTipoEvento
  WHERE td.idDespacho = $idDespacho
  GROUP BY tri.idReporteInicial;
END$$

DROP PROCEDURE IF EXISTS `spDetalleKit`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spDetalleKit`()
BEGIN
  SELECT max(tbl_asignacionkit.idAsignacion) as idAsignacion
  FROM tbl_asignacionkit;
END$$

DROP PROCEDURE IF EXISTS `spEliminarTipoEventoConfirmacion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spEliminarTipoEventoConfirmacion`($idReporteInicial INT)
BEGIN
  DELETE FROM `tbl_tipoevento_reporteinicial`
  WHERE idReporteInicial = $idReporteInicial;
END$$

DROP PROCEDURE IF EXISTS `spEstadoPaciCIta`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spEstadoPaciCIta`(IN `$idPaciente` INT)
BEGIN
  UPDATE tbl_paciente SET idEstadoPaciente = (SELECT idEstadoPaciente FROM tbl_estadopaciente WHERE descripcionEstadoPaciente LIKE '%Mora%') WHERE idPaciente = $idPaciente;
END$$

DROP PROCEDURE IF EXISTS `spFilterPagination`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spFilterPagination`(IN `$filter` VARCHAR(100), IN `$numData` INT)
BEGIN
  DECLARE _i INT DEFAULT 1;
  while _i <= $numData do
      INSERT INTO tbl_filtro VALUES( SPLIT_STRING($filter, ',', _i) );
      SET _i = _i + 1;
  END while;
END$$

DROP PROCEDURE IF EXISTS `spFiltrarPuntosLesiones`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spFiltrarPuntosLesiones`(IN `$idReporteAPH` INT)
BEGIN
  SELECT *
  FROM `tbl_puntolesion`
  WHERE `idReporteAPH` = $idReporteAPH;
END$$

DROP PROCEDURE IF EXISTS `spFinalizacionMulta`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spFinalizacionMulta`()
BEGIN
  UPDATE tbl_paciente
  INNER JOIN tbl_cita
  ON tbl_paciente.idPaciente=tbl_cita.idPaciente
  INNER JOIN tbl_historialmora
  ON tbl_cita.idCita=tbl_historialmora.idCita
  INNER JOIN tbl_multa
  ON tbl_historialmora.idMulta=tbl_multa.idMulta
  SET tbl_paciente.idEstadoPaciente=(SELECT tbl_estadopaciente.idEstadoPaciente FROM tbl_estadopaciente WHERE tbl_estadopaciente.descripcionEstadoPaciente LIKE 'Activo')
  WHERE ADDDATE(tbl_historialmora.fechaHistorial, INTERVAL tbl_multa.diasMulta DAY)=CURDATE();
END$$

DROP PROCEDURE IF EXISTS `spHistorialCitas`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spHistorialCitas`()
BEGIN
  SELECT ci.idCita,pa.numeroDocumento, CONCAT(pa.primerNombre," ",pa.primerApellido) as NombrePaciente,
  cu.nombreCUP, cu.codigoCup, ci.fechaCita, ci.horaInicial, ci.direccionCita, ci.estadoTablaCita
  FROM tbl_cita ci
  INNER JOIN tbl_paciente pa ON ci.idPaciente =pa.idPaciente
  INNER JOIN tbl_tipodocumento td ON pa.idTipoDocumento = td.idtipoDocumento
  INNER JOIN tbl_cup cu ON ci.idCUP = cu.idCUP;
END$$

DROP PROCEDURE IF EXISTS `spIdPersona`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spIdPersona`(IN $idPersona INT(11))
BEGIN
  SELECT tbl_turnoprogramacion.idPersona
  FROM tbl_turnoprogramacion
  WHERE tbl_turnoprogramacion.idTurnoProgramacion=$idPersona;
END$$

DROP PROCEDURE IF EXISTS `spInfoReporteDespacho`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spInfoReporteDespacho`( IN _idDespacho int)
BEGIN
 	 SELECT d.idDespacho, d.idReporteInicial, a.placaAmbulancia, d.fechaHoraDespacho, d.estadoDespacho, r.ubicacionIncidente, r.puntoReferencia, r.fechaHoraAproximadaEmergencia,r.fechaHoraEnvioReporteInicial, r.informacionInicial, nr.descripcionNovedad, p.primerNombre, p.primerApellido, rl.descripcionRol, nr.numeroLesionadosNovedad, r.numeroLesionados, concat(p.primerNombre,' ',p.primerApellido,' ',rl.descripcionRol) as 'despachador', da.CargoPersona
  FROM tbl_ambulancia a
  INNER JOIN tbl_despacho d
  ON d.idAmbulancia = a.idAmbulancia
  INNER JOIN tbl_asignacionpersonal ap
  ON a.idAmbulancia = ap.idambulancia
  INNER JOIN tbl_detalleasignacion da
  ON ap.idAsignacionPersonal = da.idAsignacionPersonal
  INNER JOIN tbl_persona p
  ON da.idPersona = p.idPersona
  INNER JOIN tbl_cuentausuario cu
  ON p.idPersona = cu.idPersona
  INNER JOIN tbl_rol rl
  ON cu.idRol = rl.idRol
  INNER JOIN tbl_reporteinicial r
  ON d.idReporteInicial = r.idReporteInicial
  INNER JOIN tbl_novedadreporteinicial nr
  ON r.idReporteInicial = nr.idReporteInicial
  WHERE d.idDespacho = _idDespacho
  GROUP BY ap.idAsignacionPersonal;
END$$

DROP PROCEDURE IF EXISTS `spJoinLesionesCie10`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spJoinLesionesCie10`(IN `$idPuntoLesion` INT)
BEGIN
  SELECT L.idLesion , L.idPuntoLesion, L.especificacionLesion, C.idCIE10, C.codigoCIE10, C.descripcionCIE10
  FROM `tbl_lesion` AS L
  INNER JOIN `tbl_cie10` AS C
  ON L.`idCIE10` = C.`idCIE10`
  WHERE  L.idPuntoLesion = $idPuntoLesion;
END$$

DROP PROCEDURE IF EXISTS `splistaCompletaRecursoEstandar`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `splistaCompletaRecursoEstandar`()
BEGIN
  SELECT ek.idEstandarKit, rs.nombre, ek.stockminKit FROM tbl_estandarkit as ek
  inner join tbl_recurso as rs
  on rs.idrecurso = ek.idEstandarKit;
END$$

DROP PROCEDURE IF EXISTS `spListarAcompanante`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarAcompanante`()
BEGIN
    SELECT * FROM `tbl_acompanante`;
    END$$

DROP PROCEDURE IF EXISTS `spListarAfectadoaccidentetransito`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarAfectadoaccidentetransito`()
BEGIN
  SELECT *
  FROM `tbl_afectadoaccidentetransito`
  WHERE estadoTabla = "Activo";
END$$

DROP PROCEDURE IF EXISTS `spListarAmbulancia`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarAmbulancia`()
BEGIN
    SELECT * FROM `tbl_ambulancia`;
    END$$

DROP PROCEDURE IF EXISTS `spListarAmbulanciaDisponible`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarAmbulanciaDisponible`()
BEGIN
  SELECT * FROM tbl_ambulancia as am
  where am.estadoTabla like 'Activo';
END$$

DROP PROCEDURE IF EXISTS `spListarAntecedenteaph`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarAntecedenteaph`()
BEGIN
    SELECT * FROM `tbl_antecedenteaph`;
    END$$

DROP PROCEDURE IF EXISTS `spListarAntecedentedmc`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarAntecedentedmc`()
BEGIN
    SELECT * FROM `tbl_antecedentedmc`;
    END$$

DROP PROCEDURE IF EXISTS `spListarAsignacionkit`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarAsignacionkit`()
BEGIN
  SELECT
  tbl_tipoasignacion.descripcionTipoasignacion,
  tbl_asignacionKit.idAsignacion,
  tbl_asignacionkit.fechaHoraAsignacion,
  ifnull(tbl_ambulancia.placaAmbulancia,'No aplica') as 'placaAmbulancia',
  ifnull(pa.numeroDocumento,'No aplica') as 'numeroDpersona',
  ifnull(pe.numeroDocumento,'No aplica') as 'numeroDPaciente',
  tbl_asignacionkit.estadoTablaAsignacionKit
  FROM tbl_asignacionkit
  INNER JOIN tbl_tipoasignacion
  ON tbl_asignacionkit.idTipoAsignacion=tbl_tipoasignacion.idTipoAsignacion
  LEFT JOIN tbl_ambulancia
  ON tbl_asignacionkit.idAmbulancia=tbl_ambulancia.idAmbulancia
  LEFT JOIN tbl_persona pa
  ON tbl_asignacionkit.idPersona=pa.idPersona
  LEFT JOIN tbl_paciente pe
  ON tbl_asignacionkit.idPaciente=pe.idPaciente
  ORDER BY tbl_asignacionKit.idAsignacion DESC;
END$$

DROP PROCEDURE IF EXISTS `spListarAsignacionpersonal`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarAsignacionpersonal`()
BEGIN
    SELECT * FROM `tbl_asignacionpersonal`;
    END$$

DROP PROCEDURE IF EXISTS `spListarAutorizacion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarAutorizacion`()
BEGIN
    SELECT * FROM `tbl_autorizacion`;
    END$$

DROP PROCEDURE IF EXISTS `spListarCantidadRecurso`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarCantidadRecurso`(IN `$idRecursoKit` INT(11) )
BEGIN
select stockminKit from tbl_estandarkit
where
  idEstandarKit = $idRecursoKit;
END$$

DROP PROCEDURE IF EXISTS `spListarCategoriaautorizacion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarCategoriaautorizacion`()
BEGIN
    SELECT * FROM `tbl_categoriaautorizacion`;
    END$$

DROP PROCEDURE IF EXISTS `spListarCategoriarecurso`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarCategoriarecurso`()
BEGIN
    SELECT * FROM `tbl_categoriarecurso`;
    END$$

DROP PROCEDURE IF EXISTS `spListarCertificadoatencion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarCertificadoatencion`()
BEGIN
    SELECT * FROM `tbl_certificadoatencion`;
    END$$

DROP PROCEDURE IF EXISTS `spListarChat`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarChat`()
BEGIN
    SELECT * FROM `tbl_chat`;
    END$$

DROP PROCEDURE IF EXISTS `spListarCie10`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarCie10`()
BEGIN
    SELECT * FROM `tbl_cie10`;
    END$$

DROP PROCEDURE IF EXISTS `spListarCIE10Cuerpo`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarCIE10Cuerpo`()
BEGIN
   SELECT *
   FROM `tbl_cie10`
   WHERE estadoTabla = 'Activo';
END$$

DROP PROCEDURE IF EXISTS `spListarCita`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarCita`()
BEGIN
    SELECT * FROM `tbl_cita`;
    END$$

DROP PROCEDURE IF EXISTS `spListarCitaInnerJoin`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarCitaInnerJoin`()
BEGIN
  SELECT *
  FROM `tbl_cita`
  INNER JOIN `tbl_paciente`
  ON `tbl_cita`.`idPaciente` =`tbl_paciente`.`idPaciente`
  INNER JOIN `tbl_tipodocumento`
  ON `tbl_tipodocumento`.`idTipoDocumento` = `tbl_paciente`.`idtipoDocumento`;
END$$

DROP PROCEDURE IF EXISTS `spListarCita_programacion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarCita_programacion`()
BEGIN
    SELECT * FROM `tbl_cita_programacion`;
    END$$

DROP PROCEDURE IF EXISTS `spListarCiudad`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarCiudad`()
BEGIN
  SELECT tbl_ciudad.idCiudad, tbl_ciudad.nombreCiudad FROM tbl_ciudad;
END$$

DROP PROCEDURE IF EXISTS `splistarComboRecursokit`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `splistarComboRecursokit`()
BEGIN
  SELECT idrecurso, nombre FROM `tbl_recurso`;
END$$

DROP PROCEDURE IF EXISTS `spListarConfiguracion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarConfiguracion`()
BEGIN
    SELECT * FROM `tbl_configuracion`;
    END$$

DROP PROCEDURE IF EXISTS `spListarConfiguracionCup`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarConfiguracionCup`()
BEGIN
 SELECT * FROM `tbl_configuracion`
  where estadoTabla = 'Activo' ;
   END$$

DROP PROCEDURE IF EXISTS `spListarCuentausuario`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarCuentausuario`()
BEGIN
    SELECT * FROM `tbl_cuentausuario`;
    END$$

DROP PROCEDURE IF EXISTS `spListarCuidadoantarribo`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarCuidadoantarribo`()
BEGIN
    SELECT * FROM `tbl_cuidadoantarribo`;
    END$$

DROP PROCEDURE IF EXISTS `spListarCup`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarCup`()
BEGIN
    SELECT * FROM `tbl_cup`;
    END$$

DROP PROCEDURE IF EXISTS `spListarDepartamento`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarDepartamento`()
BEGIN
  SELECT tbl_departamento.idDepartamento, tbl_departamento.nombreDepartamento FROMtbl_departamento;
END$$

DROP PROCEDURE IF EXISTS `spListarDesfibrilacion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarDesfibrilacion`()
BEGIN
    SELECT * FROM `tbl_desfibrilacion`;
    END$$

DROP PROCEDURE IF EXISTS `spListarDespacho`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarDespacho`()
BEGIN
  SELECT d.idDespacho, d.idReporteInicial, a.placaAmbulancia, d.fechaHoraDespacho, d.estadoDespacho
  FROM tbl_despacho d
  INNER JOIN tbl_ambulancia a
  ON d.idAmbulancia = a.idAmbulancia;
END$$

DROP PROCEDURE IF EXISTS `spListarDetalleasignacion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarDetalleasignacion`()
BEGIN
    SELECT * FROM `tbl_detalleasignacion`;
    END$$

DROP PROCEDURE IF EXISTS `spListarDetallekit`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarDetallekit`()
BEGIN
    SELECT * FROM `tbl_detallekit`;
    END$$

DROP PROCEDURE IF EXISTS `spListarDetalletratamientodmcrecurso`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarDetalletratamientodmcrecurso`()
BEGIN
    SELECT * FROM `tbl_detalletratamientodmcrecurso`;
    END$$

DROP PROCEDURE IF EXISTS `spListarDevolucion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarDevolucion`(
IN _id INT
)
BEGIN
  SELECT *
  from tbl_devolucion d
  INNER JOIN tbl_persona p
  ON d.idPersona = p.idPersona
  INNER JOIN tbl_tipodevolucion td
  ON d.idTipoDevolucion = td.idTipoDevolucion
  INNER JOIN tbl_detallekit dk
  ON d.idDetallekit = dk.idDetallekit
  INNER JOIN tbl_asignacionkit ak
  ON dk.idAsignacion = ak.idAsignacion
  INNER JOIN tbl_recurso r
  ON dk.idrecurso = r.idrecurso
  WHERE dk.idAsignacion = _id;
END$$

DROP PROCEDURE IF EXISTS `spListarDiagnostico`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarDiagnostico`()
BEGIN
    SELECT * FROM `tbl_diagnostico`;
    END$$

DROP PROCEDURE IF EXISTS `spListarEnteexterno`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarEnteexterno`()
BEGIN
  SELECT *
  FROM tbl_enteexterno
  WHERE estadoTabla = 'Activo';
END$$

DROP PROCEDURE IF EXISTS `spListarEnteexterno_reporteinicial`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarEnteexterno_reporteinicial`()
BEGIN
    SELECT * FROM `tbl_enteexterno_reporteinicial`;
    END$$

DROP PROCEDURE IF EXISTS `spListarEquipobiomedico`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarEquipobiomedico`()
BEGIN
    SELECT * FROM `tbl_equipobiomedico`;
    END$$

DROP PROCEDURE IF EXISTS `spListarEquipoBiomedicoDmc`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarEquipoBiomedicoDmc`()
BEGIN
  SELECT idRecurso, nombre FROM tbl_recurso WHERE idCategoriaRecurso = '2'  AND estadoTablaRecurso = 'Activo';
END$$

DROP PROCEDURE IF EXISTS `spListarEspecialidad`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarEspecialidad`()
BEGIN
    SELECT * FROM `tbl_especialidad`;
    END$$

DROP PROCEDURE IF EXISTS `spListarEstadopaciente`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarEstadopaciente`()
BEGIN
    SELECT * FROM `tbl_estadopaciente`;
    END$$

DROP PROCEDURE IF EXISTS `spListarEstandarKit`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarEstandarKit`(
    IN $idTipoK INT
)
BEGIN
  SELECT *
  FROM `tbl_estandarkit`
  INNER JOIN `tbl_tipokit`
  ON `tbl_tipokit`.`idTipoKit` = `tbl_estandarkit`.`idTipoKit`
  INNER JOIN `tbl_recurso`
  ON `tbl_recurso`.`idrecurso` = `tbl_estandarkit`.`idRecurso`
  where `tbl_estandarKit`.`idTipokit` = $idTipoK;
END$$

DROP PROCEDURE IF EXISTS `spListarEvaluacionautorizacion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarEvaluacionautorizacion`()
BEGIN
    SELECT * FROM `tbl_evaluacionautorizacion`;
    END$$

DROP PROCEDURE IF EXISTS `spListarExamenespecializado`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarExamenespecializado`()
BEGIN
    SELECT * FROM `tbl_examenespecializado`;
    END$$

DROP PROCEDURE IF EXISTS `spListarExamenfisicoaph`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarExamenfisicoaph`()
BEGIN
    SELECT * FROM `tbl_examenfisicoaph`;
    END$$

DROP PROCEDURE IF EXISTS `spListarExamenfisicodmc`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarExamenfisicodmc`()
BEGIN
    SELECT * FROM `tbl_examenfisicodmc`;
    END$$

DROP PROCEDURE IF EXISTS `spListarFormulamedica`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarFormulamedica`()
BEGIN
    SELECT * FROM `tbl_formulamedica`;
    END$$

DROP PROCEDURE IF EXISTS `spListarFormulamedicamedicamentodmc`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarFormulamedicamedicamentodmc`()
BEGIN
    SELECT * FROM `tbl_formulamedicamedicamentodmc`;
    END$$

DROP PROCEDURE IF EXISTS `spListarHistoriaclinica`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarHistoriaclinica`()
BEGIN
    SELECT * FROM `tbl_historiaclinica`;
    END$$

DROP PROCEDURE IF EXISTS `spListarHistorialmora`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarHistorialmora`()
BEGIN
    SELECT * FROM `tbl_historialmora`;
    END$$

DROP PROCEDURE IF EXISTS `spListarIncapacidad`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarIncapacidad`()
BEGIN
    SELECT * FROM `tbl_incapacidad`;
    END$$

DROP PROCEDURE IF EXISTS `spListarInfomacionAutorizacion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarInfomacionAutorizacion`(IN $limite INT, IN $Estado VARCHAR(30))
BEGIN
  SELECT TA.*,P.primerNombre, P.primerApellido, P.segundoNombre,
  P.segundoApellido, T.Descripcion
  FROM tbltemporalautorizacion TA
  INNER JOIN tbl_cuentausuario C
  ON TA.idparamedico = C.idUsuario
  INNER JOIN tbl_persona P
  ON C.idPersona = P.idPersona
  INNER JOIN tbl_tipotratamiento T
  ON TA.idTipoTratamiento = T.idTipoTratamiento
  ORDER BY TA.fechaEnvio DESC;
END$$

DROP PROCEDURE IF EXISTS `spListarInformacionAutorizacion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarInformacionAutorizacion`(
  IN $limite INT,
  IN $Estado VARCHAR(30)
)
BEGIN
  IF $Estado = "Todas" THEN
    SELECT TA.*,P.primerNombre, P.primerApellido, P.segundoNombre, P.segundoApellido, T.Descripcion
    FROM tbltemporalautorizacion TA
    INNER JOIN tbl_cuentausuario C
    ON TA.idparamedico = C.idUsuario
    INNER JOIN tbl_persona P
    ON C.idPersona = P.idPersona
    INNER JOIN tbl_tipotratamiento T
    ON TA.idTipoTratamiento = T.idTipoTratamiento
    ORDER BY TA.fechaEnvio DESC
    LIMIT $limite , 10;
  ELSE
    SELECT TA.*,P.primerNombre, P.primerApellido, P.segundoNombre, P.segundoApellido, T.Descripcion
    FROM tbltemporalautorizacion TA
    INNER JOIN tbl_cuentausuario C
    ON TA.idparamedico = C.idUsuario
    INNER JOIN tbl_persona P
    ON C.idPersona = P.idPersona
    INNER JOIN tbl_tipotratamiento T
    ON TA.idTipoTratamiento = T.idTipoTratamiento
    WHERE TA.estadoEvaluacion = $Estado
    ORDER BY TA.fechaEnvio DESC
    LIMIT $limite, 10;
  END IF;
END$$

DROP PROCEDURE IF EXISTS `spListarInformacionAutorizacionPaginador`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarInformacionAutorizacionPaginador`(IN $Estado VARCHAR(30))
BEGIN
  IF $Estado = "Todas" THEN
    SELECT TA.idTemporalAutorizacion
    FROM tbltemporalautorizacion TA;
  ELSE
    SELECT TA.idTemporalAutorizacion
    FROM tbltemporalautorizacion TA
    WHERE TA.estadoEvaluacion = $Estado;
  END IF;
END$$

DROP PROCEDURE IF EXISTS `spListarInterconsulta`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarInterconsulta`()
BEGIN
    SELECT * FROM `tbl_interconsulta`;
    END$$

DROP PROCEDURE IF EXISTS `spListarLesion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarLesion`()
BEGIN
    SELECT * FROM `tbl_lesion`;
    END$$

DROP PROCEDURE IF EXISTS `spListarLlamada`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarLlamada`()
BEGIN
    SELECT * FROM `tbl_llamada`;
    END$$

DROP PROCEDURE IF EXISTS `spListarMedicacion`$$
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

DROP PROCEDURE IF EXISTS `spListarMedicamento`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarMedicamento`()
BEGIN
    SELECT * FROM `tbl_medicamento`;
    END$$

DROP PROCEDURE IF EXISTS `spListarMedicamentoAmbulancia`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarMedicamentoAmbulancia`(in $idAmbulancia int)
BEGIN
  select dk.idDetalleKit,r.nombre,dk.cantidadAsignada,r.descripcion
  from tbl_detallekit dk
  inner join tbl_recurso r
  on dk.idRecurso=r.idRecurso
  inner join tbl_asignacionkit ak
  on dk.idAsignacion = ak.idAsignacion where ak.idAmbulancia = $idAmbulancia;
END$$

DROP PROCEDURE IF EXISTS `spListarMedicamentoDmc`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarMedicamentoDmc`()
begin
  select idRecurso, nombre from tbl_recurso where idCategoriaRecurso = '3' and estadoTablaRecurso = 'Activo';
end$$

DROP PROCEDURE IF EXISTS `spListarMedico`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarMedico`()
BEGIN
 SELECT *
 FROM tbl_persona p
 inner join tbl_cuentausuario cu
 on p.idPersona = CU.idPersona
 INNER JOIN tbl_rol re
 on re.idRol = cu.idRol
 where re.descripcionRol = 'Medico';
END$$

DROP PROCEDURE IF EXISTS `spListarMensaje`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarMensaje`()
BEGIN
    SELECT * FROM `tbl_mensaje`;
    END$$

DROP PROCEDURE IF EXISTS `spListarModulo`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarModulo`()
BEGIN
    SELECT * FROM `tbl_modulo`;
    END$$

DROP PROCEDURE IF EXISTS `spListarMotivoconsulta`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarMotivoconsulta`()
BEGIN
  SELECT *
  FROM `tbl_motivoconsulta`
  WHERE LOWER(TipoMotivoConsulta) <> LOWER("otro");
END$$

DROP PROCEDURE IF EXISTS `spListarMulta`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarMulta`()
BEGIN
    SELECT * FROM `tbl_multa`;
    END$$

DROP PROCEDURE IF EXISTS `spListarNotaenfermeria`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarNotaenfermeria`()
BEGIN
    SELECT * FROM `tbl_notaenfermeria`;
    END$$

DROP PROCEDURE IF EXISTS `spListarNovedadrecurso`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarNovedadrecurso`()
BEGIN
  SELECT *
  FROM `tbl_novedadrecurso`
  INNER JOIN `tbl_tiponovedad`
  ON `tbl_tiponovedad`.`idTipoNovedad`=`tbl_novedadrecurso`.`idTipoNovedad`
  INNER JOIN `tbl_persona`
  ON`tbl_persona`.`idPersona`=`tbl_novedadrecurso`.`idPersona`
  INNER JOIN `tbl_detallekit`
  ON `tbl_detallekit`.`idDetallekit` = `tbl_novedadrecurso`.`idDetallekit`
  INNER JOIN `tbl_recurso`
  on `tbl_detallekit`.`idrecurso` = `tbl_recurso`.`idrecurso`;
END$$

DROP PROCEDURE IF EXISTS `spListarNovedadReporte`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarNovedadReporte`()
BEGIN
SELECT tblni.idReporteInicial, tblni.descripcionNovedad, tblni.numeroLesionadosNovedad, tblri.ubicacionIncidente, tblni.idNovedad
FROM tbl_novedadreporteinicial AS tblni
INNER JOIN tbl_reporteinicial AS tblri
ON tblni.idReporteInicial = tblri.idReporteInicial
WHERE tblni.estadoNovedad = 'Activo';
END$$

DROP PROCEDURE IF EXISTS `spListarNovedadreporteinicial`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarNovedadreporteinicial`()
BEGIN
    SELECT * FROM `tbl_novedadreporteinicial`;
    END$$

DROP PROCEDURE IF EXISTS `spListarNovedadreporteinicial_enteexterno`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarNovedadreporteinicial_enteexterno`()
BEGIN
    SELECT * FROM `tbl_novedadreporteinicial_enteexterno`;
    END$$

DROP PROCEDURE IF EXISTS `spListarObservacion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarObservacion`()
BEGIN
    SELECT * FROM `tbl_observacion`;
    END$$

DROP PROCEDURE IF EXISTS `spListarOtrodmc`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarOtrodmc`()
BEGIN
    SELECT * FROM `tbl_otrodmc`;
    END$$

DROP PROCEDURE IF EXISTS `spListarPaciente`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarPaciente`()
BEGIN
    SELECT * FROM `tbl_paciente`;
    END$$

DROP PROCEDURE IF EXISTS `spListarPacienteInnerJ`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarPacienteInnerJ`()
BEGIN
  SELECT *
  FROM `tbl_paciente`
  INNER JOIN `tbl_tipodocumento`
  ON `tbl_paciente`.`idtipoDocumento` = `tbl_tipodocumento`.`idTipoDocumento`;
END$$

DROP PROCEDURE IF EXISTS `spListarPersona`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarPersona`()
BEGIN
SELECT * FROM tbl_persona as pn
where pn.estadoTablaPersona like 'Activo';
END$$

DROP PROCEDURE IF EXISTS `spListarPersonaespecialidad`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarPersonaespecialidad`()
BEGIN
    SELECT * FROM `tbl_personaespecialidad`;
    END$$

DROP PROCEDURE IF EXISTS `spListarPersonalAmbulancia`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarPersonalAmbulancia`()
BEGIN
  SELECT tblp.idPersona, tblp.primerNombre, tblp.primerApellido, tblr.descripcionRol
  FROM tbl_persona tblp
  INNER JOIN tbl_cuentausuario tblcu
  ON tblp.idPersona = tblcu.idPersona
  INNER JOIN tbl_rol tblr
  ON tblcu.idRol = tblr.idRol
  WHERE (tblp.dependencia = 'APH' AND tblp.estadoTablaPersona = 'Asignado ambulancia') AND (LOWER(tblr.descripcionRol) = LOWER('Médico') OR LOWER(tblr.descripcionRol) = LOWER('Medico') OR LOWER(tblr.descripcionRol) = LOWER('Paramédico') OR LOWER(tblr.descripcionRol) = LOWER('Paramedico'));
END$$

DROP PROCEDURE IF EXISTS `spListarPersonaProgramacion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarPersonaProgramacion`()
BEGIN
  SELECT p.idPersona, p.primerNombre ,  p.primerApellido, e.descripcionEspecialidad , e.idEspecialidad,es.idPersonaespecialidad
  FROM tbl_persona p
  INNER JOIN tbl_personaespecialidad es
  ON p.idPersona = es.idPersona
  INNER JOIN tbl_especialidad e
  ON es.idEspecialidad = e.idEspecialidad;
END$$

DROP PROCEDURE IF EXISTS `spListarPiel`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarPiel`()
BEGIN
    SELECT * FROM `tbl_piel`;
    END$$

DROP PROCEDURE IF EXISTS `spListarProcedimiento`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarProcedimiento`()
BEGIN
    SELECT * FROM `tbl_procedimiento`;
    END$$

DROP PROCEDURE IF EXISTS `spListarProgramacion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarProgramacion`()
BEGIN
    SELECT * FROM `tbl_programacion`;
    END$$

DROP PROCEDURE IF EXISTS `spListarPuntolesion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarPuntolesion`()
BEGIN
    SELECT * FROM `tbl_puntolesion`;
    END$$

DROP PROCEDURE IF EXISTS `spListarRecurso`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarRecurso`()
BEGIN
  SELECT *
  FROM `tbl_recurso`
  INNER JOIN `tbl_categoriarecurso`
  ON `tbl_categoriarecurso`.`idCategoriaRecurso` = `tbl_recurso`.`idCategoriaRecurso`;
END$$

DROP PROCEDURE IF EXISTS `spListarRecursoKit`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarRecursoKit`()
BEGIN
  SELECT recursoKit, stockminKit FROM `tbl_estandarkit`;
END$$

DROP PROCEDURE IF EXISTS `spListarReporteaph`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarReporteaph`()
BEGIN
    SELECT * FROM `tbl_reporteaph`;
    END$$

DROP PROCEDURE IF EXISTS `spListarReporteaph_motivoconsulta`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarReporteaph_motivoconsulta`()
BEGIN
    SELECT * FROM `tbl_reporteaph_motivoconsulta`;
    END$$

DROP PROCEDURE IF EXISTS `spListarReporteinicial`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarReporteinicial`()
BEGIN
  SELECT *
  FROM tbl_reporteinicial
  WHERE estadoTablaReporteInicial = 'Activo';
END$$

DROP PROCEDURE IF EXISTS `spListarRestablecer`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarRestablecer`()
BEGIN
    SELECT * FROM `tbl_restablecer`;
    END$$

DROP PROCEDURE IF EXISTS `spListarRol`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarRol`()
BEGIN
  SELECT * FROM `tbl_rol` WHERE UPPER(descripcionRol) <> UPPER('USUARIO');
END$$

DROP PROCEDURE IF EXISTS `spListarRoles`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarRoles`()
BEGIN
  SELECT * FROM `tbl_rol`;
END$$

DROP PROCEDURE IF EXISTS `spListarRolmodulovista`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarRolmodulovista`()
BEGIN
    SELECT * FROM `tbl_rolmodulovista`;
    END$$

DROP PROCEDURE IF EXISTS `spListarSignosvitales`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarSignosvitales`()
BEGIN
    SELECT * FROM `tbl_signosvitales`;
    END$$

DROP PROCEDURE IF EXISTS `spListarSolicitud`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarSolicitud`()
BEGIN
    SELECT * FROM `tbl_solicitud`;
    END$$

DROP PROCEDURE IF EXISTS `spListartblDetallekit`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListartblDetallekit`( IN $idAsignacion INT )
BEGIN
  SELECT cantidadAsignada,nombre,cantidadFinal FROM tbl_detalleKit AS dk
  INNER JOIN tbl_recurso AS rc
  ON dk.idrecurso = rc.idrecurso
  WHERE idAsignacion = $idAsignacion;
END$$

DROP PROCEDURE IF EXISTS `spListarTemporalautorizacion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarTemporalautorizacion`(IN `$idConsulta` INT,
  IN `$tipoConsulta` VARCHAR(45),
  IN `$cedulaPaciente` VARCHAR(45))
BEGIN
IF $tipoConsulta = 'Temporal' THEN
SELECT TP.observacionRespuestaAutorizacion, TP.idTipoTratamiento, TP.estadoEvaluacion, TT.Descripcion, TP.cedulaPaciente, TP.fechaEnvio, TP.descripcionAutorizacion AS descripcionAutorizacion
FROM tbl_temporalautorizacion TP
INNER JOIN tbl_tipotratamiento TT ON TT.idTipoTratamiento = TP.idTipoTratamiento
WHERE TP.idParamedico =$idConsulta
AND cedulaPaciente =$cedulaPaciente;
ELSEIF $tipoConsulta = 'Reporte' THEN
  SELECT TP.observacionRespuestaAutorizacion,TP.idTipoTratamiento, TP.estadoEvaluacion,TT.Descripcion,TP.cedulaPaciente,TP.fechaEnvio, TP.descripcionAutorizacion AS descripcionAutorizacion
  FROM tbl_autorizacion TP
	INNER JOIN tbl_tipotratamiento TT
	ON TT.idTipoTratamiento = TP.idTipoTratamiento
  WHERE TP.idReporteAPH = $idConsulta AND cedulaPaciente = $cedulaPaciente;
END IF;
END$$

DROP PROCEDURE IF EXISTS `spListarTemporalautorizacionMedicamento`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarTemporalautorizacionMedicamento`(IN `$idConsulta` INT,
  IN `$tipoConsulta` VARCHAR(45),
  IN `$cedulaPaciente` VARCHAR(45))
BEGIN
IF $tipoConsulta = 'Temporal' THEN
     SELECT TP.observacionRespuestaAutorizacion,TP.idMedicamento, TP.estadoEvaluacion,TR.nombre,TP.cedulaPaciente,TP.fechaEnvio, TP.descripcionAutorizacion AS descripcionAutorizacion
  FROM tbl_temporalautorizacion TP
	INNER JOIN tbl_detallekit TD
	ON TD.idDetallekit = TP.idMedicamento
    INNER JOIN tbl_recurso TR
    ON TR.idrecurso = TD.idrecurso
  WHERE TP.idParamedico = $idConsulta AND cedulaPaciente = $cedulaPaciente
   ORDER BY TP.fechaEnvio DESC;
ELSEIF $tipoConsulta = 'Reporte' THEN
   SELECT TP.observacionRespuestaAutorizacion,TP.idMedicamento, TP.estadoEvaluacion,TR.nombre,TP.cedulaPaciente,TP.fechaEnvio, TP.descripcionAutorizacion AS descripcionAutorizacion
  FROM tbl_autorizacion TP
	INNER JOIN tbl_detallekit TD
	ON TD.idDetallekit = TP.idMedicamento
    INNER JOIN tbl_recurso TR
    ON TR.idrecurso = TD.idrecurso
 WHERE TP.idReporteAPH = $idConsulta AND cedulaPaciente = $cedulaPaciente
   ORDER BY TP.fechaEnvio DESC;
END IF;
END$$

DROP PROCEDURE IF EXISTS `spListarTestigo`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarTestigo`()
BEGIN
    SELECT * FROM `tbl_testigo`;
    END$$

DROP PROCEDURE IF EXISTS `spListarTipoafiliacion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarTipoafiliacion`()
BEGIN
    SELECT * FROM `tbl_tipoafiliacion`;
    END$$

DROP PROCEDURE IF EXISTS `spListarTipoantecedente`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarTipoantecedente`()
BEGIN
    SELECT * FROM `tbl_tipoantecedente`;
    END$$

DROP PROCEDURE IF EXISTS `spListarTipoaseguramiento`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarTipoaseguramiento`()
BEGIN
  SELECT *
  FROM `tbl_tipoaseguramiento`
  WHERE estadoTabla = "Activo";
END$$

DROP PROCEDURE IF EXISTS `spListarTipoasignacion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarTipoasignacion`()
BEGIN
    SELECT * FROM `tbl_tipoasignacion`;
    END$$

DROP PROCEDURE IF EXISTS `spListarTipocup`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarTipocup`()
BEGIN
    SELECT * FROM `tbl_tipocup`;
    END$$

DROP PROCEDURE IF EXISTS `spListarTipodevolucion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarTipodevolucion`()
BEGIN
    SELECT * FROM `tbl_tipodevolucion`;
    END$$

DROP PROCEDURE IF EXISTS `spListarTipodocumento`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarTipodocumento`()
BEGIN
  SELECT tbl_tipodocumento.idTipoDocumento, tbl_tipodocumento.descripcionTdocumento
  FROM tbl_tipodocumento
  WHERE estadoTabla LIKE 'Activo';
END$$

DROP PROCEDURE IF EXISTS `spListarTipoevento`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarTipoevento`()
BEGIN
  SELECT *
  FROM tbl_tipoevento
  WHERE estadoTabla = 'Activo';
END$$

DROP PROCEDURE IF EXISTS `spListarTipoevento_novedadreporteinicial`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarTipoevento_novedadreporteinicial`()
BEGIN
    SELECT * FROM `tbl_tipoevento_novedadreporteinicial`;
    END$$

DROP PROCEDURE IF EXISTS `spListarTipoevento_reporteinicial`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarTipoevento_reporteinicial`()
BEGIN
    SELECT * FROM `tbl_tipoevento_reporteinicial`;
    END$$

DROP PROCEDURE IF EXISTS `spListarTipoexamenespecializado`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarTipoexamenespecializado`()
BEGIN
    SELECT * FROM `tbl_tipoexamenespecializado` where estadoTabla = 'Activo';
END$$

DROP PROCEDURE IF EXISTS `spListarTipoexamenfisico`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarTipoexamenfisico`()
BEGIN
    SELECT * FROM `tbl_tipoexamenfisico`;
    END$$

DROP PROCEDURE IF EXISTS `spListarTipokit`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarTipokit`()
BEGIN
    SELECT * FROM `tbl_tipokit`;
    END$$

DROP PROCEDURE IF EXISTS `spListarTiponovedad`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarTiponovedad`()
BEGIN
    SELECT * FROM `tbl_tiponovedad`;
    END$$

DROP PROCEDURE IF EXISTS `spListarTipoorigenatencion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarTipoorigenatencion`()
BEGIN
  SELECT * FROM `tbl_tipoorigenatencion` where estadoTabla = 'Activo';
END$$

DROP PROCEDURE IF EXISTS `spListarTipotratamiento`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarTipotratamiento`()
BEGIN
  SELECT * FROM `tbl_tipotratamiento` where estadoTabla = 'Activo';
END$$

DROP PROCEDURE IF EXISTS `spListarTipozona`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarTipozona`()
BEGIN
  SELECT tbl_tipozona.idTipoZona, tbl_tipozona.descripcionTipozona
  FROM `tbl_tipozona`
  WHERE estadoTabla LIKE 'Activo';
END$$

DROP PROCEDURE IF EXISTS `spListarTratamientoA`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarTratamientoA`()
BEGIN
  SELECT idTipoTratamiento, Descripcion, categoriaItemTratamiento
  FROM tbl_tipotratamiento
  WHERE categoriaTratamientoAph = "Tratamiento Avanzado" and estadoTabla = "Activo";
END$$

DROP PROCEDURE IF EXISTS `spListarTratamientoaph`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarTratamientoaph`()
BEGIN
    SELECT * FROM `tbl_tratamientoaph`;
    END$$

DROP PROCEDURE IF EXISTS `spListarTratamientoB`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarTratamientoB`()
BEGIN
  SELECT idTipoTratamiento, Descripcion, categoriaItemTratamiento
  FROM tbl_tipotratamiento
  WHERE categoriaTratamientoAph = "Tratamiento Basico" and estadoTabla = "Activo";
END$$

DROP PROCEDURE IF EXISTS `spListarTratamientodmc`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarTratamientodmc`()
BEGIN
    SELECT * FROM `tbl_tratamientodmc`;
    END$$

DROP PROCEDURE IF EXISTS `spListarTratamientodmcrecurso`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarTratamientodmcrecurso`()
BEGIN
    SELECT * FROM `tbl_tratamientodmcrecurso`;
    END$$

DROP PROCEDURE IF EXISTS `spListarTriage`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarTriage`()
BEGIN
    SELECT * FROM `tbl_triage`;
    END$$

DROP PROCEDURE IF EXISTS `spListarTurno`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarTurno`()
BEGIN
    SELECT * FROM `tbl_turno`;
    END$$

DROP PROCEDURE IF EXISTS `spListarTurnoprogramacion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarTurnoprogramacion`()
BEGIN
    SELECT * FROM `tbl_turnoprogramacion`;
    END$$

DROP PROCEDURE IF EXISTS `spListarValoracion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarValoracion`()
BEGIN
    SELECT * FROM `tbl_valoracion`;
    END$$

DROP PROCEDURE IF EXISTS `spListarViacomunicacioncontrolmedico`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarViacomunicacioncontrolmedico`()
BEGIN
    SELECT * FROM `tbl_viacomunicacioncontrolmedico`;
    END$$

DROP PROCEDURE IF EXISTS `spListarVista`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarVista`()
BEGIN
    SELECT * FROM `tbl_vista`;
    END$$

DROP PROCEDURE IF EXISTS `spListarZona`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spListarZona`()
BEGIN
  SELECT idTipoZona, descripcionTipozona
  FROM `tbl_tipozona`
  WHERE estadoTabla LIKE 'Activo';
END$$

DROP PROCEDURE IF EXISTS `spModificarAcompanante`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarAcompanante`(IN `$idAcompanante` INT,
  IN `$lugarExpedicionDocumentoA` VARCHAR(45),
  IN `$parentescoA` VARCHAR(45),
  IN `$identificacionA` VARCHAR(45),
  IN `$nombreA` VARCHAR(45),
  IN `$telefonoA` VARCHAR(45),
  IN `$apellidoA` VARCHAR(45))
BEGIN
  UPDATE `tbl_acompanante`
  SET `lugarExpedicionDocumentoA` = $lugarExpedicionDocumentoA,
  `parentescoA` = $parentescoA,
  `identificacionA` = $identificacionA,
  `nombreA` = $nombreA,
  `telefonoA` = $telefonoA,
  `apellidoA` = $apellidoA
    WHERE `idAcompanante` = $idAcompanante;
END$$

DROP PROCEDURE IF EXISTS `spModificarAfectadoaccidentetransito`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarAfectadoaccidentetransito`(IN $idAfectadoAccidenteTransito INT, IN $descripcionAfectadoAccidenteTransito varchar(45))
BEGIN
    UPDATE `tbl_afectadoaccidentetransito` SET `descripcionAfectadoAccidenteTransito` = $descripcionAfectadoAccidenteTransito WHERE `idAfectadoAccidenteTransito` = $idAfectadoAccidenteTransito;
    END$$

DROP PROCEDURE IF EXISTS `spModificarAmbulancia`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarAmbulancia`(IN $idAmbulancia INT, IN $tipoAmbulancia varchar(45), IN $placaAmbulancia varchar(45))
BEGIN
    UPDATE `tbl_ambulancia` SET `tipoAmbulancia` = $tipoAmbulancia, `placaAmbulancia` = $placaAmbulancia WHERE `idAmbulancia` = $idAmbulancia;
    END$$

DROP PROCEDURE IF EXISTS `spModificarAntecedenteaph`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarAntecedenteaph`(IN $idAntecedente INT, IN $idTipoAntecendente int(11), IN $idReporteAPH int(11), IN $especificacion varchar(200))
BEGIN
    UPDATE `tbl_antecedenteaph` SET `idTipoAntecendente` = $idTipoAntecendente, `idReporteAPH` = $idReporteAPH, `especificacion` = $especificacion WHERE `idAntecedente` = $idAntecedente;
    END$$

DROP PROCEDURE IF EXISTS `spModificarAntecedentedmc`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarAntecedentedmc`(IN $idAntecedente INT, IN $descripcionAntecedente text, IN $idTipoAntecedente int(11), IN $idHistoriaClinica int(11))
BEGIN
    UPDATE `tbl_antecedentedmc` SET `descripcionAntecedente` = $descripcionAntecedente, `idTipoAntecedente` = $idTipoAntecedente, `idHistoriaClinica` = $idHistoriaClinica WHERE `idAntecedente` = $idAntecedente;
    END$$

DROP PROCEDURE IF EXISTS `spModificarAsignacion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarAsignacion`(
  IN _fechaHora datetime,
  IN _latitudAmbulancia varchar(50),
  IN _longitudAmbulancia varchar(50),
  IN _idAmbulancia int
)
BEGIN
  UPDATE tbl_asignacionpersonal
  SET fechaHoraAsignacion = _fechaHora, latitud = _latitudAmbulancia, longitud = _longitudAmbulancia
  WHERE idAmbulancia = _idAmbulancia;
END$$

DROP PROCEDURE IF EXISTS `spModificarAsignacionkit`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarAsignacionkit`(IN $idAsignacion INT, IN $fechaHoraAsignacion datetime, IN $idPersona int(11), IN $idAmbulancia int(11), IN $idTipoAsignacion int(11), IN $idPaciente int(11))
BEGIN
    UPDATE `tbl_asignacionkit` SET `fechaHoraAsignacion` = $fechaHoraAsignacion, `idPersona` = $idPersona, `idAmbulancia` = $idAmbulancia, `idTipoAsignacion` = $idTipoAsignacion, `idPaciente` = $idPaciente WHERE `idAsignacion` = $idAsignacion;
    END$$

DROP PROCEDURE IF EXISTS `spModificarAsignacionpersonal`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarAsignacionpersonal`(
IN $idAsignacionPersonal int,
IN $idAmbulancia int,
IN $fechaHoraAsignacion datetime,
IN $longitud varchar(45),
IN $latitud varchar(45)
)
BEGIN
  UPDATE `tbl_asignacionpersonal` SET `idAmbulancia` = $idAmbulancia, `fechaHoraAsignacion` = $fechaHoraAsignacion,
  `longitud` = $longitud, `latitud` = $latitud WHERE `idAsignacionPersonal` = $idAsignacionPersonal;
END$$

DROP PROCEDURE IF EXISTS `spModificarAutorizacion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarAutorizacion`(IN $idAutorizacion INT, IN $idUsuarioParamedico int(11), IN $idUsuarioMedico int(11), IN $idReporteAPH int(11), IN $idTipoTratamiento int(11), IN $idMedicamento int(11), IN $descripcionAutorizacion text, IN $observacionRespuestaAutorizacion text, IN $estadoEvaluacion varchar(45), IN $fechaEnvio datetime, IN $fechaEvaluacion datetime, IN $cedulaPaciente varchar(45))
BEGIN
    UPDATE `tbl_autorizacion` SET `idUsuarioParamedico` = $idUsuarioParamedico, `idUsuarioMedico` = $idUsuarioMedico, `idReporteAPH` = $idReporteAPH, `idTipoTratamiento` = $idTipoTratamiento, `idMedicamento` = $idMedicamento, `descripcionAutorizacion` = $descripcionAutorizacion, `observacionRespuestaAutorizacion` = $observacionRespuestaAutorizacion, `estadoEvaluacion` = $estadoEvaluacion, `fechaEnvio` = $fechaEnvio, `fechaEvaluacion` = $fechaEvaluacion, `cedulaPaciente` = $cedulaPaciente WHERE `idAutorizacion` = $idAutorizacion;
    END$$

DROP PROCEDURE IF EXISTS `spModificarCategoriaautorizacion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarCategoriaautorizacion`(IN $idCategoriaAutorizacion INT, IN $descripcion varchar(45))
BEGIN
    UPDATE `tbl_categoriaautorizacion` SET `descripcion` = $descripcion WHERE `idCategoriaAutorizacion` = $idCategoriaAutorizacion;
    END$$

DROP PROCEDURE IF EXISTS `spModificarCategoriarecurso`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarCategoriarecurso`(IN $idCategoriaRecurso INT, IN $descripcionCategoriarecurso varchar(45))
BEGIN
    UPDATE `tbl_categoriarecurso` SET `descripcionCategoriarecurso` = $descripcionCategoriarecurso WHERE `idCategoriaRecurso` = $idCategoriaRecurso;
    END$$

DROP PROCEDURE IF EXISTS `spModificarCertificadoatencion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarCertificadoatencion`(IN $idCertificadoAtencion INT, IN $descripcionCertificadoAtencion varchar(45))
BEGIN
    UPDATE `tbl_certificadoatencion` SET `descripcionCertificadoAtencion` = $descripcionCertificadoAtencion WHERE `idCertificadoAtencion` = $idCertificadoAtencion;
    END$$

DROP PROCEDURE IF EXISTS `spModificarChat`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarChat`(IN $idChat INT, IN $fechaHoraInicioChat timestamp, IN $idReceptorInicial int(11), IN $idUsuarioExterno int(11), IN $visto bit(1))
BEGIN
    UPDATE `tbl_chat` SET `fechaHoraInicioChat` = $fechaHoraInicioChat, `idReceptorInicial` = $idReceptorInicial, `idUsuarioExterno` = $idUsuarioExterno, `visto` = $visto WHERE `idChat` = $idChat;
    END$$

DROP PROCEDURE IF EXISTS `spModificarCie10`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarCie10`(IN $idCIE10 INT, IN $codigoCIE10 varchar(45), IN $descripcionCIE10 varchar(1000))
BEGIN
    UPDATE `tbl_cie10` SET `codigoCIE10` = $codigoCIE10, `descripcionCIE10` = $descripcionCIE10 WHERE `idCIE10` = $idCIE10;
    END$$

DROP PROCEDURE IF EXISTS `spModificarCita`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarCita`(IN $idCita INT,  IN $direccionCita varchar(45), IN $fechaCita date, IN $horaInicial time, IN $horaFinal time, IN $telefonoFijo1 varchar(45), IN $telefonoFijo2 varchar(45), IN $idPaciente int(11), IN $idCUP int(11), IN $idZona int(11), IN $fechaRegistro date)
BEGIN
    UPDATE `tbl_cita` SET  `direccionCita` = $direccionCita, `fechaCita` = $fechaCita, `horaInicial` = $horaInicial, `horaFinal` = $horaFinal, `telefonoFijo1` = $telefonoFijo1, `telefonoFijo2` = $telefonoFijo2, `idPaciente` = $idPaciente, `idCUP` = $idCUP, `idZona` = $idZona, `fechaRegistro` = $fechaRegistro WHERE `idCita` = $idCita;
    END$$

DROP PROCEDURE IF EXISTS `spModificarCita_programacion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarCita_programacion`(IN $idCitaprogramacion INT, IN $idCita int(11), IN $idTurnoProgramacion int(11))
BEGIN
    UPDATE `tbl_cita_programacion` SET `idCita` = $idCita, `idTurnoProgramacion` = $idTurnoProgramacion WHERE `idCitaprogramacion` = $idCitaprogramacion;
    END$$

DROP PROCEDURE IF EXISTS `spModificarConfiguracion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarConfiguracion`(IN $idConfiguracion INT, IN $cantidadCitasDia int(11), IN $cantidadCitasMes int(11), IN $descripcionConfiguracion varchar(45), IN $fechaConfiguracion timestamp)
BEGIN
    UPDATE `tbl_configuracion` SET `cantidadCitasDia` = $cantidadCitasDia, `cantidadCitasMes` = $cantidadCitasMes, `descripcionConfiguracion` = $descripcionConfiguracion, `fechaConfiguracion` = $fechaConfiguracion WHERE `idConfiguracion` = $idConfiguracion;
    END$$

DROP PROCEDURE IF EXISTS `spModificarCuentausuario`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarCuentausuario`(IN $idUsuario INT, IN $idPersona int(11), IN $usuario varchar(100), IN $clave varchar(50), IN $idRol int(11))
BEGIN
    UPDATE `tbl_cuentausuario` SET `idPersona` = $idPersona, `usuario` = $usuario, `clave` = $clave, `idRol` = $idRol WHERE `idUsuario` = $idUsuario;
    END$$

DROP PROCEDURE IF EXISTS `spModificarCuidadoantarribo`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarCuidadoantarribo`(IN $idCuidadoAntArribo INT, IN $descripcionArribo varchar(45), IN $idReporteAPH int(11))
BEGIN
    UPDATE `tbl_cuidadoantarribo` SET `descripcionArribo` = $descripcionArribo, `idReporteAPH` = $idReporteAPH WHERE `idCuidadoAntArribo` = $idCuidadoAntArribo;
    END$$

DROP PROCEDURE IF EXISTS `spModificarCup`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarCup`(IN $idCUP INT, IN $nombreCUP varchar(1000), IN $idConfiguracion int(11), IN $idTipoCup int(11), IN $codigoCup varchar(45))
BEGIN
    UPDATE `tbl_cup` SET `nombreCUP` = $nombreCUP, `idConfiguracion` = $idConfiguracion, `idTipoCup` = $idTipoCup, `codigoCup` = $codigoCup WHERE `idCUP` = $idCUP;
    END$$

DROP PROCEDURE IF EXISTS `spModificarCupConfiguracion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarCupConfiguracion`(IN `$idConfiguracion` INT, IN `$idCup` INT)
BEGIN
  UPDATE `tbl_cup` SET `idConfiguracion` = $idConfiguracion,
   tbl_cup.idTipoCup=(SELECT tbl_tipocup.idTipoCup FROM tbl_tipocup
  WHERE tbl_tipocup.descripcionCUP LIKE 'Citas') WHERE`idCUP` = $idCup;
END$$

DROP PROCEDURE IF EXISTS `spModificarDesfibrilacion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarDesfibrilacion`(IN $iddesfibrilacion INT, IN $idReporteAPH int(11), IN $horaDesfibrilacion time, IN $joules float)
BEGIN
    UPDATE `tbl_desfibrilacion` SET `idReporteAPH` = $idReporteAPH, `horaDesfibrilacion` = $horaDesfibrilacion, `joules` = $joules WHERE `iddesfibrilacion` = $iddesfibrilacion;
    END$$

DROP PROCEDURE IF EXISTS `spModificarDespacho`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarDespacho`(IN $idDespacho INT, IN $idReporteInicial int(11), IN $idAmbulancia int(11), IN $fechaHoraDespacho datetime, IN $estadoDespacho varchar(50), IN $longitudEmergencia varchar(200), IN $latitudEmergencia varchar(200), IN $idPersona int(11))
BEGIN
    UPDATE `tbl_despacho` SET `idReporteInicial` = $idReporteInicial, `idAmbulancia` = $idAmbulancia, `fechaHoraDespacho` = $fechaHoraDespacho, `estadoDespacho` = $estadoDespacho, `longitudEmergencia` = $longitudEmergencia, `latitudEmergencia` = $latitudEmergencia, `idPersona` = $idPersona WHERE `idDespacho` = $idDespacho;
    END$$

DROP PROCEDURE IF EXISTS `spModificarDetalleAsignacion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarDetalleAsignacion`(
IN _persona int,
IN _detalleAsignacion int,
IN _ambulancia int
)
BEGIN
  UPDATE tbl_detalleasignacion DA
  INNER JOIN tbl_asignacionpersonal ASP
  ON DA.idAsignacionPersonal = ASP.idAsignacionPersonal
  INNER JOIN tbl_ambulancia A
  ON ASP.idAmbulancia = A.idAmbulancia
  SET idPersona = _persona
  WHERE DA.idDetalleAsignacion = _detalleAsignacion AND A.idAmbulancia = _ambulancia;
END$$

DROP PROCEDURE IF EXISTS `spModificarDetallekit`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarDetallekit`(IN $idDetallekit INT, IN $cantidadAsignada int(11), IN $cantidadFinal int(11), IN $idrecurso int(11), IN $idAsignacion int(11))
BEGIN
    UPDATE `tbl_detallekit` SET `cantidadAsignada` = $cantidadAsignada, `cantidadFinal` = $cantidadFinal, `idrecurso` = $idrecurso, `idAsignacion` = $idAsignacion WHERE `idDetallekit` = $idDetallekit;
    END$$

DROP PROCEDURE IF EXISTS `spModificarDetalletratamientodmcrecurso`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarDetalletratamientodmcrecurso`(IN $idDetalleTratamientodmcRecurso INT, IN $idRecurso int(11), IN $idTratamiento int(11))
BEGIN
    UPDATE `tbl_detalletratamientodmcrecurso` SET `idRecurso` = $idRecurso, `idTratamiento` = $idTratamiento WHERE `idDetalleTratamientodmcRecurso` = $idDetalleTratamientodmcRecurso;
    END$$

DROP PROCEDURE IF EXISTS `spModificarDevolucion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarDevolucion`(IN $idDevolucion INT, IN $cantidad int(11), IN $fechaHoraDevolucion datetime, IN $idTipoDevolucion int(11), IN $idDetallekit int(11), IN $idPersona int(11))
BEGIN
    UPDATE `tbl_devolucion` SET `cantidad` = $cantidad, `fechaHoraDevolucion` = $fechaHoraDevolucion, `idTipoDevolucion` = $idTipoDevolucion, `idDetallekit` = $idDetallekit, `idPersona` = $idPersona WHERE `idDevolucion` = $idDevolucion;
    END$$

DROP PROCEDURE IF EXISTS `spModificarDiagnostico`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarDiagnostico`(IN $idDiagnostico INT, IN $idHistoriaClinica int(11), IN $descripcionDiagnostico text, IN $idCIE10 int(11))
BEGIN
    UPDATE `tbl_diagnostico` SET `idHistoriaClinica` = $idHistoriaClinica, `descripcionDiagnostico` = $descripcionDiagnostico, `idCIE10` = $idCIE10 WHERE `idDiagnostico` = $idDiagnostico;
    END$$

DROP PROCEDURE IF EXISTS `spModificarEnteexterno`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarEnteexterno`(IN $idEnteExterno INT, IN $descripcionEnteExterno varchar(45))
BEGIN
    UPDATE `tbl_enteexterno` SET `descripcionEnteExterno` = $descripcionEnteExterno WHERE `idEnteExterno` = $idEnteExterno;
    END$$

DROP PROCEDURE IF EXISTS `spModificarEnteexterno_reporteinicial`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarEnteexterno_reporteinicial`(IN $idEnteExternoReporteInicial INT, IN $idEnteExterno int(11), IN $idReporteInicial int(11))
BEGIN
    UPDATE `tbl_enteexterno_reporteinicial` SET `idEnteExterno` = $idEnteExterno, `idReporteInicial` = $idReporteInicial WHERE `idEnteExternoReporteInicial` = $idEnteExternoReporteInicial;
    END$$

DROP PROCEDURE IF EXISTS `spModificarEquipobiomedico`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarEquipobiomedico`(IN $idEquipoBiomedico INT, IN $descripcion varchar(50), IN $idTratamiento int(11))
BEGIN
    UPDATE `tbl_equipobiomedico` SET `descripcion` = $descripcion, `idTratamiento` = $idTratamiento WHERE `idEquipoBiomedico` = $idEquipoBiomedico;
    END$$

DROP PROCEDURE IF EXISTS `spModificarEspecialidad`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarEspecialidad`(IN $idEspecialidad INT, IN $descripcionEspecialidad varchar(45))
BEGIN
    UPDATE `tbl_especialidad` SET `descripcionEspecialidad` = $descripcionEspecialidad WHERE `idEspecialidad` = $idEspecialidad;
    END$$

DROP PROCEDURE IF EXISTS `spModificarEstadopaciente`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarEstadopaciente`(IN $idEstadoPaciente INT, IN $descripcionEstadoPaciente varchar(50))
BEGIN
    UPDATE `tbl_estadopaciente` SET `descripcionEstadoPaciente` = $descripcionEstadoPaciente WHERE `idEstadoPaciente` = $idEstadoPaciente;
    END$$

DROP PROCEDURE IF EXISTS `spModificarEstandarkit`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarEstandarkit`(IN $idEstandarkit INT, IN $idRecurso int(11), IN $unidadMedida varchar(30), IN $stockminKit int(11), IN $idTipoKit int(11))
BEGIN
    UPDATE `tbl_estandarkit` SET `idRecurso` = $idRecurso, `unidadMedida` = $unidadMedida, `stockminKit` = $stockminKit, `idTipoKit` = $idTipoKit WHERE `idEstandarkit` = $idEstandarkit;
    END$$

DROP PROCEDURE IF EXISTS `spModificarEvaluacionautorizacion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarEvaluacionautorizacion`(IN $idEvaluacionAutorizacion INT, IN $idReporteAPH int(11), IN $idCuentaMedico int(11), IN $idAutorizacion int(11), IN $evaluacionAutorizacion varchar(45), IN $descripcionEvaluacion varchar(100))
BEGIN
    UPDATE `tbl_evaluacionautorizacion` SET `idReporteAPH` = $idReporteAPH, `idCuentaMedico` = $idCuentaMedico, `idAutorizacion` = $idAutorizacion, `evaluacionAutorizacion` = $evaluacionAutorizacion, `descripcionEvaluacion` = $descripcionEvaluacion WHERE `idEvaluacionAutorizacion` = $idEvaluacionAutorizacion;
    END$$

DROP PROCEDURE IF EXISTS `spModificarExamenespecializado`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarExamenespecializado`(IN $idExamenEspecializado INT, IN $observaciones text, IN $idTipoexamenespecializado int(11), IN $idHistoriaClinica int(11), IN $descripcion text)
BEGIN
    UPDATE `tbl_examenespecializado` SET `observaciones` = $observaciones, `idTipoexamenespecializado` = $idTipoexamenespecializado, `idHistoriaClinica` = $idHistoriaClinica, `descripcion` = $descripcion WHERE `idExamenEspecializado` = $idExamenEspecializado;
    END$$

DROP PROCEDURE IF EXISTS `spModificarExamenfisicoaph`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarExamenfisicoaph`(IN $idExamenFisico INT, IN $horaExamenFisico time, IN $estadoRespiracion varchar(45), IN $respiracion_min int(11), IN $SpO2 varchar(45), IN $estadoPulso varchar(45), IN $pulsaciones_min int(11), IN $estadoPresionArterial varchar(45), IN $sistolica float, IN $diastolica float, IN $PAM float, IN $glucometria float, IN $conciencia varchar(45), IN $glasgow varchar(45), IN $estadoPupilaD varchar(45), IN $estadoPupilaI varchar(45), IN $gradoDilatacionPD float, IN $gradoDilatacionPI float, IN $estadoHemodinamico varchar(45), IN $especificacionVerbal varchar(100), IN $especificacionOcular varchar(100), IN $especificacionMotor varchar(100), IN $EspecifiqueExamenFisico text)
BEGIN
    UPDATE `tbl_examenfisicoaph` SET `horaExamenFisico` = $horaExamenFisico, `estadoRespiracion` = $estadoRespiracion, `respiracion_min` = $respiracion_min, `SpO2` = $SpO2, `estadoPulso` = $estadoPulso, `pulsaciones_min` = $pulsaciones_min, `estadoPresionArterial` = $estadoPresionArterial, `sistolica` = $sistolica, `diastolica` = $diastolica, `PAM` = $PAM, `glucometria` = $glucometria, `conciencia` = $conciencia, `glasgow` = $glasgow, `estadoPupilaD` = $estadoPupilaD, `estadoPupilaI` = $estadoPupilaI, `gradoDilatacionPD` = $gradoDilatacionPD, `gradoDilatacionPI` = $gradoDilatacionPI, `estadoHemodinamico` = $estadoHemodinamico, `especificacionVerbal` = $especificacionVerbal, `especificacionOcular` = $especificacionOcular, `especificacionMotor` = $especificacionMotor, `EspecifiqueExamenFisico` = $EspecifiqueExamenFisico WHERE `idExamenFisico` = $idExamenFisico;
    END$$

DROP PROCEDURE IF EXISTS `spModificarExamenfisicodmc`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarExamenfisicodmc`(IN $idExamenFisico INT, IN $idHistoriaClinica int(11), IN $descripcionExamen text, IN $idtipoExamenFisico int(11))
BEGIN
    UPDATE `tbl_examenfisicodmc` SET `idHistoriaClinica` = $idHistoriaClinica, `descripcionExamen` = $descripcionExamen, `idtipoExamenFisico` = $idtipoExamenFisico WHERE `idExamenFisico` = $idExamenFisico;
    END$$

DROP PROCEDURE IF EXISTS `spModificarFormulamedica`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarFormulamedica`(IN $idFormulaMedica INT, IN $recomendaciones varchar(1000), IN $idHistoriaClinica int(11))
BEGIN
    UPDATE `tbl_formulamedica` SET `recomendaciones` = $recomendaciones, `idHistoriaClinica` = $idHistoriaClinica WHERE `idFormulaMedica` = $idFormulaMedica;
    END$$

DROP PROCEDURE IF EXISTS `spModificarFormulamedicamedicamentodmc`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarFormulamedicamedicamentodmc`(IN $idFormulaMedicaMedicamentoDmc INT, IN $idFormulamedica int(11), IN $idMedicamento int(11), IN $cantidadMedicamento int(11), IN $dosificacion varchar(100), IN $descripcion varchar(1000))
BEGIN
    UPDATE `tbl_formulamedicamedicamentodmc` SET `idFormulamedica` = $idFormulamedica, `idMedicamento` = $idMedicamento, `cantidadMedicamento` = $cantidadMedicamento, `dosificacion` = $dosificacion, `descripcion` = $descripcion WHERE `idFormulaMedicaMedicamentoDmc` = $idFormulaMedicaMedicamentoDmc;
    END$$

DROP PROCEDURE IF EXISTS `spModificarHistoriaclinica`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarHistoriaclinica`(IN $idHistoriaClinica INT, IN $fechaAtencion date, IN $motivoAtencion text, IN $enfermedadActual text, IN $placaVehiculo varchar(45), IN $idTipoorigenatencion int(11), IN $idCitaprogramacion int(11), IN $idPaciente int(11), IN $evolucion text)
BEGIN
    UPDATE `tbl_historiaclinica` SET `fechaAtencion` = $fechaAtencion, `motivoAtencion` = $motivoAtencion, `enfermedadActual` = $enfermedadActual, `placaVehiculo` = $placaVehiculo, `idTipoorigenatencion` = $idTipoorigenatencion, `idCitaprogramacion` = $idCitaprogramacion, `idPaciente` = $idPaciente, `evolucion` = $evolucion WHERE `idHistoriaClinica` = $idHistoriaClinica;
    END$$

DROP PROCEDURE IF EXISTS `spModificarHistorialmora`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarHistorialmora`(IN $idHistorialMora INT, IN $fechaHistorial date, IN $descripcionHistorial varchar(45), IN $idCita int(11), IN $idMulta int(11))
BEGIN
    UPDATE `tbl_historialmora` SET `fechaHistorial` = $fechaHistorial, `descripcionHistorial` = $descripcionHistorial, `idCita` = $idCita, `idMulta` = $idMulta WHERE `idHistorialMora` = $idHistorialMora;
    END$$

DROP PROCEDURE IF EXISTS `spModificarIncapacidad`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarIncapacidad`(IN $idIncapacidad INT, IN $cantidadDias int(11), IN $prorroga varchar(100), IN $descripcionMotivo text, IN $idCIE10 int(11), IN $idHistoriaClinica int(11))
BEGIN
    UPDATE `tbl_incapacidad` SET `cantidadDias` = $cantidadDias, `prorroga` = $prorroga, `descripcionMotivo` = $descripcionMotivo, `idCIE10` = $idCIE10, `idHistoriaClinica` = $idHistoriaClinica WHERE `idIncapacidad` = $idIncapacidad;
    END$$

DROP PROCEDURE IF EXISTS `spModificarInterconsulta`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarInterconsulta`(IN $idInterconsulta INT, IN $descripcionInterconsulta text, IN $especialidad varchar(100), IN $idHistoriaClinica int(11), IN $fechaLimite date)
BEGIN
    UPDATE `tbl_interconsulta` SET `descripcionInterconsulta` = $descripcionInterconsulta, `especialidad` = $especialidad, `idHistoriaClinica` = $idHistoriaClinica, `fechaLimite` = $fechaLimite WHERE `idInterconsulta` = $idInterconsulta;
    END$$

DROP PROCEDURE IF EXISTS `spModificarLesion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarLesion`(IN $idLesion INT, IN $idPuntoLesion int(11), IN $especificacionLesion varchar(100), IN $idCIE10 int(11))
BEGIN
    UPDATE `tbl_lesion` SET `idPuntoLesion` = $idPuntoLesion, `especificacionLesion` = $especificacionLesion, `idCIE10` = $idCIE10 WHERE `idLesion` = $idLesion;
    END$$

DROP PROCEDURE IF EXISTS `spModificarLlamada`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarLlamada`(IN $idLlamada INT, IN $idChat int(11), IN $urlLlamada varchar(100), IN $fechaHoraLlamada timestamp)
BEGIN
    UPDATE `tbl_llamada` SET `idChat` = $idChat, `urlLlamada` = $urlLlamada, `fechaHoraLlamada` = $fechaHoraLlamada WHERE `idLlamada` = $idLlamada;
    END$$

DROP PROCEDURE IF EXISTS `spModificarMedicamento`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarMedicamento`(IN $idmedicamento INT, IN $idReporteAPH int(11), IN $dosis varchar(45), IN $hora time, IN $viaAdministracion varchar(45), IN $cantidadUnidades int(11), IN $idDetallekit int(11), IN $idHistoriaClinica int(11))
BEGIN
    UPDATE `tbl_medicamento` SET `idReporteAPH` = $idReporteAPH, `dosis` = $dosis, `hora` = $hora, `viaAdministracion` = $viaAdministracion, `cantidadUnidades` = $cantidadUnidades, `idDetallekit` = $idDetallekit, `idHistoriaClinica` = $idHistoriaClinica WHERE `idmedicamento` = $idmedicamento;
    END$$

DROP PROCEDURE IF EXISTS `spModificarMensaje`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarMensaje`(IN $idMensaje INT, IN $idChat int(11), IN $mensaje varchar(200), IN $fechaHora timestamp, IN $tipo int(11))
BEGIN
    UPDATE `tbl_mensaje` SET `idChat` = $idChat, `mensaje` = $mensaje, `fechaHora` = $fechaHora, `tipo` = $tipo WHERE `idMensaje` = $idMensaje;
    END$$

DROP PROCEDURE IF EXISTS `spModificarModulo`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarModulo`(IN $idModulo INT, IN $descripcionModulo varchar(100), IN $iconoModulo varchar(50))
BEGIN
    UPDATE `tbl_modulo` SET `descripcionModulo` = $descripcionModulo, `iconoModulo` = $iconoModulo WHERE `idModulo` = $idModulo;
    END$$

DROP PROCEDURE IF EXISTS `spModificarMotivoconsulta`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarMotivoconsulta`(IN $idMotivoConsulta INT, IN $descripcionMotivoConsulta varchar(45), IN $TipoMotivoConsulta varchar(45))
BEGIN
    UPDATE `tbl_motivoconsulta` SET `descripcionMotivoConsulta` = $descripcionMotivoConsulta, `TipoMotivoConsulta` = $TipoMotivoConsulta WHERE `idMotivoConsulta` = $idMotivoConsulta;
    END$$

DROP PROCEDURE IF EXISTS `spModificarMulta`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarMulta`(IN $idMulta INT, IN $diasMulta int(11), IN $fechaMulta date)
BEGIN
    UPDATE `tbl_multa` SET `diasMulta` = $diasMulta, `fechaMulta` = $fechaMulta WHERE `idMulta` = $idMulta;
    END$$

DROP PROCEDURE IF EXISTS `spModificarNotaenfermeria`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarNotaenfermeria`(IN $idNotaEnfermeria INT, IN $descripcion varchar(200), IN $idPersona int(11), IN $idProcedimiento int(11))
BEGIN
    UPDATE `tbl_notaenfermeria` SET `descripcion` = $descripcion, `idPersona` = $idPersona, `idProcedimiento` = $idProcedimiento WHERE `idNotaEnfermeria` = $idNotaEnfermeria;
    END$$

DROP PROCEDURE IF EXISTS `spModificarNovedadrecurso`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarNovedadrecurso`(IN $idNovedadRecurso INT, IN $descripcionNovedad text, IN $fechaHoraNovedad datetime, IN $idDetallekit int(11), IN $idPersona int(11), IN $idTipoNovedad int(11))
BEGIN
    UPDATE `tbl_novedadrecurso` SET `descripcionNovedad` = $descripcionNovedad, `fechaHoraNovedad` = $fechaHoraNovedad, `idDetallekit` = $idDetallekit, `idPersona` = $idPersona, `idTipoNovedad` = $idTipoNovedad WHERE `idNovedadRecurso` = $idNovedadRecurso;
    END$$

DROP PROCEDURE IF EXISTS `spModificarNovedadreporteinicial`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarNovedadreporteinicial`(IN $idNovedad INT, IN $idReporteInicial int(11), IN $descripcionNovedad text, IN $fechaHoraNovedad timestamp, IN $numeroLesionadosNovedad int(11), IN $estadoNovedad varchar(50))
BEGIN
    UPDATE `tbl_novedadreporteinicial` SET `idReporteInicial` = $idReporteInicial, `descripcionNovedad` = $descripcionNovedad, `fechaHoraNovedad` = $fechaHoraNovedad, `numeroLesionadosNovedad` = $numeroLesionadosNovedad, `estadoNovedad` = $estadoNovedad WHERE `idNovedad` = $idNovedad;
    END$$

DROP PROCEDURE IF EXISTS `spModificarNovedadreporteinicial_enteexterno`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarNovedadreporteinicial_enteexterno`(IN $idNovedadReporteInicialEnteExterno INT, IN $idEnteExterno int(11), IN $idNovedad int(11))
BEGIN
    UPDATE `tbl_novedadreporteinicial_enteexterno` SET `idEnteExterno` = $idEnteExterno, `idNovedad` = $idNovedad WHERE `idNovedadReporteInicialEnteExterno` = $idNovedadReporteInicialEnteExterno;
    END$$

DROP PROCEDURE IF EXISTS `spModificarObservacion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarObservacion`(IN $idObservacion INT, IN $idPersonaResponsable int(11), IN $descripcionObservacion varchar(1000), IN $fechaObservacion date, IN $idProcedimiento int(11))
BEGIN
    UPDATE `tbl_observacion` SET `idPersonaResponsable` = $idPersonaResponsable, `descripcionObservacion` = $descripcionObservacion, `fechaObservacion` = $fechaObservacion, `idProcedimiento` = $idProcedimiento WHERE `idObservacion` = $idObservacion;
    END$$

DROP PROCEDURE IF EXISTS `spModificarOtrodmc`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarOtrodmc`(IN $idOtro INT, IN $descripcion text, IN $idHistoriaClinica int(11))
BEGIN
    UPDATE `tbl_otrodmc` SET `descripcion` = $descripcion, `idHistoriaClinica` = $idHistoriaClinica WHERE `idOtro` = $idOtro;
    END$$

DROP PROCEDURE IF EXISTS `spModificarPaciente`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarPaciente`(
  $idPaciente INT,
  $numeroDocumento VARCHAR(45),
  $primerNombre VARCHAR(45),
  $segundoNombre VARCHAR(45),
  $primerApellido VARCHAR(45),
  $segundoApellido VARCHAR(45),
  $estadoCivil VARCHAR(45),
  $ciudadResidencia VARCHAR(45),
  $barrioResidencia VARCHAR(45),
  $direccion VARCHAR(45),
  $telefonoFijo INT,
  $telefonoMovil INT,
  $correoElectronico VARCHAR(45),
  $empresa VARCHAR(45),
  $ocupacion VARCHAR(45),
  $profesion VARCHAR(45),
  $idtipoDocumento INT,
  $idtipoAfiliacion INT,
  $url VARCHAR(250)

)
BEGIN
 UPDATE `tbl_paciente` SET
 `numeroDocumento` = $numeroDocumento,
 `primerNombre` = $primerNombre,
 `segundoNombre` = $segundoNombre,
 `primerApellido` = $primerApellido,
 `segundoApellido` = $segundoApellido,
 `estadoCivil` = $estadoCivil,
 `ciudadResidencia` = $ciudadResidencia,
 `barrioResidencia` = $barrioResidencia,
 `direccion` =$direccion,
 `telefonoFijo` = $telefonoFijo,
 `telefonoMovil` = $telefonoMovil,
 `correoElectronico` = $correoElectronico,
 `empresa` = $empresa,
 `ocupacion` = $ocupacion,
 `profesion` = $profesion,
 `idtipoDocumento` = $idtipoDocumento,
 `idtipoAfiliacion` = $idtipoAfiliacion,
 `url` = $url
 WHERE `idPaciente` = $idPaciente;
 END$$

DROP PROCEDURE IF EXISTS `spModificarPacienteAPH`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarPacienteAPH`()
BEGIN
  UPDATE `tbl_paciente`
  SET `estado` = $estado,
  `numeroDocumento` = $numeroDocumento,
  `fechaNacimiento` = $fechaNacimiento,
  `tipoSangre` = $tipoSangre,
  `primerNombre` = $primerNombre,
  `segundoNombre` = $segundoNombre,
  `primerApellido` = $primerApellido,
  `segundoApellido` = $segundoApellido,
  `genero` = $genero,
  `estadoCivil` = $estadoCivil,
  `ciudadResidencia` = $ciudadResidencia,
  `barrioResidencia` = $barrioResidencia,
  `direccion` = $direccion,
  `telefonoFijo` = $telefonoFijo,
  `telefonoMovil` = $telefonoMovil,
  `correoElectronico` = $correoElectronico,
  `empresa` = $empresa,
  `ocupacion` = $ocupacion,
  `profesion` = $profesion,
  `fechaAfiliacionRegistro` = $fechaAfiliacionRegistro,
  `tipoAfiliado` = $tipoAfiliado,
  `idtipoDocumento` = (SELECT idtipoDocumento FROM tbl_tipodocumento WHERE descripcionTdocumento = $idtipoDocumento),
  `idtipoAfiliacion` = $idtipoAfiliacion,
  `edadPaciente` = $edadPaciente WHERE `idPaciente` = $idPaciente;
END$$

DROP PROCEDURE IF EXISTS `spModificarPacienteCita`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarPacienteCita`(
  IN `$idPaciente` INT,
  IN `$primerNombre` VARCHAR(45),
  IN `$segundoNombre` VARCHAR(45),
  IN `$primerApellido` VARCHAR(45),
  IN `$segundoApellido` VARCHAR(45),
  IN `$ciudadResidencia` VARCHAR(45),
  IN `$barrioResidencia` VARCHAR(45),
  IN `$direccion` VARCHAR(45),
  IN `$telefonoFijo` VARCHAR(45),
  IN `$telefonoMovil` VARCHAR(45),
  IN `$correoElectronico` VARCHAR(45),
  IN `$idtipoDocumento` INT
)
BEGIN
UPDATE `tbl_paciente`
SET
  `primerNombre` = $primerNombre,
  `segundoNombre` = $segundoNombre,
  `primerApellido` = $primerApellido,
  `segundoApellido` = $segundoApellido,
  `ciudadResidencia` = $ciudadResidencia,
  `barrioResidencia` = $barrioResidencia,
  `direccion` = $direccion,
  `telefonoFijo` = $telefonoFijo,
  `telefonoMovil` = $telefonoMovil,
  `correoElectronico` = $correoElectronico,
  `idtipoDocumento` = $idtipoDocumento
WHERE
  `idPaciente` = $idPaciente;
END$$

DROP PROCEDURE IF EXISTS `spModificarPacienteD`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarPacienteD`(IN `$idPaciente` INT, IN `$numeroDocumento` VARCHAR(45), IN `$fechaNacimiento` DATE, IN `$primerNombre` VARCHAR(45), IN `$segundoNombre` VARCHAR(45), IN `$primerApellido` VARCHAR(45), IN `$segundoApellido` VARCHAR(45), IN `$estadoCivil` VARCHAR(45), IN `$ciudadResidencia` VARCHAR(45), IN `$barrioResidencia` VARCHAR(45), IN `$direccion` VARCHAR(45), IN `$telefonoFijo` VARCHAR(45), IN `$telefonoMovil` VARCHAR(45), IN `$correoElectronico` VARCHAR(45), IN `$empresa` VARCHAR(45), IN `$ocupacion` VARCHAR(45), IN `$profesion` VARCHAR(45), IN `$fechaAfiliacionRegistro` DATE, IN `$idtipoDocumento` INT(11), IN `$idtipoAfiliacion` INT(11), IN `$url` VARCHAR(250))
BEGIN
    UPDATE `tbl_paciente` SET `numeroDocumento` = $numeroDocumento, `fechaNacimiento` = $fechaNacimiento,  `primerNombre` = $primerNombre, `segundoNombre` = $segundoNombre, `primerApellido` = $primerApellido, `segundoApellido` = $segundoApellido, `estadoCivil` = $estadoCivil, `ciudadResidencia` = $ciudadResidencia, `barrioResidencia` = $barrioResidencia, `direccion` = $direccion, `telefonoFijo` = $telefonoFijo, `telefonoMovil` = $telefonoMovil, `correoElectronico` = $correoElectronico, `empresa` = $empresa, `ocupacion` = $ocupacion, `profesion` = $profesion, `fechaAfiliacionRegistro` = $fechaAfiliacionRegistro,  `idtipoDocumento` = $idtipoDocumento, `idtipoAfiliacion` = $idtipoAfiliacion, `url` = $url WHERE `idPaciente` = $idPaciente;
    END$$

DROP PROCEDURE IF EXISTS `spModificarPerfil`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarPerfil`(
$idPersona INT, $primerNombre VARCHAR(50), $segundoNombre VARCHAR(50), $primerApellido VARCHAR(50),
$segundoApellido VARCHAR(50), $idTipoDocumento INT, $numeroDocumento VARCHAR(20), $fechaNacimiento DATE,
$sexo VARCHAR(45), $direccion VARCHAR(45), $telefono VARCHAR(45), $correoElectronico VARCHAR(45), $ciudad VARCHAR(45), $departamento VARCHAR(45), $pais VARCHAR(45), $urlFoto VARCHAR(250)
)
BEGIN
    UPDATE `tbl_persona` SET `primerNombre` = $primerNombre, `segundoNombre` = $segundoNombre, `primerApellido` = $primerApellido, `segundoApellido` = $segundoApellido, `idTipoDocumento` = $idTipoDocumento, `numeroDocumento` = $numeroDocumento, `fechaNacimiento` = $fechaNacimiento, `sexo` = $sexo, `direccion` = $direccion, `telefono` = $telefono, `correoElectronico` = $correoElectronico, `ciudad` = $ciudad, `departamento` = $departamento, `pais` = $pais, `urlFoto` = $urlFoto WHERE `idPersona` = $idPersona;
END$$

DROP PROCEDURE IF EXISTS `spModificarPersona`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarPersona`(IN $idPersona INT,
 IN $primerNombre varchar(50),
 IN $segundoNombre varchar(50),
 IN $primerApellido varchar(50),
 IN $segundoApellido varchar(50),
 IN $idTipoDocumento int(11),
 IN $numeroDocumento varchar(20),
 IN $lugarExpedicionDocumento varchar(50),
 IN $fechaNacimiento date,
 IN $lugarNacimiento varchar(45),
 IN $sexo varchar(45),
 IN $direccion varchar(45),
 IN $telefono varchar(45),
 IN $correoElectronico varchar(45),
 IN $grupoSanguineo varchar(45),
 IN $ciudad varchar(45),
 IN $departamento varchar(45),
 IN $pais varchar(45),
 IN $urlHojaDeVida varchar(250),
 IN $urlFirma varchar(250),
 IN $urlFoto varchar(250),
 IN $dependencia varchar(45),
 IN $idRol INT(11))
BEGIN
  UPDATE `tbl_persona` AS P
  INNER JOIN `tbl_cuentausuario` cu ON cu.idPersona = P.idPersona
  SET `primerNombre` = $primerNombre, `segundoNombre` = $segundoNombre, `primerApellido` = $primerApellido, `segundoApellido` = $segundoApellido, `idTipoDocumento` = $idTipoDocumento, `numeroDocumento` = $numeroDocumento, `lugarExpedicionDocumento` = $lugarExpedicionDocumento, `fechaNacimiento` = $fechaNacimiento, `lugarNacimiento` = $lugarNacimiento, `sexo` = $sexo, `direccion` = $direccion, `telefono` = $telefono, `correoElectronico` = $correoElectronico, `grupoSanguineo` = $grupoSanguineo, `ciudad` = $ciudad, `departamento` = $departamento, `pais` = $pais, `urlHojaDeVida` = $urlHojaDeVida, `urlFirma` = $urlFirma, `urlFoto` = $urlFoto, `dependencia` = $dependencia, cu.`idRol` = $idRol
  WHERE P.idPersona = $idPersona;
END$$

DROP PROCEDURE IF EXISTS `spModificarPersonaespecialidad`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarPersonaespecialidad`(IN $idPersonaespecialidad INT, IN $idPersona int(11), IN $idEspecialidad int(11))
BEGIN
    UPDATE `tbl_personaespecialidad` SET `idPersona` = $idPersona, `idEspecialidad` = $idEspecialidad WHERE `idPersonaespecialidad` = $idPersonaespecialidad;
    END$$

DROP PROCEDURE IF EXISTS `spModificarPiel`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarPiel`(IN $idPiel INT, IN $idExamenFisico int(11), IN $descripcion varchar(45))
BEGIN
    UPDATE `tbl_piel` SET `idExamenFisico` = $idExamenFisico, `descripcion` = $descripcion WHERE `idPiel` = $idPiel;
    END$$

DROP PROCEDURE IF EXISTS `spModificarProcedimiento`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarProcedimiento`(IN $idProcedimiento INT, IN $idCUP int(11), IN $idHistoriaClinica int(11), IN $descripcionProcedimiento varchar(1000))
BEGIN
    UPDATE `tbl_procedimiento` SET `idCUP` = $idCUP, `idHistoriaClinica` = $idHistoriaClinica, `descripcionProcedimiento` = $descripcionProcedimiento WHERE `idProcedimiento` = $idProcedimiento;
    END$$

DROP PROCEDURE IF EXISTS `spModificarProgramacion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarProgramacion`(IN $idProgramacion INT, IN $Fecha_inicial date, IN $Fecha_final date)
BEGIN
    UPDATE `tbl_programacion` SET `Fecha_inicial` = $Fecha_inicial, `Fecha_final` = $Fecha_final WHERE `idProgramacion` = $idProgramacion;
    END$$

DROP PROCEDURE IF EXISTS `spModificarPuntolesion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarPuntolesion`(IN $idPuntoLesion INT, IN $posX varchar(100), IN $posY varchar(100), IN $idReporteAPH int(11))
BEGIN
    UPDATE `tbl_puntolesion` SET `posX` = $posX, `posY` = $posY, `idReporteAPH` = $idReporteAPH WHERE `idPuntoLesion` = $idPuntoLesion;
    END$$

DROP PROCEDURE IF EXISTS `spModificarRecurso`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarRecurso`(IN $idrecurso INT, IN $nombre varchar(45), IN $descripcion varchar(45), IN $cantidadRecurso int(11), IN $idCategoriaRecurso int(11))
BEGIN
    UPDATE `tbl_recurso` SET `nombre` = $nombre, `descripcion` = $descripcion, `cantidadRecurso` = $cantidadRecurso, `idCategoriaRecurso` = $idCategoriaRecurso WHERE `idrecurso` = $idrecurso;
    END$$

DROP PROCEDURE IF EXISTS `spModificarReporteaph`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarReporteaph`(IN $idReporteAPH INT, IN $idExamenFisico int(11), IN $idDespacho int(11), IN $idAsignacionPersonal int(11), IN $idPersonalRecibe int(11), IN $idParamedicoAtiende int(11), IN $idTriage int(11), IN $idTipoAseguramiento int(11), IN $idCertificadoAtencion int(11), IN $fechaHoraFinalizacion datetime, IN $fechaHoraArriboEscena datetime, IN $fechaHoraArriboIPS datetime, IN $ultimaIngesta datetime, IN $idAfectadoAccidenteTransito int(11), IN $placaVehiculo varchar(45), IN $codigoAseguradora varchar(45), IN $numeroPoliza varchar(45), IN $descripcionTratamiento text, IN $descripcionTratamientoAvanzado text, IN $evaluacionResultado varchar(45), IN $institucionReceptora varchar(45), IN $situacionEntrega varchar(45), IN $presionArterialEntrega varchar(45), IN $pulsoEntrega varchar(45), IN $respiracionEntrega varchar(45), IN $complicaciones text, IN $idPaciente int(11), IN $idAcompanante int(11), IN $TAPHPresente tinyint(1), IN $TPAPHPresente tinyint(1), IN $otroPersonalControlM tinyint(1), IN $nombreOtroPersonalControlM varchar(45), IN $protocolo bit(1))
BEGIN
    UPDATE `tbl_reporteaph` SET `idExamenFisico` = $idExamenFisico, `idDespacho` = $idDespacho, `idAsignacionPersonal` = $idAsignacionPersonal, `idPersonalRecibe` = $idPersonalRecibe, `idParamedicoAtiende` = $idParamedicoAtiende, `idTriage` = $idTriage, `idTipoAseguramiento` = $idTipoAseguramiento, `idCertificadoAtencion` = $idCertificadoAtencion, `fechaHoraFinalizacion` = $fechaHoraFinalizacion, `fechaHoraArriboEscena` = $fechaHoraArriboEscena, `fechaHoraArriboIPS` = $fechaHoraArriboIPS, `ultimaIngesta` = $ultimaIngesta, `idAfectadoAccidenteTransito` = $idAfectadoAccidenteTransito, `placaVehiculo` = $placaVehiculo, `codigoAseguradora` = $codigoAseguradora, `numeroPoliza` = $numeroPoliza, `descripcionTratamiento` = $descripcionTratamiento, `descripcionTratamientoAvanzado` = $descripcionTratamientoAvanzado, `evaluacionResultado` = $evaluacionResultado, `institucionReceptora` = $institucionReceptora, `situacionEntrega` = $situacionEntrega, `presionArterialEntrega` = $presionArterialEntrega, `pulsoEntrega` = $pulsoEntrega, `respiracionEntrega` = $respiracionEntrega, `complicaciones` = $complicaciones, `idPaciente` = $idPaciente, `idAcompanante` = $idAcompanante, `TAPHPresente` = $TAPHPresente, `TPAPHPresente` = $TPAPHPresente, `otroPersonalControlM` = $otroPersonalControlM, `nombreOtroPersonalControlM` = $nombreOtroPersonalControlM, `protocolo` = $protocolo WHERE `idReporteAPH` = $idReporteAPH;
    END$$

DROP PROCEDURE IF EXISTS `spModificarReporteaph_motivoconsulta`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarReporteaph_motivoconsulta`(IN $idAPHMC INT, IN $idReporteAPH int(11), IN $idMotivoConsulta int(11), IN $especificacion text)
BEGIN
    UPDATE `tbl_reporteaph_motivoconsulta` SET `idReporteAPH` = $idReporteAPH, `idMotivoConsulta` = $idMotivoConsulta, `especificacion` = $especificacion WHERE `idAPHMC` = $idAPHMC;
    END$$

DROP PROCEDURE IF EXISTS `spModificarReporteinicial`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarReporteinicial`(IN $idReporteInicial INT, IN $informacionInicial varchar(300), IN $ubicacionIncidente varchar(100), IN $puntoReferencia varchar(45), IN $numeroLesionados int(11), IN $fechaHoraAproximadaEmergencia datetime, IN $fechaHoraEnvioReporteInicial timestamp, IN $idChat int(11))
BEGIN
    UPDATE `tbl_reporteinicial` SET `informacionInicial` = $informacionInicial, `ubicacionIncidente` = $ubicacionIncidente, `puntoReferencia` = $puntoReferencia, `numeroLesionados` = $numeroLesionados, `fechaHoraAproximadaEmergencia` = $fechaHoraAproximadaEmergencia, `fechaHoraEnvioReporteInicial` = $fechaHoraEnvioReporteInicial, `idChat` = $idChat WHERE `idReporteInicial` = $idReporteInicial;
    END$$

DROP PROCEDURE IF EXISTS `spModificarRestablecer`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarRestablecer`(IN $idRestablecer INT, IN $email varchar(50), IN $codigo varchar(50), IN $idUsuario int(11), IN $estado varchar(20), IN $fecha timestamp)
BEGIN
    UPDATE `tbl_restablecer` SET `email` = $email, `codigo` = $codigo, `idUsuario` = $idUsuario, `estado` = $estado, `fecha` = $fecha WHERE `idRestablecer` = $idRestablecer;
    END$$

DROP PROCEDURE IF EXISTS `spModificarRol`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarRol`(IN $idRol INT, IN $descripcionRol varchar(45))
BEGIN
    UPDATE `tbl_rol` SET `descripcionRol` = $descripcionRol WHERE `idRol` = $idRol;
    END$$

DROP PROCEDURE IF EXISTS `spModificarRolmodulovista`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarRolmodulovista`(IN $idRolModuloVista INT, IN $idRol int(11), IN $idModulo int(11), IN $idVista int(11))
BEGIN
    UPDATE `tbl_rolmodulovista` SET `idRol` = $idRol, `idModulo` = $idModulo, `idVista` = $idVista WHERE `idRolModuloVista` = $idRolModuloVista;
    END$$

DROP PROCEDURE IF EXISTS `spModificarSignosvitales`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarSignosvitales`(IN $idSignosVitales INT, IN $resultado double, IN $hora time, IN $idHistoriaClinica int(11), IN $idValoracion int(11))
BEGIN
    UPDATE `tbl_signosvitales` SET `resultado` = $resultado, `hora` = $hora, `idHistoriaClinica` = $idHistoriaClinica, `idValoracion` = $idValoracion WHERE `idSignosVitales` = $idSignosVitales;
    END$$

DROP PROCEDURE IF EXISTS `spModificarSolicitud`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarSolicitud`(IN $idSolicitud INT, IN $Descripcion varchar(60), IN $CuentaUsuario_idUsuario int(11))
BEGIN
    UPDATE `tbl_solicitud` SET `Descripcion` = $Descripcion, `CuentaUsuario_idUsuario` = $CuentaUsuario_idUsuario WHERE `idSolicitud` = $idSolicitud;
    END$$

DROP PROCEDURE IF EXISTS `spModificarTestigo`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarTestigo`(IN $idTestigo INT, IN $idReporteAPH int(11), IN $nombreTestigo varchar(45), IN $identificacionTestigo varchar(45))
BEGIN
    UPDATE `tbl_testigo` SET `idReporteAPH` = $idReporteAPH, `nombreTestigo` = $nombreTestigo, `identificacionTestigo` = $identificacionTestigo WHERE `idTestigo` = $idTestigo;
    END$$

DROP PROCEDURE IF EXISTS `spModificarTipoafiliacion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarTipoafiliacion`(IN $idTipoAfiliacion INT, IN $descripcionAfiliacion varchar(45))
BEGIN
    UPDATE `tbl_tipoafiliacion` SET `descripcionAfiliacion` = $descripcionAfiliacion WHERE `idTipoAfiliacion` = $idTipoAfiliacion;
    END$$

DROP PROCEDURE IF EXISTS `spModificarTipoantecedente`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarTipoantecedente`(IN $idTipoAntecedente INT, IN $descripcion varchar(100))
BEGIN
    UPDATE `tbl_tipoantecedente` SET `descripcion` = $descripcion WHERE `idTipoAntecedente` = $idTipoAntecedente;
    END$$

DROP PROCEDURE IF EXISTS `spModificarTipoaseguramiento`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarTipoaseguramiento`(IN $idTipoAseguramiento INT, IN $DescripcionTipoAseguramiento varchar(45))
BEGIN
    UPDATE `tbl_tipoaseguramiento` SET `DescripcionTipoAseguramiento` = $DescripcionTipoAseguramiento WHERE `idTipoAseguramiento` = $idTipoAseguramiento;
    END$$

DROP PROCEDURE IF EXISTS `spModificarTipoasignacion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarTipoasignacion`(IN $idTipoAsignacion INT, IN $descripcionTipoasignacion varchar(45))
BEGIN
    UPDATE `tbl_tipoasignacion` SET `descripcionTipoasignacion` = $descripcionTipoasignacion WHERE `idTipoAsignacion` = $idTipoAsignacion;
    END$$

DROP PROCEDURE IF EXISTS `spModificarTipocup`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarTipocup`(IN $idTipoCup INT, IN $descripcionCUP varchar(45))
BEGIN
    UPDATE `tbl_tipocup` SET `descripcionCUP` = $descripcionCUP WHERE `idTipoCup` = $idTipoCup;
    END$$

DROP PROCEDURE IF EXISTS `spModificarTipodevolucion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarTipodevolucion`(IN $idTipoDevolucion INT, IN $descripcionDevolucion varchar(45))
BEGIN
    UPDATE `tbl_tipodevolucion` SET `descripcionDevolucion` = $descripcionDevolucion WHERE `idTipoDevolucion` = $idTipoDevolucion;
    END$$

DROP PROCEDURE IF EXISTS `spModificarTipodocumento`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarTipodocumento`(IN $idTipoDocumento INT, IN $descripcionTdocumento varchar(45))
BEGIN
    UPDATE `tbl_tipodocumento` SET `descripcionTdocumento` = $descripcionTdocumento WHERE `idTipoDocumento` = $idTipoDocumento;
    END$$

DROP PROCEDURE IF EXISTS `spModificarTipoevento`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarTipoevento`(IN $idTipoEvento INT, IN $descripcionTipoEvento varchar(45))
BEGIN
    UPDATE `tbl_tipoevento` SET `descripcionTipoEvento` = $descripcionTipoEvento WHERE `idTipoEvento` = $idTipoEvento;
    END$$

DROP PROCEDURE IF EXISTS `spModificarTipoevento_novedadreporteinicial`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarTipoevento_novedadreporteinicial`(IN $idTipoEventoNovedadReporteInicial INT, IN $idTipoEvento int(11), IN $idNovedad int(11))
BEGIN
    UPDATE `tbl_tipoevento_novedadreporteinicial` SET `idTipoEvento` = $idTipoEvento, `idNovedad` = $idNovedad WHERE `idTipoEventoNovedadReporteInicial` = $idTipoEventoNovedadReporteInicial;
    END$$

DROP PROCEDURE IF EXISTS `spModificarTipoevento_reporteinicial`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarTipoevento_reporteinicial`(IN $idTipoEventoReporteInicial INT, IN $idReporteInicial int(11), IN $idTipoEvento int(11))
BEGIN
    UPDATE `tbl_tipoevento_reporteinicial` SET `idReporteInicial` = $idReporteInicial, `idTipoEvento` = $idTipoEvento WHERE `idTipoEventoReporteInicial` = $idTipoEventoReporteInicial;
    END$$

DROP PROCEDURE IF EXISTS `spModificarTipoexamenespecializado`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarTipoexamenespecializado`(IN $idTipoExamenEspecializado INT, IN $descripcion varchar(1000))
BEGIN
    UPDATE `tbl_tipoexamenespecializado` SET `descripcion` = $descripcion WHERE `idTipoExamenEspecializado` = $idTipoExamenEspecializado;
    END$$

DROP PROCEDURE IF EXISTS `spModificarTipoexamenfisico`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarTipoexamenfisico`(IN $idtipoExamenFisico INT, IN $descripcionExamenFisico varchar(500))
BEGIN
    UPDATE `tbl_tipoexamenfisico` SET `descripcionExamenFisico` = $descripcionExamenFisico WHERE `idtipoExamenFisico` = $idtipoExamenFisico;
    END$$

DROP PROCEDURE IF EXISTS `spModificarTipokit`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarTipokit`(IN $idTipoKit INT, IN $descripcionTipoKit varchar(50))
BEGIN
    UPDATE `tbl_tipokit` SET `descripcionTipoKit` = $descripcionTipoKit WHERE `idTipoKit` = $idTipoKit;
    END$$

DROP PROCEDURE IF EXISTS `spModificarTiponovedad`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarTiponovedad`(IN $idTipoNovedad INT, IN $descripcionTiponovedad varchar(45))
BEGIN
    UPDATE `tbl_tiponovedad` SET `descripcionTiponovedad` = $descripcionTiponovedad WHERE `idTipoNovedad` = $idTipoNovedad;
    END$$

DROP PROCEDURE IF EXISTS `spModificarTipoorigenatencion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarTipoorigenatencion`(IN $idTipoOrigenAtencion INT, IN $descripcionorigenAtencion varchar(100))
BEGIN
    UPDATE `tbl_tipoorigenatencion` SET `descripcionorigenAtencion` = $descripcionorigenAtencion WHERE `idTipoOrigenAtencion` = $idTipoOrigenAtencion;
    END$$

DROP PROCEDURE IF EXISTS `spModificarTipotratamiento`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarTipotratamiento`(IN $idTipoTratamiento INT, IN $Descripcion varchar(1000), IN $categoriaTratamientoAph varchar(45), IN $categoriaItemTratamiento varchar(45))
BEGIN
    UPDATE `tbl_tipotratamiento` SET `Descripcion` = $Descripcion, `categoriaTratamientoAph` = $categoriaTratamientoAph, `categoriaItemTratamiento` = $categoriaItemTratamiento WHERE `idTipoTratamiento` = $idTipoTratamiento;
    END$$

DROP PROCEDURE IF EXISTS `spModificarTipozona`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarTipozona`(IN $idTipoZona INT, IN $descripcionTipozona varchar(100))
BEGIN
    UPDATE `tbl_tipozona` SET `descripcionTipozona` = $descripcionTipozona WHERE `idTipoZona` = $idTipoZona;
    END$$

DROP PROCEDURE IF EXISTS `spModificarTratamientoaph`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarTratamientoaph`(IN $idtratamiento INT, IN $idReporteAPH int(11), IN $valor varchar(45), IN $idTipoTratamiento int(11))
BEGIN
    UPDATE `tbl_tratamientoaph` SET `idReporteAPH` = $idReporteAPH, `valor` = $valor, `idTipoTratamiento` = $idTipoTratamiento WHERE `idtratamiento` = $idtratamiento;
    END$$

DROP PROCEDURE IF EXISTS `spModificarTratamientodmc`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarTratamientodmc`(IN $idTratamiento INT, IN $descripcionTratamiento text, IN $fechaTratamiento date, IN $dosisTratamiento text, IN $idTipoTratamiento int(11), IN $idHistoriaClinica int(11))
BEGIN
    UPDATE `tbl_tratamientodmc` SET `descripcionTratamiento` = $descripcionTratamiento, `fechaTratamiento` = $fechaTratamiento, `dosisTratamiento` = $dosisTratamiento, `idTipoTratamiento` = $idTipoTratamiento, `idHistoriaClinica` = $idHistoriaClinica WHERE `idTratamiento` = $idTratamiento;
    END$$

DROP PROCEDURE IF EXISTS `spModificarTratamientodmcrecurso`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarTratamientodmcrecurso`(IN $TratamientoDmcRecurso INT, IN $idTratamientoDmc int(11), IN $idrecurso int(11))
BEGIN
    UPDATE `tbl_tratamientodmcrecurso` SET `idTratamientoDmc` = $idTratamientoDmc, `idrecurso` = $idrecurso WHERE `TratamientoDmcRecurso` = $TratamientoDmcRecurso;
    END$$

DROP PROCEDURE IF EXISTS `spModificarTriage`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarTriage`(IN $idTriage INT, IN $descripcionTriage varchar(45))
BEGIN
    UPDATE `tbl_triage` SET `descripcionTriage` = $descripcionTriage WHERE `idTriage` = $idTriage;
    END$$

DROP PROCEDURE IF EXISTS `spModificarTurno`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarTurno`(IN $idTurno INT, IN $horaInicioTurno time, IN $horaFinalTurno time)
BEGIN
    UPDATE `tbl_turno` SET `horaInicioTurno` = $horaInicioTurno, `horaFinalTurno` = $horaFinalTurno WHERE `idTurno` = $idTurno;
    END$$

DROP PROCEDURE IF EXISTS `spModificarTurnoprogramacion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarTurnoprogramacion`(IN $idTurnoProgramacion INT, IN $idTurno int(11), IN $idProgramacion int(11), IN $idPersona int(11))
BEGIN
    UPDATE `tbl_turnoprogramacion` SET `idTurno` = $idTurno, `idProgramacion` = $idProgramacion, `idPersona` = $idPersona WHERE `idTurnoProgramacion` = $idTurnoProgramacion;
    END$$

DROP PROCEDURE IF EXISTS `spModificarValoracion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarValoracion`(IN $idValoracion INT, IN $descripcionValoracion varchar(45))
BEGIN
    UPDATE `tbl_valoracion` SET `descripcionValoracion` = $descripcionValoracion WHERE `idValoracion` = $idValoracion;
    END$$

DROP PROCEDURE IF EXISTS `spModificarViacomunicacioncontrolmedico`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarViacomunicacioncontrolmedico`(IN $idViaComunicacionControlMedico INT, IN $idReporteAPH int(11), IN $viaComunicacion varchar(45))
BEGIN
    UPDATE `tbl_viacomunicacioncontrolmedico` SET `idReporteAPH` = $idReporteAPH, `viaComunicacion` = $viaComunicacion WHERE `idViaComunicacionControlMedico` = $idViaComunicacionControlMedico;
    END$$

DROP PROCEDURE IF EXISTS `spModificarVista`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarVista`(IN $idVista INT, IN $descripcionVista varchar(70), IN $urlVista varchar(250), IN $iconoVista varchar(45), IN $estado varchar(45))
BEGIN
    UPDATE `tbl_vista` SET `descripcionVista` = $descripcionVista, `urlVista` = $urlVista, `iconoVista` = $iconoVista, `estado` = $estado WHERE `idVista` = $idVista;
    END$$

DROP PROCEDURE IF EXISTS `spModificarZona`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spModificarZona`(IN $idZona INT, IN $descripcionZona varchar(45), IN $idTipoZona int(11))
BEGIN
    UPDATE `tbl_zona` SET `descripcionZona` = $descripcionZona, `idTipoZona` = $idTipoZona WHERE `idZona` = $idZona;
    END$$

DROP PROCEDURE IF EXISTS `spPaginacionHC`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spPaginacionHC`(
    IN $nameTable VARCHAR(100),
    IN $listFields VARCHAR(1000),
    IN $limitPagination INT,
    IN $page INT,
    IN $nameColumnDateTime VARCHAR(100),
    IN $filterDateTimeStart VARCHAR(15),
    IN $filterDateTimeEnd VARCHAR(15),
    IN $nameColumnFilter VARCHAR(100),
    IN $filter VARCHAR(100),
    IN $numDataFilter INT,
    IN $nameColumnOrderBy VARCHAR(100),
    IN $orderBy VARCHAR(5),
    IN $retornarRegistros TINYINT(1),
    IN $columnaId VARCHAR(100),
    IN $id TINYINT(1)
)
BEGIN
  -- VARIABLES LOCALES
  DECLARE _WHERE  VARCHAR(45) DEFAULT '';
  DECLARE _AND  VARCHAR(45) DEFAULT '';
  DECLARE _limitStart INT DEFAULT 0;
  DECLARE _limit VARCHAR(100) DEFAULT '';
  DECLARE _filterDateTime VARCHAR(100) DEFAULT '';
  DECLARE _filter VARCHAR(100) DEFAULT '';
  DECLARE _filterOrderBy  VARCHAR(100) DEFAULT '';
  DECLARE _JOIN  VARCHAR(100) DEFAULT '';
  DECLARE _distinct VARCHAR(10) DEFAULT '';

  -- Filtrar por rango fecha
  IF $nameColumnDateTime <> '' THEN
    IF  $filterDateTimeStart <> '' AND  $filterDateTimeEnd <> '' THEN
      SET _filterDateTime = CONCAT('and ',$nameColumnDateTime, ' BETWEEN ', '"', $filterDateTimeStart,'"', ' AND ', '"', $filterDateTimeEnd,'"');
    END IF;
  END IF;

  -- Filtrar en un campo especifico de la tabla
  IF $nameColumnFilter <> '' AND  $filter <> '' THEN
# PROCEDIMIENTO:
    CREATE TEMPORARY TABLE IF NOT EXISTS tbl_filtro(busqueda VARCHAR(100));
    CALL spFilterPagination($filter, $numDataFilter);
    SET _distinct = ' DISTINCT ';
    SET _JOIN = CONCAT(' A INNER JOIN tbl_filtro B ON A.', $nameColumnFilter, ' LIKE CONCAT("%", B.busqueda, "%") ');
  END IF;

  -- Ordenar resultados(ASC, DESC) por una columna determinada
  IF $nameColumnOrderBy <> ''  THEN
    SET _filterOrderBy = CONCAT(' ORDER BY ', $nameColumnOrderBy, ' ', $orderBy);
  END IF;

  -- Validar si hay algun filtro

    SET _WHERE = CONCAT(' WHERE ',$columnaId,' = ', $id, ' ');
  -- Limitar resultados
  IF ($limitPagination <> 0 AND $page <> 0) AND  $retornarRegistros = 1 THEN
    -- Calcular desde donde se empieza el limite de esta consulta
    SET _limitStart = ($limitPagination * $page) - $limitPagination;
    SET _limit = CONCAT(' LIMIT ', _limitStart, ',', $limitPagination);
  END IF;
  -- Creamos una variable que almacena consulta dinámica
  IF $retornarRegistros = 1 THEN
    SET @query = CONCAT(
        'SELECT ', _distinct, $listFields,
        ' FROM ', $nameTable, _JOIN, _WHERE , _filterDateTime, _filterOrderBy, _limit, ';'
    );
  ELSE
    SET @query = CONCAT(
        'SELECT COUNT(*)',
        ' FROM ', $nameTable, _JOIN, _WHERE, _filterDateTime, _filterOrderBy,  ';'
    );
  END IF;

  #SELECT @query;

  -- Preparamos el objete Statement a partir del query
  PREPARE smpt FROM @query;

  -- Ejecutamos el Statement
  EXECUTE smpt;

  -- Liberamos la memoria
  DEALLOCATE PREPARE smpt;
END$$

DROP PROCEDURE IF EXISTS `spPagination`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spPagination`(
  IN `$nameTable` VARCHAR(100),
  IN `$listFields` VARCHAR(1000),
  IN `$limitPagination` INT,
  IN `$page` INT,
  IN `$nameColumnDateTime` VARCHAR(100),
  IN `$filterDateTimeStart` VARCHAR(15),
  IN `$filterDateTimeEnd` VARCHAR(15),
  IN `$nameColumnFilter` VARCHAR(100),
  IN `$filter` VARCHAR(100),
  IN `$numDataFilter` INT,
  IN `$nameColumnOrderBy` VARCHAR(100),
  IN `$orderBy` VARCHAR(5),
  IN `$retornarRegistros` TINYINT(1)
)
BEGIN
  -- VARIABLES LOCALES
  DECLARE _WHERE  VARCHAR(45) DEFAULT '';
  DECLARE _AND  VARCHAR(45) DEFAULT '';
  DECLARE _limitStart INT DEFAULT 0;
  DECLARE _limit VARCHAR(100) DEFAULT '';
  DECLARE _filterDateTime VARCHAR(100) DEFAULT '';
  DECLARE _filter VARCHAR(100) DEFAULT '';
  DECLARE _filterOrderBy  VARCHAR(100) DEFAULT '';
  DECLARE _JOIN  VARCHAR(100) DEFAULT '';
  DECLARE _distinct VARCHAR(10) DEFAULT '';

  -- Filtrar por rango fecha
  IF $nameColumnDateTime <> '' THEN
    IF  $filterDateTimeStart <> '' AND  $filterDateTimeEnd <> '' THEN
      SET _filterDateTime = CONCAT($nameColumnDateTime, ' BETWEEN ', '"', $filterDateTimeStart,'"', ' AND ', '"', $filterDateTimeEnd,'"');
    END IF;
  END IF;

  -- Filtrar en un campo especifico de la tabla
  IF $nameColumnFilter <> '' AND  $filter <> '' THEN
# PROCEDIMIENTO:
    CREATE TEMPORARY TABLE IF NOT EXISTS tbl_filtro(busqueda VARCHAR(100));
    CALL spFilterPagination($filter, $numDataFilter);
    SET _distinct = ' DISTINCT ';
    SET _JOIN = CONCAT(' A INNER JOIN tbl_filtro B ON A.', $nameColumnFilter, ' LIKE CONCAT("%", B.busqueda, "%") ');
  END IF;

  -- Ordenar resultados(ASC, DESC) por una columna determinada
  IF $nameColumnOrderBy <> ''  THEN
    SET _filterOrderBy = CONCAT(' ORDER BY ', $nameColumnOrderBy, ' ', $orderBy);
  END IF;

  -- Validar si hay algun filtro
  IF _filterDateTime <> '' OR _filter <> '' OR _filterOrderBy THEN
    SET _WHERE = ' WHERE ';
  END IF;

  -- Limitar resultados
  IF ($limitPagination <> 0 AND $page <> 0) AND  $retornarRegistros = 1 THEN
    -- Calcular desde donde se empieza el limite de esta consulta
    SET _limitStart = ($limitPagination * $page) - $limitPagination;
    SET _limit = CONCAT(' LIMIT ', _limitStart, ',', $limitPagination);
  END IF;
  -- Creamos una variable que almacena consulta dinámica
  IF $retornarRegistros = 1 THEN
    SET @query = CONCAT(
      'SELECT ', _distinct, $listFields,
      ' FROM ', $nameTable, _JOIN, _WHERE, _filterDateTime, _filterOrderBy, _limit, ';'
    );
  ELSE
    SET @query = CONCAT(
      'SELECT COUNT(*)',
      ' FROM ', $nameTable, _JOIN, _WHERE, _filterDateTime, _filterOrderBy,  ';'
    );
  END IF;

  # SELECT @query;

  -- Preparamos el objete Statement a partir del query
  PREPARE smpt FROM @query;

  -- Ejecutamos el Statement
  EXECUTE smpt;

  -- Liberamos la memoria
  DEALLOCATE PREPARE smpt;
END$$

DROP PROCEDURE IF EXISTS `spPersonalReporteAPH`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spPersonalReporteAPH`($idAsignacionPersonal INT)
BEGIN
  SELECT
  CONCAT(
    IFNULL(B.primerNombre, ''), ' ',
    IFNULL(B.segundoNombre, ''), ' ',
    IFNULL(B.primerApellido, ''), ' ',
    IFNULL(B.segundoApellido, '')
  ) nombreCompleto,
  D.descripcionRol
  FROM  tbl_detalleasignacion  A INNER JOIN tbl_persona B
  ON A.idPersona  = B.idPersona
  INNER JOIN tbl_cuentausuario C
  ON B.idPersona = C.idPersona
  INNER JOIN tbl_rol D
  ON D.idRol = C.idRol
  WHERE A.idAsignacionPersonal = $idAsignacionPersonal;
END$$

DROP PROCEDURE IF EXISTS `spRegistarNotasEnfermeria`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistarNotasEnfermeria`()
begin
insert into  tbl_notaEnfermeria(descripcion,idPersona,idProcedimiento)
values(descripcion,idPersona,idProcedimiento);
end$$

DROP PROCEDURE IF EXISTS `spRegistrarAcompanante`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarAcompanante`(IN $lugarExpedicionDocumentoA varchar(45), IN $parentescoA varchar(45), IN $identificacionA varchar(45), IN $nombreA varchar(45), IN $telefonoA varchar(45), IN $apellidoA varchar(45))
BEGIN
    INSERT INTO `tbl_acompanante`(`lugarExpedicionDocumentoA`, `parentescoA`, `identificacionA`, `nombreA`, `telefonoA`, `apellidoA`) VALUES ($lugarExpedicionDocumentoA, $parentescoA, $identificacionA, $nombreA, $telefonoA, $apellidoA);
    END$$

DROP PROCEDURE IF EXISTS `spRegistrarAfectadoaccidentetransito`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarAfectadoaccidentetransito`(IN $descripcionAfectadoAccidenteTransito varchar(45), IN $estadoTabla varchar(50))
BEGIN
    INSERT INTO `tbl_afectadoaccidentetransito`(`descripcionAfectadoAccidenteTransito`, `estadoTabla`) VALUES ($descripcionAfectadoAccidenteTransito, $estadoTabla);
    END$$

DROP PROCEDURE IF EXISTS `spRegistrarAllAutorizacionMedicamento`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarAllAutorizacionMedicamento`(
$idUsuarioParamedico INT,
$idUsuarioMedico INT,
$idReporteAPH INT,
$idMedicamento INT,
$descripcionAutorizacion TEXT,
$observacionRespuestaAutorizacion TEXT,
$estadoEvaluacion VARCHAR(45),
$fechaEnvio DATETIME,
$fechaEvaluacion DATETIME,
$cedulaPaciente VARCHAR(45))
BEGIN
IF $idUsuarioMedico = 0 THEN
INSERT INTO `tbl_autorizacion`( `idUsuarioParamedico`, `idReporteAPH`, `idMedicamento`, `descripcionAutorizacion`, `observacionRespuestaAutorizacion`, `estadoEvaluacion`, `fechaEnvio`, `fechaEvaluacion`, `cedulaPaciente`)
VALUES($idUsuarioParamedico,$idReporteAPH,$idMedicamento,$descripcionAutorizacion,$observacionRespuestaAutorizacion,$estadoEvaluacion,$fechaEnvio,$fechaEvaluacion,$cedulaPaciente);
DELETE FROM `tbl_temporalautorizacion` WHERE `idParamedico` = $idUsuarioParamedico AND `cedulaPaciente` = $cedulaPaciente;
ELSE
INSERT INTO `tbl_autorizacion`( `idUsuarioParamedico`, `idUsuarioMedico`, `idReporteAPH`, `idMedicamento`, `descripcionAutorizacion`, `observacionRespuestaAutorizacion`, `estadoEvaluacion`, `fechaEnvio`, `fechaEvaluacion`, `cedulaPaciente`)
VALUES($idUsuarioParamedico,$idUsuarioMedico,$idReporteAPH,$idMedicamento,$descripcionAutorizacion,$observacionRespuestaAutorizacion,$estadoEvaluacion,$fechaEnvio,$fechaEvaluacion,$cedulaPaciente);
DELETE FROM `tbl_temporalautorizacion` WHERE `idParamedico` = $idUsuarioParamedico AND `cedulaPaciente` = $cedulaPaciente;
END IF;
END$$

DROP PROCEDURE IF EXISTS `spRegistrarAllAutorizacionTratamiento`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarAllAutorizacionTratamiento`(
$idUsuarioParamedico INT,
$idUsuarioMedico INT,
$idReporteAPH INT,
$idTipoTratamiento INT,
$descripcionAutorizacion TEXT,
$observacionRespuestaAutorizacion TEXT,
$estadoEvaluacion VARCHAR(45),
$fechaEnvio DATETIME,
$fechaEvaluacion DATETIME,
$cedulaPaciente VARCHAR(45))
BEGIN
IF $idUsuarioMedico = 0 THEN
INSERT INTO `tbl_autorizacion`( `idUsuarioParamedico`, `idReporteAPH`, `idTipoTratamiento`, `descripcionAutorizacion`, `observacionRespuestaAutorizacion`, `estadoEvaluacion`, `fechaEnvio`, `fechaEvaluacion`, `cedulaPaciente`)
VALUES($idUsuarioParamedico,$idReporteAPH,$idTipoTratamiento,$descripcionAutorizacion,$observacionRespuestaAutorizacion,$estadoEvaluacion,$fechaEnvio,$fechaEvaluacion,$cedulaPaciente);
ELSE
INSERT INTO `tbl_autorizacion`( `idUsuarioParamedico`, `idUsuarioMedico`, `idReporteAPH`, `idTipoTratamiento`, `descripcionAutorizacion`, `observacionRespuestaAutorizacion`, `estadoEvaluacion`, `fechaEnvio`, `fechaEvaluacion`, `cedulaPaciente`)
VALUES($idUsuarioParamedico,$idUsuarioMedico,$idReporteAPH,$idTipoTratamiento,$descripcionAutorizacion,$observacionRespuestaAutorizacion,$estadoEvaluacion,$fechaEnvio,$fechaEvaluacion,$cedulaPaciente);
end if;
DELETE FROM `tbl_temporalautorizacion` WHERE `idParamedico` = $idUsuarioParamedico AND `cedulaPaciente` = $cedulaPaciente;
END$$

DROP PROCEDURE IF EXISTS `spRegistrarAmbulancia`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarAmbulancia`(IN $tipoAmbulancia varchar(45), IN $placaAmbulancia varchar(45), IN $estadoTabla varchar(45))
BEGIN
    INSERT INTO `tbl_ambulancia`(`tipoAmbulancia`, `placaAmbulancia`, `estadoTabla`) VALUES ($tipoAmbulancia, $placaAmbulancia, $estadoTabla);
    END$$

DROP PROCEDURE IF EXISTS `spRegistrarAntecedenteaph`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarAntecedenteaph`(IN $idTipoAntecendente int(11), IN $idReporteAPH int(11), IN $especificacion varchar(200))
BEGIN
    INSERT INTO `tbl_antecedenteaph`(`idTipoAntecendente`, `idReporteAPH`, `especificacion`) VALUES ($idTipoAntecendente, $idReporteAPH, $especificacion);
    END$$

DROP PROCEDURE IF EXISTS `spRegistrarAntecedentedmc`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarAntecedentedmc`(IN $descripcionAntecedente text, IN $idTipoAntecedente int(11), IN $idHistoriaClinica int(11))
BEGIN
    INSERT INTO `tbl_antecedentedmc`(`descripcionAntecedente`, `idTipoAntecedente`, `idHistoriaClinica`) VALUES ($descripcionAntecedente, $idTipoAntecedente, $idHistoriaClinica);
    END$$

DROP PROCEDURE IF EXISTS `spRegistrarAntecedentesDmc`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarAntecedentesDmc`(IN descripcionAntecedente TEXT,IN	idTipoAntecedente  INT(11),IN idHistoriaClinica INT(11))
begin
  insert into tbl_antecedentedmc(descripcionAntecedente,idTipoAntecedente,idHistoriaClinica)
  values(descripcionAntecedente,idTipoAntecedente,idHistoriaClinica);
end$$

DROP PROCEDURE IF EXISTS `spRegistrarAsignacionkit`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarAsignacionkit`(IN $fechaHoraAsignacion datetime, IN $estadoTablaAsignacionKit varchar(45), IN $idPersona int(11), IN $idAmbulancia int(11), IN $idTipoAsignacion int(11), IN $idPaciente int(11))
BEGIN
    INSERT INTO `tbl_asignacionkit`(`fechaHoraAsignacion`, `estadoTablaAsignacionKit`, `idPersona`, `idAmbulancia`, `idTipoAsignacion`, `idPaciente`) VALUES ($fechaHoraAsignacion, $estadoTablaAsignacionKit, $idPersona, $idAmbulancia, $idTipoAsignacion, $idPaciente);
    END$$

DROP PROCEDURE IF EXISTS `spRegistrarAsignacionpersonal`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarAsignacionpersonal`(
IN $idAmbulancia int,
IN $fechaHoraAsignacion datetime,
IN $estadoTablaAsignacion varchar(45),
IN $longitud varchar(45),
IN $latitud varchar(45)
)
BEGIN
INSERT INTO `tbl_asignacionpersonal`(`idAmbulancia`, `fechaHoraAsignacion`, `estadoTablaAsignacion`, `longitud`, `latitud`) VALUES ($idAmbulancia, $fechaHoraAsignacion, $estadoTablaAsignacion, $longitud, $latitud);
END$$

DROP PROCEDURE IF EXISTS `spRegistrarAutorizacion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarAutorizacion`(IN $idUsuarioParamedico int(11), IN $idUsuarioMedico int(11), IN $idReporteAPH int(11), IN $idTipoTratamiento int(11), IN $idMedicamento int(11), IN $descripcionAutorizacion text, IN $observacionRespuestaAutorizacion text, IN $estadoEvaluacion varchar(45), IN $fechaEnvio datetime, IN $fechaEvaluacion datetime, IN $cedulaPaciente varchar(45))
BEGIN
    INSERT INTO `tbl_autorizacion`(`idUsuarioParamedico`, `idUsuarioMedico`, `idReporteAPH`, `idTipoTratamiento`, `idMedicamento`, `descripcionAutorizacion`, `observacionRespuestaAutorizacion`, `estadoEvaluacion`, `fechaEnvio`, `fechaEvaluacion`, `cedulaPaciente`) VALUES ($idUsuarioParamedico, $idUsuarioMedico, $idReporteAPH, $idTipoTratamiento, $idMedicamento, $descripcionAutorizacion, $observacionRespuestaAutorizacion, $estadoEvaluacion, $fechaEnvio, $fechaEvaluacion, $cedulaPaciente);
    END$$

DROP PROCEDURE IF EXISTS `spRegistrarAutorizacionMedicalizada`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarAutorizacionMedicalizada`(
IN `$TIPO` VARCHAR(45),
IN `$idParamedico` INT,
IN `$idMedico` INT,
IN `$id` INT,
IN `$descripcion` VARCHAR(200),
IN `$cedula` VARCHAR(20),
IN `$fecha` DATETIME
)
BEGIN
IF `$TIPO` = 'TRATAMIENTO' THEN
INSERT INTO tbl_temporalautorizacion (idParamedico,idMedico,idTipoTratamiento,descripcionAutorizacion,observacionRespuestaAutorizacion,cedulaPaciente,estadoEvaluacion,fechaEnvio,fechaEvaluacion)
VALUES($idParamedico,$idMedico,$id,$descripcion,'Aprobado desde una TAM',$cedula,'Aprobada',$fecha,$fecha);
ELSEIF `$TIPO` = 'MEDICAMENTO' THEN
INSERT INTO tbl_temporalautorizacion (idParamedico,idMedico,idMedicamento,descripcionAutorizacion,observacionRespuestaAutorizacion,cedulaPaciente,estadoEvaluacion,fechaEnvio,fechaEvaluacion)
VALUES($idParamedico,$idMedico,$id,$descripcion,'Aprobado desde una TAM',$cedula,'Aprobada',$fecha,$fecha);
END IF;
END$$

DROP PROCEDURE IF EXISTS `spRegistrarCategoriaautorizacion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarCategoriaautorizacion`(IN $descripcion varchar(45), IN $estadoTabla varchar(50))
BEGIN
    INSERT INTO `tbl_categoriaautorizacion`(`descripcion`, `estadoTabla`) VALUES ($descripcion, $estadoTabla);
    END$$

DROP PROCEDURE IF EXISTS `spRegistrarCategoriarecurso`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarCategoriarecurso`(IN $descripcionCategoriarecurso varchar(45), IN $estadoTabla varchar(50))
BEGIN
    INSERT INTO `tbl_categoriarecurso`(`descripcionCategoriarecurso`, `estadoTabla`) VALUES ($descripcionCategoriarecurso, $estadoTabla);
    END$$

DROP PROCEDURE IF EXISTS `spRegistrarCertificadoatencion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarCertificadoatencion`(IN $descripcionCertificadoAtencion varchar(45), IN $estadoTabla varchar(50))
BEGIN
    INSERT INTO `tbl_certificadoatencion`(`descripcionCertificadoAtencion`, `estadoTabla`) VALUES ($descripcionCertificadoAtencion, $estadoTabla);
    END$$

DROP PROCEDURE IF EXISTS `spRegistrarChat`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarChat`(IN $idReceptorInicial INT, IN $idUsuarioExterno INT)
BEGIN
  INSERT INTO `tbl_chat`(`idReceptorInicial`, `idUsuarioExterno`)
  VALUES ($idReceptorInicial, $idUsuarioExterno);
  SELECT MAX(idChat) FROM tbl_chat;
END$$

DROP PROCEDURE IF EXISTS `spRegistrarCie10`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarCie10`(IN $codigoCIE10 varchar(45), IN $descripcionCIE10 varchar(1000), IN $estadoTabla varchar(50))
BEGIN
    INSERT INTO `tbl_cie10`(`codigoCIE10`, `descripcionCIE10`, `estadoTabla`) VALUES ($codigoCIE10, $descripcionCIE10, $estadoTabla);
    END$$

DROP PROCEDURE IF EXISTS `spRegistrarCita`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarCita`(
IN $estado varchar(45),
IN $direc varchar(45),
IN $fecha date,
IN $horaI time,
IN $horaF time,
IN $telF1 varchar(45),
IN $telF2 varchar(45),
IN $id int(11),
IN $idCup int(11),
IN $idZona int(11),
IN $fechaRegistro date
)
BEGIN
INSERT INTO `tbl_cita` (
estadoTablaCita, direccionCita, fechaCita,
horaInicial, horaFinal, telefonoFijo1,
telefonoFijo2, idPaciente, idCUP,
idZona, fechaRegistro
)
VALUES
(
$estado, $direc, $fecha, $horaI, $horaF,
$telF1, $telF2, $id, $idCup, $idZona,$fechaRegistro
);
END$$

DROP PROCEDURE IF EXISTS `spRegistrarCita_programacion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarCita_programacion`(IN $idCita int(11), IN $idTurnoProgramacion int(11))
BEGIN
    INSERT INTO `tbl_cita_programacion`(`idCita`, `idTurnoProgramacion`) VALUES ($idCita, $idTurnoProgramacion);
    END$$

DROP PROCEDURE IF EXISTS `spRegistrarCodigoReestablecer`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarCodigoReestablecer`(
    IN $email varchar(50), IN $codigo varchar(50), IN $idUsuario int(11)
)
BEGIN
  INSERT INTO `tbl_restablecer`(`email`, `codigo`, `idUsuario`,estado) VALUES ($email, $codigo, $idUsuario,'Activo');
END$$

DROP PROCEDURE IF EXISTS `spRegistrarConfiguracion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarConfiguracion`(IN $cantidadCitasDia int(11), IN $cantidadCitasMes int(11), IN $descripcionConfiguracion varchar(45), IN $fechaConfiguracion timestamp, IN $estadoTabla varchar(50))
BEGIN
    INSERT INTO `tbl_configuracion`(`cantidadCitasDia`, `cantidadCitasMes`, `descripcionConfiguracion`, `fechaConfiguracion`, `estadoTabla`) VALUES ($cantidadCitasDia, $cantidadCitasMes, $descripcionConfiguracion, $fechaConfiguracion, $estadoTabla);
    END$$

DROP PROCEDURE IF EXISTS `spRegistrarCuentausuario`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarCuentausuario`(IN $idPersona int(11), IN $usuario varchar(100), IN $clave varchar(50), IN $idRol int(11))
BEGIN
    INSERT INTO `tbl_cuentausuario`(`idPersona`, `usuario`, `clave`, `idRol`) VALUES ($idPersona, $usuario, $clave, $idRol);
    END$$

DROP PROCEDURE IF EXISTS `spRegistrarCuidadoantarribo`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarCuidadoantarribo`(IN $descripcionArribo varchar(45), IN $idReporteAPH int(11))
BEGIN
    INSERT INTO `tbl_cuidadoantarribo`(`descripcionArribo`, `idReporteAPH`) VALUES ($descripcionArribo, $idReporteAPH);
    END$$

DROP PROCEDURE IF EXISTS `spRegistrarCup`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarCup`(IN $nombreCUP varchar(1000), IN $idConfiguracion int(11), IN $idTipoCup int(11), IN $codigoCup varchar(45), IN $estadoTabla varchar(50))
BEGIN
    INSERT INTO `tbl_cup`(`nombreCUP`, `idConfiguracion`, `idTipoCup`, `codigoCup`, `estadoTabla`) VALUES ($nombreCUP, $idConfiguracion, $idTipoCup, $codigoCup, $estadoTabla);
    END$$

DROP PROCEDURE IF EXISTS `spRegistrarCup3`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarCup3`(IN `nombreCUP` VARCHAR(1000), IN `idConfiguracion` INT, IN `idTipoCup` INT)
BEGIN
 INSERT INTO `tbl_cup`(`nombreCUP`, `idConfiguracion`, `idTipoCup`) VALUES ($nombreCUP, $idConfiguracion, $idTipoCup);
END$$

DROP PROCEDURE IF EXISTS `spRegistrarDesfibrilacion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarDesfibrilacion`(IN $idReporteAPH int(11), IN $horaDesfibrilacion time, IN $joules float)
BEGIN
    INSERT INTO `tbl_desfibrilacion`(`idReporteAPH`, `horaDesfibrilacion`, `joules`) VALUES ($idReporteAPH, $horaDesfibrilacion, $joules);
    END$$

DROP PROCEDURE IF EXISTS `spRegistrarDespacho`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarDespacho`(
    IN $idReporteInicial int,
    IN $idAmbulancia int,
    IN $fechaHoraDespacho datetime,
    IN $estadoDespacho varchar(50),
    IN $longitudEmergencia varchar(200),
    IN $latitudEmergencia varchar(200),
    IN $idPersona int
    )
BEGIN
  INSERT INTO `tbl_despacho`(`idReporteInicial`, `idAmbulancia`, `fechaHoraDespacho`, `estadoDespacho`, `longitudEmergencia`, `latitudEmergencia`,`idPersona`) VALUES ($idReporteInicial, $idAmbulancia, $fechaHoraDespacho, $estadoDespacho, $longitudEmergencia, $latitudEmergencia, $idPersona);
  SELECT MAX(idDespacho) idDespacho FROM `tbl_despacho`;
END$$

DROP PROCEDURE IF EXISTS `spRegistrarDetalleasignacion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarDetalleasignacion`(
IN $idAsignacionPersonal int,
IN $idPersona int,
IN $estadoTabla varchar(50),
IN $cargoPersona varchar(50) )
BEGIN
  INSERT INTO `tbl_detalleasignacion`(`idAsignacionPersonal`, `idPersona`, `estadoTabla`,`cargoPersona`) VALUES ($idAsignacionPersonal, $idPersona, $estadoTabla, $cargoPersona);
END$$

DROP PROCEDURE IF EXISTS `spRegistrarDetalleCita`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarDetalleCita`(IN $idCita INT, IN $idProgramacion INT)
BEGIN
  INSERT INTO tbl_cita_programacion (idCita, idTurnoProgramacion)
  VALUES ($idCita, $idProgramacion);
END$$

DROP PROCEDURE IF EXISTS `spRegistrarDetallekit`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarDetallekit`(IN $cantidadAsignada int(11), IN $cantidadFinal int(11), IN $idrecurso int(11), IN $idAsignacion int(11))
BEGIN
    INSERT INTO `tbl_detallekit`(`cantidadAsignada`, `cantidadFinal`, `idrecurso`, `idAsignacion`) VALUES ($cantidadAsignada, $cantidadFinal, $idrecurso, $idAsignacion);
    END$$

DROP PROCEDURE IF EXISTS `spRegistrarDetalletratamientodmcrecurso`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarDetalletratamientodmcrecurso`(IN $idRecurso INT(11), IN $idTratamiento int(11))
BEGIN
  INSERT INTO `tbl_detalletratamientodmcrecurso`(`idRecurso`, `idTratamiento`) VALUES ($idRecurso, $idTratamiento);
END$$

DROP PROCEDURE IF EXISTS `spRegistrarDetalleTratamientoEquipoBiomedico`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarDetalleTratamientoEquipoBiomedico`(IN descripcion VARCHAR(50),IN idTratamiento INT(11))
begin
  insert into tbl_equipobiomedico(descripcion,idTratamiento) values(descripcion,idTratamiento);
end$$

DROP PROCEDURE IF EXISTS `spRegistrarDetalleTratamientoRecurso`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarDetalleTratamientoRecurso`(
  IN idTratamiento VARCHAR(45),IN idRecurso VARCHAR(45)
)
begin
  insert into tbl_detalletratamientodmcrecurso(idTratamiento,idRecurso) values(idTratamiento,idRecurso);
end$$

DROP PROCEDURE IF EXISTS `spRegistrarDevolucion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarDevolucion`(IN $cantidad int(11), IN $fechaHoraDevolucion datetime, IN $estadoTablaDevolucion varchar(45), IN $idTipoDevolucion int(11), IN $idDetallekit int(11), IN $idPersona int(11))
BEGIN
    INSERT INTO `tbl_devolucion`(`cantidad`, `fechaHoraDevolucion`, `estadoTablaDevolucion`, `idTipoDevolucion`, `idDetallekit`, `idPersona`) VALUES ($cantidad, $fechaHoraDevolucion, $estadoTablaDevolucion, $idTipoDevolucion, $idDetallekit, $idPersona);
    END$$

DROP PROCEDURE IF EXISTS `spRegistrarDiagnostico`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarDiagnostico`(IN descripcion TEXT, IN idCIE10 INT(11) ,IN idHistoriaClinica  INT(11))
begin
  insert into tbl_diagnostico(descripcionDiagnostico,idCIE10,idHistoriaClinica)
  values(descripcion,idCIE10,idHistoriaClinica);
end$$

DROP PROCEDURE IF EXISTS `spRegistrarEnteexterno`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarEnteexterno`(IN $descripcionEnteExterno VARCHAR(45))
BEGIN
  INSERT INTO `tbl_enteexterno`(`descripcionEnteExterno`)
  VALUES ($descripcionEnteExterno);
END$$

DROP PROCEDURE IF EXISTS `spRegistrarEnteexterno_reporteinicial`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarEnteexterno_reporteinicial`(IN $idEnteExterno INT)
BEGIN
  INSERT INTO tbl_enteexterno_reporteinicial (idEnteExterno, idReporteInicial)
  VALUES ($idEnteExterno, fnUltimoReporteInicial());
END$$

DROP PROCEDURE IF EXISTS `spRegistrarEquipobiomedico`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarEquipobiomedico`(IN $descripcion varchar(50), IN $idTratamiento int(11))
BEGIN
    INSERT INTO `tbl_equipobiomedico`(`descripcion`, `idTratamiento`) VALUES ($descripcion, $idTratamiento);
    END$$

DROP PROCEDURE IF EXISTS `spRegistrarEspecialidad`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarEspecialidad`(IN $descripcionEspecialidad varchar(45), IN $estadoTabla varchar(50))
BEGIN
    INSERT INTO `tbl_especialidad`(`descripcionEspecialidad`, `estadoTabla`) VALUES ($descripcionEspecialidad, $estadoTabla);
    END$$

DROP PROCEDURE IF EXISTS `spRegistrarEstadopaciente`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarEstadopaciente`(IN $descripcionEstadoPaciente varchar(50), IN $estadoTabla varchar(50))
BEGIN
    INSERT INTO `tbl_estadopaciente`(`descripcionEstadoPaciente`, `estadoTabla`) VALUES ($descripcionEstadoPaciente, $estadoTabla);
    END$$

DROP PROCEDURE IF EXISTS `spRegistrarEstandarkit`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarEstandarkit`(IN $idRecurso int(11), IN $unidadMedida varchar(30), IN $stockminKit int(11), IN $idTipoKit int(11), IN $estadoTablaEstandarKit varchar(45))
BEGIN
    INSERT INTO `tbl_estandarkit`(`idRecurso`, `unidadMedida`, `stockminKit`, `idTipoKit`, `estadoTablaEstandarKit`) VALUES ($idRecurso, $unidadMedida, $stockminKit, $idTipoKit, $estadoTablaEstandarKit);
    END$$

DROP PROCEDURE IF EXISTS `spRegistrarEvaluacionAutorizacion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarEvaluacionAutorizacion`(
  $idAutorizacion INT,
  $idMedicoAutoriza INT,
  $descripcionEvaluacion TEXT,
  $respuestaEvaluacion VARCHAR(45),
  $fechaEvaluacion DATETIME
)
BEGIN
  UPDATE tbl_temporalautorizacion TA SET TA.observacionRespuestaAutorizacion = $descripcionEvaluacion, TA.estadoEvaluacion = $respuestaEvaluacion, TA.idMedico = $idMedicoAutoriza, TA.fechaEvaluacion = $fechaEvaluacion
  WHERE TA.idTemporalAutorizacion = $idAutorizacion;
END$$

DROP PROCEDURE IF EXISTS `spRegistrarExameneEspecializado`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarExameneEspecializado`(IN historiaClinica INT(11),IN observacion TEXT,IN idTipoExamenEspecializado INT(11),IN descripcion TEXT)
begin
  insert into tbl_examenespecializado(idHistoriaClinica,observaciones,idTipoExamenEspecializado,descripcion) values(historiaClinica,observacion,idTipoExamenEspecializado,descripcion);
end$$

DROP PROCEDURE IF EXISTS `spRegistrarExamenespecializado`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarExamenespecializado`(IN $observaciones text, IN $idTipoexamenespecializado int(11), IN $idHistoriaClinica int(11), IN $descripcion text)
BEGIN
    INSERT INTO `tbl_examenespecializado`(`observaciones`, `idTipoexamenespecializado`, `idHistoriaClinica`, `descripcion`) VALUES ($observaciones, $idTipoexamenespecializado, $idHistoriaClinica, $descripcion);
    END$$

DROP PROCEDURE IF EXISTS `spRegistrarExamenFisico`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarExamenFisico`(IN descripcion TEXT, IN idtipoExamenFisico INT(11) ,IN estado VARCHAR(45), IN idHistoriaClinica INT(11))
begin
  insert into tbl_examenfisicodmc(descripcionExamen,idtipoExamenFisico,estadoTablaExamen,idHistoriaClinica)
  values(descripcion,idTipoExamenFisico,estado,idHistoriaClinica);
end$$

DROP PROCEDURE IF EXISTS `spRegistrarExamenfisicoaph`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarExamenfisicoaph`(
  $horaExamenFisico DATETIME,
  $estadoRespiracion VARCHAR(45),
  $respiracion_min INT,
  $SpO2 FLOAT,
  $estadoPulso VARCHAR(45),
  $pulsaciones_min INT,
  $sistolica INT,
  $diastolica INT,
  $glucometria FLOAT,
  $conciencia VARCHAR(45),
  $glasgow VARCHAR(45),
  $estadoPupilaD VARCHAR(45),
  $estadoPupilaI VARCHAR(45),
  $gradoDilatacionPD FLOAT,
  $gradoDilatacionPI FLOAT,
  $estadoHemodinamico VARCHAR(45),
  $especificacionVerbal VARCHAR(45),
  $especificacionOcular VARCHAR(45),
  $especificacionMotor VARCHAR(45),
  $EspecifiqueExamenFisico TEXT
)
BEGIN
  DECLARE $PAM float;
  SET $PAM = (($diastolica * 2) + $sistolica) / 3;
  INSERT INTO `tbl_examenfisicoaph`(`horaExamenFisico`, `estadoRespiracion`, `respiracion_min`, `SpO2`, `estadoPulso`, `pulsaciones_min`, `sistolica`, `diastolica`, `PAM`, `glucometria`, `conciencia`, `glasgow`, `estadoPupilaD`, `estadoPupilaI`, `gradoDilatacionPD`, `gradoDilatacionPI`, `estadoHemodinamico`, `especificacionVerbal`, `especificacionOcular`, `especificacionMotor`, `EspecifiqueExamenFisico`)
  VALUES ($horaExamenFisico, $estadoRespiracion, $respiracion_min, $SpO2, $estadoPulso, $pulsaciones_min, $sistolica, $diastolica, $PAM, $glucometria, $conciencia, $glasgow, $estadoPupilaD, $estadoPupilaI, $gradoDilatacionPD, $gradoDilatacionPI, $estadoHemodinamico, $especificacionVerbal, $especificacionOcular, $especificacionMotor, $EspecifiqueExamenFisico);
  SELECT MAX(idExamenFisico)ultimoregistro
  FROM tbl_examenfisicoaph;
END$$

DROP PROCEDURE IF EXISTS `spRegistrarExamenfisicodmc`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarExamenfisicodmc`(IN $idHistoriaClinica int(11), IN $estadoTablaExamen varchar(45), IN $descripcionExamen text, IN $idtipoExamenFisico int(11))
BEGIN
    INSERT INTO `tbl_examenfisicodmc`(`idHistoriaClinica`, `estadoTablaExamen`, `descripcionExamen`, `idtipoExamenFisico`) VALUES ($idHistoriaClinica, $estadoTablaExamen, $descripcionExamen, $idtipoExamenFisico);
    END$$

DROP PROCEDURE IF EXISTS `spRegistrarFormulaMedica`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarFormulaMedica`(IN recomendacion VARCHAR(1000),IN idHistoriaClinica INT(11))
begin
  insert into tbl_formulamedica(recomendaciones,idHistoriaClinica) values(recomendacion,idHistoriaClinica);
end$$

DROP PROCEDURE IF EXISTS `spRegistrarFormulamedicamedicamentodmc`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarFormulamedicamedicamentodmc`(IN $idFormulamedica int(11), IN $idMedicamento int(11), IN $cantidadMedicamento int(11), IN $dosificacion varchar(100), IN $descripcion varchar(1000))
BEGIN
    INSERT INTO `tbl_formulamedicamedicamentodmc`(`idFormulamedica`, `idMedicamento`, `cantidadMedicamento`, `dosificacion`, `descripcion`) VALUES ($idFormulamedica, $idMedicamento, $cantidadMedicamento, $dosificacion, $descripcion);
    END$$

DROP PROCEDURE IF EXISTS `spRegistrarFormulaMedicamento`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarFormulaMedicamento`(IN dosificacion VARCHAR(100),IN descripcion VARCHAR(1000),IN cantidadMedicamento INT(11),IN idMedicamento INT(11),IN idFormulaMedica INT(11))
begin
  insert into tbl_formulamedicamedicamentodmc(dosificacion,descripcion,cantidadMedicamento,idMedicamento,idFormulaMedica) values(dosificacion,descripcion,cantidadMedicamento,idMedicamento,idFormulaMedica);
end$$

DROP PROCEDURE IF EXISTS `spRegistrarHistoriaclinica`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarHistoriaclinica`(IN $fechaAtencion date, IN $motivoAtencion text, IN $enfermedadActual text, IN $placaVehiculo varchar(45), IN $idTipoorigenatencion int(11), IN $idCitaprogramacion int(11), IN $idPaciente int(11), IN $evolucion text)
BEGIN
    INSERT INTO `tbl_historiaclinica`(`fechaAtencion`, `motivoAtencion`, `enfermedadActual`, `placaVehiculo`, `idTipoorigenatencion`, `idCitaprogramacion`, `idPaciente`, `evolucion`) VALUES ($fechaAtencion, $motivoAtencion, $enfermedadActual, $placaVehiculo, $idTipoorigenatencion, $idCitaprogramacion, $idPaciente, $evolucion);
    END$$

DROP PROCEDURE IF EXISTS `spRegistrarHistoriaClinicaDmc`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarHistoriaClinicaDmc`(IN fechaAtencion DATE, IN motivoAtencion TEXT, IN enfermedadActual TEXT,IN placaVehiculo VARCHAR(45), IN idTipoorigenAtencion INT(11),IN idCitaprogramacion INT(11),IN idPaciente INT(11),IN evolucion TEXT)
begin
  insert into tbl_historiaclinica(fechaAtencion,motivoAtencion,enfermedadActual,placaVehiculo,idTipoorigenAtencion,idCitaprogramacion,idPaciente,evolucion)
  values(fechaAtencion,motivoAtencion,enfermedadActual,placaVehiculo,idTipoOrigenAtencion,idCitaProgramacion,idPaciente,evolucion);
end$$

DROP PROCEDURE IF EXISTS `spRegistrarHistorialmora`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarHistorialmora`(
  IN $fechaHistorial date, IN $descripcionHistorial varchar(45), IN $idCita int(11)
)
BEGIN
   INSERT INTO `tbl_historialmora`(`fechaHistorial`, `descripcionHistorial`, `idCita`, `idMulta`) VALUES ($fechaHistorial, $descripcionHistorial, $idCita, (SELECT MAX(`idMulta`) FROM `tbl_multa` WHERE `estadoTabla` = 'Activo'));
END$$

DROP PROCEDURE IF EXISTS `spRegistrarIncapacidad`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarIncapacidad`(IN cantidadDias INT(11),IN prorroga VARCHAR(100),IN descripcionMotivo TEXT,IN idCIE10 INT(11),IN idHistoriaClinica INT(11))
begin
  insert into tbl_incapacidad(cantidadDias,prorroga,descripcionMotivo,idCIE10,idHistoriaClinica) values(cantidadDias,prorroga,descripcionMotivo,idCIE10,idHistoriaClinica);
end$$

DROP PROCEDURE IF EXISTS `spRegistrarInterconsulta`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarInterconsulta`(IN descripcionInterconsulta TEXT,IN  especialidad VARCHAR(100),IN idHistoriaClinica INT(11),IN fechaLimite DATE)
begin
  insert into tbl_interconsulta(descripcionInterconsulta,especialidad,idHistoriaClinica,fechaLimite) values(descripcionInterconsulta,especialidad,idHistoriaClinica,fechaLimite);
end$$

DROP PROCEDURE IF EXISTS `spRegistrarLesion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarLesion`(IN $idPuntoLesion int(11), IN $especificacionLesion varchar(100), IN $idCIE10 int(11))
BEGIN
    INSERT INTO `tbl_lesion`(`idPuntoLesion`, `especificacionLesion`, `idCIE10`) VALUES ($idPuntoLesion, $especificacionLesion, $idCIE10);
    END$$

DROP PROCEDURE IF EXISTS `spRegistrarLlamada`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarLlamada`(IN $idChat int(11), IN $urlLlamada varchar(100), IN $fechaHoraLlamada timestamp)
BEGIN
    INSERT INTO `tbl_llamada`(`idChat`, `urlLlamada`, `fechaHoraLlamada`) VALUES ($idChat, $urlLlamada, $fechaHoraLlamada);
    END$$

DROP PROCEDURE IF EXISTS `spRegistrarMedicacionDmc`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarMedicacionDmc`(IN dosis VARCHAR(45),IN hora TIME ,IN  viaAdministracion VARCHAR(45),IN cantidadUnidades INT(11) ,IN idDetalleKit INT(11), IN idHistoriaClinica INT(11))
begin
  insert into tbl_medicamento(dosis,hora,viaAdministracion,cantidadUnidades,idDetalleKit,idHistoriaClinica)
  values(dosis,hora,viaAdministracion,cantidadUnidades,idDetalleKit,idHistoriaClinica);
end$$

DROP PROCEDURE IF EXISTS `spRegistrarMedicamento`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarMedicamento`(IN $idReporteAPH int(11), IN $dosis varchar(45), IN $hora time, IN $viaAdministracion varchar(45), IN $cantidadUnidades int(11), IN $idDetallekit int(11), IN $idHistoriaClinica int(11))
BEGIN
    INSERT INTO `tbl_medicamento`(`idReporteAPH`, `dosis`, `hora`, `viaAdministracion`, `cantidadUnidades`, `idDetallekit`, `idHistoriaClinica`) VALUES ($idReporteAPH, $dosis, $hora, $viaAdministracion, $cantidadUnidades, $idDetallekit, $idHistoriaClinica);
    END$$

DROP PROCEDURE IF EXISTS `spRegistrarMensaje`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarMensaje`(
  IN $idChat INT,
  IN $mensaje VARCHAR(200),
  IN $tipo INT
)
BEGIN
  INSERT INTO `tbl_mensaje`(`idChat`, `mensaje`, `tipo`)
  VALUES ($idChat, $mensaje, $tipo);
END$$

DROP PROCEDURE IF EXISTS `spRegistrarModulo`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarModulo`(IN $descripcionModulo varchar(100), IN $iconoModulo varchar(50))
BEGIN
    INSERT INTO `tbl_modulo`(`descripcionModulo`, `iconoModulo`) VALUES ($descripcionModulo, $iconoModulo);
    END$$

DROP PROCEDURE IF EXISTS `spRegistrarMotivoconsulta`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarMotivoconsulta`($descripcionMotivoConsulta VARCHAR(45), $TipoMotivoConsulta VARCHAR(45))
BEGIN
  INSERT INTO `tbl_motivoconsulta`(`descripcionMotivoConsulta`, `TipoMotivoConsulta`)
  VALUES ($descripcionMotivoConsulta, $TipoMotivoConsulta);
  SELECT MAX(idMotivoConsulta) AS ultimo
  FROM tbl_motivoconsulta;
END$$

DROP PROCEDURE IF EXISTS `spRegistrarMulta`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarMulta`(IN $diasMulta int(11), IN $fechaMulta date, IN $estadoTabla varchar(50))
BEGIN
    INSERT INTO `tbl_multa`(`diasMulta`, `fechaMulta`, `estadoTabla`) VALUES ($diasMulta, $fechaMulta, $estadoTabla);
    END$$

DROP PROCEDURE IF EXISTS `spRegistrarNotaenfermeria`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarNotaenfermeria`(IN $descripcion varchar(200), IN $idPersona INT(11), IN $idProcedimiento INT(11))
BEGIN
    INSERT INTO `tbl_notaenfermeria`(`descripcion`, `idPersona`, `idProcedimiento`) VALUES ($descripcion, $idPersona, $idProcedimiento);
END$$

DROP PROCEDURE IF EXISTS `spRegistrarNovedadrecurso`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarNovedadrecurso`(IN $descripcionNovedad text, IN $fechaHoraNovedad datetime, IN $estadoTablaNovedad varchar(45), IN $idDetallekit int(11), IN $idPersona int(11), IN $idTipoNovedad int(11))
BEGIN
    INSERT INTO `tbl_novedadrecurso`(`descripcionNovedad`, `fechaHoraNovedad`, `estadoTablaNovedad`, `idDetallekit`, `idPersona`, `idTipoNovedad`) VALUES ($descripcionNovedad, $fechaHoraNovedad, $estadoTablaNovedad, $idDetallekit, $idPersona, $idTipoNovedad);
    END$$

DROP PROCEDURE IF EXISTS `spRegistrarNovedadreporteinicial`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarNovedadreporteinicial`(
    IN $idReporteInicial INT,
    IN $descripcionNovedad TEXT,
    IN $numeroLesionadosNovedad INT,
    IN $estadoNovedad VARCHAR(50)
)
BEGIN
  INSERT INTO `tbl_novedadreporteinicial`(`idReporteInicial`, `descripcionNovedad`, `numeroLesionadosNovedad`, `estadoNovedad`)
  VALUES ($idReporteInicial, $descripcionNovedad, $numeroLesionadosNovedad, $estadoNovedad);
END$$

DROP PROCEDURE IF EXISTS `spRegistrarNovedadreporteinicial_enteexterno`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarNovedadreporteinicial_enteexterno`(IN $idEnteExterno int(11), IN $idNovedad int(11))
BEGIN
    INSERT INTO `tbl_novedadreporteinicial_enteexterno`(`idEnteExterno`, `idNovedad`) VALUES ($idEnteExterno, $idNovedad);
    END$$

DROP PROCEDURE IF EXISTS `spRegistrarNovedadRinicial`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarNovedadRinicial`(IN $idReporteInicial int(11), IN $descripcionNovedad varchar(45), IN $numeroLesionados int(11))
BEGIN
  IF $numeroLesionados >= 0 THEN
    INSERT INTO `tbl_novedadreporteinicial`(`idReporteInicial`, `descripcionNovedad`, `numeroLesionados`)
    VALUES ($idReporteInicial, $descripcionNovedad, $numeroLesionados);
  ELSE
    INSERT INTO `tbl_novedadreporteinicial`(`idReporteInicial`, `descripcionNovedad`, `numeroLesionados`)
    VALUES ($idReporteInicial, $descripcionNovedad, NULL);
  END IF;
END$$

DROP PROCEDURE IF EXISTS `spRegistrarObservacion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarObservacion`(IN $idPersonaResponsable int(11), IN $descripcionObservacion varchar(1000), IN $fechaObservacion date, IN $idProcedimiento int(11))
BEGIN
    INSERT INTO `tbl_observacion`(`idPersonaResponsable`, `descripcionObservacion`, `fechaObservacion`, `idProcedimiento`) VALUES ($idPersonaResponsable, $descripcionObservacion, $fechaObservacion, $idProcedimiento);
    END$$

DROP PROCEDURE IF EXISTS `spRegistrarOtroDmc`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarOtroDmc`(IN descripcion TEXT,IN idHistoriaClinica INT(11))
begin
  insert into tbl_otrodmc(descripcion,idHistoriaClinica) values(descripcion,idHistoriaClinica);
end$$

DROP PROCEDURE IF EXISTS `spRegistrarPaciente`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarPaciente`(IN $numeroDocumento varchar(45), IN $fechaNacimiento date, IN $tipoSangre varchar(45), IN $primerNombre varchar(45), IN $segundoNombre varchar(45), IN $primerApellido varchar(45), IN $segundoApellido varchar(45), IN $genero varchar(45), IN $estadoCivil varchar(45), IN $ciudadResidencia varchar(45), IN $barrioResidencia varchar(45), IN $direccion varchar(45), IN $telefonoFijo varchar(45), IN $telefonoMovil varchar(45), IN $correoElectronico varchar(45), IN $empresa varchar(45), IN $ocupacion varchar(45), IN $profesion varchar(45), IN $fechaAfiliacionRegistro date, IN $idtipoDocumento int(11), IN $idtipoAfiliacion int(11), IN $edadPaciente varchar(10), IN $url varchar(250), IN $idEstadoPaciente int(11))
BEGIN
    INSERT INTO `tbl_paciente`(`numeroDocumento`, `fechaNacimiento`, `tipoSangre`, `primerNombre`, `segundoNombre`, `primerApellido`, `segundoApellido`, `genero`, `estadoCivil`, `ciudadResidencia`, `barrioResidencia`, `direccion`, `telefonoFijo`, `telefonoMovil`, `correoElectronico`, `empresa`, `ocupacion`, `profesion`, `fechaAfiliacionRegistro`, `idtipoDocumento`, `idtipoAfiliacion`, `edadPaciente`, `url`, `idEstadoPaciente`) VALUES ($numeroDocumento, $fechaNacimiento, $tipoSangre, $primerNombre, $segundoNombre, $primerApellido, $segundoApellido, $genero, $estadoCivil, $ciudadResidencia, $barrioResidencia, $direccion, $telefonoFijo, $telefonoMovil, $correoElectronico, $empresa, $ocupacion, $profesion, $fechaAfiliacionRegistro, $idtipoDocumento, $idtipoAfiliacion, $edadPaciente, $url, $idEstadoPaciente);
    END$$

DROP PROCEDURE IF EXISTS `spRegistrarPermiso`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarPermiso`(IN `$rol` INT, IN `$modulo` INT, IN `$vista` INT)
BEGIN
  INSERT INTO`bd_proyecto_salud`.`tbl_rolmodulovista` ( `idRol`, `idModulo`, `idVista`)
  VALUES ($rol, $modulo, $vista);
END$$

DROP PROCEDURE IF EXISTS `spRegistrarPersona`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarPersona`(IN $primerNombre varchar(50), IN $segundoNombre varchar(50), IN $primerApellido varchar(50), IN $segundoApellido varchar(50), IN $idTipoDocumento int(11), IN $numeroDocumento varchar(20), IN $lugarExpedicionDocumento varchar(50), IN $fechaNacimiento date, IN $lugarNacimiento varchar(45), IN $sexo varchar(45), IN $direccion varchar(45), IN $telefono varchar(45), IN $correoElectronico varchar(45), IN $grupoSanguineo varchar(45), IN $ciudad varchar(45), IN $departamento varchar(45), IN $pais varchar(45), IN $urlHojaDeVida varchar(250), IN $urlFirma varchar(250), IN $urlFoto varchar(250), IN $estadoTablaPersona varchar(50), IN $dependencia varchar(45))
BEGIN
    INSERT INTO `tbl_persona`(`primerNombre`, `segundoNombre`, `primerApellido`, `segundoApellido`, `idTipoDocumento`, `numeroDocumento`, `lugarExpedicionDocumento`, `fechaNacimiento`, `lugarNacimiento`, `sexo`, `direccion`, `telefono`, `correoElectronico`, `grupoSanguineo`, `ciudad`, `departamento`, `pais`, `urlHojaDeVida`, `urlFirma`, `urlFoto`, `estadoTablaPersona`, `dependencia`) VALUES ($primerNombre, $segundoNombre, $primerApellido, $segundoApellido, $idTipoDocumento, $numeroDocumento, $lugarExpedicionDocumento, $fechaNacimiento, $lugarNacimiento, $sexo, $direccion, $telefono, $correoElectronico, $grupoSanguineo, $ciudad, $departamento, $pais, $urlHojaDeVida, $urlFirma, $urlFoto, $estadoTablaPersona, $dependencia);
    END$$

DROP PROCEDURE IF EXISTS `spRegistrarPersonaespecialidad`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarPersonaespecialidad`(IN $idPersona int(11), IN $idEspecialidad int(11), IN $estadoTablaEspecialidad varchar(50))
BEGIN
    INSERT INTO `tbl_personaespecialidad`(`idPersona`, `idEspecialidad`, `estadoTablaEspecialidad`) VALUES ($idPersona, $idEspecialidad, $estadoTablaEspecialidad);
    END$$

DROP PROCEDURE IF EXISTS `spRegistrarPiel`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarPiel`(IN $idExamenFisico int(11), IN $descripcion varchar(45))
BEGIN
    INSERT INTO `tbl_piel`(`idExamenFisico`, `descripcion`) VALUES ($idExamenFisico, $descripcion);
    END$$

DROP PROCEDURE IF EXISTS `spRegistrarProcedimiento`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarProcedimiento`(IN descripcion VARCHAR(1000),IN idCUP INT(11),IN idHistoriaClinica INT(11))
begin
  insert into tbl_procedimiento(descripcionProcedimiento,idCUP,idHistoriaClinica)
  values(descripcion,idCUP,idHistoriaClinica);
end$$

DROP PROCEDURE IF EXISTS `spRegistrarProgramacion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarProgramacion`(IN $Fecha_inicial date, IN $Fecha_final date)
BEGIN
    INSERT INTO `tbl_programacion`(`Fecha_inicial`, `Fecha_final`) VALUES ($Fecha_inicial, $Fecha_final);
    END$$

DROP PROCEDURE IF EXISTS `spRegistrarPuntolesion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarPuntolesion`(IN $posX varchar(100), IN $posY varchar(100), IN $idReporteAPH int(11))
BEGIN
    INSERT INTO `tbl_puntolesion`(`posX`, `posY`, `idReporteAPH`) VALUES ($posX, $posY, $idReporteAPH);
    END$$

DROP PROCEDURE IF EXISTS `spRegistrarRecurso`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarRecurso`(IN $nombre varchar(45), IN $descripcion varchar(45), IN $cantidadRecurso int(11), IN $estadoTablaRecurso varchar(50), IN $idCategoriaRecurso int(11))
BEGIN
    INSERT INTO `tbl_recurso`(`nombre`, `descripcion`, `cantidadRecurso`, `estadoTablaRecurso`, `idCategoriaRecurso`) VALUES ($nombre, $descripcion, $cantidadRecurso, $estadoTablaRecurso, $idCategoriaRecurso);
    END$$

DROP PROCEDURE IF EXISTS `spRegistrarReporteaph`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarReporteaph`(IN $idExamenFisico int(11), IN $idDespacho int(11), IN $idAsignacionPersonal int(11), IN $idPersonalRecibe int(11), IN $idTriage int(11), IN $idTipoAseguramiento int(11), IN $idCertificadoAtencion int(11), IN $fechaHoraFinalizacion datetime, IN $fechaHoraArriboEscena datetime, IN $fechaHoraArriboIPS datetime, IN $ultimaIngesta datetime, IN $idAfectadoAccidenteTransito int(11), IN $placaVehiculo varchar(45), IN $codigoAseguradora varchar(45), IN $numeroPoliza varchar(45), IN $descripcionTratamiento text, IN $descripcionTratamientoAvanzado text, IN $evaluacionResultado varchar(45), IN $institucionReceptora varchar(45), IN $situacionEntrega varchar(45), IN $presionArterialEntrega varchar(45), IN $pulsoEntrega varchar(45), IN $respiracionEntrega varchar(45), IN $estadoTablaReporteAPH varchar(50), IN $complicaciones text, IN $idPaciente int(11),IN $idAcompanante int(11), IN $TAPHPresente BOOLEAN, IN $TPAPHPresente BOOLEAN, IN $otroPersonalControlM BOOLEAN, IN $nombreOtroPersonalControlM varchar(45), IN $protocolo bit(1), IN $idParamedicoAtiende INT)
BEGIN
INSERT INTO `tbl_reporteaph`(`idExamenFisico`, `idDespacho`, `idAsignacionPersonal`, `idPersonalRecibe`, `idParamedicoAtiende`,  `idTriage`, `idTipoAseguramiento`, `idCertificadoAtencion`, `fechaHoraFinalizacion`, `fechaHoraArriboEscena`, `fechaHoraArriboIPS`, `ultimaIngesta`, `idAfectadoAccidenteTransito`, `placaVehiculo`, `codigoAseguradora`, `numeroPoliza`, `descripcionTratamiento`, `descripcionTratamientoAvanzado`, `evaluacionResultado`, `institucionReceptora`, `situacionEntrega`, `presionArterialEntrega`, `pulsoEntrega`, `respiracionEntrega`, `estadoTablaReporteAPH`, `complicaciones`, `idPaciente`,`idAcompanante`, `TAPHPresente`,`TPAPHPresente`, `otroPersonalControlM`, `nombreOtroPersonalControlM`, `protocolo`) VALUES ($idExamenFisico, $idDespacho, $idAsignacionPersonal, $idPersonalRecibe, $idParamedicoAtiende, $idTriage, $idTipoAseguramiento, $idCertificadoAtencion, $fechaHoraFinalizacion, $fechaHoraArriboEscena, $fechaHoraArriboIPS, $ultimaIngesta, $idAfectadoAccidenteTransito, $placaVehiculo, $codigoAseguradora, $numeroPoliza, $descripcionTratamiento, $descripcionTratamientoAvanzado, $evaluacionResultado, $institucionReceptora, $situacionEntrega, $presionArterialEntrega, $pulsoEntrega, $respiracionEntrega, $estadoTablaReporteAPH, $complicaciones, $idPaciente,$idAcompanante, $TAPHPresente,$TPAPHPresente, $otroPersonalControlM, $nombreOtroPersonalControlM, $protocolo);
SELECT MAX(idReporteAPH) ultimoReporte FROM tbl_reporteaph;
UPDATE tbl_despacho SET estadoDespacho = 'Finalizado' WHERE idDespacho = $idDespacho;
END$$

DROP PROCEDURE IF EXISTS `spRegistrarReporteaph_motivoconsulta`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarReporteaph_motivoconsulta`(IN $idReporteAPH int(11), IN $idMotivoConsulta int(11), IN $especificacion text)
BEGIN
    INSERT INTO `tbl_reporteaph_motivoconsulta`(`idReporteAPH`, `idMotivoConsulta`, `especificacion`) VALUES ($idReporteAPH, $idMotivoConsulta, $especificacion);
    END$$

DROP PROCEDURE IF EXISTS `spRegistrarReporteinicial`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarReporteinicial`(
  IN $informacionInicial VARCHAR(300),
  IN $ubicacionIncidente VARCHAR(100),
  IN $puntoReferencia VARCHAR(45),
  IN $numeroLesionados INT,
  IN $fechaHoraAproximadaEmergencia DATETIME,
  IN $estadoTablaReporteInicial VARCHAR(50),
  IN $idChat INT
)
BEGIN
  INSERT INTO `tbl_reporteinicial`(`informacionInicial`, `ubicacionIncidente`, `puntoReferencia`, `numeroLesionados`, `fechaHoraAproximadaEmergencia`, `estadoTablaReporteInicial`, `idChat`)
  VALUES ($informacionInicial, $ubicacionIncidente, $puntoReferencia, $numeroLesionados, $fechaHoraAproximadaEmergencia, $estadoTablaReporteInicial, $idChat);
  SELECT MAX(idReporteInicial) 'idReporte' FROM tbl_reporteinicial;
END$$

DROP PROCEDURE IF EXISTS `spRegistrarRestablecer`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarRestablecer`(IN $email varchar(50), IN $codigo varchar(50), IN $idUsuario int(11), IN $estado varchar(20), IN $fecha timestamp)
BEGIN
    INSERT INTO `tbl_restablecer`(`email`, `codigo`, `idUsuario`, `estado`, `fecha`) VALUES ($email, $codigo, $idUsuario, $estado, $fecha);
    END$$

DROP PROCEDURE IF EXISTS `spRegistrarRol`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarRol`(IN $descripcionRol varchar(45), IN $estadoTabla varchar(50))
BEGIN
    INSERT INTO `tbl_rol`(`descripcionRol`, `estadoTabla`) VALUES ($descripcionRol, $estadoTabla);
    END$$

DROP PROCEDURE IF EXISTS `spRegistrarRolmodulovista`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarRolmodulovista`(IN $idRol int(11), IN $idModulo int(11), IN $idVista int(11))
BEGIN
    INSERT INTO `tbl_rolmodulovista`(`idRol`, `idModulo`, `idVista`) VALUES ($idRol, $idModulo, $idVista);
    END$$

DROP PROCEDURE IF EXISTS `spRegistrarSignosVitales`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarSignosVitales`(IN resultado DOUBLE,IN hora TIME,IN idValoracion INT(11), IN idHistoriaClinica INT(11))
begin
  insert into tbl_signosvitales(resultado,hora,idValoracion,idHistoriaClinica)
  values(resultado,hora,idValoracion,idHistoriaClinica);
end$$

DROP PROCEDURE IF EXISTS `spRegistrarSolicitud`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarSolicitud`(IN $Descripcion varchar(60), IN $CuentaUsuario_idUsuario int(11))
BEGIN
    INSERT INTO `tbl_solicitud`(`Descripcion`, `CuentaUsuario_idUsuario`) VALUES ($Descripcion, $CuentaUsuario_idUsuario);
    END$$

DROP PROCEDURE IF EXISTS `spRegistrarTemporalautorizacion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarTemporalautorizacion`(
IN $idParamedico INT,
IN $idReporte INT,
IN $idTipoTratamiento INT,
IN $descripcionAutorizacion TEXT,
IN $cedulaPaciente VARCHAR(200),
IN $estadoEvaluacion VARCHAR(200),
IN $fechaEnvio DATETIME)
BEGIN
  INSERT INTO `tbl_temporalautorizacion`(`idParamedico`, `idReporte`, `idTipoTratamiento`, `descripcionAutorizacion`, `cedulaPaciente`, `estadoEvaluacion`, `fechaEnvio`) VALUES ($idParamedico,$idReporte,$idTipoTratamiento,$descripcionAutorizacion,$cedulaPaciente,$estadoEvaluacion,$fechaEnvio);
END$$

DROP PROCEDURE IF EXISTS `spRegistrarTemporalautorizacionMedicamento`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarTemporalautorizacionMedicamento`(
IN $idParamedico INT,
IN $idMedicamento INT,
IN $descripcionAutorizacion TEXT,
IN $cedulaPaciente VARCHAR(200),
IN $estadoEvaluacion VARCHAR(200),
IN $fechaEnvio DATETIME)
BEGIN
  INSERT INTO `tbl_temporalautorizacion`(`idParamedico`, `idMedicamento`, `descripcionAutorizacion`, `cedulaPaciente`, `estadoEvaluacion`, `fechaEnvio`) VALUES ($idParamedico,$idMedicamento,$descripcionAutorizacion,$cedulaPaciente,$estadoEvaluacion,$fechaEnvio);
END$$

DROP PROCEDURE IF EXISTS `spRegistrarTestigo`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarTestigo`(IN $idReporteAPH int(11), IN $nombreTestigo varchar(45), IN $identificacionTestigo varchar(45))
BEGIN
    INSERT INTO `tbl_testigo`(`idReporteAPH`, `nombreTestigo`, `identificacionTestigo`) VALUES ($idReporteAPH, $nombreTestigo, $identificacionTestigo);
    END$$

DROP PROCEDURE IF EXISTS `spRegistrarTExamenesEspecializados`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarTExamenesEspecializados`(IN descripcion VARCHAR(1000))
begin
  insert into tbl_tipoexamenespecializado(descripcion,estadoTabla) values(descripcion,'Inactivo');
end$$

DROP PROCEDURE IF EXISTS `spRegistrarTipoafiliacion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarTipoafiliacion`(IN $descripcionAfiliacion varchar(45), IN $estadoTabla varchar(50))
BEGIN
    INSERT INTO `tbl_tipoafiliacion`(`descripcionAfiliacion`, `estadoTabla`) VALUES ($descripcionAfiliacion, $estadoTabla);
    END$$

DROP PROCEDURE IF EXISTS `spRegistrarTipoantecedente`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarTipoantecedente`(IN $descripcion varchar(100), IN $estadoTabla varchar(50))
BEGIN
    INSERT INTO `tbl_tipoantecedente`(`descripcion`, `estadoTabla`) VALUES ($descripcion, $estadoTabla);
    END$$

DROP PROCEDURE IF EXISTS `spRegistrarTipoaseguramiento`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarTipoaseguramiento`(IN $DescripcionTipoAseguramiento varchar(45), IN $estadoTabla varchar(50))
BEGIN
    INSERT INTO `tbl_tipoaseguramiento`(`DescripcionTipoAseguramiento`, `estadoTabla`) VALUES ($DescripcionTipoAseguramiento, $estadoTabla);
    END$$

DROP PROCEDURE IF EXISTS `spRegistrarTipoAseguramientoHC`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarTipoAseguramientoHC`(IN $DescripcionTipoAseguramiento VARCHAR(60),IN $estadoTabla VARCHAR(60))
BEGIN
INSERT INTO `tbl_tipoaseguramiento`(`DescripcionTipoAseguramiento`, `estadoTabla`) VALUES ($DescripcionTipoAseguramiento, $estadoTabla);
SELECT MAX(idTipoAseguramiento) as ultimoTipoAseguramiento FROM `tbl_tipoaseguramiento`;
END$$

DROP PROCEDURE IF EXISTS `spRegistrarTipoasignacion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarTipoasignacion`(IN $descripcionTipoasignacion varchar(45), IN $estadoTabla varchar(50))
BEGIN
    INSERT INTO `tbl_tipoasignacion`(`descripcionTipoasignacion`, `estadoTabla`) VALUES ($descripcionTipoasignacion, $estadoTabla);
    END$$

DROP PROCEDURE IF EXISTS `spRegistrarTipocup`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarTipocup`(IN $descripcionCUP varchar(45))
BEGIN
    INSERT INTO `tbl_tipocup`(`descripcionCUP`) VALUES ($descripcionCUP);
    END$$

DROP PROCEDURE IF EXISTS `spRegistrarTipodevolucion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarTipodevolucion`(IN $descripcionDevolucion varchar(45), IN $estadoTabla varchar(50))
BEGIN
    INSERT INTO `tbl_tipodevolucion`(`descripcionDevolucion`, `estadoTabla`) VALUES ($descripcionDevolucion, $estadoTabla);
    END$$

DROP PROCEDURE IF EXISTS `spRegistrarTipodocumento`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarTipodocumento`(IN $descripcionTdocumento varchar(45), IN $estadoTabla varchar(50))
BEGIN
    INSERT INTO `tbl_tipodocumento`(`descripcionTdocumento`, `estadoTabla`) VALUES ($descripcionTdocumento, $estadoTabla);
    END$$

DROP PROCEDURE IF EXISTS `spRegistrarTipoevento`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarTipoevento`(IN $descripcionTipoEvento VARCHAR(45))
BEGIN
  INSERT INTO `tbl_tipoevento`(`descripcionTipoEvento`)
  VALUES ($descripcionTipoEvento);
END$$

DROP PROCEDURE IF EXISTS `spRegistrarTipoevento_novedadreporteinicial`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarTipoevento_novedadreporteinicial`(IN $idTipoEvento int(11), IN $idNovedad int(11))
BEGIN
    INSERT INTO `tbl_tipoevento_novedadreporteinicial`(`idTipoEvento`, `idNovedad`) VALUES ($idTipoEvento, $idNovedad);
    END$$

DROP PROCEDURE IF EXISTS `spRegistrarTipoevento_reporteinicial`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarTipoevento_reporteinicial`(IN $idTipoEvento INT)
BEGIN
  INSERT INTO tbl_tipoevento_reporteinicial (idTipoEvento, idReporteInicial)
  VALUES ($idTipoEvento, fnUltimoReporteInicial());
END$$

DROP PROCEDURE IF EXISTS `spRegistrarTipoEvento_reporteinicialAPH`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarTipoEvento_reporteinicialAPH`(IN $idTipoEvento int(11), $idReporteInicial int(11))
BEGIN
  INSERT INTO tbl_tipoevento_reporteinicial (idTipoEvento, idReporteInicial)
  VALUES ($idTipoEvento, $idReporteInicial);
END$$

DROP PROCEDURE IF EXISTS `spRegistrarTipoexamenespecializado`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarTipoexamenespecializado`(IN $descripcion varchar(1000), IN $estadoTabla varchar(45))
BEGIN
    INSERT INTO `tbl_tipoexamenespecializado`(`descripcion`, `estadoTabla`) VALUES ($descripcion, $estadoTabla);
    END$$

DROP PROCEDURE IF EXISTS `spRegistrarTipoexamenfisico`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarTipoexamenfisico`(IN $descripcionExamenFisico varchar(500), IN $estadoTabla varchar(50))
BEGIN
    INSERT INTO `tbl_tipoexamenfisico`(`descripcionExamenFisico`, `estadoTabla`) VALUES ($descripcionExamenFisico, $estadoTabla);
    END$$

DROP PROCEDURE IF EXISTS `spRegistrarTipokit`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarTipokit`(IN $descripcionTipoKit varchar(50), IN $estadoTabla varchar(50))
BEGIN
    INSERT INTO `tbl_tipokit`(`descripcionTipoKit`, `estadoTabla`) VALUES ($descripcionTipoKit, $estadoTabla);
    END$$

DROP PROCEDURE IF EXISTS `spRegistrarTiponovedad`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarTiponovedad`(IN $descripcionTiponovedad varchar(45), IN $estadoTabla varchar(50))
BEGIN
    INSERT INTO `tbl_tiponovedad`(`descripcionTiponovedad`, `estadoTabla`) VALUES ($descripcionTiponovedad, $estadoTabla);
    END$$

DROP PROCEDURE IF EXISTS `spRegistrarTipoOrigenAtencion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarTipoOrigenAtencion`()
begin
  insert into tbl_tipoorigenatencion(descripcionOrigenAtencion,estadoTabla)
  values(descripcion,'Inactivo');
end$$

DROP PROCEDURE IF EXISTS `spRegistrarTipoorigenatencionOtro`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarTipoorigenatencionOtro`(IN descripcion VARCHAR(100))
begin
  insert into tbl_tipoorigenatencion(descripcionOrigenAtencion,estadoTabla)
  values(descripcion,'Inactivo');
end$$

DROP PROCEDURE IF EXISTS `spRegistrarTipotratamiento`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarTipotratamiento`(IN $Descripcion varchar(1000), IN $categoriaTratamientoAph varchar(45), IN $categoriaItemTratamiento varchar(45), IN $estadoTabla varchar(50))
BEGIN
    INSERT INTO `tbl_tipotratamiento`(`Descripcion`, `categoriaTratamientoAph`, `categoriaItemTratamiento`, `estadoTabla`) VALUES ($Descripcion, $categoriaTratamientoAph, $categoriaItemTratamiento, $estadoTabla);
    END$$

DROP PROCEDURE IF EXISTS `spRegistrarTipozona`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarTipozona`(IN $descripcionTipozona varchar(100), IN $estadoTabla varchar(50))
BEGIN
    INSERT INTO `tbl_tipozona`(`descripcionTipozona`, `estadoTabla`) VALUES ($descripcionTipozona, $estadoTabla);
    END$$

DROP PROCEDURE IF EXISTS `spRegistrarTratamiento`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarTratamiento`(
  IN descripcion VARCHAR(45),
  IN fecha VARCHAR(45),
  IN  dosis VARCHAR(45),
  IN idHistoriaClinica VARCHAR(45),
  IN idTipoTratamiento VARCHAR(45)
)
begin
  insert into tbl_tratamientodmc(descripcionTratamiento,fechaTratamiento,dosisTratamiento,idHistoriaClinica,idTipoTratamiento) values(descripcion,fecha,dosis,idHistoriaClinica,idTipoTratamiento);
end$$

DROP PROCEDURE IF EXISTS `spRegistrarTratamientoaph`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarTratamientoaph`(IN $idReporteAPH int(11), IN $valor varchar(45), IN $idTipoTratamiento int(11))
BEGIN
    INSERT INTO `tbl_tratamientoaph`(`idReporteAPH`, `valor`, `idTipoTratamiento`) VALUES ($idReporteAPH, $valor, $idTipoTratamiento);
    END$$

DROP PROCEDURE IF EXISTS `spRegistrarTratamientodmc`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarTratamientodmc`(IN $descripcionTratamiento text, IN $fechaTratamiento date, IN $dosisTratamiento text, IN $idTipoTratamiento int(11), IN $idHistoriaClinica int(11))
BEGIN
    INSERT INTO `tbl_tratamientodmc`(`descripcionTratamiento`, `fechaTratamiento`, `dosisTratamiento`, `idTipoTratamiento`, `idHistoriaClinica`) VALUES ($descripcionTratamiento, $fechaTratamiento, $dosisTratamiento, $idTipoTratamiento, $idHistoriaClinica);
    END$$

DROP PROCEDURE IF EXISTS `spRegistrarTratamientodmcrecurso`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarTratamientodmcrecurso`(IN $idTratamientoDmc int(11), IN $idrecurso int(11))
BEGIN
    INSERT INTO `tbl_tratamientodmcrecurso`(`idTratamientoDmc`, `idrecurso`) VALUES ($idTratamientoDmc, $idrecurso);
    END$$

DROP PROCEDURE IF EXISTS `spRegistrarTriage`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarTriage`(IN $descripcionTriage varchar(45), IN $estadoTabla varchar(50))
BEGIN
    INSERT INTO `tbl_triage`(`descripcionTriage`, `estadoTabla`) VALUES ($descripcionTriage, $estadoTabla);
    END$$

DROP PROCEDURE IF EXISTS `spRegistrarTTratamiento`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarTTratamiento`(IN Descripcion VARCHAR(1000))
begin
  insert into tbl_tipotratamiento(Descripcion,categoriaItemTratamiento,estadoTabla)values(descripcion,'Básico','Inactivo');
end$$

DROP PROCEDURE IF EXISTS `spRegistrarTurno`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarTurno`(IN $horaInicioTurno time, IN $horaFinalTurno time)
BEGIN
    INSERT INTO `tbl_turno`(`horaInicioTurno`, `horaFinalTurno`) VALUES ($horaInicioTurno, $horaFinalTurno);
    END$$

DROP PROCEDURE IF EXISTS `spRegistrarTurnoprogramacion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarTurnoprogramacion`(IN $idTurno int(11), IN $idProgramacion int(11), IN $idPersona int(11), IN $estadoTablaProgramacion varchar(45))
BEGIN
    INSERT INTO `tbl_turnoprogramacion`(`idTurno`, `idProgramacion`, `idPersona`, `estadoTablaProgramacion`) VALUES ($idTurno, $idProgramacion, $idPersona, $estadoTablaProgramacion);
    END$$

DROP PROCEDURE IF EXISTS `spRegistrarValoracion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarValoracion`(IN $descripcionValoracion varchar(45))
BEGIN
    INSERT INTO `tbl_valoracion`(`descripcionValoracion`) VALUES ($descripcionValoracion);
    END$$

DROP PROCEDURE IF EXISTS `spRegistrarViacomunicacioncontrolmedico`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarViacomunicacioncontrolmedico`(IN $idReporteAPH int(11), IN $viaComunicacion varchar(45))
BEGIN
    INSERT INTO `tbl_viacomunicacioncontrolmedico`(`idReporteAPH`, `viaComunicacion`) VALUES ($idReporteAPH, $viaComunicacion);
    END$$

DROP PROCEDURE IF EXISTS `spRegistrarVista`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarVista`(IN $descripcionVista varchar(70), IN $urlVista varchar(250), IN $iconoVista varchar(45), IN $estado varchar(45))
BEGIN
    INSERT INTO `tbl_vista`(`descripcionVista`, `urlVista`, `iconoVista`, `estado`) VALUES ($descripcionVista, $urlVista, $iconoVista, $estado);
    END$$

DROP PROCEDURE IF EXISTS `spRegistrarVistoChat`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarVistoChat`(IN $idChat INT)
BEGIN
  UPDATE tbl_chat
  SET visto = 1
  WHERE idChat = $idChat;
END$$

DROP PROCEDURE IF EXISTS `spRegistrarZona`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarZona`(IN $descripcionZona varchar(45), IN $idTipoZona int(11), IN $estadoTabla varchar(50))
BEGIN
    INSERT INTO `tbl_zona`(`descripcionZona`, `idTipoZona`, `estadoTabla`) VALUES ($descripcionZona, $idTipoZona, $estadoTabla);
    END$$

DROP PROCEDURE IF EXISTS `spSeleccionarUltimoid`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spSeleccionarUltimoid`()
BEGIN
  SELECT MAX(idAsignacionPersonal) AS ultimo
  FROM tbl_asignacionpersonal;
END$$

DROP PROCEDURE IF EXISTS `spSeleccionarUltimoIdAsignacion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spSeleccionarUltimoIdAsignacion`()
BEGIN
	SELECT MAX(idAsignacionPersonal) AS ultimo
  FROM tbl_asignacionpersonal;
END$$

DROP PROCEDURE IF EXISTS `spSugerenciaAuxiliarEnfermeria`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spSugerenciaAuxiliarEnfermeria`(IN $idMedico INT(11))
BEGIN

SELECT DISTINCT tbl_persona.primerNombre,tbl_persona.primerApellido,tbl_turnoprogramacion.idTurnoProgramacion

FROM tbl_cita

INNER JOIN tbl_cita_programacion

ON tbl_cita.idCita=tbl_cita_programacion.idCita

INNER JOIN tbl_turnoprogramacion

ON tbl_cita_programacion.idTurnoProgramacion=tbl_turnoprogramacion.idTurnoProgramacion

INNER JOIN tbl_persona

ON tbl_turnoprogramacion.idPersona=tbl_persona.idPersona

INNER JOIN tbl_cuentausuario

ON tbl_persona.idPersona=tbl_cuentausuario.idPersona

INNER JOIN tbl_rol

ON tbl_cuentausuario.idRol=tbl_rol.idRol

WHERE tbl_cita.idCita IN (

    SELECT tbl_cita.idCita 

    FROM tbl_cita

    INNER JOIN tbl_cita_programacion

ON tbl_cita.idCita=tbl_cita_programacion.idCita

INNER JOIN tbl_turnoprogramacion

ON tbl_cita_programacion.idTurnoProgramacion=tbl_turnoprogramacion.idTurnoProgramacion

INNER JOIN tbl_persona

ON tbl_turnoprogramacion.idPersona=tbl_persona.idPersona

INNER JOIN tbl_cuentausuario

ON tbl_persona.idPersona=tbl_cuentausuario.idPersona

INNER JOIN tbl_rol

ON tbl_cuentausuario.idRol=tbl_rol.idRol

WHERE tbl_persona.idPersona=$idMedico

)

AND tbl_rol.descripcionRol LIKE 'Auxiliar de Enfermeria' ;

END$$

DROP PROCEDURE IF EXISTS `spSugerenciaEnfermerosJefe`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spSugerenciaEnfermerosJefe`(IN $idMedico INT(11))
BEGIN

SELECT DISTINCT tbl_persona.primerNombre,tbl_persona.primerApellido,tbl_turnoprogramacion.idTurnoProgramacion

FROM tbl_cita

INNER JOIN tbl_cita_programacion

ON tbl_cita.idCita=tbl_cita_programacion.idCita

INNER JOIN tbl_turnoprogramacion

ON tbl_cita_programacion.idTurnoProgramacion=tbl_turnoprogramacion.idTurnoProgramacion

INNER JOIN tbl_persona

ON tbl_turnoprogramacion.idPersona=tbl_persona.idPersona

INNER JOIN tbl_cuentausuario

ON tbl_persona.idPersona=tbl_cuentausuario.idPersona

INNER JOIN tbl_rol

ON tbl_cuentausuario.idRol=tbl_rol.idRol

WHERE tbl_cita.idCita IN (

    SELECT tbl_cita.idCita 

    FROM tbl_cita

    INNER JOIN tbl_cita_programacion

ON tbl_cita.idCita=tbl_cita_programacion.idCita

INNER JOIN tbl_turnoprogramacion

ON tbl_cita_programacion.idTurnoProgramacion=tbl_turnoprogramacion.idTurnoProgramacion

INNER JOIN tbl_persona

ON tbl_turnoprogramacion.idPersona=tbl_persona.idPersona

INNER JOIN tbl_cuentausuario

ON tbl_persona.idPersona=tbl_cuentausuario.idPersona

INNER JOIN tbl_rol

ON tbl_cuentausuario.idRol=tbl_rol.idRol

WHERE tbl_persona.idPersona=$idMedico

)

AND tbl_rol.descripcionRol LIKE 'Enfermera jefe' ;

END$$

DROP PROCEDURE IF EXISTS `spTraerIDDespacho`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spTraerIDDespacho`(IN $idPersona INT(11))
BEGIN
  SELECT idDespacho FROM tbl_despacho
    WHERE idAmbulancia= (
      SELECT ap.idAmbulancia
      FROM tbl_detalleasignacion da
      INNER JOIN tbl_asignacionpersonal ap
      ON ap.idAsignacionPersonal = da.idAsignacionPersonal
      WHERE da.idPersona = $idPersona AND LOWER(da.estadoTabla )= LOWER("Activo")
    )
  AND LOWER(estadoDespacho) = LOWER('en proceso');
END$$

DROP PROCEDURE IF EXISTS `spTraerIdNovedadrecurso`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spTraerIdNovedadrecurso`(
IN _id INT
)
BEGIN
select * from tbl_novedadrecurso nr
INNER JOIN tbl_detallekit dk
on nr.idDetallekit = dk.idDetallekit
INNER JOIN tbl_recurso r
on dk.idrecurso = r.idrecurso
where nr.idNovedadRecurso = _id;
END$$

DROP PROCEDURE IF EXISTS `spTraerprogramacionesvencidas`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spTraerprogramacionesvencidas`(IN $Fecha date)
BEGIN
  select idTurnoProgramacion
  from tbl_turnoprogramacion tp
  inner join tbl_programacion p
  on tp.idProgramacion = p.idProgramacion
  where p.Fecha_final<$Fecha;
END$$

DROP PROCEDURE IF EXISTS `spTraerProximoIdReporteAPH`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spTraerProximoIdReporteAPH`($nombreTabla VARCHAR(45))
BEGIN
  SELECT AUTO_INCREMENT proximoId
  FROM information_schema.TABLES
  WHERE TABLE_SCHEMA = 'bd_proyecto_salud' AND TABLE_NAME=$nombreTabla;
END$$

DROP PROCEDURE IF EXISTS `spUltimaPersona`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spUltimaPersona`()
BEGIN
  SELECT MAX(idPersona) AS ultima FROM tbl_persona;
END$$

DROP PROCEDURE IF EXISTS `spUltimoAcompanante`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spUltimoAcompanante`()
BEGIN
  SELECT MAX(idAcompanante) as ultimoA from tbl_acompanante;
END$$

DROP PROCEDURE IF EXISTS `spUltimoDatoOrigenAtencion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spUltimoDatoOrigenAtencion`()
begin
  select MAX(idTipoOrigenAtencion) as id from tbl_tipoorigenatencion;
end$$

DROP PROCEDURE IF EXISTS `spUltimoIdFormula`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spUltimoIdFormula`()
begin
  select MAX(idFormulaMedica) as id from tbl_formulamedica;
end$$

DROP PROCEDURE IF EXISTS `spUltimoIdHistoriaClinica`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spUltimoIdHistoriaClinica`()
begin
  select max(idHistoriaClinica) as id from tbl_historiaclinica;
end$$

DROP PROCEDURE IF EXISTS `spUltimoIDmotivoConsulta`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spUltimoIDmotivoConsulta`()
BEGIN
  SELECT MAX(idMotivoConsulta)ultimoRegistro
  FROM tbl_motivoconsulta;
END$$

DROP PROCEDURE IF EXISTS `spUltimoIdTipoEspecializado`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spUltimoIdTipoEspecializado`()
begin
  select MAX(idTipoExamenEspecializado) as id from tbl_tipoexamenespecializado;
end$$

DROP PROCEDURE IF EXISTS `spUltimoIdTratamiento`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spUltimoIdTratamiento`()
begin
  select MAX(idTratamiento) as id from tbl_tratamientodmc;
end$$

DROP PROCEDURE IF EXISTS `spUltimoIdTTratamiento`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spUltimoIdTTratamiento`()
begin
  select max(idTipoTratamiento) as id from tbl_tipotratamiento;
end$$

DROP PROCEDURE IF EXISTS `spUltimoPaciente`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spUltimoPaciente`()
BEGIN
  SELECT MAX(idPaciente) AS ultimo
  FROM tbl_paciente;
END$$

DROP PROCEDURE IF EXISTS `spUniqueDespachoReporteaph`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spUniqueDespachoReporteaph`(IN $idDespacho int(11))
BEGIN
SELECT        idReporteAPH FROM `tbl_reporteaph` WHERE idDespacho = $idDespacho;
END$$

DROP PROCEDURE IF EXISTS `spvalidacionnombreasignacion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spvalidacionnombreasignacion`(
  in  $idPersona int,
  in $idAmbulancia int,
  in  $idPaciente int
)
BEGIN
  if ($idPersona != 0) then
  SELECT kit.idPersona, PE.primerNombre, PE.segundoNombre, PE.numeroDocumento, DE.cantidadAsignada, De.cantidadFinal, kit.idTipoAsignacion
  FROM tbl_asignacionkit as kit
  inner join tbl_persona as PE on  kit.idPersona = PE.idPersona
  inner join tbl_detallekit as DE on kit.idAsignacion = DE.idAsignacion
  inner join tbl_recurso as RE on DE.idRecurso = RE.idRecurso
  where kit.idPersona = $idPersona;

  elseif ($idAmbulancia != 0) then
  SELECT AM.idAmbulancia, AM.placaAmbulancia, AM.tipoAmbulancia, DE.cantidadAsignada, De.cantidadFinal, kiti.idTipoAsignacion
  FROM tbl_asignacionkit kiti
  inner join tbl_ambulancia as AM on kiti.idAmbulancia = AM.idAmbulancia
  inner join tbl_detallekit as DE on kiti.idAsignacion = DE.idAsignacion
  inner join tbl_recurso as RE on DE.idRecurso = RE.idRecurso
  where kiti.idAmbulancia = $idAmbulancia;

  elseif ($idPaciente != 0) then
  SELECT PA.idPaciente, PA.numeroDocumento, PA.primerNombre,          DE.cantidadAsignada, De.cantidadFinal, kita.idTipoAsignacion
  FROM tbl_asignacionkit kita
  inner join tbl_paciente PA on kita.idPaciente = PA.idPaciente
  inner join tbl_detallekit as DE on kita.idAsignacion = DE.idAsignacion
  inner join tbl_recurso as RE on DE.idRecurso = RE.idRecurso
  where kita.idPaciente = $idPaciente;
  end if;
END$$

DROP PROCEDURE IF EXISTS `spValidarChatActivo`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spValidarChatActivo`(IN $idUsuario INT, IN $bool INT)
BEGIN
  IF $bool = 1 THEN
    SELECT *
    FROM tbl_chat
    WHERE idReceptorInicial = $idUsuario AND estadoTabla = 1 AND visto = 1;
  ELSE
    SELECT *
    FROM tbl_chat
    WHERE idUsuarioExterno = $idUsuario AND estadoTabla = 1;
  END IF;
END$$

DROP PROCEDURE IF EXISTS `spValidarCorreoElectronico`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spValidarCorreoElectronico`(IN `$email` VARCHAR(100))
BEGIN
  SELECT P.correoElectronico, cU.idUsuario
  FROM tbl_persona P
  INNER JOIN tbl_cuentausuario cU
  ON P.idPersona = CU.idPersona
  WHERE P.correoElectronico = $email
  LIMIT 1;
END$$

DROP PROCEDURE IF EXISTS `spValidarCorreoPersona`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spValidarCorreoPersona`(IN $correoElectronico varchar(50))
BEGIN
  SELECT 1
  FROM tbl_persona
  WHERE correoElectronico = $correoElectronico;
END$$

DROP PROCEDURE IF EXISTS `spValidarDocumentoPersona`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spValidarDocumentoPersona`(IN $numeroDocumento VARCHAR(20))
BEGIN
  SELECT 1
  FROM tbl_persona
  WHERE numeroDocumento = $numeroDocumento;
END$$

DROP PROCEDURE IF EXISTS `spValidarMedico`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spValidarMedico`(IN `$usuario` VARCHAR(45), IN `$clave` VARCHAR(45))
BEGIN
  SELECT primerNombre, primerApellido, numeroDocumento, urlFoto, urlFirma, tbl_persona.idPersona
  FROM tbl_persona
  INNER JOIN tbl_cuentausuario
  ON tbl_cuentausuario.idPersona = tbl_persona.idPersona
  INNER JOIN tbl_rol
  ON tbl_cuentausuario.idRol = tbl_rol.idRol
  WHERE usuario = $usuario AND clave = $clave AND descripcionRol like ('%Medico Externo%');
END$$

DROP PROCEDURE IF EXISTS `spValidarRol`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spValidarRol`()
BEGIN
  SELECT r.descripcionRol
  FROM tbl_cuentausuario cu
  INNER JOIN tbl_rol r
  ON cu.idRol = r.idRol;
END$$

DROP PROCEDURE IF EXISTS `spValidarRolModuloVista`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spValidarRolModuloVista`(IN $idRol INT)
BEGIN
  SELECT r.descripcionRol, m.descripcionModulo, v.descripcionVista
  FROM tbl_rolmodulovista rmv
  INNER JOIN tbl_rol r
  ON rmv.idRol = r.idRol
  INNER JOIN tbl_modulo m
  ON rmv.idModulo = m.idModulo
  INNER JOIN tbl_Vista v
  ON rmv.idVista = v.idVista
  where r.idRol = $idRol;
END$$

DROP PROCEDURE IF EXISTS `spValidarTipoAmbulancia`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spValidarTipoAmbulancia`(IN `$idPersonal` INT)
BEGIN
  SELECT TA.tipoAmbulancia
  FROM tbl_detalleasignacion TD
  INNER JOIN tbl_asignacionPersonal TAP
  ON TD.idAsignacionPersonal = TAP.idAsignacionPersonal
  INNER JOIN tbl_ambulancia TA
  ON TA.idAmbulancia = TAP.idAmbulancia
  WHERE TD.idPersona = (SELECT idPersona FROM tbl_cuentausuario WHERE idUsuario = $idPersonal) AND TD.estadoTabla = 'Activo';
END$$

DROP PROCEDURE IF EXISTS `spValidarUrl`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spValidarUrl`(IN `$idRol` INT)
BEGIN
  SELECT v.urlVista FROM tbl_rolmodulovista rmv
  INNER JOIN tbl_rol r
  ON rmv.idRol = r.idRol
  INNER JOIN tbl_modulo m
  ON rmv.idModulo = m.idModulo
  INNER JOIN tbl_Vista v
  ON rmv.idVista = v.idVista
  where r.idRol = $idRol;
END$$

DROP PROCEDURE IF EXISTS `spValidarUsuario`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spValidarUsuario`(
    IN $usuario varchar (100),
    IN $clave varchar(50))
BEGIN
  SELECT     cu.idUsuario,
             cu.usuario,
             cu.idRol,
             r.descripcionRol,
             p.idPersona,
             concat(p.primerNombre, ' ', p.segundoNombre)    AS nombres,
             concat(p.primerApellido,' ', p.segundoApellido) AS apellidos,
             p.numeroDocumento,
             p.urlFoto
  FROM       tbl_cuentausuario cu
  INNER JOIN tbl_rol r
  ON         cu.idRol = r.idRol INNER JOIN tbl_persona p
  ON         cu.idPersona = p.idPersona
  WHERE      usuario = $usuario
  AND        clave = $clave
  AND        estadoTablaPersona != "Inactivo";
END$$

DROP PROCEDURE IF EXISTS `spValidarUsuarioPersona`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spValidarUsuarioPersona`(IN $usuario varchar(50))
BEGIN
 SELECT 1
 FROM tbl_cuentausuario
 WHERE usuario = $usuario;
END$$

--
-- Funciones
--
DROP FUNCTION IF EXISTS `fnCambiarDisponibilidad`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `fnCambiarDisponibilidad`(`$idAmbulancia` INT) RETURNS int(11)
BEGIN
  DECLARE isProcess INT;
  DECLARE CONTINUE HANDLER FOR SQLEXCEPTION RETURN 0;

  SET isProcess = (
	SELECT COUNT(*) FROM `tbl_ambulancia` WHERE `idAmbulancia` = `$idAmbulancia` AND `estadoTabla` = 'En proceso'
  );

  IF (isProcess = 1) THEN
    UPDATE `tbl_ambulancia` SET `estadoTabla`= 'Personal asignado' WHERE `idAmbulancia` = `$idAmbulancia`;
    RETURN 1;
  ELSE
    RETURN 2;
  END IF;
END$$

DROP FUNCTION IF EXISTS `fnCancelarEmergencia`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `fnCancelarEmergencia`(`$idReporteInicial` INT, `$idDespacho` INT,  `$motivoCancelacion` text) RETURNS int(11)
BEGIN
  DECLARE cantidadDespachos INT;
  DECLARE CONTINUE HANDLER FOR SQLEXCEPTION return 0;

  -- Actulizar el estado del registro del despacho a "Cancelado"
  UPDATE tbl_despacho
  SET estadoDespacho = 'Cancelado'
  WHERE idDespacho = `$idDespacho`;


  -- Insertar novedad de cancelación al reporte inicial
  INSERT INTO `tbl_novedadreporteinicial`(`idNovedad`, `idReporteInicial`,`descripcionNovedad`)
  VALUES (
  null,
  `$idReporteInicial`,
  CONCAT(
    'Cancelación de emergencia ambulancia(',
    (SELECT idAmbulancia FROM tbl_despacho WHERE idDespacho = `$idDespacho` ),') :',
    `$motivoCancelacion`)
  );

  -- Realizar consulta de la cantidad de despachos asociados al reporte inicial
  -- Esto ayudara a validar si puedo o no cancelar el reporte inicial

  SET cantidadDespachos = (SELECT COUNT(idDespacho) AS 'CantidadDespachos'
                           FROM tbl_despacho
                           WHERE idReporteInicial = `$idReporteInicial` AND
                           LOWER(estadoDespacho) <> LOWER('Cancelado') );

  -- Validadr si puedo cancelar el reporte inicial

  IF cantidadDespachos = 0 THEN
    UPDATE tbl_reporteinicial
    SET estadoTablaReporteInicial = 'Cancelado'
    WHERE idReporteInicial = `$idReporteInicial`;
  END IF;

  RETURN 1;
END$$

DROP FUNCTION IF EXISTS `fnContarNovedadesReporte`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `fnContarNovedadesReporte`(idReporte INT) RETURNS int(11)
BEGIN
  DECLARE NumeroNovedades INT;
  SET NumeroNovedades = (SELECT COUNT(idNovedad)
                         FROM tbl_novedadreporteinicial
                         WHERE idReporteInicial = idReporte);
  RETURN NumeroNovedades;
END$$

DROP FUNCTION IF EXISTS `fnFinalizarReporteInicial`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `fnFinalizarReporteInicial`(
  $idReporteInicial INT
) RETURNS int(11)
BEGIN

  SET @catidadDespachos = ( SELECT count(RI.idReporteInicial) AS 'cantidadDespachos'
  FROM tbl_reporteinicial RI
  INNER JOIN tbl_despacho DES ON RI.idReporteInicial = DES.idReporteInicial
  WHERE RI.idReporteInicial = $idReporteInicial AND DES.estadoDespacho <> 'Cancelado' );

  SET @reportesTerminados = ( SELECT count(RI.idReporteInicial) AS 'cantidadReportesTerminados'
  FROM tbl_reporteinicial RI
  INNER JOIN tbl_despacho DES ON RI.idReporteInicial = DES.idReporteInicial
  INNER JOIN tbl_reporteaph RA ON DES.idDespacho = RA.idDespacho
  WHERE RI.idReporteInicial = $idReporteInicial AND DES.estadoDespacho <> 'Cancelado' );

  IF @reportesTerminados = @catidadDespachos THEN
    UPDATE tbl_reporteinicial
    SET estadoTablaReporteInicial = 'Finalizado'
    WHERE idReporteInicial = $idReporteInicial;
    RETURN 1;
  ELSE
    RETURN 0;
  END IF;

END$$

DROP FUNCTION IF EXISTS `fnPedirAyuda`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `fnPedirAyuda`(
    `$idReporteInicial` INT ,
    `$descripcion` text ,
    `$tipoAyuda` INT,
    `$numeroLesionados` INT
    ) RETURNS int(11)
BEGIN
  DECLARE idAutoI INT;
  DECLARE CONTINUE HANDLER FOR SQLEXCEPTION return 0;

  SET idAutoI = (SELECT AUTO_INCREMENT
                 FROM information_schema.TABLES WHERE
                 TABLE_SCHEMA = 'bd_proyecto_salud'
                 AND TABLE_NAME = 'tbl_novedadreporteinicial');

  -- Insertar novedad para pedir una nueva ambulancia
  INSERT INTO `tbl_novedadreporteinicial`(`idReporteInicial`, `descripcionNovedad`, `numeroLesionadosNovedad`, `estadoNovedad`)
  VALUES (`$idReporteInicial`, `$descripcion`,`$numeroLesionados`, 'Activo');

  IF (idAutoI <>  0) THEN
    INSERT INTO `tbl_novedadreporteinicial_enteexterno`(`idEnteExterno`,`idNovedad`)
    VALUES (`$tipoAyuda`, idAutoI);
    RETURN 1;
  ELSE
    RETURN 0;
  END IF;
END$$

DROP FUNCTION IF EXISTS `fnRegistrarPuntolesion`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `fnRegistrarPuntolesion`(`$posX` VARCHAR(45), `$posY` VARCHAR(45), `$idReporteAPH` INT(11)) RETURNS int(11)
BEGIN
  DECLARE idAutoI INT;
  DECLARE CONTINUE HANDLER FOR SQLEXCEPTION return 0;
  SET idAutoI = (
    SELECT AUTO_INCREMENT
    FROM information_schema.TABLES
    WHERE TABLE_SCHEMA = 'bd_proyecto_salud' AND TABLE_NAME = 'tbl_puntolesion'
  );
  INSERT INTO `tbl_puntolesion`(`posX`, `posY`, `idReporteAPH`) VALUES (`$posX`, `$posY`, `$idReporteAPH`);
  IF (idAutoI <>  0) THEN
    RETURN idAutoI;
  ELSE
    RETURN 0;
  END IF;
END$$

DROP FUNCTION IF EXISTS `fnUltimoReporteInicial`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `fnUltimoReporteInicial`() RETURNS int(11)
BEGIN
  DECLARE idReporte INT;
  SET idReporte = (SELECT MAX(idReporteInicial)
                   FROM tbl_reporteinicial);
  RETURN idReporte;
END$$

DROP FUNCTION IF EXISTS `SPLIT_STRING`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `SPLIT_STRING`(`s` VARCHAR(1024), `del` CHAR(1), `i` INT) RETURNS varchar(1024) CHARSET utf8
    DETERMINISTIC
BEGIN
  DECLARE n INT;
  SET n = LENGTH(s) - LENGTH(REPLACE(s, del, '')) + 1;
  IF i > n THEN
    RETURN NULL;
  ELSE
    RETURN SUBSTRING_INDEX(SUBSTRING_INDEX(s, del, i) , del , -1);
  END IF;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_acompanante`
--

DROP TABLE IF EXISTS `tbl_acompanante`;
CREATE TABLE IF NOT EXISTS `tbl_acompanante` (
  `idAcompanante` int(11) NOT NULL AUTO_INCREMENT,
  `lugarExpedicionDocumentoA` varchar(45) DEFAULT NULL,
  `parentescoA` varchar(45) NOT NULL,
  `identificacionA` varchar(45) NOT NULL,
  `nombreA` varchar(45) NOT NULL,
  `telefonoA` varchar(45) DEFAULT NULL,
  `apellidoA` varchar(45) NOT NULL,
  PRIMARY KEY (`idAcompanante`),
  UNIQUE KEY `identificacionA` (`identificacionA`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_afectadoaccidentetransito`
--

DROP TABLE IF EXISTS `tbl_afectadoaccidentetransito`;
CREATE TABLE IF NOT EXISTS `tbl_afectadoaccidentetransito` (
  `idAfectadoAccidenteTransito` int(11) NOT NULL AUTO_INCREMENT,
  `descripcionAfectadoAccidenteTransito` varchar(45) NOT NULL,
  `estadoTabla` varchar(50) NOT NULL DEFAULT 'Activo',
  PRIMARY KEY (`idAfectadoAccidenteTransito`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_ambulancia`
--

DROP TABLE IF EXISTS `tbl_ambulancia`;
CREATE TABLE IF NOT EXISTS `tbl_ambulancia` (
  `idAmbulancia` int(11) NOT NULL AUTO_INCREMENT,
  `tipoAmbulancia` varchar(45) NOT NULL,
  `placaAmbulancia` varchar(45) NOT NULL,
  `estadoTabla` varchar(45) NOT NULL DEFAULT 'Activo',
  PRIMARY KEY (`idAmbulancia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_antecedenteaph`
--

DROP TABLE IF EXISTS `tbl_antecedenteaph`;
CREATE TABLE IF NOT EXISTS `tbl_antecedenteaph` (
  `idAntecedente` int(11) NOT NULL AUTO_INCREMENT,
  `idTipoAntecendente` int(11) NOT NULL,
  `idReporteAPH` int(11) NOT NULL,
  `especificacion` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`idAntecedente`),
  KEY `idReporteAPH` (`idReporteAPH`),
  KEY `idTipoAntecendente` (`idTipoAntecendente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_antecedentedmc`
--

DROP TABLE IF EXISTS `tbl_antecedentedmc`;
CREATE TABLE IF NOT EXISTS `tbl_antecedentedmc` (
  `idAntecedente` int(11) NOT NULL AUTO_INCREMENT,
  `descripcionAntecedente` text NOT NULL,
  `idTipoAntecedente` int(11) NOT NULL,
  `idHistoriaClinica` int(11) NOT NULL,
  PRIMARY KEY (`idAntecedente`),
  KEY `idTipoAntecedente` (`idTipoAntecedente`),
  KEY `idHistoriaClinica` (`idHistoriaClinica`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_asignacionkit`
--

DROP TABLE IF EXISTS `tbl_asignacionkit`;
CREATE TABLE IF NOT EXISTS `tbl_asignacionkit` (
  `idAsignacion` int(11) NOT NULL AUTO_INCREMENT,
  `fechaHoraAsignacion` datetime NOT NULL,
  `estadoTablaAsignacionKit` varchar(45) NOT NULL DEFAULT 'Activo',
  `idPersona` int(11) DEFAULT NULL,
  `idAmbulancia` int(11) DEFAULT NULL,
  `idTipoAsignacion` int(11) DEFAULT NULL,
  `idPaciente` int(11) DEFAULT NULL,
  PRIMARY KEY (`idAsignacion`),
  KEY `idPersona` (`idPersona`),
  KEY `idAmbulancia` (`idAmbulancia`),
  KEY `idTipoAsignacion` (`idTipoAsignacion`),
  KEY `idPaciente` (`idPaciente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_asignacionpersonal`
--

DROP TABLE IF EXISTS `tbl_asignacionpersonal`;
CREATE TABLE IF NOT EXISTS `tbl_asignacionpersonal` (
  `idAsignacionPersonal` int(11) NOT NULL AUTO_INCREMENT,
  `idAmbulancia` int(11) NOT NULL,
  `fechaHoraAsignacion` datetime NOT NULL,
  `estadoTablaAsignacion` varchar(45) DEFAULT 'Activo',
  `longitud` varchar(45) DEFAULT NULL,
  `latitud` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idAsignacionPersonal`),
  KEY `idAmbulancia` (`idAmbulancia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_autorizacion`
--

DROP TABLE IF EXISTS `tbl_autorizacion`;
CREATE TABLE IF NOT EXISTS `tbl_autorizacion` (
  `idAutorizacion` int(11) NOT NULL AUTO_INCREMENT,
  `idUsuarioParamedico` int(11) NOT NULL,
  `idUsuarioMedico` int(11) NOT NULL,
  `idReporteAPH` int(11) NOT NULL,
  `idTipoTratamiento` int(11) DEFAULT NULL,
  `idMedicamento` int(11) DEFAULT NULL,
  `descripcionAutorizacion` text,
  `observacionRespuestaAutorizacion` text,
  `estadoEvaluacion` varchar(45) DEFAULT NULL,
  `fechaEnvio` datetime DEFAULT NULL,
  `fechaEvaluacion` datetime DEFAULT NULL,
  `cedulaPaciente` varchar(45) NOT NULL,
  PRIMARY KEY (`idAutorizacion`),
  KEY `idUsuarioParamedico` (`idUsuarioParamedico`),
  KEY `tbl_autorizacion_medico_idx` (`idUsuarioMedico`),
  KEY `tbl_autorizacion_reporteAPH_idx` (`idReporteAPH`),
  KEY `tbl_autorizacion_tipoTratamiento_idx` (`idTipoTratamiento`),
  KEY `fk_autorizacion_medicamento` (`idMedicamento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_categoriaautorizacion`
--

DROP TABLE IF EXISTS `tbl_categoriaautorizacion`;
CREATE TABLE IF NOT EXISTS `tbl_categoriaautorizacion` (
  `idCategoriaAutorizacion` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(45) NOT NULL,
  `estadoTabla` varchar(50) NOT NULL DEFAULT 'Activo',
  PRIMARY KEY (`idCategoriaAutorizacion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_categoriarecurso`
--

DROP TABLE IF EXISTS `tbl_categoriarecurso`;
CREATE TABLE IF NOT EXISTS `tbl_categoriarecurso` (
  `idCategoriaRecurso` int(11) NOT NULL AUTO_INCREMENT,
  `descripcionCategoriarecurso` varchar(45) NOT NULL,
  `estadoTabla` varchar(50) NOT NULL DEFAULT 'Activo',
  PRIMARY KEY (`idCategoriaRecurso`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_certificadoatencion`
--

DROP TABLE IF EXISTS `tbl_certificadoatencion`;
CREATE TABLE IF NOT EXISTS `tbl_certificadoatencion` (
  `idCertificadoAtencion` int(11) NOT NULL AUTO_INCREMENT,
  `descripcionCertificadoAtencion` varchar(45) NOT NULL,
  `estadoTabla` varchar(50) DEFAULT 'Activo',
  PRIMARY KEY (`idCertificadoAtencion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_chat`
--

DROP TABLE IF EXISTS `tbl_chat`;
CREATE TABLE IF NOT EXISTS `tbl_chat` (
  `idChat` int(11) NOT NULL AUTO_INCREMENT,
  `fechaHoraInicioChat` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `idReceptorInicial` int(11) NOT NULL,
  `idUsuarioExterno` int(11) NOT NULL,
  `estadoTabla` bit(1) NOT NULL DEFAULT b'1',
  `visto` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`idChat`),
  KEY `FK_ID_USUARIO_EXTERNO` (`idUsuarioExterno`),
  KEY `FK_ID_RECEPTOR_INICIAL` (`idReceptorInicial`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_cie10`
--

DROP TABLE IF EXISTS `tbl_cie10`;
CREATE TABLE IF NOT EXISTS `tbl_cie10` (
  `idCIE10` int(11) NOT NULL AUTO_INCREMENT,
  `codigoCIE10` varchar(45) NOT NULL,
  `descripcionCIE10` varchar(1000) NOT NULL,
  `estadoTabla` varchar(50) NOT NULL DEFAULT 'Activo',
  PRIMARY KEY (`idCIE10`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_cita`
--

DROP TABLE IF EXISTS `tbl_cita`;
CREATE TABLE IF NOT EXISTS `tbl_cita` (
  `idCita` int(11) NOT NULL AUTO_INCREMENT,
  `estadoTablaCita` varchar(45) NOT NULL,
  `direccionCita` varchar(45) NOT NULL,
  `fechaCita` date NOT NULL,
  `horaInicial` time NOT NULL,
  `horaFinal` time NOT NULL,
  `telefonoFijo1` varchar(45) NOT NULL,
  `telefonoFijo2` varchar(45) DEFAULT NULL,
  `idPaciente` int(11) NOT NULL,
  `idCUP` int(11) NOT NULL,
  `idZona` int(11) NOT NULL,
  `fechaRegistro` date NOT NULL,
  PRIMARY KEY (`idCita`),
  KEY `idPaciente` (`idPaciente`),
  KEY `idCUP` (`idCUP`),
  KEY `idZona` (`idZona`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_cita_programacion`
--

DROP TABLE IF EXISTS `tbl_cita_programacion`;
CREATE TABLE IF NOT EXISTS `tbl_cita_programacion` (
  `idCitaprogramacion` int(11) NOT NULL AUTO_INCREMENT,
  `idCita` int(11) NOT NULL,
  `idTurnoProgramacion` int(11) NOT NULL,
  PRIMARY KEY (`idCitaprogramacion`),
  KEY `idCita` (`idCita`),
  KEY `idTurnoProgramacion` (`idTurnoProgramacion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_ciudad`
--

DROP TABLE IF EXISTS `tbl_ciudad`;
CREATE TABLE IF NOT EXISTS `tbl_ciudad` (
  `idCiudad` int(11) NOT NULL AUTO_INCREMENT,
  `nombreCiudad` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idCiudad`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1119 ;

--
-- Volcado de datos para la tabla `tbl_ciudad`
--

INSERT INTO `tbl_ciudad` (`idCiudad`, `nombreCiudad`) VALUES
(1, 'Medellín'),
(2, 'Abejorral'),
(3, 'Abriaquí'),
(4, 'Alejandría'),
(5, 'Amagá'),
(6, 'Amalfi'),
(7, 'Andes'),
(8, 'Angelópolis'),
(9, 'Angostura'),
(10, 'Anorí'),
(11, 'Santafé De Antioquia'),
(12, 'Anza'),
(13, 'Apartadó'),
(14, 'Arboletes'),
(15, 'Argelia'),
(16, 'Armenia'),
(17, 'Barbosa'),
(18, 'Belmira'),
(19, 'Bello'),
(20, 'Betania'),
(21, 'Betulia'),
(22, 'Ciudad Bolívar'),
(23, 'Briceño'),
(24, 'Buriticá'),
(25, 'Cáceres'),
(26, 'Caicedo'),
(27, 'Caldas'),
(28, 'Campamento'),
(29, 'Cañasgordas'),
(30, 'Caracolí'),
(31, 'Caramanta'),
(32, 'Carepa'),
(33, 'El Carmen De Viboral'),
(34, 'Carolina'),
(35, 'Caucasia'),
(36, 'Chigorodó'),
(37, 'Cisneros'),
(38, 'Cocorná'),
(39, 'Concepción'),
(40, 'Concordia'),
(41, 'Copacabana'),
(42, 'Dabeiba'),
(43, 'Don Matías'),
(44, 'Ebéjico'),
(45, 'El Bagre'),
(46, 'Entrerrios'),
(47, 'Envigado'),
(48, 'Fredonia'),
(49, 'Frontino'),
(50, 'Giraldo'),
(51, 'Girardota'),
(52, 'Gómez Plata'),
(53, 'Granada'),
(54, 'Guadalupe'),
(55, 'Guarne'),
(56, 'Guatape'),
(57, 'Heliconia'),
(58, 'Hispania'),
(59, 'Itagui'),
(60, 'Ituango'),
(61, 'Jardín'),
(62, 'Jericó'),
(63, 'La Ceja'),
(64, 'La Estrella'),
(65, 'La Pintada'),
(66, 'La Unión'),
(67, 'Liborina'),
(68, 'Maceo'),
(69, 'Marinilla'),
(70, 'Montebello'),
(71, 'Murindó'),
(72, 'Mutatá'),
(73, 'Nariño'),
(74, 'Necoclí'),
(75, 'Nechí'),
(76, 'Olaya'),
(77, 'Peñol'),
(78, 'Peque'),
(79, 'Pueblorrico'),
(80, 'Puerto Berrío'),
(81, 'Puerto Nare'),
(82, 'Puerto Triunfo'),
(83, 'Remedios'),
(84, 'Retiro'),
(85, 'Rionegro'),
(86, 'Sabanalarga'),
(87, 'Sabaneta'),
(88, 'Salgar'),
(89, 'San Andrés De Cuerquía'),
(90, 'San Carlos'),
(91, 'San Francisco'),
(92, 'San Jerónimo'),
(93, 'San José De La Montaña'),
(94, 'San Juan De Urabá'),
(95, 'San Luis'),
(96, 'San Pedro'),
(97, 'San Pedro De Uraba'),
(98, 'San Rafael'),
(99, 'San Roque'),
(100, 'San Vicente'),
(101, 'Santa Rosa De Osos'),
(102, 'Santo Domingo'),
(103, 'El Santuario'),
(104, 'Segovia'),
(105, 'Sonson'),
(106, 'Sopetrán'),
(107, 'Támesis'),
(108, 'Tarazá'),
(109, 'Tarso'),
(110, 'Titiribí'),
(111, 'Toledo'),
(112, 'Turbo'),
(113, 'Uramita'),
(114, 'Urrao'),
(115, 'Valdivia'),
(116, 'Valparaíso'),
(117, 'Vegachí'),
(118, 'Venecia'),
(119, 'Vigía Del Fuerte'),
(120, 'Yalí'),
(121, 'Yarumal'),
(122, 'Yolombó'),
(123, 'Yondó'),
(124, 'Zaragoza'),
(125, 'Barranquilla'),
(126, 'Baranoa'),
(127, 'Campo De La Cruz'),
(128, 'Candelaria'),
(129, 'Galapa'),
(130, 'Juan De Acosta'),
(131, 'Luruaco'),
(132, 'Malambo'),
(133, 'Manatí'),
(134, 'Palmar De Varela'),
(135, 'Piojó'),
(136, 'Polonuevo'),
(137, 'Ponedera'),
(138, 'Puerto Colombia'),
(139, 'Repelón'),
(140, 'Sabanagrande'),
(141, 'Sabanalarga'),
(142, 'Santa Lucía'),
(143, 'Santo Tomás'),
(144, 'Soledad'),
(145, 'Suan'),
(146, 'Tubará'),
(147, 'Usiacurí'),
(148, 'Bogotá, D.C.'),
(149, 'Cartagena'),
(150, 'Achí'),
(151, 'Altos Del Rosario'),
(152, 'Arenal'),
(153, 'Arjona'),
(154, 'Arroyohondo'),
(155, 'Barranco De Loba'),
(156, 'Calamar'),
(157, 'Cantagallo'),
(158, 'Cicuco'),
(159, 'Córdoba'),
(160, 'Clemencia'),
(161, 'El Carmen De Bolívar'),
(162, 'El Guamo'),
(163, 'El Peñón'),
(164, 'Hatillo De Loba'),
(165, 'Magangué'),
(166, 'Mahates'),
(167, 'Margarita'),
(168, 'María La Baja'),
(169, 'Montecristo'),
(170, 'Mompós'),
(171, 'Morales'),
(172, 'Pinillos'),
(173, 'Regidor'),
(174, 'Río Viejo'),
(175, 'San Cristóbal'),
(176, 'San Estanislao'),
(177, 'San Fernando'),
(178, 'San Jacinto'),
(179, 'San Jacinto Del Cauca'),
(180, 'San Juan Nepomuceno'),
(181, 'San Martín De Loba'),
(182, 'San Pablo'),
(183, 'Santa Catalina'),
(184, 'Santa Rosa'),
(185, 'Santa Rosa Del Sur'),
(186, 'Simití'),
(187, 'Soplaviento'),
(188, 'Talaigua Nuevo'),
(189, 'Tiquisio'),
(190, 'Turbaco'),
(191, 'Turbaná'),
(192, 'Villanueva'),
(193, 'Zambrano'),
(194, 'Tunja'),
(195, 'Almeida'),
(196, 'Aquitania'),
(197, 'Arcabuco'),
(198, 'Belén'),
(199, 'Berbeo'),
(200, 'Betéitiva'),
(201, 'Boavita'),
(202, 'Boyacá'),
(203, 'Briceño'),
(204, 'Buenavista'),
(205, 'Busbanzá'),
(206, 'Caldas'),
(207, 'Campohermoso'),
(208, 'Cerinza'),
(209, 'Chinavita'),
(210, 'Chiquinquirá'),
(211, 'Chiscas'),
(212, 'Chita'),
(213, 'Chitaraque'),
(214, 'Chivatá'),
(215, 'Ciénega'),
(216, 'Cómbita'),
(217, 'Coper'),
(218, 'Corrales'),
(219, 'Covarachía'),
(220, 'Cubará'),
(221, 'Cucaita'),
(222, 'Cuítiva'),
(223, 'Chíquiza'),
(224, 'Chivor'),
(225, 'Duitama'),
(226, 'El Cocuy'),
(227, 'El7aspino'),
(228, 'Firavitoba'),
(229, 'Floresta'),
(230, 'Gachantivá'),
(231, 'Gameza'),
(232, 'Garagoa'),
(233, 'Guacamayas'),
(234, 'Guateque'),
(235, 'Guayatá'),
(236, 'Güicán'),
(237, 'Iza'),
(238, 'Jenesano'),
(239, 'Jericó'),
(240, 'Labranzagrande'),
(241, 'La Capilla'),
(242, 'La Victoria'),
(243, 'La Uvita'),
(244, 'Villa De Leyva'),
(245, 'Macanal'),
(246, 'Maripí'),
(247, 'Miraflores'),
(248, 'Mongua'),
(249, 'Monguí'),
(250, 'Moniquirá'),
(251, 'Motavita'),
(252, 'Muzo'),
(253, 'Nobsa'),
(254, 'Nuevo Colón'),
(255, 'Oicatá'),
(256, 'Otanche'),
(257, 'Pachavita'),
(258, 'Páez'),
(259, 'Paipa'),
(260, 'Pajarito'),
(261, 'Panqueba'),
(262, 'Pauna'),
(263, 'Paya'),
(264, 'Paz De Río'),
(265, 'Pesca'),
(266, 'Pisba'),
(267, 'Puerto Boyacá'),
(268, 'Quípama'),
(269, 'Ramiriquí'),
(270, 'Ráquira'),
(271, 'Rondón'),
(272, 'Saboyá'),
(273, 'Sáchica'),
(274, 'Samacá'),
(275, 'San Eduardo'),
(276, 'San José De Pare'),
(277, 'San Luis De Gaceno'),
(278, 'San Mateo'),
(279, 'San Miguel De Sema'),
(280, 'San Pablo De Borbur'),
(281, 'Santana'),
(282, 'Santa María'),
(283, 'Santa Rosa De Viterbo'),
(284, 'Santa Sofía'),
(285, 'Sativanorte'),
(286, 'Sativasur'),
(287, 'Siachoque'),
(288, 'Soatá'),
(289, 'Socotá'),
(290, 'Socha'),
(291, 'Sogamoso'),
(292, 'Somondoco'),
(293, 'Sora'),
(294, 'Sotaquirá'),
(295, 'Soracá'),
(296, 'Susacón'),
(297, 'Sutamarchán'),
(298, 'Sutatenza'),
(299, 'Tasco'),
(300, 'Tenza'),
(301, 'Tibaná'),
(302, 'Tibasosa'),
(303, 'Tinjacá'),
(304, 'Tipacoque'),
(305, 'Toca'),
(306, 'Togüí'),
(307, 'Tópaga'),
(308, 'Tota'),
(309, 'Tununguá'),
(310, 'Turmequé'),
(311, 'Tuta'),
(312, 'Tutazá'),
(313, 'Umbita'),
(314, 'Ventaquemada'),
(315, 'Viracachá'),
(316, 'Zetaquira'),
(317, 'Manizales'),
(318, 'Aguadas'),
(319, 'Anserma'),
(320, 'Aranzazu'),
(321, 'Belalcázar'),
(322, 'Chinchiná'),
(323, 'Filadelfia'),
(324, 'La Dorada'),
(325, 'La Merced'),
(326, 'Manzanares'),
(327, 'Marmato'),
(328, 'Marquetalia'),
(329, 'Marulanda'),
(330, 'Neira'),
(331, 'Norcasia'),
(332, 'Pácora'),
(333, 'Palestina'),
(334, 'Pensilvania'),
(335, 'Riosucio'),
(336, 'Risaralda'),
(337, 'Salamina'),
(338, 'Samaná'),
(339, 'San José'),
(340, 'Supía'),
(341, 'Victoria'),
(342, 'Villamaría'),
(343, 'Viterbo'),
(344, 'Florencia'),
(345, 'Albania'),
(346, 'Belén De Los Andaquies'),
(347, 'Cartagena Del Chairá'),
(348, 'Curillo'),
(349, 'El Doncello'),
(350, 'El Paujil'),
(351, 'La Montañita'),
(352, 'Milán'),
(353, 'Morelia'),
(354, 'Puerto Rico'),
(355, 'San José Del Fragua'),
(356, 'San Vicente Del Caguán'),
(357, 'Solano'),
(358, 'Solita'),
(359, 'Valparaíso'),
(360, 'Popayán'),
(361, 'Almaguer'),
(362, 'Argelia'),
(363, 'Balboa'),
(364, 'Bolívar'),
(365, 'Buenos Aires'),
(366, 'Cajibío'),
(367, 'Caldono'),
(368, 'Caloto'),
(369, 'Corinto'),
(370, 'El Tambo'),
(371, 'Florencia'),
(372, 'Guachené'),
(373, 'Guapi'),
(374, 'Inzá'),
(375, 'Jambaló'),
(376, 'La Sierra'),
(377, 'La Vega'),
(378, 'López'),
(379, 'Mercaderes'),
(380, 'Miranda'),
(381, 'Morales'),
(382, 'Padilla'),
(383, 'Paez'),
(384, 'Patía'),
(385, 'Piamonte'),
(386, 'Piendamó'),
(387, 'Puerto Tejada'),
(388, 'Puracé'),
(389, 'Rosas'),
(390, 'San Sebastián'),
(391, 'Santander De Quilichao'),
(392, 'Santa Rosa'),
(393, 'Silvia'),
(394, 'Sotara'),
(395, 'Suárez'),
(396, 'Sucre'),
(397, 'Timbío'),
(398, 'Timbiquí'),
(399, 'Toribio'),
(400, 'Totoró'),
(401, 'Villa Rica'),
(402, 'Valledupar'),
(403, 'Aguachica'),
(404, 'Agustín Codazzi'),
(405, 'Astrea'),
(406, 'Becerril'),
(407, 'Bosconia'),
(408, 'Chimichagua'),
(409, 'Chiriguaná'),
(410, 'Curumaní'),
(411, 'El Copey'),
(412, 'El Paso'),
(413, 'Gamarra'),
(414, 'González'),
(415, 'La Gloria'),
(416, 'La Jagua De Ibirico'),
(417, 'Manaure'),
(418, 'Pailitas'),
(419, 'Pelaya'),
(420, 'Pueblo Bello'),
(421, 'Río De Oro'),
(422, 'La Paz'),
(423, 'San Alberto'),
(424, 'San Diego'),
(425, 'San Martín'),
(426, 'Tamalameque'),
(427, 'Montería'),
(428, 'Ayapel'),
(429, 'Buenavista'),
(430, 'Canalete'),
(431, 'Cereté'),
(432, 'Chimá'),
(433, 'Chinú'),
(434, 'Ciénaga De Oro'),
(435, 'Cotorra'),
(436, 'La Apartada'),
(437, 'Lorica'),
(438, 'Los Córdobas'),
(439, 'Momil'),
(440, 'Montelíbano'),
(441, 'Moñitos'),
(442, 'Planeta Rica'),
(443, 'Pueblo Nuevo'),
(444, 'Puerto Escondido'),
(445, 'Puerto Libertador'),
(446, 'Purísima'),
(447, 'Sahagún'),
(448, 'San Andrés Sotavento'),
(449, 'San Antero'),
(450, 'San Bernardo Del Viento'),
(451, 'San Carlos'),
(452, 'San Pelayo'),
(453, 'Tierralta'),
(454, 'Valencia'),
(455, 'Agua De Dios'),
(456, 'Albán'),
(457, 'Anapoima'),
(458, 'Anolaima'),
(459, 'Arbeláez'),
(460, 'Beltrán'),
(461, 'Bituima'),
(462, 'Bojacá'),
(463, 'Cabrera'),
(464, 'Cachipay'),
(465, 'Cajicá'),
(466, 'Caparrapí'),
(467, 'Caqueza'),
(468, 'Carmen De Carupa'),
(469, 'Chaguaní'),
(470, 'Chía'),
(471, 'Chipaque'),
(472, 'Choachí'),
(473, 'Chocontá'),
(474, 'Cogua'),
(475, 'Cota'),
(476, 'Cucunubá'),
(477, 'El Colegio'),
(478, 'El Peñón'),
(479, 'El Rosal'),
(480, 'Facatativá'),
(481, 'Fomeque'),
(482, 'Fosca'),
(483, 'Funza'),
(484, 'Fúquene'),
(485, 'Fusagasugá'),
(486, 'Gachala'),
(487, 'Gachancipá'),
(488, 'Gachetá'),
(489, 'Gama'),
(490, 'Girardot'),
(491, 'Granada'),
(492, 'Guachetá'),
(493, 'Guaduas'),
(494, 'Guasca'),
(495, 'Guataquí'),
(496, 'Guatavita'),
(497, 'Guayabal De Siquima'),
(498, 'Guayabetal'),
(499, 'Gutiérrez'),
(500, 'Jerusalén'),
(501, 'Junín'),
(502, 'La Calera'),
(503, 'La Mesa'),
(504, 'La Palma'),
(505, 'La Peña'),
(506, 'La Vega'),
(507, 'Lenguazaque'),
(508, 'Macheta'),
(509, 'Madrid'),
(510, 'Manta'),
(511, 'Medina'),
(512, 'Mosquera'),
(513, 'Nariño'),
(514, 'Nemocón'),
(515, 'Nilo'),
(516, 'Nimaima'),
(517, 'Nocaima'),
(518, 'Venecia'),
(519, 'Pacho'),
(520, 'Pandi'),
(521, 'Paratebueno'),
(522, 'Pasca'),
(523, 'Puerto Salgar'),
(524, 'Pulí'),
(525, 'Quebradanegra'),
(526, 'Quetame'),
(527, 'Quipile'),
(528, 'Apulo'),
(529, 'Ricaurte'),
(530, 'San Antonio Del Tequendama'),
(531, 'San Bernardo'),
(532, 'San Cayetano'),
(533, 'San Francisco'),
(534, 'San Juan De Río Seco'),
(535, 'Sasaima'),
(536, 'Sesquilé'),
(537, 'Sibaté'),
(538, 'Silvania'),
(539, 'Simijaca'),
(540, 'Soacha'),
(541, 'Sopó'),
(542, 'Subachoque'),
(543, 'Suesca'),
(544, 'Supatá'),
(545, 'Susa'),
(546, 'Sutatausa'),
(547, 'Tabio'),
(548, 'Tausa'),
(549, 'Tena'),
(550, 'Tenjo'),
(551, 'Tibacuy'),
(552, 'Tibirita'),
(553, 'Tocaima'),
(554, 'Tocancipá'),
(555, 'Topaipí'),
(556, 'Ubalá'),
(557, 'Ubaque'),
(558, 'Villa De San Diego De Ubate'),
(559, 'Une'),
(560, 'Útica'),
(561, 'Vergara'),
(562, 'Vianí'),
(563, 'Villagómez'),
(564, 'Villapinzón'),
(565, 'Villeta'),
(566, 'Viotá'),
(567, 'Yacopí'),
(568, 'Zipacón'),
(569, 'Zipaquirá'),
(570, 'Quibdó'),
(571, 'Acandí'),
(572, 'Alto Baudo'),
(573, 'Atrato'),
(574, 'Bagadó'),
(575, 'Bahía Solano'),
(576, 'Bajo Baudó'),
(577, 'Belén De Bajirá'),
(578, 'Bojaya'),
(579, 'El Cantón Del San Pablo'),
(580, 'Carmen Del Darien'),
(581, 'Cértegui'),
(582, 'Condoto'),
(583, 'El Carmen De Atrato'),
(584, 'El Litoral Del San Juan'),
(585, 'Istmina'),
(586, 'Juradó'),
(587, 'Lloró'),
(588, 'Medio Atrato'),
(589, 'Medio Baudó'),
(590, 'Medio San Juan'),
(591, 'Nóvita'),
(592, 'Nuquí'),
(593, 'Río Iro'),
(594, 'Río Quito'),
(595, 'Riosucio'),
(596, 'San José Del Palmar'),
(597, 'Sipí'),
(598, 'Tadó'),
(599, 'Unguía'),
(600, 'Unión Panamericana'),
(601, 'Neiva'),
(602, 'Acevedo'),
(603, 'Agrado'),
(604, 'Aipe'),
(605, 'Algeciras'),
(606, 'Altamira'),
(607, 'Baraya'),
(608, 'Campoalegre'),
(609, 'Colombia'),
(610, 'Elías'),
(611, 'Garzón'),
(612, 'Gigante'),
(613, 'Guadalupe'),
(614, 'Hobo'),
(615, 'Iquira'),
(616, 'Isnos'),
(617, 'La Argentina'),
(618, 'La Plata'),
(619, 'Nátaga'),
(620, 'Oporapa'),
(621, 'Paicol'),
(622, 'Palermo'),
(623, 'Palestina'),
(624, 'Pital'),
(625, 'Pitalito'),
(626, 'Rivera'),
(627, 'Saladoblanco'),
(628, 'San Agustín'),
(629, 'Santa María'),
(630, 'Suaza'),
(631, 'Tarqui'),
(632, 'Tesalia'),
(633, 'Tello'),
(634, 'Teruel'),
(635, 'Timaná'),
(636, 'Villavieja'),
(637, 'Yaguará'),
(638, 'Riohacha'),
(639, 'Albania'),
(640, 'Barrancas'),
(641, 'Dibulla'),
(642, 'Distracción'),
(643, 'El Molino'),
(644, 'Fonseca'),
(645, 'Hatonuevo'),
(646, 'La Jagua Del Pilar'),
(647, 'Maicao'),
(648, 'Manaure'),
(649, 'San Juan Del Cesar'),
(650, 'Uribia'),
(651, 'Urumita'),
(652, 'Villanueva'),
(653, 'Santa Marta'),
(654, 'Algarrobo'),
(655, 'Aracataca'),
(656, 'Ariguaní'),
(657, 'Cerro San Antonio'),
(658, 'Chibolo'),
(659, 'Ciénaga'),
(660, 'Concordia'),
(661, 'El Banco'),
(662, 'El Piñon'),
(663, 'El Retén'),
(664, 'Fundación'),
(665, 'Guamal'),
(666, 'Nueva Granada'),
(667, 'Pedraza'),
(668, 'Pijiño Del Carmen'),
(669, 'Pivijay'),
(670, 'Plato'),
(671, 'Puebloviejo'),
(672, 'Remolino'),
(673, 'Sabanas De San Angel'),
(674, 'Salamina'),
(675, 'San Sebastián De Buenavista'),
(676, 'San Zenón'),
(677, 'Santa Ana'),
(678, 'Santa Bárbara De Pinto'),
(679, 'Sitionuevo'),
(680, 'Tenerife'),
(681, 'Zapayán'),
(682, 'Zona Bananera'),
(683, 'Villavicencio'),
(684, 'Acacías'),
(685, 'Barranca De Upía'),
(686, 'Cabuyaro'),
(687, 'Castilla La Nueva'),
(688, 'Cubarral'),
(689, 'Cumaral'),
(690, 'El Calvario'),
(691, 'El Castillo'),
(692, 'El Dorado'),
(693, 'Fuente De Oro'),
(694, 'Granada'),
(695, 'Guamal'),
(696, 'Mapiripán'),
(697, 'Mesetas'),
(698, 'La Macarena'),
(699, 'Uribe'),
(700, 'Lejanías'),
(701, 'Puerto Concordia'),
(702, 'Puerto Gaitán'),
(703, 'Puerto López'),
(704, 'Puerto Lleras'),
(705, 'Puerto Rico'),
(706, 'Restrepo'),
(707, 'San Carlos De Guaroa'),
(708, 'San Juan De Arama'),
(709, 'San Juanito'),
(710, 'San Martín'),
(711, 'Vistahermosa'),
(712, 'Pasto'),
(713, 'Albán'),
(714, 'Aldana'),
(715, 'Ancuyá'),
(716, 'Arboleda'),
(717, 'Barbacoas'),
(718, 'Belén'),
(719, 'Buesaco'),
(720, 'Colón'),
(721, 'Consaca'),
(722, 'Contadero'),
(723, 'Córdoba'),
(724, 'Cuaspud'),
(725, 'Cumbal'),
(726, 'Cumbitara'),
(727, 'Chachagüí'),
(728, 'El Charco'),
(729, 'El Peñol'),
(730, 'El Rosario'),
(731, 'El Tablón De Gómez'),
(732, 'El Tambo'),
(733, 'Funes'),
(734, 'Guachucal'),
(735, 'Guaitarilla'),
(736, 'Gualmatán'),
(737, 'Iles'),
(738, 'Imués'),
(739, 'Ipiales'),
(740, 'La Cruz'),
(741, 'La Florida'),
(742, 'La Llanada'),
(743, 'La Tola'),
(744, 'La Unión'),
(745, 'Leiva'),
(746, 'Linares'),
(747, 'Los Andes'),
(748, 'Magüi'),
(749, 'Mallama'),
(750, 'Mosquera'),
(751, 'Nariño'),
(752, 'Olaya Herrera'),
(753, 'Ospina'),
(754, 'Francisco Pizarro'),
(755, 'Policarpa'),
(756, 'Potosí'),
(757, 'Providencia'),
(758, 'Puerres'),
(759, 'Pupiales'),
(760, 'Ricaurte'),
(761, 'Roberto Payán'),
(762, 'Samaniego'),
(763, 'Sandoná'),
(764, 'San Bernardo'),
(765, 'San Lorenzo'),
(766, 'San Pablo'),
(767, 'San Pedro De Cartago'),
(768, 'Santa Bárbara'),
(769, 'Santacruz'),
(770, 'Sapuyes'),
(771, 'Taminango'),
(772, 'Tangua'),
(773, 'San Andres De Tumaco'),
(774, 'Túquerres'),
(775, 'Yacuanquer'),
(776, 'Cúcuta'),
(777, 'Abrego'),
(778, 'Arboledas'),
(779, 'Bochalema'),
(780, 'Bucarasica'),
(781, 'Cácota'),
(782, 'Cachirá'),
(783, 'Chinácota'),
(784, 'Chitagá'),
(785, 'Convención'),
(786, 'Cucutilla'),
(787, 'Durania'),
(788, 'El Carmen'),
(789, 'El Tarra'),
(790, 'El Zulia'),
(791, 'Gramalote'),
(792, 'Hacarí'),
(793, 'Herrán'),
(794, 'Labateca'),
(795, 'La Esperanza'),
(796, 'La Playa'),
(797, 'Los Patios'),
(798, 'Lourdes'),
(799, 'Mutiscua'),
(800, 'Ocaña'),
(801, 'Pamplona'),
(802, 'Pamplonita'),
(803, 'Puerto Santander'),
(804, 'Ragonvalia'),
(805, 'Salazar'),
(806, 'San Calixto'),
(807, 'San Cayetano'),
(808, 'Santiago'),
(809, 'Sardinata'),
(810, 'Silos'),
(811, 'Teorama'),
(812, 'Tibú'),
(813, 'Toledo'),
(814, 'Villa Caro'),
(815, 'Villa Del Rosario'),
(816, 'Armenia'),
(817, 'Buenavista'),
(818, 'Calarca'),
(819, 'Circasia'),
(820, 'Córdoba'),
(821, 'Filandia'),
(822, 'Génova'),
(823, 'La Tebaida'),
(824, 'Montenegro'),
(825, 'Pijao'),
(826, 'Quimbaya'),
(827, 'Salento'),
(828, 'Pereira'),
(829, 'Apía'),
(830, 'Balboa'),
(831, 'Belén De Umbría'),
(832, 'Dosquebradas'),
(833, 'Guática'),
(834, 'La Celia'),
(835, 'La Virginia'),
(836, 'Marsella'),
(837, 'Mistrató'),
(838, 'Pueblo Rico'),
(839, 'Quinchía'),
(840, 'Santa Rosa De Cabal'),
(841, 'Santuario'),
(842, 'Bucaramanga'),
(843, 'Aguada'),
(844, 'Albania'),
(845, 'Aratoca'),
(846, 'Barbosa'),
(847, 'Barichara'),
(848, 'Barrancabermeja'),
(849, 'Betulia'),
(850, 'Bolívar'),
(851, 'Cabrera'),
(852, 'California'),
(853, 'Capitanejo'),
(854, 'Carcasí'),
(855, 'Cepitá'),
(856, 'Cerrito'),
(857, 'Charalá'),
(858, 'Charta'),
(859, 'Chima'),
(860, 'Chipatá'),
(861, 'Cimitarra'),
(862, 'Concepción'),
(863, 'Confines'),
(864, 'Contratación'),
(865, 'Coromoro'),
(866, 'Curití'),
(867, 'El Carmen De Chucurí'),
(868, 'El Guacamayo'),
(869, 'El Peñón'),
(870, 'El Playón'),
(871, 'Encino'),
(872, 'Enciso'),
(873, 'Florián'),
(874, 'Floridablanca'),
(875, 'Galán'),
(876, 'Gambita'),
(877, 'Girón'),
(878, 'Guaca'),
(879, 'Guadalupe'),
(880, 'Guapotá'),
(881, 'Guavatá'),
(882, 'Güepsa'),
(883, 'Hato'),
(884, 'Jesús María'),
(885, 'Jordán'),
(886, 'La Belleza'),
(887, 'Landázuri'),
(888, 'La Paz'),
(889, 'Lebríja'),
(890, 'Los Santos'),
(891, 'Macaravita'),
(892, 'Málaga'),
(893, 'Matanza'),
(894, 'Mogotes'),
(895, 'Molagavita'),
(896, 'Ocamonte'),
(897, 'Oiba'),
(898, 'Onzaga'),
(899, 'Palmar'),
(900, 'Palmas Del Socorro'),
(901, 'Páramo'),
(902, 'Piedecuesta'),
(903, 'Pinchote'),
(904, 'Puente Nacional'),
(905, 'Puerto Parra'),
(906, 'Puerto Wilches'),
(907, 'Rionegro'),
(908, 'Sabana De Torres'),
(909, 'San Andrés'),
(910, 'San Benito'),
(911, 'San Gil'),
(912, 'San Joaquín'),
(913, 'San José De Miranda'),
(914, 'San Miguel'),
(915, 'San Vicente De Chucurí'),
(916, 'Santa Bárbara'),
(917, 'Santa Helena Del Opón'),
(918, 'Simacota'),
(919, 'Socorro'),
(920, 'Suaita'),
(921, 'Sucre'),
(922, 'Suratá'),
(923, 'Tona'),
(924, 'Valle De San José'),
(925, 'Vélez'),
(926, 'Vetas'),
(927, 'Villanueva'),
(928, 'Zapatoca'),
(929, 'Sincelejo'),
(930, 'Buenavista'),
(931, 'Caimito'),
(932, 'Coloso'),
(933, 'Corozal'),
(934, 'Coveñas'),
(935, 'Chalán'),
(936, 'El Roble'),
(937, 'Galeras'),
(938, 'Guaranda'),
(939, 'La Unión'),
(940, 'Los Palmitos'),
(941, 'Majagual'),
(942, 'Morroa'),
(943, 'Ovejas'),
(944, 'Palmito'),
(945, 'Sampués'),
(946, 'San Benito Abad'),
(947, 'San Juan De Betulia'),
(948, 'San Marcos'),
(949, 'San Onofre'),
(950, 'San Pedro'),
(951, 'San Luis De Sincé'),
(952, 'Sucre'),
(953, 'Santiago De Tolú'),
(954, 'Tolú Viejo'),
(955, 'Ibagué'),
(956, 'Alpujarra'),
(957, 'Alvarado'),
(958, 'Ambalema'),
(959, 'Anzoátegui'),
(960, 'Armero'),
(961, 'Ataco'),
(962, 'Cajamarca'),
(963, 'Carmen De Apicalá'),
(964, 'Casabianca'),
(965, 'Chaparral'),
(966, 'Coello'),
(967, 'Coyaima'),
(968, 'Cunday'),
(969, 'Dolores'),
(970, 'Espinal'),
(971, 'Falan'),
(972, 'Flandes'),
(973, 'Fresno'),
(974, 'Guamo'),
(975, 'Herveo'),
(976, 'Honda'),
(977, 'Icononzo'),
(978, 'Lérida'),
(979, 'Líbano'),
(980, 'Mariquita'),
(981, 'Melgar'),
(982, 'Murillo'),
(983, 'Natagaima'),
(984, 'Ortega'),
(985, 'Palocabildo'),
(986, 'Piedras'),
(987, 'Planadas'),
(988, 'Prado'),
(989, 'Purificación'),
(990, 'Rioblanco'),
(991, 'Roncesvalles'),
(992, 'Rovira'),
(993, 'Saldaña'),
(994, 'San Antonio'),
(995, 'San Luis'),
(996, 'Santa Isabel'),
(997, 'Suárez'),
(998, 'Valle De San Juan'),
(999, 'Venadillo'),
(1000, 'Villahermosa'),
(1001, 'Villarrica'),
(1002, 'Cali'),
(1003, 'Alcalá'),
(1004, 'Andalucía'),
(1005, 'Ansermanuevo'),
(1006, 'Argelia'),
(1007, 'Bolívar'),
(1008, 'Buenaventura'),
(1009, 'Guadalajara De Buga'),
(1010, 'Bugalagrande'),
(1011, 'Caicedonia'),
(1012, 'Calima'),
(1013, 'Candelaria'),
(1014, 'Cartago'),
(1015, 'Dagua'),
(1016, 'El Águila'),
(1017, 'El Cairo'),
(1018, 'El Cerrito'),
(1019, 'El Dovio'),
(1020, 'Florida'),
(1021, 'Ginebra'),
(1022, 'Guacarí'),
(1023, 'Jamundí'),
(1024, 'La Cumbre'),
(1025, 'La Unión'),
(1026, 'La Victoria'),
(1027, 'Obando'),
(1028, 'Palmira'),
(1029, 'Pradera'),
(1030, 'Restrepo'),
(1031, 'Riofrío'),
(1032, 'Roldanillo'),
(1033, 'San Pedro'),
(1034, 'Sevilla'),
(1035, 'Toro'),
(1036, 'Trujillo'),
(1037, 'Tuluá'),
(1038, 'Ulloa'),
(1039, 'Versalles'),
(1040, 'Vijes'),
(1041, 'Yotoco'),
(1042, 'Yumbo'),
(1043, 'Zarzal'),
(1044, 'Arauca'),
(1045, 'Arauquita'),
(1046, 'Cravo Norte'),
(1047, 'Fortul'),
(1048, 'Puerto Rondón'),
(1049, 'Saravena'),
(1050, 'Tame'),
(1051, 'Yopal'),
(1052, 'Aguazul'),
(1053, 'Chameza'),
(1054, 'Hato Corozal'),
(1055, 'La Salina'),
(1056, 'Maní'),
(1057, 'Monterrey'),
(1058, 'Nunchía'),
(1059, 'Orocué'),
(1060, 'Paz De Ariporo'),
(1061, 'Pore'),
(1062, 'Recetor'),
(1063, 'Sabanalarga'),
(1064, 'Sácama'),
(1065, 'San Luis De Palenque'),
(1066, 'Támara'),
(1067, 'Tauramena'),
(1068, 'Trinidad'),
(1069, 'Villanueva'),
(1070, 'Mocoa'),
(1071, 'Colón'),
(1072, 'Orito'),
(1073, 'Puerto Asís'),
(1074, 'Puerto Caicedo'),
(1075, 'Puerto Guzmán'),
(1076, 'Leguízamo'),
(1077, 'Sibundoy'),
(1078, 'San Francisco'),
(1079, 'San Miguel'),
(1080, 'Santiago'),
(1081, 'Valle Del Guamuez'),
(1082, 'Villagarzón'),
(1083, 'San Andrés'),
(1084, 'Providencia'),
(1085, 'Leticia'),
(1086, 'El Encanto'),
(1087, 'La Chorrera'),
(1088, 'La Pedrera'),
(1089, 'La Victoria'),
(1090, 'Miriti - Paraná'),
(1091, 'Puerto Alegría'),
(1092, 'Puerto Arica'),
(1093, 'Puerto Nariño'),
(1094, 'Puerto Santander'),
(1095, 'Tarapacá'),
(1096, 'Inírida'),
(1097, 'Barranco Minas'),
(1098, 'Mapiripana'),
(1099, 'San Felipe'),
(1100, 'Puerto Colombia'),
(1101, 'La Guadalupe'),
(1102, 'Cacahual'),
(1103, 'Pana Pana'),
(1104, 'Morichal'),
(1105, 'San José Del Guaviare'),
(1106, 'Calamar'),
(1107, 'El Retorno'),
(1108, 'Miraflores'),
(1109, 'Mitú'),
(1110, 'Caruru'),
(1111, 'Pacoa'),
(1112, 'Taraira'),
(1113, 'Papunaua'),
(1114, 'Yavaraté'),
(1115, 'Puerto Carreño'),
(1116, 'La Primavera'),
(1117, 'Santa Rosalía'),
(1118, 'Cumaribo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_configuracion`
--

DROP TABLE IF EXISTS `tbl_configuracion`;
CREATE TABLE IF NOT EXISTS `tbl_configuracion` (
  `idConfiguracion` int(11) NOT NULL AUTO_INCREMENT,
  `cantidadCitasDia` int(11) DEFAULT NULL,
  `cantidadCitasMes` int(11) NOT NULL,
  `descripcionConfiguracion` varchar(45) NOT NULL,
  `fechaConfiguracion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `estadoTabla` varchar(50) NOT NULL DEFAULT 'Activo',
  PRIMARY KEY (`idConfiguracion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_cuentausuario`
--

DROP TABLE IF EXISTS `tbl_cuentausuario`;
CREATE TABLE IF NOT EXISTS `tbl_cuentausuario` (
  `idUsuario` int(11) NOT NULL AUTO_INCREMENT,
  `idPersona` int(11) NOT NULL,
  `usuario` varchar(100) NOT NULL,
  `clave` varchar(50) NOT NULL,
  `idRol` int(11) NOT NULL,
  PRIMARY KEY (`idUsuario`),
  UNIQUE KEY `usuario` (`usuario`),
  KEY `idRol` (`idRol`),
  KEY `idPersona` (`idPersona`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Volcado de datos para la tabla `tbl_cuentausuario`
--

INSERT INTO `tbl_cuentausuario` (`idUsuario`, `idPersona`, `usuario`, `clave`, `idRol`) VALUES
(1, 1, 'fernanda05', '+Lsd3riJePoBTC+vWKyJZRwdwL81D+Qua/93f+eleWY=', 1),
(2, 2, 'gjmarin5', 'kRjOs8EWGn96CcDkQZkLS3ArXwb8+pyDA1mNzqZyCPE=', 5),
(3, 3, 'usuga97', 'Gg0DxoPzWroidov9n9z9mJcFbczd9nAE2q/UVyMtkdk=', 6),
(4, 4, 'jcvalencia72', 'z26OMZv+9z58jBr7G1xfcYjvIJ+nqLYji9fsu327eVQ=', 2),
(5, 5, 'sgiraldo58', 'VoFtj1ciTbegQ/pynOqeidtmtJ2lcTVMPzBKsLhRC0Q=', 3),
(6, 6, 'yonirivera', '26wX7oSVXx/2fvRimW4AgGpfhk6e5TbPVgPmq5nynHQ=', 7),
(7, 7, 'ltzapata1', 'q478mkh259KzujbN9YSwcSYJje1LAOLWs0KvEYL4byY=', 4),
(8, 8, 'leydyzapata03@gmail.com', 'zACxC5YOmnlQGAdKAki+ZHq+GYzGvsvQ8q0sfC6cdAc=', 9),
(9, 9, 'monica02', 'AXUEDLSOFWL9I2DnhHtMpHPTfqSMb7ow7CCOVXedcO0=', 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_cuidadoantarribo`
--

DROP TABLE IF EXISTS `tbl_cuidadoantarribo`;
CREATE TABLE IF NOT EXISTS `tbl_cuidadoantarribo` (
  `idCuidadoAntArribo` int(11) NOT NULL AUTO_INCREMENT,
  `descripcionArribo` varchar(45) NOT NULL,
  `idReporteAPH` int(11) NOT NULL,
  PRIMARY KEY (`idCuidadoAntArribo`),
  KEY `idReporteAPH` (`idReporteAPH`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_cup`
--

DROP TABLE IF EXISTS `tbl_cup`;
CREATE TABLE IF NOT EXISTS `tbl_cup` (
  `idCUP` int(11) NOT NULL AUTO_INCREMENT,
  `nombreCUP` varchar(1000) NOT NULL,
  `idConfiguracion` int(11) DEFAULT NULL,
  `idTipoCup` int(11) NOT NULL,
  `codigoCup` varchar(45) NOT NULL,
  `estadoTabla` varchar(50) NOT NULL DEFAULT 'Activo',
  PRIMARY KEY (`idCUP`),
  KEY `idConfiguracion` (`idConfiguracion`),
  KEY `idTipoCup` (`idTipoCup`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_departamento`
--

DROP TABLE IF EXISTS `tbl_departamento`;
CREATE TABLE IF NOT EXISTS `tbl_departamento` (
  `idDepartamento` int(11) NOT NULL AUTO_INCREMENT,
  `nombreDepartamento` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idDepartamento`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=33 ;

--
-- Volcado de datos para la tabla `tbl_departamento`
--

INSERT INTO `tbl_departamento` (`idDepartamento`, `nombreDepartamento`) VALUES
(1, 'Amazonas'),
(2, 'Antioquia'),
(3, 'Arauca'),
(4, 'Atlántico'),
(5, 'Bolívar'),
(6, 'Boyacá'),
(7, 'Caldas'),
(8, 'Caquetá'),
(9, 'Casanare'),
(10, 'Cauca'),
(11, 'Cesar'),
(12, 'Chocó'),
(13, 'Córdoba'),
(14, 'Cundinamarca'),
(15, 'Guainía'),
(16, 'Guaviare'),
(17, 'Huila'),
(18, 'La Guajira'),
(19, 'Magdalena'),
(20, 'Meta'),
(21, 'Nariño'),
(22, 'Norte de Santander'),
(23, 'Putumayo'),
(24, 'Quindío'),
(25, 'Risaralda'),
(26, 'San Andrés y Providencia'),
(27, 'Santander'),
(28, 'Sucre'),
(29, 'Tolima'),
(30, 'Valle del Cauca'),
(31, 'Vaupés'),
(32, 'Vichada');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_desfibrilacion`
--

DROP TABLE IF EXISTS `tbl_desfibrilacion`;
CREATE TABLE IF NOT EXISTS `tbl_desfibrilacion` (
  `iddesfibrilacion` int(11) NOT NULL AUTO_INCREMENT,
  `idReporteAPH` int(11) NOT NULL,
  `horaDesfibrilacion` time NOT NULL,
  `joules` float NOT NULL,
  PRIMARY KEY (`iddesfibrilacion`),
  KEY `idReporteAPH` (`idReporteAPH`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_despacho`
--

DROP TABLE IF EXISTS `tbl_despacho`;
CREATE TABLE IF NOT EXISTS `tbl_despacho` (
  `idDespacho` int(11) NOT NULL AUTO_INCREMENT,
  `idReporteInicial` int(11) NOT NULL,
  `idAmbulancia` int(11) NOT NULL,
  `fechaHoraDespacho` datetime NOT NULL,
  `estadoDespacho` varchar(50) NOT NULL,
  `longitudEmergencia` varchar(200) NOT NULL,
  `latitudEmergencia` varchar(200) NOT NULL,
  `idPersona` int(11) NOT NULL,
  PRIMARY KEY (`idDespacho`),
  KEY `idReporteInicial` (`idReporteInicial`),
  KEY `idAmbulancia` (`idAmbulancia`),
  KEY `fk_idPersona_Despacho` (`idPersona`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_detalleasignacion`
--

DROP TABLE IF EXISTS `tbl_detalleasignacion`;
CREATE TABLE IF NOT EXISTS `tbl_detalleasignacion` (
  `idDetalleAsignacion` int(11) NOT NULL AUTO_INCREMENT,
  `idAsignacionPersonal` int(11) NOT NULL,
  `idPersona` int(11) NOT NULL,
  `estadoTabla` varchar(50) NOT NULL DEFAULT 'Activo',
  `cargoPersona` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`idDetalleAsignacion`),
  KEY `idAsignacionPersonal` (`idAsignacionPersonal`),
  KEY `idPersona` (`idPersona`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_detallekit`
--

DROP TABLE IF EXISTS `tbl_detallekit`;
CREATE TABLE IF NOT EXISTS `tbl_detallekit` (
  `idDetallekit` int(11) NOT NULL AUTO_INCREMENT,
  `cantidadAsignada` int(11) NOT NULL,
  `cantidadFinal` int(11) NOT NULL,
  `idrecurso` int(11) NOT NULL,
  `idAsignacion` int(11) NOT NULL,
  PRIMARY KEY (`idDetallekit`),
  KEY `idAsignacion` (`idAsignacion`),
  KEY `idrecurso` (`idrecurso`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_detalletratamientodmcrecurso`
--

DROP TABLE IF EXISTS `tbl_detalletratamientodmcrecurso`;
CREATE TABLE IF NOT EXISTS `tbl_detalletratamientodmcrecurso` (
  `idDetalleTratamientodmcRecurso` int(11) NOT NULL AUTO_INCREMENT,
  `idRecurso` int(11) NOT NULL,
  `idTratamiento` int(11) NOT NULL,
  PRIMARY KEY (`idDetalleTratamientodmcRecurso`),
  KEY `tbl_detalletratamientodmcRecurso_ibfk_1_idx` (`idRecurso`),
  KEY `tbl_detalletratamientodmcRecurso_ibfk_2_idx` (`idTratamiento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_devolucion`
--

DROP TABLE IF EXISTS `tbl_devolucion`;
CREATE TABLE IF NOT EXISTS `tbl_devolucion` (
  `idDevolucion` int(11) NOT NULL AUTO_INCREMENT,
  `cantidad` int(11) NOT NULL,
  `fechaHoraDevolucion` datetime NOT NULL,
  `estadoTablaDevolucion` varchar(45) NOT NULL,
  `idTipoDevolucion` int(11) NOT NULL,
  `idDetallekit` int(11) NOT NULL,
  `idPersona` int(11) NOT NULL,
  PRIMARY KEY (`idDevolucion`),
  KEY `idTipoDevolucion` (`idTipoDevolucion`),
  KEY `idDetallekit` (`idDetallekit`),
  KEY `idPersona` (`idPersona`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_diagnostico`
--

DROP TABLE IF EXISTS `tbl_diagnostico`;
CREATE TABLE IF NOT EXISTS `tbl_diagnostico` (
  `idDiagnostico` int(11) NOT NULL AUTO_INCREMENT,
  `idHistoriaClinica` int(11) NOT NULL,
  `descripcionDiagnostico` text NOT NULL,
  `idCIE10` int(11) NOT NULL,
  PRIMARY KEY (`idDiagnostico`),
  KEY `idCIE10` (`idCIE10`),
  KEY `idHistoriaClinica` (`idHistoriaClinica`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_enteexterno`
--

DROP TABLE IF EXISTS `tbl_enteexterno`;
CREATE TABLE IF NOT EXISTS `tbl_enteexterno` (
  `idEnteExterno` int(11) NOT NULL AUTO_INCREMENT,
  `descripcionEnteExterno` varchar(45) NOT NULL,
  `estadoTabla` varchar(50) NOT NULL DEFAULT 'Activo',
  PRIMARY KEY (`idEnteExterno`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_enteexterno_reporteinicial`
--

DROP TABLE IF EXISTS `tbl_enteexterno_reporteinicial`;
CREATE TABLE IF NOT EXISTS `tbl_enteexterno_reporteinicial` (
  `idEnteExternoReporteInicial` int(11) NOT NULL AUTO_INCREMENT,
  `idEnteExterno` int(11) NOT NULL,
  `idReporteInicial` int(11) NOT NULL,
  PRIMARY KEY (`idEnteExternoReporteInicial`),
  KEY `idEnteExterno` (`idEnteExterno`),
  KEY `idReporteInicial` (`idReporteInicial`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_equipobiomedico`
--

DROP TABLE IF EXISTS `tbl_equipobiomedico`;
CREATE TABLE IF NOT EXISTS `tbl_equipobiomedico` (
  `idEquipoBiomedico` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(50) DEFAULT NULL,
  `idTratamiento` int(11) DEFAULT NULL,
  PRIMARY KEY (`idEquipoBiomedico`),
  KEY `tbl_equipobiomedico_ibfk_1_idx` (`idTratamiento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_especialidad`
--

DROP TABLE IF EXISTS `tbl_especialidad`;
CREATE TABLE IF NOT EXISTS `tbl_especialidad` (
  `idEspecialidad` int(11) NOT NULL AUTO_INCREMENT,
  `descripcionEspecialidad` varchar(45) NOT NULL,
  `estadoTabla` varchar(50) NOT NULL DEFAULT 'Activo',
  PRIMARY KEY (`idEspecialidad`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `tbl_especialidad`
--

INSERT INTO `tbl_especialidad` (`idEspecialidad`, `descripcionEspecialidad`, `estadoTabla`) VALUES
(1, 'Nutricionista', 'Activo'),
(2, 'Psicólogo', 'Activo'),
(3, 'Fisioterapeuta', 'Activo'),
(4, 'Médico General', 'Activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_estadopaciente`
--

DROP TABLE IF EXISTS `tbl_estadopaciente`;
CREATE TABLE IF NOT EXISTS `tbl_estadopaciente` (
  `idEstadoPaciente` int(11) NOT NULL AUTO_INCREMENT,
  `descripcionEstadoPaciente` varchar(50) DEFAULT NULL,
  `estadoTabla` varchar(50) DEFAULT 'Activo',
  PRIMARY KEY (`idEstadoPaciente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_estandarkit`
--

DROP TABLE IF EXISTS `tbl_estandarkit`;
CREATE TABLE IF NOT EXISTS `tbl_estandarkit` (
  `idEstandarkit` int(11) NOT NULL AUTO_INCREMENT,
  `idRecurso` int(11) NOT NULL,
  `unidadMedida` varchar(30) NOT NULL,
  `stockminKit` int(11) DEFAULT NULL,
  `idTipoKit` int(11) NOT NULL,
  `estadoTablaEstandarKit` varchar(45) NOT NULL DEFAULT 'Activo',
  PRIMARY KEY (`idEstandarkit`),
  KEY `FK_ESTANDAR_KIT_TIPO_KIT` (`idTipoKit`),
  KEY `FK_ESTANDAR_KIT_RECURSO` (`idRecurso`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_evaluacionautorizacion`
--

DROP TABLE IF EXISTS `tbl_evaluacionautorizacion`;
CREATE TABLE IF NOT EXISTS `tbl_evaluacionautorizacion` (
  `idEvaluacionAutorizacion` int(11) NOT NULL AUTO_INCREMENT,
  `idReporteAPH` int(11) NOT NULL,
  `idCuentaMedico` int(11) NOT NULL,
  `idAutorizacion` int(11) NOT NULL,
  `evaluacionAutorizacion` varchar(45) NOT NULL,
  `descripcionEvaluacion` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`idEvaluacionAutorizacion`),
  KEY `idReporteAPH` (`idReporteAPH`),
  KEY `idCuentaMedico` (`idCuentaMedico`),
  KEY `idAutorizacion` (`idAutorizacion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_examenespecializado`
--

DROP TABLE IF EXISTS `tbl_examenespecializado`;
CREATE TABLE IF NOT EXISTS `tbl_examenespecializado` (
  `idExamenEspecializado` int(11) NOT NULL AUTO_INCREMENT,
  `observaciones` text NOT NULL,
  `idTipoexamenespecializado` int(11) NOT NULL,
  `idHistoriaClinica` int(11) NOT NULL,
  `descripcion` text,
  PRIMARY KEY (`idExamenEspecializado`),
  KEY `idTipoexamenespecializado` (`idTipoexamenespecializado`),
  KEY `idHistoriaClinica` (`idHistoriaClinica`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_examenfisicoaph`
--

DROP TABLE IF EXISTS `tbl_examenfisicoaph`;
CREATE TABLE IF NOT EXISTS `tbl_examenfisicoaph` (
  `idExamenFisico` int(11) NOT NULL AUTO_INCREMENT,
  `horaExamenFisico` time NOT NULL,
  `estadoRespiracion` varchar(45) NOT NULL,
  `respiracion_min` int(11) NOT NULL,
  `SpO2` varchar(45) NOT NULL,
  `estadoPulso` varchar(45) NOT NULL,
  `pulsaciones_min` int(11) NOT NULL,
  `estadoPresionArterial` varchar(45) NOT NULL,
  `sistolica` float NOT NULL,
  `diastolica` float NOT NULL,
  `PAM` float NOT NULL,
  `glucometria` float NOT NULL,
  `conciencia` varchar(45) NOT NULL,
  `glasgow` varchar(45) NOT NULL,
  `estadoPupilaD` varchar(45) DEFAULT NULL,
  `estadoPupilaI` varchar(45) DEFAULT NULL,
  `gradoDilatacionPD` float DEFAULT NULL,
  `gradoDilatacionPI` float DEFAULT NULL,
  `estadoHemodinamico` varchar(45) NOT NULL,
  `especificacionVerbal` varchar(100) NOT NULL,
  `especificacionOcular` varchar(100) NOT NULL,
  `especificacionMotor` varchar(100) NOT NULL,
  `EspecifiqueExamenFisico` text,
  PRIMARY KEY (`idExamenFisico`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_examenfisicodmc`
--

DROP TABLE IF EXISTS `tbl_examenfisicodmc`;
CREATE TABLE IF NOT EXISTS `tbl_examenfisicodmc` (
  `idExamenFisico` int(11) NOT NULL AUTO_INCREMENT,
  `idHistoriaClinica` int(11) NOT NULL,
  `estadoTablaExamen` varchar(45) NOT NULL,
  `descripcionExamen` text,
  `idtipoExamenFisico` int(11) NOT NULL,
  PRIMARY KEY (`idExamenFisico`),
  KEY `idtipoExamenFisico` (`idtipoExamenFisico`),
  KEY `idHistoriaClinica` (`idHistoriaClinica`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_formulamedica`
--

DROP TABLE IF EXISTS `tbl_formulamedica`;
CREATE TABLE IF NOT EXISTS `tbl_formulamedica` (
  `idFormulaMedica` int(11) NOT NULL AUTO_INCREMENT,
  `recomendaciones` varchar(1000) NOT NULL,
  `idHistoriaClinica` int(11) NOT NULL,
  PRIMARY KEY (`idFormulaMedica`),
  KEY `idHistoriaClinica` (`idHistoriaClinica`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_formulamedicamedicamentodmc`
--

DROP TABLE IF EXISTS `tbl_formulamedicamedicamentodmc`;
CREATE TABLE IF NOT EXISTS `tbl_formulamedicamedicamentodmc` (
  `idFormulaMedicaMedicamentoDmc` int(11) NOT NULL AUTO_INCREMENT,
  `idFormulamedica` int(11) NOT NULL,
  `idMedicamento` int(11) NOT NULL,
  `cantidadMedicamento` int(11) NOT NULL,
  `dosificacion` varchar(100) NOT NULL,
  `descripcion` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`idFormulaMedicaMedicamentoDmc`),
  KEY `idFormulamedica` (`idFormulamedica`),
  KEY `tbl_formulamedicamedicamentodmc_ibfk_2_idx` (`idMedicamento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_historiaclinica`
--

DROP TABLE IF EXISTS `tbl_historiaclinica`;
CREATE TABLE IF NOT EXISTS `tbl_historiaclinica` (
  `idHistoriaClinica` int(11) NOT NULL AUTO_INCREMENT,
  `fechaAtencion` date DEFAULT NULL,
  `motivoAtencion` text NOT NULL,
  `enfermedadActual` text,
  `placaVehiculo` varchar(45) NOT NULL,
  `idTipoorigenatencion` int(11) DEFAULT NULL,
  `idCitaprogramacion` int(11) DEFAULT NULL,
  `idPaciente` int(11) DEFAULT NULL,
  `evolucion` text NOT NULL,
  PRIMARY KEY (`idHistoriaClinica`),
  KEY `idTipoorigenatencion` (`idTipoorigenatencion`),
  KEY `idCitaprogramacion` (`idCitaprogramacion`),
  KEY `idPaciente` (`idPaciente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_historialmora`
--

DROP TABLE IF EXISTS `tbl_historialmora`;
CREATE TABLE IF NOT EXISTS `tbl_historialmora` (
  `idHistorialMora` int(11) NOT NULL AUTO_INCREMENT,
  `fechaHistorial` date NOT NULL,
  `descripcionHistorial` varchar(45) NOT NULL,
  `idCita` int(11) NOT NULL,
  `idMulta` int(11) NOT NULL,
  PRIMARY KEY (`idHistorialMora`),
  KEY `idCita` (`idCita`),
  KEY `idMulta` (`idMulta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_incapacidad`
--

DROP TABLE IF EXISTS `tbl_incapacidad`;
CREATE TABLE IF NOT EXISTS `tbl_incapacidad` (
  `idIncapacidad` int(11) NOT NULL AUTO_INCREMENT,
  `cantidadDias` int(11) DEFAULT NULL,
  `prorroga` varchar(100) DEFAULT NULL,
  `descripcionMotivo` text,
  `idCIE10` int(11) DEFAULT NULL,
  `idHistoriaClinica` int(11) NOT NULL,
  PRIMARY KEY (`idIncapacidad`),
  KEY `idCIE10` (`idCIE10`),
  KEY `idHistoriaClinica` (`idHistoriaClinica`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_interconsulta`
--

DROP TABLE IF EXISTS `tbl_interconsulta`;
CREATE TABLE IF NOT EXISTS `tbl_interconsulta` (
  `idInterconsulta` int(11) NOT NULL AUTO_INCREMENT,
  `descripcionInterconsulta` text NOT NULL,
  `especialidad` varchar(100) NOT NULL,
  `idHistoriaClinica` int(11) NOT NULL,
  `fechaLimite` date NOT NULL,
  PRIMARY KEY (`idInterconsulta`),
  KEY `idHistoriaClinica` (`idHistoriaClinica`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_lesion`
--

DROP TABLE IF EXISTS `tbl_lesion`;
CREATE TABLE IF NOT EXISTS `tbl_lesion` (
  `idLesion` int(11) NOT NULL AUTO_INCREMENT,
  `idPuntoLesion` int(11) NOT NULL,
  `especificacionLesion` varchar(100) DEFAULT NULL,
  `idCIE10` int(11) NOT NULL,
  PRIMARY KEY (`idLesion`),
  KEY `idReporteAPH` (`idPuntoLesion`),
  KEY `idCIE10` (`idCIE10`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_llamada`
--

DROP TABLE IF EXISTS `tbl_llamada`;
CREATE TABLE IF NOT EXISTS `tbl_llamada` (
  `idLlamada` int(11) NOT NULL AUTO_INCREMENT,
  `idChat` int(11) NOT NULL,
  `urlLlamada` varchar(100) NOT NULL,
  `fechaHoraLlamada` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idLlamada`),
  KEY `idChat` (`idChat`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_medicamento`
--

DROP TABLE IF EXISTS `tbl_medicamento`;
CREATE TABLE IF NOT EXISTS `tbl_medicamento` (
  `idmedicamento` int(11) NOT NULL AUTO_INCREMENT,
  `idReporteAPH` int(11) DEFAULT NULL,
  `dosis` varchar(45) NOT NULL,
  `hora` time NOT NULL,
  `viaAdministracion` varchar(45) NOT NULL,
  `cantidadUnidades` int(11) NOT NULL,
  `idDetallekit` int(11) NOT NULL,
  `idHistoriaClinica` int(11) DEFAULT NULL,
  PRIMARY KEY (`idmedicamento`),
  KEY `idReporteAPH` (`idReporteAPH`),
  KEY `idDetallekit` (`idDetallekit`),
  KEY `idHistoriaClinica` (`idHistoriaClinica`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_mensaje`
--

DROP TABLE IF EXISTS `tbl_mensaje`;
CREATE TABLE IF NOT EXISTS `tbl_mensaje` (
  `idMensaje` int(11) NOT NULL AUTO_INCREMENT,
  `idChat` int(11) NOT NULL,
  `mensaje` varchar(200) NOT NULL,
  `fechaHora` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `tipo` int(11) NOT NULL,
  PRIMARY KEY (`idMensaje`),
  KEY `idChat` (`idChat`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_modulo`
--

DROP TABLE IF EXISTS `tbl_modulo`;
CREATE TABLE IF NOT EXISTS `tbl_modulo` (
  `idModulo` int(11) NOT NULL AUTO_INCREMENT,
  `descripcionModulo` varchar(100) NOT NULL,
  `iconoModulo` varchar(50) NOT NULL,
  PRIMARY KEY (`idModulo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Volcado de datos para la tabla `tbl_modulo`
--

INSERT INTO `tbl_modulo` (`idModulo`, `descripcionModulo`, `iconoModulo`) VALUES
(1, 'Cuentas de Usuario', 'user'),
(2, 'Reporte Inicial ', 'file-text'),
(3, 'Despachador', 'location-arrow'),
(4, 'Reporte APH', 'file-text'),
(5, 'Stock', 'th-large'),
(6, 'Paciente', 'users'),
(7, 'Programación', 'calendar-check-o'),
(8, 'Citas', 'edit'),
(9, 'Historia Clínica', 'user-md');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_motivoconsulta`
--

DROP TABLE IF EXISTS `tbl_motivoconsulta`;
CREATE TABLE IF NOT EXISTS `tbl_motivoconsulta` (
  `idMotivoConsulta` int(11) NOT NULL AUTO_INCREMENT,
  `descripcionMotivoConsulta` varchar(45) NOT NULL,
  `TipoMotivoConsulta` varchar(45) NOT NULL,
  PRIMARY KEY (`idMotivoConsulta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_multa`
--

DROP TABLE IF EXISTS `tbl_multa`;
CREATE TABLE IF NOT EXISTS `tbl_multa` (
  `idMulta` int(11) NOT NULL AUTO_INCREMENT,
  `diasMulta` int(11) DEFAULT NULL,
  `fechaMulta` date DEFAULT NULL,
  `estadoTabla` varchar(50) NOT NULL DEFAULT 'Activo',
  PRIMARY KEY (`idMulta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_notaenfermeria`
--

DROP TABLE IF EXISTS `tbl_notaenfermeria`;
CREATE TABLE IF NOT EXISTS `tbl_notaenfermeria` (
  `idNotaEnfermeria` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(200) DEFAULT NULL,
  `idPersona` int(11) DEFAULT NULL,
  `idProcedimiento` int(11) DEFAULT NULL,
  PRIMARY KEY (`idNotaEnfermeria`),
  KEY `idPersona` (`idPersona`),
  KEY `idProcedimiento` (`idProcedimiento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_novedadrecurso`
--

DROP TABLE IF EXISTS `tbl_novedadrecurso`;
CREATE TABLE IF NOT EXISTS `tbl_novedadrecurso` (
  `idNovedadRecurso` int(11) NOT NULL AUTO_INCREMENT,
  `descripcionNovedad` text,
  `fechaHoraNovedad` datetime NOT NULL,
  `estadoTablaNovedad` varchar(45) NOT NULL,
  `idDetallekit` int(11) NOT NULL,
  `idPersona` int(11) NOT NULL,
  `idTipoNovedad` int(11) NOT NULL,
  PRIMARY KEY (`idNovedadRecurso`),
  KEY `idDetallekit` (`idDetallekit`),
  KEY `idPersona` (`idPersona`),
  KEY `idTipoNovedad` (`idTipoNovedad`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_novedadreporteinicial`
--

DROP TABLE IF EXISTS `tbl_novedadreporteinicial`;
CREATE TABLE IF NOT EXISTS `tbl_novedadreporteinicial` (
  `idNovedad` int(11) NOT NULL AUTO_INCREMENT,
  `idReporteInicial` int(11) NOT NULL,
  `descripcionNovedad` text NOT NULL,
  `fechaHoraNovedad` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `numeroLesionadosNovedad` int(11) DEFAULT NULL,
  `estadoNovedad` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`idNovedad`),
  KEY `idReporteInicial` (`idReporteInicial`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_novedadreporteinicial_enteexterno`
--

DROP TABLE IF EXISTS `tbl_novedadreporteinicial_enteexterno`;
CREATE TABLE IF NOT EXISTS `tbl_novedadreporteinicial_enteexterno` (
  `idNovedadReporteInicialEnteExterno` int(11) NOT NULL AUTO_INCREMENT,
  `idEnteExterno` int(11) NOT NULL,
  `idNovedad` int(11) NOT NULL,
  PRIMARY KEY (`idNovedadReporteInicialEnteExterno`),
  KEY `idNovedad` (`idNovedad`),
  KEY `idEnteExterno` (`idEnteExterno`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_observacion`
--

DROP TABLE IF EXISTS `tbl_observacion`;
CREATE TABLE IF NOT EXISTS `tbl_observacion` (
  `idObservacion` int(11) NOT NULL AUTO_INCREMENT,
  `idPersonaResponsable` int(11) DEFAULT NULL,
  `descripcionObservacion` varchar(1000) NOT NULL,
  `fechaObservacion` date NOT NULL,
  `idProcedimiento` int(11) NOT NULL,
  PRIMARY KEY (`idObservacion`),
  KEY `idProcedimiento` (`idProcedimiento`),
  KEY `idPersonaResponsable` (`idPersonaResponsable`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_otrodmc`
--

DROP TABLE IF EXISTS `tbl_otrodmc`;
CREATE TABLE IF NOT EXISTS `tbl_otrodmc` (
  `idOtro` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` text NOT NULL,
  `idHistoriaClinica` int(11) NOT NULL,
  PRIMARY KEY (`idOtro`),
  KEY `idHistoriaClinica` (`idHistoriaClinica`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_paciente`
--

DROP TABLE IF EXISTS `tbl_paciente`;
CREATE TABLE IF NOT EXISTS `tbl_paciente` (
  `idPaciente` int(11) NOT NULL AUTO_INCREMENT,
  `numeroDocumento` varchar(45) NOT NULL,
  `fechaNacimiento` date DEFAULT NULL,
  `tipoSangre` varchar(45) DEFAULT NULL,
  `primerNombre` varchar(45) NOT NULL,
  `segundoNombre` varchar(45) DEFAULT NULL,
  `primerApellido` varchar(45) NOT NULL,
  `segundoApellido` varchar(45) DEFAULT NULL,
  `genero` varchar(45) NOT NULL,
  `estadoCivil` varchar(45) DEFAULT NULL,
  `ciudadResidencia` varchar(45) NOT NULL,
  `barrioResidencia` varchar(45) DEFAULT NULL,
  `direccion` varchar(45) DEFAULT NULL,
  `telefonoFijo` varchar(45) DEFAULT NULL,
  `telefonoMovil` varchar(45) DEFAULT NULL,
  `correoElectronico` varchar(45) DEFAULT NULL,
  `empresa` varchar(45) DEFAULT NULL,
  `ocupacion` varchar(45) DEFAULT NULL,
  `profesion` varchar(45) DEFAULT NULL,
  `fechaAfiliacionRegistro` date DEFAULT NULL,
  `idtipoDocumento` int(11) NOT NULL,
  `idtipoAfiliacion` int(11) DEFAULT NULL,
  `edadPaciente` varchar(10) NOT NULL,
  `url` varchar(250) DEFAULT NULL,
  `idEstadoPaciente` int(11) DEFAULT NULL,
  PRIMARY KEY (`idPaciente`),
  UNIQUE KEY `numeroDocumento` (`numeroDocumento`),
  KEY `idtipoDocumento` (`idtipoDocumento`),
  KEY `idtipoAfiliacion` (`idtipoAfiliacion`),
  KEY `FK_PACIENTE_ESTADO_PACIENTE` (`idEstadoPaciente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_persona`
--

DROP TABLE IF EXISTS `tbl_persona`;
CREATE TABLE IF NOT EXISTS `tbl_persona` (
  `idPersona` int(11) NOT NULL AUTO_INCREMENT,
  `primerNombre` varchar(50) NOT NULL,
  `segundoNombre` varchar(50) DEFAULT NULL,
  `primerApellido` varchar(50) NOT NULL,
  `segundoApellido` varchar(50) DEFAULT NULL,
  `idTipoDocumento` int(11) DEFAULT NULL,
  `numeroDocumento` varchar(20) NOT NULL,
  `lugarExpedicionDocumento` varchar(50) DEFAULT NULL,
  `fechaNacimiento` date DEFAULT NULL,
  `lugarNacimiento` varchar(45) DEFAULT NULL,
  `sexo` varchar(45) DEFAULT NULL,
  `direccion` varchar(45) DEFAULT NULL,
  `telefono` varchar(45) DEFAULT NULL,
  `correoElectronico` varchar(45) DEFAULT NULL,
  `grupoSanguineo` varchar(45) DEFAULT NULL,
  `ciudad` varchar(45) DEFAULT NULL,
  `departamento` varchar(45) DEFAULT NULL,
  `pais` varchar(45) DEFAULT NULL,
  `urlHojaDeVida` varchar(250) DEFAULT NULL,
  `urlFirma` varchar(250) DEFAULT NULL,
  `urlFoto` varchar(250) DEFAULT NULL,
  `estadoTablaPersona` varchar(50) DEFAULT 'Activo',
  `dependencia` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idPersona`),
  UNIQUE KEY `numeroDocumento` (`numeroDocumento`),
  UNIQUE KEY `correoElectronico` (`correoElectronico`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Volcado de datos para la tabla `tbl_persona`
--

INSERT INTO `tbl_persona` (`idPersona`, `primerNombre`, `segundoNombre`, `primerApellido`, `segundoApellido`, `idTipoDocumento`, `numeroDocumento`, `lugarExpedicionDocumento`, `fechaNacimiento`, `lugarNacimiento`, `sexo`, `direccion`, `telefono`, `correoElectronico`, `grupoSanguineo`, `ciudad`, `departamento`, `pais`, `urlHojaDeVida`, `urlFirma`, `urlFoto`, `estadoTablaPersona`, `dependencia`) VALUES
(1, 'Luisa', 'Fernanda', 'Parra', 'Arboleda', 1, '1045050624', 'Tamesis', '1997-09-25', 'Tamesis', 'Femenino', 'Calle 30A #72-05', '2357684', 'lfparra25@misena.edu.co', 'O+', 'Medellin', 'Antioquia', 'Colombia', NULL, NULL, 'Public/Img/Usuarios/FotosPersona/default.png', 'Activo', 'APH'),
(2, 'Gabriel', 'Jaime', 'Marin', 'Isaza', 1, '1035039815', 'Copacabana', '1998-01-28', 'Bello', 'Masculino', 'cra 70 cll 3b-02', '2379195', 'gjmarin5@misena.edu.co', 'A+', 'Medellin', 'Antioquia', 'Colombia', NULL, NULL, 'Public/Img/Usuarios/FotosPersona/default.png', 'Activo', 'APH'),
(3, 'Daniela ', 'Maria', 'Usuga', 'Usuga', 1, '1001544711', 'Medellin', '1997-09-22', 'Frontino', 'Femenino', 'cll 54 #34b', '4382858', 'usuga-@hotmail.com', 'B+', 'Medellin', 'Antioquia', 'Colombia', NULL, NULL, 'Public/Img/Usuarios/FotosPersona/default.png', 'Activo', 'Domiciliaria'),
(4, 'Juan ', 'Carlos', 'Valencia', 'Panchana', 1, '102048343', 'Bello', '1997-09-01', 'Bello', 'Masculino', 'Av. 47A #63-75', '2066967', 'jcvalencia72@misena.edu.co', 'A+', 'Medellin', 'Antioquia', 'Colombia', NULL, NULL, 'Public/Img/Usuarios/FotosPersona/default.png', 'Activo', 'APH'),
(5, 'Santiago', '', 'Giraldo', 'Escudero', 1, '1000634785', 'Bello', '1997-12-05', 'Medellin', 'Masculino', 'cra. 98 #01-01', '3205966848', 'sgiraldo58@misena.edu.co', 'A+', 'Medellin', 'Antioquia', 'Colombia', NULL, NULL, 'Public/Img/Usuarios/FotosPersona/default.png', 'Activo', 'APH'),
(6, 'Yoni', 'Esneider', 'Rivera', 'Rodriguez', 1, '1035434042', 'Copacabana', '1995-08-04', 'Niquia', 'Masculino', 'Av. 37 #55-26', '4835587', 'yoniriveratennis@gmail.com', 'O+', 'Medellin', 'Antioquia', 'Colombia', NULL, NULL, 'Public/Img/Usuarios/FotosPersona/default.png', 'Activo', 'APH'),
(7, 'Leydy', 'Tatiana', 'Zapata', 'Rios', 1, '1045050151', 'Tamesis', '1996-07-12', 'Valparaiso', 'Femenino', 'cra. 56 cll56 A 25', '3778067', 'ltzapata1@misena.edu.co', 'A+', 'Medellin', 'Antioquia', 'Colmobia', NULL, NULL, 'Public/Img/Usuarios/FotosPersona/default.png', 'Activo', 'Domiciliaria'),
(8, 'Daniel', 'Felipe', 'Lopez', 'Restrepo', 1, '1045048022', 'Medellin', '1995-07-30', 'Sabaneta', 'Masculino', 'Dg 9 # 13-50', '5785044', 'leydyzapata03@gmail.com', 'B+', 'Medellin', 'Antioquia', 'Colombia', NULL, NULL, 'Public/Img/Usuarios/FotosPersona/default.png', 'Activo', 'APH'),
(9, 'Monica', 'Alejandra', 'Rojas', 'Valencia', 1, '1045047030', '', '1997-01-02', '', 'Femenino', 'Cra. 5 #10A-89', '2880741', 'mapa8823@hotmail.com', '', 'Medellin', 'Antioquia', 'Colombia', '', '', 'Public/Img/Usuarios/FotosPersona/default.png', 'Activo', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_personaespecialidad`
--

DROP TABLE IF EXISTS `tbl_personaespecialidad`;
CREATE TABLE IF NOT EXISTS `tbl_personaespecialidad` (
  `idPersonaespecialidad` int(11) NOT NULL AUTO_INCREMENT,
  `idPersona` int(11) NOT NULL,
  `idEspecialidad` int(11) NOT NULL,
  `estadoTablaEspecialidad` varchar(50) NOT NULL DEFAULT 'Activo',
  PRIMARY KEY (`idPersonaespecialidad`),
  KEY `idPersona` (`idPersona`),
  KEY `idEspecialidad` (`idEspecialidad`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_piel`
--

DROP TABLE IF EXISTS `tbl_piel`;
CREATE TABLE IF NOT EXISTS `tbl_piel` (
  `idPiel` int(11) NOT NULL AUTO_INCREMENT,
  `idExamenFisico` int(11) NOT NULL,
  `descripcion` varchar(45) NOT NULL,
  PRIMARY KEY (`idPiel`),
  KEY `idExamenFisico` (`idExamenFisico`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_procedimiento`
--

DROP TABLE IF EXISTS `tbl_procedimiento`;
CREATE TABLE IF NOT EXISTS `tbl_procedimiento` (
  `idProcedimiento` int(11) NOT NULL AUTO_INCREMENT,
  `idCUP` int(11) NOT NULL,
  `idHistoriaClinica` int(11) NOT NULL,
  `descripcionProcedimiento` varchar(1000) NOT NULL,
  PRIMARY KEY (`idProcedimiento`),
  KEY `idHistoriaClinica` (`idHistoriaClinica`),
  KEY `idCUP` (`idCUP`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_programacion`
--

DROP TABLE IF EXISTS `tbl_programacion`;
CREATE TABLE IF NOT EXISTS `tbl_programacion` (
  `idProgramacion` int(11) NOT NULL AUTO_INCREMENT,
  `Fecha_inicial` date NOT NULL,
  `Fecha_final` date NOT NULL,
  PRIMARY KEY (`idProgramacion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_puntolesion`
--

DROP TABLE IF EXISTS `tbl_puntolesion`;
CREATE TABLE IF NOT EXISTS `tbl_puntolesion` (
  `idPuntoLesion` int(11) NOT NULL AUTO_INCREMENT,
  `posX` varchar(100) NOT NULL,
  `posY` varchar(100) NOT NULL,
  `idReporteAPH` int(11) NOT NULL,
  PRIMARY KEY (`idPuntoLesion`),
  KEY `idReporteAPH` (`idReporteAPH`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_recurso`
--

DROP TABLE IF EXISTS `tbl_recurso`;
CREATE TABLE IF NOT EXISTS `tbl_recurso` (
  `idrecurso` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `descripcion` varchar(45) DEFAULT NULL,
  `cantidadRecurso` int(11) DEFAULT NULL,
  `estadoTablaRecurso` varchar(50) NOT NULL DEFAULT 'Activo',
  `idCategoriaRecurso` int(11) NOT NULL,
  PRIMARY KEY (`idrecurso`),
  KEY `idCategoriaRecurso` (`idCategoriaRecurso`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_reporteaph`
--

DROP TABLE IF EXISTS `tbl_reporteaph`;
CREATE TABLE IF NOT EXISTS `tbl_reporteaph` (
  `idReporteAPH` int(11) NOT NULL AUTO_INCREMENT,
  `idExamenFisico` int(11) NOT NULL,
  `idDespacho` int(11) NOT NULL,
  `idAsignacionPersonal` int(11) NOT NULL,
  `idPersonalRecibe` int(11) DEFAULT NULL,
  `idParamedicoAtiende` int(11) NOT NULL,
  `idTriage` int(11) NOT NULL,
  `idTipoAseguramiento` int(11) NOT NULL,
  `idCertificadoAtencion` int(11) NOT NULL,
  `fechaHoraFinalizacion` datetime NOT NULL,
  `fechaHoraArriboEscena` datetime NOT NULL,
  `fechaHoraArriboIPS` datetime NOT NULL,
  `ultimaIngesta` datetime DEFAULT NULL,
  `idAfectadoAccidenteTransito` int(11) DEFAULT NULL,
  `placaVehiculo` varchar(45) DEFAULT NULL,
  `codigoAseguradora` varchar(45) DEFAULT NULL,
  `numeroPoliza` varchar(45) DEFAULT NULL,
  `descripcionTratamiento` text,
  `descripcionTratamientoAvanzado` text,
  `evaluacionResultado` varchar(45) NOT NULL,
  `institucionReceptora` varchar(45) NOT NULL,
  `situacionEntrega` varchar(45) NOT NULL,
  `presionArterialEntrega` varchar(45) NOT NULL,
  `pulsoEntrega` varchar(45) NOT NULL,
  `respiracionEntrega` varchar(45) NOT NULL,
  `estadoTablaReporteAPH` varchar(50) DEFAULT NULL,
  `complicaciones` text,
  `idPaciente` int(11) NOT NULL,
  `idAcompanante` int(11) DEFAULT NULL,
  `TAPHPresente` tinyint(1) NOT NULL,
  `TPAPHPresente` tinyint(1) NOT NULL,
  `otroPersonalControlM` tinyint(1) DEFAULT NULL,
  `nombreOtroPersonalControlM` varchar(45) DEFAULT NULL,
  `protocolo` bit(1) DEFAULT NULL,
  PRIMARY KEY (`idReporteAPH`),
  UNIQUE KEY `idDespacho_2` (`idDespacho`),
  KEY `idPaciente` (`idPaciente`),
  KEY `idDespacho` (`idDespacho`),
  KEY `idTriage` (`idTriage`),
  KEY `idCertificadoAtencion` (`idCertificadoAtencion`),
  KEY `idAfectadoAccidenteTransito` (`idAfectadoAccidenteTransito`),
  KEY `idPersonalRecibe` (`idPersonalRecibe`),
  KEY `idTipoAseguramiento` (`idTipoAseguramiento`),
  KEY `idExamenFisico` (`idExamenFisico`),
  KEY `FK_ASIGNACION_PERSONAL_REPORTE` (`idAsignacionPersonal`),
  KEY `tbl_reporteaph_ibfk_11_idx` (`idAcompanante`),
  KEY `idParamedicoAtiende` (`idParamedicoAtiende`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_reporteaph_motivoconsulta`
--

DROP TABLE IF EXISTS `tbl_reporteaph_motivoconsulta`;
CREATE TABLE IF NOT EXISTS `tbl_reporteaph_motivoconsulta` (
  `idAPHMC` int(11) NOT NULL AUTO_INCREMENT,
  `idReporteAPH` int(11) NOT NULL,
  `idMotivoConsulta` int(11) NOT NULL,
  `especificacion` text,
  PRIMARY KEY (`idAPHMC`),
  KEY `idReporteAPH` (`idReporteAPH`),
  KEY `idMotivoConsulta` (`idMotivoConsulta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_reporteinicial`
--

DROP TABLE IF EXISTS `tbl_reporteinicial`;
CREATE TABLE IF NOT EXISTS `tbl_reporteinicial` (
  `idReporteInicial` int(11) NOT NULL AUTO_INCREMENT,
  `informacionInicial` varchar(300) NOT NULL,
  `ubicacionIncidente` varchar(100) DEFAULT NULL,
  `puntoReferencia` varchar(45) DEFAULT NULL,
  `numeroLesionados` int(11) DEFAULT NULL,
  `fechaHoraAproximadaEmergencia` datetime DEFAULT NULL,
  `fechaHoraEnvioReporteInicial` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `estadoTablaReporteInicial` varchar(50) NOT NULL,
  `idChat` int(11) NOT NULL,
  PRIMARY KEY (`idReporteInicial`),
  KEY `FK_ID_RECEPTOR` (`idChat`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_restablecer`
--

DROP TABLE IF EXISTS `tbl_restablecer`;
CREATE TABLE IF NOT EXISTS `tbl_restablecer` (
  `idRestablecer` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(50) DEFAULT NULL,
  `codigo` varchar(50) DEFAULT NULL,
  `idUsuario` int(11) DEFAULT NULL,
  `estado` varchar(20) DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idRestablecer`),
  KEY `idUsuario` (`idUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_rol`
--

DROP TABLE IF EXISTS `tbl_rol`;
CREATE TABLE IF NOT EXISTS `tbl_rol` (
  `idRol` int(11) NOT NULL AUTO_INCREMENT,
  `descripcionRol` varchar(45) NOT NULL,
  `estadoTabla` varchar(50) NOT NULL DEFAULT 'Activo',
  PRIMARY KEY (`idRol`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Volcado de datos para la tabla `tbl_rol`
--

INSERT INTO `tbl_rol` (`idRol`, `descripcionRol`, `estadoTabla`) VALUES
(1, 'Administrador', 'Activo'),
(2, 'Paramedico', 'Activo'),
(3, 'Medico', 'Activo'),
(4, 'Auxiliar de Enfermeria', 'Activo'),
(5, 'Control Medico', 'Activo'),
(6, 'Enfermera Jefe', 'Activo'),
(7, 'Receptor Inicial', 'Activo'),
(8, 'Usuario', 'Activo'),
(9, 'Medico Externo', 'Activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_rolmodulovista`
--

DROP TABLE IF EXISTS `tbl_rolmodulovista`;
CREATE TABLE IF NOT EXISTS `tbl_rolmodulovista` (
  `idRolModuloVista` int(11) NOT NULL AUTO_INCREMENT,
  `idRol` int(11) NOT NULL,
  `idModulo` int(11) NOT NULL,
  `idVista` int(11) NOT NULL,
  PRIMARY KEY (`idRolModuloVista`),
  KEY `idRol` (`idRol`),
  KEY `idModulo` (`idModulo`),
  KEY `idVista` (`idVista`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=121 ;

--
-- Volcado de datos para la tabla `tbl_rolmodulovista`
--

INSERT INTO `tbl_rolmodulovista` (`idRolModuloVista`, `idRol`, `idModulo`, `idVista`) VALUES
(1, 1, 1, 1),
(2, 1, 1, 2),
(3, 1, 1, 3),
(4, 1, 2, 4),
(5, 1, 2, 5),
(6, 1, 3, 7),
(7, 1, 3, 8),
(8, 1, 3, 9),
(9, 1, 3, 10),
(10, 1, 4, 11),
(11, 1, 4, 12),
(12, 1, 5, 13),
(13, 1, 5, 14),
(14, 1, 5, 15),
(15, 1, 5, 16),
(16, 1, 5, 17),
(17, 1, 5, 18),
(18, 1, 5, 19),
(19, 1, 5, 20),
(20, 1, 6, 21),
(21, 1, 6, 22),
(22, 1, 7, 23),
(23, 1, 7, 24),
(24, 1, 8, 25),
(25, 1, 8, 26),
(26, 1, 8, 27),
(27, 1, 9, 28),
(28, 1, 9, 29),
(29, 1, 9, 30),
(30, 1, 9, 31),
(31, 1, 9, 32),
(32, 1, 9, 33),
(33, 1, 9, 34),
(34, 1, 9, 35),
(35, 1, 9, 36),
(36, 1, 9, 37),
(37, 1, 4, 38),
(38, 1, 4, 39),
(39, 1, 4, 40),
(40, 1, 4, 41),
(41, 1, 4, 42),
(42, 1, 4, 43),
(43, 1, 4, 44),
(44, 1, 4, 45),
(45, 1, 4, 46),
(46, 1, 4, 47),
(47, 1, 4, 48),
(48, 1, 4, 49),
(49, 1, 4, 50),
(50, 1, 4, 51),
(51, 1, 5, 52),
(52, 1, 5, 53),
(53, 1, 5, 54),
(54, 1, 5, 55),
(55, 1, 2, 56),
(56, 1, 7, 57),
(57, 1, 7, 58),
(58, 1, 6, 59),
(59, 1, 3, 60),
(60, 1, 1, 61),
(61, 7, 2, 4),
(62, 7, 2, 5),
(63, 3, 3, 9),
(64, 3, 3, 10),
(65, 2, 3, 9),
(66, 2, 3, 10),
(67, 5, 4, 12),
(68, 3, 4, 11),
(69, 3, 4, 42),
(70, 3, 4, 43),
(71, 3, 4, 44),
(72, 3, 4, 45),
(73, 3, 4, 46),
(74, 3, 4, 47),
(75, 3, 4, 48),
(76, 3, 4, 49),
(77, 3, 4, 50),
(78, 3, 4, 51),
(79, 3, 4, 52),
(80, 3, 4, 53),
(81, 3, 4, 54),
(82, 3, 4, 55),
(83, 2, 4, 11),
(84, 2, 4, 42),
(85, 2, 4, 43),
(86, 2, 4, 44),
(87, 2, 4, 45),
(88, 2, 4, 46),
(89, 2, 4, 47),
(90, 2, 4, 48),
(91, 2, 4, 49),
(92, 2, 4, 50),
(93, 2, 4, 51),
(94, 2, 4, 52),
(95, 2, 4, 53),
(96, 2, 4, 54),
(97, 2, 4, 55),
(98, 3, 7, 24),
(99, 4, 7, 24),
(100, 6, 7, 24),
(101, 3, 9, 28),
(102, 3, 9, 35),
(103, 3, 9, 36),
(104, 3, 9, 37),
(105, 3, 9, 38),
(106, 3, 9, 39),
(107, 3, 9, 40),
(108, 3, 9, 41),
(109, 3, 9, 29),
(110, 3, 9, 30),
(111, 3, 9, 31),
(112, 3, 9, 33),
(113, 4, 9, 29),
(114, 4, 9, 30),
(115, 4, 9, 31),
(116, 4, 9, 33),
(117, 6, 9, 29),
(118, 6, 9, 30),
(119, 6, 9, 31),
(120, 6, 9, 33);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_signosvitales`
--

DROP TABLE IF EXISTS `tbl_signosvitales`;
CREATE TABLE IF NOT EXISTS `tbl_signosvitales` (
  `idSignosVitales` int(11) NOT NULL AUTO_INCREMENT,
  `resultado` double DEFAULT NULL,
  `hora` time DEFAULT NULL,
  `idHistoriaClinica` int(11) NOT NULL,
  `idValoracion` int(11) DEFAULT NULL,
  PRIMARY KEY (`idSignosVitales`),
  KEY `idHistoriaClinica` (`idHistoriaClinica`),
  KEY `idValoracion` (`idValoracion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_solicitud`
--

DROP TABLE IF EXISTS `tbl_solicitud`;
CREATE TABLE IF NOT EXISTS `tbl_solicitud` (
  `idSolicitud` int(11) NOT NULL AUTO_INCREMENT,
  `Descripcion` varchar(60) NOT NULL,
  `CuentaUsuario_idUsuario` int(11) NOT NULL,
  PRIMARY KEY (`idSolicitud`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_temporalautorizacion`
--

DROP TABLE IF EXISTS `tbl_temporalautorizacion`;
CREATE TABLE IF NOT EXISTS `tbl_temporalautorizacion` (
  `idTemporalAutorizacion` int(11) NOT NULL AUTO_INCREMENT,
  `idParamedico` int(11) DEFAULT NULL,
  `idMedico` int(11) DEFAULT NULL,
  `idReporte` int(11) DEFAULT NULL,
  `idTipoTratamiento` int(11) DEFAULT NULL,
  `idMedicamento` int(11) DEFAULT NULL,
  `descripcionAutorizacion` text,
  `observacionRespuestaAutorizacion` text,
  `cedulaPaciente` varchar(45) DEFAULT NULL,
  `estadoEvaluacion` varchar(45) DEFAULT NULL,
  `fechaEnvio` datetime DEFAULT NULL,
  `fechaEvaluacion` datetime DEFAULT NULL,
  PRIMARY KEY (`idTemporalAutorizacion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_testigo`
--

DROP TABLE IF EXISTS `tbl_testigo`;
CREATE TABLE IF NOT EXISTS `tbl_testigo` (
  `idTestigo` int(11) NOT NULL AUTO_INCREMENT,
  `idReporteAPH` int(11) NOT NULL,
  `nombreTestigo` varchar(45) NOT NULL,
  `identificacionTestigo` varchar(45) NOT NULL,
  PRIMARY KEY (`idTestigo`),
  KEY `idReporteAPH` (`idReporteAPH`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_tipoafiliacion`
--

DROP TABLE IF EXISTS `tbl_tipoafiliacion`;
CREATE TABLE IF NOT EXISTS `tbl_tipoafiliacion` (
  `idTipoAfiliacion` int(11) NOT NULL AUTO_INCREMENT,
  `descripcionAfiliacion` varchar(45) DEFAULT NULL,
  `estadoTabla` varchar(50) NOT NULL DEFAULT 'Activo',
  PRIMARY KEY (`idTipoAfiliacion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_tipoantecedente`
--

DROP TABLE IF EXISTS `tbl_tipoantecedente`;
CREATE TABLE IF NOT EXISTS `tbl_tipoantecedente` (
  `idTipoAntecedente` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(100) NOT NULL,
  `estadoTabla` varchar(50) NOT NULL DEFAULT 'Activo',
  PRIMARY KEY (`idTipoAntecedente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_tipoaseguramiento`
--

DROP TABLE IF EXISTS `tbl_tipoaseguramiento`;
CREATE TABLE IF NOT EXISTS `tbl_tipoaseguramiento` (
  `idTipoAseguramiento` int(11) NOT NULL AUTO_INCREMENT,
  `DescripcionTipoAseguramiento` varchar(45) NOT NULL,
  `estadoTabla` varchar(50) DEFAULT 'Activo',
  PRIMARY KEY (`idTipoAseguramiento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_tipoasignacion`
--

DROP TABLE IF EXISTS `tbl_tipoasignacion`;
CREATE TABLE IF NOT EXISTS `tbl_tipoasignacion` (
  `idTipoAsignacion` int(11) NOT NULL AUTO_INCREMENT,
  `descripcionTipoasignacion` varchar(45) NOT NULL,
  `estadoTabla` varchar(50) NOT NULL DEFAULT 'Activo',
  PRIMARY KEY (`idTipoAsignacion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_tipocup`
--

DROP TABLE IF EXISTS `tbl_tipocup`;
CREATE TABLE IF NOT EXISTS `tbl_tipocup` (
  `idTipoCup` int(11) NOT NULL AUTO_INCREMENT,
  `descripcionCUP` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idTipoCup`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_tipodevolucion`
--

DROP TABLE IF EXISTS `tbl_tipodevolucion`;
CREATE TABLE IF NOT EXISTS `tbl_tipodevolucion` (
  `idTipoDevolucion` int(11) NOT NULL AUTO_INCREMENT,
  `descripcionDevolucion` varchar(45) NOT NULL,
  `estadoTabla` varchar(50) NOT NULL DEFAULT 'Activo',
  PRIMARY KEY (`idTipoDevolucion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_tipodocumento`
--

DROP TABLE IF EXISTS `tbl_tipodocumento`;
CREATE TABLE IF NOT EXISTS `tbl_tipodocumento` (
  `idTipoDocumento` int(11) NOT NULL AUTO_INCREMENT,
  `descripcionTdocumento` varchar(45) NOT NULL,
  `estadoTabla` varchar(50) NOT NULL DEFAULT 'Activo',
  PRIMARY KEY (`idTipoDocumento`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Volcado de datos para la tabla `tbl_tipodocumento`
--

INSERT INTO `tbl_tipodocumento` (`idTipoDocumento`, `descripcionTdocumento`, `estadoTabla`) VALUES
(1, 'Cédula de Ciudadanía', 'Activo'),
(2, 'Tarjeta de Identidad', 'Activo'),
(3, 'Registro Civil', 'Activo'),
(4, 'Documento de Extranjería', 'Activo'),
(5, 'Otro', 'Activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_tipoevento`
--

DROP TABLE IF EXISTS `tbl_tipoevento`;
CREATE TABLE IF NOT EXISTS `tbl_tipoevento` (
  `idTipoEvento` int(11) NOT NULL AUTO_INCREMENT,
  `descripcionTipoEvento` varchar(45) NOT NULL,
  `estadoTabla` varchar(50) NOT NULL DEFAULT 'Activo',
  PRIMARY KEY (`idTipoEvento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_tipoevento_novedadreporteinicial`
--

DROP TABLE IF EXISTS `tbl_tipoevento_novedadreporteinicial`;
CREATE TABLE IF NOT EXISTS `tbl_tipoevento_novedadreporteinicial` (
  `idTipoEventoNovedadReporteInicial` int(11) NOT NULL AUTO_INCREMENT,
  `idTipoEvento` int(11) NOT NULL,
  `idNovedad` int(11) NOT NULL,
  PRIMARY KEY (`idTipoEventoNovedadReporteInicial`),
  KEY `idNovedad` (`idNovedad`),
  KEY `idTipoEvento` (`idTipoEvento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_tipoevento_reporteinicial`
--

DROP TABLE IF EXISTS `tbl_tipoevento_reporteinicial`;
CREATE TABLE IF NOT EXISTS `tbl_tipoevento_reporteinicial` (
  `idTipoEventoReporteInicial` int(11) NOT NULL AUTO_INCREMENT,
  `idReporteInicial` int(11) NOT NULL,
  `idTipoEvento` int(11) NOT NULL,
  PRIMARY KEY (`idTipoEventoReporteInicial`),
  KEY `idReporteInicial` (`idReporteInicial`),
  KEY `idTipoEvento` (`idTipoEvento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_tipoexamenespecializado`
--

DROP TABLE IF EXISTS `tbl_tipoexamenespecializado`;
CREATE TABLE IF NOT EXISTS `tbl_tipoexamenespecializado` (
  `idTipoExamenEspecializado` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(1000) NOT NULL,
  `estadoTabla` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idTipoExamenEspecializado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_tipoexamenfisico`
--

DROP TABLE IF EXISTS `tbl_tipoexamenfisico`;
CREATE TABLE IF NOT EXISTS `tbl_tipoexamenfisico` (
  `idtipoExamenFisico` int(11) NOT NULL AUTO_INCREMENT,
  `descripcionExamenFisico` varchar(500) NOT NULL,
  `estadoTabla` varchar(50) DEFAULT 'Activo',
  PRIMARY KEY (`idtipoExamenFisico`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_tipokit`
--

DROP TABLE IF EXISTS `tbl_tipokit`;
CREATE TABLE IF NOT EXISTS `tbl_tipokit` (
  `idTipoKit` int(11) NOT NULL AUTO_INCREMENT,
  `descripcionTipoKit` varchar(50) DEFAULT NULL,
  `estadoTabla` varchar(50) DEFAULT 'Activo',
  PRIMARY KEY (`idTipoKit`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_tiponovedad`
--

DROP TABLE IF EXISTS `tbl_tiponovedad`;
CREATE TABLE IF NOT EXISTS `tbl_tiponovedad` (
  `idTipoNovedad` int(11) NOT NULL AUTO_INCREMENT,
  `descripcionTiponovedad` varchar(45) NOT NULL,
  `estadoTabla` varchar(50) NOT NULL DEFAULT 'Activo',
  PRIMARY KEY (`idTipoNovedad`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_tipoorigenatencion`
--

DROP TABLE IF EXISTS `tbl_tipoorigenatencion`;
CREATE TABLE IF NOT EXISTS `tbl_tipoorigenatencion` (
  `idTipoOrigenAtencion` int(11) NOT NULL AUTO_INCREMENT,
  `descripcionorigenAtencion` varchar(100) NOT NULL,
  `estadoTabla` varchar(50) DEFAULT 'Activo',
  PRIMARY KEY (`idTipoOrigenAtencion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_tipotratamiento`
--

DROP TABLE IF EXISTS `tbl_tipotratamiento`;
CREATE TABLE IF NOT EXISTS `tbl_tipotratamiento` (
  `idTipoTratamiento` int(11) NOT NULL AUTO_INCREMENT,
  `Descripcion` varchar(1000) NOT NULL,
  `categoriaTratamientoAph` varchar(45) DEFAULT NULL,
  `categoriaItemTratamiento` varchar(45) DEFAULT NULL,
  `estadoTabla` varchar(50) DEFAULT 'Activo',
  PRIMARY KEY (`idTipoTratamiento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_tipozona`
--

DROP TABLE IF EXISTS `tbl_tipozona`;
CREATE TABLE IF NOT EXISTS `tbl_tipozona` (
  `idTipoZona` int(11) NOT NULL AUTO_INCREMENT,
  `descripcionTipozona` varchar(100) NOT NULL,
  `estadoTabla` varchar(50) NOT NULL DEFAULT 'Activo',
  PRIMARY KEY (`idTipoZona`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_tratamientoaph`
--

DROP TABLE IF EXISTS `tbl_tratamientoaph`;
CREATE TABLE IF NOT EXISTS `tbl_tratamientoaph` (
  `idtratamiento` int(11) NOT NULL AUTO_INCREMENT,
  `idReporteAPH` int(11) NOT NULL,
  `valor` varchar(45) DEFAULT NULL,
  `idTipoTratamiento` int(11) NOT NULL,
  PRIMARY KEY (`idtratamiento`),
  KEY `idReporteAPH` (`idReporteAPH`),
  KEY `idTipoTratamiento` (`idTipoTratamiento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_tratamientodmc`
--

DROP TABLE IF EXISTS `tbl_tratamientodmc`;
CREATE TABLE IF NOT EXISTS `tbl_tratamientodmc` (
  `idTratamiento` int(11) NOT NULL AUTO_INCREMENT,
  `descripcionTratamiento` text,
  `fechaTratamiento` date NOT NULL,
  `dosisTratamiento` text NOT NULL,
  `idTipoTratamiento` int(11) NOT NULL,
  `idHistoriaClinica` int(11) NOT NULL,
  PRIMARY KEY (`idTratamiento`),
  KEY `idTipoTratamiento` (`idTipoTratamiento`),
  KEY `idHistoriaClinica` (`idHistoriaClinica`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_tratamientodmcrecurso`
--

DROP TABLE IF EXISTS `tbl_tratamientodmcrecurso`;
CREATE TABLE IF NOT EXISTS `tbl_tratamientodmcrecurso` (
  `TratamientoDmcRecurso` int(11) NOT NULL AUTO_INCREMENT,
  `idTratamientoDmc` int(11) NOT NULL,
  `idrecurso` int(11) NOT NULL,
  PRIMARY KEY (`TratamientoDmcRecurso`),
  KEY `idTratamientoDmc` (`idTratamientoDmc`),
  KEY `idrecurso` (`idrecurso`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_triage`
--

DROP TABLE IF EXISTS `tbl_triage`;
CREATE TABLE IF NOT EXISTS `tbl_triage` (
  `idTriage` int(11) NOT NULL AUTO_INCREMENT,
  `descripcionTriage` varchar(45) NOT NULL,
  `estadoTabla` varchar(50) DEFAULT 'Activo',
  PRIMARY KEY (`idTriage`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_turno`
--

DROP TABLE IF EXISTS `tbl_turno`;
CREATE TABLE IF NOT EXISTS `tbl_turno` (
  `idTurno` int(11) NOT NULL AUTO_INCREMENT,
  `horaInicioTurno` time NOT NULL,
  `horaFinalTurno` time NOT NULL,
  PRIMARY KEY (`idTurno`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_turnoprogramacion`
--

DROP TABLE IF EXISTS `tbl_turnoprogramacion`;
CREATE TABLE IF NOT EXISTS `tbl_turnoprogramacion` (
  `idTurnoProgramacion` int(11) NOT NULL AUTO_INCREMENT,
  `idTurno` int(11) NOT NULL,
  `idProgramacion` int(11) NOT NULL,
  `idPersona` int(11) NOT NULL,
  `estadoTablaProgramacion` varchar(45) NOT NULL,
  PRIMARY KEY (`idTurnoProgramacion`),
  KEY `idTurno` (`idTurno`),
  KEY `idProgramacion` (`idProgramacion`),
  KEY `idPersona` (`idPersona`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_valoracion`
--

DROP TABLE IF EXISTS `tbl_valoracion`;
CREATE TABLE IF NOT EXISTS `tbl_valoracion` (
  `idValoracion` int(11) NOT NULL AUTO_INCREMENT,
  `descripcionValoracion` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idValoracion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_viacomunicacioncontrolmedico`
--

DROP TABLE IF EXISTS `tbl_viacomunicacioncontrolmedico`;
CREATE TABLE IF NOT EXISTS `tbl_viacomunicacioncontrolmedico` (
  `idViaComunicacionControlMedico` int(11) NOT NULL AUTO_INCREMENT,
  `idReporteAPH` int(11) NOT NULL,
  `viaComunicacion` varchar(45) NOT NULL,
  PRIMARY KEY (`idViaComunicacionControlMedico`),
  KEY `idReporteAPH` (`idReporteAPH`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_vista`
--

DROP TABLE IF EXISTS `tbl_vista`;
CREATE TABLE IF NOT EXISTS `tbl_vista` (
  `idVista` int(11) NOT NULL AUTO_INCREMENT,
  `descripcionVista` varchar(70) NOT NULL,
  `urlVista` varchar(250) NOT NULL,
  `iconoVista` varchar(45) NOT NULL,
  `estado` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idVista`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=62 ;

--
-- Volcado de datos para la tabla `tbl_vista`
--

INSERT INTO `tbl_vista` (`idVista`, `descripcionVista`, `urlVista`, `iconoVista`, `estado`) VALUES
(1, 'Registrar Persona', 'Usuarios/ctrlRegistrarpersona', 'check', 'Activo'),
(2, 'Consultar Persona', 'Usuarios/ctrlConsultarPersona', 'search', 'Activo'),
(3, 'Asignar Permisos', 'Usuarios/ctrlPermisos', 'key', 'Activo'),
(4, 'Registrar Reporte Inicial', 'ReporteInicial/ctrlRegistrarReporteInicial', 'pencil', 'Activo'),
(5, 'Consultar Reporte Inicial', 'ReporteInicial/ctrlConsultarReporte', 'files-o', 'Activo'),
(6, 'Reportar Emergencia', 'ReporteInicial/ctrlChatUsuario', 'comments-o', 'Activo'),
(7, 'Asignación de Personal', 'Despachador/ctrlAsignacionPersonal', 'users', 'Activo'),
(8, 'Modificación del Personal', 'Despachador/ctrlModificarAsignacion', 'pencil-square-o', 'Activo'),
(9, 'Gestionar Despacho', 'Despachador/ctrlDespacho', 'paper-plane', 'Activo'),
(10, 'Consultar Reportes Despacho', 'Despachador/ctrlListarDespacho', 'search', 'Activo'),
(11, 'Consultar Reportes APH', 'ReporteAPH/ctrlIndex', 'file-text-o', 'Activo'),
(12, 'Control de Autorizaciones ', 'ReporteAPH/ctrlcontrolautorizacion', 'list-alt', 'Activo'),
(13, 'Gestión Estándar Kit', 'Stock/ctrlKit', 'suitcase', 'Activo'),
(14, 'Gestión Recursos', 'Stock/ctrlRecurso', 'stethoscope', 'Activo'),
(15, 'Registrar Asignación', 'Stock/ctrlRegistroAsignacion', 'check-square-o', 'Activo'),
(16, 'Consultar Asignación', 'Stock/ctrlConsultarAsignacion', 'folder-open', 'Activo'),
(17, 'Gestión Novedades', 'Stock/ctrlNovedad', 'file-text-o', 'Activo'),
(18, 'Gestión Devoluciones', 'Stock/ctrlDevolucionNovedad', 'reply-all', 'Activo'),
(19, 'Consultar Devoluciones', 'Stock/ctrlConsultaDevolucion', 'search', 'Activo'),
(20, 'Consultar Prestamos', 'Stock/ctrlConsultarTratamiento', 'search', 'Activo'),
(21, 'Paciente Inicial', 'Pacientes/CtrlPacienteInicial', 'users', 'Activo'),
(22, 'Registro Paciente', 'Pacientes/CtrlRegistroPaciente', 'user-plus', 'Activo'),
(23, 'Consultar Usuarios', 'Programacion/ctrlConsultarUsuarios', 'users', 'Activo'),
(24, 'Consultar Agenda', 'Programacion/ctrlHistorialprogramacion', 'book', 'Activo'),
(25, 'Registrar Cita', 'Citas/CtrlCitas', 'calendar-plus-o', 'Activo'),
(26, 'Historial Cita', 'Citas/ctrlHistorialCitas', 'book', 'Activo'),
(27, 'Configuración', 'Citas/ctrlConfiguracionCup', 'cogs', 'Activo'),
(28, 'Confirmar Cita', 'HistoriaClinicaDMC/ctrlConsultarCita', 'check-square-o', 'Activo'),
(29, 'Consultar Datos', 'HistoriaClinicaDMC/ctrlConsultarHistoria', 'search', 'Activo'),
(30, 'Consultar Atención', 'HistoriaClinicaDMC/ctrlConsultarAtencion', 'spinner', 'Inactivo'),
(31, 'Consultar Ordenes', 'HistoriaClinicaDMC/ctrlConsultarOrdenes', 'spinner', 'Inactivo'),
(32, 'Descargar PDF', 'HistoriaClinicaDMC/ctrlDescargarPDF', 'spinner', 'Inactivo'),
(33, 'Registrar Antecedentes', 'HistoriaClinicaDMC/ctrlRegistrarAntecedentesExamenes', 'spinner', 'Inactivo'),
(34, 'Registrar Historia Clínica', 'HistoriaClinicaDMC/ctrlRegistrarHistoriaClinica', 'spinner', 'Inactivo'),
(35, 'Registrar Información Personal', 'HistoriaClinicaDMC/ctrlRegistrarInformacionPersonalAtencion', 'spinner', 'Inactivo'),
(36, 'Registrar Medicación ', 'HistoriaClinicaDMC/ctrlRegistrarMedicacion', 'spinner', 'Inactivo'),
(37, 'Registrar Ordenes Médicas', 'HistoriaClinicaDMC/ctrlRegistrarOrdenesMedicas', 'spinner', 'Inactivo'),
(38, 'Registrar Procedimientos', 'HistoriaClinicaDMC/ctrlRegistrarProcedimientoDiagnostico', 'spinner', 'Inactivo'),
(39, 'Registrar Signos Vitales', 'HistoriaClinicaDMC/ctrlRegistrarSignosVitales', 'spinner', 'Inactivo'),
(40, 'Antecedentes Paciente', 'ReporteAPH/ctrlAntecedentesPaciente', 'spinner', 'Inactivo'),
(41, 'Información General', 'ReporteAPH/ctrlInformacionGeneral', 'spinner', 'Inactivo'),
(42, 'Examen Fisico', 'ReporteAPH/ctrlExamenFisico', 'spinner', 'Inactivo'),
(43, 'Generar Reporte APH', 'ReporteAPH/ctrlGenerarReporteAPH', 'spinner', 'Inactivo'),
(44, 'Layout Reporte APH', 'ReporteAPH/ctrlLayoutReporteAPH', 'spinner', 'Inactivo'),
(45, 'Localización Lesiones', 'ReporteAPH/ctrlLocalizacionLesiones', 'spinner', 'Inactivo'),
(46, 'Medicamento', 'ReporteAPH/ctrlMedicamento', 'spinner', 'Inactivo'),
(47, 'Motivo Consulta', 'ReporteAPH/ctrlMotivoconsulta', 'spinner', 'Inactivo'),
(48, 'Reporte APH', 'ReporteAPH/ctrlReporteAPH', 'spinner', 'Inactivo'),
(49, 'Reporte Inicial', 'ReporteAPH/ctrlReporteInicial', 'spinner', 'Inactivo'),
(50, 'Resultados Atención', 'ReporteAPH/ctrlResultadosAtencion', 'spinner', 'Inactivo'),
(51, 'Tipo Evento', 'ReporteAPH/ctrlTipoEvento', 'spinner', 'Inactivo'),
(52, 'Tratamiento A', 'ReporteAPH/ctrlTratamientoA', 'spinner', 'Inactivo'),
(53, 'Tratamiento B', 'ReporteAPH/ctrlTratamientoB', 'spinner', 'Inactivo'),
(54, 'Consulta Recurso', 'Stock/ctrlConsultaRecurso', 'spinner', 'Inactivo'),
(55, 'Detalle Kit', 'Stock/ctrlDetalleKit', 'spinner', 'Inactivo'),
(56, 'Recursos', 'Stock/ctrlRecursos', 'spinner', 'Inactivo'),
(57, 'Registro Recurso', 'Stock/ctrlRegistroRecurso', 'spinner', 'Inactivo'),
(58, 'Calendario', 'Programacion/ctrlCalendario', 'spinner', 'Inactivo'),
(59, 'Programación', 'Programacion/ctrlCProgramacion', 'spinner', 'Inactivo'),
(60, 'Consulta Paciente', 'Pacientes/ctrlConsultaPaciente', 'spinner', 'Inactivo'),
(61, 'Modificar Persona', 'Usuarios/ctrlModificarPersona', 'spinner', 'Inactivo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_zona`
--

DROP TABLE IF EXISTS `tbl_zona`;
CREATE TABLE IF NOT EXISTS `tbl_zona` (
  `idZona` int(11) NOT NULL AUTO_INCREMENT,
  `descripcionZona` varchar(45) NOT NULL,
  `idTipoZona` int(11) NOT NULL,
  `estadoTabla` varchar(50) NOT NULL DEFAULT 'Activo',
  PRIMARY KEY (`idZona`),
  KEY `idTipoZona` (`idTipoZona`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `viewambulanciasdisponibles`
--
DROP VIEW IF EXISTS `viewambulanciasdisponibles`;
CREATE TABLE IF NOT EXISTS `viewambulanciasdisponibles` (
`idAmbulancia` int(11)
,`tipoAmbulancia` varchar(45)
,`placaAmbulancia` varchar(45)
);
-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `viewambulanciaspersonal`
--
DROP VIEW IF EXISTS `viewambulanciaspersonal`;
CREATE TABLE IF NOT EXISTS `viewambulanciaspersonal` (
`idAmbulancia` int(11)
,`tipoAmbulancia` varchar(45)
,`placaAmbulancia` varchar(45)
);
-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `viewasignaciones`
--
DROP VIEW IF EXISTS `viewasignaciones`;
CREATE TABLE IF NOT EXISTS `viewasignaciones` (
`idAmbulancia` int(11)
,`tipoAmbulancia` varchar(45)
,`latitud` varchar(45)
,`longitud` varchar(45)
,`primerNombre` varchar(50)
,`primerApellido` varchar(50)
,`descripcionEspecialidad` varchar(45)
);
-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `viewcie10aph`
--
DROP VIEW IF EXISTS `viewcie10aph`;
CREATE TABLE IF NOT EXISTS `viewcie10aph` (
`idCIE10` int(11)
,`codigoCIE10` varchar(45)
,`descripcionCIE10` varchar(1000)
,`estadoTabla` varchar(50)
);
-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `viewconsultaratencion`
--
DROP VIEW IF EXISTS `viewconsultaratencion`;
CREATE TABLE IF NOT EXISTS `viewconsultaratencion` (
`idPaciente` int(11)
,`idHistoriaClinica` int(11)
,`fechaAtencion` date
,`horaInicial` time
,`telefonoFijo1` varchar(45)
,`primerNombre` varchar(50)
,`primerApellido` varchar(50)
,`numeroDocumento` varchar(20)
,`direccion` varchar(45)
);
-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `viewconsultarcitamedico`
--
DROP VIEW IF EXISTS `viewconsultarcitamedico`;
CREATE TABLE IF NOT EXISTS `viewconsultarcitamedico` (
`idCita` int(11)
,`idPersona` int(11)
,`estadoTablaCita` varchar(45)
,`idPaciente` int(11)
,`primerNombre` varchar(45)
,`primerApellido` varchar(45)
,`numeroDocumento` varchar(45)
,`horaInicial` time
,`horaFinal` time
,`direccionCita` varchar(45)
,`nombreCUP` varchar(1000)
,`idCitaProgramacion` int(11)
,`barrioResidencia` varchar(45)
,`descripcionZona` varchar(45)
,`telefonoFijo1` varchar(45)
);
-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `viewconsultarprestamos`
--
DROP VIEW IF EXISTS `viewconsultarprestamos`;
CREATE TABLE IF NOT EXISTS `viewconsultarprestamos` (
`idPaciente` int(11)
,`primerNombre` varchar(45)
,`segundoNombre` varchar(45)
,`direccion` varchar(45)
,`telefonoFijo` varchar(45)
,`numeroDocumento` varchar(45)
,`idHistoriaClinica` int(11)
,`nombre` varchar(45)
,`fechaHoraAsignacion` datetime
,`cantidadRecurso` int(11)
,`descripcionTratamiento` text
,`fechaTratamiento` date
,`estadoTablaAsignacionKit` varchar(45)
,`cantidadAsignada` int(11)
);
-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `viewdatosbasicospacientes`
--
DROP VIEW IF EXISTS `viewdatosbasicospacientes`;
CREATE TABLE IF NOT EXISTS `viewdatosbasicospacientes` (
`idPaciente` int(11)
,`numeroDocumento` varchar(45)
,`fechaNacimiento` date
,`NombreCompleto` varchar(183)
,`ciudadResidencia` varchar(45)
,`telefonoFijo` varchar(45)
,`fechaAfiliacionRegistro` date
,`url` varchar(250)
,`descripcionTdocumento` varchar(45)
,`idEstadoPaciente` int(11)
);
-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `viewdatosbasicosreporteaph`
--
DROP VIEW IF EXISTS `viewdatosbasicosreporteaph`;
CREATE TABLE IF NOT EXISTS `viewdatosbasicosreporteaph` (
`idReporteAPH` int(11)
,`nombreCompleto` varchar(183)
,`numeroDocumento` varchar(45)
,`genero` varchar(45)
,`telefonoFijo` varchar(45)
,`edadPaciente` varchar(10)
,`informacionInicial` varchar(300)
,`fechaHoraFinalizacion` datetime
,`idAmbulancia` int(11)
,`fechaHoraDespacho` datetime
,`idAsignacionPersonal` int(11)
);
-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `viewlistarreporteinicial`
--
DROP VIEW IF EXISTS `viewlistarreporteinicial`;
CREATE TABLE IF NOT EXISTS `viewlistarreporteinicial` (
`idReporteInicial` int(11)
,`informacionInicial` varchar(300)
,`ubicacionIncidente` varchar(100)
,`puntoReferencia` varchar(45)
,`numeroLesionados` int(11)
,`fechaHoraAproximadaEmergencia` datetime
,`fechaHoraEnvioReporteInicial` timestamp
,`estadoTablaReporteInicial` varchar(50)
,`nombreReceptor` varchar(101)
,`novedades` int(11)
);
-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `viewlistarreportesactivos`
--
DROP VIEW IF EXISTS `viewlistarreportesactivos`;
CREATE TABLE IF NOT EXISTS `viewlistarreportesactivos` (
`idReporteInicial` int(11)
,`informacionInicial` varchar(300)
,`ubicacionIncidente` varchar(100)
,`puntoReferencia` varchar(45)
,`numeroLesionados` int(11)
,`fechaHoraAproximadaEmergencia` datetime
,`fechaHoraEnvioReporteInicial` timestamp
,`estadoTablaReporteInicial` varchar(50)
,`idChat` int(11)
);
-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `viewpersonalambulancia`
--
DROP VIEW IF EXISTS `viewpersonalambulancia`;
CREATE TABLE IF NOT EXISTS `viewpersonalambulancia` (
`idPersona` int(11)
,`primerNombre` varchar(50)
,`primerApellido` varchar(50)
,`descripcionRol` varchar(45)
);
-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `viewtemporalautorizacion`
--
DROP VIEW IF EXISTS `viewtemporalautorizacion`;
CREATE TABLE IF NOT EXISTS `viewtemporalautorizacion` (
`idTemporalAutorizacion` int(11)
,`idParamedico` int(11)
,`idMedico` int(11)
,`idReporte` int(11)
,`idTipoTratamiento` int(11)
,`idMedicamento` int(11)
,`descripcionAutorizacion` text
,`observacionRespuestaAutorizacion` text
,`cedulaPaciente` varchar(45)
,`estadoEvaluacion` varchar(45)
,`fechaEnvio` datetime
,`fechaEvaluacion` datetime
,`nombreCompleto` varchar(203)
,`correoElectronico` varchar(45)
,`urlFoto` varchar(250)
,`numeroDocumento` varchar(20)
,`Descripcion` varchar(1000)
);
-- --------------------------------------------------------

--
-- Estructura para la vista `viewambulanciasdisponibles`
--
DROP TABLE IF EXISTS `viewambulanciasdisponibles`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viewambulanciasdisponibles` AS select `tbl_ambulancia`.`idAmbulancia` AS `idAmbulancia`,`tbl_ambulancia`.`tipoAmbulancia` AS `tipoAmbulancia`,`tbl_ambulancia`.`placaAmbulancia` AS `placaAmbulancia` from `tbl_ambulancia` where (`tbl_ambulancia`.`estadoTabla` = 'Activo');

-- --------------------------------------------------------

--
-- Estructura para la vista `viewambulanciaspersonal`
--
DROP TABLE IF EXISTS `viewambulanciaspersonal`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viewambulanciaspersonal` AS select `tbl_ambulancia`.`idAmbulancia` AS `idAmbulancia`,`tbl_ambulancia`.`tipoAmbulancia` AS `tipoAmbulancia`,`tbl_ambulancia`.`placaAmbulancia` AS `placaAmbulancia` from `tbl_ambulancia` where (`tbl_ambulancia`.`estadoTabla` = 'Personal Asignado');

-- --------------------------------------------------------

--
-- Estructura para la vista `viewasignaciones`
--
DROP TABLE IF EXISTS `viewasignaciones`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viewasignaciones` AS select `tba`.`idAmbulancia` AS `idAmbulancia`,`tba`.`tipoAmbulancia` AS `tipoAmbulancia`,`tbla`.`latitud` AS `latitud`,`tbla`.`longitud` AS `longitud`,`tblp`.`primerNombre` AS `primerNombre`,`tblp`.`primerApellido` AS `primerApellido`,`tble`.`descripcionEspecialidad` AS `descripcionEspecialidad` from (((((`tbl_ambulancia` `tba` join `tbl_asignacionpersonal` `tbla` on((`tba`.`idAmbulancia` = `tbla`.`idAmbulancia`))) join `tbl_detalleasignacion` `tblda` on((`tbla`.`idAsignacionPersonal` = `tblda`.`idAsignacionPersonal`))) join `tbl_persona` `tblp` on((`tblda`.`idPersona` = `tblp`.`idPersona`))) join `tbl_personaespecialidad` `tblpe` on((`tblp`.`idPersona` = `tblpe`.`idPersona`))) join `tbl_especialidad` `tble` on((`tblpe`.`idEspecialidad` = `tble`.`idEspecialidad`))) where ((`tba`.`estadoTabla` like 'activo') and (`tbla`.`estadoTablaAsignacion` like 'activo')) order by `tba`.`idAmbulancia`;

-- --------------------------------------------------------

--
-- Estructura para la vista `viewcie10aph`
--
DROP TABLE IF EXISTS `viewcie10aph`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viewcie10aph` AS select `tbl_cie10`.`idCIE10` AS `idCIE10`,`tbl_cie10`.`codigoCIE10` AS `codigoCIE10`,`tbl_cie10`.`descripcionCIE10` AS `descripcionCIE10`,`tbl_cie10`.`estadoTabla` AS `estadoTabla` from `tbl_cie10` where ((`tbl_cie10`.`codigoCIE10` like 'S%') or (`tbl_cie10`.`codigoCIE10` like 'T%'));

-- --------------------------------------------------------

--
-- Estructura para la vista `viewconsultaratencion`
--
DROP TABLE IF EXISTS `viewconsultaratencion`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viewconsultaratencion` AS select `hist`.`idPaciente` AS `idPaciente`,`hist`.`idHistoriaClinica` AS `idHistoriaClinica`,`hist`.`fechaAtencion` AS `fechaAtencion`,`cit`.`horaInicial` AS `horaInicial`,`cit`.`telefonoFijo1` AS `telefonoFijo1`,`per`.`primerNombre` AS `primerNombre`,`per`.`primerApellido` AS `primerApellido`,`per`.`numeroDocumento` AS `numeroDocumento`,`per`.`direccion` AS `direccion` from ((((`tbl_cita` `cit` join `tbl_cita_programacion` `ctp` on((`cit`.`idCita` = `ctp`.`idCita`))) join `tbl_historiaclinica` `hist` on((`ctp`.`idCitaprogramacion` = `hist`.`idCitaprogramacion`))) join `tbl_turnoprogramacion` `turn` on((`ctp`.`idTurnoProgramacion` = `turn`.`idTurnoProgramacion`))) join `tbl_persona` `per` on((`per`.`idPersona` = `turn`.`idPersona`))) where (`cit`.`estadoTablaCita` = 'Terminada');

-- --------------------------------------------------------

--
-- Estructura para la vista `viewconsultarcitamedico`
--
DROP TABLE IF EXISTS `viewconsultarcitamedico`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viewconsultarcitamedico` AS select `c`.`idCita` AS `idCita`,`pe`.`idPersona` AS `idPersona`,`c`.`estadoTablaCita` AS `estadoTablaCita`,`pa`.`idPaciente` AS `idPaciente`,`pa`.`primerNombre` AS `primerNombre`,`pa`.`primerApellido` AS `primerApellido`,`pa`.`numeroDocumento` AS `numeroDocumento`,`c`.`horaInicial` AS `horaInicial`,`c`.`horaFinal` AS `horaFinal`,`c`.`direccionCita` AS `direccionCita`,`cu`.`nombreCUP` AS `nombreCUP`,`cp`.`idCitaprogramacion` AS `idCitaProgramacion`,`pa`.`barrioResidencia` AS `barrioResidencia`,`z`.`descripcionZona` AS `descripcionZona`,`c`.`telefonoFijo1` AS `telefonoFijo1` from ((((((((`tbl_cita` `c` join `tbl_paciente` `pa` on((`pa`.`idPaciente` = `c`.`idPaciente`))) join `tbl_cita_programacion` `cp` on((`c`.`idCita` = `cp`.`idCita`))) join `tbl_turnoprogramacion` `tp` on((`cp`.`idTurnoProgramacion` = `tp`.`idTurnoProgramacion`))) join `tbl_persona` `pe` on((`pe`.`idPersona` = `tp`.`idPersona`))) join `tbl_programacion` `p` on((`p`.`idProgramacion` = `tp`.`idProgramacion`))) join `tbl_turno` `t` on((`t`.`idTurno` = `tp`.`idTurno`))) join `tbl_cup` `cu` on((`cu`.`idCUP` = `c`.`idCUP`))) join `tbl_zona` `z` on((`z`.`idZona` = `c`.`idZona`)));

-- --------------------------------------------------------

--
-- Estructura para la vista `viewconsultarprestamos`
--
DROP TABLE IF EXISTS `viewconsultarprestamos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viewconsultarprestamos` AS select `pa`.`idPaciente` AS `idPaciente`,`pa`.`primerNombre` AS `primerNombre`,`pa`.`segundoNombre` AS `segundoNombre`,`pa`.`direccion` AS `direccion`,`pa`.`telefonoFijo` AS `telefonoFijo`,`pa`.`numeroDocumento` AS `numeroDocumento`,`tbh`.`idHistoriaClinica` AS `idHistoriaClinica`,`tbr`.`nombre` AS `nombre`,`tbl_asignacionkit`.`fechaHoraAsignacion` AS `fechaHoraAsignacion`,`tbr`.`cantidadRecurso` AS `cantidadRecurso`,`tbt`.`descripcionTratamiento` AS `descripcionTratamiento`,`tbt`.`fechaTratamiento` AS `fechaTratamiento`,`tbl_asignacionkit`.`estadoTablaAsignacionKit` AS `estadoTablaAsignacionKit`,`tbl_detallekit`.`cantidadAsignada` AS `cantidadAsignada` from (((((((((((((((((`tbl_cita` `c` join `tbl_paciente` `pa` on((`pa`.`idPaciente` = `c`.`idPaciente`))) join `tbl_cita_programacion` `cp` on((`c`.`idCita` = `cp`.`idCita`))) join `tbl_turnoprogramacion` `tp` on((`cp`.`idTurnoProgramacion` = `tp`.`idTurnoProgramacion`))) join `tbl_persona` `pe` on((`pe`.`idPersona` = `tp`.`idPersona`))) join `tbl_programacion` `p` on((`p`.`idProgramacion` = `tp`.`idProgramacion`))) join `tbl_turno` `t` on((`t`.`idTurno` = `tp`.`idTurno`))) join `tbl_cup` `cu` on((`cu`.`idCUP` = `c`.`idCUP`))) join `tbl_zona` `z` on((`z`.`idZona` = `c`.`idZona`))) join `tbl_historiaclinica` `tbh` on((`pa`.`idPaciente` = `tbh`.`idPaciente`))) join `tbl_tratamientodmc` `tbt` on((`tbh`.`idHistoriaClinica` = `tbt`.`idHistoriaClinica`))) join `tbl_detalletratamientodmcrecurso` `tbd` on((`tbt`.`idTratamiento` = `tbd`.`idDetalleTratamientodmcRecurso`))) join `tbl_recurso` `tbr` on((`tbd`.`idRecurso` = `tbr`.`idrecurso`))) join `tbl_categoriarecurso` `tbcg` on((`tbr`.`idCategoriaRecurso` = `tbcg`.`idCategoriaRecurso`))) join `tbl_tratamientodmc` on((`tbh`.`idHistoriaClinica` = `tbl_tratamientodmc`.`idHistoriaClinica`))) join `tbl_detalletratamientodmcrecurso` `dett` on((`tbl_tratamientodmc`.`idTratamiento` = `dett`.`idTratamiento`))) join `tbl_asignacionkit` on((`pa`.`idPaciente` = `tbl_asignacionkit`.`idPaciente`))) join `tbl_detallekit` on((`tbl_asignacionkit`.`idAsignacion` = `tbl_detallekit`.`idAsignacion`)));

-- --------------------------------------------------------

--
-- Estructura para la vista `viewdatosbasicospacientes`
--
DROP TABLE IF EXISTS `viewdatosbasicospacientes`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viewdatosbasicospacientes` AS select `a`.`idPaciente` AS `idPaciente`,`a`.`numeroDocumento` AS `numeroDocumento`,`a`.`fechaNacimiento` AS `fechaNacimiento`,concat(ifnull(`a`.`primerNombre`,''),' ',ifnull(`a`.`segundoNombre`,''),' ',ifnull(`a`.`primerApellido`,''),' ',ifnull(`a`.`segundoApellido`,'')) AS `NombreCompleto`,`a`.`ciudadResidencia` AS `ciudadResidencia`,`a`.`telefonoFijo` AS `telefonoFijo`,`a`.`fechaAfiliacionRegistro` AS `fechaAfiliacionRegistro`,`a`.`url` AS `url`,`b`.`descripcionTdocumento` AS `descripcionTdocumento`,`a`.`idEstadoPaciente` AS `idEstadoPaciente` from (`tbl_paciente` `a` join `tbl_tipodocumento` `b` on((`a`.`idtipoDocumento` = `b`.`idTipoDocumento`)));

-- --------------------------------------------------------

--
-- Estructura para la vista `viewdatosbasicosreporteaph`
--
DROP TABLE IF EXISTS `viewdatosbasicosreporteaph`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viewdatosbasicosreporteaph` AS select `a`.`idReporteAPH` AS `idReporteAPH`,concat(ifnull(`b`.`primerNombre`,''),' ',ifnull(`b`.`segundoNombre`,''),' ',ifnull(`b`.`primerApellido`,''),' ',ifnull(`b`.`segundoApellido`,'')) AS `nombreCompleto`,`b`.`numeroDocumento` AS `numeroDocumento`,`b`.`genero` AS `genero`,`b`.`telefonoFijo` AS `telefonoFijo`,`b`.`edadPaciente` AS `edadPaciente`,`d`.`informacionInicial` AS `informacionInicial`,`a`.`fechaHoraFinalizacion` AS `fechaHoraFinalizacion`,`c`.`idAmbulancia` AS `idAmbulancia`,`c`.`fechaHoraDespacho` AS `fechaHoraDespacho`,`a`.`idAsignacionPersonal` AS `idAsignacionPersonal` from (((`tbl_reporteaph` `a` join `tbl_paciente` `b` on((`a`.`idPaciente` = `b`.`idPaciente`))) join `tbl_despacho` `c` on((`a`.`idDespacho` = `c`.`idDespacho`))) join `tbl_reporteinicial` `d` on((`c`.`idReporteInicial` = `d`.`idReporteInicial`))) order by `a`.`idReporteAPH`;

-- --------------------------------------------------------

--
-- Estructura para la vista `viewlistarreporteinicial`
--
DROP TABLE IF EXISTS `viewlistarreporteinicial`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viewlistarreporteinicial` AS select `ri`.`idReporteInicial` AS `idReporteInicial`,`ri`.`informacionInicial` AS `informacionInicial`,`ri`.`ubicacionIncidente` AS `ubicacionIncidente`,`ri`.`puntoReferencia` AS `puntoReferencia`,`ri`.`numeroLesionados` AS `numeroLesionados`,`ri`.`fechaHoraAproximadaEmergencia` AS `fechaHoraAproximadaEmergencia`,`ri`.`fechaHoraEnvioReporteInicial` AS `fechaHoraEnvioReporteInicial`,`ri`.`estadoTablaReporteInicial` AS `estadoTablaReporteInicial`,concat(`p`.`primerNombre`,' ',`p`.`primerApellido`) AS `nombreReceptor`,`FNCONTARNOVEDADESREPORTE`(`ri`.`idReporteInicial`) AS `novedades` from (((`tbl_reporteinicial` `ri` join `tbl_chat` `cht` on((`cht`.`idChat` = `ri`.`idChat`))) join `tbl_cuentausuario` `cu` on((`cht`.`idReceptorInicial` = `cu`.`idUsuario`))) join `tbl_persona` `p` on((`cu`.`idPersona` = `p`.`idPersona`)));

-- --------------------------------------------------------

--
-- Estructura para la vista `viewlistarreportesactivos`
--
DROP TABLE IF EXISTS `viewlistarreportesactivos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viewlistarreportesactivos` AS select `tbl_reporteinicial`.`idReporteInicial` AS `idReporteInicial`,`tbl_reporteinicial`.`informacionInicial` AS `informacionInicial`,`tbl_reporteinicial`.`ubicacionIncidente` AS `ubicacionIncidente`,`tbl_reporteinicial`.`puntoReferencia` AS `puntoReferencia`,`tbl_reporteinicial`.`numeroLesionados` AS `numeroLesionados`,`tbl_reporteinicial`.`fechaHoraAproximadaEmergencia` AS `fechaHoraAproximadaEmergencia`,`tbl_reporteinicial`.`fechaHoraEnvioReporteInicial` AS `fechaHoraEnvioReporteInicial`,`tbl_reporteinicial`.`estadoTablaReporteInicial` AS `estadoTablaReporteInicial`,`tbl_reporteinicial`.`idChat` AS `idChat` from `tbl_reporteinicial` where (lcase(`tbl_reporteinicial`.`estadoTablaReporteInicial`) = convert(lcase('Activo') using utf8));

-- --------------------------------------------------------

--
-- Estructura para la vista `viewpersonalambulancia`
--
DROP TABLE IF EXISTS `viewpersonalambulancia`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viewpersonalambulancia` AS select `tblp`.`idPersona` AS `idPersona`,`tblp`.`primerNombre` AS `primerNombre`,`tblp`.`primerApellido` AS `primerApellido`,`tblr`.`descripcionRol` AS `descripcionRol` from ((`tbl_persona` `tblp` join `tbl_cuentausuario` `tblcu` on((`tblp`.`idPersona` = `tblcu`.`idPersona`))) join `tbl_rol` `tblr` on((`tblcu`.`idRol` = `tblr`.`idRol`))) where ((`tblp`.`dependencia` = 'APH') and (`tblp`.`estadoTablaPersona` = 'Activo') and ((lcase(`tblr`.`descripcionRol`) = convert(lcase('Médico') using utf8)) or (lcase(`tblr`.`descripcionRol`) = convert(lcase('Medico') using utf8)) or (lcase(`tblr`.`descripcionRol`) = convert(lcase('Paramédico') using utf8)) or (lcase(`tblr`.`descripcionRol`) = convert(lcase('Paramedico') using utf8))));

-- --------------------------------------------------------

--
-- Estructura para la vista `viewtemporalautorizacion`
--
DROP TABLE IF EXISTS `viewtemporalautorizacion`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viewtemporalautorizacion` AS (select `ta`.`idTemporalAutorizacion` AS `idTemporalAutorizacion`,`ta`.`idParamedico` AS `idParamedico`,`ta`.`idMedico` AS `idMedico`,`ta`.`idReporte` AS `idReporte`,`ta`.`idTipoTratamiento` AS `idTipoTratamiento`,`ta`.`idMedicamento` AS `idMedicamento`,`ta`.`descripcionAutorizacion` AS `descripcionAutorizacion`,`ta`.`observacionRespuestaAutorizacion` AS `observacionRespuestaAutorizacion`,`ta`.`cedulaPaciente` AS `cedulaPaciente`,`ta`.`estadoEvaluacion` AS `estadoEvaluacion`,`ta`.`fechaEnvio` AS `fechaEnvio`,`ta`.`fechaEvaluacion` AS `fechaEvaluacion`,concat(ifnull(`p`.`primerNombre`,''),' ',ifnull(`p`.`segundoNombre`,''),' ',ifnull(`p`.`primerApellido`,''),' ',ifnull(`p`.`segundoApellido`,'')) AS `nombreCompleto`,`p`.`correoElectronico` AS `correoElectronico`,`p`.`urlFoto` AS `urlFoto`,`p`.`numeroDocumento` AS `numeroDocumento`,`t`.`Descripcion` AS `Descripcion` from (((`tbl_temporalautorizacion` `ta` join `tbl_cuentausuario` `c` on((`ta`.`idParamedico` = `c`.`idUsuario`))) join `tbl_persona` `p` on((`c`.`idPersona` = `p`.`idPersona`))) join `tbl_tipotratamiento` `t` on((`ta`.`idTipoTratamiento` = `t`.`idTipoTratamiento`))) order by `ta`.`idTemporalAutorizacion` desc);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tbl_antecedenteaph`
--
ALTER TABLE `tbl_antecedenteaph`
  ADD CONSTRAINT `tbl_antecedenteaph_ibfk_1` FOREIGN KEY (`idReporteAPH`) REFERENCES `tbl_reporteaph` (`idReporteAPH`),
  ADD CONSTRAINT `tbl_antecedenteaph_ibfk_2` FOREIGN KEY (`idTipoAntecendente`) REFERENCES `tbl_tipoantecedente` (`idTipoAntecedente`);

--
-- Filtros para la tabla `tbl_antecedentedmc`
--
ALTER TABLE `tbl_antecedentedmc`
  ADD CONSTRAINT `tbl_antecedentedmc_ibfk_1` FOREIGN KEY (`idTipoAntecedente`) REFERENCES `tbl_tipoantecedente` (`idTipoAntecedente`),
  ADD CONSTRAINT `tbl_antecedentedmc_ibfk_2` FOREIGN KEY (`idHistoriaClinica`) REFERENCES `tbl_historiaclinica` (`idHistoriaClinica`);

--
-- Filtros para la tabla `tbl_asignacionkit`
--
ALTER TABLE `tbl_asignacionkit`
  ADD CONSTRAINT `tbl_asignacionkit_ibfk_1` FOREIGN KEY (`idPersona`) REFERENCES `tbl_persona` (`idPersona`),
  ADD CONSTRAINT `tbl_asignacionkit_ibfk_2` FOREIGN KEY (`idAmbulancia`) REFERENCES `tbl_ambulancia` (`idAmbulancia`),
  ADD CONSTRAINT `tbl_asignacionkit_ibfk_3` FOREIGN KEY (`idTipoAsignacion`) REFERENCES `tbl_tipoasignacion` (`idTipoAsignacion`),
  ADD CONSTRAINT `tbl_asignacionkit_ibfk_4` FOREIGN KEY (`idPaciente`) REFERENCES `tbl_paciente` (`idPaciente`);

--
-- Filtros para la tabla `tbl_asignacionpersonal`
--
ALTER TABLE `tbl_asignacionpersonal`
  ADD CONSTRAINT `tbl_asignacionpersonal_ibfk_1` FOREIGN KEY (`idAmbulancia`) REFERENCES `tbl_ambulancia` (`idAmbulancia`);

--
-- Filtros para la tabla `tbl_autorizacion`
--
ALTER TABLE `tbl_autorizacion`
  ADD CONSTRAINT `fk_autorizacion_medicamento` FOREIGN KEY (`idMedicamento`) REFERENCES `tbl_medicamento` (`idDetallekit`),
  ADD CONSTRAINT `tbl_autorizacion_ibfk_1` FOREIGN KEY (`idUsuarioParamedico`) REFERENCES `tbl_cuentausuario` (`idUsuario`),
  ADD CONSTRAINT `tbl_autorizacion_medico` FOREIGN KEY (`idUsuarioMedico`) REFERENCES `tbl_cuentausuario` (`idUsuario`),
  ADD CONSTRAINT `tbl_autorizacion_reporteAPH` FOREIGN KEY (`idReporteAPH`) REFERENCES `tbl_reporteaph` (`idReporteAPH`),
  ADD CONSTRAINT `tbl_autorizacion_tipoTratamiento` FOREIGN KEY (`idTipoTratamiento`) REFERENCES `tbl_tipotratamiento` (`idTipoTratamiento`);

--
-- Filtros para la tabla `tbl_chat`
--
ALTER TABLE `tbl_chat`
  ADD CONSTRAINT `FK_ID_RECEPTOR_INICIAL` FOREIGN KEY (`idReceptorInicial`) REFERENCES `tbl_cuentausuario` (`idUsuario`),
  ADD CONSTRAINT `FK_ID_USUARIO_EXTERNO` FOREIGN KEY (`idUsuarioExterno`) REFERENCES `tbl_cuentausuario` (`idUsuario`);

--
-- Filtros para la tabla `tbl_cita`
--
ALTER TABLE `tbl_cita`
  ADD CONSTRAINT `tbl_cita_ibfk_1` FOREIGN KEY (`idPaciente`) REFERENCES `tbl_paciente` (`idPaciente`),
  ADD CONSTRAINT `tbl_cita_ibfk_2` FOREIGN KEY (`idCUP`) REFERENCES `tbl_cup` (`idCUP`),
  ADD CONSTRAINT `tbl_cita_ibfk_3` FOREIGN KEY (`idZona`) REFERENCES `tbl_zona` (`idZona`);

--
-- Filtros para la tabla `tbl_cita_programacion`
--
ALTER TABLE `tbl_cita_programacion`
  ADD CONSTRAINT `tbl_cita_programacion_ibfk_1` FOREIGN KEY (`idCita`) REFERENCES `tbl_cita` (`idCita`),
  ADD CONSTRAINT `tbl_cita_programacion_ibfk_2` FOREIGN KEY (`idTurnoProgramacion`) REFERENCES `tbl_turnoprogramacion` (`idTurnoProgramacion`);

--
-- Filtros para la tabla `tbl_cuentausuario`
--
ALTER TABLE `tbl_cuentausuario`
  ADD CONSTRAINT `tbl_cuentausuario_ibfk_1` FOREIGN KEY (`idRol`) REFERENCES `tbl_rol` (`idRol`),
  ADD CONSTRAINT `tbl_cuentausuario_ibfk_2` FOREIGN KEY (`idPersona`) REFERENCES `tbl_persona` (`idPersona`);

--
-- Filtros para la tabla `tbl_cuidadoantarribo`
--
ALTER TABLE `tbl_cuidadoantarribo`
  ADD CONSTRAINT `tbl_cuidadoantarribo_ibfk_1` FOREIGN KEY (`idReporteAPH`) REFERENCES `tbl_reporteaph` (`idReporteAPH`);

--
-- Filtros para la tabla `tbl_cup`
--
ALTER TABLE `tbl_cup`
  ADD CONSTRAINT `tbl_cup_ibfk_1` FOREIGN KEY (`idConfiguracion`) REFERENCES `tbl_configuracion` (`idConfiguracion`),
  ADD CONSTRAINT `tbl_cup_ibfk_2` FOREIGN KEY (`idTipoCup`) REFERENCES `tbl_tipocup` (`idTipoCup`);

--
-- Filtros para la tabla `tbl_desfibrilacion`
--
ALTER TABLE `tbl_desfibrilacion`
  ADD CONSTRAINT `tbl_desfibrilacion_ibfk_1` FOREIGN KEY (`idReporteAPH`) REFERENCES `tbl_reporteaph` (`idReporteAPH`);

--
-- Filtros para la tabla `tbl_despacho`
--
ALTER TABLE `tbl_despacho`
  ADD CONSTRAINT `fk_idPersona_Despacho` FOREIGN KEY (`idPersona`) REFERENCES `tbl_persona` (`idPersona`),
  ADD CONSTRAINT `tbl_despacho_ibfk_1` FOREIGN KEY (`idReporteInicial`) REFERENCES `tbl_reporteinicial` (`idReporteInicial`),
  ADD CONSTRAINT `tbl_despacho_ibfk_2` FOREIGN KEY (`idAmbulancia`) REFERENCES `tbl_ambulancia` (`idAmbulancia`);

--
-- Filtros para la tabla `tbl_detalleasignacion`
--
ALTER TABLE `tbl_detalleasignacion`
  ADD CONSTRAINT `tbl_detalleasignacion_ibfk_1` FOREIGN KEY (`idAsignacionPersonal`) REFERENCES `tbl_asignacionpersonal` (`idAsignacionPersonal`),
  ADD CONSTRAINT `tbl_detalleasignacion_ibfk_2` FOREIGN KEY (`idPersona`) REFERENCES `tbl_persona` (`idPersona`);

--
-- Filtros para la tabla `tbl_detallekit`
--
ALTER TABLE `tbl_detallekit`
  ADD CONSTRAINT `tbl_detallekit_ibfk_1` FOREIGN KEY (`idAsignacion`) REFERENCES `tbl_asignacionkit` (`idAsignacion`),
  ADD CONSTRAINT `tbl_detallekit_ibfk_2` FOREIGN KEY (`idrecurso`) REFERENCES `tbl_recurso` (`idrecurso`);

--
-- Filtros para la tabla `tbl_detalletratamientodmcrecurso`
--
ALTER TABLE `tbl_detalletratamientodmcrecurso`
  ADD CONSTRAINT `tbl_detalletratamientodmcrecurso_ibfk_1` FOREIGN KEY (`idRecurso`) REFERENCES `tbl_recurso` (`idrecurso`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `tbl_detalletratamientodmcrecurso_ibfk_2` FOREIGN KEY (`idTratamiento`) REFERENCES `tbl_tratamientodmc` (`idTratamiento`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `tbl_devolucion`
--
ALTER TABLE `tbl_devolucion`
  ADD CONSTRAINT `tbl_devolucion_ibfk_1` FOREIGN KEY (`idTipoDevolucion`) REFERENCES `tbl_tipodevolucion` (`idTipoDevolucion`),
  ADD CONSTRAINT `tbl_devolucion_ibfk_2` FOREIGN KEY (`idDetallekit`) REFERENCES `tbl_detallekit` (`idDetallekit`),
  ADD CONSTRAINT `tbl_devolucion_ibfk_3` FOREIGN KEY (`idPersona`) REFERENCES `tbl_persona` (`idPersona`);

--
-- Filtros para la tabla `tbl_diagnostico`
--
ALTER TABLE `tbl_diagnostico`
  ADD CONSTRAINT `tbl_diagnostico_ibfk_1` FOREIGN KEY (`idCIE10`) REFERENCES `tbl_cie10` (`idCIE10`),
  ADD CONSTRAINT `tbl_diagnostico_ibfk_2` FOREIGN KEY (`idHistoriaClinica`) REFERENCES `tbl_historiaclinica` (`idHistoriaClinica`);

--
-- Filtros para la tabla `tbl_enteexterno_reporteinicial`
--
ALTER TABLE `tbl_enteexterno_reporteinicial`
  ADD CONSTRAINT `tbl_enteexterno_reporteinicial_ibfk_1` FOREIGN KEY (`idEnteExterno`) REFERENCES `tbl_enteexterno` (`idEnteExterno`),
  ADD CONSTRAINT `tbl_enteexterno_reporteinicial_ibfk_2` FOREIGN KEY (`idReporteInicial`) REFERENCES `tbl_reporteinicial` (`idReporteInicial`);

--
-- Filtros para la tabla `tbl_equipobiomedico`
--
ALTER TABLE `tbl_equipobiomedico`
  ADD CONSTRAINT `tbl_equipobiomedico_ibfk_1` FOREIGN KEY (`idTratamiento`) REFERENCES `tbl_tratamientodmc` (`idTratamiento`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `tbl_estandarkit`
--
ALTER TABLE `tbl_estandarkit`
  ADD CONSTRAINT `FK_ESTANDAR_KIT_RECURSO` FOREIGN KEY (`idRecurso`) REFERENCES `tbl_recurso` (`idrecurso`),
  ADD CONSTRAINT `FK_ESTANDAR_KIT_TIPO_KIT` FOREIGN KEY (`idTipoKit`) REFERENCES `tbl_tipokit` (`idTipoKit`);

--
-- Filtros para la tabla `tbl_evaluacionautorizacion`
--
ALTER TABLE `tbl_evaluacionautorizacion`
  ADD CONSTRAINT `tbl_evaluacionautorizacion_ibfk_1` FOREIGN KEY (`idReporteAPH`) REFERENCES `tbl_reporteaph` (`idReporteAPH`),
  ADD CONSTRAINT `tbl_evaluacionautorizacion_ibfk_2` FOREIGN KEY (`idCuentaMedico`) REFERENCES `tbl_cuentausuario` (`idUsuario`),
  ADD CONSTRAINT `tbl_evaluacionautorizacion_ibfk_3` FOREIGN KEY (`idAutorizacion`) REFERENCES `tbl_autorizacion` (`idAutorizacion`);

--
-- Filtros para la tabla `tbl_examenespecializado`
--
ALTER TABLE `tbl_examenespecializado`
  ADD CONSTRAINT `tbl_examenespecializado_ibfk_1` FOREIGN KEY (`idTipoexamenespecializado`) REFERENCES `tbl_tipoexamenespecializado` (`idTipoExamenEspecializado`),
  ADD CONSTRAINT `tbl_examenespecializado_ibfk_2` FOREIGN KEY (`idHistoriaClinica`) REFERENCES `tbl_historiaclinica` (`idHistoriaClinica`);

--
-- Filtros para la tabla `tbl_examenfisicodmc`
--
ALTER TABLE `tbl_examenfisicodmc`
  ADD CONSTRAINT `tbl_examenfisicodmc_ibfk_1` FOREIGN KEY (`idtipoExamenFisico`) REFERENCES `tbl_tipoexamenfisico` (`idtipoExamenFisico`),
  ADD CONSTRAINT `tbl_examenfisicodmc_ibfk_2` FOREIGN KEY (`idHistoriaClinica`) REFERENCES `tbl_historiaclinica` (`idHistoriaClinica`);

--
-- Filtros para la tabla `tbl_formulamedica`
--
ALTER TABLE `tbl_formulamedica`
  ADD CONSTRAINT `tbl_formulamedica_ibfk_1` FOREIGN KEY (`idHistoriaClinica`) REFERENCES `tbl_historiaclinica` (`idHistoriaClinica`);

--
-- Filtros para la tabla `tbl_formulamedicamedicamentodmc`
--
ALTER TABLE `tbl_formulamedicamedicamentodmc`
  ADD CONSTRAINT `tbl_formulamedicamedicamentodmc_ibfk_1` FOREIGN KEY (`idFormulamedica`) REFERENCES `tbl_formulamedica` (`idFormulaMedica`),
  ADD CONSTRAINT `tbl_formulamedicamedicamentodmc_ibfk_2` FOREIGN KEY (`idMedicamento`) REFERENCES `tbl_recurso` (`idrecurso`);

--
-- Filtros para la tabla `tbl_historiaclinica`
--
ALTER TABLE `tbl_historiaclinica`
  ADD CONSTRAINT `tbl_historiaclinica_ibfk_4` FOREIGN KEY (`idTipoorigenatencion`) REFERENCES `tbl_tipoorigenatencion` (`idTipoOrigenAtencion`),
  ADD CONSTRAINT `tbl_historiaclinica_ibfk_5` FOREIGN KEY (`idCitaprogramacion`) REFERENCES `tbl_cita_programacion` (`idCitaprogramacion`),
  ADD CONSTRAINT `tbl_historiaclinica_ibfk_6` FOREIGN KEY (`idPaciente`) REFERENCES `tbl_paciente` (`idPaciente`);

--
-- Filtros para la tabla `tbl_historialmora`
--
ALTER TABLE `tbl_historialmora`
  ADD CONSTRAINT `tbl_historialmora_ibfk_1` FOREIGN KEY (`idCita`) REFERENCES `tbl_cita` (`idCita`),
  ADD CONSTRAINT `tbl_historialmora_ibfk_2` FOREIGN KEY (`idMulta`) REFERENCES `tbl_multa` (`idMulta`);

--
-- Filtros para la tabla `tbl_incapacidad`
--
ALTER TABLE `tbl_incapacidad`
  ADD CONSTRAINT `tbl_incapacidad_ibfk_1` FOREIGN KEY (`idCIE10`) REFERENCES `tbl_cie10` (`idCIE10`),
  ADD CONSTRAINT `tbl_incapacidad_ibfk_2` FOREIGN KEY (`idHistoriaClinica`) REFERENCES `tbl_historiaclinica` (`idHistoriaClinica`);

--
-- Filtros para la tabla `tbl_interconsulta`
--
ALTER TABLE `tbl_interconsulta`
  ADD CONSTRAINT `tbl_interconsulta_ibfk_1` FOREIGN KEY (`idHistoriaClinica`) REFERENCES `tbl_historiaclinica` (`idHistoriaClinica`);

--
-- Filtros para la tabla `tbl_lesion`
--
ALTER TABLE `tbl_lesion`
  ADD CONSTRAINT `tbl_lesion_ibfk_1` FOREIGN KEY (`idPuntoLesion`) REFERENCES `tbl_puntolesion` (`idPuntoLesion`),
  ADD CONSTRAINT `tbl_lesion_ibfk_2` FOREIGN KEY (`idCIE10`) REFERENCES `tbl_cie10` (`idCIE10`);

--
-- Filtros para la tabla `tbl_llamada`
--
ALTER TABLE `tbl_llamada`
  ADD CONSTRAINT `tbl_llamada_ibfk_1` FOREIGN KEY (`idChat`) REFERENCES `tbl_chat` (`idChat`);

--
-- Filtros para la tabla `tbl_medicamento`
--
ALTER TABLE `tbl_medicamento`
  ADD CONSTRAINT `tbl_medicamento_ibfk_1` FOREIGN KEY (`idReporteAPH`) REFERENCES `tbl_reporteaph` (`idReporteAPH`),
  ADD CONSTRAINT `tbl_medicamento_ibfk_2` FOREIGN KEY (`idDetallekit`) REFERENCES `tbl_detallekit` (`idDetallekit`),
  ADD CONSTRAINT `tbl_medicamento_ibfk_3` FOREIGN KEY (`idHistoriaClinica`) REFERENCES `tbl_historiaclinica` (`idHistoriaClinica`);

--
-- Filtros para la tabla `tbl_mensaje`
--
ALTER TABLE `tbl_mensaje`
  ADD CONSTRAINT `tbl_mensaje_ibfk_1` FOREIGN KEY (`idChat`) REFERENCES `tbl_chat` (`idChat`);

--
-- Filtros para la tabla `tbl_notaenfermeria`
--
ALTER TABLE `tbl_notaenfermeria`
  ADD CONSTRAINT `tbl_notaenfermeria_ibfk_1` FOREIGN KEY (`idPersona`) REFERENCES `tbl_persona` (`idPersona`),
  ADD CONSTRAINT `tbl_notaenfermeria_ibfk_2` FOREIGN KEY (`idProcedimiento`) REFERENCES `tbl_procedimiento` (`idProcedimiento`);

--
-- Filtros para la tabla `tbl_novedadrecurso`
--
ALTER TABLE `tbl_novedadrecurso`
  ADD CONSTRAINT `tbl_novedadrecurso_ibfk_1` FOREIGN KEY (`idDetallekit`) REFERENCES `tbl_detallekit` (`idDetallekit`),
  ADD CONSTRAINT `tbl_novedadrecurso_ibfk_2` FOREIGN KEY (`idPersona`) REFERENCES `tbl_persona` (`idPersona`),
  ADD CONSTRAINT `tbl_novedadrecurso_ibfk_3` FOREIGN KEY (`idTipoNovedad`) REFERENCES `tbl_tiponovedad` (`idTipoNovedad`);

--
-- Filtros para la tabla `tbl_novedadreporteinicial`
--
ALTER TABLE `tbl_novedadreporteinicial`
  ADD CONSTRAINT `tbl_novedadreporteinicial_ibfk_1` FOREIGN KEY (`idReporteInicial`) REFERENCES `tbl_reporteinicial` (`idReporteInicial`);

--
-- Filtros para la tabla `tbl_novedadreporteinicial_enteexterno`
--
ALTER TABLE `tbl_novedadreporteinicial_enteexterno`
  ADD CONSTRAINT `tbl_novedadreporteinicial_enteexterno_ibfk_1` FOREIGN KEY (`idNovedad`) REFERENCES `tbl_novedadreporteinicial` (`idNovedad`),
  ADD CONSTRAINT `tbl_novedadreporteinicial_enteexterno_ibfk_2` FOREIGN KEY (`idEnteExterno`) REFERENCES `tbl_enteexterno` (`idEnteExterno`);

--
-- Filtros para la tabla `tbl_observacion`
--
ALTER TABLE `tbl_observacion`
  ADD CONSTRAINT `tbl_observacion_ibfk_1` FOREIGN KEY (`idProcedimiento`) REFERENCES `tbl_procedimiento` (`idProcedimiento`),
  ADD CONSTRAINT `tbl_observacion_ibfk_2` FOREIGN KEY (`idPersonaResponsable`) REFERENCES `tbl_persona` (`idPersona`);

--
-- Filtros para la tabla `tbl_otrodmc`
--
ALTER TABLE `tbl_otrodmc`
  ADD CONSTRAINT `tbl_otrodmc_ibfk_1` FOREIGN KEY (`idHistoriaClinica`) REFERENCES `tbl_historiaclinica` (`idHistoriaClinica`);

--
-- Filtros para la tabla `tbl_paciente`
--
ALTER TABLE `tbl_paciente`
  ADD CONSTRAINT `FK_PACIENTE_ESTADO_PACIENTE` FOREIGN KEY (`idEstadoPaciente`) REFERENCES `tbl_estadopaciente` (`idEstadoPaciente`),
  ADD CONSTRAINT `tbl_paciente_ibfk_1` FOREIGN KEY (`idtipoDocumento`) REFERENCES `tbl_tipodocumento` (`idTipoDocumento`),
  ADD CONSTRAINT `tbl_paciente_ibfk_2` FOREIGN KEY (`idtipoDocumento`) REFERENCES `tbl_tipodocumento` (`idTipoDocumento`),
  ADD CONSTRAINT `tbl_paciente_ibfk_3` FOREIGN KEY (`idtipoAfiliacion`) REFERENCES `tbl_tipoafiliacion` (`idTipoAfiliacion`);

--
-- Filtros para la tabla `tbl_personaespecialidad`
--
ALTER TABLE `tbl_personaespecialidad`
  ADD CONSTRAINT `tbl_personaespecialidad_ibfk_1` FOREIGN KEY (`idPersona`) REFERENCES `tbl_persona` (`idPersona`),
  ADD CONSTRAINT `tbl_personaespecialidad_ibfk_2` FOREIGN KEY (`idEspecialidad`) REFERENCES `tbl_especialidad` (`idEspecialidad`);

--
-- Filtros para la tabla `tbl_piel`
--
ALTER TABLE `tbl_piel`
  ADD CONSTRAINT `tbl_piel_ibfk_1` FOREIGN KEY (`idExamenFisico`) REFERENCES `tbl_examenfisicoaph` (`idExamenFisico`);

--
-- Filtros para la tabla `tbl_procedimiento`
--
ALTER TABLE `tbl_procedimiento`
  ADD CONSTRAINT `tbl_procedimiento_ibfk_1` FOREIGN KEY (`idHistoriaClinica`) REFERENCES `tbl_historiaclinica` (`idHistoriaClinica`),
  ADD CONSTRAINT `tbl_procedimiento_ibfk_2` FOREIGN KEY (`idCUP`) REFERENCES `tbl_cup` (`idCUP`);

--
-- Filtros para la tabla `tbl_puntolesion`
--
ALTER TABLE `tbl_puntolesion`
  ADD CONSTRAINT `tbl_puntolesion_ibfk_1` FOREIGN KEY (`idReporteAPH`) REFERENCES `tbl_reporteaph` (`idReporteAPH`);

--
-- Filtros para la tabla `tbl_reporteaph`
--
ALTER TABLE `tbl_reporteaph`
  ADD CONSTRAINT `FK_ASIGNACION_PERSONAL_REPORTE` FOREIGN KEY (`idAsignacionPersonal`) REFERENCES `tbl_asignacionpersonal` (`idAsignacionPersonal`),
  ADD CONSTRAINT `tbl_reporteaph_ibfk_1` FOREIGN KEY (`idPaciente`) REFERENCES `tbl_paciente` (`idPaciente`),
  ADD CONSTRAINT `tbl_reporteaph_ibfk_10` FOREIGN KEY (`idExamenFisico`) REFERENCES `tbl_examenfisicoaph` (`idExamenFisico`),
  ADD CONSTRAINT `tbl_reporteaph_ibfk_11` FOREIGN KEY (`idAcompanante`) REFERENCES `tbl_acompanante` (`idAcompanante`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `tbl_reporteaph_ibfk_12` FOREIGN KEY (`idParamedicoAtiende`) REFERENCES `tbl_cuentausuario` (`idUsuario`),
  ADD CONSTRAINT `tbl_reporteaph_ibfk_2` FOREIGN KEY (`idExamenFisico`) REFERENCES `tbl_examenfisicoaph` (`idExamenFisico`),
  ADD CONSTRAINT `tbl_reporteaph_ibfk_3` FOREIGN KEY (`idDespacho`) REFERENCES `tbl_despacho` (`idDespacho`),
  ADD CONSTRAINT `tbl_reporteaph_ibfk_4` FOREIGN KEY (`idTriage`) REFERENCES `tbl_triage` (`idTriage`),
  ADD CONSTRAINT `tbl_reporteaph_ibfk_5` FOREIGN KEY (`idCertificadoAtencion`) REFERENCES `tbl_certificadoatencion` (`idCertificadoAtencion`),
  ADD CONSTRAINT `tbl_reporteaph_ibfk_6` FOREIGN KEY (`idTipoAseguramiento`) REFERENCES `tbl_tipoaseguramiento` (`idTipoAseguramiento`),
  ADD CONSTRAINT `tbl_reporteaph_ibfk_7` FOREIGN KEY (`idAfectadoAccidenteTransito`) REFERENCES `tbl_afectadoaccidentetransito` (`idAfectadoAccidenteTransito`),
  ADD CONSTRAINT `tbl_reporteaph_ibfk_8` FOREIGN KEY (`idPersonalRecibe`) REFERENCES `tbl_cuentausuario` (`idUsuario`),
  ADD CONSTRAINT `tbl_reporteaph_ibfk_9` FOREIGN KEY (`idTipoAseguramiento`) REFERENCES `tbl_tipoaseguramiento` (`idTipoAseguramiento`);

--
-- Filtros para la tabla `tbl_reporteaph_motivoconsulta`
--
ALTER TABLE `tbl_reporteaph_motivoconsulta`
  ADD CONSTRAINT `tbl_reporteaph_motivoconsulta_ibfk_1` FOREIGN KEY (`idReporteAPH`) REFERENCES `tbl_reporteaph` (`idReporteAPH`),
  ADD CONSTRAINT `tbl_reporteaph_motivoconsulta_ibfk_2` FOREIGN KEY (`idMotivoConsulta`) REFERENCES `tbl_motivoconsulta` (`idMotivoConsulta`);

--
-- Filtros para la tabla `tbl_reporteinicial`
--
ALTER TABLE `tbl_reporteinicial`
  ADD CONSTRAINT `FK_ID_CHAT` FOREIGN KEY (`idChat`) REFERENCES `tbl_chat` (`idChat`);

--
-- Filtros para la tabla `tbl_restablecer`
--
ALTER TABLE `tbl_restablecer`
  ADD CONSTRAINT `tbl_restablecer_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `tbl_cuentausuario` (`idUsuario`);

--
-- Filtros para la tabla `tbl_rolmodulovista`
--
ALTER TABLE `tbl_rolmodulovista`
  ADD CONSTRAINT `tbl_rolmodulovista_ibfk_1` FOREIGN KEY (`idRol`) REFERENCES `tbl_rol` (`idRol`),
  ADD CONSTRAINT `tbl_rolmodulovista_ibfk_2` FOREIGN KEY (`idModulo`) REFERENCES `tbl_modulo` (`idModulo`),
  ADD CONSTRAINT `tbl_rolmodulovista_ibfk_3` FOREIGN KEY (`idVista`) REFERENCES `tbl_vista` (`idVista`);

--
-- Filtros para la tabla `tbl_signosvitales`
--
ALTER TABLE `tbl_signosvitales`
  ADD CONSTRAINT `tbl_signosvitales_ibfk_1` FOREIGN KEY (`idHistoriaClinica`) REFERENCES `tbl_historiaclinica` (`idHistoriaClinica`),
  ADD CONSTRAINT `tbl_signosvitales_ibfk_2` FOREIGN KEY (`idValoracion`) REFERENCES `tbl_valoracion` (`idValoracion`);

--
-- Filtros para la tabla `tbl_testigo`
--
ALTER TABLE `tbl_testigo`
  ADD CONSTRAINT `tbl_testigo_ibfk_1` FOREIGN KEY (`idReporteAPH`) REFERENCES `tbl_reporteaph` (`idReporteAPH`);

--
-- Filtros para la tabla `tbl_tipoevento_novedadreporteinicial`
--
ALTER TABLE `tbl_tipoevento_novedadreporteinicial`
  ADD CONSTRAINT `tbl_tipoevento_novedadreporteinicial_ibfk_1` FOREIGN KEY (`idNovedad`) REFERENCES `tbl_novedadreporteinicial` (`idNovedad`),
  ADD CONSTRAINT `tbl_tipoevento_novedadreporteinicial_ibfk_2` FOREIGN KEY (`idTipoEvento`) REFERENCES `tbl_tipoevento` (`idTipoEvento`);

--
-- Filtros para la tabla `tbl_tipoevento_reporteinicial`
--
ALTER TABLE `tbl_tipoevento_reporteinicial`
  ADD CONSTRAINT `tbl_tipoevento_reporteinicial_ibfk_1` FOREIGN KEY (`idReporteInicial`) REFERENCES `tbl_reporteinicial` (`idReporteInicial`),
  ADD CONSTRAINT `tbl_tipoevento_reporteinicial_ibfk_2` FOREIGN KEY (`idTipoEvento`) REFERENCES `tbl_tipoevento` (`idTipoEvento`);

--
-- Filtros para la tabla `tbl_tratamientoaph`
--
ALTER TABLE `tbl_tratamientoaph`
  ADD CONSTRAINT `tbl_tratamientoaph_ibfk_1` FOREIGN KEY (`idReporteAPH`) REFERENCES `tbl_reporteaph` (`idReporteAPH`),
  ADD CONSTRAINT `tbl_tratamientoaph_ibfk_2` FOREIGN KEY (`idTipoTratamiento`) REFERENCES `tbl_tipotratamiento` (`idTipoTratamiento`);

--
-- Filtros para la tabla `tbl_tratamientodmc`
--
ALTER TABLE `tbl_tratamientodmc`
  ADD CONSTRAINT `tbl_tratamientodmc_ibfk_1` FOREIGN KEY (`idTipoTratamiento`) REFERENCES `tbl_tipotratamiento` (`idTipoTratamiento`),
  ADD CONSTRAINT `tbl_tratamientodmc_ibfk_2` FOREIGN KEY (`idHistoriaClinica`) REFERENCES `tbl_historiaclinica` (`idHistoriaClinica`);

--
-- Filtros para la tabla `tbl_tratamientodmcrecurso`
--
ALTER TABLE `tbl_tratamientodmcrecurso`
  ADD CONSTRAINT `tbl_tratamientodmcrecurso_ibfk_1` FOREIGN KEY (`idTratamientoDmc`) REFERENCES `tbl_tratamientodmc` (`idTratamiento`),
  ADD CONSTRAINT `tbl_tratamientodmcrecurso_ibfk_2` FOREIGN KEY (`idrecurso`) REFERENCES `tbl_recurso` (`idrecurso`);

--
-- Filtros para la tabla `tbl_turnoprogramacion`
--
ALTER TABLE `tbl_turnoprogramacion`
  ADD CONSTRAINT `tbl_turnoprogramacion_ibfk_1` FOREIGN KEY (`idTurno`) REFERENCES `tbl_turno` (`idTurno`),
  ADD CONSTRAINT `tbl_turnoprogramacion_ibfk_2` FOREIGN KEY (`idProgramacion`) REFERENCES `tbl_programacion` (`idProgramacion`),
  ADD CONSTRAINT `tbl_turnoprogramacion_ibfk_3` FOREIGN KEY (`idPersona`) REFERENCES `tbl_persona` (`idPersona`);

--
-- Filtros para la tabla `tbl_viacomunicacioncontrolmedico`
--
ALTER TABLE `tbl_viacomunicacioncontrolmedico`
  ADD CONSTRAINT `tbl_viacomunicacioncontrolmedico_ibfk_1` FOREIGN KEY (`idReporteAPH`) REFERENCES `tbl_reporteaph` (`idReporteAPH`);

--
-- Filtros para la tabla `tbl_zona`
--
ALTER TABLE `tbl_zona`
  ADD CONSTRAINT `tbl_zona_ibfk_1` FOREIGN KEY (`idTipoZona`) REFERENCES `tbl_tipozona` (`idTipoZona`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

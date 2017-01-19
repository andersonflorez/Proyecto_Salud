-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-06-2016 a las 23:00:19
-- Versión del servidor: 5.6.17
-- Versión de PHP: 5.5.12

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
SET FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

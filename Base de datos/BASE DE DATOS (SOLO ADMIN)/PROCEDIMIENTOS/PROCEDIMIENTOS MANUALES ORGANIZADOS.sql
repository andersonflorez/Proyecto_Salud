DELIMITER !

USE `bd_proyecto_salud` !

# PROCEDIMIENTO:
CREATE PROCEDURE spDetalleKit()
BEGIN
  SELECT max(tbl_asignacionkit.idAsignacion) as idAsignacion
  FROM tbl_asignacionkit;
END !

# PROCEDIMIENTO:
CREATE PROCEDURE spRegistrarEnteexterno(IN $descripcionEnteExterno VARCHAR(45))
BEGIN
  INSERT INTO `tbl_enteexterno`(`descripcionEnteExterno`)
  VALUES ($descripcionEnteExterno);
END !

# PROCEDIMIENTO:
CREATE PROCEDURE spRegistrarTipoevento(IN $descripcionTipoEvento VARCHAR(45))
BEGIN
  INSERT INTO `tbl_tipoevento`(`descripcionTipoEvento`)
  VALUES ($descripcionTipoEvento);
END !

#PROCEDIMIENTO:
CREATE PROCEDURE `spConsultarPersonaDocumento`(IN `$numeroDocumento` VARCHAR(45))
BEGIN
  SELECT * FROM tbl_persona
  INNER JOIN tbl_cuentausuario
  ON tbl_persona.idPersona = tbl_cuentausuario.idPersona
  INNER JOIN tbl_rol
  ON tbl_rol.idRol = tbl_cuentausuario.idRol
  Where numeroDocumento = $numeroDocumento AND descripcionRol like ('%Medico Externo%');
END !

# PROCEDIMIENTO:
CREATE PROCEDURE spRegistrarVistoChat(IN $idChat INT)
BEGIN
  UPDATE tbl_chat
  SET visto = 1
  WHERE idChat = $idChat;
END !

# PROCEDIMIENTO:
CREATE PROCEDURE spConsultarMensajeNotificacion(IN $idChat INT)
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
END !

# PROCEDIMIENTO:
CREATE PROCEDURE spConsultarNotificacionesChat(IN $idReceptor INT)
BEGIN
  SELECT *
  FROM tbl_chat
  WHERE idReceptorInicial = $idReceptor AND estadoTabla = 1 AND visto = 0;
END !

# PROCEDIMIENTO:
CREATE PROCEDURE spRegistrarMensaje(
  IN $idChat INT,
  IN $mensaje VARCHAR(200),
  IN $tipo INT
)
BEGIN
  INSERT INTO `tbl_mensaje`(`idChat`, `mensaje`, `tipo`)
  VALUES ($idChat, $mensaje, $tipo);
END !

# PROCEDIMIENTO:
CREATE PROCEDURE spRegistrarChat(IN $idReceptorInicial INT, IN $idUsuarioExterno INT)
BEGIN
  INSERT INTO `tbl_chat`(`idReceptorInicial`, `idUsuarioExterno`)
  VALUES ($idReceptorInicial, $idUsuarioExterno);
  SELECT MAX(idChat) FROM tbl_chat;
END !

# PROCEDIMIENTO:
CREATE PROCEDURE spConsultarChatsUsuario(IN $idUsuarioExterno INT)
BEGIN
  SELECT * FROM `tbl_chat`
  WHERE `idUsuarioExterno` = $idUsuarioExterno AND estadoTabla = 0
  ORDER BY fechaHoraInicioChat DESC;
END !

# PROCEDIMIENTO:
CREATE PROCEDURE spValidarChatActivo(IN $idUsuario INT, IN $bool INT)
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
END !

# PROCEDIMIENTO:
CREATE PROCEDURE spConsultarMensajesChat(IN $idChat INT)
BEGIN
  SELECT mensaje, fechaHora, tipo
  FROM `tbl_mensaje`
  WHERE `idChat` = $idChat
  ORDER BY fechaHora ASC;
END !

# PROCEDIMIENTO:
CREATE PROCEDURE spCambiarEstadoChat(IN $idUsuarioExterno INT)
BEGIN
  UPDATE `tbl_chat`
  SET `estadoTabla` = 0
  WHERE idUsuarioExterno = $idUsuarioExterno AND estadoTabla = 1;
END !

# PROCEDIMIENTO:
CREATE PROCEDURE spConsultarReceptorInicial(IN $idUsuario INT)
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
END !

# PROCEDIMIENTO:
CREATE PROCEDURE spConsultarUsuarioExterno(IN $idUsuario INT)
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
END !


# PROCEDIMIENTO
CREATE PROCEDURE spRegistrarReporteinicial(
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
END !


# PROCEDIMIENTO:
CREATE PROCEDURE spRegistrarDespacho(
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
END !

# FUNCIÓN:
CREATE FUNCTION fnContarNovedadesReporte(idReporte INT)
RETURNS INT
BEGIN
  DECLARE NumeroNovedades INT;
  SET NumeroNovedades = (SELECT COUNT(idNovedad)
                         FROM tbl_novedadreporteinicial
                         WHERE idReporteInicial = idReporte);
  RETURN NumeroNovedades;
END !

CREATE OR REPLACE VIEW viewAsignaciones AS
    SELECT
        tba.idAmbulancia,
        tba.tipoAmbulancia,
        tbla.latitud,
        tbla.longitud,
        tblp.primerNombre,
        tblp.primerApellido,
        tble.descripcionEspecialidad
    FROM
        tbl_ambulancia AS tba
            INNER JOIN
        tbl_asignacionpersonal AS tbla ON tba.idAmbulancia = tbla.idAmbulancia
            INNER JOIN
        tbl_detalleasignacion AS tblda ON tbla.idAsignacionPersonal = tblda.idAsignacionPersonal
            INNER JOIN
        tbl_persona AS tblp ON tblda.idPersona = tblp.idPersona
            INNER JOIN
        tbl_personaespecialidad AS tblpe ON tblp.idPersona = tblpe.idPersona
            INNER JOIN
        tbl_especialidad AS tble ON tblpe.idEspecialidad = tble.idEspecialidad
    WHERE
        tba.estadoTabla LIKE 'activo'
            AND tbla.estadoTablaAsignacion LIKE 'activo'
    ORDER BY tba.idAmbulancia ASC!

# PROCEDIMIENTO:
CREATE PROCEDURE spCosnultarAsignacionAmbulancia(in _idAmbulancia int)
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
END !

# PROCEDIMIENTO:
CREATE PROCEDURE spModificarAsignacion(
  IN _fechaHora datetime,
  IN _latitudAmbulancia varchar(50),
  IN _longitudAmbulancia varchar(50),
  IN _idAmbulancia int
)
BEGIN
  UPDATE tbl_asignacionpersonal
  SET fechaHoraAsignacion = _fechaHora, latitud = _latitudAmbulancia, longitud = _longitudAmbulancia
  WHERE idAmbulancia = _idAmbulancia;
END !

# PROCEDIMIENTO:
CREATE PROCEDURE spModificarDetalleAsignacion(
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
END !

# PROCEDIMIENTO:
CREATE PROCEDURE spConsultarAsignaciones()
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
END !

CREATE OR REPLACE VIEW viewPersonalAmbulancia AS
SELECT tblp.idPersona, tblp.primerNombre, tblp.primerApellido, tblr.descripcionRol
FROM tbl_persona tblp
INNER JOIN tbl_cuentausuario tblcu
ON tblp.idPersona = tblcu.idPersona
INNER JOIN tbl_rol tblr
ON tblcu.idRol = tblr.idRol
WHERE (tblp.dependencia = 'APH' AND tblp.estadoTablaPersona = 'Activo') AND (LOWER(tblr.descripcionRol) = LOWER('Médico') OR LOWER(tblr.descripcionRol) = LOWER('Medico') OR LOWER(tblr.descripcionRol) = LOWER('Paramédico') OR LOWER(tblr.descripcionRol) = LOWER('Paramedico')) !


CREATE OR REPLACE VIEW viewambulanciasdisponibles AS
SELECT idAmbulancia, tipoAmbulancia, placaAmbulancia FROM tbl_ambulancia WHERE estadoTabla = 'Activo'!

# PROCEDIMIENTO:
CREATE PROCEDURE spListarNovedadrecurso()
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
END !

# PROCEDIMIENTO:
CREATE PROCEDURE spListarDevolucion(
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
END !

# PROCEDIMIENTO:
CREATE PROCEDURE spListarAsignacionkit()
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
END !

CREATE VIEW viewListarReporteInicial AS
    SELECT
        ri.`idReporteInicial`,
        ri.`informacionInicial`,
        ri.`ubicacionIncidente`,
        ri.`puntoReferencia`,
        ri.`numeroLesionados`,
        ri.`fechaHoraAproximadaEmergencia`,
        ri.`fechaHoraEnvioReporteInicial`,
        ri.`estadoTablaReporteInicial`,
        CONCAT(p.primerNombre, ' ', p.primerApellido) 'nombreReceptor',
        FNCONTARNOVEDADESREPORTE(ri.idReporteInicial) 'novedades'
    FROM
        tbl_reporteinicial ri
            INNER JOIN
        tbl_chat cht ON cht.idChat = ri.idChat
            INNER JOIN
        tbl_cuentausuario cu ON cht.idReceptorInicial = cu.idUsuario
            INNER JOIN
        tbl_persona p ON cu.idPersona = p.idPersona!

# PROCEDIMIENTO:
CREATE PROCEDURE spListarReporteinicial()
BEGIN
  SELECT *
  FROM tbl_reporteinicial
  WHERE estadoTablaReporteInicial = 'Activo';
END !

# PROCEDIMIENTO:
CREATE PROCEDURE spConsultarPersonaProgramacion(IN $id INT)
BEGIN
  SELECT p.primerNombre ,p.segundoNombre, p.primerApellido,p.segundoApellido,p.telefono,p.direccion,p.numeroDocumento,p.sexo,p.lugarNacimiento,p.fechaNacimiento,p.ciudad,p.departamento,p.correoElectronico,p.estadoPersona,p.pais,p.grupoSanguineo,p.dependencia,e.descripcionEspecialidad , e.idEspecialidad,es.idPersonaespecialidad
  FROM tbl_persona p
  INNER JOIN tbl_personaespecialidad es
  ON p.idPersona = es.idPersona
  INNER JOIN tbl_especialidad e
  ON es.idEspecialidad = e.idEspecialidad
  WHERE p.idPersona = $id;
END !

# PROCEDIMIENTO:
CREATE PROCEDURE spListarPersonaProgramacion()
BEGIN
  SELECT p.idPersona, p.primerNombre ,  p.primerApellido, e.descripcionEspecialidad , e.idEspecialidad,es.idPersonaespecialidad
  FROM tbl_persona p
  INNER JOIN tbl_personaespecialidad es
  ON p.idPersona = es.idPersona
  INNER JOIN tbl_especialidad e
  ON es.idEspecialidad = e.idEspecialidad;
END !

# PROCEDIMIENTO:
CREATE PROCEDURE spCitasAgendadas()
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
END !

# PROCEDIMIENTO:
CREATE PROCEDURE spConsultarAgenda(IN $idPersona INT)
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
END !

# PROCEDIMIENTO:
CREATE PROCEDURE spConsultarAgendaActual(IN $idPersona INT)
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
END !


# PROCEDIMIENTO:
CREATE PROCEDURE `SpAsignarMoraPaciente`(IN `$idPaciente` INT)
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
END !


# PROCEDIMIENTO:
CREATE PROCEDURE `spConsultarCitaInner`(IN `$idPaciente` INT)
BEGIN
 SELECT tbl_cita.estadoTablaCita, tbl_cita.fechaCita, tbl_cita.horaInicial, tbl_cup.nombreCUP,tbl_cup.codigoCup,tbl_cita.idCita FROM tbl_cita INNER JOIN tbl_cup ON tbl_cup.idCUP = tbl_cita.idCUP
 WHERE tbl_cita.idPaciente =$idPaciente AND tbl_cita.estadoTablaCita = 'Iniciada';
END !

#PROCEDIMIENTO:

CREATE  PROCEDURE `spModificarPacienteD`(IN `$idPaciente` INT, IN `$numeroDocumento` VARCHAR(45), IN `$fechaNacimiento` DATE, IN `$primerNombre` VARCHAR(45), IN `$segundoNombre` VARCHAR(45), IN `$primerApellido` VARCHAR(45), IN `$segundoApellido` VARCHAR(45), IN `$estadoCivil` VARCHAR(45), IN `$ciudadResidencia` VARCHAR(45), IN `$barrioResidencia` VARCHAR(45), IN `$direccion` VARCHAR(45), IN `$telefonoFijo` VARCHAR(45), IN `$telefonoMovil` VARCHAR(45), IN `$correoElectronico` VARCHAR(45), IN `$empresa` VARCHAR(45), IN `$ocupacion` VARCHAR(45), IN `$profesion` VARCHAR(45), IN `$fechaAfiliacionRegistro` DATE, IN `$idtipoDocumento` INT(11), IN `$idtipoAfiliacion` INT(11), IN `$url` VARCHAR(250))
 BEGIN
    UPDATE `tbl_paciente` SET `numeroDocumento` = $numeroDocumento, `fechaNacimiento` = $fechaNacimiento,  `primerNombre` = $primerNombre, `segundoNombre` = $segundoNombre, `primerApellido` = $primerApellido, `segundoApellido` = $segundoApellido, `estadoCivil` = $estadoCivil, `ciudadResidencia` = $ciudadResidencia, `barrioResidencia` = $barrioResidencia, `direccion` = $direccion, `telefonoFijo` = $telefonoFijo, `telefonoMovil` = $telefonoMovil, `correoElectronico` = $correoElectronico, `empresa` = $empresa, `ocupacion` = $ocupacion, `profesion` = $profesion, `fechaAfiliacionRegistro` = $fechaAfiliacionRegistro,  `idtipoDocumento` = $idtipoDocumento, `idtipoAfiliacion` = $idtipoAfiliacion, `url` = $url WHERE `idPaciente` = $idPaciente;
    END!


#PROCEDIMIENTO:
CREATE PROCEDURE `spHistorialCitas`()
BEGIN
  SELECT ci.idCita,pa.numeroDocumento, CONCAT(pa.primerNombre," ",pa.primerApellido) as NombrePaciente,
  cu.nombreCUP, cu.codigoCup, ci.fechaCita, ci.horaInicial, ci.direccionCita, ci.estadoTablaCita
  FROM tbl_cita ci
  INNER JOIN tbl_paciente pa ON ci.idPaciente =pa.idPaciente
  INNER JOIN tbl_tipodocumento td ON pa.idTipoDocumento = td.idtipoDocumento
  INNER JOIN tbl_cup cu ON ci.idCUP = cu.idCUP;
END !

# PROCEDIMIENTO:
CREATE PROCEDURE `spListarCitaInnerJoin`()
BEGIN
  SELECT *
  FROM `tbl_cita`
  INNER JOIN `tbl_paciente`
  ON `tbl_cita`.`idPaciente` =`tbl_paciente`.`idPaciente`
  INNER JOIN `tbl_tipodocumento`
  ON `tbl_tipodocumento`.`idTipoDocumento` = `tbl_paciente`.`idtipoDocumento`;
END !

# PROCEDIMIENTO:
CREATE PROCEDURE `spListarPacienteInnerJ`()
BEGIN
  SELECT *
  FROM `tbl_paciente`
  INNER JOIN `tbl_tipodocumento`
  ON `tbl_paciente`.`idtipoDocumento` = `tbl_tipodocumento`.`idTipoDocumento`;
END !

# PROCEDIMIENTO:
CREATE PROCEDURE `spListarMedicamentoAmbulancia`(in $idAmbulancia int)
BEGIN
  select dk.idDetalleKit,r.nombre,dk.cantidadAsignada,r.descripcion
  from tbl_detallekit dk
  inner join tbl_recurso r
  on dk.idRecurso=r.idRecurso
  inner join tbl_asignacionkit ak
  on dk.idAsignacion = ak.idAsignacion where ak.idAmbulancia = $idAmbulancia;
END !

# PROCEDIMIENTO:
CREATE PROCEDURE `spConsultarIdAmbulancia`(IN `$idPersona` INT)
BEGIN
  SELECT ap.idAmbulancia
  FROM tbl_detalleasignacion da
  INNER JOIN tbl_asignacionpersonal ap
  ON ap.idAsignacionPersonal = da.idAsignacionPersonal
  WHERE da.idPersona = (SELECT idPersona FROM tbl_cuentausuario WHERE idUsuario = $idPersona) AND da.estadoTabla = "Activo";
END !

# PROCEDIMIENTO:
CREATE PROCEDURE `spListarTipoaseguramiento`()
BEGIN
  SELECT *
  FROM `tbl_tipoaseguramiento`
  WHERE estadoTabla = "Activo";
END !

# PROCEDIMIENTO:
CREATE PROCEDURE `spListarAfectadoaccidentetransito`()
BEGIN
  SELECT *
  FROM `tbl_afectadoaccidentetransito`
  WHERE estadoTabla = "Activo";
END !

# PROCEDIMIENTO:
CREATE PROCEDURE spListarEstandarKit(
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
END !

# PROCEDIMIENTO:
CREATE PROCEDURE spListarRecurso()
BEGIN
  SELECT *
  FROM `tbl_recurso`
  INNER JOIN `tbl_categoriarecurso`
  ON `tbl_categoriarecurso`.`idCategoriaRecurso` = `tbl_recurso`.`idCategoriaRecurso`;
END !

# PROCEDIMIENTO:
CREATE PROCEDURE spValidarDocumentoPersona(IN $numeroDocumento VARCHAR(20))
BEGIN
  SELECT 1
  FROM tbl_persona
  WHERE numeroDocumento = $numeroDocumento;
END !

# PROCEDIMIENTO:
CREATE PROCEDURE `spConsultarModuloVista`(IN `$idRol` INT, IN `$idModulo` INT)
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
END !

# PROCEDIMIENTO:
CREATE PROCEDURE spConsultarModuloRol(IN $idRol INT)
BEGIN
  SELECT DISTINCT m.idModulo, m.descripcionModulo, m.iconoModulo
  FROM tbl_rolModuloVista rmv
  INNER JOIN tbl_modulo m
  ON rmv.idModulo = m.idModulo
  INNER JOIN tbl_rol r
  ON rmv.idRol = r.idRol
  WHERE r.idRol = $idRol;
END !

# PROCEDIMIENTO:
CREATE PROCEDURE spValidarRolModuloVista(IN $idRol INT)
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
END !

# PROCEDIMIENTO:
CREATE PROCEDURE spValidarRol()
BEGIN
  SELECT r.descripcionRol
  FROM tbl_cuentausuario cu
  INNER JOIN tbl_rol r
  ON cu.idRol = r.idRol;
END !

# PROCEDIMIENTO:
CREATE PROCEDURE spValidarUsuario (
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
END !

# PROCEDIMIENTO:
CREATE PROCEDURE spCancelarReporteinicial(IN $descripcion VARCHAR(300), IN $estadoReporte VARCHAR(50), IN $idChat INT)
BEGIN
  INSERT INTO `tbl_reporteinicial`(`informacionInicial`,`estadoTablaReporteInicial`,`idChat`)
  VALUES ($descripcion,$estadoReporte, $idChat);
END !

# PROCEDIMIENTO:
CREATE PROCEDURE `spValidarMedico`(IN `$usuario` VARCHAR(45), IN `$clave` VARCHAR(45))
BEGIN
  SELECT primerNombre, primerApellido, numeroDocumento, urlFoto, urlFirma, tbl_persona.idPersona, idUsuario
  FROM tbl_persona INNER JOIN tbl_cuentausuario ON tbl_cuentausuario.idPersona = tbl_persona.idPersona
  INNER JOIN tbl_rol ON tbl_cuentausuario.idRol = tbl_rol.idRol
  WHERE usuario = $usuario AND clave = $clave
  AND descripcionRol like ('%Medico Externo%');
END !

# PROCEDIMIENTO:
CREATE PROCEDURE `spUltimaPersona`()
BEGIN
  SELECT MAX(idPersona) AS ultima FROM tbl_persona;
END !

# PROCEDIMIENTO:
CREATE PROCEDURE `spConsultarRespuestaNotificacionTemporal`()
BEGIN
select tc.usuario,tt.observacionRespuestaAutorizacion,tt.estadoEvaluacion,tt.cedulaPaciente,tt.fechaEvaluacion
from tbl_temporalautorizacion tt
inner join tbl_cuentausuario tc
on tt.idMedico = tc.idUsuario
inner join tbl_persona tp
on tp.idPersona = tc.idUsuario
order by tt.fechaEvaluacion DESC
limit 1;
END !

# PROCEDIMIENTO:
CREATE PROCEDURE `spConsultarPacienteDocumento`(IN `$numeroDocumento` VARCHAR(45))
BEGIN
  SELECT * FROM  tbl_paciente
  Where numeroDocumento = $numeroDocumento;
END !

# PROCEDIMIENTO:
CREATE PROCEDURE `spConsultarAcompanante`(IN `$identificacionA` INT)
BEGIN
  SELECT *
  FROM `tbl_acompanante`
  WHERE `identificacionA` = $identificacionA;
END !

# PROCEDIMIENTO:
CREATE PROCEDURE `spConsultarAmbulanciaEstado`(IN _idReportaInicial int)
BEGIN
  SELECT * FROM tbl_ambulancia a
  INNER JOIN tbl_despacho d ON a.idAmbulancia = d.idAmbulancia
  WHERE d.idReporteInicial = _idReportaInicial;
END !

# PROCEDIMIENTO:
CREATE PROCEDURE spListarTratamientoB()
BEGIN
  SELECT idTipoTratamiento, Descripcion, categoriaItemTratamiento
  FROM tbl_tipotratamiento
  WHERE categoriaTratamientoAph = "Tratamiento Basico" and estadoTabla = "Activo";
END !

# PROCEDIMIENTO:
CREATE PROCEDURE spListarTratamientoA()
BEGIN
  SELECT idTipoTratamiento, Descripcion, categoriaItemTratamiento
  FROM tbl_tipotratamiento
  WHERE categoriaTratamientoAph = "Tratamiento Avanzado" and estadoTabla = "Activo";
END !

# PROCEDIMIENTO:
CREATE PROCEDURE `spJoinLesionesCie10`(IN `$idPuntoLesion` INT)
BEGIN
  SELECT L.idLesion , L.idPuntoLesion, L.especificacionLesion, C.idCIE10, C.codigoCIE10, C.descripcionCIE10
  FROM `tbl_lesion` AS L
  INNER JOIN `tbl_cie10` AS C
  ON L.`idCIE10` = C.`idCIE10`
  WHERE  L.idPuntoLesion = $idPuntoLesion;
END !

# PROCEDIMIENTO:
CREATE  PROCEDURE `spFiltrarPuntosLesiones`(IN `$idReporteAPH` INT)
BEGIN
  SELECT *
  FROM `tbl_puntolesion`
  WHERE `idReporteAPH` = $idReporteAPH;
END !

# FUNCIÓN:
CREATE FUNCTION `fnRegistrarPuntolesion`(`$posX` VARCHAR(45), `$posY` VARCHAR(45), `$idReporteAPH` INT(11)) RETURNS int(11)
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
END !

# PROCEDIMIENTO:
CREATE PROCEDURE `spUltimoPaciente`()
BEGIN
  SELECT MAX(idPaciente) AS ultimo
  FROM tbl_paciente;
END !

# PROCEDIMIENTO:
CREATE PROCEDURE `spSeleccionarUltimoid`()
BEGIN
  SELECT MAX(idAsignacionPersonal) AS ultimo
  FROM tbl_asignacionpersonal;
END !

# PROCEDIMIENTO:
CREATE PROCEDURE `SpContarNotificacionesDespacho`($idDespacho int)
BEGIN
  SELECT COUNT(idAmbulancia) 'Numero'
  FROM tbl_despacho
  WHERE   idDespacho = $idDespacho;
END !

# PROCEDIMIENTO:
CREATE PROCEDURE `SpDescripcionNotificacionesDespacho`($idDespacho int)
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
END !

# PROCEDIMIENTO:
CREATE PROCEDURE `spModificarPacienteAPH`()
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
END !

# PROCEDIMIENTO:
CREATE PROCEDURE spConsultarTipoevento_reporteinicial(IN idReporteInicial INT)
BEGIN
  SELECT tpe.descripcionTipoEvento
  FROM tbl_tipoevento_reporteinicial ttr
  INNER JOIN tbl_tipoevento tpe
  ON ttr.idTipoEvento = tpe.idTipoEvento
  WHERE ttr.idReporteInicial = idReporteInicial;
END !

# PROCEDIMIENTO:
CREATE PROCEDURE spConsultarEnteexterno_reporteinicial(IN idReporteInicial INT)
BEGIN
  SELECT ext.descripcionEnteExterno
  FROM tbl_enteexterno_reporteinicial tex
  INNER JOIN tbl_enteexterno ext
  ON tex.idEnteExterno = ext.idEnteExterno
  WHERE tex.idReporteInicial = idReporteInicial;
END !

# PROCEDIMIENTO:
CREATE PROCEDURE spRegistrarNovedadreporteinicial(
    IN $idReporteInicial INT,
    IN $descripcionNovedad TEXT,
    IN $numeroLesionadosNovedad INT,
    IN $estadoNovedad VARCHAR(50)
)
BEGIN
  INSERT INTO `tbl_novedadreporteinicial`(`idReporteInicial`, `descripcionNovedad`, `numeroLesionadosNovedad`, `estadoNovedad`)
  VALUES ($idReporteInicial, $descripcionNovedad, $numeroLesionadosNovedad, $estadoNovedad);
END !

# PROCEDIMIENTO:
CREATE PROCEDURE spConsultarNovedadreporteinicial(IN idReporte INT)
BEGIN
  SELECT descripcionNovedad, fechaHoraNovedad
  FROM `tbl_novedadreporteinicial`
  WHERE idReporteInicial = idReporte;
END !

# FUNCIÓN:
CREATE FUNCTION fnUltimoReporteInicial()
RETURNS INT
BEGIN
  DECLARE idReporte INT;
  SET idReporte = (SELECT MAX(idReporteInicial)
                   FROM tbl_reporteinicial);
  RETURN idReporte;
END !

# PROCEDIMIENTO:
CREATE PROCEDURE spListarInfomacionAutorizacion(IN $limite INT, IN $Estado VARCHAR(30))
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
END !

# PROCEDIMIENTO:
CREATE PROCEDURE spListarInformacionAutorizacion(
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
END !

# PROCEDIMIENTO:
CREATE PROCEDURE spListarInformacionAutorizacionPaginador(IN $Estado VARCHAR(30))
BEGIN
  IF $Estado = "Todas" THEN
    SELECT TA.idTemporalAutorizacion
    FROM tbltemporalautorizacion TA;
  ELSE
    SELECT TA.idTemporalAutorizacion
    FROM tbltemporalautorizacion TA
    WHERE TA.estadoEvaluacion = $Estado;
  END IF;
END !

# PROCEDIMIENTO:
CREATE PROCEDURE spListarCIE10Cuerpo()
BEGIN
   SELECT *
   FROM `tbl_cie10`
   WHERE estadoTabla = 'Activo';
END !

# FUNCIÓN:
CREATE FUNCTION `fnCancelarEmergencia`(`$idReporteInicial` INT, `$idDespacho` INT,  `$motivoCancelacion` text) RETURNS int(11)
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
END !


# FUNCIÓN:
CREATE FUNCTION fnPedirAyuda(
    `$idReporteInicial` INT ,
    `$descripcion` text ,
    `$tipoAyuda` INT,
    `$numeroLesionados` INT
    )
RETURNS INT
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
END !


# PROCEDIMIENTO:
CREATE PROCEDURE spConfirmarLlegada($idDespacho INT)
BEGIN
  UPDATE `tbl_despacho`
  SET `estadoDespacho`= 'En emergencia'
  WHERE idDespacho = $idDespacho;
END !


# PROCEDIMIENTO:
CREATE PROCEDURE `spRegistrarNovedadRinicial`(IN $idReporteInicial int(11), IN $descripcionNovedad varchar(45), IN $numeroLesionados int(11))
BEGIN
  IF $numeroLesionados >= 0 THEN
    INSERT INTO `tbl_novedadreporteinicial`(`idReporteInicial`, `descripcionNovedad`, `numeroLesionados`)
    VALUES ($idReporteInicial, $descripcionNovedad, $numeroLesionados);
  ELSE
    INSERT INTO `tbl_novedadreporteinicial`(`idReporteInicial`, `descripcionNovedad`, `numeroLesionados`)
    VALUES ($idReporteInicial, $descripcionNovedad, NULL);
  END IF;
END !


# PROCEDIMIENTO:
CREATE PROCEDURE spRegistrarEnteexterno_reporteinicial(IN $idEnteExterno INT)
BEGIN
  INSERT INTO tbl_enteexterno_reporteinicial (idEnteExterno, idReporteInicial)
  VALUES ($idEnteExterno, fnUltimoReporteInicial());
END !


# PROCEDIMIENTO:
CREATE PROCEDURE spRegistrarTipoevento_reporteinicial(IN $idTipoEvento INT)
BEGIN
  INSERT INTO tbl_tipoevento_reporteinicial (idTipoEvento, idReporteInicial)
  VALUES ($idTipoEvento, fnUltimoReporteInicial());
END !


# PROCEDIMIENTO:
CREATE PROCEDURE spListarTipoevento()
BEGIN
  SELECT *
  FROM tbl_tipoevento
  WHERE estadoTabla = 'Activo';
END !


# PROCEDIMIENTO:
CREATE PROCEDURE spListarEnteexterno()
BEGIN
  SELECT *
  FROM tbl_enteexterno
  WHERE estadoTabla = 'Activo';
END !


# PROCEDIMIENTO:
CREATE  PROCEDURE `spModificarAcompanante`(IN `$idAcompanante` INT,
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
END !


# PROCEDIMIENTO:
CREATE PROCEDURE `spConsultarPacienteAcompanante`(IN `$idPa` INT)
BEGIN
  SELECT *
  FROM `tbl_acompanante` a
  INNER JOIN tbl_paciente p
  ON p.idPaciente = a.idPaciente
  Where p.idPaciente = $idPa;
END !


# PROCEDIMIENTO:
CREATE PROCEDURE spListarAmbulanciaDisponible()
BEGIN
  SELECT * FROM tbl_ambulancia as am
  where am.estadoTabla like 'Activo';
END !


# PROCEDIMIENTO:
CREATE PROCEDURE spListarPersonalAmbulancia()
BEGIN
  SELECT tblp.idPersona, tblp.primerNombre, tblp.primerApellido, tblr.descripcionRol
  FROM tbl_persona tblp
  INNER JOIN tbl_cuentausuario tblcu
  ON tblp.idPersona = tblcu.idPersona
  INNER JOIN tbl_rol tblr
  ON tblcu.idRol = tblr.idRol
  WHERE (tblp.dependencia = 'APH' AND tblp.estadoTablaPersona = 'Asignado ambulancia') AND (LOWER(tblr.descripcionRol) = LOWER('Médico') OR LOWER(tblr.descripcionRol) = LOWER('Medico') OR LOWER(tblr.descripcionRol) = LOWER('Paramédico') OR LOWER(tblr.descripcionRol) = LOWER('Paramedico'));
END !


# PROCEDIMIENTO:
CREATE PROCEDURE spConsultaPersonaPro(iN $idTurnoProgram INT)
BEGIN
  SELECT tbl_persona.primerNombre,tbl_persona.segundoNombre,tbl_persona.primerApellido,tbl_persona.segundoApellido
  FROM tbl_turnoprogramacion
  INNER JOIN tbl_persona
  ON tbl_turnoprogramacion.idPersona = tbl_persona.idPersona
  WHERE tbl_turnoprogramacion.idTurnoProgramacion = $idTurnoProgram;
END !


# PROCEDIMIENTO:
CREATE PROCEDURE spPagination(
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
END !

# PROCEDIMIENTO:
CREATE PROCEDURE `spFilterPagination`(IN `$filter` VARCHAR(100), IN `$numData` INT)
BEGIN
  DECLARE _i INT DEFAULT 1;
  while _i <= $numData do
      INSERT INTO tbl_filtro VALUES( SPLIT_STRING($filter, ',', _i) );
      SET _i = _i + 1;
  END while;
END !

# FUNCIÓN:
CREATE FUNCTION `SPLIT_STRING`(`s` VARCHAR(1024), `del` CHAR(1), `i` INT)
RETURNS varchar(1024) CHARSET utf8 DETERMINISTIC
BEGIN
  DECLARE n INT;
  SET n = LENGTH(s) - LENGTH(REPLACE(s, del, '')) + 1;
  IF i > n THEN
    RETURN NULL;
  ELSE
    RETURN SUBSTRING_INDEX(SUBSTRING_INDEX(s, del, i) , del , -1);
  END IF;
END !

# PROCEDIMIENTO:
CREATE PROCEDURE `SpConsultarGeolocalizacion`(`$idDespacho` int)
BEGIN
  SELECT longitudEmergencia,latitudEmergencia,asig.longitud longitudAmbulancia,asig.latitud latitudAmbulancia
  FROM tbl_despacho desp
  INNER JOIN tbl_asignacionpersonal asig
  ON desp.idAmbulancia = asig.idAmbulancia
  WHERE desp.idDespacho = `$idDespacho` AND LOWER(asig.estadoTablaAsignacion) = LOWER("activo");
END !

# PROCEDIMIENTO:
CREATE PROCEDURE SpConsultarDespachoAPH($idDespacho int)
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
END !

# PROCEDIMIENTO:
CREATE PROCEDURE SpConsultarReporteInicialAPH($idReporteI int)
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
END !

# PROCEDIMIENTO:
CREATE PROCEDURE spTraerProximoIdReporteAPH($nombreTabla VARCHAR(45))
BEGIN
  SELECT AUTO_INCREMENT proximoId
  FROM information_schema.TABLES
  WHERE TABLE_SCHEMA = 'bd_proyecto_salud' AND TABLE_NAME=$nombreTabla;
END !

# PROCEDIMIENTO:
CREATE PROCEDURE spEliminarTipoEventoConfirmacion($idReporteInicial INT)
BEGIN
  DELETE FROM `tbl_tipoevento_reporteinicial`
  WHERE idReporteInicial = $idReporteInicial;
END !

# PROCEDIMIENTO:
CREATE PROCEDURE spUltimoIDmotivoConsulta()
BEGIN
  SELECT MAX(idMotivoConsulta)ultimoRegistro
  FROM tbl_motivoconsulta;
END !

# PROCEDIMIENTO:
CREATE PROCEDURE spRegistrarMotivoconsulta($descripcionMotivoConsulta VARCHAR(45), $TipoMotivoConsulta VARCHAR(45))
BEGIN
  INSERT INTO `tbl_motivoconsulta`(`descripcionMotivoConsulta`, `TipoMotivoConsulta`)
  VALUES ($descripcionMotivoConsulta, $TipoMotivoConsulta);
  SELECT MAX(idMotivoConsulta) AS ultimo
  FROM tbl_motivoconsulta;
END !

# PROCEDIMIENTO:
CREATE PROCEDURE spListarMotivoconsulta()
BEGIN
  SELECT *
  FROM `tbl_motivoconsulta`
  WHERE LOWER(TipoMotivoConsulta) <> LOWER("otro");
END !

# PROCEDIMIENTO:
CREATE PROCEDURE spRegistrarExamenfisicoaph(
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
END !

# PROCEDIMIENTO:
CREATE PROCEDURE spRegistrarReporteaph(IN $idExamenFisico int(11), IN $idDespacho int(11), IN $idAsignacionPersonal int(11), IN $idPersonalRecibe int(11), IN $idTriage int(11), IN $idTipoAseguramiento int(11), IN $idCertificadoAtencion int(11), IN $fechaHoraFinalizacion datetime, IN $fechaHoraArriboEscena datetime, IN $fechaHoraArriboIPS datetime, IN $ultimaIngesta datetime, IN $idAfectadoAccidenteTransito int(11), IN $placaVehiculo varchar(45), IN $codigoAseguradora varchar(45), IN $numeroPoliza varchar(45), IN $descripcionTratamiento text, IN $descripcionTratamientoAvanzado text, IN $evaluacionResultado varchar(45), IN $institucionReceptora varchar(45), IN $situacionEntrega varchar(45), IN $presionArterialEntrega varchar(45), IN $pulsoEntrega varchar(45), IN $respiracionEntrega varchar(45), IN $estadoTablaReporteAPH varchar(50), IN $complicaciones text, IN $idPaciente int(11),IN $idAcompanante int(11), IN $TAPHPresente BOOLEAN, IN $TPAPHPresente BOOLEAN, IN $otroPersonalControlM BOOLEAN, IN $nombreOtroPersonalControlM varchar(45), IN $protocolo bit(1), IN $idParamedicoAtiende INT)
BEGIN
INSERT INTO `tbl_reporteaph`(`idExamenFisico`, `idDespacho`, `idAsignacionPersonal`, `idPersonalRecibe`, `idParamedicoAtiende`,  `idTriage`, `idTipoAseguramiento`, `idCertificadoAtencion`, `fechaHoraFinalizacion`, `fechaHoraArriboEscena`, `fechaHoraArriboIPS`, `ultimaIngesta`, `idAfectadoAccidenteTransito`, `placaVehiculo`, `codigoAseguradora`, `numeroPoliza`, `descripcionTratamiento`, `descripcionTratamientoAvanzado`, `evaluacionResultado`, `institucionReceptora`, `situacionEntrega`, `presionArterialEntrega`, `pulsoEntrega`, `respiracionEntrega`, `estadoTablaReporteAPH`, `complicaciones`, `idPaciente`,`idAcompanante`, `TAPHPresente`,`TPAPHPresente`, `otroPersonalControlM`, `nombreOtroPersonalControlM`, `protocolo`) VALUES ($idExamenFisico, $idDespacho, $idAsignacionPersonal, $idPersonalRecibe, $idParamedicoAtiende, $idTriage, $idTipoAseguramiento, $idCertificadoAtencion, $fechaHoraFinalizacion, $fechaHoraArriboEscena, $fechaHoraArriboIPS, $ultimaIngesta, $idAfectadoAccidenteTransito, $placaVehiculo, $codigoAseguradora, $numeroPoliza, $descripcionTratamiento, $descripcionTratamientoAvanzado, $evaluacionResultado, $institucionReceptora, $situacionEntrega, $presionArterialEntrega, $pulsoEntrega, $respiracionEntrega, $estadoTablaReporteAPH, $complicaciones, $idPaciente,$idAcompanante, $TAPHPresente,$TPAPHPresente, $otroPersonalControlM, $nombreOtroPersonalControlM, $protocolo);
SELECT MAX(idReporteAPH) ultimoReporte FROM tbl_reporteaph;
UPDATE tbl_despacho SET estadoDespacho = 'Finalizado' WHERE idDespacho = $idDespacho;
END !


# PROCEDIMIENTO:
CREATE PROCEDURE spListarTipodocumento()
BEGIN
  SELECT tbl_tipodocumento.idTipoDocumento, tbl_tipodocumento.descripcionTdocumento
  FROM tbl_tipodocumento
  WHERE estadoTabla LIKE 'Activo';
END !

# PROCEDIMIENTO:
CREATE PROCEDURE spListarZona()
BEGIN
  SELECT idTipoZona, descripcionTipozona
  FROM `tbl_tipozona`
  WHERE estadoTabla LIKE 'Activo';
END !

# PROCEDIMIENTO:
CREATE PROCEDURE spListarTipozona()
BEGIN
  SELECT tbl_tipozona.idTipoZona, tbl_tipozona.descripcionTipozona
  FROM `tbl_tipozona`
  WHERE estadoTabla LIKE 'Activo';
END !

# PROCEDIMIENTO:
CREATE PROCEDURE spConsultarZona (IN $idTipoZ INT)
BEGIN
  SELECT idZona, descripcionZona
  FROM tbl_zona
  WHERE idTipoZona = $idTipoZ AND estadoTabla LIKE 'Activo';
END !

# PROCEDIMIENTO:
CREATE PROCEDURE spConfirmacionDatos(IN $numDoc varchar(45), IN $fechaNac date, IN $idTipoD INT(11))
BEGIN
  SELECT idPaciente, tbl_estadopaciente.descripcionEstadoPaciente, primerNombre, segundoNombre, primerApellido, segundoApellido, ciudadResidencia, barrioResidencia, direccion, correoElectronico, telefonoFijo, telefonoMovil
  FROM `tbl_paciente`
  INNER JOIN tbl_estadopaciente
  ON tbl_paciente.idEstadoPaciente = tbl_estadopaciente.idEstadoPaciente
  WHERE (numeroDocumento = `$numDoc` AND fechaNacimiento = `$fechaNac`) AND (idtipoDocumento = `$idTipoD` AND tbl_estadopaciente.estadoTabla LIKE 'Activo');
END !

# PROCEDIMIENTO:
CREATE  PROCEDURE spRegistrarCita(
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
END!


#PROCEDIMIENTO:
CREATE PROCEDURE `spCitasAsignadas`(IN `$idPaciente` INT(11))
BEGIN
  SELECT COUNT(c.estadoTablaCita) as 'Citas_Asignadas', p.idEstadoPaciente FROM tbl_cita c inner join tbl_paciente p on p.idPaciente = c.idPaciente WHERE c.idPaciente=$idPaciente AND c.estadoTablaCita='Iniciada';
END !


#PROCEDIMIENTO:
CREATE PROCEDURE spFinalizacionMulta()
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
END !

# PROCEDIMIENTO:
CREATE PROCEDURE spConsultaIdProgram (IN $FechaCapt DATE, iN $Hora TIME)
BEGIN
  SELECT idTurnoProgramacion
  FROM tbl_turnoprogramacion
  INNER JOIN tbl_turno ON tbl_turnoprogramacion.idTurnoProgramacion = tbl_turno.idTurno
  INNER JOIN tbl_programacion ON tbl_turnoprogramacion.idTurnoProgramacion = tbl_programacion.idProgramacion
  WHERE ($Hora BETWEEN tbl_turno.horaInicioTurno AND tbl_turno.horaFinalTurno)  AND ($FechaCapt BETWEEN tbl_programacion.Fecha_inicial  AND tbl_programacion.Fecha_final) AND (tbl_turnoprogramacion.estadoTablaProgramacion LIKE 'Activo');
END !

# PROCEDIMIENTO:
CREATE PROCEDURE spConsultaIdCita()
BEGIN
  SELECT MAX(tbl_cita.idCita) AS 'idUltimo'
  FROM tbl_cita;
END !

# PROCEDIMIENTO:
CREATE PROCEDURE spRegistrarDetalleCita(IN $idCita INT, IN $idProgramacion INT)
BEGIN
  INSERT INTO tbl_cita_programacion (idCita, idTurnoProgramacion)
  VALUES ($idCita, $idProgramacion);
END !

# PROCEDIMIENTO:
CREATE  PROCEDURE `spConsultaMedicosEspecial`(
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
END!


# PROCEDIMIENTO:
CREATE PROCEDURE `spConsultaNombresMedic`(
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
END!


# PROCEDIMIENTO:
CREATE  PROCEDURE `spConsultaNombresEnfermerosJefe`(
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
END!


#PROCEDIMIENTO:
CREATE PROCEDURE `spModificarCupConfiguracion` (IN `$idConfiguracion` INT, IN `$idCup` INT)
BEGIN
  UPDATE `tbl_cup` SET `idConfiguracion` = $idConfiguracion,
   tbl_cup.idTipoCup=(SELECT tbl_tipocup.idTipoCup FROM tbl_tipocup
  WHERE tbl_tipocup.descripcionCUP LIKE 'Citas') WHERE`idCUP` = $idCup;
END !


#PROCEDIMIENTO:
CREATE PROCEDURE spConsultarEspecialidadPersona (IN _idPersona int)
BEGIN
  SELECT tblr.descripcionRol
  from tbl_persona AS tblp
  INNER JOIN tbl_cuentausuario AS tblcu
  ON tblp.idPersona = tblcu.idPersona
  INNER JOIN tbl_rol AS tblr
  ON tblcu.idRol = tblr.idRol
  WHERE tblp.idPersona = _idPersona;
END !

# PROCEDIMIENTO:
CREATE  PROCEDURE `spConsultaNombresAuxEnfermeria`(
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
END!


# PROCEDIMIENTO:

CREATE  PROCEDURE `spConsultaCitasMes`(IN $idPaciente INT(11), IN $primerDiaM DATE, IN $ultimoDiaM DATE, IN $fechaActual DATE)
BEGIN
  SELECT COUNT(tbl_cita.idCita) AS "Cantidad_Citas_Mes"
  FROM tbl_cita
  WHERE tbl_cita.idPaciente=$idPaciente
AND ($fechaActual BETWEEN $primerDiaM AND $ultimoDiaM);
END!


# PROCEDIMIENTO:

CREATE  PROCEDURE `spConsultaCitasDia`(IN $idPaciente INT(11), IN $fechaActual DATE)
BEGIN
SELECT
COUNT(tbl_cita.idCita) AS "Cantidad_Citas_Dia"
FROM
tbl_cita
WHERE
tbl_cita.idPaciente = $idPaciente
AND tbl_cita.fechaRegistro = $fechaActual;
END!


# PROCEDIMIENTO:
CREATE PROCEDURE spConsultaConfiguracionCita()
BEGIN
  SELECT tbl_configuracion.cantidadCitasDia, tbl_configuracion.cantidadCitasMes,
  tbl_configuracion.descripcionConfiguracion, tbl_configuracion.fechaConfiguracion
  FROM tbl_configuracion
  WHERE tbl_configuracion.estadoTabla LIKE 'Activo';
END !

CREATE OR REPLACE VIEW ViewDatosBasicosReporteAPH AS
    SELECT
        A.idReporteAPH,
        CONCAT(IFNULL(B.primerNombre, ''),
                ' ',
                IFNULL(B.segundoNombre, ''),
                ' ',
                IFNULL(B.primerApellido, ''),
                ' ',
                IFNULL(B.segundoApellido, '')) nombreCompleto,
        B.numeroDocumento,
        B.genero,
        B.telefonoFijo,
        B.edadPaciente,
        D.informacionInicial,
        A.fechaHoraFinalizacion,
        C.idAmbulancia,
        C.fechaHoraDespacho,
        A.idAsignacionPersonal
    FROM
        tbl_reporteaph A
            INNER JOIN
        tbl_paciente B ON A.idPaciente = B.idPaciente
            INNER JOIN
        tbl_despacho C ON A.idDespacho = C.idDespacho
            INNER JOIN
        tbl_reporteinicial D ON C.idReporteInicial = D.idReporteInicial
    ORDER BY A.idReporteAPH!


# PROCEDIMIENTO:
CREATE PROCEDURE spPersonalReporteAPH($idAsignacionPersonal INT)
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
END !

# PROCEDIMIENTO:
CREATE PROCEDURE `spConsultarReporteAPH`( `$idReporteAph` INT)
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
END !

  # PROCEDIMIENTO:
CREATE PROCEDURE spConsultarTratamientosAPH(
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
END !

# PROCEDIMIENTO:
CREATE PROCEDURE spConsultarDesfibrilacionAPH(
  $idReporteAph INT
)
BEGIN
SELECT DES.horaDesfibrilacion, DES.joules FROM tbl_desfibrilacion DES
INNER JOIN tbl_reporteaph RA
ON RA.idReporteAPH = DES.idReporteAPH
WHERE RA.idReporteAPH = $idReporteAph;
END !

# PROCEDIMIENTO:
CREATE PROCEDURE spConsultarAntecedentesAPH(
  $idReporteAph INT
)
BEGIN
SELECT TAC.idTipoAntecedente, TAC.descripcion, IFNULL(ACA.especificacion, '') AS especificacion FROM tbl_antecedenteaph ACA
INNER JOIN tbl_reporteaph RA
ON RA.idReporteAPH = ACA.idReporteAPH
INNER JOIN tbl_tipoantecedente TAC
ON ACA.idTipoAntecendente = TAC.idTipoAntecedente
WHERE RA.idReporteAPH = $idReporteAph;
END !

# PROCEDIMIENTO:
CREATE PROCEDURE spConsultarMotivoConsultaAPH(
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
END !

# PROCEDIMIENTO:
CREATE PROCEDURE spConsultarTestigoAPH(
  $idReporteAph INT
)
BEGIN
SELECT TES.nombreTestigo, TES.identificacionTestigo FROM tbl_testigo TES
INNER JOIN tbl_reporteaph RA
ON RA.idReporteAPH = TES.idReporteAPH
WHERE RA.idReporteAPH = $idReporteAph;
END !

# PROCEDIMIENTO:
CREATE PROCEDURE spConsultarMedicamentosAPH(
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
END !

# PROCEDIMIENTO:
CREATE PROCEDURE spConsultarViaComunicacionAPH(
  $idReporteAph INT
)
BEGIN
SELECT VC.idViaComunicacionControlMedico, VC.viaComunicacion
FROM tbl_viacomunicacioncontrolmedico VC
INNER JOIN tbl_reporteaph RA
ON RA.idReporteAPH = VC.idReporteAPH
WHERE RA.idReporteAPH = $idReporteAph;
END !

CREATE OR REPLACE VIEW viewtemporalautorizacion AS
    (SELECT
        TA.*,
        CONCAT(IFNULL(P.primerNombre, ''),
                ' ',
                IFNULL(P.segundoNombre, ''),
                ' ',
                IFNULL(P.primerApellido, ''),
                ' ',
                IFNULL(P.segundoApellido, '')) AS 'nombreCompleto',
        P.correoElectronico,
        P.urlFoto,
        P.numeroDocumento,
        T.Descripcion
    FROM
        tbl_temporalautorizacion TA
            INNER JOIN
        tbl_cuentausuario C ON TA.idParamedico = C.idUsuario
            INNER JOIN
        tbl_persona P ON C.idPersona = P.idPersona
            INNER JOIN
        tbl_tipotratamiento T ON TA.idTipoTratamiento = T.idTipoTratamiento
    ORDER BY TA.idTemporalAutorizacion DESC)!

# PROCEDIMIENTO:
CREATE PROCEDURE spConsultarAutorizacionTemporal(
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
END !

# PROCEDIMIENTO:
CREATE PROCEDURE spRegistrarEvaluacionAutorizacion(
  $idAutorizacion INT,
  $idMedicoAutoriza INT,
  $descripcionEvaluacion TEXT,
  $respuestaEvaluacion VARCHAR(45),
  $fechaEvaluacion DATETIME
)
BEGIN
  UPDATE tbl_temporalautorizacion TA SET TA.observacionRespuestaAutorizacion = $descripcionEvaluacion, TA.estadoEvaluacion = $respuestaEvaluacion, TA.idMedico = $idMedicoAutoriza, TA.fechaEvaluacion = $fechaEvaluacion
  WHERE TA.idTemporalAutorizacion = $idAutorizacion;
END !

# PROCEDIMIENTO:
CREATE PROCEDURE `spConsultaridEspecialidad`(IN `$idPersona` INT)
BEGIN
  SELECT idEspecialidad FROM tbl_personaespecialidad WHERE idPersona = $idPersona;
END !

# PROCEDIMIENTO:
CREATE PROCEDURE spActualizarEstadoPersona(IN _idPersona int)
BEGIN
  UPDATE tbl_persona set estadoTablaPersona = 'Asignado ambulancia' where idPersona = _idPersona;
END !

CREATE OR REPLACE VIEW ViewDatosBasicosPacientes AS
SELECT A.idPaciente, A.numeroDocumento, A.fechaNacimiento,
 CONCAT(IFNULL(A.primerNombre,''),
 ' ',
 IFNULL(A.segundoNombre,''),
 ' ',
  IFNULL(A.primerApellido,''),
  ' ',
   IFNULL(A.segundoApellido,'')) AS NombreCompleto,
    A.ciudadResidencia, A.telefonoFijo,A.fechaAfiliacionRegistro, A.url,B.descripcionTdocumento, A.idEstadoPaciente
 FROM tbl_paciente A
  INNER JOIN tbl_tipodocumento B
  ON A.idtipoDocumento = B.idTipoDocumento!

# PROCEDIMIENTO:
CREATE  PROCEDURE `spModificarPacienteCita`(
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
END !

CREATE PROCEDURE `spListarRecursoKit`()
BEGIN
  SELECT recursoKit, stockminKit FROM `tbl_estandarkit`;
END !

CREATE PROCEDURE `spListarCantidadRecurso`(IN `$idRecursoKit` INT(11) )
BEGIN
select stockminKit from tbl_estandarkit
where
  idEstandarKit = $idRecursoKit;
END !

CREATE PROCEDURE `spListarTipoorigenatencion`()
BEGIN
  SELECT * FROM `tbl_tipoorigenatencion` where estadoTabla = 'Activo';
END !

CREATE PROCEDURE `spListarTipotratamiento`()
BEGIN
  SELECT * FROM `tbl_tipotratamiento` where estadoTabla = 'Activo';
END !


CREATE PROCEDURE `spListarTipoexamenespecializado`()
BEGIN
    SELECT * FROM `tbl_tipoexamenespecializado` where estadoTabla = 'Activo';
END !


CREATE PROCEDURE `spConsultarAtencionOrigenDmc`(in $idAtencion INT)
BEGIN
  select motivoAtencion,enfermedadActual,descripcionorigenAtencion,evolucion,idHistoriaClinica
  from tbl_historiaclinica as ht
  inner join tbl_tipoorigenatencion as tip on  ht.idTipoOrigenAtencion=tip.idTipoOrigenAtencion
  where ht.idHistoriaClinica=$idAtencion;
END !


#PROCEDIMIENTO:
CREATE PROCEDURE spConsultarHistoriaClinic()
BEGIN
  select  distinct his.idPaciente,primerNombre,ifnull(segundoNombre,'') as 'segundoNombre',
              primerApellido,ifnull(segundoApellido,'Ningun registro') as 'segundoApellido',descripcionTdocumento,numeroDocumento
              from tbl_historiaclinica as his
              inner join tbl_paciente as pac
              on his.idPaciente=pac.idPaciente
              inner join tbl_tipodocumento as doc
              on pac.idtipoDocumento=doc.idtipoDocumento;
END !

#PROCEDIMIENTO:
CREATE PROCEDURE spConsultarAtencionDmc(in idPaciente int)
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
END !

#PROCEDIMIENTO:
CREATE PROCEDURE spConsultarProcedimientosDmc(in $idHistoriaClinica int)
BEGIN
  select nombreCUP,codigoCup,descripcionProcedimiento,idHistoriaClinica
              from tbl_cup as cup
              inner join tbl_procedimiento as pro
              on cup.idCUP=pro.idCUP
              where idHistoriaClinica=$idHistoriaClinica;
END !


#PROCEDIMIENTO:
CREATE PROCEDURE `spConsultarAntecedentesDmc`(in $idAtencion INT)
BEGIN
  SELECT tbl_tipo.descripcion,tbl_ant.idHistoriaClinica,tbl_ant.descripcionAntecedente
  from tbl_antecedentedmc as tbl_ant
  inner join tbl_tipoantecedente as tbl_tipo
  on tbl_ant.idTipoAntecedente=tbl_tipo.idTipoAntecedente
  where tbl_ant.idHistoriaClinica=$idAtencion
  order by tbl_ant.descripcionAntecedente desc;
END !


#PROCEDIMIENTO:
CREATE PROCEDURE `spConsultarExamenesfisicoDmc`(in $idAtencion INT)
BEGIN
  select estadoTablaExamen,descripcionExamen,descripcionExamenFisico,idHistoriaClinica
  from tbl_examenfisicodmc as exm
  inner join tbl_tipoexamenfisico as tipe
  on exm.idtipoExamenFisico=tipe.idtipoExamenFisico
  where idHistoriaClinica=$idAtencion;
END !


#PROCEDIMIENTO:
CREATE PROCEDURE `spConsultarDiagnosticoDmc`(in $idAtencion INT)
BEGIN
  select descripcionDiagnostico,evolucion,codigoCIE10,descripcionCIE10,his.idHistoriaClinica
  from tbl_diagnostico as diag
  inner join tbl_historiaclinica as his
  on diag.idHistoriaClinica=his.idHistoriaClinica
  inner join tbl_cie10 as cie
  on diag.idCIE10=cie.idCIE10
  where diag.idHistoriaClinica=$idAtencion;
END !


#PROCEDIMIENTO:
CREATE PROCEDURE spConsultarIdPacienteDmc(in $idPaciente int)
BEGIN
  select idPaciente
  from tbl_paciente
    where idPaciente=$idPaciente;
END !

#PROCEDIMIENTO:
CREATE PROCEDURE spConsultarIdHistoriaClinicaDmc(in $idHistoriaClinica int)
BEGIN
  select idHistoriaClinica
  from tbl_historiaclinica
  where idHistoriaClinica=$idHistoriaClinica;
END !

#PROCEDIMIENTO:
CREATE PROCEDURE `spRegistrarTemporalautorizacion`(
IN $idParamedico INT,
IN $idReporte INT,
IN $idTipoTratamiento INT,
IN $descripcionAutorizacion TEXT,
IN $cedulaPaciente VARCHAR(200),
IN $estadoEvaluacion VARCHAR(200),
IN $fechaEnvio DATETIME)
BEGIN
  INSERT INTO `tbl_temporalautorizacion`(`idParamedico`, `idReporte`, `idTipoTratamiento`, `descripcionAutorizacion`, `cedulaPaciente`, `estadoEvaluacion`, `fechaEnvio`) VALUES ($idParamedico,$idReporte,$idTipoTratamiento,$descripcionAutorizacion,$cedulaPaciente,$estadoEvaluacion,$fechaEnvio);
END !

# PROCEDIMIENTO:
CREATE PROCEDURE `SpActualizarEstadoTemporal`(
  IN `$cedula` VARCHAR(200),
  IN `$fechaEnvio` DATETIME
 )
BEGIN
  UPDATE `tbl_temporalautorizacion` SET `estadoEvaluacion` = 'Cancelado' WHERE `fechaEnvio` = $fechaEnvio AND `cedulaPaciente` = $cedula;
END !

CREATE OR REPLACE VIEW ViewCie10APH AS
    SELECT
        *
    FROM
        `tbl_cie10`
    WHERE
        `codigoCIE10` LIKE 'S%'
            OR `codigoCIE10` LIKE 'T%'!

# PROCEDIMIENTO:
CREATE PROCEDURE `spUltimoAcompanante`()
BEGIN
  SELECT MAX(idAcompanante) as ultimoA from tbl_acompanante;
END !

CREATE PROCEDURE spConsultarDatosNotificacion($idPersona INT)
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
END !

CREATE OR REPLACE VIEW `viewconsultaratencion` AS
    SELECT
        `hist`.`idPaciente` AS `idPaciente`,
        `hist`.`idHistoriaClinica` AS `idHistoriaClinica`,
        `hist`.`fechaAtencion` AS `fechaAtencion`,
        `cit`.`horaInicial` AS `horaInicial`,
        `cit`.`telefonoFijo1` AS `telefonoFijo1`,
        `per`.`primerNombre` AS `primerNombre`,
        `per`.`primerApellido` AS `primerApellido`,
        `per`.`numeroDocumento` AS `numeroDocumento`,
        `per`.`direccion` AS `direccion`
    FROM
        ((((`tbl_cita` `cit`
        JOIN `tbl_cita_programacion` `ctp` ON ((`cit`.`idCita` = `ctp`.`idCita`)))
        JOIN `tbl_historiaclinica` `hist` ON ((`ctp`.`idCitaprogramacion` = `hist`.`idCitaprogramacion`)))
        JOIN `tbl_turnoprogramacion` `turn` ON ((`ctp`.`idTurnoProgramacion` = `turn`.`idTurnoProgramacion`)))
        JOIN `tbl_persona` `per` ON ((`per`.`idPersona` = `turn`.`idPersona`)))
    WHERE
        (`cit`.`estadoTablaCita` = 'Terminada')!




CREATE OR REPLACE VIEW `viewconsultarcitamedico` AS
    SELECT
        `c`.`idCita` AS `idCita`,
        `pe`.`idPersona` AS `idPersona`,
        `c`.`estadoTablaCita` AS `estadoTablaCita`,
        `pa`.`idPaciente` AS `idPaciente`,
        `pa`.`primerNombre` AS `primerNombre`,
        `pa`.`primerApellido` AS `primerApellido`,
        `pa`.`numeroDocumento` AS `numeroDocumento`,
        `c`.`horaInicial` AS `horaInicial`,
        `c`.`horaFinal` AS `horaFinal`,
        `c`.`direccionCita` AS `direccionCita`,
        `cu`.`nombreCUP` AS `nombreCUP`,
        `cp`.`idCitaprogramacion` AS `idCitaProgramacion`,
        `pa`.`barrioResidencia` AS `barrioResidencia`,
        `z`.`descripcionZona` AS `descripcionZona`,
        `c`.`telefonoFijo1` AS `telefonoFijo1`
    FROM
        ((((((((`tbl_cita` `c`
        JOIN `tbl_paciente` `pa` ON ((`pa`.`idPaciente` = `c`.`idPaciente`)))
        JOIN `tbl_cita_programacion` `cp` ON ((`c`.`idCita` = `cp`.`idCita`)))
        JOIN `tbl_turnoprogramacion` `tp` ON ((`cp`.`idTurnoProgramacion` = `tp`.`idTurnoProgramacion`)))
        JOIN `tbl_persona` `pe` ON ((`pe`.`idPersona` = `tp`.`idPersona`)))
        JOIN `tbl_programacion` `p` ON ((`p`.`idProgramacion` = `tp`.`idProgramacion`)))
        JOIN `tbl_turno` `t` ON ((`t`.`idTurno` = `tp`.`idTurno`)))
        JOIN `tbl_cup` `cu` ON ((`cu`.`idCUP` = `c`.`idCUP`)))
        JOIN `tbl_zona` `z` ON ((`z`.`idZona` = `c`.`idZona`)))!



#procedimiento paginar HC
CREATE PROCEDURE `spPaginacionHC`(
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
END!


# INNER JOIN DE PACIENTE
CREATE PROCEDURE `spConsultarPaciente`(IN $idPaciente INT)
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
    END!


#SP Cambiar estado cita
CREATE PROCEDURE `spCambiarEstadoCita`( IN $idCita INT(11))
begin
  update tbl_cita set estadoTablaCita='Terminada' where idCita = $idCita;
end !


#SP Cambiar estado cita
CREATE  PROCEDURE `spCambiarEstadoCitaProceso`(IN `$idCita` INT)
BEGIN
  UPDATE tbl_cita SET estadoTablaCita='Proceso' WHERE idCita=$idCita;
END !


#SPConsultar cita persona
CREATE PROCEDURE spConsultarCitaPersona(in _idCita int)
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
END !


#sp registrar historial mora
CREATE PROCEDURE `spRegistrarHistorialmora`(
  IN $fechaHistorial date, IN $descripcionHistorial varchar(45), IN $idCita int(11)
)
BEGIN
   INSERT INTO `tbl_historialmora`(`fechaHistorial`, `descripcionHistorial`, `idCita`, `idMulta`) VALUES ($fechaHistorial, $descripcionHistorial, $idCita, (SELECT MAX(`idMulta`) FROM `tbl_multa` WHERE `estadoTabla` = 'Activo'));
END !



#sp validar correo
CREATE PROCEDURE `spValidarCorreoElectronico`(IN `$email` VARCHAR(100))
BEGIN
  SELECT P.correoElectronico, cU.idUsuario
  FROM tbl_persona P
  INNER JOIN tbl_cuentausuario cU
  ON P.idPersona = CU.idPersona
  WHERE P.correoElectronico = $email
  LIMIT 1;
END !


#sp Reestablecer clave
CREATE PROCEDURE `spRegistrarCodigoReestablecer`(
    IN $email varchar(50), IN $codigo varchar(50), IN $idUsuario int(11)
)
BEGIN
  INSERT INTO `tbl_restablecer`(`email`, `codigo`, `idUsuario`,estado) VALUES ($email, $codigo, $idUsuario,'Activo');
END !


CREATE PROCEDURE `spRegistrarCup3`(IN `nombreCUP` VARCHAR(1000), IN `idConfiguracion` INT, IN `idTipoCup` INT)
BEGIN
 INSERT INTO `tbl_cup`(`nombreCUP`, `idConfiguracion`, `idTipoCup`) VALUES ($nombreCUP, $idConfiguracion, $idTipoCup);
END !


CREATE  PROCEDURE `spCambiarEstadoPaciente`(IN `$idPaciente` INT, IN `$idEstadoPaciente` INT)
BEGIN
  UPDATE `tbl_paciente` SET `idEstadoPaciente` = $idEstadoPaciente
  WHERE `tbl_paciente`.`idPaciente` = $idPaciente;
END!


#PROCEDIMIENTO:

CREATE  PROCEDURE `spListarConfiguracionCup`()
BEGIN
 SELECT * FROM `tbl_configuracion`
  where estadoTabla = 'Activo' ;
   END!


#PROCEDIMIENTO
CREATE PROCEDURE `spEstadoPaciCIta`(IN `$idPaciente` INT)
BEGIN
  UPDATE tbl_paciente SET idEstadoPaciente = (SELECT idEstadoPaciente FROM tbl_estadopaciente WHERE descripcionEstadoPaciente LIKE '%Mora%') WHERE idPaciente = $idPaciente;
END !


CREATE PROCEDURE `spConsultarHorario`(IN $FechaCapt DATE)
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
END!




#############################
CREATE  PROCEDURE `spConsultaMedicos`(
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
END!







###################################################################
CREATE  PROCEDURE `spConsultaEnfermerosJefe`(
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
END!


#PROCEDIMIENTO:
CREATE  PROCEDURE `spConfiguracionAsignada`(IN $idCup INT)
BEGIN
SELECT tbl_configuracion.cantidadCitasDia,tbl_configuracion.cantidadCitasMes
FROM tbl_cup
INNER JOIN tbl_configuracion
ON tbl_cup.idConfiguracion=tbl_configuracion.idConfiguracion
WHERE tbl_cup.idCUP=$idCup AND tbl_configuracion.estadoTabla LIKE 'Activo';
END!




#######################################################################
CREATE PROCEDURE `spConsultaAuxEnfermeria`(
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
END !


CREATE DEFINER=`root`@`localhost` PROCEDURE `spConsultarMedicacionDmc`(IN $idAtencion INT)
begin
  select his.dosis,his.hora,his.viaAdministracion,cantidadUnidades,nombre
  from tbl_medicamento as his
  inner join tbl_detallekit as det

  on his.idDetalleKit=det.idDetallekit
  inner join tbl_recurso as rec
  on det.idrecurso=rec.idrecurso
  where idHistoriaClinica = $idAtencion;
end !


#PROCEDIMIENTO
CREATE PROCEDURE `spConsultarProcedimientoDmc`(IN $idAtencion INT)
begin
  select nombreCUP,codigoCup,descripcionProcedimiento,idHistoriaClinica,idProcedimiento
  from tbl_cup as cup
  inner join tbl_procedimiento as pro
  on cup.idCUP=pro.idCUP
  where idHistoriaClinica=$idAtencion;
end !


#PROCEDIMIENTO
CREATE PROCEDURE `spConsultarPacienteIdDmc`(IN $idAtencion INT)
begin
  select  idPaciente
  from tbl_historiaclinica
  where idPaciente=$idAtencion;
end !


#PROCEDIMIENTO
CREATE PROCEDURE `spConsultarHoraSignosVitales`(IN $idAtencion INT )
begin
  select hora from tbl_signosvitales where idHistoriaClinica= $idAtencion limit 4;
end !


#PROCEDIMIENTO
CREATE PROCEDURE `spConsultarResultadosSignosVitales`(IN $idAtencion INT)
begin
  select resultado from tbl_signosvitales where idHistoriaClinica=$idAtencion;
end !


#PROCEDIMIENTO
create Procedure spRegistarNotasEnfermeria()
begin
insert into  tbl_notaEnfermeria(descripcion,idPersona,idProcedimiento)
values(descripcion,idPersona,idProcedimiento);
end !


#PROCEDIMIENTO
CREATE PROCEDURE `spConsultarProcedimientosNotas`(IN $idProcedimiento INT)
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
end !


#PROCEDIMIENTO
CREATE PROCEDURE `spConsultarDescripcionProcedimiento`(IN filtro VARCHAR(1000))
begin
  select idCup as id, nombreCup from tbl_cup where nombreCup LIKE concat('%',filtro,'%');
end !


#PROCEDIMIENTO
CREATE PROCEDURE `spConsultarDescripcionIdProcedimiento`(IN id INT(11))
begin
  select nombreCup from tbl_cup where idCup = id;
end !




#PROCEDIMIENTO
CREATE PROCEDURE `spConsultarCodigoIdProcedimiento`(IN id INT(11))
begin
  select codigoCup from tbl_cup where idCup = id;
end !




#PROCEDIMIENTO
CREATE PROCEDURE `spContarDescripcionProcedimiento`(IN filtro VARCHAR(1000))
begin
  select count(idCup) as cont from tbl_cup where nombreCup LIKE concat('%',filtro,'%');
end !


#PROCEDIMIENTO
CREATE PROCEDURE `spConsultarCodigoProcedimientos`(IN filtro VARCHAR(45))
begin
  select idCup as id, codigoCup from tbl_cup where codigoCup LIKE concat('%',filtro,'%');
end !


#PROCEDIMIENTO
CREATE PROCEDURE `spContarCodigoProcedimiento`(IN filtro VARCHAR(45))
begin
  select count(idCup) as cont from tbl_cup where codigoCup LIKE concat('%',filtro,'%');
end !


#PROCEDIMIENTO
CREATE PROCEDURE `spConsultarDescripcionIdDiagnostico`(IN id INT(11))
begin
select descripcionCIE10 from tbl_cie10 where idCIE10 = id;
end !


#PROCEDIMIENTO
CREATE PROCEDURE `spConsultarCodigoIdDiagnostico`(IN id INT(11))
begin
  select codigoCIE10 from tbl_cie10 where idCIE10 = id;
end !


#PROCEDIMIENTO
CREATE PROCEDURE `spConsultarDescripcionDiagnostico`(IN filtro VARCHAR(1000))
begin
  select idCIE10 as id, descripcionCIE10 from tbl_cie10 where descripcionCIE10 LIKE concat('%',filtro,'%');
end !


#PROCEDIMIENTO
CREATE PROCEDURE `spContarDiagnostico`(IN filtro VARCHAR(1000))
begin
  select count(idCIE10) as cont from tbl_cie10 where descripcionCIE10 LIKE concat('%',filtro,'%');
end !


# PROCEDIMIENTO
CREATE PROCEDURE `spConsultarCodigoDiagnostico`(IN filtro VARCHAR(45))
begin
  select idCIE10 as id, codigoCIE10 from tbl_cie10 where codigoCIE10 LIKE concat('%',filtro,'%');
end !


#PROCEDIMIENTO
CREATE PROCEDURE `spActualizarInformacionPersonal`(IN $estadoCivil VARCHAR(45),IN $ciudadResidencia VARCHAR(45),IN $barrioResidencia VARCHAR(45),IN $direccion VARCHAR(45),IN $correoElectronico VARCHAR(45),IN $telefonoFijo VARCHAR(45),IN $telefonoMovil VARCHAR(45),IN $empresa VARCHAR(45),IN $ocupacion VARCHAR(45),IN $idPaciente INT(11))
begin
  UPDATE tbl_paciente set estadoCivil=$estadoCivil,ciudadResidencia=$ciudadResidencia,barrioResidencia=$barrioResidencia,direccion=$direccion,correoElectronico=$correoElectronico,telefonoFijo=$telefonoFijo,telefonoMovil=$telefonoMovil,empresa=$empresa,
  ocupacion=$ocupacion where idPaciente= $idPaciente;
end !




#PROCEDIMIENTO

create Procedure spRegistrarTipoOrigenAtencion()
begin
  insert into tbl_tipoorigenatencion(descripcionOrigenAtencion,estadoTabla)
  values(descripcion,'Inactivo');
end !





#PROCEDIMIENTO
CREATE PROCEDURE `spRegistrarHistoriaClinicaDmc`(IN fechaAtencion DATE, IN motivoAtencion TEXT, IN enfermedadActual TEXT,IN placaVehiculo VARCHAR(45), IN idTipoorigenAtencion INT(11),IN idCitaprogramacion INT(11),IN idPaciente INT(11),IN evolucion TEXT)
begin
  insert into tbl_historiaclinica(fechaAtencion,motivoAtencion,enfermedadActual,placaVehiculo,idTipoorigenAtencion,idCitaprogramacion,idPaciente,evolucion)
  values(fechaAtencion,motivoAtencion,enfermedadActual,placaVehiculo,idTipoOrigenAtencion,idCitaProgramacion,idPaciente,evolucion);
end !


#PROCEDIMIENTO
CREATE  PROCEDURE `spRegistrarAntecedentesDmc`(IN descripcionAntecedente TEXT,IN	idTipoAntecedente  INT(11),IN idHistoriaClinica INT(11))
begin
  insert into tbl_antecedentedmc(descripcionAntecedente,idTipoAntecedente,idHistoriaClinica)
  values(descripcionAntecedente,idTipoAntecedente,idHistoriaClinica);
end !


#PROCEDIMIENTO
CREATE PROCEDURE `spRegistrarExamenFisico`(IN descripcion TEXT, IN idtipoExamenFisico INT(11) ,IN estado VARCHAR(45), IN idHistoriaClinica INT(11))
begin
  insert into tbl_examenfisicodmc(descripcionExamen,idtipoExamenFisico,estadoTablaExamen,idHistoriaClinica)
  values(descripcion,idTipoExamenFisico,estado,idHistoriaClinica);
end !


#PROCEDIMIENTO
CREATE DEFINER=`root`@`localhost` PROCEDURE `spRegistrarDiagnostico`(IN descripcion TEXT, IN idCIE10 INT(11) ,IN idHistoriaClinica  INT(11))
begin
  insert into tbl_diagnostico(descripcionDiagnostico,idCIE10,idHistoriaClinica)
  values(descripcion,idCIE10,idHistoriaClinica);
end !


#PROCEDIMIENTO
CREATE PROCEDURE `spRegistrarProcedimiento`(IN descripcion VARCHAR(1000),IN idCUP INT(11),IN idHistoriaClinica INT(11))
begin
  insert into tbl_procedimiento(descripcionProcedimiento,idCUP,idHistoriaClinica)
  values(descripcion,idCUP,idHistoriaClinica);
end !


#PROCEDIMIENTO
CREATE PROCEDURE `spRegistrarMedicacionDmc`(IN dosis VARCHAR(45),IN hora TIME ,IN  viaAdministracion VARCHAR(45),IN cantidadUnidades INT(11) ,IN idDetalleKit INT(11), IN idHistoriaClinica INT(11))
begin
  insert into tbl_medicamento(dosis,hora,viaAdministracion,cantidadUnidades,idDetalleKit,idHistoriaClinica)
  values(dosis,hora,viaAdministracion,cantidadUnidades,idDetalleKit,idHistoriaClinica);
end !


#PROCEDIMIENTO
CREATE PROCEDURE `spActualizarMedicacionDmc`(IN $cantidadUnidades INT(11), IN $idDetalleKit INT(11))
begin
  update tbl_detallekit dt1,(select cantidadFinal-$cantidadUnidades as nuevaCantidad from tbl_detallekit
  where idDetallekit = $idDetalleKit)as dt2 set dt1.cantidadFinal = dt2.nuevaCantidad
  where idDetallekit = $idDetalleKit;
end !


#PROCEDIMIENTO
CREATE PROCEDURE `spRegistrarTTratamiento`(IN Descripcion VARCHAR(1000))
begin
  insert into tbl_tipotratamiento(Descripcion,categoriaItemTratamiento,estadoTabla)values(descripcion,'Básico','Inactivo');
end !


#PROCEDIMIENTO
CREATE PROCEDURE `spRegistrarTratamiento`(
  IN descripcion VARCHAR(45),
  IN fecha VARCHAR(45),
  IN  dosis VARCHAR(45),
  IN idHistoriaClinica VARCHAR(45),
  IN idTipoTratamiento VARCHAR(45)
)
begin
  insert into tbl_tratamientodmc(descripcionTratamiento,fechaTratamiento,dosisTratamiento,idHistoriaClinica,idTipoTratamiento) values(descripcion,fecha,dosis,idHistoriaClinica,idTipoTratamiento);
end !





#PROCEDIMIENTO
CREATE PROCEDURE `spRegistrarDetalleTratamientoEquipoBiomedico`(IN descripcion VARCHAR(50),IN idTratamiento INT(11))
begin
  insert into tbl_equipobiomedico(descripcion,idTratamiento) values(descripcion,idTratamiento);
end !


#PROCEDIMIENTO
CREATE PROCEDURE `spRegistrarDetalleTratamientoRecurso`(
  IN idTratamiento VARCHAR(45),IN idRecurso VARCHAR(45)
)
begin
  insert into tbl_detalletratamientodmcrecurso(idTratamiento,idRecurso) values(idTratamiento,idRecurso);
end !


#PROCEDIMIENTO
CREATE PROCEDURE `spRegistrarFormulaMedica`(IN recomendacion VARCHAR(1000),IN idHistoriaClinica INT(11))
begin
  insert into tbl_formulamedica(recomendaciones,idHistoriaClinica) values(recomendacion,idHistoriaClinica);
end !


CREATE PROCEDURE `spUltimoIdFormula`()
begin
  select MAX(idFormulaMedica) as id from tbl_formulamedica;
end !


#PROCEDIMIENTO
CREATE PROCEDURE `spRegistrarFormulaMedicamento`(IN dosificacion VARCHAR(100),IN descripcion VARCHAR(1000),IN cantidadMedicamento INT(11),IN idMedicamento INT(11),IN idFormulaMedica INT(11))
begin
  insert into tbl_formulamedicamedicamentodmc(dosificacion,descripcion,cantidadMedicamento,idMedicamento,idFormulaMedica) values(dosificacion,descripcion,cantidadMedicamento,idMedicamento,idFormulaMedica);
end !


#PROCEDIMIENTO
CREATE PROCEDURE `spRegistrarTExamenesEspecializados`(IN descripcion VARCHAR(1000))
begin
  insert into tbl_tipoexamenespecializado(descripcion,estadoTabla) values(descripcion,'Inactivo');
end !


#PROCEDIMIENTO
CREATE PROCEDURE `spRegistrarExameneEspecializado`(IN historiaClinica INT(11),IN observacion TEXT,IN idTipoExamenEspecializado INT(11),IN descripcion TEXT)
begin
  insert into tbl_examenespecializado(idHistoriaClinica,observaciones,idTipoExamenEspecializado,descripcion) values(historiaClinica,observacion,idTipoExamenEspecializado,descripcion);
end !


#PROCEDIMIENTO
CREATE PROCEDURE `spRegistrarIncapacidad`(IN cantidadDias INT(11),IN prorroga VARCHAR(100),IN descripcionMotivo TEXT,IN idCIE10 INT(11),IN idHistoriaClinica INT(11))
begin
  insert into tbl_incapacidad(cantidadDias,prorroga,descripcionMotivo,idCIE10,idHistoriaClinica) values(cantidadDias,prorroga,descripcionMotivo,idCIE10,idHistoriaClinica);
end !


#PROCEDIMIENTO
CREATE PROCEDURE `spRegistrarOtroDmc`(IN descripcion TEXT,IN idHistoriaClinica INT(11))
begin
  insert into tbl_otrodmc(descripcion,idHistoriaClinica) values(descripcion,idHistoriaClinica);
end !


#PROCEDIMIENTO
CREATE PROCEDURE spConsultarcitasprogramadas(IN $idPersona INT)
BEGIN
  SELECT P.idPersona ,Es.idRol,P.primerNombre, E.descripcionRol ,P.primerApellido,T.horaInicioTurno,T.horaFinalTurno,PR.Fecha_inicial,PR.Fecha_final FROM tbl_persona P inner join tbl_cuentausuario Es on p.idPersona = Es.idPersona inner join tbl_rol E on Es.idRol = E.idRol inner join tbl_turnoprogramacion TP on P.idPersona = TP.idPersona inner JOIN tbl_turno T on TP.idTurno = T.idTurno inner join tbl_programacion PR on TP.idProgramacion = PR.idProgramacion where P.idPersona = $idPersona and TP.estadoTablaProgramacion = "Inactivo";
END !


#PROCEDIMIENTO
CREATE PROCEDURE spConsultarTurnoActivo(IN $idPersona INT)
BEGIN
  SELECT P.idPersona,T.idTurno,tp.idTurnoProgramacion, Es.idrol,P.primerNombre, E.descripcionRol,P.primerApellido,P.segundoApellido ,max(T.horaInicioTurno) as 'Horainicial',max(T.horaFinalTurno) as'Horafinal',max(PR.Fecha_inicial) as 'Fechainicial',max(PR.Fecha_final) as 'Fechafinal',TP.estadoTablaProgramacion FROM tbl_persona P inner join tbl_cuentausuario Es on p.idPersona = Es.idPersona inner join tbl_rol E on ES.idRol = E.idRol inner join tbl_turnoprogramacion TP on P.idPersona = TP.idPersona inner JOIN tbl_turno T on TP.idTurno = T.idTurno inner join tbl_programacion PR on TP.idProgramacion = PR.idProgramacion where P.idPersona = $idPersona and TP.estadoTablaProgramacion = 'Activo' LIMIT 1;
END !



#PROCEDIMIENTO
    CREATE PROCEDURE spConsultarProgramacion(IN $fecha_inicial DATE, $fecha_final DATE)
   BEGIN SELECT `idProgramacion` FROM `tbl_programacion` WHERE `Fecha_inicial` = $fecha_inicial

and `Fecha_final` = $fecha_final;
    END !




#PROCEDIMIENTO
    CREATE PROCEDURE spConsultarprogramacionconturno(IN $idPersona INT)
   BEGIN
SELECT p.idPersona,TP.idProgramacion from tbl_persona p INNER JOIN tbl_turnoprogramacion TP on p.idPersona = TP.idPersona
where TP.estadoTablaProgramacion = "Activo" and p.idPersona = $idPersona;
END !




#PROCEDIMIENTO
CREATE PROCEDURE spConsultacitasU(IN $idPersona INT)
BEGIN
  SELECT PE.idPersona, PE.primerNombre as 'medico',PE.primerApellido as 'medicoape', PA.idPaciente, PA.primerNombre as 'paciente', PA.primerApellido,PA.numeroDocumento,C.horaInicial,C.horaFinal,P.Fecha_inicial as 'fecha',C.direccionCita,CU.nombreCUP FROM tbl_cita C INNER JOIN tbl_paciente PA ON PA.idPaciente = C.idPaciente INNER JOIN tbl_cita_programacion CP ON C.idCita = CP.idcita INNER JOIN tbl_turnoprogramacion TP ON CP.idTurnoProgramacion = TP.idTurnoProgramacion INNER JOIN tbl_persona PE ON PE.idPersona = TP.idPersona INNER JOIN tbl_programacion P ON P.idProgramacion = TP.idProgramacion INNER JOIN tbl_turno T ON T.idTurno = TP.idTurno INNER JOIN tbl_Cup cu ON CU.idCup = C.idCUP
  where PE.idPersona = $idPersona;
END !




#PROCEDIMIENTO
CREATE PROCEDURE spConsultaProgramacionDias(IN $idPersona INT)
BEGIN
select p.Fecha_inicial
from tbl_Programacion p
inner join tbl_TurnoProgramacion tp
on p.idProgramacion = tp.idProgramacion
where tp.idPersona = $idPersona and tp.estadoTablaProgramacion = 'Activo';
END !


#PROCEDIMIENTO
CREATE PROCEDURE consultarPersonatodo(IN $idPersona INT)
BEGIN
  SELECT  pe.primerNombre ,pe.segundoNombre, pe.primerApellido,pe.segundoApellido,pe.telefono,pe.direccion,pe.numeroDocumento,pe.sexo,pe.lugarNacimiento,pe.fechaNacimiento,pe.ciudad,pe.departamento,pe.correoElectronico,pe.estadotablaPersona,pe.pais,pe.grupoSanguineo,r.descripcionRol,pe.dependencia from tbl_persona pe inner join tbl_cuentausuario c on pe.idPersona = c.idPersona inner join tbl_rol r on r.idRol = c.idRol
   where pe.idPersona = $idPersona;
END !


#PROCEDIMIENTO
CREATE PROCEDURE spConsultarTurnosP(IN $idPersona INT)
BEGIN
  select distinct t.horaInicioTurno, t.horaFinalTurno
  from tbl_turnoprogramacion tp
  inner join tbl_turno t
  on tp.idTurno = t.idTurno
  where tp.estadoTablaProgramacion = 'Activo' and tp.idPersona = $idPersona;
END !




#PROCEDIMIENTO
CREATE PROCEDURE spConsultarpersonaconespecialidad()
BEGIN
  Select (select COUNT(pr.idProgramacion) FROM tbl_turnoprogramacion pr where pr.idPersona = pe.idPersona and pr.estadoTablaProgramacion = 'Activo') as pro, pe.idPersona, pe.primerNombre,pe.primerApellido,r.descripcionRol,pe.estadoTablaPersona,pe.dependencia from tbl_persona pe inner join tbl_cuentausuario c on pe.idPersona = c.idPersona inner join tbl_rol r on r.idRol = c.idRol where (r.descripcionRol = "Auxiliar de Enfermeria" or r.descripcionRol = "Enfermera Jefe" or r.descripcionRol= "Medico") and pe.estadoTablaPersona = "Activo" and pe.dependencia = "Domiciliaria";
END !



# PROCEDIMIENTO:
CREATE PROCEDURE `spListarTemporalautorizacion`(IN `$idConsulta` INT,
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
END !

#PROCEDIMIENTO
CREATE PROCEDURE spRegistrarTipoAseguramientoHC(IN $DescripcionTipoAseguramiento VARCHAR(60),IN $estadoTabla VARCHAR(60))
BEGIN
INSERT INTO `tbl_tipoaseguramiento`(`DescripcionTipoAseguramiento`, `estadoTabla`) VALUES ($DescripcionTipoAseguramiento, $estadoTabla);
SELECT MAX(idTipoAseguramiento) as ultimoTipoAseguramiento FROM `tbl_tipoaseguramiento`;
END !

#PROCEDIMIENTO:
CREATE PROCEDURE spUniqueDespachoReporteaph(IN $idDespacho int(11))
BEGIN
SELECT        idReporteAPH FROM `tbl_reporteaph` WHERE idDespacho = $idDespacho;
END !

#PROCEDIMIENTO
CREATE PROCEDURE spRegistrarTipoEvento_reporteinicialAPH(IN $idTipoEvento int(11), $idReporteInicial int(11))
BEGIN
  INSERT INTO tbl_tipoevento_reporteinicial (idTipoEvento, idReporteInicial)
  VALUES ($idTipoEvento, $idReporteInicial);
END !

CREATE PROCEDURE spConsultaPersonaCorreo(
    IN $correoElectronico varchar(50)
)
BEGIN
SELECT * FROM `tbl_persona` WHERE `correoElectronico` = $correoElectronico;
END!

# PROCEDIMIENTO:
CREATE PROCEDURE spValidarCorreoPersona(IN $correoElectronico varchar(50))
BEGIN
  SELECT 1
  FROM tbl_persona
  WHERE correoElectronico = $correoElectronico;
END !

# PROCEDIMIENTO:
CREATE PROCEDURE spConsultaPersonaUsuario(IN $usuario varchar(50))
BEGIN
  SELECT * FROM `tbl_cuentausuario` WHERE `usuario` = $usuario;
END !

# PROCEDIMIENTO:
CREATE PROCEDURE spValidarUsuarioPersona(IN $usuario varchar(50))
BEGIN
 SELECT 1
 FROM tbl_cuentausuario
 WHERE usuario = $usuario;
END !


# FUNCTION:
CREATE FUNCTION  fnFinalizarReporteInicial(
  $idReporteInicial INT
) RETURNS INT(11)
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

END !

# PROCEDIMIENTO:
CREATE PROCEDURE `spConsultarMedicoExterno`()
BEGIN
  SELECT idRol as Rol FROM `tbl_rol` WHERE `descripcionRol` like ('%Medico Externo%');
END !

# PROCEDIMIENTO:
CREATE PROCEDURE `spRegistrarTemporalautorizacionMedicamento`(
IN $idParamedico INT,
IN $idMedicamento INT,
IN $descripcionAutorizacion TEXT,
IN $cedulaPaciente VARCHAR(200),
IN $estadoEvaluacion VARCHAR(200),
IN $fechaEnvio DATETIME)
BEGIN
  INSERT INTO `tbl_temporalautorizacion`(`idParamedico`, `idMedicamento`, `descripcionAutorizacion`, `cedulaPaciente`, `estadoEvaluacion`, `fechaEnvio`) VALUES ($idParamedico,$idMedicamento,$descripcionAutorizacion,$cedulaPaciente,$estadoEvaluacion,$fechaEnvio);
END !

# PROCEDIMIENTO:
CREATE PROCEDURE `spListarTemporalautorizacionMedicamento`(IN `$idConsulta` INT,
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
END !

# PROCEDIMIENTO:
CREATE PROCEDURE `spRegistrarAllAutorizacionMedicamento`(
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
END !

# PROCEDIMIENTO:
CREATE PROCEDURE `spRegistrarAllAutorizacionTratamiento`(
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
END !

# PROCEDIMIENTO:
CREATE PROCEDURE listarAllAutorizacion(
$idParamedico INT,
$cedulaBusqueda VARCHAR(45)
)
BEGIN
SELECT * FROM tbl_temporalautorizacion WHERE idParamedico = $idParamedico AND cedulaPaciente = $cedulaBusqueda;
END !

# PROCEDIMIENTO:
CREATE PROCEDURE `spValidarTipoAmbulancia`(IN `$idPersonal` INT)
BEGIN
  SELECT TA.tipoAmbulancia
  FROM tbl_detalleasignacion TD
  INNER JOIN tbl_asignacionPersonal TAP
  ON TD.idAsignacionPersonal = TAP.idAsignacionPersonal
  INNER JOIN tbl_ambulancia TA
  ON TA.idAmbulancia = TAP.idAmbulancia
  WHERE TD.idPersona = (SELECT idPersona FROM tbl_cuentausuario WHERE idUsuario = $idPersonal) AND TD.estadoTabla = 'Activo';
END !

# PROCEDIMIENTO:
CREATE PROCEDURE spAutenticarMedico (
IN `$usuario` VARCHAR(45),
IN `$clave` VARCHAR(45)
)
BEGIN
SELECT TC.idUsuario FROM tbl_cuentausuario TC
INNER JOIN tbl_rol TR
ON TR.idRol = TC.idRol
WHERE TC.usuario = `$usuario` AND TC.clave = `$clave` AND TR.descripcionRol = 'Medico';
END !

# PROCEDIMIENTO:
CREATE PROCEDURE `spRegistrarAutorizacionMedicalizada`(
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
END !

CREATE PROCEDURE spListarNovedadReporte()
BEGIN
SELECT tblni.idReporteInicial, tblni.descripcionNovedad, tblni.numeroLesionadosNovedad, tblri.ubicacionIncidente, tblni.idNovedad
FROM tbl_novedadreporteinicial AS tblni
INNER JOIN tbl_reporteinicial AS tblri
ON tblni.idReporteInicial = tblri.idReporteInicial
WHERE tblni.estadoNovedad = 'Activo'
order by tblni.fechaHoraNovedad desc ;
END !

CREATE PROCEDURE spActualizarEstadoNovedadReporte(IN _idNovedad int )
BEGIN
  UPDATE tbl_novedadreporteinicial SET estadoNovedad = 'Atendida' where idNovedad = _idNovedad;
END !


CREATE PROCEDURE spInfoReporteDespacho( IN _idDespacho int)
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
END  !


CREATE PROCEDURE spListarDespacho()
BEGIN
  SELECT d.idDespacho, d.idReporteInicial, a.placaAmbulancia, d.fechaHoraDespacho, d.estadoDespacho
  FROM tbl_despacho d
  INNER JOIN tbl_ambulancia a
  ON d.idAmbulancia = a.idAmbulancia;
END !

CREATE PROCEDURE spConsultarAsignacionAmbulancia ()
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
END !


CREATE PROCEDURE spConsultaParametrizadaAsignacionAmbulancia( IN _idAmbulancia int )
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
END !


CREATE PROCEDURE spRegistrarDetalleasignacion(
IN $idAsignacionPersonal int,
IN $idPersona int,
IN $estadoTabla varchar(50),
IN $cargoPersona varchar(50) )
BEGIN
  INSERT INTO `tbl_detalleasignacion`(`idAsignacionPersonal`, `idPersona`, `estadoTabla`,`cargoPersona`) VALUES ($idAsignacionPersonal, $idPersona, $estadoTabla, $cargoPersona);
END !

CREATE PROCEDURE spSeleccionarUltimoIdAsignacion()
BEGIN
	SELECT MAX(idAsignacionPersonal) AS ultimo
  FROM tbl_asignacionpersonal;
END !

CREATE PROCEDURE spRegistrarAsignacionpersonal(
IN $idAmbulancia int,
IN $fechaHoraAsignacion datetime,
IN $estadoTablaAsignacion varchar(45),
IN $longitud varchar(45),
IN $latitud varchar(45)
)
BEGIN
INSERT INTO `tbl_asignacionpersonal`(`idAmbulancia`, `fechaHoraAsignacion`, `estadoTablaAsignacion`, `longitud`, `latitud`) VALUES ($idAmbulancia, $fechaHoraAsignacion, $estadoTablaAsignacion, $longitud, $latitud);
END !

CREATE OR REPLACE VIEW viewAmbulanciasPersonal AS
SELECT idAmbulancia, tipoAmbulancia, placaAmbulancia
FROM tbl_ambulancia
WHERE estadoTabla = 'Personal Asignado' !

CREATE PROCEDURE spConsultarTipoAmbulancia(IN _idAmbulancia int)
BEGIN
  SELECT tipoAmbulancia
  FROM tbl_ambulancia
  WHERE idAmbulancia = _idAmbulancia;
END !

CREATE PROCEDURE spModificarAsignacionpersonal(
IN $idAsignacionPersonal int,
IN $idAmbulancia int,
IN $fechaHoraAsignacion datetime,
IN $longitud varchar(45),
IN $latitud varchar(45)
)
BEGIN
  UPDATE `tbl_asignacionpersonal` SET `idAmbulancia` = $idAmbulancia, `fechaHoraAsignacion` = $fechaHoraAsignacion,
  `longitud` = $longitud, `latitud` = $latitud WHERE `idAsignacionPersonal` = $idAsignacionPersonal;
END !


CREATE PROCEDURE spConfirmarAsignacion(
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
END !


CREATE PROCEDURE spConsultaBasicadelTratamiento(IN _idPaciente int)
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
END !

CREATE PROCEDURE spConsultaBasicaTratamiento()
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
END !

CREATE PROCEDURE `spRegistrarPermiso`(IN `$rol` INT, IN `$modulo` INT, IN `$vista` INT)
BEGIN
  INSERT INTO`bd_proyecto_salud`.`tbl_rolmodulovista` ( `idRol`, `idModulo`, `idVista`)
  VALUES ($rol, $modulo, $vista);
END !

CREATE PROCEDURE `spConsultarUsuario`()
BEGIN
  SELECT idRol as Rol FROM tbl_rol WHERE descripcionRol = UPPER('Usuario');
END !

CREATE PROCEDURE `spValidarUrl`(IN `$idRol` INT)
BEGIN
  SELECT v.urlVista FROM tbl_rolmodulovista rmv
  INNER JOIN tbl_rol r
  ON rmv.idRol = r.idRol
  INNER JOIN tbl_modulo m
  ON rmv.idModulo = m.idModulo
  INNER JOIN tbl_Vista v
  ON rmv.idVista = v.idVista
  where r.idRol = $idRol;
END !

CREATE PROCEDURE `spConcultaPermisoAsignado`(IN `$descripcionRol` VARCHAR(45))
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
END !

CREATE OR REPLACE VIEW viewlistarreportesactivos AS
SELECT * FROM tbl_reporteinicial
WHERE LOWER(estadoTablaReporteInicial) = LOWER('Activo') !


CREATE PROCEDURE spListarMedico()
BEGIN
 SELECT *
 FROM tbl_persona p
 inner join tbl_cuentausuario cu
 on p.idPersona = CU.idPersona
 INNER JOIN tbl_rol re
 on re.idRol = cu.idRol
 where re.descripcionRol = 'Medico';
END !


CREATE PROCEDURE spTraerIdNovedadrecurso(
IN _id INT
)
BEGIN
select * from tbl_novedadrecurso nr
INNER JOIN tbl_detallekit dk
on nr.idDetallekit = dk.idDetallekit
INNER JOIN tbl_recurso r
on dk.idrecurso = r.idrecurso
where nr.idNovedadRecurso = _id;
END !


CREATE PROCEDURE spListarRol()
BEGIN
  SELECT * FROM `tbl_rol` WHERE UPPER(descripcionRol) <> UPPER('USUARIO');
END !


CREATE  PROCEDURE `spSugerenciaEnfermerosJefe`(IN $idMedico INT(11))

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

END!


CREATE  PROCEDURE `spSugerenciaAuxiliarEnfermeria`(IN $idMedico INT(11))

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

END!


CREATE PROCEDURE `spIdPersona`(IN $idPersona INT(11))
BEGIN
  SELECT tbl_turnoprogramacion.idPersona
  FROM tbl_turnoprogramacion
  WHERE tbl_turnoprogramacion.idTurnoProgramacion=$idPersona;
END !


CREATE PROCEDURE spConsultaPersonaD($numeroDocumento VARCHAR(45))
BEGIN
  SELECT * FROM `tbl_persona` WHERE `numeroDocumento` = $numeroDocumento;
END !


CREATE PROCEDURE spConsultarHistorialP(IN $fehca date, $id int)
BEGIN
  select p.Fecha_inicial
  from `tbl_turnoprogramacion` t
  inner join `tbl_programacion` p
  on t.idProgramacion = p.idProgramacion
  where t.idPersona = $id and date_format(p.Fecha_final,'%m-%Y')= date_format($fehca,'%m-%Y') and (t.estadoTablaProgramacion = 'Activo' or t.estadoTablaProgramacion = 'Terminado');
END !


CREATE PROCEDURE spConsultarTurnosHP(IN $fecha date, $idPersona INT)
BEGIN
  select distinct t.horaInicioTurno, t.horaFinalTurno
  from tbl_turnoprogramacion tp
  inner join tbl_turno t
  on tp.idTurno = t.idTurno
  inner join tbl_programacion p
  on tp.idProgramacion = p.idProgramacion
  where tp.idPersona=$idPersona and date_format(p.Fecha_final,'%m-%Y')= date_format($fecha,'%m-%Y') and (tp.estadoTablaProgramacion = 'Activo' or tp.estadoTablaProgramacion = 'Terminado');
END !


CREATE PROCEDURE spTraerprogramacionesvencidas(IN $Fecha date)
BEGIN
  select idTurnoProgramacion
  from tbl_turnoprogramacion tp
  inner join tbl_programacion p
  on tp.idProgramacion = p.idProgramacion
  where p.Fecha_final<$Fecha;
END !


CREATE PROCEDURE spConsultarCorreoPersonaP(IN $idPersona INT)
BEGIN
  select `correoElectronico`
  from `tbl_persona`
  where `idPersona` = $idPersona;
END !

CREATE PROCEDURE spCambiarEstadoProgramacion(IN $idPersona INT)
BEGIN
  UPDATE tbl_turnoprogramacion e set e.estadoTablaProgramacion = 'Inactivo'
  where e.idPersona = $idPersona;
END !


CREATE OR REPLACE VIEW viewconsultarprestamos AS
SELECT
PA.idPaciente, PA.primerNombre, PA.segundoNombre, PA.direccion, PA.telefonoFijo, PA.numeroDocumento,tbh.idHistoriaClinica, tbr.nombre, tbl_asignacionkit.fechaHoraAsignacion, tbr.cantidadRecurso,tbt.descripcionTratamiento,tbt.fechaTratamiento,tbl_asignacionkit.estadoTablaAsignacionKit,
tbl_detallekit.cantidadAsignada
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
INNER JOIN tbl_categoriarecurso tbcg ON tbr.idCategoriaRecurso = tbcg.idCategoriaRecurso
INNER JOIN tbl_tratamientodmc on tbh.idHistoriaClinica = tbl_tratamientodmc.idHistoriaClinica
INNER JOIN tbl_detalletratamientodmcrecurso dett on tbl_tratamientodmc.idTratamiento = dett.idTratamiento
INNER JOIN tbl_asignacionkit on PA.idPaciente= tbl_asignacionkit.idPaciente
INNER JOIN tbl_detallekit on tbl_asignacionkit.idAsignacion = tbl_detallekit.idAsignacion !


CREATE PROCEDURE spConsultarDescripcionCUPcita(IN $filtro varchar(1000))
BEGIN
  select tbl_cup.idCUP as id, tbl_cup.nombreCUP as nombreCup
  from tbl_cup
  where tbl_cup.nombreCUP LIKE CONCAT('%',CONCAT($filtro, '%')) and idTipoCup=(SELECT tbl_tipocup.idTipoCup
  FROM tbl_tipocup
  WHERE tbl_tipocup.descripcionCUP LIKE 'Citas');
END !


CREATE PROCEDURE spConsultarDescripcionIdCUPcita(IN $id int(11))
BEGIN
select tbl_cup.nombreCUP  as nombreCup
from tbl_cup
where tbl_cup.idCUP = $id and tbl_cup.idTipoCup=(SELECT tbl_tipocup.idTipoCup
FROM tbl_tipocup
WHERE tbl_tipocup.descripcionCUP LIKE 'Citas');
END !


CREATE PROCEDURE spConsultarCodigoIdCUPCita(IN $id int(11))
BEGIN
  select tbl_cup.codigoCup as codigoCup
  from tbl_cup
  where tbl_cup.idCUP = $id and tbl_cup.idTipoCup=(SELECT tbl_tipocup.idTipoCup
  FROM tbl_tipocup
  WHERE tbl_tipocup.descripcionCUP LIKE 'Citas');
END !


CREATE PROCEDURE spContarDescripcionCUPcita(IN $filtro varchar(1000))
BEGIN
  select count(tbl_cup.idCUP) as cont
  from tbl_cup
  where tbl_cup.nombreCUP LIKE CONCAT('%',CONCAT($filtro, '%')) and tbl_cup.idTipoCup=(SELECT tbl_tipocup.idTipoCup
  FROM tbl_tipocup
  WHERE tbl_tipocup.descripcionCUP LIKE 'Citas');
END !


CREATE PROCEDURE spConsultarCodigoCUPcita(IN $filtro varchar(45))
BEGIN
  select tbl_cup.idCUP as id, tbl_cup.codigoCup as codigoCup
  from tbl_cup
  where tbl_cup.codigoCup LIKE CONCAT('%',CONCAT($filtro, '%')) and tbl_cup.idTipoCup=(SELECT tbl_tipocup.idTipoCup
  FROM tbl_tipocup
  WHERE tbl_tipocup.descripcionCUP LIKE 'Citas');
END !


CREATE PROCEDURE spContarCodigoCUPcita(IN $filtro varchar(45))
BEGIN
  select count(tbl_cup.idCUP) as cont
  from tbl_cup
  where tbl_cup.codigoCup LIKE CONCAT('%',CONCAT($filtro, '%')) and tbl_cup.idTipoCup=(SELECT tbl_tipocup.idTipoCup
  FROM tbl_tipocup
  WHERE tbl_tipocup.descripcionCUP LIKE 'Citas');
END !


CREATE PROCEDURE spActualizarEstadoDetalleAsignacion( IN _idPersona int )
BEGIN
  UPDATE tbl_detalleasignacion SET estadoTabla = 'Inactivo' WHERE idPersona = _idPersona;
END !


CREATE PROCEDURE spListartblDetallekit( IN $idAsignacion INT )
BEGIN
  SELECT cantidadAsignada,nombre,cantidadFinal FROM tbl_detalleKit AS dk
  INNER JOIN tbl_recurso AS rc
  ON dk.idrecurso = rc.idrecurso
  WHERE idAsignacion = $idAsignacion;
END !


CREATE PROCEDURE splistaCompletaRecursoEstandar()
BEGIN
  SELECT ek.idEstandarKit, rs.nombre, ek.stockminKit FROM tbl_estandarkit as ek
  inner join tbl_recurso as rs
  on rs.idrecurso = ek.idEstandarKit;
END !


CREATE PROCEDURE splistarComboRecursokit()
BEGIN
  SELECT idrecurso, nombre FROM `tbl_recurso`;
END !


create procedure spListarEquipoBiomedicoDmc()
BEGIN
  SELECT idRecurso, nombre FROM tbl_recurso WHERE idCategoriaRecurso = '2'  AND estadoTablaRecurso = 'Activo';
END !


create procedure spListarMedicamentoDmc()
begin
  select idRecurso, nombre from tbl_recurso where idCategoriaRecurso = '3' and estadoTablaRecurso = 'Activo';
end !

create procedure spUltimoIdTTratamiento()
begin
  select max(idTipoTratamiento) as id from tbl_tipotratamiento;
end !


CREATE PROCEDURE `spListarMedicacion`(IN idPersona VARCHAR(100))
begin
  select dk.idDetalleKit,r.nombre,cantidadFinal as cantidadTotal
  from tbl_detallekit dk
  inner join tbl_recurso r
  on dk.idRecurso=r.idRecurso
  inner join tbl_asignacionkit ak
  on dk.idAsignacion = ak.idAsignacion
  where ak.idPersona = idPersona;
end !


CREATE PROCEDURE `spCambiarEstadoCitaCancelar`(IN `$idCita` INT)
BEGIN
  UPDATE tbl_cita SET estadoTablaCita='Cancelada' WHERE idCita= $idCita;
END !


CREATE PROCEDURE `spContarCodigoDiagnostico`(IN filtro VARCHAR(45))
begin
  select count(idCIE10) as cont from tbl_cie10 where codigoCIE10 LIKE concat('%',filtro,'%');
end !


CREATE PROCEDURE `spRegistrarTipoorigenatencionOtro`(IN descripcion VARCHAR(100))
begin
  insert into tbl_tipoorigenatencion(descripcionOrigenAtencion,estadoTabla)
  values(descripcion,'Inactivo');
end !


CREATE PROCEDURE `spUltimoDatoOrigenAtencion`()
begin
  select MAX(idTipoOrigenAtencion) as id from tbl_tipoorigenatencion;
end !


CREATE PROCEDURE `spUltimoIdHistoriaClinica`()
begin
  select max(idHistoriaClinica) as id from tbl_historiaclinica;
end !


CREATE  PROCEDURE `spRegistrarSignosVitales`(IN resultado DOUBLE,IN hora TIME,IN idValoracion INT(11), IN idHistoriaClinica INT(11))
begin
  insert into tbl_signosvitales(resultado,hora,idValoracion,idHistoriaClinica)
  values(resultado,hora,idValoracion,idHistoriaClinica);
end !


CREATE PROCEDURE `spUltimoIdTratamiento`()
begin
  select MAX(idTratamiento) as id from tbl_tratamientodmc;
end !


CREATE PROCEDURE `spRegistrarDetalletratamientodmcrecurso`(IN $idRecurso INT(11), IN $idTratamiento int(11))
BEGIN
  INSERT INTO `tbl_detalletratamientodmcrecurso`(`idRecurso`, `idTratamiento`) VALUES ($idRecurso, $idTratamiento);
END !


CREATE PROCEDURE `spUltimoIdTipoEspecializado`()
begin
  select MAX(idTipoExamenEspecializado) as id from tbl_tipoexamenespecializado;
end !


CREATE PROCEDURE `spRegistrarNotaenfermeria`(IN $descripcion varchar(200), IN $idPersona INT(11), IN $idProcedimiento INT(11))
BEGIN
    INSERT INTO `tbl_notaenfermeria`(`descripcion`, `idPersona`, `idProcedimiento`) VALUES ($descripcion, $idPersona, $idProcedimiento);
END !


CREATE  PROCEDURE `spConsultarPersonaAtencion`(IN `$idAtencion` INT)
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
END !


CREATE PROCEDURE `spConsultarPacienteAtencion`(IN `$idPaciente` INT)
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
END !


CREATE PROCEDURE `spCambiarCitaProceso`(IN `$idCita` INT)
BEGIN
  UPDATE tbl_cita SET estadoTablaCita='Proceso' WHERE idCita=$idCita;
END !


CREATE PROCEDURE `spConsultarFechaAtencion`( IN `$idAtencion` INT )
BEGIN
 SELECT fechaAtencion FROM `tbl_historiaclinica` WHERE idHistoriaClinica = $idAtencion;
END !


CREATE PROCEDURE spModificarPaciente (
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
 END !


CREATE PROCEDURE `SpConsultarInformeCita`(IN `$idCita` INT)
BEGIN
  SELECT distinct CONCAT(pe.primerNombre,' ',pe.primerApellido) AS NombrePersona,ro.descripcionRol FROM tbl_cita ci INNER JOIN tbl_cita_programacion tcp ON $idCita=tcp.idCita INNER JOIN tbl_turnoprogramacion ttp ON tcp.idTurnoProgramacion=ttp.idTurnoProgramacion INNER JOIN tbl_persona pe ON ttp.idPersona=pe.idPersona INNER JOIN tbl_cuentausuario tcu ON pe.idPersona=tcu.idPersona INNER JOIN tbl_rol ro ON tcu.idRol =ro.idRol
  WHERE ro.descripcionRol like 'Medico' or ro.descripcionRol like 'Enfermera Jefe' or ro.descripcionRol like 'Auxiliar de Enfermeria';
END !


CREATE PROCEDURE `spConsultarPersonalAsistencial`(IN `$idCita` INT)
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
END !


CREATE PROCEDURE `spAsignarMora`(IN `$idPaciente` INT)
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
END !


CREATE PROCEDURE `spCancelarCita`(IN `$idCita` INT)
BEGIN
  update tbl_cita set estadoTablaCita = 'Cancelada' where idCita = $idCita;
END !


CREATE PROCEDURE `spConsultarDiasMora`(IN `$idPaciente` INT)
BEGIN
 select tm.diasMulta, thm.fechaHistorial
 from tbl_multa tm inner join tbl_historialmora thm on thm.idMulta = tm.idMulta inner join tbl_cita tc on tc.idCita = thm.idCita inner join tbl_paciente tp on tp.idPaciente = tc.idPaciente where tp.idPaciente = $idPaciente;
END !


CREATE PROCEDURE `spCancelarCitaRegistrarMora`(IN `$fecha` DATE, IN `$descripcion` VARCHAR(45), IN `$idCita` INT)
BEGIN
 insert into tbl_historialmora(fechaHistorial,`descripcionHistorial`,`idCita`,`idMulta`) values($fecha,$descripcion,$idCita,(select max(idMulta) from tbl_multa where estadoTabla = 'Activo'));
END !


CREATE PROCEDURE `spConsultaDesProcedi`(IN `$filtro` VARCHAR(1000))
BEGIN
  select tbl_cup.idCup as id, tbl_cup.nombreCup
  from tbl_cup where tbl_cup.nombreCUP LIKE CONCAT('%',CONCAT($filtro, '%')) and
  idTipoCup = ( select tbl_tipocup.idTipoCup from tbl_tipocup where tbl_tipocup.descripcionCUP like 'Citas' ) or
  idTipoCup = (select tbl_tipocup.idTipoCup from tbl_tipocup where tbl_tipocup.descripcionCUP like 'Otro');
end !


CREATE PROCEDURE `spConsultaDesIdProce`(IN `$id` INT)
BEGIN
  select nombreCup from tbl_cup where idCup = $id;
END !


CREATE PROCEDURE `spConsultarCodIdProce`(IN `$id` INT)
BEGIN
  select codigoCup from tbl_cup where idCup = $id;
END !


CREATE PROCEDURE `spContarDescripProce`(IN `$filtro` VARCHAR(1000))
BEGIN
 select count(idCup) ascont from tbl_cup where nombreCup LIKE CONCAT('%',CONCAT($filtro, '%'));
END !


CREATE PROCEDURE `spConsultarCodProcedi` (IN `$filtro` VARCHAR(1000))
BEGIN
  select idCup as id,codigoCup from tbl_cup
  where idTipoCup = (select idTipoCup from tbl_tipocup where descripcionCUP like 'Citas' )
  or idTipoCup = (select idTipoCup from tbl_tipocup where descripcionCUP like 'Otro' )
  and codigoCup LIKE CONCAT('%',CONCAT($filtro, '%'));
END !


CREATE PROCEDURE `spContarCodProcedimi`(IN `$filtro` VARCHAR(1000))
BEGIN
 select count(idCup) ascont from tbl_cup where codigoCup LIKE CONCAT('%',CONCAT($filtro, '%'));
END !


CREATE PROCEDURE spConsultarClaveUsuario(
  $Usuario varchar(45)
)
BEGIN
  SELECT TC.idUsuario,TC.clave,TR.descripcionRol FROM tbl_cuentausuario TC
  INNER JOIN tbl_rol TR
  ON TR.idRol = TC.idRol
  WHERE usuario = $Usuario;
END !


CREATE PROCEDURE spConsultarPerfil(
  $idUsuario INT
)
BEGIN
  SELECT p.idPersona, p.urlFoto,
  p.primerNombre, p.segundoNombre, p.primerApellido,     p.segundoApellido,p.idTipoDocumento, p.numeroDocumento,   p.fechaNacimiento, p.sexo, p.direccion, p.telefono,   p.correoElectronico, p.ciudad, p.departamento, p.pais, cu.usuario
  FROM
  tbl_persona p INNER JOIN tbl_cuentausuario cu
  ON p.idPersona = cu.idPersona
  WHERE cu.idUsuario = $idUsuario;
END !


CREATE PROCEDURE spModificarPerfil(
$idPersona INT, $primerNombre VARCHAR(50), $segundoNombre VARCHAR(50), $primerApellido VARCHAR(50),
$segundoApellido VARCHAR(50), $idTipoDocumento INT, $numeroDocumento VARCHAR(20), $fechaNacimiento DATE,
$sexo VARCHAR(45), $direccion VARCHAR(45), $telefono VARCHAR(45), $correoElectronico VARCHAR(45), $ciudad VARCHAR(45), $departamento VARCHAR(45), $pais VARCHAR(45), $urlFoto VARCHAR(250)
)
BEGIN
    UPDATE `tbl_persona` SET `primerNombre` = $primerNombre, `segundoNombre` = $segundoNombre, `primerApellido` = $primerApellido, `segundoApellido` = $segundoApellido, `idTipoDocumento` = $idTipoDocumento, `numeroDocumento` = $numeroDocumento, `fechaNacimiento` = $fechaNacimiento, `sexo` = $sexo, `direccion` = $direccion, `telefono` = $telefono, `correoElectronico` = $correoElectronico, `ciudad` = $ciudad, `departamento` = $departamento, `pais` = $pais, `urlFoto` = $urlFoto WHERE `idPersona` = $idPersona;
END !


CREATE PROCEDURE `spConsultarPacienteDomiciliaria` (IN `$idPaciente` INT)
BEGIN
  select * from tbl_paciente where idPaciente = $idPaciente;
END !


CREATE PROCEDURE `spConsultarEmailPaciente` (IN $idPaciente INT)
BEGIN
  select correoElectronico from tbl_paciente where idPaciente = $idPaciente;
END !


CREATE PROCEDURE `spConsultarAllPersonas`(IN `$numeroDocumento` VARCHAR(45))
BEGIN
  SELECT * FROM tbl_persona
  INNER JOIN tbl_cuentausuario
  ON tbl_persona.idPersona = tbl_cuentausuario.idPersona
  INNER JOIN tbl_rol
  ON tbl_rol.idRol = tbl_cuentausuario.idRol
  WHERE `numeroDocumento` = $numeroDocumento and descripcionRol <> 'Medico Externo';
END !


CREATE PROCEDURE `spRegistrarInterconsulta`(IN descripcionInterconsulta TEXT,IN  especialidad VARCHAR(100),IN idHistoriaClinica INT(11),IN fechaLimite DATE)
begin
  insert into tbl_interconsulta(descripcionInterconsulta,especialidad,idHistoriaClinica,fechaLimite) values(descripcionInterconsulta,especialidad,idHistoriaClinica,fechaLimite);
end !


CREATE FUNCTION fnCambiarDisponibilidad(`$idAmbulancia` INT)
RETURNS INT
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
END !


CREATE PROCEDURE spListarRoles()
BEGIN
  SELECT * FROM `tbl_rol`;
END !


CREATE PROCEDURE `spListarCiudad`()
BEGIN
  SELECT tbl_ciudad.idCiudad, tbl_ciudad.nombreCiudad FROM tbl_ciudad;
END !


CREATE PROCEDURE `spListarDepartamento`()
BEGIN
  SELECT tbl_departamento.idDepartamento, tbl_departamento.nombreDepartamento FROMtbl_departamento;
END !


CREATE PROCEDURE `spConsultarProgramacionCitaCalen`()
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
END !


CREATE PROCEDURE `spActualizarCantidadRecurso`(
    IN _cantidad INT(11),
    IN _idDetalleKit INT(11)
)
begin
UPDATE tbl_recurso recu,

      (SELECT re.cantidadRecurso +_cantidad AS nuevaCantidad,tbl_detallekit.idRecurso FROM tbl_detallekit
       INNER JOIN tbl_recurso re  ON tbl_detallekit.idrecurso = re.idrecurso
       WHERE idDetallekit = _idDetalleKit) AS dt2 SET recu.cantidadRecurso = dt2.nuevaCantidad

  WHERE recu.idrecurso = dt2.idRecurso;
END !


CREATE PROCEDURE spConsultarPersonatodo(IN $idPersona INT)
BEGIN
  SELECT  pe.primerNombre ,pe.segundoNombre, pe.primerApellido,pe.segundoApellido,pe.telefono,pe.direccion,pe.numeroDocumento,pe.sexo,pe.lugarNacimiento,pe.fechaNacimiento,pe.ciudad,pe.departamento,pe.correoElectronico,pe.estadotablaPersona,pe.pais,pe.grupoSanguineo,r.descripcionRol,pe.dependencia from tbl_persona pe inner join tbl_cuentausuario c on pe.idPersona = c.idPersona inner join tbl_rol r on r.idRol = c.idRol
  where pe.idPersona = $idPersona;
END !


CREATE PROCEDURE spTraerIDDespacho(IN $idPersona INT(11))
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
END !


CREATE PROCEDURE spModificarPersona(IN $idPersona INT,
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
END !


CREATE PROCEDURE spListarPersona()
BEGIN
SELECT * FROM tbl_persona as pn
where pn.estadoTablaPersona like 'Activo';
END !


create procedure spvalidacionnombreasignacion(
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
END !


  CREATE PROCEDURE spEliminarPermiso(
      _idRol INT,
      _idVista INT
  )
  BEGIN
  DELETE FROM tbl_rolmodulovista
  WHERE idRol = _idRol AND idVista = _idVista;
  END !


DELIMITER ;

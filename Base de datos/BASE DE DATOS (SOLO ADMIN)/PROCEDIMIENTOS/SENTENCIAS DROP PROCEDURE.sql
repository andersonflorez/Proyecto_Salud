-- LAS SIGUIENTES SENTENCIAS ELIMINAN TODOS LOS PROCEDIMIENTOS ALMACENADOS MODIFICADOS DE LA BD:
USE `bd_proyecto_salud`;
DROP PROCEDURE IF EXISTS spDetalleKit;
DROP PROCEDURE IF EXISTS spRegistrarEnteexterno;
DROP PROCEDURE IF EXISTS spRegistrarTipoevento;
DROP PROCEDURE IF EXISTS spRegistrarVistoChat;
DROP PROCEDURE IF EXISTS spConsultarMensajeNotificacion;
DROP PROCEDURE IF EXISTS spConsultarNotificacionesChat;
DROP PROCEDURE IF EXISTS spRegistrarMensaje;
DROP PROCEDURE IF EXISTS spRegistrarChat;
DROP PROCEDURE IF EXISTS spConsultarChatsUsuario;
DROP PROCEDURE IF EXISTS spValidarChatActivo;
DROP PROCEDURE IF EXISTS spConsultarMensaje;
DROP PROCEDURE IF EXISTS spConsultarMensajesChat;
DROP PROCEDURE IF EXISTS spCambiarEstadoChat;
DROP PROCEDURE IF EXISTS spConsultarReceptorInicial;
DROP PROCEDURE IF EXISTS spConsultarUsuarioExterno;
DROP PROCEDURE IF EXISTS spRegistrarReporteinicial;
DROP PROCEDURE IF EXISTS spRegistrarDespacho;
DROP VIEW IF EXISTS viewAsignaciones;
DROP VIEW IF EXISTS viewListarReporteInicial;
DROP PROCEDURE IF EXISTS spConsultarAsignacionAmbulancia;
DROP PROCEDURE IF EXISTS spModificarAsignacion;
DROP PROCEDURE  IF EXISTS spModificarDetalleAsignacion;
DROP PROCEDURE IF EXISTS spConsultarAsignaciones;
DROP VIEW IF EXISTS viewPersonalAmbulancia;
DROP VIEW IF EXISTS viewAmbulanciasDisponibles;
DROP PROCEDURE IF EXISTS spListarAsignacionkit;
DROP PROCEDURE IF EXISTS spListarDevolucion;
DROP PROCEDURE IF EXISTS spListarNovedadrecurso;
DROP PROCEDURE IF EXISTS spListarReporteinicial;
DROP PROCEDURE IF EXISTS spCitasAgendadas;
DROP PROCEDURE IF EXISTS spConsultarAgenda;
DROP PROCEDURE IF EXISTS spConsultarAgendaActual;
DROP PROCEDURE IF EXISTS spListarPersonaProgramacion;
DROP PROCEDURE IF EXISTS spConsultarPersonaProgramacion;
DROP PROCEDURE IF EXISTS SpAsignarMoraPaciente;
DROP PROCEDURE IF EXISTS spConsultarCitaInner;
DROP PROCEDURE IF EXISTS spListarCitaInnerJoin;
DROP PROCEDURE IF EXISTS spListarPacienteInnerJ;
DROP PROCEDURE IF EXISTS spListarAfectadoaccidentetransito;
DROP PROCEDURE IF EXISTS spListarTipoaseguramiento;
DROP PROCEDURE IF EXISTS spConsultarIdAmbulancia;
DROP PROCEDURE IF EXISTS spListarMedicamentoAmbulancia;
DROP PROCEDURE IF EXISTS spListarEstandarkit;
DROP PROCEDURE IF EXISTS spListarRecurso;
DROP PROCEDURE IF EXISTS spValidarDocumentoPersona;
DROP PROCEDURE IF EXISTS spConsultarModuloVista;
DROP PROCEDURE IF EXISTS spConsultarModuloRol;
DROP PROCEDURE IF EXISTS spValidarRolModuloVista;
DROP PROCEDURE IF EXISTS spValidarRol;
DROP PROCEDURE IF EXISTS spValidarUsuario;
DROP PROCEDURE IF EXISTS spCancelarReporteInicial;
DROP PROCEDURE IF EXISTS spConsultarAmbulanciaEstado;
DROP PROCEDURE IF EXISTS spListarTratamientoB;
DROP PROCEDURE IF EXISTS spListarTratamientoA;
DROP PROCEDURE IF EXISTS spJoinLesionesCie10;
DROP PROCEDURE IF EXISTS spFiltrarPuntosLesiones;
DROP FUNCTION IF EXISTS fnRegistrarPuntolesion;
DROP PROCEDURE IF EXISTS spUltimoPaciente;
DROP PROCEDURE IF EXISTS spSeleccionarUltimoid;
DROP PROCEDURE IF EXISTS SpContarNotificacionesDespacho;
DROP PROCEDURE IF EXISTS SpDescripcionNotificacionesDespacho;
DROP PROCEDURE IF EXISTS spModificarPacienteAPH;
DROP FUNCTION IF EXISTS fnContarNovedadesReporte;
DROP PROCEDURE IF EXISTS spConsultarEnteexterno_reporteinicial;
DROP PROCEDURE IF EXISTS spRegistrarNovedadreporteinicial;
DROP PROCEDURE IF EXISTS spConsultarNovedadreporteinicial;
DROP PROCEDURE IF EXISTS spConsultarTipoevento_reporteinicial;
DROP FUNCTION IF EXISTS fnUltimoReporteInicial;
DROP FUNCTION IF EXISTS fnContarReportesIniciales;
DROP PROCEDURE IF EXISTS spListarInfomacionAutorizacion;
DROP PROCEDURE IF EXISTS spRegistrarEvaluacionAutorizacion;
DROP PROCEDURE IF EXISTS spConsultarAutorizacionTemporal;
DROP PROCEDURE IF EXISTS spListarInformacionAutorizacion;
DROP PROCEDURE IF EXISTS spListarInformacionAutorizacionPaginador;
DROP PROCEDURE IF EXISTS spListarCIE10Cuerpo;
DROP FUNCTION IF EXISTS fnCancelarEmergencia;
DROP FUNCTION IF EXISTS fnPedirAyuda;
DROP PROCEDURE IF EXISTS spConfirmarLlegada;
DROP PROCEDURE IF EXISTS spRegistrarNovedadRinicial;
DROP PROCEDURE IF EXISTS spRegistrarEnteexterno_reporteinicial;
DROP PROCEDURE IF EXISTS spRegistrarTipoevento_reporteinicial;
DROP PROCEDURE IF EXISTS spListarTipoevento;
DROP PROCEDURE IF EXISTS spListarEnteexterno;
DROP PROCEDURE IF EXISTS spModificarAcompanante;
DROP PROCEDURE IF EXISTS spConsultarPacienteAcompanante;
DROP PROCEDURE IF EXISTS spListarTemporalautorizacion;
DROP PROCEDURE IF EXISTS spListarAmbulanciaDisponible;
DROP PROCEDURE IF EXISTS spListarPersonalAmbulancia;
DROP PROCEDURE IF EXISTS spConsultaPersonaPro;
DROP PROCEDURE IF EXISTS spPagination;
DROP PROCEDURE IF EXISTS spFilterPagination;
DROP FUNCTION IF EXISTS SPLIT_STRING;
DROP PROCEDURE IF EXISTS SpConsultarGeolocalizacion;
DROP PROCEDURE IF EXISTS SpConsultarDespachoAPH;
DROP PROCEDURE IF EXISTS SpConsultarReporteInicialAPH;
DROP PROCEDURE IF EXISTS spTraerProximoIdReporteAPH;
DROP PROCEDURE IF EXISTS spEliminarTipoEventoConfirmacion;
DROP PROCEDURE IF EXISTS spUltimoIDmotivoConsulta;
DROP PROCEDURE IF EXISTS spRegistrarMotivoconsulta;
DROP PROCEDURE IF EXISTS spListarMotivoconsulta;
DROP PROCEDURE IF EXISTS spRegistrarExamenfisicoaph;
DROP PROCEDURE IF EXISTS spListarTipodocumento;
DROP PROCEDURE IF EXISTS spListarZona;
DROP PROCEDURE IF EXISTS spListarTipozona;
DROP PROCEDURE IF EXISTS spConsultarZona;
DROP PROCEDURE IF EXISTS spConsultarHorario;
DROP PROCEDURE IF EXISTS spConfirmacionDatos;
DROP PROCEDURE IF EXISTS spRegistrarCita;
DROP PROCEDURE IF EXISTS spConsultaIdProgram;
DROP PROCEDURE IF EXISTS spConsultaIdCita;
DROP PROCEDURE IF EXISTS spConsultaMedicos;
DROP PROCEDURE IF EXISTS spConsultaMedicosEspecial;
DROP PROCEDURE IF EXISTS spConsultaNombresMedic;
DROP PROCEDURE IF EXISTS spConsultaEnfermerosJefe;
DROP PROCEDURE IF EXISTS spConsultaNombresEnfermerosJefe;
DROP PROCEDURE IF EXISTS spConsultaAuxEnfermeria;
DROP PROCEDURE IF EXISTS spConsultaNombresAuxEnfermeria;
DROP PROCEDURE IF EXISTS spRegistrarDetalleCita;
DROP PROCEDURE IF EXISTS spConsultaCitasMes;
DROP PROCEDURE IF EXISTS spConsultaCitasDia;
DROP PROCEDURE IF EXISTS spConsultaConfiguracionCita;
DROP PROCEDURE IF EXISTS spValidarMedico;
DROP PROCEDURE IF EXISTS spUltimaPersona;
DROP PROCEDURE IF EXISTS spConsultarPacienteDocumento;
DROP PROCEDURE IF EXISTS spConsultarAcompanante;
DROP PROCEDURE IF EXISTS spPersonalReporteAPH;
DROP PROCEDURE IF EXISTS spConsultarReporteAPH;
DROP PROCEDURE IF EXISTS spConsultarTratamientosAPH;
DROP PROCEDURE IF EXISTS spConsultarDesfibrilacionAPH;
DROP PROCEDURE IF EXISTS spConsultarAntecedentesAPH;
DROP PROCEDURE IF EXISTS spConsultarMotivoConsultaAPH;
DROP PROCEDURE IF EXISTS spConsultarTestigoAPH;
DROP PROCEDURE IF EXISTS spConsultarMedicamentosAPH;
DROP PROCEDURE IF EXISTS spConsultarViaComunicacionAPH;
DROP PROCEDURE IF EXISTS spRegistrarReporteaph;
DROP PROCEDURE IF EXISTS spRegistrarEvaluacionAutorizacion;
DROP PROCEDURE IF EXISTS spConsultaridEspecialidad;
DROP PROCEDURE IF EXISTS spActualizarEstadoPersona;
DROP PROCEDURE IF EXISTS spModificarPacienteCita;
DROP PROCEDURE IF EXISTS spListarRecursoKit;
DROP PROCEDURE IF EXISTS spListarCantidadRecurso;
DROP PROCEDURE IF EXISTS spConsultarProgramacion;
DROP PROCEDURE IF EXISTS spConsultarprogramacionconturno;
DROP PROCEDURE IF EXISTS spConsultaProgramacionDias;
DROP PROCEDURE IF EXISTS spCosnultarAsignacionAmbulancia;
DROP PROCEDURE IF EXISTS spListarTipoorigenatencion;
DROP PROCEDURE IF EXISTS spListarTipotratamiento;
DROP PROCEDURE IF EXISTS spListarTipoexamenespecializado;
DROP PROCEDURE IF EXISTS spConsultarAtencionOrigenDmc;
DROP PROCEDURE IF EXISTS spConsultarHistoriaClinic;
DROP PROCEDURE IF EXISTS spConsultarAtencionDmc;
DROP PROCEDURE IF EXISTS spConsultarProcedimientosDmc;
DROP PROCEDURE IF EXISTS spConsultarAntecedentesDmc;
DROP PROCEDURE IF EXISTS spConsultarExamenesfisicoDmc;
DROP PROCEDURE IF EXISTS spConsultarDiagnosticoDmc;
DROP PROCEDURE IF EXISTS spConsultarIdPacienteDmc;
DROP PROCEDURE IF EXISTS spConsultarIdHistoriaClinicaDmc;
DROP PROCEDURE IF EXISTS spRegistrarTemporalautorizacion;
DROP PROCEDURE IF EXISTS SpActualizarEstadoTemporal;
DROP PROCEDURE IF EXISTS spUltimoAcompanante;
DROP PROCEDURE IF EXISTS spConsultarDatosNotificacion;
DROP PROCEDURE IF EXISTS spConsultarRespuestaNotificacionTemporal;
DROP VIEW IF EXISTS `viewconsultaratencion`;
DROP VIEW IF EXISTS `viewconsultarcitamedico`;
DROP VIEW IF EXISTS `viewdatosbasicospacientes`;
DROP procedure IF EXISTS `spPaginacionHC`;
DROP procedure IF EXISTS `spConsultarPaciente`;
DROP PROCEDURE IF EXISTS spCambiarEstadoCitaCancelada;
DROP PROCEDURE IF EXISTS spCambiarEstadoCitaProceso;
DROP PROCEDURE IF EXISTS spConsultarCitaPersona;
DROP PROCEDURE IF EXISTS spRegistrarHistorialmora;
DROP PROCEDURE IF EXISTS spRegistrarCodigoReestablecer;
DROP PROCEDURE IF EXISTS spValidarCorreoElectronico;
DROP PROCEDURE IF EXISTS spRegistrarCup3;
DROP PROCEDURE IF EXISTS spCambiarEstadoPaciente;
DROP PROCEDURE IF EXISTS spEstadoPaciCIta;
DROP PROCEDURE IF EXISTS spConsultarMedicacionDmc;
DROP PROCEDURE IF EXISTS spConsultarProcedimientoDmc;
DROP PROCEDURE IF EXISTS spConsultarPacienteIdDmc;
DROP PROCEDURE IF EXISTS spConsultarHoraSignosVitales;
DROP PROCEDURE IF EXISTS spConsultarResultadosSignosVitales;
DROP PROCEDURE IF EXISTS spRegistarNotasEnfermeria;
DROP PROCEDURE IF EXISTS spConsultarProcedimientosNotas;
DROP PROCEDURE IF EXISTS spconsultarDescripcionProcedimiento;
DROP PROCEDURE IF EXISTS spConsultarDescripcionIdProcedimiento;
DROP PROCEDURE IF EXISTS spConsultarCodigoIdProcedimiento;
DROP PROCEDURE IF EXISTS spContarDescripcionProcedimiento;
DROP PROCEDURE IF EXISTS spConsultarCodigoProcedimientos;
DROP PROCEDURE IF EXISTS spContarCodigoProcedimiento;
DROP PROCEDURE IF EXISTS spConsultarDescripcionIdDiagnostico;
DROP PROCEDURE IF EXISTS spConsultarCodigoIdDiagnostico;
DROP PROCEDURE IF EXISTS spConsultarDescripcionDiagnostico;
DROP PROCEDURE IF EXISTS spContarDiagnostico;
DROP PROCEDURE IF EXISTS spConsultarCodigoDiagnostico;
DROP PROCEDURE IF EXISTS spContarCodigoDiagnostico;
DROP PROCEDURE IF EXISTS spActualizarInformacionPersonal;
DROP PROCEDURE IF EXISTS spRegistrarHistoriaClinicaDmc;
DROP PROCEDURE IF EXISTS spRegistrarAntecedentesDmc;
DROP PROCEDURE IF EXISTS spRegistrarExamenFisico;
DROP PROCEDURE IF EXISTS spRegistrarDiagnostico;
DROP PROCEDURE IF EXISTS spRegistrarProcedimiento;
DROP PROCEDURE IF EXISTS spRegistrarSignosVitales;
DROP PROCEDURE IF EXISTS spRegistrarMedicacionDmc;
DROP PROCEDURE IF EXISTS spActualizarMedicacionDmc;
DROP PROCEDURE IF EXISTS spRegistrarTTratamiento;
DROP PROCEDURE IF EXISTS spRegistrarTratamiento;
DROP PROCEDURE IF EXISTS spRegistrarDetalleTratamientoEquipoBiomedico;
DROP PROCEDURE IF EXISTS spRegistrarDetalleTratamientoRecurso;
DROP PROCEDURE IF EXISTS spRegistrarFormulaMedica;
DROP PROCEDURE IF EXISTS spRegistrarFormulaMedicamento;
DROP PROCEDURE IF EXISTS spRegistrarTExamenesEspecializados;
DROP PROCEDURE IF EXISTS spRegistrarExameneEspecializado;
DROP PROCEDURE IF EXISTS spRegistrarInterconsulta;
DROP PROCEDURE IF EXISTS spRegistrarIncapacidad;
DROP PROCEDURE IF EXISTS spRegistrarOtroDmc;
DROP PROCEDURE IF EXISTS spCambiarEstadoCita;
DROP PROCEDURE IF EXISTS spConsultarcitasprogramadas;
DROP PROCEDURE IF EXISTS spConsultarTurnoActivo;
DROP PROCEDURE IF EXISTS spConsultarProgramacion;
DROP PROCEDURE IF EXISTS spConsultarprogramacionconturno;
DROP PROCEDURE IF EXISTS spConsultacitasU;
DROP PROCEDURE IF EXISTS spConsultaProgramacionDias;
DROP PROCEDURE IF EXISTS consultarPersonatodo;
DROP PROCEDURE IF EXISTS spConsultarTurnosP;
DROP PROCEDURE IF EXISTS spConsultarpersonaconespecialidad;
DROP PROCEDURE IF EXISTS spListarTemporalautorizacion;
DROP PROCEDURE IF EXISTS spRegistrarTipoAseguramientoHC;
DROP PROCEDURE IF EXISTS spUniqueDespachoReporteaph;
DROP PROCEDURE IF EXISTS spRegistrarTipoEvento_reporteinicialAPH;
DROP PROCEDURE IF EXISTS spConsultaPersonaCorreo;
DROP PROCEDURE IF EXISTS spValidarCorreoPersona;
DROP PROCEDURE IF EXISTS spConsultaPersonaUsuario;
DROP PROCEDURE IF EXISTS spValidarUsuarioPersona;
DROP PROCEDURE IF EXISTS spConsultarMedicoExterno;
DROP FUNCTION  IF EXISTS fnFinalizarReporteInicial;
DROP PROCEDURE  IF EXISTS spRegistrarTipoOrigenAtencion;
DROP PROCEDURE  IF EXISTS spRegistrarTemporalautorizacionMedicamento;
DROP PROCEDURE  IF EXISTS spListarTemporalautorizacionMedicamento;
DROP PROCEDURE  IF EXISTS spRegistrarAllAutorizacionMedicamento;
DROP PROCEDURE  IF EXISTS spRegistrarAllAutorizacionTratamiento;
DROP PROCEDURE  IF EXISTS listarAllAutorizacion;
DROP PROCEDURE  IF EXISTS spValidarTipoAmbulancia;
DROP PROCEDURE  IF EXISTS spAutenticarMedico;
DROP PROCEDURE  IF EXISTS spRegistrarAutorizacionMedicalizada;
DROP PROCEDURE  IF EXISTS spListarNovedadReporte;
DROP PROCEDURE  IF EXISTS spActualizarEstadoNovedadReporte;
DROP PROCEDURE  IF EXISTS spInfoReporteDespacho;
DROP PROCEDURE  IF EXISTS spListarDespacho;
DROP PROCEDURE  IF EXISTS spRegistrarDetalleasignacion;
DROP PROCEDURE  IF EXISTS spSeleccionarUltimoIdAsignacion;
DROP PROCEDURE  IF EXISTS spRegistrarAsignacionpersonal;
DROP PROCEDURE  IF EXISTS spConsultarTipoAmbulancia;
DROP PROCEDURE  IF EXISTS spModificarAsignacionpersonal;
DROP PROCEDURE  IF EXISTS spConfirmarAsignacion;
DROP PROCEDURE IF EXISTS spModificarPacienteD;
DROP PROCEDURE IF EXISTS spHistorialCitas;
DROP PROCEDURE IF EXISTS SpConsultarInformeCita;
DROP PROCEDURE IF EXISTS spListarConfiguracionCup;
DROP PROCEDURE IF EXISTS spConfiguracionAsignada;
DROP PROCEDURE IF EXISTS spCitasAsignadas;
DROP PROCEDURE IF EXISTS spFinalizacionMulta;
DROP PROCEDURE IF EXISTS spModificarCupConfiguracion;
DROP PROCEDURE IF EXISTS spConsultarEspecialidadPersona;
DROP PROCEDURE IF EXISTS spConsultarPersonaDocumento;
DROP PROCEDURE IF EXISTS spConsultaBasicadelTratamiento;
DROP PROCEDURE IF EXISTS spConsultaBasicaTratamiento;
DROP PROCEDURE IF EXISTS spRegistrarPermiso;
DROP PROCEDURE IF EXISTS spConsultarUsuario;
DROP PROCEDURE IF EXISTS spValidarUrl;
DROP PROCEDURE IF EXISTS spConcultaPermisoAsignado;
DROP PROCEDURE IF EXISTS spConsultaParametrizadaAsignacionAmbulancia;
DROP PROCEDURE IF EXISTS spListarMedico;
DROP PROCEDURE IF EXISTS spTraerIdNovedadrecurso;
DROP PROCEDURE IF EXISTS spListarRol;
DROP PROCEDURE IF EXISTS spSugerenciaEnfermerosJefe;
DROP PROCEDURE IF EXISTS spSugerenciaAuxiliarEnfermeria;
DROP PROCEDURE IF EXISTS spIdPersona;
DROP PROCEDURE IF EXISTS spConsultaPersonaD;
DROP PROCEDURE IF EXISTS spConsultarHistorialP;
DROP PROCEDURE IF EXISTS spConsultarTurnosHP;
DROP PROCEDURE IF EXISTS spTraerprogramacionesvencidas;
DROP PROCEDURE IF EXISTS spConsultarCorreoPersonaP;
DROP PROCEDURE IF EXISTS spCambiarEstadoProgramacion;
DROP PROCEDURE IF EXISTS spConsultarDescripcionCUPcita;
DROP PROCEDURE IF EXISTS spConsultarDescripcionIdCUPcita;
DROP PROCEDURE IF EXISTS spConsultarCodigoIdCUPCita;
DROP PROCEDURE IF EXISTS spContarDescripcionCUPcita;
DROP PROCEDURE IF EXISTS spConsultarCodigoCUPcita;
DROP PROCEDURE IF EXISTS spContarCodigoCUPcita;
DROP PROCEDURE IF EXISTS spActualizarEstadoDetalleAsignacion;
DROP PROCEDURE IF EXISTS spListartblDetallekit;
DROP PROCEDURE IF EXISTS splistaCompletaRecursoEstandar;
DROP PROCEDURE IF EXISTS splistarComboRecursokit;
DROP PROCEDURE IF EXISTS spListarEquipoBiomedicoDmc;
DROP PROCEDURE IF EXISTS spListarMedicamentoDmc;
DROP PROCEDURE IF EXISTS spUltimoIdTTratamiento;
DROP PROCEDURE IF EXISTS spListarMedicacion;
DROP PROCEDURE IF EXISTS spCambiarEstadoCitaCancelar;
DROP PROCEDURE IF EXISTS spRegistrarTipoorigenatencionOtro;
DROP PROCEDURE IF EXISTS spUltimoDatoOrigenAtencion;
DROP PROCEDURE IF EXISTS spUltimoIdHistoriaClinica;
DROP PROCEDURE IF EXISTS spUltimoIdTratamiento;
DROP PROCEDURE IF EXISTS spRegistrarDetalletratamientodmcrecurso;
DROP PROCEDURE IF EXISTS spUltimoIdFormula;
DROP PROCEDURE IF EXISTS spUltimoIdTipoEspecializado;
DROP PROCEDURE IF EXISTS spRegistrarNotaenfermeria;
DROP PROCEDURE IF EXISTS spConsultarPersonaAtencion;
DROP PROCEDURE IF EXISTS spConsultarPacienteAtencion;
DROP PROCEDURE IF EXISTS spCambiarCitaProceso;
DROP PROCEDURE IF EXISTS spConsultarFechaAtencion;
DROP PROCEDURE IF EXISTS spModificarPaciente;
DROP PROCEDURE IF EXISTS spConsultarPersonalAsistencial;
DROP PROCEDURE IF EXISTS spAsignarMora;
DROP PROCEDURE IF EXISTS spCancelarCita;
DROP PROCEDURE IF EXISTS spConsultarDiasMora;
DROP PROCEDURE IF EXISTS spCancelarCitaRegistrarMora;
DROP PROCEDURE IF EXISTS spConsultaDesProcedi;
DROP PROCEDURE IF EXISTS spConsultarCodIdProce;
DROP PROCEDURE IF EXISTS spContarDescripProce;
DROP PROCEDURE IF EXISTS spConsultarCodProcedi;
DROP PROCEDURE IF EXISTS spContarCodProcedimi;
DROP PROCEDURE IF EXISTS spConsultarClaveUsuario;
DROP PROCEDURE IF EXISTS spConsultarPerfil;
DROP PROCEDURE IF EXISTS spModificarPerfil;
DROP PROCEDURE IF EXISTS spConsultaDesIdProce;
DROP PROCEDURE IF EXISTS spConsultarPacienteDomiciliaria;
DROP PROCEDURE IF EXISTS spConsultarEmailPaciente;
DROP PROCEDURE IF EXISTS spConsultarAllPersonas;
DROP PROCEDURE IF EXISTS spRegistrarInterconsulta;
DROP FUNCTION IF EXISTS fnCambiarDisponibilidad;
DROP PROCEDURE IF EXISTS spListarRoles;
DROP PROCEDURE IF EXISTS spListarCiudad;
DROP PROCEDURE IF EXISTS spListarDepartamento;
DROP PROCEDURE IF EXISTS spConsultarProgramacionCitaCalen;
DROP PROCEDURE IF EXISTS spActualizarCantidadRecurso;
DROP PROCEDURE IF EXISTS spConsultarPersonatodo;
DROP PROCEDURE IF EXISTS spTraerIDDespacho;
DROP PROCEDURE IF EXISTS spModificarPersona;
DROP PROCEDURE IF EXISTS spListarPersona;
DROP PROCEDURE IF EXISTS spvalidacionnombreasignacion;
DROP PROCEDURE IF EXISTS spEliminarPermiso;
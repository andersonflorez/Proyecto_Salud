  -- ******************************************************************************* --
  -- ************** PROCEDIMIENTOS ALMACENADOS DE bd_proyecto_salud *************** --
  -- ******************************************************************************* --

    -- # CRUD tbl_acompanante --


    -- ================== REGISTRAR ACOMPANANTE ================= --

    DROP PROCEDURE IF EXISTS spRegistrarAcompanante;
    DELIMITER !
    CREATE PROCEDURE spRegistrarAcompanante(IN $lugarExpedicionDocumentoA varchar(45), IN $parentescoA varchar(45), IN $identificacionA varchar(45), IN $nombreA varchar(45), IN $telefonoA varchar(45), IN $apellidoA varchar(45))
    BEGIN
    INSERT INTO `tbl_acompanante`(`lugarExpedicionDocumentoA`, `parentescoA`, `identificacionA`, `nombreA`, `telefonoA`, `apellidoA`) VALUES ($lugarExpedicionDocumentoA, $parentescoA, $identificacionA, $nombreA, $telefonoA, $apellidoA);
    END !
    DELIMITER ;



    -- =================== CONSULTAR ACOMPANANTE ================ --

    DROP PROCEDURE IF EXISTS spConsultarAcompanante;
    DELIMITER !
    CREATE PROCEDURE spConsultarAcompanante(IN $idAcompanante INT)
    BEGIN
    SELECT * FROM `tbl_acompanante` WHERE `idAcompanante` = $idAcompanante;
    END !
    DELIMITER ;



    -- ================== MODIFICAR ACOMPANANTE ================= --

    DROP PROCEDURE IF EXISTS spModificarAcompanante;
    DELIMITER !
    CREATE PROCEDURE spModificarAcompanante(IN $idAcompanante INT, IN $lugarExpedicionDocumentoA varchar(45), IN $parentescoA varchar(45), IN $identificacionA varchar(45), IN $nombreA varchar(45), IN $telefonoA varchar(45), IN $apellidoA varchar(45))
    BEGIN
    UPDATE `tbl_acompanante` SET `lugarExpedicionDocumentoA` = $lugarExpedicionDocumentoA, `parentescoA` = $parentescoA, `identificacionA` = $identificacionA, `nombreA` = $nombreA, `telefonoA` = $telefonoA, `apellidoA` = $apellidoA WHERE `idAcompanante` = $idAcompanante;
    END !
    DELIMITER ;



    -- ==================== LISTAR ACOMPANANTE ================== --

    DROP PROCEDURE IF EXISTS spListarAcompanante;
    DELIMITER !
    CREATE PROCEDURE spListarAcompanante()
    BEGIN
    SELECT * FROM `tbl_acompanante`;
    END !
    DELIMITER ;





    -- # CRUD tbl_afectadoaccidentetransito --


    -- ================== REGISTRAR AFECTADOACCIDENTETRANSITO ================= --

    DROP PROCEDURE IF EXISTS spRegistrarAfectadoaccidentetransito;
    DELIMITER !
    CREATE PROCEDURE spRegistrarAfectadoaccidentetransito(IN $descripcionAfectadoAccidenteTransito varchar(45), IN $estadoTabla varchar(50))
    BEGIN
    INSERT INTO `tbl_afectadoaccidentetransito`(`descripcionAfectadoAccidenteTransito`, `estadoTabla`) VALUES ($descripcionAfectadoAccidenteTransito, $estadoTabla);
    END !
    DELIMITER ;



    -- =================== CONSULTAR AFECTADOACCIDENTETRANSITO ================ --

    DROP PROCEDURE IF EXISTS spConsultarAfectadoaccidentetransito;
    DELIMITER !
    CREATE PROCEDURE spConsultarAfectadoaccidentetransito(IN $idAfectadoAccidenteTransito INT)
    BEGIN
    SELECT * FROM `tbl_afectadoaccidentetransito` WHERE `idAfectadoAccidenteTransito` = $idAfectadoAccidenteTransito;
    END !
    DELIMITER ;



    -- ================== MODIFICAR AFECTADOACCIDENTETRANSITO ================= --

    DROP PROCEDURE IF EXISTS spModificarAfectadoaccidentetransito;
    DELIMITER !
    CREATE PROCEDURE spModificarAfectadoaccidentetransito(IN $idAfectadoAccidenteTransito INT, IN $descripcionAfectadoAccidenteTransito varchar(45))
    BEGIN
    UPDATE `tbl_afectadoaccidentetransito` SET `descripcionAfectadoAccidenteTransito` = $descripcionAfectadoAccidenteTransito WHERE `idAfectadoAccidenteTransito` = $idAfectadoAccidenteTransito;
    END !
    DELIMITER ;



    -- ==================== LISTAR AFECTADOACCIDENTETRANSITO ================== --

    DROP PROCEDURE IF EXISTS spListarAfectadoaccidentetransito;
    DELIMITER !
    CREATE PROCEDURE spListarAfectadoaccidentetransito()
    BEGIN
    SELECT * FROM `tbl_afectadoaccidentetransito`;
    END !
    DELIMITER ;


      -- ================== CAMBIAR ESTADO AFECTADOACCIDENTETRANSITO ================= --

      DROP PROCEDURE IF EXISTS spCambiarEstadoAfectadoaccidentetransito;
      DELIMITER !
      CREATE PROCEDURE spCambiarEstadoAfectadoaccidentetransito(IN $idAfectadoAccidenteTransito INT, IN $estadoTabla varchar(50))
      BEGIN
      UPDATE `tbl_afectadoaccidentetransito` SET `estadoTabla` = $estadoTabla WHERE `idAfectadoAccidenteTransito` = $idAfectadoAccidenteTransito;
      END !
      DELIMITER ;



    -- # CRUD tbl_ambulancia --


    -- ================== REGISTRAR AMBULANCIA ================= --

    DROP PROCEDURE IF EXISTS spRegistrarAmbulancia;
    DELIMITER !
    CREATE PROCEDURE spRegistrarAmbulancia(IN $tipoAmbulancia varchar(45), IN $placaAmbulancia varchar(45), IN $estadoTabla varchar(45))
    BEGIN
    INSERT INTO `tbl_ambulancia`(`tipoAmbulancia`, `placaAmbulancia`, `estadoTabla`) VALUES ($tipoAmbulancia, $placaAmbulancia, $estadoTabla);
    END !
    DELIMITER ;



    -- =================== CONSULTAR AMBULANCIA ================ --

    DROP PROCEDURE IF EXISTS spConsultarAmbulancia;
    DELIMITER !
    CREATE PROCEDURE spConsultarAmbulancia(IN $idAmbulancia INT)
    BEGIN
    SELECT * FROM `tbl_ambulancia` WHERE `idAmbulancia` = $idAmbulancia;
    END !
    DELIMITER ;



    -- ================== MODIFICAR AMBULANCIA ================= --

    DROP PROCEDURE IF EXISTS spModificarAmbulancia;
    DELIMITER !
    CREATE PROCEDURE spModificarAmbulancia(IN $idAmbulancia INT, IN $tipoAmbulancia varchar(45), IN $placaAmbulancia varchar(45))
    BEGIN
    UPDATE `tbl_ambulancia` SET `tipoAmbulancia` = $tipoAmbulancia, `placaAmbulancia` = $placaAmbulancia WHERE `idAmbulancia` = $idAmbulancia;
    END !
    DELIMITER ;



    -- ==================== LISTAR AMBULANCIA ================== --

    DROP PROCEDURE IF EXISTS spListarAmbulancia;
    DELIMITER !
    CREATE PROCEDURE spListarAmbulancia()
    BEGIN
    SELECT * FROM `tbl_ambulancia`;
    END !
    DELIMITER ;


      -- ================== CAMBIAR ESTADO AMBULANCIA ================= --

      DROP PROCEDURE IF EXISTS spCambiarEstadoAmbulancia;
      DELIMITER !
      CREATE PROCEDURE spCambiarEstadoAmbulancia(IN $idAmbulancia INT, IN $estadoTabla varchar(45))
      BEGIN
      UPDATE `tbl_ambulancia` SET `estadoTabla` = $estadoTabla WHERE `idAmbulancia` = $idAmbulancia;
      END !
      DELIMITER ;



    -- # CRUD tbl_antecedenteaph --


    -- ================== REGISTRAR ANTECEDENTEAPH ================= --

    DROP PROCEDURE IF EXISTS spRegistrarAntecedenteaph;
    DELIMITER !
    CREATE PROCEDURE spRegistrarAntecedenteaph(IN $idTipoAntecendente int(11), IN $idReporteAPH int(11), IN $especificacion varchar(200))
    BEGIN
    INSERT INTO `tbl_antecedenteaph`(`idTipoAntecendente`, `idReporteAPH`, `especificacion`) VALUES ($idTipoAntecendente, $idReporteAPH, $especificacion);
    END !
    DELIMITER ;



    -- =================== CONSULTAR ANTECEDENTEAPH ================ --

    DROP PROCEDURE IF EXISTS spConsultarAntecedenteaph;
    DELIMITER !
    CREATE PROCEDURE spConsultarAntecedenteaph(IN $idAntecedente INT)
    BEGIN
    SELECT * FROM `tbl_antecedenteaph` WHERE `idAntecedente` = $idAntecedente;
    END !
    DELIMITER ;



    -- ================== MODIFICAR ANTECEDENTEAPH ================= --

    DROP PROCEDURE IF EXISTS spModificarAntecedenteaph;
    DELIMITER !
    CREATE PROCEDURE spModificarAntecedenteaph(IN $idAntecedente INT, IN $idTipoAntecendente int(11), IN $idReporteAPH int(11), IN $especificacion varchar(200))
    BEGIN
    UPDATE `tbl_antecedenteaph` SET `idTipoAntecendente` = $idTipoAntecendente, `idReporteAPH` = $idReporteAPH, `especificacion` = $especificacion WHERE `idAntecedente` = $idAntecedente;
    END !
    DELIMITER ;



    -- ==================== LISTAR ANTECEDENTEAPH ================== --

    DROP PROCEDURE IF EXISTS spListarAntecedenteaph;
    DELIMITER !
    CREATE PROCEDURE spListarAntecedenteaph()
    BEGIN
    SELECT * FROM `tbl_antecedenteaph`;
    END !
    DELIMITER ;





    -- # CRUD tbl_antecedentedmc --


    -- ================== REGISTRAR ANTECEDENTEDMC ================= --

    DROP PROCEDURE IF EXISTS spRegistrarAntecedentedmc;
    DELIMITER !
    CREATE PROCEDURE spRegistrarAntecedentedmc(IN $descripcionAntecedente text, IN $idTipoAntecedente int(11), IN $idHistoriaClinica int(11))
    BEGIN
    INSERT INTO `tbl_antecedentedmc`(`descripcionAntecedente`, `idTipoAntecedente`, `idHistoriaClinica`) VALUES ($descripcionAntecedente, $idTipoAntecedente, $idHistoriaClinica);
    END !
    DELIMITER ;



    -- =================== CONSULTAR ANTECEDENTEDMC ================ --

    DROP PROCEDURE IF EXISTS spConsultarAntecedentedmc;
    DELIMITER !
    CREATE PROCEDURE spConsultarAntecedentedmc(IN $idAntecedente INT)
    BEGIN
    SELECT * FROM `tbl_antecedentedmc` WHERE `idAntecedente` = $idAntecedente;
    END !
    DELIMITER ;



    -- ================== MODIFICAR ANTECEDENTEDMC ================= --

    DROP PROCEDURE IF EXISTS spModificarAntecedentedmc;
    DELIMITER !
    CREATE PROCEDURE spModificarAntecedentedmc(IN $idAntecedente INT, IN $descripcionAntecedente text, IN $idTipoAntecedente int(11), IN $idHistoriaClinica int(11))
    BEGIN
    UPDATE `tbl_antecedentedmc` SET `descripcionAntecedente` = $descripcionAntecedente, `idTipoAntecedente` = $idTipoAntecedente, `idHistoriaClinica` = $idHistoriaClinica WHERE `idAntecedente` = $idAntecedente;
    END !
    DELIMITER ;



    -- ==================== LISTAR ANTECEDENTEDMC ================== --

    DROP PROCEDURE IF EXISTS spListarAntecedentedmc;
    DELIMITER !
    CREATE PROCEDURE spListarAntecedentedmc()
    BEGIN
    SELECT * FROM `tbl_antecedentedmc`;
    END !
    DELIMITER ;





    -- # CRUD tbl_asignacionkit --


    -- ================== REGISTRAR ASIGNACIONKIT ================= --

    DROP PROCEDURE IF EXISTS spRegistrarAsignacionkit;
    DELIMITER !
    CREATE PROCEDURE spRegistrarAsignacionkit(IN $fechaHoraAsignacion datetime, IN $estadoTablaAsignacionKit varchar(45), IN $idPersona int(11), IN $idAmbulancia int(11), IN $idTipoAsignacion int(11), IN $idPaciente int(11))
    BEGIN
    INSERT INTO `tbl_asignacionkit`(`fechaHoraAsignacion`, `estadoTablaAsignacionKit`, `idPersona`, `idAmbulancia`, `idTipoAsignacion`, `idPaciente`) VALUES ($fechaHoraAsignacion, $estadoTablaAsignacionKit, $idPersona, $idAmbulancia, $idTipoAsignacion, $idPaciente);
    END !
    DELIMITER ;



    -- =================== CONSULTAR ASIGNACIONKIT ================ --

    DROP PROCEDURE IF EXISTS spConsultarAsignacionkit;
    DELIMITER !
    CREATE PROCEDURE spConsultarAsignacionkit(IN $idAsignacion INT)
    BEGIN
    SELECT * FROM `tbl_asignacionkit` WHERE `idAsignacion` = $idAsignacion;
    END !
    DELIMITER ;



    -- ================== MODIFICAR ASIGNACIONKIT ================= --

    DROP PROCEDURE IF EXISTS spModificarAsignacionkit;
    DELIMITER !
    CREATE PROCEDURE spModificarAsignacionkit(IN $idAsignacion INT, IN $fechaHoraAsignacion datetime, IN $idPersona int(11), IN $idAmbulancia int(11), IN $idTipoAsignacion int(11), IN $idPaciente int(11))
    BEGIN
    UPDATE `tbl_asignacionkit` SET `fechaHoraAsignacion` = $fechaHoraAsignacion, `idPersona` = $idPersona, `idAmbulancia` = $idAmbulancia, `idTipoAsignacion` = $idTipoAsignacion, `idPaciente` = $idPaciente WHERE `idAsignacion` = $idAsignacion;
    END !
    DELIMITER ;



    -- ==================== LISTAR ASIGNACIONKIT ================== --

    DROP PROCEDURE IF EXISTS spListarAsignacionkit;
    DELIMITER !
    CREATE PROCEDURE spListarAsignacionkit()
    BEGIN
    SELECT * FROM `tbl_asignacionkit`;
    END !
    DELIMITER ;


      -- ================== CAMBIAR ESTADO ASIGNACIONKIT ================= --

      DROP PROCEDURE IF EXISTS spCambiarEstadoAsignacionkit;
      DELIMITER !
      CREATE PROCEDURE spCambiarEstadoAsignacionkit(IN $idAsignacion INT, IN $estadoTablaAsignacionKit varchar(45))
      BEGIN
      UPDATE `tbl_asignacionkit` SET `estadoTablaAsignacionKit` = $estadoTablaAsignacionKit WHERE `idAsignacion` = $idAsignacion;
      END !
      DELIMITER ;



    -- # CRUD tbl_asignacionpersonal --


    -- ================== REGISTRAR ASIGNACIONPERSONAL ================= --

    DROP PROCEDURE IF EXISTS spRegistrarAsignacionpersonal;
    DELIMITER !
    CREATE PROCEDURE spRegistrarAsignacionpersonal(IN $idAmbulancia int(11), IN $fechaHoraAsignacion datetime, IN $estadoTablaAsignacion varchar(45), IN $longitud varchar(45), IN $latitud varchar(45))
    BEGIN
    INSERT INTO `tbl_asignacionpersonal`(`idAmbulancia`, `fechaHoraAsignacion`, `estadoTablaAsignacion`, `longitud`, `latitud`) VALUES ($idAmbulancia, $fechaHoraAsignacion, $estadoTablaAsignacion, $longitud, $latitud);
    END !
    DELIMITER ;



    -- =================== CONSULTAR ASIGNACIONPERSONAL ================ --

    DROP PROCEDURE IF EXISTS spConsultarAsignacionpersonal;
    DELIMITER !
    CREATE PROCEDURE spConsultarAsignacionpersonal(IN $idAsignacionPersonal INT)
    BEGIN
    SELECT * FROM `tbl_asignacionpersonal` WHERE `idAsignacionPersonal` = $idAsignacionPersonal;
    END !
    DELIMITER ;



    -- ================== MODIFICAR ASIGNACIONPERSONAL ================= --

    DROP PROCEDURE IF EXISTS spModificarAsignacionpersonal;
    DELIMITER !
    CREATE PROCEDURE spModificarAsignacionpersonal(IN $idAsignacionPersonal INT, IN $idAmbulancia int(11), IN $fechaHoraAsignacion datetime, IN $longitud varchar(45), IN $latitud varchar(45))
    BEGIN
    UPDATE `tbl_asignacionpersonal` SET `idAmbulancia` = $idAmbulancia, `fechaHoraAsignacion` = $fechaHoraAsignacion, `longitud` = $longitud, `latitud` = $latitud WHERE `idAsignacionPersonal` = $idAsignacionPersonal;
    END !
    DELIMITER ;



    -- ==================== LISTAR ASIGNACIONPERSONAL ================== --

    DROP PROCEDURE IF EXISTS spListarAsignacionpersonal;
    DELIMITER !
    CREATE PROCEDURE spListarAsignacionpersonal()
    BEGIN
    SELECT * FROM `tbl_asignacionpersonal`;
    END !
    DELIMITER ;


      -- ================== CAMBIAR ESTADO ASIGNACIONPERSONAL ================= --

      DROP PROCEDURE IF EXISTS spCambiarEstadoAsignacionpersonal;
      DELIMITER !
      CREATE PROCEDURE spCambiarEstadoAsignacionpersonal(IN $idAsignacionPersonal INT, IN $estadoTablaAsignacion varchar(45))
      BEGIN
      UPDATE `tbl_asignacionpersonal` SET `estadoTablaAsignacion` = $estadoTablaAsignacion WHERE `idAsignacionPersonal` = $idAsignacionPersonal;
      END !
      DELIMITER ;



    -- # CRUD tbl_autorizacion --


    -- ================== REGISTRAR AUTORIZACION ================= --

    DROP PROCEDURE IF EXISTS spRegistrarAutorizacion;
    DELIMITER !
    CREATE PROCEDURE spRegistrarAutorizacion(IN $idUsuarioParamedico int(11), IN $idUsuarioMedico int(11), IN $idReporteAPH int(11), IN $idTipoTratamiento int(11), IN $idMedicamento int(11), IN $descripcionAutorizacion text, IN $observacionRespuestaAutorizacion text, IN $estadoEvaluacion varchar(45), IN $fechaEnvio datetime, IN $fechaEvaluacion datetime, IN $cedulaPaciente varchar(45))
    BEGIN
    INSERT INTO `tbl_autorizacion`(`idUsuarioParamedico`, `idUsuarioMedico`, `idReporteAPH`, `idTipoTratamiento`, `idMedicamento`, `descripcionAutorizacion`, `observacionRespuestaAutorizacion`, `estadoEvaluacion`, `fechaEnvio`, `fechaEvaluacion`, `cedulaPaciente`) VALUES ($idUsuarioParamedico, $idUsuarioMedico, $idReporteAPH, $idTipoTratamiento, $idMedicamento, $descripcionAutorizacion, $observacionRespuestaAutorizacion, $estadoEvaluacion, $fechaEnvio, $fechaEvaluacion, $cedulaPaciente);
    END !
    DELIMITER ;



    -- =================== CONSULTAR AUTORIZACION ================ --

    DROP PROCEDURE IF EXISTS spConsultarAutorizacion;
    DELIMITER !
    CREATE PROCEDURE spConsultarAutorizacion(IN $idAutorizacion INT)
    BEGIN
    SELECT * FROM `tbl_autorizacion` WHERE `idAutorizacion` = $idAutorizacion;
    END !
    DELIMITER ;



    -- ================== MODIFICAR AUTORIZACION ================= --

    DROP PROCEDURE IF EXISTS spModificarAutorizacion;
    DELIMITER !
    CREATE PROCEDURE spModificarAutorizacion(IN $idAutorizacion INT, IN $idUsuarioParamedico int(11), IN $idUsuarioMedico int(11), IN $idReporteAPH int(11), IN $idTipoTratamiento int(11), IN $idMedicamento int(11), IN $descripcionAutorizacion text, IN $observacionRespuestaAutorizacion text, IN $estadoEvaluacion varchar(45), IN $fechaEnvio datetime, IN $fechaEvaluacion datetime, IN $cedulaPaciente varchar(45))
    BEGIN
    UPDATE `tbl_autorizacion` SET `idUsuarioParamedico` = $idUsuarioParamedico, `idUsuarioMedico` = $idUsuarioMedico, `idReporteAPH` = $idReporteAPH, `idTipoTratamiento` = $idTipoTratamiento, `idMedicamento` = $idMedicamento, `descripcionAutorizacion` = $descripcionAutorizacion, `observacionRespuestaAutorizacion` = $observacionRespuestaAutorizacion, `estadoEvaluacion` = $estadoEvaluacion, `fechaEnvio` = $fechaEnvio, `fechaEvaluacion` = $fechaEvaluacion, `cedulaPaciente` = $cedulaPaciente WHERE `idAutorizacion` = $idAutorizacion;
    END !
    DELIMITER ;



    -- ==================== LISTAR AUTORIZACION ================== --

    DROP PROCEDURE IF EXISTS spListarAutorizacion;
    DELIMITER !
    CREATE PROCEDURE spListarAutorizacion()
    BEGIN
    SELECT * FROM `tbl_autorizacion`;
    END !
    DELIMITER ;





    -- # CRUD tbl_categoriaautorizacion --


    -- ================== REGISTRAR CATEGORIAAUTORIZACION ================= --

    DROP PROCEDURE IF EXISTS spRegistrarCategoriaautorizacion;
    DELIMITER !
    CREATE PROCEDURE spRegistrarCategoriaautorizacion(IN $descripcion varchar(45), IN $estadoTabla varchar(50))
    BEGIN
    INSERT INTO `tbl_categoriaautorizacion`(`descripcion`, `estadoTabla`) VALUES ($descripcion, $estadoTabla);
    END !
    DELIMITER ;



    -- =================== CONSULTAR CATEGORIAAUTORIZACION ================ --

    DROP PROCEDURE IF EXISTS spConsultarCategoriaautorizacion;
    DELIMITER !
    CREATE PROCEDURE spConsultarCategoriaautorizacion(IN $idCategoriaAutorizacion INT)
    BEGIN
    SELECT * FROM `tbl_categoriaautorizacion` WHERE `idCategoriaAutorizacion` = $idCategoriaAutorizacion;
    END !
    DELIMITER ;



    -- ================== MODIFICAR CATEGORIAAUTORIZACION ================= --

    DROP PROCEDURE IF EXISTS spModificarCategoriaautorizacion;
    DELIMITER !
    CREATE PROCEDURE spModificarCategoriaautorizacion(IN $idCategoriaAutorizacion INT, IN $descripcion varchar(45))
    BEGIN
    UPDATE `tbl_categoriaautorizacion` SET `descripcion` = $descripcion WHERE `idCategoriaAutorizacion` = $idCategoriaAutorizacion;
    END !
    DELIMITER ;



    -- ==================== LISTAR CATEGORIAAUTORIZACION ================== --

    DROP PROCEDURE IF EXISTS spListarCategoriaautorizacion;
    DELIMITER !
    CREATE PROCEDURE spListarCategoriaautorizacion()
    BEGIN
    SELECT * FROM `tbl_categoriaautorizacion`;
    END !
    DELIMITER ;


      -- ================== CAMBIAR ESTADO CATEGORIAAUTORIZACION ================= --

      DROP PROCEDURE IF EXISTS spCambiarEstadoCategoriaautorizacion;
      DELIMITER !
      CREATE PROCEDURE spCambiarEstadoCategoriaautorizacion(IN $idCategoriaAutorizacion INT, IN $estadoTabla varchar(50))
      BEGIN
      UPDATE `tbl_categoriaautorizacion` SET `estadoTabla` = $estadoTabla WHERE `idCategoriaAutorizacion` = $idCategoriaAutorizacion;
      END !
      DELIMITER ;



    -- # CRUD tbl_categoriarecurso --


    -- ================== REGISTRAR CATEGORIARECURSO ================= --

    DROP PROCEDURE IF EXISTS spRegistrarCategoriarecurso;
    DELIMITER !
    CREATE PROCEDURE spRegistrarCategoriarecurso(IN $descripcionCategoriarecurso varchar(45), IN $estadoTabla varchar(50))
    BEGIN
    INSERT INTO `tbl_categoriarecurso`(`descripcionCategoriarecurso`, `estadoTabla`) VALUES ($descripcionCategoriarecurso, $estadoTabla);
    END !
    DELIMITER ;



    -- =================== CONSULTAR CATEGORIARECURSO ================ --

    DROP PROCEDURE IF EXISTS spConsultarCategoriarecurso;
    DELIMITER !
    CREATE PROCEDURE spConsultarCategoriarecurso(IN $idCategoriaRecurso INT)
    BEGIN
    SELECT * FROM `tbl_categoriarecurso` WHERE `idCategoriaRecurso` = $idCategoriaRecurso;
    END !
    DELIMITER ;



    -- ================== MODIFICAR CATEGORIARECURSO ================= --

    DROP PROCEDURE IF EXISTS spModificarCategoriarecurso;
    DELIMITER !
    CREATE PROCEDURE spModificarCategoriarecurso(IN $idCategoriaRecurso INT, IN $descripcionCategoriarecurso varchar(45))
    BEGIN
    UPDATE `tbl_categoriarecurso` SET `descripcionCategoriarecurso` = $descripcionCategoriarecurso WHERE `idCategoriaRecurso` = $idCategoriaRecurso;
    END !
    DELIMITER ;



    -- ==================== LISTAR CATEGORIARECURSO ================== --

    DROP PROCEDURE IF EXISTS spListarCategoriarecurso;
    DELIMITER !
    CREATE PROCEDURE spListarCategoriarecurso()
    BEGIN
    SELECT * FROM `tbl_categoriarecurso`;
    END !
    DELIMITER ;


      -- ================== CAMBIAR ESTADO CATEGORIARECURSO ================= --

      DROP PROCEDURE IF EXISTS spCambiarEstadoCategoriarecurso;
      DELIMITER !
      CREATE PROCEDURE spCambiarEstadoCategoriarecurso(IN $idCategoriaRecurso INT, IN $estadoTabla varchar(50))
      BEGIN
      UPDATE `tbl_categoriarecurso` SET `estadoTabla` = $estadoTabla WHERE `idCategoriaRecurso` = $idCategoriaRecurso;
      END !
      DELIMITER ;



    -- # CRUD tbl_certificadoatencion --


    -- ================== REGISTRAR CERTIFICADOATENCION ================= --

    DROP PROCEDURE IF EXISTS spRegistrarCertificadoatencion;
    DELIMITER !
    CREATE PROCEDURE spRegistrarCertificadoatencion(IN $descripcionCertificadoAtencion varchar(45), IN $estadoTabla varchar(50))
    BEGIN
    INSERT INTO `tbl_certificadoatencion`(`descripcionCertificadoAtencion`, `estadoTabla`) VALUES ($descripcionCertificadoAtencion, $estadoTabla);
    END !
    DELIMITER ;



    -- =================== CONSULTAR CERTIFICADOATENCION ================ --

    DROP PROCEDURE IF EXISTS spConsultarCertificadoatencion;
    DELIMITER !
    CREATE PROCEDURE spConsultarCertificadoatencion(IN $idCertificadoAtencion INT)
    BEGIN
    SELECT * FROM `tbl_certificadoatencion` WHERE `idCertificadoAtencion` = $idCertificadoAtencion;
    END !
    DELIMITER ;



    -- ================== MODIFICAR CERTIFICADOATENCION ================= --

    DROP PROCEDURE IF EXISTS spModificarCertificadoatencion;
    DELIMITER !
    CREATE PROCEDURE spModificarCertificadoatencion(IN $idCertificadoAtencion INT, IN $descripcionCertificadoAtencion varchar(45))
    BEGIN
    UPDATE `tbl_certificadoatencion` SET `descripcionCertificadoAtencion` = $descripcionCertificadoAtencion WHERE `idCertificadoAtencion` = $idCertificadoAtencion;
    END !
    DELIMITER ;



    -- ==================== LISTAR CERTIFICADOATENCION ================== --

    DROP PROCEDURE IF EXISTS spListarCertificadoatencion;
    DELIMITER !
    CREATE PROCEDURE spListarCertificadoatencion()
    BEGIN
    SELECT * FROM `tbl_certificadoatencion`;
    END !
    DELIMITER ;


      -- ================== CAMBIAR ESTADO CERTIFICADOATENCION ================= --

      DROP PROCEDURE IF EXISTS spCambiarEstadoCertificadoatencion;
      DELIMITER !
      CREATE PROCEDURE spCambiarEstadoCertificadoatencion(IN $idCertificadoAtencion INT, IN $estadoTabla varchar(50))
      BEGIN
      UPDATE `tbl_certificadoatencion` SET `estadoTabla` = $estadoTabla WHERE `idCertificadoAtencion` = $idCertificadoAtencion;
      END !
      DELIMITER ;



    -- # CRUD tbl_chat --


    -- ================== REGISTRAR CHAT ================= --

    DROP PROCEDURE IF EXISTS spRegistrarChat;
    DELIMITER !
    CREATE PROCEDURE spRegistrarChat(IN $fechaHoraInicioChat timestamp, IN $idReceptorInicial int(11), IN $idUsuarioExterno int(11), IN $estadoTabla bit(1), IN $visto bit(1))
    BEGIN
    INSERT INTO `tbl_chat`(`fechaHoraInicioChat`, `idReceptorInicial`, `idUsuarioExterno`, `estadoTabla`, `visto`) VALUES ($fechaHoraInicioChat, $idReceptorInicial, $idUsuarioExterno, $estadoTabla, $visto);
    END !
    DELIMITER ;



    -- =================== CONSULTAR CHAT ================ --

    DROP PROCEDURE IF EXISTS spConsultarChat;
    DELIMITER !
    CREATE PROCEDURE spConsultarChat(IN $idChat INT)
    BEGIN
    SELECT * FROM `tbl_chat` WHERE `idChat` = $idChat;
    END !
    DELIMITER ;



    -- ================== MODIFICAR CHAT ================= --

    DROP PROCEDURE IF EXISTS spModificarChat;
    DELIMITER !
    CREATE PROCEDURE spModificarChat(IN $idChat INT, IN $fechaHoraInicioChat timestamp, IN $idReceptorInicial int(11), IN $idUsuarioExterno int(11), IN $visto bit(1))
    BEGIN
    UPDATE `tbl_chat` SET `fechaHoraInicioChat` = $fechaHoraInicioChat, `idReceptorInicial` = $idReceptorInicial, `idUsuarioExterno` = $idUsuarioExterno, `visto` = $visto WHERE `idChat` = $idChat;
    END !
    DELIMITER ;



    -- ==================== LISTAR CHAT ================== --

    DROP PROCEDURE IF EXISTS spListarChat;
    DELIMITER !
    CREATE PROCEDURE spListarChat()
    BEGIN
    SELECT * FROM `tbl_chat`;
    END !
    DELIMITER ;


      -- ================== CAMBIAR ESTADO CHAT ================= --

      DROP PROCEDURE IF EXISTS spCambiarEstadoChat;
      DELIMITER !
      CREATE PROCEDURE spCambiarEstadoChat(IN $idChat INT, IN $estadoTabla bit(1))
      BEGIN
      UPDATE `tbl_chat` SET `estadoTabla` = $estadoTabla WHERE `idChat` = $idChat;
      END !
      DELIMITER ;



    -- # CRUD tbl_cie10 --


    -- ================== REGISTRAR CIE10 ================= --

    DROP PROCEDURE IF EXISTS spRegistrarCie10;
    DELIMITER !
    CREATE PROCEDURE spRegistrarCie10(IN $codigoCIE10 varchar(45), IN $descripcionCIE10 varchar(1000), IN $estadoTabla varchar(50))
    BEGIN
    INSERT INTO `tbl_cie10`(`codigoCIE10`, `descripcionCIE10`, `estadoTabla`) VALUES ($codigoCIE10, $descripcionCIE10, $estadoTabla);
    END !
    DELIMITER ;



    -- =================== CONSULTAR CIE10 ================ --

    DROP PROCEDURE IF EXISTS spConsultarCie10;
    DELIMITER !
    CREATE PROCEDURE spConsultarCie10(IN $idCIE10 INT)
    BEGIN
    SELECT * FROM `tbl_cie10` WHERE `idCIE10` = $idCIE10;
    END !
    DELIMITER ;



    -- ================== MODIFICAR CIE10 ================= --

    DROP PROCEDURE IF EXISTS spModificarCie10;
    DELIMITER !
    CREATE PROCEDURE spModificarCie10(IN $idCIE10 INT, IN $codigoCIE10 varchar(45), IN $descripcionCIE10 varchar(1000))
    BEGIN
    UPDATE `tbl_cie10` SET `codigoCIE10` = $codigoCIE10, `descripcionCIE10` = $descripcionCIE10 WHERE `idCIE10` = $idCIE10;
    END !
    DELIMITER ;



    -- ==================== LISTAR CIE10 ================== --

    DROP PROCEDURE IF EXISTS spListarCie10;
    DELIMITER !
    CREATE PROCEDURE spListarCie10()
    BEGIN
    SELECT * FROM `tbl_cie10`;
    END !
    DELIMITER ;


      -- ================== CAMBIAR ESTADO CIE10 ================= --

      DROP PROCEDURE IF EXISTS spCambiarEstadoCie10;
      DELIMITER !
      CREATE PROCEDURE spCambiarEstadoCie10(IN $idCIE10 INT, IN $estadoTabla varchar(50))
      BEGIN
      UPDATE `tbl_cie10` SET `estadoTabla` = $estadoTabla WHERE `idCIE10` = $idCIE10;
      END !
      DELIMITER ;



    -- # CRUD tbl_cita --


    -- ================== REGISTRAR CITA ================= --

    DROP PROCEDURE IF EXISTS spRegistrarCita;
    DELIMITER !
    CREATE PROCEDURE spRegistrarCita(IN $estadoTablaCita varchar(45), IN $direccionCita varchar(45), IN $fechaCita date, IN $horaInicial time, IN $horaFinal time, IN $telefonoFijo1 varchar(45), IN $telefonoFijo2 varchar(45), IN $idPaciente int(11), IN $idCUP int(11), IN $idZona int(11), IN $fechaRegistro date)
    BEGIN
    INSERT INTO `tbl_cita`(`estadoTablaCita`, `direccionCita`, `fechaCita`, `horaInicial`, `horaFinal`, `telefonoFijo1`, `telefonoFijo2`, `idPaciente`, `idCUP`, `idZona`, `fechaRegistro`) VALUES ($estadoTablaCita, $direccionCita, $fechaCita, $horaInicial, $horaFinal, $telefonoFijo1, $telefonoFijo2, $idPaciente, $idCUP, $idZona, $fechaRegistro);
    END !
    DELIMITER ;



    -- =================== CONSULTAR CITA ================ --

    DROP PROCEDURE IF EXISTS spConsultarCita;
    DELIMITER !
    CREATE PROCEDURE spConsultarCita(IN $idCita INT)
    BEGIN
    SELECT * FROM `tbl_cita` WHERE `idCita` = $idCita;
    END !
    DELIMITER ;



    -- ================== MODIFICAR CITA ================= --

    DROP PROCEDURE IF EXISTS spModificarCita;
    DELIMITER !
    CREATE PROCEDURE spModificarCita(IN $idCita INT,  IN $direccionCita varchar(45), IN $fechaCita date, IN $horaInicial time, IN $horaFinal time, IN $telefonoFijo1 varchar(45), IN $telefonoFijo2 varchar(45), IN $idPaciente int(11), IN $idCUP int(11), IN $idZona int(11), IN $fechaRegistro date)
    BEGIN
    UPDATE `tbl_cita` SET  `direccionCita` = $direccionCita, `fechaCita` = $fechaCita, `horaInicial` = $horaInicial, `horaFinal` = $horaFinal, `telefonoFijo1` = $telefonoFijo1, `telefonoFijo2` = $telefonoFijo2, `idPaciente` = $idPaciente, `idCUP` = $idCUP, `idZona` = $idZona, `fechaRegistro` = $fechaRegistro WHERE `idCita` = $idCita;
    END !
    DELIMITER ;



    -- ==================== LISTAR CITA ================== --

    DROP PROCEDURE IF EXISTS spListarCita;
    DELIMITER !
    CREATE PROCEDURE spListarCita()
    BEGIN
    SELECT * FROM `tbl_cita`;
    END !
    DELIMITER ;


      -- ================== CAMBIAR ESTADO CITA ================= --

      DROP PROCEDURE IF EXISTS spCambiarEstadoCita;
      DELIMITER !
      CREATE PROCEDURE spCambiarEstadoCita(IN $idCita INT, IN $estadoTablaCita varchar(45))
      BEGIN
      UPDATE `tbl_cita` SET `estadoTablaCita` = $estadoTablaCita WHERE `idCita` = $idCita;
      END !
      DELIMITER ;



    -- # CRUD tbl_cita_programacion --


    -- ================== REGISTRAR CITA_PROGRAMACION ================= --

    DROP PROCEDURE IF EXISTS spRegistrarCita_programacion;
    DELIMITER !
    CREATE PROCEDURE spRegistrarCita_programacion(IN $idCita int(11), IN $idTurnoProgramacion int(11))
    BEGIN
    INSERT INTO `tbl_cita_programacion`(`idCita`, `idTurnoProgramacion`) VALUES ($idCita, $idTurnoProgramacion);
    END !
    DELIMITER ;



    -- =================== CONSULTAR CITA_PROGRAMACION ================ --

    DROP PROCEDURE IF EXISTS spConsultarCita_programacion;
    DELIMITER !
    CREATE PROCEDURE spConsultarCita_programacion(IN $idCitaprogramacion INT)
    BEGIN
    SELECT * FROM `tbl_cita_programacion` WHERE `idCitaprogramacion` = $idCitaprogramacion;
    END !
    DELIMITER ;



    -- ================== MODIFICAR CITA_PROGRAMACION ================= --

    DROP PROCEDURE IF EXISTS spModificarCita_programacion;
    DELIMITER !
    CREATE PROCEDURE spModificarCita_programacion(IN $idCitaprogramacion INT, IN $idCita int(11), IN $idTurnoProgramacion int(11))
    BEGIN
    UPDATE `tbl_cita_programacion` SET `idCita` = $idCita, `idTurnoProgramacion` = $idTurnoProgramacion WHERE `idCitaprogramacion` = $idCitaprogramacion;
    END !
    DELIMITER ;



    -- ==================== LISTAR CITA_PROGRAMACION ================== --

    DROP PROCEDURE IF EXISTS spListarCita_programacion;
    DELIMITER !
    CREATE PROCEDURE spListarCita_programacion()
    BEGIN
    SELECT * FROM `tbl_cita_programacion`;
    END !
    DELIMITER ;





    -- # CRUD tbl_configuracion --


    -- ================== REGISTRAR CONFIGURACION ================= --

    DROP PROCEDURE IF EXISTS spRegistrarConfiguracion;
    DELIMITER !
    CREATE PROCEDURE spRegistrarConfiguracion(IN $cantidadCitasDia int(11), IN $cantidadCitasMes int(11), IN $descripcionConfiguracion varchar(45), IN $fechaConfiguracion timestamp, IN $estadoTabla varchar(50))
    BEGIN
    INSERT INTO `tbl_configuracion`(`cantidadCitasDia`, `cantidadCitasMes`, `descripcionConfiguracion`, `fechaConfiguracion`, `estadoTabla`) VALUES ($cantidadCitasDia, $cantidadCitasMes, $descripcionConfiguracion, $fechaConfiguracion, $estadoTabla);
    END !
    DELIMITER ;



    -- =================== CONSULTAR CONFIGURACION ================ --

    DROP PROCEDURE IF EXISTS spConsultarConfiguracion;
    DELIMITER !
    CREATE PROCEDURE spConsultarConfiguracion(IN $idConfiguracion INT)
    BEGIN
    SELECT * FROM `tbl_configuracion` WHERE `idConfiguracion` = $idConfiguracion;
    END !
    DELIMITER ;



    -- ================== MODIFICAR CONFIGURACION ================= --

    DROP PROCEDURE IF EXISTS spModificarConfiguracion;
    DELIMITER !
    CREATE PROCEDURE spModificarConfiguracion(IN $idConfiguracion INT, IN $cantidadCitasDia int(11), IN $cantidadCitasMes int(11), IN $descripcionConfiguracion varchar(45), IN $fechaConfiguracion timestamp)
    BEGIN
    UPDATE `tbl_configuracion` SET `cantidadCitasDia` = $cantidadCitasDia, `cantidadCitasMes` = $cantidadCitasMes, `descripcionConfiguracion` = $descripcionConfiguracion, `fechaConfiguracion` = $fechaConfiguracion WHERE `idConfiguracion` = $idConfiguracion;
    END !
    DELIMITER ;



    -- ==================== LISTAR CONFIGURACION ================== --

    DROP PROCEDURE IF EXISTS spListarConfiguracion;
    DELIMITER !
    CREATE PROCEDURE spListarConfiguracion()
    BEGIN
    SELECT * FROM `tbl_configuracion`;
    END !
    DELIMITER ;


      -- ================== CAMBIAR ESTADO CONFIGURACION ================= --

      DROP PROCEDURE IF EXISTS spCambiarEstadoConfiguracion;
      DELIMITER !
      CREATE PROCEDURE spCambiarEstadoConfiguracion(IN $idConfiguracion INT, IN $estadoTabla varchar(50))
      BEGIN
      UPDATE `tbl_configuracion` SET `estadoTabla` = $estadoTabla WHERE `idConfiguracion` = $idConfiguracion;
      END !
      DELIMITER ;



    -- # CRUD tbl_cuentausuario --


    -- ================== REGISTRAR CUENTAUSUARIO ================= --

    DROP PROCEDURE IF EXISTS spRegistrarCuentausuario;
    DELIMITER !
    CREATE PROCEDURE spRegistrarCuentausuario(IN $idPersona int(11), IN $usuario varchar(100), IN $clave varchar(50), IN $idRol int(11))
    BEGIN
    INSERT INTO `tbl_cuentausuario`(`idPersona`, `usuario`, `clave`, `idRol`) VALUES ($idPersona, $usuario, $clave, $idRol);
    END !
    DELIMITER ;



    -- =================== CONSULTAR CUENTAUSUARIO ================ --

    DROP PROCEDURE IF EXISTS spConsultarCuentausuario;
    DELIMITER !
    CREATE PROCEDURE spConsultarCuentausuario(IN $idUsuario INT)
    BEGIN
    SELECT * FROM `tbl_cuentausuario` WHERE `idUsuario` = $idUsuario;
    END !
    DELIMITER ;



    -- ================== MODIFICAR CUENTAUSUARIO ================= --

    DROP PROCEDURE IF EXISTS spModificarCuentausuario;
    DELIMITER !
    CREATE PROCEDURE spModificarCuentausuario(IN $idUsuario INT, IN $idPersona int(11), IN $usuario varchar(100), IN $clave varchar(50), IN $idRol int(11))
    BEGIN
    UPDATE `tbl_cuentausuario` SET `idPersona` = $idPersona, `usuario` = $usuario, `clave` = $clave, `idRol` = $idRol WHERE `idUsuario` = $idUsuario;
    END !
    DELIMITER ;



    -- ==================== LISTAR CUENTAUSUARIO ================== --

    DROP PROCEDURE IF EXISTS spListarCuentausuario;
    DELIMITER !
    CREATE PROCEDURE spListarCuentausuario()
    BEGIN
    SELECT * FROM `tbl_cuentausuario`;
    END !
    DELIMITER ;





    -- # CRUD tbl_cuidadoantarribo --


    -- ================== REGISTRAR CUIDADOANTARRIBO ================= --

    DROP PROCEDURE IF EXISTS spRegistrarCuidadoantarribo;
    DELIMITER !
    CREATE PROCEDURE spRegistrarCuidadoantarribo(IN $descripcionArribo varchar(45), IN $idReporteAPH int(11))
    BEGIN
    INSERT INTO `tbl_cuidadoantarribo`(`descripcionArribo`, `idReporteAPH`) VALUES ($descripcionArribo, $idReporteAPH);
    END !
    DELIMITER ;



    -- =================== CONSULTAR CUIDADOANTARRIBO ================ --

    DROP PROCEDURE IF EXISTS spConsultarCuidadoantarribo;
    DELIMITER !
    CREATE PROCEDURE spConsultarCuidadoantarribo(IN $idCuidadoAntArribo INT)
    BEGIN
    SELECT * FROM `tbl_cuidadoantarribo` WHERE `idCuidadoAntArribo` = $idCuidadoAntArribo;
    END !
    DELIMITER ;



    -- ================== MODIFICAR CUIDADOANTARRIBO ================= --

    DROP PROCEDURE IF EXISTS spModificarCuidadoantarribo;
    DELIMITER !
    CREATE PROCEDURE spModificarCuidadoantarribo(IN $idCuidadoAntArribo INT, IN $descripcionArribo varchar(45), IN $idReporteAPH int(11))
    BEGIN
    UPDATE `tbl_cuidadoantarribo` SET `descripcionArribo` = $descripcionArribo, `idReporteAPH` = $idReporteAPH WHERE `idCuidadoAntArribo` = $idCuidadoAntArribo;
    END !
    DELIMITER ;



    -- ==================== LISTAR CUIDADOANTARRIBO ================== --

    DROP PROCEDURE IF EXISTS spListarCuidadoantarribo;
    DELIMITER !
    CREATE PROCEDURE spListarCuidadoantarribo()
    BEGIN
    SELECT * FROM `tbl_cuidadoantarribo`;
    END !
    DELIMITER ;





    -- # CRUD tbl_cup --


    -- ================== REGISTRAR CUP ================= --

    DROP PROCEDURE IF EXISTS spRegistrarCup;
    DELIMITER !
    CREATE PROCEDURE spRegistrarCup(IN $nombreCUP varchar(1000), IN $idConfiguracion int(11), IN $idTipoCup int(11), IN $codigoCup varchar(45), IN $estadoTabla varchar(50))
    BEGIN
    INSERT INTO `tbl_cup`(`nombreCUP`, `idConfiguracion`, `idTipoCup`, `codigoCup`, `estadoTabla`) VALUES ($nombreCUP, $idConfiguracion, $idTipoCup, $codigoCup, $estadoTabla);
    END !
    DELIMITER ;



    -- =================== CONSULTAR CUP ================ --

    DROP PROCEDURE IF EXISTS spConsultarCup;
    DELIMITER !
    CREATE PROCEDURE spConsultarCup(IN $idCUP INT)
    BEGIN
    SELECT * FROM `tbl_cup` WHERE `idCUP` = $idCUP;
    END !
    DELIMITER ;



    -- ================== MODIFICAR CUP ================= --

    DROP PROCEDURE IF EXISTS spModificarCup;
    DELIMITER !
    CREATE PROCEDURE spModificarCup(IN $idCUP INT, IN $nombreCUP varchar(1000), IN $idConfiguracion int(11), IN $idTipoCup int(11), IN $codigoCup varchar(45))
    BEGIN
    UPDATE `tbl_cup` SET `nombreCUP` = $nombreCUP, `idConfiguracion` = $idConfiguracion, `idTipoCup` = $idTipoCup, `codigoCup` = $codigoCup WHERE `idCUP` = $idCUP;
    END !
    DELIMITER ;



    -- ==================== LISTAR CUP ================== --

    DROP PROCEDURE IF EXISTS spListarCup;
    DELIMITER !
    CREATE PROCEDURE spListarCup()
    BEGIN
    SELECT * FROM `tbl_cup`;
    END !
    DELIMITER ;


      -- ================== CAMBIAR ESTADO CUP ================= --

      DROP PROCEDURE IF EXISTS spCambiarEstadoCup;
      DELIMITER !
      CREATE PROCEDURE spCambiarEstadoCup(IN $idCUP INT, IN $estadoTabla varchar(50))
      BEGIN
      UPDATE `tbl_cup` SET `estadoTabla` = $estadoTabla WHERE `idCUP` = $idCUP;
      END !
      DELIMITER ;



    -- # CRUD tbl_desfibrilacion --


    -- ================== REGISTRAR DESFIBRILACION ================= --

    DROP PROCEDURE IF EXISTS spRegistrarDesfibrilacion;
    DELIMITER !
    CREATE PROCEDURE spRegistrarDesfibrilacion(IN $idReporteAPH int(11), IN $horaDesfibrilacion time, IN $joules float)
    BEGIN
    INSERT INTO `tbl_desfibrilacion`(`idReporteAPH`, `horaDesfibrilacion`, `joules`) VALUES ($idReporteAPH, $horaDesfibrilacion, $joules);
    END !
    DELIMITER ;



    -- =================== CONSULTAR DESFIBRILACION ================ --

    DROP PROCEDURE IF EXISTS spConsultarDesfibrilacion;
    DELIMITER !
    CREATE PROCEDURE spConsultarDesfibrilacion(IN $iddesfibrilacion INT)
    BEGIN
    SELECT * FROM `tbl_desfibrilacion` WHERE `iddesfibrilacion` = $iddesfibrilacion;
    END !
    DELIMITER ;



    -- ================== MODIFICAR DESFIBRILACION ================= --

    DROP PROCEDURE IF EXISTS spModificarDesfibrilacion;
    DELIMITER !
    CREATE PROCEDURE spModificarDesfibrilacion(IN $iddesfibrilacion INT, IN $idReporteAPH int(11), IN $horaDesfibrilacion time, IN $joules float)
    BEGIN
    UPDATE `tbl_desfibrilacion` SET `idReporteAPH` = $idReporteAPH, `horaDesfibrilacion` = $horaDesfibrilacion, `joules` = $joules WHERE `iddesfibrilacion` = $iddesfibrilacion;
    END !
    DELIMITER ;



    -- ==================== LISTAR DESFIBRILACION ================== --

    DROP PROCEDURE IF EXISTS spListarDesfibrilacion;
    DELIMITER !
    CREATE PROCEDURE spListarDesfibrilacion()
    BEGIN
    SELECT * FROM `tbl_desfibrilacion`;
    END !
    DELIMITER ;





    -- # CRUD tbl_despacho --


    -- ================== REGISTRAR DESPACHO ================= --

    DROP PROCEDURE IF EXISTS spRegistrarDespacho;
    DELIMITER !
    CREATE PROCEDURE spRegistrarDespacho(IN $idReporteInicial int(11), IN $idAmbulancia int(11), IN $fechaHoraDespacho datetime, IN $estadoDespacho varchar(50), IN $longitudEmergencia varchar(200), IN $latitudEmergencia varchar(200), IN $idPersona int(11))
    BEGIN
    INSERT INTO `tbl_despacho`(`idReporteInicial`, `idAmbulancia`, `fechaHoraDespacho`, `estadoDespacho`, `longitudEmergencia`, `latitudEmergencia`, `idPersona`) VALUES ($idReporteInicial, $idAmbulancia, $fechaHoraDespacho, $estadoDespacho, $longitudEmergencia, $latitudEmergencia, $idPersona);
    END !
    DELIMITER ;



    -- =================== CONSULTAR DESPACHO ================ --

    DROP PROCEDURE IF EXISTS spConsultarDespacho;
    DELIMITER !
    CREATE PROCEDURE spConsultarDespacho(IN $idDespacho INT)
    BEGIN
    SELECT * FROM `tbl_despacho` WHERE `idDespacho` = $idDespacho;
    END !
    DELIMITER ;



    -- ================== MODIFICAR DESPACHO ================= --

    DROP PROCEDURE IF EXISTS spModificarDespacho;
    DELIMITER !
    CREATE PROCEDURE spModificarDespacho(IN $idDespacho INT, IN $idReporteInicial int(11), IN $idAmbulancia int(11), IN $fechaHoraDespacho datetime, IN $estadoDespacho varchar(50), IN $longitudEmergencia varchar(200), IN $latitudEmergencia varchar(200), IN $idPersona int(11))
    BEGIN
    UPDATE `tbl_despacho` SET `idReporteInicial` = $idReporteInicial, `idAmbulancia` = $idAmbulancia, `fechaHoraDespacho` = $fechaHoraDespacho, `estadoDespacho` = $estadoDespacho, `longitudEmergencia` = $longitudEmergencia, `latitudEmergencia` = $latitudEmergencia, `idPersona` = $idPersona WHERE `idDespacho` = $idDespacho;
    END !
    DELIMITER ;



    -- ==================== LISTAR DESPACHO ================== --

    DROP PROCEDURE IF EXISTS spListarDespacho;
    DELIMITER !
    CREATE PROCEDURE spListarDespacho()
    BEGIN
    SELECT * FROM `tbl_despacho`;
    END !
    DELIMITER ;





    -- # CRUD tbl_detalleasignacion --


    -- ================== REGISTRAR DETALLEASIGNACION ================= --

    DROP PROCEDURE IF EXISTS spRegistrarDetalleasignacion;
    DELIMITER !
    CREATE PROCEDURE spRegistrarDetalleasignacion(IN $idAsignacionPersonal int(11), IN $idPersona int(11), IN $estadoTabla varchar(50), IN $cargoPersona varchar(50))
    BEGIN
    INSERT INTO `tbl_detalleasignacion`(`idAsignacionPersonal`, `idPersona`, `estadoTabla`, `cargoPersona`) VALUES ($idAsignacionPersonal, $idPersona, $estadoTabla, $cargoPersona);
    END !
    DELIMITER ;



    -- =================== CONSULTAR DETALLEASIGNACION ================ --

    DROP PROCEDURE IF EXISTS spConsultarDetalleasignacion;
    DELIMITER !
    CREATE PROCEDURE spConsultarDetalleasignacion(IN $idDetalleAsignacion INT)
    BEGIN
    SELECT * FROM `tbl_detalleasignacion` WHERE `idDetalleAsignacion` = $idDetalleAsignacion;
    END !
    DELIMITER ;



    -- ================== MODIFICAR DETALLEASIGNACION ================= --

    DROP PROCEDURE IF EXISTS spModificarDetalleasignacion;
    DELIMITER !
    CREATE PROCEDURE spModificarDetalleasignacion(IN $idDetalleAsignacion INT, IN $idAsignacionPersonal int(11), IN $idPersona int(11), IN $cargoPersona varchar(50))
    BEGIN
    UPDATE `tbl_detalleasignacion` SET `idAsignacionPersonal` = $idAsignacionPersonal, `idPersona` = $idPersona, `cargoPersona` = $cargoPersona WHERE `idDetalleAsignacion` = $idDetalleAsignacion;
    END !
    DELIMITER ;



    -- ==================== LISTAR DETALLEASIGNACION ================== --

    DROP PROCEDURE IF EXISTS spListarDetalleasignacion;
    DELIMITER !
    CREATE PROCEDURE spListarDetalleasignacion()
    BEGIN
    SELECT * FROM `tbl_detalleasignacion`;
    END !
    DELIMITER ;


      -- ================== CAMBIAR ESTADO DETALLEASIGNACION ================= --

      DROP PROCEDURE IF EXISTS spCambiarEstadoDetalleasignacion;
      DELIMITER !
      CREATE PROCEDURE spCambiarEstadoDetalleasignacion(IN $idDetalleAsignacion INT, IN $estadoTabla varchar(50))
      BEGIN
      UPDATE `tbl_detalleasignacion` SET `estadoTabla` = $estadoTabla WHERE `idDetalleAsignacion` = $idDetalleAsignacion;
      END !
      DELIMITER ;



    -- # CRUD tbl_detallekit --


    -- ================== REGISTRAR DETALLEKIT ================= --

    DROP PROCEDURE IF EXISTS spRegistrarDetallekit;
    DELIMITER !
    CREATE PROCEDURE spRegistrarDetallekit(IN $cantidadAsignada int(11), IN $cantidadFinal int(11), IN $idrecurso int(11), IN $idAsignacion int(11))
    BEGIN
    INSERT INTO `tbl_detallekit`(`cantidadAsignada`, `cantidadFinal`, `idrecurso`, `idAsignacion`) VALUES ($cantidadAsignada, $cantidadFinal, $idrecurso, $idAsignacion);
    END !
    DELIMITER ;



    -- =================== CONSULTAR DETALLEKIT ================ --

    DROP PROCEDURE IF EXISTS spConsultarDetallekit;
    DELIMITER !
    CREATE PROCEDURE spConsultarDetallekit(IN $idDetallekit INT)
    BEGIN
    SELECT * FROM `tbl_detallekit` WHERE `idDetallekit` = $idDetallekit;
    END !
    DELIMITER ;



    -- ================== MODIFICAR DETALLEKIT ================= --

    DROP PROCEDURE IF EXISTS spModificarDetallekit;
    DELIMITER !
    CREATE PROCEDURE spModificarDetallekit(IN $idDetallekit INT, IN $cantidadAsignada int(11), IN $cantidadFinal int(11), IN $idrecurso int(11), IN $idAsignacion int(11))
    BEGIN
    UPDATE `tbl_detallekit` SET `cantidadAsignada` = $cantidadAsignada, `cantidadFinal` = $cantidadFinal, `idrecurso` = $idrecurso, `idAsignacion` = $idAsignacion WHERE `idDetallekit` = $idDetallekit;
    END !
    DELIMITER ;



    -- ==================== LISTAR DETALLEKIT ================== --

    DROP PROCEDURE IF EXISTS spListarDetallekit;
    DELIMITER !
    CREATE PROCEDURE spListarDetallekit()
    BEGIN
    SELECT * FROM `tbl_detallekit`;
    END !
    DELIMITER ;





    -- # CRUD tbl_detalletratamientodmcrecurso --


    -- ================== REGISTRAR DETALLETRATAMIENTODMCRECURSO ================= --

    DROP PROCEDURE IF EXISTS spRegistrarDetalletratamientodmcrecurso;
    DELIMITER !
    CREATE PROCEDURE spRegistrarDetalletratamientodmcrecurso(IN $idRecurso int(11), IN $idTratamiento int(11))
    BEGIN
    INSERT INTO `tbl_detalletratamientodmcrecurso`(`idRecurso`, `idTratamiento`) VALUES ($idRecurso, $idTratamiento);
    END !
    DELIMITER ;



    -- =================== CONSULTAR DETALLETRATAMIENTODMCRECURSO ================ --

    DROP PROCEDURE IF EXISTS spConsultarDetalletratamientodmcrecurso;
    DELIMITER !
    CREATE PROCEDURE spConsultarDetalletratamientodmcrecurso(IN $idDetalleTratamientodmcRecurso INT)
    BEGIN
    SELECT * FROM `tbl_detalletratamientodmcrecurso` WHERE `idDetalleTratamientodmcRecurso` = $idDetalleTratamientodmcRecurso;
    END !
    DELIMITER ;



    -- ================== MODIFICAR DETALLETRATAMIENTODMCRECURSO ================= --

    DROP PROCEDURE IF EXISTS spModificarDetalletratamientodmcrecurso;
    DELIMITER !
    CREATE PROCEDURE spModificarDetalletratamientodmcrecurso(IN $idDetalleTratamientodmcRecurso INT, IN $idRecurso int(11), IN $idTratamiento int(11))
    BEGIN
    UPDATE `tbl_detalletratamientodmcrecurso` SET `idRecurso` = $idRecurso, `idTratamiento` = $idTratamiento WHERE `idDetalleTratamientodmcRecurso` = $idDetalleTratamientodmcRecurso;
    END !
    DELIMITER ;



    -- ==================== LISTAR DETALLETRATAMIENTODMCRECURSO ================== --

    DROP PROCEDURE IF EXISTS spListarDetalletratamientodmcrecurso;
    DELIMITER !
    CREATE PROCEDURE spListarDetalletratamientodmcrecurso()
    BEGIN
    SELECT * FROM `tbl_detalletratamientodmcrecurso`;
    END !
    DELIMITER ;





    -- # CRUD tbl_devolucion --


    -- ================== REGISTRAR DEVOLUCION ================= --

    DROP PROCEDURE IF EXISTS spRegistrarDevolucion;
    DELIMITER !
    CREATE PROCEDURE spRegistrarDevolucion(IN $cantidad int(11), IN $fechaHoraDevolucion datetime, IN $estadoTablaDevolucion varchar(45), IN $idTipoDevolucion int(11), IN $idDetallekit int(11), IN $idPersona int(11))
    BEGIN
    INSERT INTO `tbl_devolucion`(`cantidad`, `fechaHoraDevolucion`, `estadoTablaDevolucion`, `idTipoDevolucion`, `idDetallekit`, `idPersona`) VALUES ($cantidad, $fechaHoraDevolucion, $estadoTablaDevolucion, $idTipoDevolucion, $idDetallekit, $idPersona);
    END !
    DELIMITER ;



    -- =================== CONSULTAR DEVOLUCION ================ --

    DROP PROCEDURE IF EXISTS spConsultarDevolucion;
    DELIMITER !
    CREATE PROCEDURE spConsultarDevolucion(IN $idDevolucion INT)
    BEGIN
    SELECT * FROM `tbl_devolucion` WHERE `idDevolucion` = $idDevolucion;
    END !
    DELIMITER ;



    -- ================== MODIFICAR DEVOLUCION ================= --

    DROP PROCEDURE IF EXISTS spModificarDevolucion;
    DELIMITER !
    CREATE PROCEDURE spModificarDevolucion(IN $idDevolucion INT, IN $cantidad int(11), IN $fechaHoraDevolucion datetime, IN $idTipoDevolucion int(11), IN $idDetallekit int(11), IN $idPersona int(11))
    BEGIN
    UPDATE `tbl_devolucion` SET `cantidad` = $cantidad, `fechaHoraDevolucion` = $fechaHoraDevolucion, `idTipoDevolucion` = $idTipoDevolucion, `idDetallekit` = $idDetallekit, `idPersona` = $idPersona WHERE `idDevolucion` = $idDevolucion;
    END !
    DELIMITER ;



    -- ==================== LISTAR DEVOLUCION ================== --

    DROP PROCEDURE IF EXISTS spListarDevolucion;
    DELIMITER !
    CREATE PROCEDURE spListarDevolucion()
    BEGIN
    SELECT * FROM `tbl_devolucion`;
    END !
    DELIMITER ;


      -- ================== CAMBIAR ESTADO DEVOLUCION ================= --

      DROP PROCEDURE IF EXISTS spCambiarEstadoDevolucion;
      DELIMITER !
      CREATE PROCEDURE spCambiarEstadoDevolucion(IN $idDevolucion INT, IN $estadoTablaDevolucion varchar(45))
      BEGIN
      UPDATE `tbl_devolucion` SET `estadoTablaDevolucion` = $estadoTablaDevolucion WHERE `idDevolucion` = $idDevolucion;
      END !
      DELIMITER ;



    -- # CRUD tbl_diagnostico --


    -- ================== REGISTRAR DIAGNOSTICO ================= --

    DROP PROCEDURE IF EXISTS spRegistrarDiagnostico;
    DELIMITER !
    CREATE PROCEDURE spRegistrarDiagnostico(IN $idHistoriaClinica int(11), IN $descripcionDiagnostico text, IN $idCIE10 int(11))
    BEGIN
    INSERT INTO `tbl_diagnostico`(`idHistoriaClinica`, `descripcionDiagnostico`, `idCIE10`) VALUES ($idHistoriaClinica, $descripcionDiagnostico, $idCIE10);
    END !
    DELIMITER ;



    -- =================== CONSULTAR DIAGNOSTICO ================ --

    DROP PROCEDURE IF EXISTS spConsultarDiagnostico;
    DELIMITER !
    CREATE PROCEDURE spConsultarDiagnostico(IN $idDiagnostico INT)
    BEGIN
    SELECT * FROM `tbl_diagnostico` WHERE `idDiagnostico` = $idDiagnostico;
    END !
    DELIMITER ;



    -- ================== MODIFICAR DIAGNOSTICO ================= --

    DROP PROCEDURE IF EXISTS spModificarDiagnostico;
    DELIMITER !
    CREATE PROCEDURE spModificarDiagnostico(IN $idDiagnostico INT, IN $idHistoriaClinica int(11), IN $descripcionDiagnostico text, IN $idCIE10 int(11))
    BEGIN
    UPDATE `tbl_diagnostico` SET `idHistoriaClinica` = $idHistoriaClinica, `descripcionDiagnostico` = $descripcionDiagnostico, `idCIE10` = $idCIE10 WHERE `idDiagnostico` = $idDiagnostico;
    END !
    DELIMITER ;



    -- ==================== LISTAR DIAGNOSTICO ================== --

    DROP PROCEDURE IF EXISTS spListarDiagnostico;
    DELIMITER !
    CREATE PROCEDURE spListarDiagnostico()
    BEGIN
    SELECT * FROM `tbl_diagnostico`;
    END !
    DELIMITER ;





    -- # CRUD tbl_enteexterno --


    -- ================== REGISTRAR ENTEEXTERNO ================= --

    DROP PROCEDURE IF EXISTS spRegistrarEnteexterno;
    DELIMITER !
    CREATE PROCEDURE spRegistrarEnteexterno(IN $descripcionEnteExterno varchar(45), IN $estadoTabla varchar(50))
    BEGIN
    INSERT INTO `tbl_enteexterno`(`descripcionEnteExterno`, `estadoTabla`) VALUES ($descripcionEnteExterno, $estadoTabla);
    END !
    DELIMITER ;



    -- =================== CONSULTAR ENTEEXTERNO ================ --

    DROP PROCEDURE IF EXISTS spConsultarEnteexterno;
    DELIMITER !
    CREATE PROCEDURE spConsultarEnteexterno(IN $idEnteExterno INT)
    BEGIN
    SELECT * FROM `tbl_enteexterno` WHERE `idEnteExterno` = $idEnteExterno;
    END !
    DELIMITER ;



    -- ================== MODIFICAR ENTEEXTERNO ================= --

    DROP PROCEDURE IF EXISTS spModificarEnteexterno;
    DELIMITER !
    CREATE PROCEDURE spModificarEnteexterno(IN $idEnteExterno INT, IN $descripcionEnteExterno varchar(45))
    BEGIN
    UPDATE `tbl_enteexterno` SET `descripcionEnteExterno` = $descripcionEnteExterno WHERE `idEnteExterno` = $idEnteExterno;
    END !
    DELIMITER ;



    -- ==================== LISTAR ENTEEXTERNO ================== --

    DROP PROCEDURE IF EXISTS spListarEnteexterno;
    DELIMITER !
    CREATE PROCEDURE spListarEnteexterno()
    BEGIN
    SELECT * FROM `tbl_enteexterno`;
    END !
    DELIMITER ;


      -- ================== CAMBIAR ESTADO ENTEEXTERNO ================= --

      DROP PROCEDURE IF EXISTS spCambiarEstadoEnteexterno;
      DELIMITER !
      CREATE PROCEDURE spCambiarEstadoEnteexterno(IN $idEnteExterno INT, IN $estadoTabla varchar(50))
      BEGIN
      UPDATE `tbl_enteexterno` SET `estadoTabla` = $estadoTabla WHERE `idEnteExterno` = $idEnteExterno;
      END !
      DELIMITER ;



    -- # CRUD tbl_enteexterno_reporteinicial --


    -- ================== REGISTRAR ENTEEXTERNO_REPORTEINICIAL ================= --

    DROP PROCEDURE IF EXISTS spRegistrarEnteexterno_reporteinicial;
    DELIMITER !
    CREATE PROCEDURE spRegistrarEnteexterno_reporteinicial(IN $idEnteExterno int(11), IN $idReporteInicial int(11))
    BEGIN
    INSERT INTO `tbl_enteexterno_reporteinicial`(`idEnteExterno`, `idReporteInicial`) VALUES ($idEnteExterno, $idReporteInicial);
    END !
    DELIMITER ;



    -- =================== CONSULTAR ENTEEXTERNO_REPORTEINICIAL ================ --

    DROP PROCEDURE IF EXISTS spConsultarEnteexterno_reporteinicial;
    DELIMITER !
    CREATE PROCEDURE spConsultarEnteexterno_reporteinicial(IN $idEnteExternoReporteInicial INT)
    BEGIN
    SELECT * FROM `tbl_enteexterno_reporteinicial` WHERE `idEnteExternoReporteInicial` = $idEnteExternoReporteInicial;
    END !
    DELIMITER ;



    -- ================== MODIFICAR ENTEEXTERNO_REPORTEINICIAL ================= --

    DROP PROCEDURE IF EXISTS spModificarEnteexterno_reporteinicial;
    DELIMITER !
    CREATE PROCEDURE spModificarEnteexterno_reporteinicial(IN $idEnteExternoReporteInicial INT, IN $idEnteExterno int(11), IN $idReporteInicial int(11))
    BEGIN
    UPDATE `tbl_enteexterno_reporteinicial` SET `idEnteExterno` = $idEnteExterno, `idReporteInicial` = $idReporteInicial WHERE `idEnteExternoReporteInicial` = $idEnteExternoReporteInicial;
    END !
    DELIMITER ;



    -- ==================== LISTAR ENTEEXTERNO_REPORTEINICIAL ================== --

    DROP PROCEDURE IF EXISTS spListarEnteexterno_reporteinicial;
    DELIMITER !
    CREATE PROCEDURE spListarEnteexterno_reporteinicial()
    BEGIN
    SELECT * FROM `tbl_enteexterno_reporteinicial`;
    END !
    DELIMITER ;





    -- # CRUD tbl_equipobiomedico --


    -- ================== REGISTRAR EQUIPOBIOMEDICO ================= --

    DROP PROCEDURE IF EXISTS spRegistrarEquipobiomedico;
    DELIMITER !
    CREATE PROCEDURE spRegistrarEquipobiomedico(IN $descripcion varchar(50), IN $idTratamiento int(11))
    BEGIN
    INSERT INTO `tbl_equipobiomedico`(`descripcion`, `idTratamiento`) VALUES ($descripcion, $idTratamiento);
    END !
    DELIMITER ;



    -- =================== CONSULTAR EQUIPOBIOMEDICO ================ --

    DROP PROCEDURE IF EXISTS spConsultarEquipobiomedico;
    DELIMITER !
    CREATE PROCEDURE spConsultarEquipobiomedico(IN $idEquipoBiomedico INT)
    BEGIN
    SELECT * FROM `tbl_equipobiomedico` WHERE `idEquipoBiomedico` = $idEquipoBiomedico;
    END !
    DELIMITER ;



    -- ================== MODIFICAR EQUIPOBIOMEDICO ================= --

    DROP PROCEDURE IF EXISTS spModificarEquipobiomedico;
    DELIMITER !
    CREATE PROCEDURE spModificarEquipobiomedico(IN $idEquipoBiomedico INT, IN $descripcion varchar(50), IN $idTratamiento int(11))
    BEGIN
    UPDATE `tbl_equipobiomedico` SET `descripcion` = $descripcion, `idTratamiento` = $idTratamiento WHERE `idEquipoBiomedico` = $idEquipoBiomedico;
    END !
    DELIMITER ;



    -- ==================== LISTAR EQUIPOBIOMEDICO ================== --

    DROP PROCEDURE IF EXISTS spListarEquipobiomedico;
    DELIMITER !
    CREATE PROCEDURE spListarEquipobiomedico()
    BEGIN
    SELECT * FROM `tbl_equipobiomedico`;
    END !
    DELIMITER ;





    -- # CRUD tbl_especialidad --


    -- ================== REGISTRAR ESPECIALIDAD ================= --

    DROP PROCEDURE IF EXISTS spRegistrarEspecialidad;
    DELIMITER !
    CREATE PROCEDURE spRegistrarEspecialidad(IN $descripcionEspecialidad varchar(45), IN $estadoTabla varchar(50))
    BEGIN
    INSERT INTO `tbl_especialidad`(`descripcionEspecialidad`, `estadoTabla`) VALUES ($descripcionEspecialidad, $estadoTabla);
    END !
    DELIMITER ;



    -- =================== CONSULTAR ESPECIALIDAD ================ --

    DROP PROCEDURE IF EXISTS spConsultarEspecialidad;
    DELIMITER !
    CREATE PROCEDURE spConsultarEspecialidad(IN $idEspecialidad INT)
    BEGIN
    SELECT * FROM `tbl_especialidad` WHERE `idEspecialidad` = $idEspecialidad;
    END !
    DELIMITER ;



    -- ================== MODIFICAR ESPECIALIDAD ================= --

    DROP PROCEDURE IF EXISTS spModificarEspecialidad;
    DELIMITER !
    CREATE PROCEDURE spModificarEspecialidad(IN $idEspecialidad INT, IN $descripcionEspecialidad varchar(45))
    BEGIN
    UPDATE `tbl_especialidad` SET `descripcionEspecialidad` = $descripcionEspecialidad WHERE `idEspecialidad` = $idEspecialidad;
    END !
    DELIMITER ;



    -- ==================== LISTAR ESPECIALIDAD ================== --

    DROP PROCEDURE IF EXISTS spListarEspecialidad;
    DELIMITER !
    CREATE PROCEDURE spListarEspecialidad()
    BEGIN
    SELECT * FROM `tbl_especialidad`;
    END !
    DELIMITER ;


      -- ================== CAMBIAR ESTADO ESPECIALIDAD ================= --

      DROP PROCEDURE IF EXISTS spCambiarEstadoEspecialidad;
      DELIMITER !
      CREATE PROCEDURE spCambiarEstadoEspecialidad(IN $idEspecialidad INT, IN $estadoTabla varchar(50))
      BEGIN
      UPDATE `tbl_especialidad` SET `estadoTabla` = $estadoTabla WHERE `idEspecialidad` = $idEspecialidad;
      END !
      DELIMITER ;



    -- # CRUD tbl_estadopaciente --


    -- ================== REGISTRAR ESTADOPACIENTE ================= --

    DROP PROCEDURE IF EXISTS spRegistrarEstadopaciente;
    DELIMITER !
    CREATE PROCEDURE spRegistrarEstadopaciente(IN $descripcionEstadoPaciente varchar(50), IN $estadoTabla varchar(50))
    BEGIN
    INSERT INTO `tbl_estadopaciente`(`descripcionEstadoPaciente`, `estadoTabla`) VALUES ($descripcionEstadoPaciente, $estadoTabla);
    END !
    DELIMITER ;



    -- =================== CONSULTAR ESTADOPACIENTE ================ --

    DROP PROCEDURE IF EXISTS spConsultarEstadopaciente;
    DELIMITER !
    CREATE PROCEDURE spConsultarEstadopaciente(IN $idEstadoPaciente INT)
    BEGIN
    SELECT * FROM `tbl_estadopaciente` WHERE `idEstadoPaciente` = $idEstadoPaciente;
    END !
    DELIMITER ;



    -- ================== MODIFICAR ESTADOPACIENTE ================= --

    DROP PROCEDURE IF EXISTS spModificarEstadopaciente;
    DELIMITER !
    CREATE PROCEDURE spModificarEstadopaciente(IN $idEstadoPaciente INT, IN $descripcionEstadoPaciente varchar(50))
    BEGIN
    UPDATE `tbl_estadopaciente` SET `descripcionEstadoPaciente` = $descripcionEstadoPaciente WHERE `idEstadoPaciente` = $idEstadoPaciente;
    END !
    DELIMITER ;



    -- ==================== LISTAR ESTADOPACIENTE ================== --

    DROP PROCEDURE IF EXISTS spListarEstadopaciente;
    DELIMITER !
    CREATE PROCEDURE spListarEstadopaciente()
    BEGIN
    SELECT * FROM `tbl_estadopaciente`;
    END !
    DELIMITER ;


      -- ================== CAMBIAR ESTADO ESTADOPACIENTE ================= --

      DROP PROCEDURE IF EXISTS spCambiarEstadoEstadopaciente;
      DELIMITER !
      CREATE PROCEDURE spCambiarEstadoEstadopaciente(IN $idEstadoPaciente INT, IN $estadoTabla varchar(50))
      BEGIN
      UPDATE `tbl_estadopaciente` SET `estadoTabla` = $estadoTabla WHERE `idEstadoPaciente` = $idEstadoPaciente;
      END !
      DELIMITER ;



    -- # CRUD tbl_estandarkit --


    -- ================== REGISTRAR ESTANDARKIT ================= --

    DROP PROCEDURE IF EXISTS spRegistrarEstandarkit;
    DELIMITER !
    CREATE PROCEDURE spRegistrarEstandarkit(IN $idRecurso int(11), IN $unidadMedida varchar(30), IN $stockminKit int(11), IN $idTipoKit int(11), IN $estadoTablaEstandarKit varchar(45))
    BEGIN
    INSERT INTO `tbl_estandarkit`(`idRecurso`, `unidadMedida`, `stockminKit`, `idTipoKit`, `estadoTablaEstandarKit`) VALUES ($idRecurso, $unidadMedida, $stockminKit, $idTipoKit, $estadoTablaEstandarKit);
    END !
    DELIMITER ;



    -- =================== CONSULTAR ESTANDARKIT ================ --

    DROP PROCEDURE IF EXISTS spConsultarEstandarkit;
    DELIMITER !
    CREATE PROCEDURE spConsultarEstandarkit(IN $idEstandarkit INT)
    BEGIN
    SELECT * FROM `tbl_estandarkit` WHERE `idEstandarkit` = $idEstandarkit;
    END !
    DELIMITER ;



    -- ================== MODIFICAR ESTANDARKIT ================= --

    DROP PROCEDURE IF EXISTS spModificarEstandarkit;
    DELIMITER !
    CREATE PROCEDURE spModificarEstandarkit(IN $idEstandarkit INT, IN $idRecurso int(11), IN $unidadMedida varchar(30), IN $stockminKit int(11), IN $idTipoKit int(11))
    BEGIN
    UPDATE `tbl_estandarkit` SET `idRecurso` = $idRecurso, `unidadMedida` = $unidadMedida, `stockminKit` = $stockminKit, `idTipoKit` = $idTipoKit WHERE `idEstandarkit` = $idEstandarkit;
    END !
    DELIMITER ;



    -- ==================== LISTAR ESTANDARKIT ================== --

    DROP PROCEDURE IF EXISTS spListarEstandarkit;
    DELIMITER !
    CREATE PROCEDURE spListarEstandarkit()
    BEGIN
    SELECT * FROM `tbl_estandarkit`;
    END !
    DELIMITER ;


      -- ================== CAMBIAR ESTADO ESTANDARKIT ================= --

      DROP PROCEDURE IF EXISTS spCambiarEstadoEstandarkit;
      DELIMITER !
      CREATE PROCEDURE spCambiarEstadoEstandarkit(IN $idEstandarkit INT, IN $estadoTablaEstandarKit varchar(45))
      BEGIN
      UPDATE `tbl_estandarkit` SET `estadoTablaEstandarKit` = $estadoTablaEstandarKit WHERE `idEstandarkit` = $idEstandarkit;
      END !
      DELIMITER ;



    -- # CRUD tbl_evaluacionautorizacion --


    -- ================== REGISTRAR EVALUACIONAUTORIZACION ================= --

    DROP PROCEDURE IF EXISTS spRegistrarEvaluacionautorizacion;
    DELIMITER !
    CREATE PROCEDURE spRegistrarEvaluacionautorizacion(IN $idReporteAPH int(11), IN $idCuentaMedico int(11), IN $idAutorizacion int(11), IN $evaluacionAutorizacion varchar(45), IN $descripcionEvaluacion varchar(100))
    BEGIN
    INSERT INTO `tbl_evaluacionautorizacion`(`idReporteAPH`, `idCuentaMedico`, `idAutorizacion`, `evaluacionAutorizacion`, `descripcionEvaluacion`) VALUES ($idReporteAPH, $idCuentaMedico, $idAutorizacion, $evaluacionAutorizacion, $descripcionEvaluacion);
    END !
    DELIMITER ;



    -- =================== CONSULTAR EVALUACIONAUTORIZACION ================ --

    DROP PROCEDURE IF EXISTS spConsultarEvaluacionautorizacion;
    DELIMITER !
    CREATE PROCEDURE spConsultarEvaluacionautorizacion(IN $idEvaluacionAutorizacion INT)
    BEGIN
    SELECT * FROM `tbl_evaluacionautorizacion` WHERE `idEvaluacionAutorizacion` = $idEvaluacionAutorizacion;
    END !
    DELIMITER ;



    -- ================== MODIFICAR EVALUACIONAUTORIZACION ================= --

    DROP PROCEDURE IF EXISTS spModificarEvaluacionautorizacion;
    DELIMITER !
    CREATE PROCEDURE spModificarEvaluacionautorizacion(IN $idEvaluacionAutorizacion INT, IN $idReporteAPH int(11), IN $idCuentaMedico int(11), IN $idAutorizacion int(11), IN $evaluacionAutorizacion varchar(45), IN $descripcionEvaluacion varchar(100))
    BEGIN
    UPDATE `tbl_evaluacionautorizacion` SET `idReporteAPH` = $idReporteAPH, `idCuentaMedico` = $idCuentaMedico, `idAutorizacion` = $idAutorizacion, `evaluacionAutorizacion` = $evaluacionAutorizacion, `descripcionEvaluacion` = $descripcionEvaluacion WHERE `idEvaluacionAutorizacion` = $idEvaluacionAutorizacion;
    END !
    DELIMITER ;



    -- ==================== LISTAR EVALUACIONAUTORIZACION ================== --

    DROP PROCEDURE IF EXISTS spListarEvaluacionautorizacion;
    DELIMITER !
    CREATE PROCEDURE spListarEvaluacionautorizacion()
    BEGIN
    SELECT * FROM `tbl_evaluacionautorizacion`;
    END !
    DELIMITER ;





    -- # CRUD tbl_examenespecializado --


    -- ================== REGISTRAR EXAMENESPECIALIZADO ================= --

    DROP PROCEDURE IF EXISTS spRegistrarExamenespecializado;
    DELIMITER !
    CREATE PROCEDURE spRegistrarExamenespecializado(IN $observaciones text, IN $idTipoexamenespecializado int(11), IN $idHistoriaClinica int(11), IN $descripcion text)
    BEGIN
    INSERT INTO `tbl_examenespecializado`(`observaciones`, `idTipoexamenespecializado`, `idHistoriaClinica`, `descripcion`) VALUES ($observaciones, $idTipoexamenespecializado, $idHistoriaClinica, $descripcion);
    END !
    DELIMITER ;



    -- =================== CONSULTAR EXAMENESPECIALIZADO ================ --

    DROP PROCEDURE IF EXISTS spConsultarExamenespecializado;
    DELIMITER !
    CREATE PROCEDURE spConsultarExamenespecializado(IN $idExamenEspecializado INT)
    BEGIN
    SELECT * FROM `tbl_examenespecializado` WHERE `idExamenEspecializado` = $idExamenEspecializado;
    END !
    DELIMITER ;



    -- ================== MODIFICAR EXAMENESPECIALIZADO ================= --

    DROP PROCEDURE IF EXISTS spModificarExamenespecializado;
    DELIMITER !
    CREATE PROCEDURE spModificarExamenespecializado(IN $idExamenEspecializado INT, IN $observaciones text, IN $idTipoexamenespecializado int(11), IN $idHistoriaClinica int(11), IN $descripcion text)
    BEGIN
    UPDATE `tbl_examenespecializado` SET `observaciones` = $observaciones, `idTipoexamenespecializado` = $idTipoexamenespecializado, `idHistoriaClinica` = $idHistoriaClinica, `descripcion` = $descripcion WHERE `idExamenEspecializado` = $idExamenEspecializado;
    END !
    DELIMITER ;



    -- ==================== LISTAR EXAMENESPECIALIZADO ================== --

    DROP PROCEDURE IF EXISTS spListarExamenespecializado;
    DELIMITER !
    CREATE PROCEDURE spListarExamenespecializado()
    BEGIN
    SELECT * FROM `tbl_examenespecializado`;
    END !
    DELIMITER ;





    -- # CRUD tbl_examenfisicoaph --


    -- ================== REGISTRAR EXAMENFISICOAPH ================= --

    DROP PROCEDURE IF EXISTS spRegistrarExamenfisicoaph;
    DELIMITER !
    CREATE PROCEDURE spRegistrarExamenfisicoaph(IN $horaExamenFisico time, IN $estadoRespiracion varchar(45), IN $respiracion_min int(11), IN $SpO2 varchar(45), IN $estadoPulso varchar(45), IN $pulsaciones_min int(11), IN $estadoPresionArterial varchar(45), IN $sistolica float, IN $diastolica float, IN $PAM float, IN $glucometria float, IN $conciencia varchar(45), IN $glasgow varchar(45), IN $estadoPupilaD varchar(45), IN $estadoPupilaI varchar(45), IN $gradoDilatacionPD float, IN $gradoDilatacionPI float, IN $estadoHemodinamico varchar(45), IN $especificacionVerbal varchar(100), IN $especificacionOcular varchar(100), IN $especificacionMotor varchar(100), IN $EspecifiqueExamenFisico text)
    BEGIN
    INSERT INTO `tbl_examenfisicoaph`(`horaExamenFisico`, `estadoRespiracion`, `respiracion_min`, `SpO2`, `estadoPulso`, `pulsaciones_min`, `estadoPresionArterial`, `sistolica`, `diastolica`, `PAM`, `glucometria`, `conciencia`, `glasgow`, `estadoPupilaD`, `estadoPupilaI`, `gradoDilatacionPD`, `gradoDilatacionPI`, `estadoHemodinamico`, `especificacionVerbal`, `especificacionOcular`, `especificacionMotor`, `EspecifiqueExamenFisico`) VALUES ($horaExamenFisico, $estadoRespiracion, $respiracion_min, $SpO2, $estadoPulso, $pulsaciones_min, $estadoPresionArterial, $sistolica, $diastolica, $PAM, $glucometria, $conciencia, $glasgow, $estadoPupilaD, $estadoPupilaI, $gradoDilatacionPD, $gradoDilatacionPI, $estadoHemodinamico, $especificacionVerbal, $especificacionOcular, $especificacionMotor, $EspecifiqueExamenFisico);
    END !
    DELIMITER ;



    -- =================== CONSULTAR EXAMENFISICOAPH ================ --

    DROP PROCEDURE IF EXISTS spConsultarExamenfisicoaph;
    DELIMITER !
    CREATE PROCEDURE spConsultarExamenfisicoaph(IN $idExamenFisico INT)
    BEGIN
    SELECT * FROM `tbl_examenfisicoaph` WHERE `idExamenFisico` = $idExamenFisico;
    END !
    DELIMITER ;



    -- ================== MODIFICAR EXAMENFISICOAPH ================= --

    DROP PROCEDURE IF EXISTS spModificarExamenfisicoaph;
    DELIMITER !
    CREATE PROCEDURE spModificarExamenfisicoaph(IN $idExamenFisico INT, IN $horaExamenFisico time, IN $estadoRespiracion varchar(45), IN $respiracion_min int(11), IN $SpO2 varchar(45), IN $estadoPulso varchar(45), IN $pulsaciones_min int(11), IN $estadoPresionArterial varchar(45), IN $sistolica float, IN $diastolica float, IN $PAM float, IN $glucometria float, IN $conciencia varchar(45), IN $glasgow varchar(45), IN $estadoPupilaD varchar(45), IN $estadoPupilaI varchar(45), IN $gradoDilatacionPD float, IN $gradoDilatacionPI float, IN $estadoHemodinamico varchar(45), IN $especificacionVerbal varchar(100), IN $especificacionOcular varchar(100), IN $especificacionMotor varchar(100), IN $EspecifiqueExamenFisico text)
    BEGIN
    UPDATE `tbl_examenfisicoaph` SET `horaExamenFisico` = $horaExamenFisico, `estadoRespiracion` = $estadoRespiracion, `respiracion_min` = $respiracion_min, `SpO2` = $SpO2, `estadoPulso` = $estadoPulso, `pulsaciones_min` = $pulsaciones_min, `estadoPresionArterial` = $estadoPresionArterial, `sistolica` = $sistolica, `diastolica` = $diastolica, `PAM` = $PAM, `glucometria` = $glucometria, `conciencia` = $conciencia, `glasgow` = $glasgow, `estadoPupilaD` = $estadoPupilaD, `estadoPupilaI` = $estadoPupilaI, `gradoDilatacionPD` = $gradoDilatacionPD, `gradoDilatacionPI` = $gradoDilatacionPI, `estadoHemodinamico` = $estadoHemodinamico, `especificacionVerbal` = $especificacionVerbal, `especificacionOcular` = $especificacionOcular, `especificacionMotor` = $especificacionMotor, `EspecifiqueExamenFisico` = $EspecifiqueExamenFisico WHERE `idExamenFisico` = $idExamenFisico;
    END !
    DELIMITER ;



    -- ==================== LISTAR EXAMENFISICOAPH ================== --

    DROP PROCEDURE IF EXISTS spListarExamenfisicoaph;
    DELIMITER !
    CREATE PROCEDURE spListarExamenfisicoaph()
    BEGIN
    SELECT * FROM `tbl_examenfisicoaph`;
    END !
    DELIMITER ;





    -- # CRUD tbl_examenfisicodmc --


    -- ================== REGISTRAR EXAMENFISICODMC ================= --

    DROP PROCEDURE IF EXISTS spRegistrarExamenfisicodmc;
    DELIMITER !
    CREATE PROCEDURE spRegistrarExamenfisicodmc(IN $idHistoriaClinica int(11), IN $estadoTablaExamen varchar(45), IN $descripcionExamen text, IN $idtipoExamenFisico int(11))
    BEGIN
    INSERT INTO `tbl_examenfisicodmc`(`idHistoriaClinica`, `estadoTablaExamen`, `descripcionExamen`, `idtipoExamenFisico`) VALUES ($idHistoriaClinica, $estadoTablaExamen, $descripcionExamen, $idtipoExamenFisico);
    END !
    DELIMITER ;



    -- =================== CONSULTAR EXAMENFISICODMC ================ --

    DROP PROCEDURE IF EXISTS spConsultarExamenfisicodmc;
    DELIMITER !
    CREATE PROCEDURE spConsultarExamenfisicodmc(IN $idExamenFisico INT)
    BEGIN
    SELECT * FROM `tbl_examenfisicodmc` WHERE `idExamenFisico` = $idExamenFisico;
    END !
    DELIMITER ;



    -- ================== MODIFICAR EXAMENFISICODMC ================= --

    DROP PROCEDURE IF EXISTS spModificarExamenfisicodmc;
    DELIMITER !
    CREATE PROCEDURE spModificarExamenfisicodmc(IN $idExamenFisico INT, IN $idHistoriaClinica int(11), IN $descripcionExamen text, IN $idtipoExamenFisico int(11))
    BEGIN
    UPDATE `tbl_examenfisicodmc` SET `idHistoriaClinica` = $idHistoriaClinica, `descripcionExamen` = $descripcionExamen, `idtipoExamenFisico` = $idtipoExamenFisico WHERE `idExamenFisico` = $idExamenFisico;
    END !
    DELIMITER ;



    -- ==================== LISTAR EXAMENFISICODMC ================== --

    DROP PROCEDURE IF EXISTS spListarExamenfisicodmc;
    DELIMITER !
    CREATE PROCEDURE spListarExamenfisicodmc()
    BEGIN
    SELECT * FROM `tbl_examenfisicodmc`;
    END !
    DELIMITER ;


      -- ================== CAMBIAR ESTADO EXAMENFISICODMC ================= --

      DROP PROCEDURE IF EXISTS spCambiarEstadoExamenfisicodmc;
      DELIMITER !
      CREATE PROCEDURE spCambiarEstadoExamenfisicodmc(IN $idExamenFisico INT, IN $estadoTablaExamen varchar(45))
      BEGIN
      UPDATE `tbl_examenfisicodmc` SET `estadoTablaExamen` = $estadoTablaExamen WHERE `idExamenFisico` = $idExamenFisico;
      END !
      DELIMITER ;



    -- # CRUD tbl_formulamedica --


    -- ================== REGISTRAR FORMULAMEDICA ================= --

    DROP PROCEDURE IF EXISTS spRegistrarFormulamedica;
    DELIMITER !
    CREATE PROCEDURE spRegistrarFormulamedica(IN $recomendaciones varchar(1000), IN $idHistoriaClinica int(11))
    BEGIN
    INSERT INTO `tbl_formulamedica`(`recomendaciones`, `idHistoriaClinica`) VALUES ($recomendaciones, $idHistoriaClinica);
    END !
    DELIMITER ;



    -- =================== CONSULTAR FORMULAMEDICA ================ --

    DROP PROCEDURE IF EXISTS spConsultarFormulamedica;
    DELIMITER !
    CREATE PROCEDURE spConsultarFormulamedica(IN $idFormulaMedica INT)
    BEGIN
    SELECT * FROM `tbl_formulamedica` WHERE `idFormulaMedica` = $idFormulaMedica;
    END !
    DELIMITER ;



    -- ================== MODIFICAR FORMULAMEDICA ================= --

    DROP PROCEDURE IF EXISTS spModificarFormulamedica;
    DELIMITER !
    CREATE PROCEDURE spModificarFormulamedica(IN $idFormulaMedica INT, IN $recomendaciones varchar(1000), IN $idHistoriaClinica int(11))
    BEGIN
    UPDATE `tbl_formulamedica` SET `recomendaciones` = $recomendaciones, `idHistoriaClinica` = $idHistoriaClinica WHERE `idFormulaMedica` = $idFormulaMedica;
    END !
    DELIMITER ;



    -- ==================== LISTAR FORMULAMEDICA ================== --

    DROP PROCEDURE IF EXISTS spListarFormulamedica;
    DELIMITER !
    CREATE PROCEDURE spListarFormulamedica()
    BEGIN
    SELECT * FROM `tbl_formulamedica`;
    END !
    DELIMITER ;





    -- # CRUD tbl_formulamedicamedicamentodmc --


    -- ================== REGISTRAR FORMULAMEDICAMEDICAMENTODMC ================= --

    DROP PROCEDURE IF EXISTS spRegistrarFormulamedicamedicamentodmc;
    DELIMITER !
    CREATE PROCEDURE spRegistrarFormulamedicamedicamentodmc(IN $idFormulamedica int(11), IN $idMedicamento int(11), IN $cantidadMedicamento int(11), IN $dosificacion varchar(100), IN $descripcion varchar(1000))
    BEGIN
    INSERT INTO `tbl_formulamedicamedicamentodmc`(`idFormulamedica`, `idMedicamento`, `cantidadMedicamento`, `dosificacion`, `descripcion`) VALUES ($idFormulamedica, $idMedicamento, $cantidadMedicamento, $dosificacion, $descripcion);
    END !
    DELIMITER ;



    -- =================== CONSULTAR FORMULAMEDICAMEDICAMENTODMC ================ --

    DROP PROCEDURE IF EXISTS spConsultarFormulamedicamedicamentodmc;
    DELIMITER !
    CREATE PROCEDURE spConsultarFormulamedicamedicamentodmc(IN $idFormulaMedicaMedicamentoDmc INT)
    BEGIN
    SELECT * FROM `tbl_formulamedicamedicamentodmc` WHERE `idFormulaMedicaMedicamentoDmc` = $idFormulaMedicaMedicamentoDmc;
    END !
    DELIMITER ;



    -- ================== MODIFICAR FORMULAMEDICAMEDICAMENTODMC ================= --

    DROP PROCEDURE IF EXISTS spModificarFormulamedicamedicamentodmc;
    DELIMITER !
    CREATE PROCEDURE spModificarFormulamedicamedicamentodmc(IN $idFormulaMedicaMedicamentoDmc INT, IN $idFormulamedica int(11), IN $idMedicamento int(11), IN $cantidadMedicamento int(11), IN $dosificacion varchar(100), IN $descripcion varchar(1000))
    BEGIN
    UPDATE `tbl_formulamedicamedicamentodmc` SET `idFormulamedica` = $idFormulamedica, `idMedicamento` = $idMedicamento, `cantidadMedicamento` = $cantidadMedicamento, `dosificacion` = $dosificacion, `descripcion` = $descripcion WHERE `idFormulaMedicaMedicamentoDmc` = $idFormulaMedicaMedicamentoDmc;
    END !
    DELIMITER ;



    -- ==================== LISTAR FORMULAMEDICAMEDICAMENTODMC ================== --

    DROP PROCEDURE IF EXISTS spListarFormulamedicamedicamentodmc;
    DELIMITER !
    CREATE PROCEDURE spListarFormulamedicamedicamentodmc()
    BEGIN
    SELECT * FROM `tbl_formulamedicamedicamentodmc`;
    END !
    DELIMITER ;





    -- # CRUD tbl_historiaclinica --


    -- ================== REGISTRAR HISTORIACLINICA ================= --

    DROP PROCEDURE IF EXISTS spRegistrarHistoriaclinica;
    DELIMITER !
    CREATE PROCEDURE spRegistrarHistoriaclinica(IN $fechaAtencion date, IN $motivoAtencion text, IN $enfermedadActual text, IN $placaVehiculo varchar(45), IN $idTipoorigenatencion int(11), IN $idCitaprogramacion int(11), IN $idPaciente int(11), IN $evolucion text)
    BEGIN
    INSERT INTO `tbl_historiaclinica`(`fechaAtencion`, `motivoAtencion`, `enfermedadActual`, `placaVehiculo`, `idTipoorigenatencion`, `idCitaprogramacion`, `idPaciente`, `evolucion`) VALUES ($fechaAtencion, $motivoAtencion, $enfermedadActual, $placaVehiculo, $idTipoorigenatencion, $idCitaprogramacion, $idPaciente, $evolucion);
    END !
    DELIMITER ;



    -- =================== CONSULTAR HISTORIACLINICA ================ --

    DROP PROCEDURE IF EXISTS spConsultarHistoriaclinica;
    DELIMITER !
    CREATE PROCEDURE spConsultarHistoriaclinica(IN $idHistoriaClinica INT)
    BEGIN
    SELECT * FROM `tbl_historiaclinica` WHERE `idHistoriaClinica` = $idHistoriaClinica;
    END !
    DELIMITER ;



    -- ================== MODIFICAR HISTORIACLINICA ================= --

    DROP PROCEDURE IF EXISTS spModificarHistoriaclinica;
    DELIMITER !
    CREATE PROCEDURE spModificarHistoriaclinica(IN $idHistoriaClinica INT, IN $fechaAtencion date, IN $motivoAtencion text, IN $enfermedadActual text, IN $placaVehiculo varchar(45), IN $idTipoorigenatencion int(11), IN $idCitaprogramacion int(11), IN $idPaciente int(11), IN $evolucion text)
    BEGIN
    UPDATE `tbl_historiaclinica` SET `fechaAtencion` = $fechaAtencion, `motivoAtencion` = $motivoAtencion, `enfermedadActual` = $enfermedadActual, `placaVehiculo` = $placaVehiculo, `idTipoorigenatencion` = $idTipoorigenatencion, `idCitaprogramacion` = $idCitaprogramacion, `idPaciente` = $idPaciente, `evolucion` = $evolucion WHERE `idHistoriaClinica` = $idHistoriaClinica;
    END !
    DELIMITER ;



    -- ==================== LISTAR HISTORIACLINICA ================== --

    DROP PROCEDURE IF EXISTS spListarHistoriaclinica;
    DELIMITER !
    CREATE PROCEDURE spListarHistoriaclinica()
    BEGIN
    SELECT * FROM `tbl_historiaclinica`;
    END !
    DELIMITER ;





    -- # CRUD tbl_historialmora --


    -- ================== REGISTRAR HISTORIALMORA ================= --

    DROP PROCEDURE IF EXISTS spRegistrarHistorialmora;
    DELIMITER !
    CREATE PROCEDURE spRegistrarHistorialmora(IN $fechaHistorial date, IN $descripcionHistorial varchar(45), IN $idCita int(11), IN $idMulta int(11))
    BEGIN
    INSERT INTO `tbl_historialmora`(`fechaHistorial`, `descripcionHistorial`, `idCita`, `idMulta`) VALUES ($fechaHistorial, $descripcionHistorial, $idCita, $idMulta);
    END !
    DELIMITER ;



    -- =================== CONSULTAR HISTORIALMORA ================ --

    DROP PROCEDURE IF EXISTS spConsultarHistorialmora;
    DELIMITER !
    CREATE PROCEDURE spConsultarHistorialmora(IN $idHistorialMora INT)
    BEGIN
    SELECT * FROM `tbl_historialmora` WHERE `idHistorialMora` = $idHistorialMora;
    END !
    DELIMITER ;



    -- ================== MODIFICAR HISTORIALMORA ================= --

    DROP PROCEDURE IF EXISTS spModificarHistorialmora;
    DELIMITER !
    CREATE PROCEDURE spModificarHistorialmora(IN $idHistorialMora INT, IN $fechaHistorial date, IN $descripcionHistorial varchar(45), IN $idCita int(11), IN $idMulta int(11))
    BEGIN
    UPDATE `tbl_historialmora` SET `fechaHistorial` = $fechaHistorial, `descripcionHistorial` = $descripcionHistorial, `idCita` = $idCita, `idMulta` = $idMulta WHERE `idHistorialMora` = $idHistorialMora;
    END !
    DELIMITER ;



    -- ==================== LISTAR HISTORIALMORA ================== --

    DROP PROCEDURE IF EXISTS spListarHistorialmora;
    DELIMITER !
    CREATE PROCEDURE spListarHistorialmora()
    BEGIN
    SELECT * FROM `tbl_historialmora`;
    END !
    DELIMITER ;





    -- # CRUD tbl_incapacidad --


    -- ================== REGISTRAR INCAPACIDAD ================= --

    DROP PROCEDURE IF EXISTS spRegistrarIncapacidad;
    DELIMITER !
    CREATE PROCEDURE spRegistrarIncapacidad(IN $cantidadDias int(11), IN $prorroga varchar(100), IN $descripcionMotivo text, IN $idCIE10 int(11), IN $idHistoriaClinica int(11))
    BEGIN
    INSERT INTO `tbl_incapacidad`(`cantidadDias`, `prorroga`, `descripcionMotivo`, `idCIE10`, `idHistoriaClinica`) VALUES ($cantidadDias, $prorroga, $descripcionMotivo, $idCIE10, $idHistoriaClinica);
    END !
    DELIMITER ;



    -- =================== CONSULTAR INCAPACIDAD ================ --

    DROP PROCEDURE IF EXISTS spConsultarIncapacidad;
    DELIMITER !
    CREATE PROCEDURE spConsultarIncapacidad(IN $idIncapacidad INT)
    BEGIN
    SELECT * FROM `tbl_incapacidad` WHERE `idIncapacidad` = $idIncapacidad;
    END !
    DELIMITER ;



    -- ================== MODIFICAR INCAPACIDAD ================= --

    DROP PROCEDURE IF EXISTS spModificarIncapacidad;
    DELIMITER !
    CREATE PROCEDURE spModificarIncapacidad(IN $idIncapacidad INT, IN $cantidadDias int(11), IN $prorroga varchar(100), IN $descripcionMotivo text, IN $idCIE10 int(11), IN $idHistoriaClinica int(11))
    BEGIN
    UPDATE `tbl_incapacidad` SET `cantidadDias` = $cantidadDias, `prorroga` = $prorroga, `descripcionMotivo` = $descripcionMotivo, `idCIE10` = $idCIE10, `idHistoriaClinica` = $idHistoriaClinica WHERE `idIncapacidad` = $idIncapacidad;
    END !
    DELIMITER ;



    -- ==================== LISTAR INCAPACIDAD ================== --

    DROP PROCEDURE IF EXISTS spListarIncapacidad;
    DELIMITER !
    CREATE PROCEDURE spListarIncapacidad()
    BEGIN
    SELECT * FROM `tbl_incapacidad`;
    END !
    DELIMITER ;





    -- # CRUD tbl_interconsulta --


    -- ================== REGISTRAR INTERCONSULTA ================= --

    DROP PROCEDURE IF EXISTS spRegistrarInterconsulta;
    DELIMITER !
    CREATE PROCEDURE spRegistrarInterconsulta(IN $descripcionInterconsulta text, IN $especialidad varchar(100), IN $idHistoriaClinica int(11), IN $fechaLimite date)
    BEGIN
    INSERT INTO `tbl_interconsulta`(`descripcionInterconsulta`, `especialidad`, `idHistoriaClinica`, `fechaLimite`) VALUES ($descripcionInterconsulta, $especialidad, $idHistoriaClinica, $fechaLimite);
    END !
    DELIMITER ;



    -- =================== CONSULTAR INTERCONSULTA ================ --

    DROP PROCEDURE IF EXISTS spConsultarInterconsulta;
    DELIMITER !
    CREATE PROCEDURE spConsultarInterconsulta(IN $idInterconsulta INT)
    BEGIN
    SELECT * FROM `tbl_interconsulta` WHERE `idInterconsulta` = $idInterconsulta;
    END !
    DELIMITER ;



    -- ================== MODIFICAR INTERCONSULTA ================= --

    DROP PROCEDURE IF EXISTS spModificarInterconsulta;
    DELIMITER !
    CREATE PROCEDURE spModificarInterconsulta(IN $idInterconsulta INT, IN $descripcionInterconsulta text, IN $especialidad varchar(100), IN $idHistoriaClinica int(11), IN $fechaLimite date)
    BEGIN
    UPDATE `tbl_interconsulta` SET `descripcionInterconsulta` = $descripcionInterconsulta, `especialidad` = $especialidad, `idHistoriaClinica` = $idHistoriaClinica, `fechaLimite` = $fechaLimite WHERE `idInterconsulta` = $idInterconsulta;
    END !
    DELIMITER ;



    -- ==================== LISTAR INTERCONSULTA ================== --

    DROP PROCEDURE IF EXISTS spListarInterconsulta;
    DELIMITER !
    CREATE PROCEDURE spListarInterconsulta()
    BEGIN
    SELECT * FROM `tbl_interconsulta`;
    END !
    DELIMITER ;





    -- # CRUD tbl_lesion --


    -- ================== REGISTRAR LESION ================= --

    DROP PROCEDURE IF EXISTS spRegistrarLesion;
    DELIMITER !
    CREATE PROCEDURE spRegistrarLesion(IN $idPuntoLesion int(11), IN $especificacionLesion varchar(100), IN $idCIE10 int(11))
    BEGIN
    INSERT INTO `tbl_lesion`(`idPuntoLesion`, `especificacionLesion`, `idCIE10`) VALUES ($idPuntoLesion, $especificacionLesion, $idCIE10);
    END !
    DELIMITER ;



    -- =================== CONSULTAR LESION ================ --

    DROP PROCEDURE IF EXISTS spConsultarLesion;
    DELIMITER !
    CREATE PROCEDURE spConsultarLesion(IN $idLesion INT)
    BEGIN
    SELECT * FROM `tbl_lesion` WHERE `idLesion` = $idLesion;
    END !
    DELIMITER ;



    -- ================== MODIFICAR LESION ================= --

    DROP PROCEDURE IF EXISTS spModificarLesion;
    DELIMITER !
    CREATE PROCEDURE spModificarLesion(IN $idLesion INT, IN $idPuntoLesion int(11), IN $especificacionLesion varchar(100), IN $idCIE10 int(11))
    BEGIN
    UPDATE `tbl_lesion` SET `idPuntoLesion` = $idPuntoLesion, `especificacionLesion` = $especificacionLesion, `idCIE10` = $idCIE10 WHERE `idLesion` = $idLesion;
    END !
    DELIMITER ;



    -- ==================== LISTAR LESION ================== --

    DROP PROCEDURE IF EXISTS spListarLesion;
    DELIMITER !
    CREATE PROCEDURE spListarLesion()
    BEGIN
    SELECT * FROM `tbl_lesion`;
    END !
    DELIMITER ;





    -- # CRUD tbl_llamada --


    -- ================== REGISTRAR LLAMADA ================= --

    DROP PROCEDURE IF EXISTS spRegistrarLlamada;
    DELIMITER !
    CREATE PROCEDURE spRegistrarLlamada(IN $idChat int(11), IN $urlLlamada varchar(100), IN $fechaHoraLlamada timestamp)
    BEGIN
    INSERT INTO `tbl_llamada`(`idChat`, `urlLlamada`, `fechaHoraLlamada`) VALUES ($idChat, $urlLlamada, $fechaHoraLlamada);
    END !
    DELIMITER ;



    -- =================== CONSULTAR LLAMADA ================ --

    DROP PROCEDURE IF EXISTS spConsultarLlamada;
    DELIMITER !
    CREATE PROCEDURE spConsultarLlamada(IN $idLlamada INT)
    BEGIN
    SELECT * FROM `tbl_llamada` WHERE `idLlamada` = $idLlamada;
    END !
    DELIMITER ;



    -- ================== MODIFICAR LLAMADA ================= --

    DROP PROCEDURE IF EXISTS spModificarLlamada;
    DELIMITER !
    CREATE PROCEDURE spModificarLlamada(IN $idLlamada INT, IN $idChat int(11), IN $urlLlamada varchar(100), IN $fechaHoraLlamada timestamp)
    BEGIN
    UPDATE `tbl_llamada` SET `idChat` = $idChat, `urlLlamada` = $urlLlamada, `fechaHoraLlamada` = $fechaHoraLlamada WHERE `idLlamada` = $idLlamada;
    END !
    DELIMITER ;



    -- ==================== LISTAR LLAMADA ================== --

    DROP PROCEDURE IF EXISTS spListarLlamada;
    DELIMITER !
    CREATE PROCEDURE spListarLlamada()
    BEGIN
    SELECT * FROM `tbl_llamada`;
    END !
    DELIMITER ;





    -- # CRUD tbl_medicamento --


    -- ================== REGISTRAR MEDICAMENTO ================= --

    DROP PROCEDURE IF EXISTS spRegistrarMedicamento;
    DELIMITER !
    CREATE PROCEDURE spRegistrarMedicamento(IN $idReporteAPH int(11), IN $dosis varchar(45), IN $hora time, IN $viaAdministracion varchar(45), IN $cantidadUnidades int(11), IN $idDetallekit int(11), IN $idHistoriaClinica int(11))
    BEGIN
    INSERT INTO `tbl_medicamento`(`idReporteAPH`, `dosis`, `hora`, `viaAdministracion`, `cantidadUnidades`, `idDetallekit`, `idHistoriaClinica`) VALUES ($idReporteAPH, $dosis, $hora, $viaAdministracion, $cantidadUnidades, $idDetallekit, $idHistoriaClinica);
    END !
    DELIMITER ;



    -- =================== CONSULTAR MEDICAMENTO ================ --

    DROP PROCEDURE IF EXISTS spConsultarMedicamento;
    DELIMITER !
    CREATE PROCEDURE spConsultarMedicamento(IN $idmedicamento INT)
    BEGIN
    SELECT * FROM `tbl_medicamento` WHERE `idmedicamento` = $idmedicamento;
    END !
    DELIMITER ;



    -- ================== MODIFICAR MEDICAMENTO ================= --

    DROP PROCEDURE IF EXISTS spModificarMedicamento;
    DELIMITER !
    CREATE PROCEDURE spModificarMedicamento(IN $idmedicamento INT, IN $idReporteAPH int(11), IN $dosis varchar(45), IN $hora time, IN $viaAdministracion varchar(45), IN $cantidadUnidades int(11), IN $idDetallekit int(11), IN $idHistoriaClinica int(11))
    BEGIN
    UPDATE `tbl_medicamento` SET `idReporteAPH` = $idReporteAPH, `dosis` = $dosis, `hora` = $hora, `viaAdministracion` = $viaAdministracion, `cantidadUnidades` = $cantidadUnidades, `idDetallekit` = $idDetallekit, `idHistoriaClinica` = $idHistoriaClinica WHERE `idmedicamento` = $idmedicamento;
    END !
    DELIMITER ;



    -- ==================== LISTAR MEDICAMENTO ================== --

    DROP PROCEDURE IF EXISTS spListarMedicamento;
    DELIMITER !
    CREATE PROCEDURE spListarMedicamento()
    BEGIN
    SELECT * FROM `tbl_medicamento`;
    END !
    DELIMITER ;





    -- # CRUD tbl_mensaje --


    -- ================== REGISTRAR MENSAJE ================= --

    DROP PROCEDURE IF EXISTS spRegistrarMensaje;
    DELIMITER !
    CREATE PROCEDURE spRegistrarMensaje(IN $idChat int(11), IN $mensaje varchar(200), IN $fechaHora timestamp, IN $tipo int(11))
    BEGIN
    INSERT INTO `tbl_mensaje`(`idChat`, `mensaje`, `fechaHora`, `tipo`) VALUES ($idChat, $mensaje, $fechaHora, $tipo);
    END !
    DELIMITER ;



    -- =================== CONSULTAR MENSAJE ================ --

    DROP PROCEDURE IF EXISTS spConsultarMensaje;
    DELIMITER !
    CREATE PROCEDURE spConsultarMensaje(IN $idMensaje INT)
    BEGIN
    SELECT * FROM `tbl_mensaje` WHERE `idMensaje` = $idMensaje;
    END !
    DELIMITER ;



    -- ================== MODIFICAR MENSAJE ================= --

    DROP PROCEDURE IF EXISTS spModificarMensaje;
    DELIMITER !
    CREATE PROCEDURE spModificarMensaje(IN $idMensaje INT, IN $idChat int(11), IN $mensaje varchar(200), IN $fechaHora timestamp, IN $tipo int(11))
    BEGIN
    UPDATE `tbl_mensaje` SET `idChat` = $idChat, `mensaje` = $mensaje, `fechaHora` = $fechaHora, `tipo` = $tipo WHERE `idMensaje` = $idMensaje;
    END !
    DELIMITER ;



    -- ==================== LISTAR MENSAJE ================== --

    DROP PROCEDURE IF EXISTS spListarMensaje;
    DELIMITER !
    CREATE PROCEDURE spListarMensaje()
    BEGIN
    SELECT * FROM `tbl_mensaje`;
    END !
    DELIMITER ;





    -- # CRUD tbl_modulo --


    -- ================== REGISTRAR MODULO ================= --

    DROP PROCEDURE IF EXISTS spRegistrarModulo;
    DELIMITER !
    CREATE PROCEDURE spRegistrarModulo(IN $descripcionModulo varchar(100), IN $iconoModulo varchar(50))
    BEGIN
    INSERT INTO `tbl_modulo`(`descripcionModulo`, `iconoModulo`) VALUES ($descripcionModulo, $iconoModulo);
    END !
    DELIMITER ;



    -- =================== CONSULTAR MODULO ================ --

    DROP PROCEDURE IF EXISTS spConsultarModulo;
    DELIMITER !
    CREATE PROCEDURE spConsultarModulo(IN $idModulo INT)
    BEGIN
    SELECT * FROM `tbl_modulo` WHERE `idModulo` = $idModulo;
    END !
    DELIMITER ;



    -- ================== MODIFICAR MODULO ================= --

    DROP PROCEDURE IF EXISTS spModificarModulo;
    DELIMITER !
    CREATE PROCEDURE spModificarModulo(IN $idModulo INT, IN $descripcionModulo varchar(100), IN $iconoModulo varchar(50))
    BEGIN
    UPDATE `tbl_modulo` SET `descripcionModulo` = $descripcionModulo, `iconoModulo` = $iconoModulo WHERE `idModulo` = $idModulo;
    END !
    DELIMITER ;



    -- ==================== LISTAR MODULO ================== --

    DROP PROCEDURE IF EXISTS spListarModulo;
    DELIMITER !
    CREATE PROCEDURE spListarModulo()
    BEGIN
    SELECT * FROM `tbl_modulo`;
    END !
    DELIMITER ;





    -- # CRUD tbl_motivoconsulta --


    -- ================== REGISTRAR MOTIVOCONSULTA ================= --

    DROP PROCEDURE IF EXISTS spRegistrarMotivoconsulta;
    DELIMITER !
    CREATE PROCEDURE spRegistrarMotivoconsulta(IN $descripcionMotivoConsulta varchar(45), IN $TipoMotivoConsulta varchar(45))
    BEGIN
    INSERT INTO `tbl_motivoconsulta`(`descripcionMotivoConsulta`, `TipoMotivoConsulta`) VALUES ($descripcionMotivoConsulta, $TipoMotivoConsulta);
    END !
    DELIMITER ;



    -- =================== CONSULTAR MOTIVOCONSULTA ================ --

    DROP PROCEDURE IF EXISTS spConsultarMotivoconsulta;
    DELIMITER !
    CREATE PROCEDURE spConsultarMotivoconsulta(IN $idMotivoConsulta INT)
    BEGIN
    SELECT * FROM `tbl_motivoconsulta` WHERE `idMotivoConsulta` = $idMotivoConsulta;
    END !
    DELIMITER ;



    -- ================== MODIFICAR MOTIVOCONSULTA ================= --

    DROP PROCEDURE IF EXISTS spModificarMotivoconsulta;
    DELIMITER !
    CREATE PROCEDURE spModificarMotivoconsulta(IN $idMotivoConsulta INT, IN $descripcionMotivoConsulta varchar(45), IN $TipoMotivoConsulta varchar(45))
    BEGIN
    UPDATE `tbl_motivoconsulta` SET `descripcionMotivoConsulta` = $descripcionMotivoConsulta, `TipoMotivoConsulta` = $TipoMotivoConsulta WHERE `idMotivoConsulta` = $idMotivoConsulta;
    END !
    DELIMITER ;



    -- ==================== LISTAR MOTIVOCONSULTA ================== --

    DROP PROCEDURE IF EXISTS spListarMotivoconsulta;
    DELIMITER !
    CREATE PROCEDURE spListarMotivoconsulta()
    BEGIN
    SELECT * FROM `tbl_motivoconsulta`;
    END !
    DELIMITER ;





    -- # CRUD tbl_multa --


    -- ================== REGISTRAR MULTA ================= --

    DROP PROCEDURE IF EXISTS spRegistrarMulta;
    DELIMITER !
    CREATE PROCEDURE spRegistrarMulta(IN $diasMulta int(11), IN $fechaMulta date, IN $estadoTabla varchar(50))
    BEGIN
    INSERT INTO `tbl_multa`(`diasMulta`, `fechaMulta`, `estadoTabla`) VALUES ($diasMulta, $fechaMulta, $estadoTabla);
    END !
    DELIMITER ;



    -- =================== CONSULTAR MULTA ================ --

    DROP PROCEDURE IF EXISTS spConsultarMulta;
    DELIMITER !
    CREATE PROCEDURE spConsultarMulta(IN $idMulta INT)
    BEGIN
    SELECT * FROM `tbl_multa` WHERE `idMulta` = $idMulta;
    END !
    DELIMITER ;



    -- ================== MODIFICAR MULTA ================= --

    DROP PROCEDURE IF EXISTS spModificarMulta;
    DELIMITER !
    CREATE PROCEDURE spModificarMulta(IN $idMulta INT, IN $diasMulta int(11), IN $fechaMulta date)
    BEGIN
    UPDATE `tbl_multa` SET `diasMulta` = $diasMulta, `fechaMulta` = $fechaMulta WHERE `idMulta` = $idMulta;
    END !
    DELIMITER ;



    -- ==================== LISTAR MULTA ================== --

    DROP PROCEDURE IF EXISTS spListarMulta;
    DELIMITER !
    CREATE PROCEDURE spListarMulta()
    BEGIN
    SELECT * FROM `tbl_multa`;
    END !
    DELIMITER ;


      -- ================== CAMBIAR ESTADO MULTA ================= --

      DROP PROCEDURE IF EXISTS spCambiarEstadoMulta;
      DELIMITER !
      CREATE PROCEDURE spCambiarEstadoMulta(IN $idMulta INT, IN $estadoTabla varchar(50))
      BEGIN
      UPDATE `tbl_multa` SET `estadoTabla` = $estadoTabla WHERE `idMulta` = $idMulta;
      END !
      DELIMITER ;



    -- # CRUD tbl_notaenfermeria --


    -- ================== REGISTRAR NOTAENFERMERIA ================= --

    DROP PROCEDURE IF EXISTS spRegistrarNotaenfermeria;
    DELIMITER !
    CREATE PROCEDURE spRegistrarNotaenfermeria(IN $descripcion varchar(200), IN $idPersona int(11), IN $idProcedimiento int(11))
    BEGIN
    INSERT INTO `tbl_notaenfermeria`(`descripcion`, `idPersona`, `idProcedimiento`) VALUES ($descripcion, $idPersona, $idProcedimiento);
    END !
    DELIMITER ;



    -- =================== CONSULTAR NOTAENFERMERIA ================ --

    DROP PROCEDURE IF EXISTS spConsultarNotaenfermeria;
    DELIMITER !
    CREATE PROCEDURE spConsultarNotaenfermeria(IN $idNotaEnfermeria INT)
    BEGIN
    SELECT * FROM `tbl_notaenfermeria` WHERE `idNotaEnfermeria` = $idNotaEnfermeria;
    END !
    DELIMITER ;



    -- ================== MODIFICAR NOTAENFERMERIA ================= --

    DROP PROCEDURE IF EXISTS spModificarNotaenfermeria;
    DELIMITER !
    CREATE PROCEDURE spModificarNotaenfermeria(IN $idNotaEnfermeria INT, IN $descripcion varchar(200), IN $idPersona int(11), IN $idProcedimiento int(11))
    BEGIN
    UPDATE `tbl_notaenfermeria` SET `descripcion` = $descripcion, `idPersona` = $idPersona, `idProcedimiento` = $idProcedimiento WHERE `idNotaEnfermeria` = $idNotaEnfermeria;
    END !
    DELIMITER ;



    -- ==================== LISTAR NOTAENFERMERIA ================== --

    DROP PROCEDURE IF EXISTS spListarNotaenfermeria;
    DELIMITER !
    CREATE PROCEDURE spListarNotaenfermeria()
    BEGIN
    SELECT * FROM `tbl_notaenfermeria`;
    END !
    DELIMITER ;





    -- # CRUD tbl_novedadrecurso --


    -- ================== REGISTRAR NOVEDADRECURSO ================= --

    DROP PROCEDURE IF EXISTS spRegistrarNovedadrecurso;
    DELIMITER !
    CREATE PROCEDURE spRegistrarNovedadrecurso(IN $descripcionNovedad text, IN $fechaHoraNovedad datetime, IN $estadoTablaNovedad varchar(45), IN $idDetallekit int(11), IN $idPersona int(11), IN $idTipoNovedad int(11))
    BEGIN
    INSERT INTO `tbl_novedadrecurso`(`descripcionNovedad`, `fechaHoraNovedad`, `estadoTablaNovedad`, `idDetallekit`, `idPersona`, `idTipoNovedad`) VALUES ($descripcionNovedad, $fechaHoraNovedad, $estadoTablaNovedad, $idDetallekit, $idPersona, $idTipoNovedad);
    END !
    DELIMITER ;



    -- =================== CONSULTAR NOVEDADRECURSO ================ --

    DROP PROCEDURE IF EXISTS spConsultarNovedadrecurso;
    DELIMITER !
    CREATE PROCEDURE spConsultarNovedadrecurso(IN $idNovedadRecurso INT)
    BEGIN
    SELECT * FROM `tbl_novedadrecurso` WHERE `idNovedadRecurso` = $idNovedadRecurso;
    END !
    DELIMITER ;



    -- ================== MODIFICAR NOVEDADRECURSO ================= --

    DROP PROCEDURE IF EXISTS spModificarNovedadrecurso;
    DELIMITER !
    CREATE PROCEDURE spModificarNovedadrecurso(IN $idNovedadRecurso INT, IN $descripcionNovedad text, IN $fechaHoraNovedad datetime, IN $idDetallekit int(11), IN $idPersona int(11), IN $idTipoNovedad int(11))
    BEGIN
    UPDATE `tbl_novedadrecurso` SET `descripcionNovedad` = $descripcionNovedad, `fechaHoraNovedad` = $fechaHoraNovedad, `idDetallekit` = $idDetallekit, `idPersona` = $idPersona, `idTipoNovedad` = $idTipoNovedad WHERE `idNovedadRecurso` = $idNovedadRecurso;
    END !
    DELIMITER ;



    -- ==================== LISTAR NOVEDADRECURSO ================== --

    DROP PROCEDURE IF EXISTS spListarNovedadrecurso;
    DELIMITER !
    CREATE PROCEDURE spListarNovedadrecurso()
    BEGIN
    SELECT * FROM `tbl_novedadrecurso`;
    END !
    DELIMITER ;


      -- ================== CAMBIAR ESTADO NOVEDADRECURSO ================= --

      DROP PROCEDURE IF EXISTS spCambiarEstadoNovedadrecurso;
      DELIMITER !
      CREATE PROCEDURE spCambiarEstadoNovedadrecurso(IN $idNovedadRecurso INT, IN $estadoTablaNovedad varchar(45))
      BEGIN
      UPDATE `tbl_novedadrecurso` SET `estadoTablaNovedad` = $estadoTablaNovedad WHERE `idNovedadRecurso` = $idNovedadRecurso;
      END !
      DELIMITER ;



    -- # CRUD tbl_novedadreporteinicial --


    -- ================== REGISTRAR NOVEDADREPORTEINICIAL ================= --

    DROP PROCEDURE IF EXISTS spRegistrarNovedadreporteinicial;
    DELIMITER !
    CREATE PROCEDURE spRegistrarNovedadreporteinicial(IN $idReporteInicial int(11), IN $descripcionNovedad text, IN $fechaHoraNovedad timestamp, IN $numeroLesionadosNovedad int(11), IN $estadoNovedad varchar(50))
    BEGIN
    INSERT INTO `tbl_novedadreporteinicial`(`idReporteInicial`, `descripcionNovedad`, `fechaHoraNovedad`, `numeroLesionadosNovedad`, `estadoNovedad`) VALUES ($idReporteInicial, $descripcionNovedad, $fechaHoraNovedad, $numeroLesionadosNovedad, $estadoNovedad);
    END !
    DELIMITER ;



    -- =================== CONSULTAR NOVEDADREPORTEINICIAL ================ --

    DROP PROCEDURE IF EXISTS spConsultarNovedadreporteinicial;
    DELIMITER !
    CREATE PROCEDURE spConsultarNovedadreporteinicial(IN $idNovedad INT)
    BEGIN
    SELECT * FROM `tbl_novedadreporteinicial` WHERE `idNovedad` = $idNovedad;
    END !
    DELIMITER ;



    -- ================== MODIFICAR NOVEDADREPORTEINICIAL ================= --

    DROP PROCEDURE IF EXISTS spModificarNovedadreporteinicial;
    DELIMITER !
    CREATE PROCEDURE spModificarNovedadreporteinicial(IN $idNovedad INT, IN $idReporteInicial int(11), IN $descripcionNovedad text, IN $fechaHoraNovedad timestamp, IN $numeroLesionadosNovedad int(11), IN $estadoNovedad varchar(50))
    BEGIN
    UPDATE `tbl_novedadreporteinicial` SET `idReporteInicial` = $idReporteInicial, `descripcionNovedad` = $descripcionNovedad, `fechaHoraNovedad` = $fechaHoraNovedad, `numeroLesionadosNovedad` = $numeroLesionadosNovedad, `estadoNovedad` = $estadoNovedad WHERE `idNovedad` = $idNovedad;
    END !
    DELIMITER ;



    -- ==================== LISTAR NOVEDADREPORTEINICIAL ================== --

    DROP PROCEDURE IF EXISTS spListarNovedadreporteinicial;
    DELIMITER !
    CREATE PROCEDURE spListarNovedadreporteinicial()
    BEGIN
    SELECT * FROM `tbl_novedadreporteinicial`;
    END !
    DELIMITER ;





    -- # CRUD tbl_novedadreporteinicial_enteexterno --


    -- ================== REGISTRAR NOVEDADREPORTEINICIAL_ENTEEXTERNO ================= --

    DROP PROCEDURE IF EXISTS spRegistrarNovedadreporteinicial_enteexterno;
    DELIMITER !
    CREATE PROCEDURE spRegistrarNovedadreporteinicial_enteexterno(IN $idEnteExterno int(11), IN $idNovedad int(11))
    BEGIN
    INSERT INTO `tbl_novedadreporteinicial_enteexterno`(`idEnteExterno`, `idNovedad`) VALUES ($idEnteExterno, $idNovedad);
    END !
    DELIMITER ;



    -- =================== CONSULTAR NOVEDADREPORTEINICIAL_ENTEEXTERNO ================ --

    DROP PROCEDURE IF EXISTS spConsultarNovedadreporteinicial_enteexterno;
    DELIMITER !
    CREATE PROCEDURE spConsultarNovedadreporteinicial_enteexterno(IN $idNovedadReporteInicialEnteExterno INT)
    BEGIN
    SELECT * FROM `tbl_novedadreporteinicial_enteexterno` WHERE `idNovedadReporteInicialEnteExterno` = $idNovedadReporteInicialEnteExterno;
    END !
    DELIMITER ;



    -- ================== MODIFICAR NOVEDADREPORTEINICIAL_ENTEEXTERNO ================= --

    DROP PROCEDURE IF EXISTS spModificarNovedadreporteinicial_enteexterno;
    DELIMITER !
    CREATE PROCEDURE spModificarNovedadreporteinicial_enteexterno(IN $idNovedadReporteInicialEnteExterno INT, IN $idEnteExterno int(11), IN $idNovedad int(11))
    BEGIN
    UPDATE `tbl_novedadreporteinicial_enteexterno` SET `idEnteExterno` = $idEnteExterno, `idNovedad` = $idNovedad WHERE `idNovedadReporteInicialEnteExterno` = $idNovedadReporteInicialEnteExterno;
    END !
    DELIMITER ;



    -- ==================== LISTAR NOVEDADREPORTEINICIAL_ENTEEXTERNO ================== --

    DROP PROCEDURE IF EXISTS spListarNovedadreporteinicial_enteexterno;
    DELIMITER !
    CREATE PROCEDURE spListarNovedadreporteinicial_enteexterno()
    BEGIN
    SELECT * FROM `tbl_novedadreporteinicial_enteexterno`;
    END !
    DELIMITER ;





    -- # CRUD tbl_observacion --


    -- ================== REGISTRAR OBSERVACION ================= --

    DROP PROCEDURE IF EXISTS spRegistrarObservacion;
    DELIMITER !
    CREATE PROCEDURE spRegistrarObservacion(IN $idPersonaResponsable int(11), IN $descripcionObservacion varchar(1000), IN $fechaObservacion date, IN $idProcedimiento int(11))
    BEGIN
    INSERT INTO `tbl_observacion`(`idPersonaResponsable`, `descripcionObservacion`, `fechaObservacion`, `idProcedimiento`) VALUES ($idPersonaResponsable, $descripcionObservacion, $fechaObservacion, $idProcedimiento);
    END !
    DELIMITER ;



    -- =================== CONSULTAR OBSERVACION ================ --

    DROP PROCEDURE IF EXISTS spConsultarObservacion;
    DELIMITER !
    CREATE PROCEDURE spConsultarObservacion(IN $idObservacion INT)
    BEGIN
    SELECT * FROM `tbl_observacion` WHERE `idObservacion` = $idObservacion;
    END !
    DELIMITER ;



    -- ================== MODIFICAR OBSERVACION ================= --

    DROP PROCEDURE IF EXISTS spModificarObservacion;
    DELIMITER !
    CREATE PROCEDURE spModificarObservacion(IN $idObservacion INT, IN $idPersonaResponsable int(11), IN $descripcionObservacion varchar(1000), IN $fechaObservacion date, IN $idProcedimiento int(11))
    BEGIN
    UPDATE `tbl_observacion` SET `idPersonaResponsable` = $idPersonaResponsable, `descripcionObservacion` = $descripcionObservacion, `fechaObservacion` = $fechaObservacion, `idProcedimiento` = $idProcedimiento WHERE `idObservacion` = $idObservacion;
    END !
    DELIMITER ;



    -- ==================== LISTAR OBSERVACION ================== --

    DROP PROCEDURE IF EXISTS spListarObservacion;
    DELIMITER !
    CREATE PROCEDURE spListarObservacion()
    BEGIN
    SELECT * FROM `tbl_observacion`;
    END !
    DELIMITER ;





    -- # CRUD tbl_otrodmc --


    -- ================== REGISTRAR OTRODMC ================= --

    DROP PROCEDURE IF EXISTS spRegistrarOtrodmc;
    DELIMITER !
    CREATE PROCEDURE spRegistrarOtrodmc(IN $descripcion text, IN $idHistoriaClinica int(11))
    BEGIN
    INSERT INTO `tbl_otrodmc`(`descripcion`, `idHistoriaClinica`) VALUES ($descripcion, $idHistoriaClinica);
    END !
    DELIMITER ;



    -- =================== CONSULTAR OTRODMC ================ --

    DROP PROCEDURE IF EXISTS spConsultarOtrodmc;
    DELIMITER !
    CREATE PROCEDURE spConsultarOtrodmc(IN $idOtro INT)
    BEGIN
    SELECT * FROM `tbl_otrodmc` WHERE `idOtro` = $idOtro;
    END !
    DELIMITER ;



    -- ================== MODIFICAR OTRODMC ================= --

    DROP PROCEDURE IF EXISTS spModificarOtrodmc;
    DELIMITER !
    CREATE PROCEDURE spModificarOtrodmc(IN $idOtro INT, IN $descripcion text, IN $idHistoriaClinica int(11))
    BEGIN
    UPDATE `tbl_otrodmc` SET `descripcion` = $descripcion, `idHistoriaClinica` = $idHistoriaClinica WHERE `idOtro` = $idOtro;
    END !
    DELIMITER ;



    -- ==================== LISTAR OTRODMC ================== --

    DROP PROCEDURE IF EXISTS spListarOtrodmc;
    DELIMITER !
    CREATE PROCEDURE spListarOtrodmc()
    BEGIN
    SELECT * FROM `tbl_otrodmc`;
    END !
    DELIMITER ;





    -- # CRUD tbl_paciente --


    -- ================== REGISTRAR PACIENTE ================= --

    DROP PROCEDURE IF EXISTS spRegistrarPaciente;
    DELIMITER !
    CREATE PROCEDURE spRegistrarPaciente(IN $numeroDocumento varchar(45), IN $fechaNacimiento date, IN $tipoSangre varchar(45), IN $primerNombre varchar(45), IN $segundoNombre varchar(45), IN $primerApellido varchar(45), IN $segundoApellido varchar(45), IN $genero varchar(45), IN $estadoCivil varchar(45), IN $ciudadResidencia varchar(45), IN $barrioResidencia varchar(45), IN $direccion varchar(45), IN $telefonoFijo varchar(45), IN $telefonoMovil varchar(45), IN $correoElectronico varchar(45), IN $empresa varchar(45), IN $ocupacion varchar(45), IN $profesion varchar(45), IN $fechaAfiliacionRegistro date, IN $idtipoDocumento int(11), IN $idtipoAfiliacion int(11), IN $edadPaciente varchar(10), IN $url varchar(250), IN $idEstadoPaciente int(11))
    BEGIN
    INSERT INTO `tbl_paciente`(`numeroDocumento`, `fechaNacimiento`, `tipoSangre`, `primerNombre`, `segundoNombre`, `primerApellido`, `segundoApellido`, `genero`, `estadoCivil`, `ciudadResidencia`, `barrioResidencia`, `direccion`, `telefonoFijo`, `telefonoMovil`, `correoElectronico`, `empresa`, `ocupacion`, `profesion`, `fechaAfiliacionRegistro`, `idtipoDocumento`, `idtipoAfiliacion`, `edadPaciente`, `url`, `idEstadoPaciente`) VALUES ($numeroDocumento, $fechaNacimiento, $tipoSangre, $primerNombre, $segundoNombre, $primerApellido, $segundoApellido, $genero, $estadoCivil, $ciudadResidencia, $barrioResidencia, $direccion, $telefonoFijo, $telefonoMovil, $correoElectronico, $empresa, $ocupacion, $profesion, $fechaAfiliacionRegistro, $idtipoDocumento, $idtipoAfiliacion, $edadPaciente, $url, $idEstadoPaciente);
    END !
    DELIMITER ;



    -- =================== CONSULTAR PACIENTE ================ --

    DROP PROCEDURE IF EXISTS spConsultarPaciente;
    DELIMITER !
    CREATE PROCEDURE spConsultarPaciente(IN $idPaciente INT)
    BEGIN
    SELECT * FROM `tbl_paciente` WHERE `idPaciente` = $idPaciente;
    END !
    DELIMITER ;



    -- ================== MODIFICAR PACIENTE ================= --

    DROP PROCEDURE IF EXISTS spModificarPaciente;
    DELIMITER !
    CREATE PROCEDURE spModificarPaciente(IN $idPaciente INT, IN $numeroDocumento varchar(45), IN $fechaNacimiento date, IN $tipoSangre varchar(45), IN $primerNombre varchar(45), IN $segundoNombre varchar(45), IN $primerApellido varchar(45), IN $segundoApellido varchar(45), IN $genero varchar(45), IN $estadoCivil varchar(45), IN $ciudadResidencia varchar(45), IN $barrioResidencia varchar(45), IN $direccion varchar(45), IN $telefonoFijo varchar(45), IN $telefonoMovil varchar(45), IN $correoElectronico varchar(45), IN $empresa varchar(45), IN $ocupacion varchar(45), IN $profesion varchar(45), IN $fechaAfiliacionRegistro date, IN $idtipoDocumento int(11), IN $idtipoAfiliacion int(11), IN $edadPaciente varchar(10), IN $url varchar(250), IN $idEstadoPaciente int(11))
    BEGIN
    UPDATE `tbl_paciente` SET `numeroDocumento` = $numeroDocumento, `fechaNacimiento` = $fechaNacimiento, `tipoSangre` = $tipoSangre, `primerNombre` = $primerNombre, `segundoNombre` = $segundoNombre, `primerApellido` = $primerApellido, `segundoApellido` = $segundoApellido, `genero` = $genero, `estadoCivil` = $estadoCivil, `ciudadResidencia` = $ciudadResidencia, `barrioResidencia` = $barrioResidencia, `direccion` = $direccion, `telefonoFijo` = $telefonoFijo, `telefonoMovil` = $telefonoMovil, `correoElectronico` = $correoElectronico, `empresa` = $empresa, `ocupacion` = $ocupacion, `profesion` = $profesion, `fechaAfiliacionRegistro` = $fechaAfiliacionRegistro, `idtipoDocumento` = $idtipoDocumento, `idtipoAfiliacion` = $idtipoAfiliacion, `edadPaciente` = $edadPaciente, `url` = $url, `idEstadoPaciente` = $idEstadoPaciente WHERE `idPaciente` = $idPaciente;
    END !
    DELIMITER ;



    -- ==================== LISTAR PACIENTE ================== --

    DROP PROCEDURE IF EXISTS spListarPaciente;
    DELIMITER !
    CREATE PROCEDURE spListarPaciente()
    BEGIN
    SELECT * FROM `tbl_paciente`;
    END !
    DELIMITER ;





    -- # CRUD tbl_persona --


    -- ================== REGISTRAR PERSONA ================= --

    DROP PROCEDURE IF EXISTS spRegistrarPersona;
    DELIMITER !
    CREATE PROCEDURE spRegistrarPersona(IN $primerNombre varchar(50), IN $segundoNombre varchar(50), IN $primerApellido varchar(50), IN $segundoApellido varchar(50), IN $idTipoDocumento int(11), IN $numeroDocumento varchar(20), IN $lugarExpedicionDocumento varchar(50), IN $fechaNacimiento date, IN $lugarNacimiento varchar(45), IN $sexo varchar(45), IN $direccion varchar(45), IN $telefono varchar(45), IN $correoElectronico varchar(45), IN $grupoSanguineo varchar(45), IN $ciudad varchar(45), IN $departamento varchar(45), IN $pais varchar(45), IN $urlHojaDeVida varchar(250), IN $urlFirma varchar(250), IN $urlFoto varchar(250), IN $estadoTablaPersona varchar(50), IN $dependencia varchar(45))
    BEGIN
    INSERT INTO `tbl_persona`(`primerNombre`, `segundoNombre`, `primerApellido`, `segundoApellido`, `idTipoDocumento`, `numeroDocumento`, `lugarExpedicionDocumento`, `fechaNacimiento`, `lugarNacimiento`, `sexo`, `direccion`, `telefono`, `correoElectronico`, `grupoSanguineo`, `ciudad`, `departamento`, `pais`, `urlHojaDeVida`, `urlFirma`, `urlFoto`, `estadoTablaPersona`, `dependencia`) VALUES ($primerNombre, $segundoNombre, $primerApellido, $segundoApellido, $idTipoDocumento, $numeroDocumento, $lugarExpedicionDocumento, $fechaNacimiento, $lugarNacimiento, $sexo, $direccion, $telefono, $correoElectronico, $grupoSanguineo, $ciudad, $departamento, $pais, $urlHojaDeVida, $urlFirma, $urlFoto, $estadoTablaPersona, $dependencia);
    END !
    DELIMITER ;



    -- =================== CONSULTAR PERSONA ================ --

    DROP PROCEDURE IF EXISTS spConsultarPersona;
    DELIMITER !
    CREATE PROCEDURE spConsultarPersona(IN $idPersona INT)
    BEGIN
    SELECT * FROM `tbl_persona` WHERE `idPersona` = $idPersona;
    END !
    DELIMITER ;



    -- ================== MODIFICAR PERSONA ================= --

    DROP PROCEDURE IF EXISTS spModificarPersona;
    DELIMITER !
    CREATE PROCEDURE spModificarPersona(IN $idPersona INT, IN $primerNombre varchar(50), IN $segundoNombre varchar(50), IN $primerApellido varchar(50), IN $segundoApellido varchar(50), IN $idTipoDocumento int(11), IN $numeroDocumento varchar(20), IN $lugarExpedicionDocumento varchar(50), IN $fechaNacimiento date, IN $lugarNacimiento varchar(45), IN $sexo varchar(45), IN $direccion varchar(45), IN $telefono varchar(45), IN $correoElectronico varchar(45), IN $grupoSanguineo varchar(45), IN $ciudad varchar(45), IN $departamento varchar(45), IN $pais varchar(45), IN $urlHojaDeVida varchar(250), IN $urlFirma varchar(250), IN $urlFoto varchar(250), IN $dependencia varchar(45))
    BEGIN
    UPDATE `tbl_persona` SET `primerNombre` = $primerNombre, `segundoNombre` = $segundoNombre, `primerApellido` = $primerApellido, `segundoApellido` = $segundoApellido, `idTipoDocumento` = $idTipoDocumento, `numeroDocumento` = $numeroDocumento, `lugarExpedicionDocumento` = $lugarExpedicionDocumento, `fechaNacimiento` = $fechaNacimiento, `lugarNacimiento` = $lugarNacimiento, `sexo` = $sexo, `direccion` = $direccion, `telefono` = $telefono, `correoElectronico` = $correoElectronico, `grupoSanguineo` = $grupoSanguineo, `ciudad` = $ciudad, `departamento` = $departamento, `pais` = $pais, `urlHojaDeVida` = $urlHojaDeVida, `urlFirma` = $urlFirma, `urlFoto` = $urlFoto, `dependencia` = $dependencia WHERE `idPersona` = $idPersona;
    END !
    DELIMITER ;



    -- ==================== LISTAR PERSONA ================== --

    DROP PROCEDURE IF EXISTS spListarPersona;
    DELIMITER !
    CREATE PROCEDURE spListarPersona()
    BEGIN
    SELECT * FROM `tbl_persona`;
    END !
    DELIMITER ;


      -- ================== CAMBIAR ESTADO PERSONA ================= --

      DROP PROCEDURE IF EXISTS spCambiarEstadoPersona;
      DELIMITER !
      CREATE PROCEDURE spCambiarEstadoPersona(IN $idPersona INT, IN $estadoTablaPersona varchar(50))
      BEGIN
      UPDATE `tbl_persona` SET `estadoTablaPersona` = $estadoTablaPersona WHERE `idPersona` = $idPersona;
      END !
      DELIMITER ;



    -- # CRUD tbl_personaespecialidad --


    -- ================== REGISTRAR PERSONAESPECIALIDAD ================= --

    DROP PROCEDURE IF EXISTS spRegistrarPersonaespecialidad;
    DELIMITER !
    CREATE PROCEDURE spRegistrarPersonaespecialidad(IN $idPersona int(11), IN $idEspecialidad int(11), IN $estadoTablaEspecialidad varchar(50))
    BEGIN
    INSERT INTO `tbl_personaespecialidad`(`idPersona`, `idEspecialidad`, `estadoTablaEspecialidad`) VALUES ($idPersona, $idEspecialidad, $estadoTablaEspecialidad);
    END !
    DELIMITER ;



    -- =================== CONSULTAR PERSONAESPECIALIDAD ================ --

    DROP PROCEDURE IF EXISTS spConsultarPersonaespecialidad;
    DELIMITER !
    CREATE PROCEDURE spConsultarPersonaespecialidad(IN $idPersonaespecialidad INT)
    BEGIN
    SELECT * FROM `tbl_personaespecialidad` WHERE `idPersonaespecialidad` = $idPersonaespecialidad;
    END !
    DELIMITER ;



    -- ================== MODIFICAR PERSONAESPECIALIDAD ================= --

    DROP PROCEDURE IF EXISTS spModificarPersonaespecialidad;
    DELIMITER !
    CREATE PROCEDURE spModificarPersonaespecialidad(IN $idPersonaespecialidad INT, IN $idPersona int(11), IN $idEspecialidad int(11))
    BEGIN
    UPDATE `tbl_personaespecialidad` SET `idPersona` = $idPersona, `idEspecialidad` = $idEspecialidad WHERE `idPersonaespecialidad` = $idPersonaespecialidad;
    END !
    DELIMITER ;



    -- ==================== LISTAR PERSONAESPECIALIDAD ================== --

    DROP PROCEDURE IF EXISTS spListarPersonaespecialidad;
    DELIMITER !
    CREATE PROCEDURE spListarPersonaespecialidad()
    BEGIN
    SELECT * FROM `tbl_personaespecialidad`;
    END !
    DELIMITER ;


      -- ================== CAMBIAR ESTADO PERSONAESPECIALIDAD ================= --

      DROP PROCEDURE IF EXISTS spCambiarEstadoPersonaespecialidad;
      DELIMITER !
      CREATE PROCEDURE spCambiarEstadoPersonaespecialidad(IN $idPersonaespecialidad INT, IN $estadoTablaEspecialidad varchar(50))
      BEGIN
      UPDATE `tbl_personaespecialidad` SET `estadoTablaEspecialidad` = $estadoTablaEspecialidad WHERE `idPersonaespecialidad` = $idPersonaespecialidad;
      END !
      DELIMITER ;



    -- # CRUD tbl_piel --


    -- ================== REGISTRAR PIEL ================= --

    DROP PROCEDURE IF EXISTS spRegistrarPiel;
    DELIMITER !
    CREATE PROCEDURE spRegistrarPiel(IN $idExamenFisico int(11), IN $descripcion varchar(45))
    BEGIN
    INSERT INTO `tbl_piel`(`idExamenFisico`, `descripcion`) VALUES ($idExamenFisico, $descripcion);
    END !
    DELIMITER ;



    -- =================== CONSULTAR PIEL ================ --

    DROP PROCEDURE IF EXISTS spConsultarPiel;
    DELIMITER !
    CREATE PROCEDURE spConsultarPiel(IN $idPiel INT)
    BEGIN
    SELECT * FROM `tbl_piel` WHERE `idPiel` = $idPiel;
    END !
    DELIMITER ;



    -- ================== MODIFICAR PIEL ================= --

    DROP PROCEDURE IF EXISTS spModificarPiel;
    DELIMITER !
    CREATE PROCEDURE spModificarPiel(IN $idPiel INT, IN $idExamenFisico int(11), IN $descripcion varchar(45))
    BEGIN
    UPDATE `tbl_piel` SET `idExamenFisico` = $idExamenFisico, `descripcion` = $descripcion WHERE `idPiel` = $idPiel;
    END !
    DELIMITER ;



    -- ==================== LISTAR PIEL ================== --

    DROP PROCEDURE IF EXISTS spListarPiel;
    DELIMITER !
    CREATE PROCEDURE spListarPiel()
    BEGIN
    SELECT * FROM `tbl_piel`;
    END !
    DELIMITER ;





    -- # CRUD tbl_procedimiento --


    -- ================== REGISTRAR PROCEDIMIENTO ================= --

    DROP PROCEDURE IF EXISTS spRegistrarProcedimiento;
    DELIMITER !
    CREATE PROCEDURE spRegistrarProcedimiento(IN $idCUP int(11), IN $idHistoriaClinica int(11), IN $descripcionProcedimiento varchar(1000))
    BEGIN
    INSERT INTO `tbl_procedimiento`(`idCUP`, `idHistoriaClinica`, `descripcionProcedimiento`) VALUES ($idCUP, $idHistoriaClinica, $descripcionProcedimiento);
    END !
    DELIMITER ;



    -- =================== CONSULTAR PROCEDIMIENTO ================ --

    DROP PROCEDURE IF EXISTS spConsultarProcedimiento;
    DELIMITER !
    CREATE PROCEDURE spConsultarProcedimiento(IN $idProcedimiento INT)
    BEGIN
    SELECT * FROM `tbl_procedimiento` WHERE `idProcedimiento` = $idProcedimiento;
    END !
    DELIMITER ;



    -- ================== MODIFICAR PROCEDIMIENTO ================= --

    DROP PROCEDURE IF EXISTS spModificarProcedimiento;
    DELIMITER !
    CREATE PROCEDURE spModificarProcedimiento(IN $idProcedimiento INT, IN $idCUP int(11), IN $idHistoriaClinica int(11), IN $descripcionProcedimiento varchar(1000))
    BEGIN
    UPDATE `tbl_procedimiento` SET `idCUP` = $idCUP, `idHistoriaClinica` = $idHistoriaClinica, `descripcionProcedimiento` = $descripcionProcedimiento WHERE `idProcedimiento` = $idProcedimiento;
    END !
    DELIMITER ;



    -- ==================== LISTAR PROCEDIMIENTO ================== --

    DROP PROCEDURE IF EXISTS spListarProcedimiento;
    DELIMITER !
    CREATE PROCEDURE spListarProcedimiento()
    BEGIN
    SELECT * FROM `tbl_procedimiento`;
    END !
    DELIMITER ;





    -- # CRUD tbl_programacion --


    -- ================== REGISTRAR PROGRAMACION ================= --

    DROP PROCEDURE IF EXISTS spRegistrarProgramacion;
    DELIMITER !
    CREATE PROCEDURE spRegistrarProgramacion(IN $Fecha_inicial date, IN $Fecha_final date)
    BEGIN
    INSERT INTO `tbl_programacion`(`Fecha_inicial`, `Fecha_final`) VALUES ($Fecha_inicial, $Fecha_final);
    END !
    DELIMITER ;



    -- =================== CONSULTAR PROGRAMACION ================ --

    DROP PROCEDURE IF EXISTS spConsultarProgramacion;
    DELIMITER !
    CREATE PROCEDURE spConsultarProgramacion(IN $idProgramacion INT)
    BEGIN
    SELECT * FROM `tbl_programacion` WHERE `idProgramacion` = $idProgramacion;
    END !
    DELIMITER ;



    -- ================== MODIFICAR PROGRAMACION ================= --

    DROP PROCEDURE IF EXISTS spModificarProgramacion;
    DELIMITER !
    CREATE PROCEDURE spModificarProgramacion(IN $idProgramacion INT, IN $Fecha_inicial date, IN $Fecha_final date)
    BEGIN
    UPDATE `tbl_programacion` SET `Fecha_inicial` = $Fecha_inicial, `Fecha_final` = $Fecha_final WHERE `idProgramacion` = $idProgramacion;
    END !
    DELIMITER ;



    -- ==================== LISTAR PROGRAMACION ================== --

    DROP PROCEDURE IF EXISTS spListarProgramacion;
    DELIMITER !
    CREATE PROCEDURE spListarProgramacion()
    BEGIN
    SELECT * FROM `tbl_programacion`;
    END !
    DELIMITER ;





    -- # CRUD tbl_puntolesion --


    -- ================== REGISTRAR PUNTOLESION ================= --

    DROP PROCEDURE IF EXISTS spRegistrarPuntolesion;
    DELIMITER !
    CREATE PROCEDURE spRegistrarPuntolesion(IN $posX varchar(100), IN $posY varchar(100), IN $idReporteAPH int(11))
    BEGIN
    INSERT INTO `tbl_puntolesion`(`posX`, `posY`, `idReporteAPH`) VALUES ($posX, $posY, $idReporteAPH);
    END !
    DELIMITER ;



    -- =================== CONSULTAR PUNTOLESION ================ --

    DROP PROCEDURE IF EXISTS spConsultarPuntolesion;
    DELIMITER !
    CREATE PROCEDURE spConsultarPuntolesion(IN $idPuntoLesion INT)
    BEGIN
    SELECT * FROM `tbl_puntolesion` WHERE `idPuntoLesion` = $idPuntoLesion;
    END !
    DELIMITER ;



    -- ================== MODIFICAR PUNTOLESION ================= --

    DROP PROCEDURE IF EXISTS spModificarPuntolesion;
    DELIMITER !
    CREATE PROCEDURE spModificarPuntolesion(IN $idPuntoLesion INT, IN $posX varchar(100), IN $posY varchar(100), IN $idReporteAPH int(11))
    BEGIN
    UPDATE `tbl_puntolesion` SET `posX` = $posX, `posY` = $posY, `idReporteAPH` = $idReporteAPH WHERE `idPuntoLesion` = $idPuntoLesion;
    END !
    DELIMITER ;



    -- ==================== LISTAR PUNTOLESION ================== --

    DROP PROCEDURE IF EXISTS spListarPuntolesion;
    DELIMITER !
    CREATE PROCEDURE spListarPuntolesion()
    BEGIN
    SELECT * FROM `tbl_puntolesion`;
    END !
    DELIMITER ;





    -- # CRUD tbl_recurso --


    -- ================== REGISTRAR RECURSO ================= --

    DROP PROCEDURE IF EXISTS spRegistrarRecurso;
    DELIMITER !
    CREATE PROCEDURE spRegistrarRecurso(IN $nombre varchar(45), IN $descripcion varchar(45), IN $cantidadRecurso int(11), IN $estadoTablaRecurso varchar(50), IN $idCategoriaRecurso int(11))
    BEGIN
    INSERT INTO `tbl_recurso`(`nombre`, `descripcion`, `cantidadRecurso`, `estadoTablaRecurso`, `idCategoriaRecurso`) VALUES ($nombre, $descripcion, $cantidadRecurso, $estadoTablaRecurso, $idCategoriaRecurso);
    END !
    DELIMITER ;



    -- =================== CONSULTAR RECURSO ================ --

    DROP PROCEDURE IF EXISTS spConsultarRecurso;
    DELIMITER !
    CREATE PROCEDURE spConsultarRecurso(IN $idrecurso INT)
    BEGIN
    SELECT * FROM `tbl_recurso` WHERE `idrecurso` = $idrecurso;
    END !
    DELIMITER ;



    -- ================== MODIFICAR RECURSO ================= --

    DROP PROCEDURE IF EXISTS spModificarRecurso;
    DELIMITER !
    CREATE PROCEDURE spModificarRecurso(IN $idrecurso INT, IN $nombre varchar(45), IN $descripcion varchar(45), IN $cantidadRecurso int(11), IN $idCategoriaRecurso int(11))
    BEGIN
    UPDATE `tbl_recurso` SET `nombre` = $nombre, `descripcion` = $descripcion, `cantidadRecurso` = $cantidadRecurso, `idCategoriaRecurso` = $idCategoriaRecurso WHERE `idrecurso` = $idrecurso;
    END !
    DELIMITER ;



    -- ==================== LISTAR RECURSO ================== --

    DROP PROCEDURE IF EXISTS spListarRecurso;
    DELIMITER !
    CREATE PROCEDURE spListarRecurso()
    BEGIN
    SELECT * FROM `tbl_recurso`;
    END !
    DELIMITER ;


      -- ================== CAMBIAR ESTADO RECURSO ================= --

      DROP PROCEDURE IF EXISTS spCambiarEstadoRecurso;
      DELIMITER !
      CREATE PROCEDURE spCambiarEstadoRecurso(IN $idrecurso INT, IN $estadoTablaRecurso varchar(50))
      BEGIN
      UPDATE `tbl_recurso` SET `estadoTablaRecurso` = $estadoTablaRecurso WHERE `idrecurso` = $idrecurso;
      END !
      DELIMITER ;



    -- # CRUD tbl_reporteaph --


    -- ================== REGISTRAR REPORTEAPH ================= --

    DROP PROCEDURE IF EXISTS spRegistrarReporteaph;
    DELIMITER !
    CREATE PROCEDURE spRegistrarReporteaph(IN $idExamenFisico int(11), IN $idDespacho int(11), IN $idAsignacionPersonal int(11), IN $idPersonalRecibe int(11), IN $idParamedicoAtiende int(11), IN $idTriage int(11), IN $idTipoAseguramiento int(11), IN $idCertificadoAtencion int(11), IN $fechaHoraFinalizacion datetime, IN $fechaHoraArriboEscena datetime, IN $fechaHoraArriboIPS datetime, IN $ultimaIngesta datetime, IN $idAfectadoAccidenteTransito int(11), IN $placaVehiculo varchar(45), IN $codigoAseguradora varchar(45), IN $numeroPoliza varchar(45), IN $descripcionTratamiento text, IN $descripcionTratamientoAvanzado text, IN $evaluacionResultado varchar(45), IN $institucionReceptora varchar(45), IN $situacionEntrega varchar(45), IN $presionArterialEntrega varchar(45), IN $pulsoEntrega varchar(45), IN $respiracionEntrega varchar(45), IN $estadoTablaReporteAPH varchar(50), IN $complicaciones text, IN $idPaciente int(11), IN $idAcompanante int(11), IN $TAPHPresente tinyint(1), IN $TPAPHPresente tinyint(1), IN $otroPersonalControlM tinyint(1), IN $nombreOtroPersonalControlM varchar(45), IN $protocolo bit(1))
    BEGIN
    INSERT INTO `tbl_reporteaph`(`idExamenFisico`, `idDespacho`, `idAsignacionPersonal`, `idPersonalRecibe`, `idParamedicoAtiende`, `idTriage`, `idTipoAseguramiento`, `idCertificadoAtencion`, `fechaHoraFinalizacion`, `fechaHoraArriboEscena`, `fechaHoraArriboIPS`, `ultimaIngesta`, `idAfectadoAccidenteTransito`, `placaVehiculo`, `codigoAseguradora`, `numeroPoliza`, `descripcionTratamiento`, `descripcionTratamientoAvanzado`, `evaluacionResultado`, `institucionReceptora`, `situacionEntrega`, `presionArterialEntrega`, `pulsoEntrega`, `respiracionEntrega`, `estadoTablaReporteAPH`, `complicaciones`, `idPaciente`, `idAcompanante`, `TAPHPresente`, `TPAPHPresente`, `otroPersonalControlM`, `nombreOtroPersonalControlM`, `protocolo`) VALUES ($idExamenFisico, $idDespacho, $idAsignacionPersonal, $idPersonalRecibe, $idParamedicoAtiende, $idTriage, $idTipoAseguramiento, $idCertificadoAtencion, $fechaHoraFinalizacion, $fechaHoraArriboEscena, $fechaHoraArriboIPS, $ultimaIngesta, $idAfectadoAccidenteTransito, $placaVehiculo, $codigoAseguradora, $numeroPoliza, $descripcionTratamiento, $descripcionTratamientoAvanzado, $evaluacionResultado, $institucionReceptora, $situacionEntrega, $presionArterialEntrega, $pulsoEntrega, $respiracionEntrega, $estadoTablaReporteAPH, $complicaciones, $idPaciente, $idAcompanante, $TAPHPresente, $TPAPHPresente, $otroPersonalControlM, $nombreOtroPersonalControlM, $protocolo);
    END !
    DELIMITER ;



    -- =================== CONSULTAR REPORTEAPH ================ --

    DROP PROCEDURE IF EXISTS spConsultarReporteaph;
    DELIMITER !
    CREATE PROCEDURE spConsultarReporteaph(IN $idReporteAPH INT)
    BEGIN
    SELECT * FROM `tbl_reporteaph` WHERE `idReporteAPH` = $idReporteAPH;
    END !
    DELIMITER ;



    -- ================== MODIFICAR REPORTEAPH ================= --

    DROP PROCEDURE IF EXISTS spModificarReporteaph;
    DELIMITER !
    CREATE PROCEDURE spModificarReporteaph(IN $idReporteAPH INT, IN $idExamenFisico int(11), IN $idDespacho int(11), IN $idAsignacionPersonal int(11), IN $idPersonalRecibe int(11), IN $idParamedicoAtiende int(11), IN $idTriage int(11), IN $idTipoAseguramiento int(11), IN $idCertificadoAtencion int(11), IN $fechaHoraFinalizacion datetime, IN $fechaHoraArriboEscena datetime, IN $fechaHoraArriboIPS datetime, IN $ultimaIngesta datetime, IN $idAfectadoAccidenteTransito int(11), IN $placaVehiculo varchar(45), IN $codigoAseguradora varchar(45), IN $numeroPoliza varchar(45), IN $descripcionTratamiento text, IN $descripcionTratamientoAvanzado text, IN $evaluacionResultado varchar(45), IN $institucionReceptora varchar(45), IN $situacionEntrega varchar(45), IN $presionArterialEntrega varchar(45), IN $pulsoEntrega varchar(45), IN $respiracionEntrega varchar(45), IN $complicaciones text, IN $idPaciente int(11), IN $idAcompanante int(11), IN $TAPHPresente tinyint(1), IN $TPAPHPresente tinyint(1), IN $otroPersonalControlM tinyint(1), IN $nombreOtroPersonalControlM varchar(45), IN $protocolo bit(1))
    BEGIN
    UPDATE `tbl_reporteaph` SET `idExamenFisico` = $idExamenFisico, `idDespacho` = $idDespacho, `idAsignacionPersonal` = $idAsignacionPersonal, `idPersonalRecibe` = $idPersonalRecibe, `idParamedicoAtiende` = $idParamedicoAtiende, `idTriage` = $idTriage, `idTipoAseguramiento` = $idTipoAseguramiento, `idCertificadoAtencion` = $idCertificadoAtencion, `fechaHoraFinalizacion` = $fechaHoraFinalizacion, `fechaHoraArriboEscena` = $fechaHoraArriboEscena, `fechaHoraArriboIPS` = $fechaHoraArriboIPS, `ultimaIngesta` = $ultimaIngesta, `idAfectadoAccidenteTransito` = $idAfectadoAccidenteTransito, `placaVehiculo` = $placaVehiculo, `codigoAseguradora` = $codigoAseguradora, `numeroPoliza` = $numeroPoliza, `descripcionTratamiento` = $descripcionTratamiento, `descripcionTratamientoAvanzado` = $descripcionTratamientoAvanzado, `evaluacionResultado` = $evaluacionResultado, `institucionReceptora` = $institucionReceptora, `situacionEntrega` = $situacionEntrega, `presionArterialEntrega` = $presionArterialEntrega, `pulsoEntrega` = $pulsoEntrega, `respiracionEntrega` = $respiracionEntrega, `complicaciones` = $complicaciones, `idPaciente` = $idPaciente, `idAcompanante` = $idAcompanante, `TAPHPresente` = $TAPHPresente, `TPAPHPresente` = $TPAPHPresente, `otroPersonalControlM` = $otroPersonalControlM, `nombreOtroPersonalControlM` = $nombreOtroPersonalControlM, `protocolo` = $protocolo WHERE `idReporteAPH` = $idReporteAPH;
    END !
    DELIMITER ;



    -- ==================== LISTAR REPORTEAPH ================== --

    DROP PROCEDURE IF EXISTS spListarReporteaph;
    DELIMITER !
    CREATE PROCEDURE spListarReporteaph()
    BEGIN
    SELECT * FROM `tbl_reporteaph`;
    END !
    DELIMITER ;


      -- ================== CAMBIAR ESTADO REPORTEAPH ================= --

      DROP PROCEDURE IF EXISTS spCambiarEstadoReporteaph;
      DELIMITER !
      CREATE PROCEDURE spCambiarEstadoReporteaph(IN $idReporteAPH INT, IN $estadoTablaReporteAPH varchar(50))
      BEGIN
      UPDATE `tbl_reporteaph` SET `estadoTablaReporteAPH` = $estadoTablaReporteAPH WHERE `idReporteAPH` = $idReporteAPH;
      END !
      DELIMITER ;



    -- # CRUD tbl_reporteaph_motivoconsulta --


    -- ================== REGISTRAR REPORTEAPH_MOTIVOCONSULTA ================= --

    DROP PROCEDURE IF EXISTS spRegistrarReporteaph_motivoconsulta;
    DELIMITER !
    CREATE PROCEDURE spRegistrarReporteaph_motivoconsulta(IN $idReporteAPH int(11), IN $idMotivoConsulta int(11), IN $especificacion text)
    BEGIN
    INSERT INTO `tbl_reporteaph_motivoconsulta`(`idReporteAPH`, `idMotivoConsulta`, `especificacion`) VALUES ($idReporteAPH, $idMotivoConsulta, $especificacion);
    END !
    DELIMITER ;



    -- =================== CONSULTAR REPORTEAPH_MOTIVOCONSULTA ================ --

    DROP PROCEDURE IF EXISTS spConsultarReporteaph_motivoconsulta;
    DELIMITER !
    CREATE PROCEDURE spConsultarReporteaph_motivoconsulta(IN $idAPHMC INT)
    BEGIN
    SELECT * FROM `tbl_reporteaph_motivoconsulta` WHERE `idAPHMC` = $idAPHMC;
    END !
    DELIMITER ;



    -- ================== MODIFICAR REPORTEAPH_MOTIVOCONSULTA ================= --

    DROP PROCEDURE IF EXISTS spModificarReporteaph_motivoconsulta;
    DELIMITER !
    CREATE PROCEDURE spModificarReporteaph_motivoconsulta(IN $idAPHMC INT, IN $idReporteAPH int(11), IN $idMotivoConsulta int(11), IN $especificacion text)
    BEGIN
    UPDATE `tbl_reporteaph_motivoconsulta` SET `idReporteAPH` = $idReporteAPH, `idMotivoConsulta` = $idMotivoConsulta, `especificacion` = $especificacion WHERE `idAPHMC` = $idAPHMC;
    END !
    DELIMITER ;



    -- ==================== LISTAR REPORTEAPH_MOTIVOCONSULTA ================== --

    DROP PROCEDURE IF EXISTS spListarReporteaph_motivoconsulta;
    DELIMITER !
    CREATE PROCEDURE spListarReporteaph_motivoconsulta()
    BEGIN
    SELECT * FROM `tbl_reporteaph_motivoconsulta`;
    END !
    DELIMITER ;





    -- # CRUD tbl_reporteinicial --


    -- ================== REGISTRAR REPORTEINICIAL ================= --

    DROP PROCEDURE IF EXISTS spRegistrarReporteinicial;
    DELIMITER !
    CREATE PROCEDURE spRegistrarReporteinicial(IN $informacionInicial varchar(300), IN $ubicacionIncidente varchar(100), IN $puntoReferencia varchar(45), IN $numeroLesionados int(11), IN $fechaHoraAproximadaEmergencia datetime, IN $fechaHoraEnvioReporteInicial timestamp, IN $estadoTablaReporteInicial varchar(50), IN $idChat int(11))
    BEGIN
    INSERT INTO `tbl_reporteinicial`(`informacionInicial`, `ubicacionIncidente`, `puntoReferencia`, `numeroLesionados`, `fechaHoraAproximadaEmergencia`, `fechaHoraEnvioReporteInicial`, `estadoTablaReporteInicial`, `idChat`) VALUES ($informacionInicial, $ubicacionIncidente, $puntoReferencia, $numeroLesionados, $fechaHoraAproximadaEmergencia, $fechaHoraEnvioReporteInicial, $estadoTablaReporteInicial, $idChat);
    END !
    DELIMITER ;



    -- =================== CONSULTAR REPORTEINICIAL ================ --

    DROP PROCEDURE IF EXISTS spConsultarReporteinicial;
    DELIMITER !
    CREATE PROCEDURE spConsultarReporteinicial(IN $idReporteInicial INT)
    BEGIN
    SELECT * FROM `tbl_reporteinicial` WHERE `idReporteInicial` = $idReporteInicial;
    END !
    DELIMITER ;



    -- ================== MODIFICAR REPORTEINICIAL ================= --

    DROP PROCEDURE IF EXISTS spModificarReporteinicial;
    DELIMITER !
    CREATE PROCEDURE spModificarReporteinicial(IN $idReporteInicial INT, IN $informacionInicial varchar(300), IN $ubicacionIncidente varchar(100), IN $puntoReferencia varchar(45), IN $numeroLesionados int(11), IN $fechaHoraAproximadaEmergencia datetime, IN $fechaHoraEnvioReporteInicial timestamp, IN $idChat int(11))
    BEGIN
    UPDATE `tbl_reporteinicial` SET `informacionInicial` = $informacionInicial, `ubicacionIncidente` = $ubicacionIncidente, `puntoReferencia` = $puntoReferencia, `numeroLesionados` = $numeroLesionados, `fechaHoraAproximadaEmergencia` = $fechaHoraAproximadaEmergencia, `fechaHoraEnvioReporteInicial` = $fechaHoraEnvioReporteInicial, `idChat` = $idChat WHERE `idReporteInicial` = $idReporteInicial;
    END !
    DELIMITER ;



    -- ==================== LISTAR REPORTEINICIAL ================== --

    DROP PROCEDURE IF EXISTS spListarReporteinicial;
    DELIMITER !
    CREATE PROCEDURE spListarReporteinicial()
    BEGIN
    SELECT * FROM `tbl_reporteinicial`;
    END !
    DELIMITER ;


      -- ================== CAMBIAR ESTADO REPORTEINICIAL ================= --

      DROP PROCEDURE IF EXISTS spCambiarEstadoReporteinicial;
      DELIMITER !
      CREATE PROCEDURE spCambiarEstadoReporteinicial(IN $idReporteInicial INT, IN $estadoTablaReporteInicial varchar(50))
      BEGIN
      UPDATE `tbl_reporteinicial` SET `estadoTablaReporteInicial` = $estadoTablaReporteInicial WHERE `idReporteInicial` = $idReporteInicial;
      END !
      DELIMITER ;



    -- # CRUD tbl_restablecer --


    -- ================== REGISTRAR RESTABLECER ================= --

    DROP PROCEDURE IF EXISTS spRegistrarRestablecer;
    DELIMITER !
    CREATE PROCEDURE spRegistrarRestablecer(IN $email varchar(50), IN $codigo varchar(50), IN $idUsuario int(11), IN $estado varchar(20), IN $fecha timestamp)
    BEGIN
    INSERT INTO `tbl_restablecer`(`email`, `codigo`, `idUsuario`, `estado`, `fecha`) VALUES ($email, $codigo, $idUsuario, $estado, $fecha);
    END !
    DELIMITER ;



    -- =================== CONSULTAR RESTABLECER ================ --

    DROP PROCEDURE IF EXISTS spConsultarRestablecer;
    DELIMITER !
    CREATE PROCEDURE spConsultarRestablecer(IN $idRestablecer INT)
    BEGIN
    SELECT * FROM `tbl_restablecer` WHERE `idRestablecer` = $idRestablecer;
    END !
    DELIMITER ;



    -- ================== MODIFICAR RESTABLECER ================= --

    DROP PROCEDURE IF EXISTS spModificarRestablecer;
    DELIMITER !
    CREATE PROCEDURE spModificarRestablecer(IN $idRestablecer INT, IN $email varchar(50), IN $codigo varchar(50), IN $idUsuario int(11), IN $estado varchar(20), IN $fecha timestamp)
    BEGIN
    UPDATE `tbl_restablecer` SET `email` = $email, `codigo` = $codigo, `idUsuario` = $idUsuario, `estado` = $estado, `fecha` = $fecha WHERE `idRestablecer` = $idRestablecer;
    END !
    DELIMITER ;



    -- ==================== LISTAR RESTABLECER ================== --

    DROP PROCEDURE IF EXISTS spListarRestablecer;
    DELIMITER !
    CREATE PROCEDURE spListarRestablecer()
    BEGIN
    SELECT * FROM `tbl_restablecer`;
    END !
    DELIMITER ;





    -- # CRUD tbl_rol --


    -- ================== REGISTRAR ROL ================= --

    DROP PROCEDURE IF EXISTS spRegistrarRol;
    DELIMITER !
    CREATE PROCEDURE spRegistrarRol(IN $descripcionRol varchar(45), IN $estadoTabla varchar(50))
    BEGIN
    INSERT INTO `tbl_rol`(`descripcionRol`, `estadoTabla`) VALUES ($descripcionRol, $estadoTabla);
    END !
    DELIMITER ;



    -- =================== CONSULTAR ROL ================ --

    DROP PROCEDURE IF EXISTS spConsultarRol;
    DELIMITER !
    CREATE PROCEDURE spConsultarRol(IN $idRol INT)
    BEGIN
    SELECT * FROM `tbl_rol` WHERE `idRol` = $idRol;
    END !
    DELIMITER ;



    -- ================== MODIFICAR ROL ================= --

    DROP PROCEDURE IF EXISTS spModificarRol;
    DELIMITER !
    CREATE PROCEDURE spModificarRol(IN $idRol INT, IN $descripcionRol varchar(45))
    BEGIN
    UPDATE `tbl_rol` SET `descripcionRol` = $descripcionRol WHERE `idRol` = $idRol;
    END !
    DELIMITER ;



    -- ==================== LISTAR ROL ================== --

    DROP PROCEDURE IF EXISTS spListarRol;
    DELIMITER !
    CREATE PROCEDURE spListarRol()
    BEGIN
    SELECT * FROM `tbl_rol`;
    END !
    DELIMITER ;


      -- ================== CAMBIAR ESTADO ROL ================= --

      DROP PROCEDURE IF EXISTS spCambiarEstadoRol;
      DELIMITER !
      CREATE PROCEDURE spCambiarEstadoRol(IN $idRol INT, IN $estadoTabla varchar(50))
      BEGIN
      UPDATE `tbl_rol` SET `estadoTabla` = $estadoTabla WHERE `idRol` = $idRol;
      END !
      DELIMITER ;



    -- # CRUD tbl_rolmodulovista --


    -- ================== REGISTRAR ROLMODULOVISTA ================= --

    DROP PROCEDURE IF EXISTS spRegistrarRolmodulovista;
    DELIMITER !
    CREATE PROCEDURE spRegistrarRolmodulovista(IN $idRol int(11), IN $idModulo int(11), IN $idVista int(11))
    BEGIN
    INSERT INTO `tbl_rolmodulovista`(`idRol`, `idModulo`, `idVista`) VALUES ($idRol, $idModulo, $idVista);
    END !
    DELIMITER ;



    -- =================== CONSULTAR ROLMODULOVISTA ================ --

    DROP PROCEDURE IF EXISTS spConsultarRolmodulovista;
    DELIMITER !
    CREATE PROCEDURE spConsultarRolmodulovista(IN $idRolModuloVista INT)
    BEGIN
    SELECT * FROM `tbl_rolmodulovista` WHERE `idRolModuloVista` = $idRolModuloVista;
    END !
    DELIMITER ;



    -- ================== MODIFICAR ROLMODULOVISTA ================= --

    DROP PROCEDURE IF EXISTS spModificarRolmodulovista;
    DELIMITER !
    CREATE PROCEDURE spModificarRolmodulovista(IN $idRolModuloVista INT, IN $idRol int(11), IN $idModulo int(11), IN $idVista int(11))
    BEGIN
    UPDATE `tbl_rolmodulovista` SET `idRol` = $idRol, `idModulo` = $idModulo, `idVista` = $idVista WHERE `idRolModuloVista` = $idRolModuloVista;
    END !
    DELIMITER ;



    -- ==================== LISTAR ROLMODULOVISTA ================== --

    DROP PROCEDURE IF EXISTS spListarRolmodulovista;
    DELIMITER !
    CREATE PROCEDURE spListarRolmodulovista()
    BEGIN
    SELECT * FROM `tbl_rolmodulovista`;
    END !
    DELIMITER ;





    -- # CRUD tbl_signosvitales --


    -- ================== REGISTRAR SIGNOSVITALES ================= --

    DROP PROCEDURE IF EXISTS spRegistrarSignosvitales;
    DELIMITER !
    CREATE PROCEDURE spRegistrarSignosvitales(IN $resultado double, IN $hora time, IN $idHistoriaClinica int(11), IN $idValoracion int(11))
    BEGIN
    INSERT INTO `tbl_signosvitales`(`resultado`, `hora`, `idHistoriaClinica`, `idValoracion`) VALUES ($resultado, $hora, $idHistoriaClinica, $idValoracion);
    END !
    DELIMITER ;



    -- =================== CONSULTAR SIGNOSVITALES ================ --

    DROP PROCEDURE IF EXISTS spConsultarSignosvitales;
    DELIMITER !
    CREATE PROCEDURE spConsultarSignosvitales(IN $idSignosVitales INT)
    BEGIN
    SELECT * FROM `tbl_signosvitales` WHERE `idSignosVitales` = $idSignosVitales;
    END !
    DELIMITER ;



    -- ================== MODIFICAR SIGNOSVITALES ================= --

    DROP PROCEDURE IF EXISTS spModificarSignosvitales;
    DELIMITER !
    CREATE PROCEDURE spModificarSignosvitales(IN $idSignosVitales INT, IN $resultado double, IN $hora time, IN $idHistoriaClinica int(11), IN $idValoracion int(11))
    BEGIN
    UPDATE `tbl_signosvitales` SET `resultado` = $resultado, `hora` = $hora, `idHistoriaClinica` = $idHistoriaClinica, `idValoracion` = $idValoracion WHERE `idSignosVitales` = $idSignosVitales;
    END !
    DELIMITER ;



    -- ==================== LISTAR SIGNOSVITALES ================== --

    DROP PROCEDURE IF EXISTS spListarSignosvitales;
    DELIMITER !
    CREATE PROCEDURE spListarSignosvitales()
    BEGIN
    SELECT * FROM `tbl_signosvitales`;
    END !
    DELIMITER ;





    -- # CRUD tbl_solicitud --


    -- ================== REGISTRAR SOLICITUD ================= --

    DROP PROCEDURE IF EXISTS spRegistrarSolicitud;
    DELIMITER !
    CREATE PROCEDURE spRegistrarSolicitud(IN $Descripcion varchar(60), IN $CuentaUsuario_idUsuario int(11))
    BEGIN
    INSERT INTO `tbl_solicitud`(`Descripcion`, `CuentaUsuario_idUsuario`) VALUES ($Descripcion, $CuentaUsuario_idUsuario);
    END !
    DELIMITER ;



    -- =================== CONSULTAR SOLICITUD ================ --

    DROP PROCEDURE IF EXISTS spConsultarSolicitud;
    DELIMITER !
    CREATE PROCEDURE spConsultarSolicitud(IN $idSolicitud INT)
    BEGIN
    SELECT * FROM `tbl_solicitud` WHERE `idSolicitud` = $idSolicitud;
    END !
    DELIMITER ;



    -- ================== MODIFICAR SOLICITUD ================= --

    DROP PROCEDURE IF EXISTS spModificarSolicitud;
    DELIMITER !
    CREATE PROCEDURE spModificarSolicitud(IN $idSolicitud INT, IN $Descripcion varchar(60), IN $CuentaUsuario_idUsuario int(11))
    BEGIN
    UPDATE `tbl_solicitud` SET `Descripcion` = $Descripcion, `CuentaUsuario_idUsuario` = $CuentaUsuario_idUsuario WHERE `idSolicitud` = $idSolicitud;
    END !
    DELIMITER ;



    -- ==================== LISTAR SOLICITUD ================== --

    DROP PROCEDURE IF EXISTS spListarSolicitud;
    DELIMITER !
    CREATE PROCEDURE spListarSolicitud()
    BEGIN
    SELECT * FROM `tbl_solicitud`;
    END !
    DELIMITER ;





    -- # CRUD tbl_testigo --


    -- ================== REGISTRAR TESTIGO ================= --

    DROP PROCEDURE IF EXISTS spRegistrarTestigo;
    DELIMITER !
    CREATE PROCEDURE spRegistrarTestigo(IN $idReporteAPH int(11), IN $nombreTestigo varchar(45), IN $identificacionTestigo varchar(45))
    BEGIN
    INSERT INTO `tbl_testigo`(`idReporteAPH`, `nombreTestigo`, `identificacionTestigo`) VALUES ($idReporteAPH, $nombreTestigo, $identificacionTestigo);
    END !
    DELIMITER ;



    -- =================== CONSULTAR TESTIGO ================ --

    DROP PROCEDURE IF EXISTS spConsultarTestigo;
    DELIMITER !
    CREATE PROCEDURE spConsultarTestigo(IN $idTestigo INT)
    BEGIN
    SELECT * FROM `tbl_testigo` WHERE `idTestigo` = $idTestigo;
    END !
    DELIMITER ;



    -- ================== MODIFICAR TESTIGO ================= --

    DROP PROCEDURE IF EXISTS spModificarTestigo;
    DELIMITER !
    CREATE PROCEDURE spModificarTestigo(IN $idTestigo INT, IN $idReporteAPH int(11), IN $nombreTestigo varchar(45), IN $identificacionTestigo varchar(45))
    BEGIN
    UPDATE `tbl_testigo` SET `idReporteAPH` = $idReporteAPH, `nombreTestigo` = $nombreTestigo, `identificacionTestigo` = $identificacionTestigo WHERE `idTestigo` = $idTestigo;
    END !
    DELIMITER ;



    -- ==================== LISTAR TESTIGO ================== --

    DROP PROCEDURE IF EXISTS spListarTestigo;
    DELIMITER !
    CREATE PROCEDURE spListarTestigo()
    BEGIN
    SELECT * FROM `tbl_testigo`;
    END !
    DELIMITER ;





    -- # CRUD tbl_tipoafiliacion --


    -- ================== REGISTRAR TIPOAFILIACION ================= --

    DROP PROCEDURE IF EXISTS spRegistrarTipoafiliacion;
    DELIMITER !
    CREATE PROCEDURE spRegistrarTipoafiliacion(IN $descripcionAfiliacion varchar(45), IN $estadoTabla varchar(50))
    BEGIN
    INSERT INTO `tbl_tipoafiliacion`(`descripcionAfiliacion`, `estadoTabla`) VALUES ($descripcionAfiliacion, $estadoTabla);
    END !
    DELIMITER ;



    -- =================== CONSULTAR TIPOAFILIACION ================ --

    DROP PROCEDURE IF EXISTS spConsultarTipoafiliacion;
    DELIMITER !
    CREATE PROCEDURE spConsultarTipoafiliacion(IN $idTipoAfiliacion INT)
    BEGIN
    SELECT * FROM `tbl_tipoafiliacion` WHERE `idTipoAfiliacion` = $idTipoAfiliacion;
    END !
    DELIMITER ;



    -- ================== MODIFICAR TIPOAFILIACION ================= --

    DROP PROCEDURE IF EXISTS spModificarTipoafiliacion;
    DELIMITER !
    CREATE PROCEDURE spModificarTipoafiliacion(IN $idTipoAfiliacion INT, IN $descripcionAfiliacion varchar(45))
    BEGIN
    UPDATE `tbl_tipoafiliacion` SET `descripcionAfiliacion` = $descripcionAfiliacion WHERE `idTipoAfiliacion` = $idTipoAfiliacion;
    END !
    DELIMITER ;



    -- ==================== LISTAR TIPOAFILIACION ================== --

    DROP PROCEDURE IF EXISTS spListarTipoafiliacion;
    DELIMITER !
    CREATE PROCEDURE spListarTipoafiliacion()
    BEGIN
    SELECT * FROM `tbl_tipoafiliacion`;
    END !
    DELIMITER ;


      -- ================== CAMBIAR ESTADO TIPOAFILIACION ================= --

      DROP PROCEDURE IF EXISTS spCambiarEstadoTipoafiliacion;
      DELIMITER !
      CREATE PROCEDURE spCambiarEstadoTipoafiliacion(IN $idTipoAfiliacion INT, IN $estadoTabla varchar(50))
      BEGIN
      UPDATE `tbl_tipoafiliacion` SET `estadoTabla` = $estadoTabla WHERE `idTipoAfiliacion` = $idTipoAfiliacion;
      END !
      DELIMITER ;



    -- # CRUD tbl_tipoantecedente --


    -- ================== REGISTRAR TIPOANTECEDENTE ================= --

    DROP PROCEDURE IF EXISTS spRegistrarTipoantecedente;
    DELIMITER !
    CREATE PROCEDURE spRegistrarTipoantecedente(IN $descripcion varchar(100), IN $estadoTabla varchar(50))
    BEGIN
    INSERT INTO `tbl_tipoantecedente`(`descripcion`, `estadoTabla`) VALUES ($descripcion, $estadoTabla);
    END !
    DELIMITER ;



    -- =================== CONSULTAR TIPOANTECEDENTE ================ --

    DROP PROCEDURE IF EXISTS spConsultarTipoantecedente;
    DELIMITER !
    CREATE PROCEDURE spConsultarTipoantecedente(IN $idTipoAntecedente INT)
    BEGIN
    SELECT * FROM `tbl_tipoantecedente` WHERE `idTipoAntecedente` = $idTipoAntecedente;
    END !
    DELIMITER ;



    -- ================== MODIFICAR TIPOANTECEDENTE ================= --

    DROP PROCEDURE IF EXISTS spModificarTipoantecedente;
    DELIMITER !
    CREATE PROCEDURE spModificarTipoantecedente(IN $idTipoAntecedente INT, IN $descripcion varchar(100))
    BEGIN
    UPDATE `tbl_tipoantecedente` SET `descripcion` = $descripcion WHERE `idTipoAntecedente` = $idTipoAntecedente;
    END !
    DELIMITER ;



    -- ==================== LISTAR TIPOANTECEDENTE ================== --

    DROP PROCEDURE IF EXISTS spListarTipoantecedente;
    DELIMITER !
    CREATE PROCEDURE spListarTipoantecedente()
    BEGIN
    SELECT * FROM `tbl_tipoantecedente`;
    END !
    DELIMITER ;


      -- ================== CAMBIAR ESTADO TIPOANTECEDENTE ================= --

      DROP PROCEDURE IF EXISTS spCambiarEstadoTipoantecedente;
      DELIMITER !
      CREATE PROCEDURE spCambiarEstadoTipoantecedente(IN $idTipoAntecedente INT, IN $estadoTabla varchar(50))
      BEGIN
      UPDATE `tbl_tipoantecedente` SET `estadoTabla` = $estadoTabla WHERE `idTipoAntecedente` = $idTipoAntecedente;
      END !
      DELIMITER ;



    -- # CRUD tbl_tipoaseguramiento --


    -- ================== REGISTRAR TIPOASEGURAMIENTO ================= --

    DROP PROCEDURE IF EXISTS spRegistrarTipoaseguramiento;
    DELIMITER !
    CREATE PROCEDURE spRegistrarTipoaseguramiento(IN $DescripcionTipoAseguramiento varchar(45), IN $estadoTabla varchar(50))
    BEGIN
    INSERT INTO `tbl_tipoaseguramiento`(`DescripcionTipoAseguramiento`, `estadoTabla`) VALUES ($DescripcionTipoAseguramiento, $estadoTabla);
    END !
    DELIMITER ;



    -- =================== CONSULTAR TIPOASEGURAMIENTO ================ --

    DROP PROCEDURE IF EXISTS spConsultarTipoaseguramiento;
    DELIMITER !
    CREATE PROCEDURE spConsultarTipoaseguramiento(IN $idTipoAseguramiento INT)
    BEGIN
    SELECT * FROM `tbl_tipoaseguramiento` WHERE `idTipoAseguramiento` = $idTipoAseguramiento;
    END !
    DELIMITER ;



    -- ================== MODIFICAR TIPOASEGURAMIENTO ================= --

    DROP PROCEDURE IF EXISTS spModificarTipoaseguramiento;
    DELIMITER !
    CREATE PROCEDURE spModificarTipoaseguramiento(IN $idTipoAseguramiento INT, IN $DescripcionTipoAseguramiento varchar(45))
    BEGIN
    UPDATE `tbl_tipoaseguramiento` SET `DescripcionTipoAseguramiento` = $DescripcionTipoAseguramiento WHERE `idTipoAseguramiento` = $idTipoAseguramiento;
    END !
    DELIMITER ;



    -- ==================== LISTAR TIPOASEGURAMIENTO ================== --

    DROP PROCEDURE IF EXISTS spListarTipoaseguramiento;
    DELIMITER !
    CREATE PROCEDURE spListarTipoaseguramiento()
    BEGIN
    SELECT * FROM `tbl_tipoaseguramiento`;
    END !
    DELIMITER ;


      -- ================== CAMBIAR ESTADO TIPOASEGURAMIENTO ================= --

      DROP PROCEDURE IF EXISTS spCambiarEstadoTipoaseguramiento;
      DELIMITER !
      CREATE PROCEDURE spCambiarEstadoTipoaseguramiento(IN $idTipoAseguramiento INT, IN $estadoTabla varchar(50))
      BEGIN
      UPDATE `tbl_tipoaseguramiento` SET `estadoTabla` = $estadoTabla WHERE `idTipoAseguramiento` = $idTipoAseguramiento;
      END !
      DELIMITER ;



    -- # CRUD tbl_tipoasignacion --


    -- ================== REGISTRAR TIPOASIGNACION ================= --

    DROP PROCEDURE IF EXISTS spRegistrarTipoasignacion;
    DELIMITER !
    CREATE PROCEDURE spRegistrarTipoasignacion(IN $descripcionTipoasignacion varchar(45), IN $estadoTabla varchar(50))
    BEGIN
    INSERT INTO `tbl_tipoasignacion`(`descripcionTipoasignacion`, `estadoTabla`) VALUES ($descripcionTipoasignacion, $estadoTabla);
    END !
    DELIMITER ;



    -- =================== CONSULTAR TIPOASIGNACION ================ --

    DROP PROCEDURE IF EXISTS spConsultarTipoasignacion;
    DELIMITER !
    CREATE PROCEDURE spConsultarTipoasignacion(IN $idTipoAsignacion INT)
    BEGIN
    SELECT * FROM `tbl_tipoasignacion` WHERE `idTipoAsignacion` = $idTipoAsignacion;
    END !
    DELIMITER ;



    -- ================== MODIFICAR TIPOASIGNACION ================= --

    DROP PROCEDURE IF EXISTS spModificarTipoasignacion;
    DELIMITER !
    CREATE PROCEDURE spModificarTipoasignacion(IN $idTipoAsignacion INT, IN $descripcionTipoasignacion varchar(45))
    BEGIN
    UPDATE `tbl_tipoasignacion` SET `descripcionTipoasignacion` = $descripcionTipoasignacion WHERE `idTipoAsignacion` = $idTipoAsignacion;
    END !
    DELIMITER ;



    -- ==================== LISTAR TIPOASIGNACION ================== --

    DROP PROCEDURE IF EXISTS spListarTipoasignacion;
    DELIMITER !
    CREATE PROCEDURE spListarTipoasignacion()
    BEGIN
    SELECT * FROM `tbl_tipoasignacion`;
    END !
    DELIMITER ;


      -- ================== CAMBIAR ESTADO TIPOASIGNACION ================= --

      DROP PROCEDURE IF EXISTS spCambiarEstadoTipoasignacion;
      DELIMITER !
      CREATE PROCEDURE spCambiarEstadoTipoasignacion(IN $idTipoAsignacion INT, IN $estadoTabla varchar(50))
      BEGIN
      UPDATE `tbl_tipoasignacion` SET `estadoTabla` = $estadoTabla WHERE `idTipoAsignacion` = $idTipoAsignacion;
      END !
      DELIMITER ;



    -- # CRUD tbl_tipocup --


    -- ================== REGISTRAR TIPOCUP ================= --

    DROP PROCEDURE IF EXISTS spRegistrarTipocup;
    DELIMITER !
    CREATE PROCEDURE spRegistrarTipocup(IN $descripcionCUP varchar(45))
    BEGIN
    INSERT INTO `tbl_tipocup`(`descripcionCUP`) VALUES ($descripcionCUP);
    END !
    DELIMITER ;



    -- =================== CONSULTAR TIPOCUP ================ --

    DROP PROCEDURE IF EXISTS spConsultarTipocup;
    DELIMITER !
    CREATE PROCEDURE spConsultarTipocup(IN $idTipoCup INT)
    BEGIN
    SELECT * FROM `tbl_tipocup` WHERE `idTipoCup` = $idTipoCup;
    END !
    DELIMITER ;



    -- ================== MODIFICAR TIPOCUP ================= --

    DROP PROCEDURE IF EXISTS spModificarTipocup;
    DELIMITER !
    CREATE PROCEDURE spModificarTipocup(IN $idTipoCup INT, IN $descripcionCUP varchar(45))
    BEGIN
    UPDATE `tbl_tipocup` SET `descripcionCUP` = $descripcionCUP WHERE `idTipoCup` = $idTipoCup;
    END !
    DELIMITER ;



    -- ==================== LISTAR TIPOCUP ================== --

    DROP PROCEDURE IF EXISTS spListarTipocup;
    DELIMITER !
    CREATE PROCEDURE spListarTipocup()
    BEGIN
    SELECT * FROM `tbl_tipocup`;
    END !
    DELIMITER ;





    -- # CRUD tbl_tipodevolucion --


    -- ================== REGISTRAR TIPODEVOLUCION ================= --

    DROP PROCEDURE IF EXISTS spRegistrarTipodevolucion;
    DELIMITER !
    CREATE PROCEDURE spRegistrarTipodevolucion(IN $descripcionDevolucion varchar(45), IN $estadoTabla varchar(50))
    BEGIN
    INSERT INTO `tbl_tipodevolucion`(`descripcionDevolucion`, `estadoTabla`) VALUES ($descripcionDevolucion, $estadoTabla);
    END !
    DELIMITER ;



    -- =================== CONSULTAR TIPODEVOLUCION ================ --

    DROP PROCEDURE IF EXISTS spConsultarTipodevolucion;
    DELIMITER !
    CREATE PROCEDURE spConsultarTipodevolucion(IN $idTipoDevolucion INT)
    BEGIN
    SELECT * FROM `tbl_tipodevolucion` WHERE `idTipoDevolucion` = $idTipoDevolucion;
    END !
    DELIMITER ;



    -- ================== MODIFICAR TIPODEVOLUCION ================= --

    DROP PROCEDURE IF EXISTS spModificarTipodevolucion;
    DELIMITER !
    CREATE PROCEDURE spModificarTipodevolucion(IN $idTipoDevolucion INT, IN $descripcionDevolucion varchar(45))
    BEGIN
    UPDATE `tbl_tipodevolucion` SET `descripcionDevolucion` = $descripcionDevolucion WHERE `idTipoDevolucion` = $idTipoDevolucion;
    END !
    DELIMITER ;



    -- ==================== LISTAR TIPODEVOLUCION ================== --

    DROP PROCEDURE IF EXISTS spListarTipodevolucion;
    DELIMITER !
    CREATE PROCEDURE spListarTipodevolucion()
    BEGIN
    SELECT * FROM `tbl_tipodevolucion`;
    END !
    DELIMITER ;


      -- ================== CAMBIAR ESTADO TIPODEVOLUCION ================= --

      DROP PROCEDURE IF EXISTS spCambiarEstadoTipodevolucion;
      DELIMITER !
      CREATE PROCEDURE spCambiarEstadoTipodevolucion(IN $idTipoDevolucion INT, IN $estadoTabla varchar(50))
      BEGIN
      UPDATE `tbl_tipodevolucion` SET `estadoTabla` = $estadoTabla WHERE `idTipoDevolucion` = $idTipoDevolucion;
      END !
      DELIMITER ;



    -- # CRUD tbl_tipodocumento --


    -- ================== REGISTRAR TIPODOCUMENTO ================= --

    DROP PROCEDURE IF EXISTS spRegistrarTipodocumento;
    DELIMITER !
    CREATE PROCEDURE spRegistrarTipodocumento(IN $descripcionTdocumento varchar(45), IN $estadoTabla varchar(50))
    BEGIN
    INSERT INTO `tbl_tipodocumento`(`descripcionTdocumento`, `estadoTabla`) VALUES ($descripcionTdocumento, $estadoTabla);
    END !
    DELIMITER ;



    -- =================== CONSULTAR TIPODOCUMENTO ================ --

    DROP PROCEDURE IF EXISTS spConsultarTipodocumento;
    DELIMITER !
    CREATE PROCEDURE spConsultarTipodocumento(IN $idTipoDocumento INT)
    BEGIN
    SELECT * FROM `tbl_tipodocumento` WHERE `idTipoDocumento` = $idTipoDocumento;
    END !
    DELIMITER ;



    -- ================== MODIFICAR TIPODOCUMENTO ================= --

    DROP PROCEDURE IF EXISTS spModificarTipodocumento;
    DELIMITER !
    CREATE PROCEDURE spModificarTipodocumento(IN $idTipoDocumento INT, IN $descripcionTdocumento varchar(45))
    BEGIN
    UPDATE `tbl_tipodocumento` SET `descripcionTdocumento` = $descripcionTdocumento WHERE `idTipoDocumento` = $idTipoDocumento;
    END !
    DELIMITER ;



    -- ==================== LISTAR TIPODOCUMENTO ================== --

    DROP PROCEDURE IF EXISTS spListarTipodocumento;
    DELIMITER !
    CREATE PROCEDURE spListarTipodocumento()
    BEGIN
    SELECT * FROM `tbl_tipodocumento`;
    END !
    DELIMITER ;


      -- ================== CAMBIAR ESTADO TIPODOCUMENTO ================= --

      DROP PROCEDURE IF EXISTS spCambiarEstadoTipodocumento;
      DELIMITER !
      CREATE PROCEDURE spCambiarEstadoTipodocumento(IN $idTipoDocumento INT, IN $estadoTabla varchar(50))
      BEGIN
      UPDATE `tbl_tipodocumento` SET `estadoTabla` = $estadoTabla WHERE `idTipoDocumento` = $idTipoDocumento;
      END !
      DELIMITER ;



    -- # CRUD tbl_tipoevento --


    -- ================== REGISTRAR TIPOEVENTO ================= --

    DROP PROCEDURE IF EXISTS spRegistrarTipoevento;
    DELIMITER !
    CREATE PROCEDURE spRegistrarTipoevento(IN $descripcionTipoEvento varchar(45), IN $estadoTabla varchar(50))
    BEGIN
    INSERT INTO `tbl_tipoevento`(`descripcionTipoEvento`, `estadoTabla`) VALUES ($descripcionTipoEvento, $estadoTabla);
    END !
    DELIMITER ;



    -- =================== CONSULTAR TIPOEVENTO ================ --

    DROP PROCEDURE IF EXISTS spConsultarTipoevento;
    DELIMITER !
    CREATE PROCEDURE spConsultarTipoevento(IN $idTipoEvento INT)
    BEGIN
    SELECT * FROM `tbl_tipoevento` WHERE `idTipoEvento` = $idTipoEvento;
    END !
    DELIMITER ;



    -- ================== MODIFICAR TIPOEVENTO ================= --

    DROP PROCEDURE IF EXISTS spModificarTipoevento;
    DELIMITER !
    CREATE PROCEDURE spModificarTipoevento(IN $idTipoEvento INT, IN $descripcionTipoEvento varchar(45))
    BEGIN
    UPDATE `tbl_tipoevento` SET `descripcionTipoEvento` = $descripcionTipoEvento WHERE `idTipoEvento` = $idTipoEvento;
    END !
    DELIMITER ;



    -- ==================== LISTAR TIPOEVENTO ================== --

    DROP PROCEDURE IF EXISTS spListarTipoevento;
    DELIMITER !
    CREATE PROCEDURE spListarTipoevento()
    BEGIN
    SELECT * FROM `tbl_tipoevento`;
    END !
    DELIMITER ;


      -- ================== CAMBIAR ESTADO TIPOEVENTO ================= --

      DROP PROCEDURE IF EXISTS spCambiarEstadoTipoevento;
      DELIMITER !
      CREATE PROCEDURE spCambiarEstadoTipoevento(IN $idTipoEvento INT, IN $estadoTabla varchar(50))
      BEGIN
      UPDATE `tbl_tipoevento` SET `estadoTabla` = $estadoTabla WHERE `idTipoEvento` = $idTipoEvento;
      END !
      DELIMITER ;



    -- # CRUD tbl_tipoevento_novedadreporteinicial --


    -- ================== REGISTRAR TIPOEVENTO_NOVEDADREPORTEINICIAL ================= --

    DROP PROCEDURE IF EXISTS spRegistrarTipoevento_novedadreporteinicial;
    DELIMITER !
    CREATE PROCEDURE spRegistrarTipoevento_novedadreporteinicial(IN $idTipoEvento int(11), IN $idNovedad int(11))
    BEGIN
    INSERT INTO `tbl_tipoevento_novedadreporteinicial`(`idTipoEvento`, `idNovedad`) VALUES ($idTipoEvento, $idNovedad);
    END !
    DELIMITER ;



    -- =================== CONSULTAR TIPOEVENTO_NOVEDADREPORTEINICIAL ================ --

    DROP PROCEDURE IF EXISTS spConsultarTipoevento_novedadreporteinicial;
    DELIMITER !
    CREATE PROCEDURE spConsultarTipoevento_novedadreporteinicial(IN $idTipoEventoNovedadReporteInicial INT)
    BEGIN
    SELECT * FROM `tbl_tipoevento_novedadreporteinicial` WHERE `idTipoEventoNovedadReporteInicial` = $idTipoEventoNovedadReporteInicial;
    END !
    DELIMITER ;



    -- ================== MODIFICAR TIPOEVENTO_NOVEDADREPORTEINICIAL ================= --

    DROP PROCEDURE IF EXISTS spModificarTipoevento_novedadreporteinicial;
    DELIMITER !
    CREATE PROCEDURE spModificarTipoevento_novedadreporteinicial(IN $idTipoEventoNovedadReporteInicial INT, IN $idTipoEvento int(11), IN $idNovedad int(11))
    BEGIN
    UPDATE `tbl_tipoevento_novedadreporteinicial` SET `idTipoEvento` = $idTipoEvento, `idNovedad` = $idNovedad WHERE `idTipoEventoNovedadReporteInicial` = $idTipoEventoNovedadReporteInicial;
    END !
    DELIMITER ;



    -- ==================== LISTAR TIPOEVENTO_NOVEDADREPORTEINICIAL ================== --

    DROP PROCEDURE IF EXISTS spListarTipoevento_novedadreporteinicial;
    DELIMITER !
    CREATE PROCEDURE spListarTipoevento_novedadreporteinicial()
    BEGIN
    SELECT * FROM `tbl_tipoevento_novedadreporteinicial`;
    END !
    DELIMITER ;





    -- # CRUD tbl_tipoevento_reporteinicial --


    -- ================== REGISTRAR TIPOEVENTO_REPORTEINICIAL ================= --

    DROP PROCEDURE IF EXISTS spRegistrarTipoevento_reporteinicial;
    DELIMITER !
    CREATE PROCEDURE spRegistrarTipoevento_reporteinicial(IN $idReporteInicial int(11), IN $idTipoEvento int(11))
    BEGIN
    INSERT INTO `tbl_tipoevento_reporteinicial`(`idReporteInicial`, `idTipoEvento`) VALUES ($idReporteInicial, $idTipoEvento);
    END !
    DELIMITER ;



    -- =================== CONSULTAR TIPOEVENTO_REPORTEINICIAL ================ --

    DROP PROCEDURE IF EXISTS spConsultarTipoevento_reporteinicial;
    DELIMITER !
    CREATE PROCEDURE spConsultarTipoevento_reporteinicial(IN $idTipoEventoReporteInicial INT)
    BEGIN
    SELECT * FROM `tbl_tipoevento_reporteinicial` WHERE `idTipoEventoReporteInicial` = $idTipoEventoReporteInicial;
    END !
    DELIMITER ;



    -- ================== MODIFICAR TIPOEVENTO_REPORTEINICIAL ================= --

    DROP PROCEDURE IF EXISTS spModificarTipoevento_reporteinicial;
    DELIMITER !
    CREATE PROCEDURE spModificarTipoevento_reporteinicial(IN $idTipoEventoReporteInicial INT, IN $idReporteInicial int(11), IN $idTipoEvento int(11))
    BEGIN
    UPDATE `tbl_tipoevento_reporteinicial` SET `idReporteInicial` = $idReporteInicial, `idTipoEvento` = $idTipoEvento WHERE `idTipoEventoReporteInicial` = $idTipoEventoReporteInicial;
    END !
    DELIMITER ;



    -- ==================== LISTAR TIPOEVENTO_REPORTEINICIAL ================== --

    DROP PROCEDURE IF EXISTS spListarTipoevento_reporteinicial;
    DELIMITER !
    CREATE PROCEDURE spListarTipoevento_reporteinicial()
    BEGIN
    SELECT * FROM `tbl_tipoevento_reporteinicial`;
    END !
    DELIMITER ;





    -- # CRUD tbl_tipoexamenespecializado --


    -- ================== REGISTRAR TIPOEXAMENESPECIALIZADO ================= --

    DROP PROCEDURE IF EXISTS spRegistrarTipoexamenespecializado;
    DELIMITER !
    CREATE PROCEDURE spRegistrarTipoexamenespecializado(IN $descripcion varchar(1000), IN $estadoTabla varchar(45))
    BEGIN
    INSERT INTO `tbl_tipoexamenespecializado`(`descripcion`, `estadoTabla`) VALUES ($descripcion, $estadoTabla);
    END !
    DELIMITER ;



    -- =================== CONSULTAR TIPOEXAMENESPECIALIZADO ================ --

    DROP PROCEDURE IF EXISTS spConsultarTipoexamenespecializado;
    DELIMITER !
    CREATE PROCEDURE spConsultarTipoexamenespecializado(IN $idTipoExamenEspecializado INT)
    BEGIN
    SELECT * FROM `tbl_tipoexamenespecializado` WHERE `idTipoExamenEspecializado` = $idTipoExamenEspecializado;
    END !
    DELIMITER ;



    -- ================== MODIFICAR TIPOEXAMENESPECIALIZADO ================= --

    DROP PROCEDURE IF EXISTS spModificarTipoexamenespecializado;
    DELIMITER !
    CREATE PROCEDURE spModificarTipoexamenespecializado(IN $idTipoExamenEspecializado INT, IN $descripcion varchar(1000))
    BEGIN
    UPDATE `tbl_tipoexamenespecializado` SET `descripcion` = $descripcion WHERE `idTipoExamenEspecializado` = $idTipoExamenEspecializado;
    END !
    DELIMITER ;



    -- ==================== LISTAR TIPOEXAMENESPECIALIZADO ================== --

    DROP PROCEDURE IF EXISTS spListarTipoexamenespecializado;
    DELIMITER !
    CREATE PROCEDURE spListarTipoexamenespecializado()
    BEGIN
    SELECT * FROM `tbl_tipoexamenespecializado`;
    END !
    DELIMITER ;


      -- ================== CAMBIAR ESTADO TIPOEXAMENESPECIALIZADO ================= --

      DROP PROCEDURE IF EXISTS spCambiarEstadoTipoexamenespecializado;
      DELIMITER !
      CREATE PROCEDURE spCambiarEstadoTipoexamenespecializado(IN $idTipoExamenEspecializado INT, IN $estadoTabla varchar(45))
      BEGIN
      UPDATE `tbl_tipoexamenespecializado` SET `estadoTabla` = $estadoTabla WHERE `idTipoExamenEspecializado` = $idTipoExamenEspecializado;
      END !
      DELIMITER ;



    -- # CRUD tbl_tipoexamenfisico --


    -- ================== REGISTRAR TIPOEXAMENFISICO ================= --

    DROP PROCEDURE IF EXISTS spRegistrarTipoexamenfisico;
    DELIMITER !
    CREATE PROCEDURE spRegistrarTipoexamenfisico(IN $descripcionExamenFisico varchar(500), IN $estadoTabla varchar(50))
    BEGIN
    INSERT INTO `tbl_tipoexamenfisico`(`descripcionExamenFisico`, `estadoTabla`) VALUES ($descripcionExamenFisico, $estadoTabla);
    END !
    DELIMITER ;



    -- =================== CONSULTAR TIPOEXAMENFISICO ================ --

    DROP PROCEDURE IF EXISTS spConsultarTipoexamenfisico;
    DELIMITER !
    CREATE PROCEDURE spConsultarTipoexamenfisico(IN $idtipoExamenFisico INT)
    BEGIN
    SELECT * FROM `tbl_tipoexamenfisico` WHERE `idtipoExamenFisico` = $idtipoExamenFisico;
    END !
    DELIMITER ;



    -- ================== MODIFICAR TIPOEXAMENFISICO ================= --

    DROP PROCEDURE IF EXISTS spModificarTipoexamenfisico;
    DELIMITER !
    CREATE PROCEDURE spModificarTipoexamenfisico(IN $idtipoExamenFisico INT, IN $descripcionExamenFisico varchar(500))
    BEGIN
    UPDATE `tbl_tipoexamenfisico` SET `descripcionExamenFisico` = $descripcionExamenFisico WHERE `idtipoExamenFisico` = $idtipoExamenFisico;
    END !
    DELIMITER ;



    -- ==================== LISTAR TIPOEXAMENFISICO ================== --

    DROP PROCEDURE IF EXISTS spListarTipoexamenfisico;
    DELIMITER !
    CREATE PROCEDURE spListarTipoexamenfisico()
    BEGIN
    SELECT * FROM `tbl_tipoexamenfisico`;
    END !
    DELIMITER ;


      -- ================== CAMBIAR ESTADO TIPOEXAMENFISICO ================= --

      DROP PROCEDURE IF EXISTS spCambiarEstadoTipoexamenfisico;
      DELIMITER !
      CREATE PROCEDURE spCambiarEstadoTipoexamenfisico(IN $idtipoExamenFisico INT, IN $estadoTabla varchar(50))
      BEGIN
      UPDATE `tbl_tipoexamenfisico` SET `estadoTabla` = $estadoTabla WHERE `idtipoExamenFisico` = $idtipoExamenFisico;
      END !
      DELIMITER ;



    -- # CRUD tbl_tipokit --


    -- ================== REGISTRAR TIPOKIT ================= --

    DROP PROCEDURE IF EXISTS spRegistrarTipokit;
    DELIMITER !
    CREATE PROCEDURE spRegistrarTipokit(IN $descripcionTipoKit varchar(50), IN $estadoTabla varchar(50))
    BEGIN
    INSERT INTO `tbl_tipokit`(`descripcionTipoKit`, `estadoTabla`) VALUES ($descripcionTipoKit, $estadoTabla);
    END !
    DELIMITER ;



    -- =================== CONSULTAR TIPOKIT ================ --

    DROP PROCEDURE IF EXISTS spConsultarTipokit;
    DELIMITER !
    CREATE PROCEDURE spConsultarTipokit(IN $idTipoKit INT)
    BEGIN
    SELECT * FROM `tbl_tipokit` WHERE `idTipoKit` = $idTipoKit;
    END !
    DELIMITER ;



    -- ================== MODIFICAR TIPOKIT ================= --

    DROP PROCEDURE IF EXISTS spModificarTipokit;
    DELIMITER !
    CREATE PROCEDURE spModificarTipokit(IN $idTipoKit INT, IN $descripcionTipoKit varchar(50))
    BEGIN
    UPDATE `tbl_tipokit` SET `descripcionTipoKit` = $descripcionTipoKit WHERE `idTipoKit` = $idTipoKit;
    END !
    DELIMITER ;



    -- ==================== LISTAR TIPOKIT ================== --

    DROP PROCEDURE IF EXISTS spListarTipokit;
    DELIMITER !
    CREATE PROCEDURE spListarTipokit()
    BEGIN
    SELECT * FROM `tbl_tipokit`;
    END !
    DELIMITER ;


      -- ================== CAMBIAR ESTADO TIPOKIT ================= --

      DROP PROCEDURE IF EXISTS spCambiarEstadoTipokit;
      DELIMITER !
      CREATE PROCEDURE spCambiarEstadoTipokit(IN $idTipoKit INT, IN $estadoTabla varchar(50))
      BEGIN
      UPDATE `tbl_tipokit` SET `estadoTabla` = $estadoTabla WHERE `idTipoKit` = $idTipoKit;
      END !
      DELIMITER ;



    -- # CRUD tbl_tiponovedad --


    -- ================== REGISTRAR TIPONOVEDAD ================= --

    DROP PROCEDURE IF EXISTS spRegistrarTiponovedad;
    DELIMITER !
    CREATE PROCEDURE spRegistrarTiponovedad(IN $descripcionTiponovedad varchar(45), IN $estadoTabla varchar(50))
    BEGIN
    INSERT INTO `tbl_tiponovedad`(`descripcionTiponovedad`, `estadoTabla`) VALUES ($descripcionTiponovedad, $estadoTabla);
    END !
    DELIMITER ;



    -- =================== CONSULTAR TIPONOVEDAD ================ --

    DROP PROCEDURE IF EXISTS spConsultarTiponovedad;
    DELIMITER !
    CREATE PROCEDURE spConsultarTiponovedad(IN $idTipoNovedad INT)
    BEGIN
    SELECT * FROM `tbl_tiponovedad` WHERE `idTipoNovedad` = $idTipoNovedad;
    END !
    DELIMITER ;



    -- ================== MODIFICAR TIPONOVEDAD ================= --

    DROP PROCEDURE IF EXISTS spModificarTiponovedad;
    DELIMITER !
    CREATE PROCEDURE spModificarTiponovedad(IN $idTipoNovedad INT, IN $descripcionTiponovedad varchar(45))
    BEGIN
    UPDATE `tbl_tiponovedad` SET `descripcionTiponovedad` = $descripcionTiponovedad WHERE `idTipoNovedad` = $idTipoNovedad;
    END !
    DELIMITER ;



    -- ==================== LISTAR TIPONOVEDAD ================== --

    DROP PROCEDURE IF EXISTS spListarTiponovedad;
    DELIMITER !
    CREATE PROCEDURE spListarTiponovedad()
    BEGIN
    SELECT * FROM `tbl_tiponovedad`;
    END !
    DELIMITER ;


      -- ================== CAMBIAR ESTADO TIPONOVEDAD ================= --

      DROP PROCEDURE IF EXISTS spCambiarEstadoTiponovedad;
      DELIMITER !
      CREATE PROCEDURE spCambiarEstadoTiponovedad(IN $idTipoNovedad INT, IN $estadoTabla varchar(50))
      BEGIN
      UPDATE `tbl_tiponovedad` SET `estadoTabla` = $estadoTabla WHERE `idTipoNovedad` = $idTipoNovedad;
      END !
      DELIMITER ;



    -- # CRUD tbl_tipoorigenatencion --


    -- ================== REGISTRAR TIPOORIGENATENCION ================= --

    DROP PROCEDURE IF EXISTS spRegistrarTipoorigenatencion;
    DELIMITER !
    CREATE PROCEDURE spRegistrarTipoorigenatencion(IN $descripcionorigenAtencion varchar(100), IN $estadoTabla varchar(50))
    BEGIN
    INSERT INTO `tbl_tipoorigenatencion`(`descripcionorigenAtencion`, `estadoTabla`) VALUES ($descripcionorigenAtencion, $estadoTabla);
    END !
    DELIMITER ;



    -- =================== CONSULTAR TIPOORIGENATENCION ================ --

    DROP PROCEDURE IF EXISTS spConsultarTipoorigenatencion;
    DELIMITER !
    CREATE PROCEDURE spConsultarTipoorigenatencion(IN $idTipoOrigenAtencion INT)
    BEGIN
    SELECT * FROM `tbl_tipoorigenatencion` WHERE `idTipoOrigenAtencion` = $idTipoOrigenAtencion;
    END !
    DELIMITER ;



    -- ================== MODIFICAR TIPOORIGENATENCION ================= --

    DROP PROCEDURE IF EXISTS spModificarTipoorigenatencion;
    DELIMITER !
    CREATE PROCEDURE spModificarTipoorigenatencion(IN $idTipoOrigenAtencion INT, IN $descripcionorigenAtencion varchar(100))
    BEGIN
    UPDATE `tbl_tipoorigenatencion` SET `descripcionorigenAtencion` = $descripcionorigenAtencion WHERE `idTipoOrigenAtencion` = $idTipoOrigenAtencion;
    END !
    DELIMITER ;



    -- ==================== LISTAR TIPOORIGENATENCION ================== --

    DROP PROCEDURE IF EXISTS spListarTipoorigenatencion;
    DELIMITER !
    CREATE PROCEDURE spListarTipoorigenatencion()
    BEGIN
    SELECT * FROM `tbl_tipoorigenatencion`;
    END !
    DELIMITER ;


      -- ================== CAMBIAR ESTADO TIPOORIGENATENCION ================= --

      DROP PROCEDURE IF EXISTS spCambiarEstadoTipoorigenatencion;
      DELIMITER !
      CREATE PROCEDURE spCambiarEstadoTipoorigenatencion(IN $idTipoOrigenAtencion INT, IN $estadoTabla varchar(50))
      BEGIN
      UPDATE `tbl_tipoorigenatencion` SET `estadoTabla` = $estadoTabla WHERE `idTipoOrigenAtencion` = $idTipoOrigenAtencion;
      END !
      DELIMITER ;



    -- # CRUD tbl_tipotratamiento --


    -- ================== REGISTRAR TIPOTRATAMIENTO ================= --

    DROP PROCEDURE IF EXISTS spRegistrarTipotratamiento;
    DELIMITER !
    CREATE PROCEDURE spRegistrarTipotratamiento(IN $Descripcion varchar(1000), IN $categoriaTratamientoAph varchar(45), IN $categoriaItemTratamiento varchar(45), IN $estadoTabla varchar(50))
    BEGIN
    INSERT INTO `tbl_tipotratamiento`(`Descripcion`, `categoriaTratamientoAph`, `categoriaItemTratamiento`, `estadoTabla`) VALUES ($Descripcion, $categoriaTratamientoAph, $categoriaItemTratamiento, $estadoTabla);
    END !
    DELIMITER ;



    -- =================== CONSULTAR TIPOTRATAMIENTO ================ --

    DROP PROCEDURE IF EXISTS spConsultarTipotratamiento;
    DELIMITER !
    CREATE PROCEDURE spConsultarTipotratamiento(IN $idTipoTratamiento INT)
    BEGIN
    SELECT * FROM `tbl_tipotratamiento` WHERE `idTipoTratamiento` = $idTipoTratamiento;
    END !
    DELIMITER ;



    -- ================== MODIFICAR TIPOTRATAMIENTO ================= --

    DROP PROCEDURE IF EXISTS spModificarTipotratamiento;
    DELIMITER !
    CREATE PROCEDURE spModificarTipotratamiento(IN $idTipoTratamiento INT, IN $Descripcion varchar(1000), IN $categoriaTratamientoAph varchar(45), IN $categoriaItemTratamiento varchar(45))
    BEGIN
    UPDATE `tbl_tipotratamiento` SET `Descripcion` = $Descripcion, `categoriaTratamientoAph` = $categoriaTratamientoAph, `categoriaItemTratamiento` = $categoriaItemTratamiento WHERE `idTipoTratamiento` = $idTipoTratamiento;
    END !
    DELIMITER ;



    -- ==================== LISTAR TIPOTRATAMIENTO ================== --

    DROP PROCEDURE IF EXISTS spListarTipotratamiento;
    DELIMITER !
    CREATE PROCEDURE spListarTipotratamiento()
    BEGIN
    SELECT * FROM `tbl_tipotratamiento`;
    END !
    DELIMITER ;


      -- ================== CAMBIAR ESTADO TIPOTRATAMIENTO ================= --

      DROP PROCEDURE IF EXISTS spCambiarEstadoTipotratamiento;
      DELIMITER !
      CREATE PROCEDURE spCambiarEstadoTipotratamiento(IN $idTipoTratamiento INT, IN $estadoTabla varchar(50))
      BEGIN
      UPDATE `tbl_tipotratamiento` SET `estadoTabla` = $estadoTabla WHERE `idTipoTratamiento` = $idTipoTratamiento;
      END !
      DELIMITER ;



    -- # CRUD tbl_tipozona --


    -- ================== REGISTRAR TIPOZONA ================= --

    DROP PROCEDURE IF EXISTS spRegistrarTipozona;
    DELIMITER !
    CREATE PROCEDURE spRegistrarTipozona(IN $descripcionTipozona varchar(100), IN $estadoTabla varchar(50))
    BEGIN
    INSERT INTO `tbl_tipozona`(`descripcionTipozona`, `estadoTabla`) VALUES ($descripcionTipozona, $estadoTabla);
    END !
    DELIMITER ;



    -- =================== CONSULTAR TIPOZONA ================ --

    DROP PROCEDURE IF EXISTS spConsultarTipozona;
    DELIMITER !
    CREATE PROCEDURE spConsultarTipozona(IN $idTipoZona INT)
    BEGIN
    SELECT * FROM `tbl_tipozona` WHERE `idTipoZona` = $idTipoZona;
    END !
    DELIMITER ;



    -- ================== MODIFICAR TIPOZONA ================= --

    DROP PROCEDURE IF EXISTS spModificarTipozona;
    DELIMITER !
    CREATE PROCEDURE spModificarTipozona(IN $idTipoZona INT, IN $descripcionTipozona varchar(100))
    BEGIN
    UPDATE `tbl_tipozona` SET `descripcionTipozona` = $descripcionTipozona WHERE `idTipoZona` = $idTipoZona;
    END !
    DELIMITER ;



    -- ==================== LISTAR TIPOZONA ================== --

    DROP PROCEDURE IF EXISTS spListarTipozona;
    DELIMITER !
    CREATE PROCEDURE spListarTipozona()
    BEGIN
    SELECT * FROM `tbl_tipozona`;
    END !
    DELIMITER ;


      -- ================== CAMBIAR ESTADO TIPOZONA ================= --

      DROP PROCEDURE IF EXISTS spCambiarEstadoTipozona;
      DELIMITER !
      CREATE PROCEDURE spCambiarEstadoTipozona(IN $idTipoZona INT, IN $estadoTabla varchar(50))
      BEGIN
      UPDATE `tbl_tipozona` SET `estadoTabla` = $estadoTabla WHERE `idTipoZona` = $idTipoZona;
      END !
      DELIMITER ;



    -- # CRUD tbl_tratamientoaph --


    -- ================== REGISTRAR TRATAMIENTOAPH ================= --

    DROP PROCEDURE IF EXISTS spRegistrarTratamientoaph;
    DELIMITER !
    CREATE PROCEDURE spRegistrarTratamientoaph(IN $idReporteAPH int(11), IN $valor varchar(45), IN $idTipoTratamiento int(11))
    BEGIN
    INSERT INTO `tbl_tratamientoaph`(`idReporteAPH`, `valor`, `idTipoTratamiento`) VALUES ($idReporteAPH, $valor, $idTipoTratamiento);
    END !
    DELIMITER ;



    -- =================== CONSULTAR TRATAMIENTOAPH ================ --

    DROP PROCEDURE IF EXISTS spConsultarTratamientoaph;
    DELIMITER !
    CREATE PROCEDURE spConsultarTratamientoaph(IN $idtratamiento INT)
    BEGIN
    SELECT * FROM `tbl_tratamientoaph` WHERE `idtratamiento` = $idtratamiento;
    END !
    DELIMITER ;



    -- ================== MODIFICAR TRATAMIENTOAPH ================= --

    DROP PROCEDURE IF EXISTS spModificarTratamientoaph;
    DELIMITER !
    CREATE PROCEDURE spModificarTratamientoaph(IN $idtratamiento INT, IN $idReporteAPH int(11), IN $valor varchar(45), IN $idTipoTratamiento int(11))
    BEGIN
    UPDATE `tbl_tratamientoaph` SET `idReporteAPH` = $idReporteAPH, `valor` = $valor, `idTipoTratamiento` = $idTipoTratamiento WHERE `idtratamiento` = $idtratamiento;
    END !
    DELIMITER ;



    -- ==================== LISTAR TRATAMIENTOAPH ================== --

    DROP PROCEDURE IF EXISTS spListarTratamientoaph;
    DELIMITER !
    CREATE PROCEDURE spListarTratamientoaph()
    BEGIN
    SELECT * FROM `tbl_tratamientoaph`;
    END !
    DELIMITER ;





    -- # CRUD tbl_tratamientodmc --


    -- ================== REGISTRAR TRATAMIENTODMC ================= --

    DROP PROCEDURE IF EXISTS spRegistrarTratamientodmc;
    DELIMITER !
    CREATE PROCEDURE spRegistrarTratamientodmc(IN $descripcionTratamiento text, IN $fechaTratamiento date, IN $dosisTratamiento text, IN $idTipoTratamiento int(11), IN $idHistoriaClinica int(11))
    BEGIN
    INSERT INTO `tbl_tratamientodmc`(`descripcionTratamiento`, `fechaTratamiento`, `dosisTratamiento`, `idTipoTratamiento`, `idHistoriaClinica`) VALUES ($descripcionTratamiento, $fechaTratamiento, $dosisTratamiento, $idTipoTratamiento, $idHistoriaClinica);
    END !
    DELIMITER ;



    -- =================== CONSULTAR TRATAMIENTODMC ================ --

    DROP PROCEDURE IF EXISTS spConsultarTratamientodmc;
    DELIMITER !
    CREATE PROCEDURE spConsultarTratamientodmc(IN $idTratamiento INT)
    BEGIN
    SELECT * FROM `tbl_tratamientodmc` WHERE `idTratamiento` = $idTratamiento;
    END !
    DELIMITER ;



    -- ================== MODIFICAR TRATAMIENTODMC ================= --

    DROP PROCEDURE IF EXISTS spModificarTratamientodmc;
    DELIMITER !
    CREATE PROCEDURE spModificarTratamientodmc(IN $idTratamiento INT, IN $descripcionTratamiento text, IN $fechaTratamiento date, IN $dosisTratamiento text, IN $idTipoTratamiento int(11), IN $idHistoriaClinica int(11))
    BEGIN
    UPDATE `tbl_tratamientodmc` SET `descripcionTratamiento` = $descripcionTratamiento, `fechaTratamiento` = $fechaTratamiento, `dosisTratamiento` = $dosisTratamiento, `idTipoTratamiento` = $idTipoTratamiento, `idHistoriaClinica` = $idHistoriaClinica WHERE `idTratamiento` = $idTratamiento;
    END !
    DELIMITER ;



    -- ==================== LISTAR TRATAMIENTODMC ================== --

    DROP PROCEDURE IF EXISTS spListarTratamientodmc;
    DELIMITER !
    CREATE PROCEDURE spListarTratamientodmc()
    BEGIN
    SELECT * FROM `tbl_tratamientodmc`;
    END !
    DELIMITER ;





    -- # CRUD tbl_tratamientodmcrecurso --


    -- ================== REGISTRAR TRATAMIENTODMCRECURSO ================= --

    DROP PROCEDURE IF EXISTS spRegistrarTratamientodmcrecurso;
    DELIMITER !
    CREATE PROCEDURE spRegistrarTratamientodmcrecurso(IN $idTratamientoDmc int(11), IN $idrecurso int(11))
    BEGIN
    INSERT INTO `tbl_tratamientodmcrecurso`(`idTratamientoDmc`, `idrecurso`) VALUES ($idTratamientoDmc, $idrecurso);
    END !
    DELIMITER ;



    -- =================== CONSULTAR TRATAMIENTODMCRECURSO ================ --

    DROP PROCEDURE IF EXISTS spConsultarTratamientodmcrecurso;
    DELIMITER !
    CREATE PROCEDURE spConsultarTratamientodmcrecurso(IN $TratamientoDmcRecurso INT)
    BEGIN
    SELECT * FROM `tbl_tratamientodmcrecurso` WHERE `TratamientoDmcRecurso` = $TratamientoDmcRecurso;
    END !
    DELIMITER ;



    -- ================== MODIFICAR TRATAMIENTODMCRECURSO ================= --

    DROP PROCEDURE IF EXISTS spModificarTratamientodmcrecurso;
    DELIMITER !
    CREATE PROCEDURE spModificarTratamientodmcrecurso(IN $TratamientoDmcRecurso INT, IN $idTratamientoDmc int(11), IN $idrecurso int(11))
    BEGIN
    UPDATE `tbl_tratamientodmcrecurso` SET `idTratamientoDmc` = $idTratamientoDmc, `idrecurso` = $idrecurso WHERE `TratamientoDmcRecurso` = $TratamientoDmcRecurso;
    END !
    DELIMITER ;



    -- ==================== LISTAR TRATAMIENTODMCRECURSO ================== --

    DROP PROCEDURE IF EXISTS spListarTratamientodmcrecurso;
    DELIMITER !
    CREATE PROCEDURE spListarTratamientodmcrecurso()
    BEGIN
    SELECT * FROM `tbl_tratamientodmcrecurso`;
    END !
    DELIMITER ;





    -- # CRUD tbl_triage --


    -- ================== REGISTRAR TRIAGE ================= --

    DROP PROCEDURE IF EXISTS spRegistrarTriage;
    DELIMITER !
    CREATE PROCEDURE spRegistrarTriage(IN $descripcionTriage varchar(45), IN $estadoTabla varchar(50))
    BEGIN
    INSERT INTO `tbl_triage`(`descripcionTriage`, `estadoTabla`) VALUES ($descripcionTriage, $estadoTabla);
    END !
    DELIMITER ;



    -- =================== CONSULTAR TRIAGE ================ --

    DROP PROCEDURE IF EXISTS spConsultarTriage;
    DELIMITER !
    CREATE PROCEDURE spConsultarTriage(IN $idTriage INT)
    BEGIN
    SELECT * FROM `tbl_triage` WHERE `idTriage` = $idTriage;
    END !
    DELIMITER ;



    -- ================== MODIFICAR TRIAGE ================= --

    DROP PROCEDURE IF EXISTS spModificarTriage;
    DELIMITER !
    CREATE PROCEDURE spModificarTriage(IN $idTriage INT, IN $descripcionTriage varchar(45))
    BEGIN
    UPDATE `tbl_triage` SET `descripcionTriage` = $descripcionTriage WHERE `idTriage` = $idTriage;
    END !
    DELIMITER ;



    -- ==================== LISTAR TRIAGE ================== --

    DROP PROCEDURE IF EXISTS spListarTriage;
    DELIMITER !
    CREATE PROCEDURE spListarTriage()
    BEGIN
    SELECT * FROM `tbl_triage`;
    END !
    DELIMITER ;


      -- ================== CAMBIAR ESTADO TRIAGE ================= --

      DROP PROCEDURE IF EXISTS spCambiarEstadoTriage;
      DELIMITER !
      CREATE PROCEDURE spCambiarEstadoTriage(IN $idTriage INT, IN $estadoTabla varchar(50))
      BEGIN
      UPDATE `tbl_triage` SET `estadoTabla` = $estadoTabla WHERE `idTriage` = $idTriage;
      END !
      DELIMITER ;



    -- # CRUD tbl_turno --


    -- ================== REGISTRAR TURNO ================= --

    DROP PROCEDURE IF EXISTS spRegistrarTurno;
    DELIMITER !
    CREATE PROCEDURE spRegistrarTurno(IN $horaInicioTurno time, IN $horaFinalTurno time)
    BEGIN
    INSERT INTO `tbl_turno`(`horaInicioTurno`, `horaFinalTurno`) VALUES ($horaInicioTurno, $horaFinalTurno);
    END !
    DELIMITER ;



    -- =================== CONSULTAR TURNO ================ --

    DROP PROCEDURE IF EXISTS spConsultarTurno;
    DELIMITER !
    CREATE PROCEDURE spConsultarTurno(IN $idTurno INT)
    BEGIN
    SELECT * FROM `tbl_turno` WHERE `idTurno` = $idTurno;
    END !
    DELIMITER ;



    -- ================== MODIFICAR TURNO ================= --

    DROP PROCEDURE IF EXISTS spModificarTurno;
    DELIMITER !
    CREATE PROCEDURE spModificarTurno(IN $idTurno INT, IN $horaInicioTurno time, IN $horaFinalTurno time)
    BEGIN
    UPDATE `tbl_turno` SET `horaInicioTurno` = $horaInicioTurno, `horaFinalTurno` = $horaFinalTurno WHERE `idTurno` = $idTurno;
    END !
    DELIMITER ;



    -- ==================== LISTAR TURNO ================== --

    DROP PROCEDURE IF EXISTS spListarTurno;
    DELIMITER !
    CREATE PROCEDURE spListarTurno()
    BEGIN
    SELECT * FROM `tbl_turno`;
    END !
    DELIMITER ;





    -- # CRUD tbl_turnoprogramacion --


    -- ================== REGISTRAR TURNOPROGRAMACION ================= --

    DROP PROCEDURE IF EXISTS spRegistrarTurnoprogramacion;
    DELIMITER !
    CREATE PROCEDURE spRegistrarTurnoprogramacion(IN $idTurno int(11), IN $idProgramacion int(11), IN $idPersona int(11), IN $estadoTablaProgramacion varchar(45))
    BEGIN
    INSERT INTO `tbl_turnoprogramacion`(`idTurno`, `idProgramacion`, `idPersona`, `estadoTablaProgramacion`) VALUES ($idTurno, $idProgramacion, $idPersona, $estadoTablaProgramacion);
    END !
    DELIMITER ;



    -- =================== CONSULTAR TURNOPROGRAMACION ================ --

    DROP PROCEDURE IF EXISTS spConsultarTurnoprogramacion;
    DELIMITER !
    CREATE PROCEDURE spConsultarTurnoprogramacion(IN $idTurnoProgramacion INT)
    BEGIN
    SELECT * FROM `tbl_turnoprogramacion` WHERE `idTurnoProgramacion` = $idTurnoProgramacion;
    END !
    DELIMITER ;



    -- ================== MODIFICAR TURNOPROGRAMACION ================= --

    DROP PROCEDURE IF EXISTS spModificarTurnoprogramacion;
    DELIMITER !
    CREATE PROCEDURE spModificarTurnoprogramacion(IN $idTurnoProgramacion INT, IN $idTurno int(11), IN $idProgramacion int(11), IN $idPersona int(11))
    BEGIN
    UPDATE `tbl_turnoprogramacion` SET `idTurno` = $idTurno, `idProgramacion` = $idProgramacion, `idPersona` = $idPersona WHERE `idTurnoProgramacion` = $idTurnoProgramacion;
    END !
    DELIMITER ;



    -- ==================== LISTAR TURNOPROGRAMACION ================== --

    DROP PROCEDURE IF EXISTS spListarTurnoprogramacion;
    DELIMITER !
    CREATE PROCEDURE spListarTurnoprogramacion()
    BEGIN
    SELECT * FROM `tbl_turnoprogramacion`;
    END !
    DELIMITER ;


      -- ================== CAMBIAR ESTADO TURNOPROGRAMACION ================= --

      DROP PROCEDURE IF EXISTS spCambiarEstadoTurnoprogramacion;
      DELIMITER !
      CREATE PROCEDURE spCambiarEstadoTurnoprogramacion(IN $idTurnoProgramacion INT, IN $estadoTablaProgramacion varchar(45))
      BEGIN
      UPDATE `tbl_turnoprogramacion` SET `estadoTablaProgramacion` = $estadoTablaProgramacion WHERE `idTurnoProgramacion` = $idTurnoProgramacion;
      END !
      DELIMITER ;



    -- # CRUD tbl_valoracion --


    -- ================== REGISTRAR VALORACION ================= --

    DROP PROCEDURE IF EXISTS spRegistrarValoracion;
    DELIMITER !
    CREATE PROCEDURE spRegistrarValoracion(IN $descripcionValoracion varchar(45))
    BEGIN
    INSERT INTO `tbl_valoracion`(`descripcionValoracion`) VALUES ($descripcionValoracion);
    END !
    DELIMITER ;



    -- =================== CONSULTAR VALORACION ================ --

    DROP PROCEDURE IF EXISTS spConsultarValoracion;
    DELIMITER !
    CREATE PROCEDURE spConsultarValoracion(IN $idValoracion INT)
    BEGIN
    SELECT * FROM `tbl_valoracion` WHERE `idValoracion` = $idValoracion;
    END !
    DELIMITER ;



    -- ================== MODIFICAR VALORACION ================= --

    DROP PROCEDURE IF EXISTS spModificarValoracion;
    DELIMITER !
    CREATE PROCEDURE spModificarValoracion(IN $idValoracion INT, IN $descripcionValoracion varchar(45))
    BEGIN
    UPDATE `tbl_valoracion` SET `descripcionValoracion` = $descripcionValoracion WHERE `idValoracion` = $idValoracion;
    END !
    DELIMITER ;



    -- ==================== LISTAR VALORACION ================== --

    DROP PROCEDURE IF EXISTS spListarValoracion;
    DELIMITER !
    CREATE PROCEDURE spListarValoracion()
    BEGIN
    SELECT * FROM `tbl_valoracion`;
    END !
    DELIMITER ;





    -- # CRUD tbl_viacomunicacioncontrolmedico --


    -- ================== REGISTRAR VIACOMUNICACIONCONTROLMEDICO ================= --

    DROP PROCEDURE IF EXISTS spRegistrarViacomunicacioncontrolmedico;
    DELIMITER !
    CREATE PROCEDURE spRegistrarViacomunicacioncontrolmedico(IN $idReporteAPH int(11), IN $viaComunicacion varchar(45))
    BEGIN
    INSERT INTO `tbl_viacomunicacioncontrolmedico`(`idReporteAPH`, `viaComunicacion`) VALUES ($idReporteAPH, $viaComunicacion);
    END !
    DELIMITER ;



    -- =================== CONSULTAR VIACOMUNICACIONCONTROLMEDICO ================ --

    DROP PROCEDURE IF EXISTS spConsultarViacomunicacioncontrolmedico;
    DELIMITER !
    CREATE PROCEDURE spConsultarViacomunicacioncontrolmedico(IN $idViaComunicacionControlMedico INT)
    BEGIN
    SELECT * FROM `tbl_viacomunicacioncontrolmedico` WHERE `idViaComunicacionControlMedico` = $idViaComunicacionControlMedico;
    END !
    DELIMITER ;



    -- ================== MODIFICAR VIACOMUNICACIONCONTROLMEDICO ================= --

    DROP PROCEDURE IF EXISTS spModificarViacomunicacioncontrolmedico;
    DELIMITER !
    CREATE PROCEDURE spModificarViacomunicacioncontrolmedico(IN $idViaComunicacionControlMedico INT, IN $idReporteAPH int(11), IN $viaComunicacion varchar(45))
    BEGIN
    UPDATE `tbl_viacomunicacioncontrolmedico` SET `idReporteAPH` = $idReporteAPH, `viaComunicacion` = $viaComunicacion WHERE `idViaComunicacionControlMedico` = $idViaComunicacionControlMedico;
    END !
    DELIMITER ;



    -- ==================== LISTAR VIACOMUNICACIONCONTROLMEDICO ================== --

    DROP PROCEDURE IF EXISTS spListarViacomunicacioncontrolmedico;
    DELIMITER !
    CREATE PROCEDURE spListarViacomunicacioncontrolmedico()
    BEGIN
    SELECT * FROM `tbl_viacomunicacioncontrolmedico`;
    END !
    DELIMITER ;





    -- # CRUD tbl_vista --


    -- ================== REGISTRAR VISTA ================= --

    DROP PROCEDURE IF EXISTS spRegistrarVista;
    DELIMITER !
    CREATE PROCEDURE spRegistrarVista(IN $descripcionVista varchar(70), IN $urlVista varchar(250), IN $iconoVista varchar(45), IN $estado varchar(45))
    BEGIN
    INSERT INTO `tbl_vista`(`descripcionVista`, `urlVista`, `iconoVista`, `estado`) VALUES ($descripcionVista, $urlVista, $iconoVista, $estado);
    END !
    DELIMITER ;



    -- =================== CONSULTAR VISTA ================ --

    DROP PROCEDURE IF EXISTS spConsultarVista;
    DELIMITER !
    CREATE PROCEDURE spConsultarVista(IN $idVista INT)
    BEGIN
    SELECT * FROM `tbl_vista` WHERE `idVista` = $idVista;
    END !
    DELIMITER ;



    -- ================== MODIFICAR VISTA ================= --

    DROP PROCEDURE IF EXISTS spModificarVista;
    DELIMITER !
    CREATE PROCEDURE spModificarVista(IN $idVista INT, IN $descripcionVista varchar(70), IN $urlVista varchar(250), IN $iconoVista varchar(45), IN $estado varchar(45))
    BEGIN
    UPDATE `tbl_vista` SET `descripcionVista` = $descripcionVista, `urlVista` = $urlVista, `iconoVista` = $iconoVista, `estado` = $estado WHERE `idVista` = $idVista;
    END !
    DELIMITER ;



    -- ==================== LISTAR VISTA ================== --

    DROP PROCEDURE IF EXISTS spListarVista;
    DELIMITER !
    CREATE PROCEDURE spListarVista()
    BEGIN
    SELECT * FROM `tbl_vista`;
    END !
    DELIMITER ;





    -- # CRUD tbl_zona --


    -- ================== REGISTRAR ZONA ================= --

    DROP PROCEDURE IF EXISTS spRegistrarZona;
    DELIMITER !
    CREATE PROCEDURE spRegistrarZona(IN $descripcionZona varchar(45), IN $idTipoZona int(11), IN $estadoTabla varchar(50))
    BEGIN
    INSERT INTO `tbl_zona`(`descripcionZona`, `idTipoZona`, `estadoTabla`) VALUES ($descripcionZona, $idTipoZona, $estadoTabla);
    END !
    DELIMITER ;



    -- =================== CONSULTAR ZONA ================ --

    DROP PROCEDURE IF EXISTS spConsultarZona;
    DELIMITER !
    CREATE PROCEDURE spConsultarZona(IN $idZona INT)
    BEGIN
    SELECT * FROM `tbl_zona` WHERE `idZona` = $idZona;
    END !
    DELIMITER ;



    -- ================== MODIFICAR ZONA ================= --

    DROP PROCEDURE IF EXISTS spModificarZona;
    DELIMITER !
    CREATE PROCEDURE spModificarZona(IN $idZona INT, IN $descripcionZona varchar(45), IN $idTipoZona int(11))
    BEGIN
    UPDATE `tbl_zona` SET `descripcionZona` = $descripcionZona, `idTipoZona` = $idTipoZona WHERE `idZona` = $idZona;
    END !
    DELIMITER ;



    -- ==================== LISTAR ZONA ================== --

    DROP PROCEDURE IF EXISTS spListarZona;
    DELIMITER !
    CREATE PROCEDURE spListarZona()
    BEGIN
    SELECT * FROM `tbl_zona`;
    END !
    DELIMITER ;


      -- ================== CAMBIAR ESTADO ZONA ================= --

      DROP PROCEDURE IF EXISTS spCambiarEstadoZona;
      DELIMITER !
      CREATE PROCEDURE spCambiarEstadoZona(IN $idZona INT, IN $estadoTabla varchar(50))
      BEGIN
      UPDATE `tbl_zona` SET `estadoTabla` = $estadoTabla WHERE `idZona` = $idZona;
      END !
      DELIMITER ;

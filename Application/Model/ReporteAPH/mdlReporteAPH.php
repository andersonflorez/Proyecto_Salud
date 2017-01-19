<?php

/**
* Modelo ModelNombreModelo:
* Escribe aqui una descripcion de lo que hace
* este modelo. Copia esta estructura básica y
* utilízala en todos los modelos que necesites
* crear. Todos los modelos deben tener esta
* estructura.
*/
class MdlReporteAPH implements iModel {

  private static $_INSTANCIA; // Instancia única de esta clase
  private $_CONEXION;         // Variable de conexión PDO
  private $_nombreTabla;
  private $_idExamenFisico;
  private $_idDespacho;
  private $_idPersonalRecibe;
  private $_idTriage;
  private $_idTipoAseguramiento;
  private $_idCertificadoAtencion;
  private $_fechaFinalizacion;
  private $_fechaArriboEscena;
  private $_fechaArriboIps;
  private $_horaUltimaIngesta;
  private $_idAfectado;
  private $_placaVehiculo;
  private $_numeroPoliza;
  private $_codigoAseguradora;
  private $_descripcionTratamientoBasico;
  private $_descripcionTratamientoAvanzado;
  private $_evaluacionResultado;
  private $_institucionReceptora;
  private $_situacionEntrega;
  private $_presionArterial;
  private $_pulso;
  private $_respiracion;
  private $_estado;
  private $_complicaciones;
  private $_idPaciente;
  private $_TAPHPresente;
  private $_TPAPHPresente;
  private $_otroPersonalPresente;
  private $_nombreOtroPersonal;
  private $_protocolo;
  private $_idReporteAph;
  private $_viaComunicacion;
  private $_idAsignacionPersonal;
  private $_descripcionPiel;
  private $_idAcompanante;
  private $_descripcionCuidado;
  private $_nombreTestigo;
  private $_identificacionTestigo;
  private $_idParamedicoAtiende;
  private $_idReporteInicial;
  private $_descripcionNovedad;
  private $_estadoNovedad;
  private $_numeroAfectados;
  # Atributos de la clase:
  // ...

  # Constructor:
  private function __construct($_CON){
    try {
      $this->_CONEXION = $_CON;
    } catch (PDOException $e) {
      exit('Error al intentar conectar con la Base de Datos :' + $e);
    }
  }

  /*
  * Función getInstance():
  * Devuelve la única instancia de esta clase.
  * Recibe la conexión PDO como parámetro.
  */
  public static function getInstance($_CONEXION) {
    if (!self::$_INSTANCIA instanceof self) {
      self::$_INSTANCIA = new self($_CONEXION);
    }
    return self::$_INSTANCIA;
  }

  function __GET($atributo){
    return $this->$atributo;
  }
  function __SET($atributo,$valor){
    $this->$atributo = $valor;
  }

  function TraerProximoIDReporteAPH(){
    try {
      $tabla = $this->__GET("_nombreTabla");
      $sql = "CALL spTraerProximoIdReporteAPH(?)";
      $query = $this->_CONEXION->prepare($sql);
      $query->bindParam(1, $tabla);
      if ($query->execute()) {
        return $query->fetch();
      }else{
        return null;
      }
    } catch (Exception $e) {
      return null;
    }

  }
  function RegistrarHistoriaClinicaAPH(){
    try {
      $idExamenFisico = $this->__GET("_idExamenFisico");
      $idDespacho = $this->__GET("_idDespacho");
      $idAsignacionPersonal = $this->__GET("_idAsignacionPersonal");
      $idPersonalRecibe = $this->__GET("_idPersonalRecibe");
      $idtriage = $this->__GET("_idTriage");
      $idTipoAseguramiento = $this->__GET("_idTipoAseguramiento");
      $idCertificadoAtencion = $this->__GET("_idCertificadoAtencion");
      $HoraFinalizacion = $this->__GET("_fechaFinalizacion");
      $HoraArriboEscena = $this->__GET("_fechaArriboEscena");
      $HoraArriboIps = $this->__GET("_fechaArriboIps");
      $horaUltimaIngesta = $this->__GET("_horaUltimaIngesta");
      $idAfectado = $this->__GET("_idAfectado");
      $placa = $this->__GET("_placaVehiculo");
      $poliza = $this->__GET("_poliza");
      $codigoAseguradora = $this->__GET("_codigoAseguradora");
      $tratamientoBasico = $this->__GET("_descripcionTratamientoBasico");
      $tratamientoAvanzado = $this->__GET("_descripcionTratamientoAvanzado");
      $evaluacionResultado = $this->__GET("_evaluacionResultado");
      $institucionReceptora = $this->__GET("_institucionReceptora");
      $situacionEntrega = $this->__GET("_situacionEntrega");
      $presionArterial = $this->__GET("_presionArterial");
      $pulso = $this->__GET("_pulso");
      $respiracion = $this->__GET("_respiracion");
      $estado = $this->__GET("_estado");
      $complicaciones = $this->__GET("_complicaciones");
      $idPaciente = $this->__GET("_idPaciente");
      $TAPHPresente = $this->__GET("_TAPHPresente");
      $TPAPHPresente = $this->__GET("_TPAPHPresente");
      $otroPersonalPresente = $this->__GET("_otroPersonalPresente");
      $nombreOtroPersonal = $this->__GET("_nombreOtroPersonal");
      $protocolo = $this->__GET("_protocolo");
      $idParamedicoAtiende = $this->__GET("_idParamedicoAtiende");
      $idAcompanante = $this->__GET("_idAcompanante");
      $sql = "CALL spRegistrarReporteaph(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
      $query = $this->_CONEXION->prepare($sql);
      $query->bindParam(1,$idExamenFisico,PDO::PARAM_STR);
      $query->bindParam(2,$idDespacho,PDO::PARAM_STR);
      $query->bindParam(3,$idAsignacionPersonal,PDO::PARAM_STR);
      $query->bindParam(4,$idPersonalRecibe,PDO::PARAM_STR);
      $query->bindParam(5,$idtriage,PDO::PARAM_STR);
      $query->bindParam(6,$idTipoAseguramiento,PDO::PARAM_STR);
      $query->bindParam(7,$idCertificadoAtencion,PDO::PARAM_STR);
      $query->bindParam(8,$HoraFinalizacion,PDO::PARAM_STR);
      $query->bindParam(9,$HoraArriboEscena,PDO::PARAM_STR);
      $query->bindParam(10,$HoraArriboIps,PDO::PARAM_STR);
      $query->bindParam(11,$horaUltimaIngesta,PDO::PARAM_STR);
      $query->bindParam(12,$idAfectado,PDO::PARAM_STR);
      $query->bindParam(13,$placa,PDO::PARAM_STR);
      $query->bindParam(14,$codigoAseguradora,PDO::PARAM_STR);
      $query->bindParam(15,$poliza,PDO::PARAM_STR);
      $query->bindParam(16,$tratamientoBasico,PDO::PARAM_STR);
      $query->bindParam(17,$tratamientoAvanzado,PDO::PARAM_STR);
      $query->bindParam(18,$evaluacionResultado,PDO::PARAM_STR);
      $query->bindParam(19,$institucionReceptora,PDO::PARAM_STR);
      $query->bindParam(20,$situacionEntrega,PDO::PARAM_STR);
      $query->bindParam(21,$presionArterial,PDO::PARAM_STR);
      $query->bindParam(22,$pulso,PDO::PARAM_STR);
      $query->bindParam(23,$respiracion,PDO::PARAM_STR);
      $query->bindParam(24,$estado,PDO::PARAM_STR);
      $query->bindParam(25,$complicaciones,PDO::PARAM_STR);
      $query->bindParam(26,$idPaciente,PDO::PARAM_STR);
      $query->bindParam(27,$idAcompanante,PDO::PARAM_STR);
      $query->bindParam(28,$TAPHPresente,PDO::PARAM_STR);
      $query->bindParam(29,$TPAPHPresente,PDO::PARAM_STR);
      $query->bindParam(30,$otroPersonalPresente,PDO::PARAM_STR);
      $query->bindParam(31,$nombreOtroPersonal,PDO::PARAM_STR);
      $query->bindParam(32,$protocolo,PDO::PARAM_STR);
      $query->bindParam(33,$idParamedicoAtiende,PDO::PARAM_STR);
      if ($query->execute()) {
        return $query->fetch();
      }else{
        return null;
      }

    } catch (Exception $e) {
      return null;
    }

  }
  function RegistrarViaComunicacion(){
    try {
      $idReporteAPH = $this->__GET("_reporteAph");
      $viaCom = $this->__GET("_viaComunicacion");
      $sql = "CALL spRegistrarViacomunicacioncontrolmedico(?,?)";
      $query = $this->_CONEXION->prepare($sql);
      $query->bindParam(1, $idReporteAPH, PDO::PARAM_STR);
      $query->bindParam(2, $viaCom, PDO::PARAM_STR);
      if ($query->execute()) {
        return true;
      }else{
        return false;
      }
    } catch (Exception $e) {
      return false;
    }

  }
  function RegistrarPiel(){
    try {
      $descripcionPiel = $this->__GET("_descripcionPiel");
      $idExamenF = $this->__GET("_idExamenFisico");
      $sql = "CALL spRegistrarPiel(?,?)";
      $query = $this->_CONEXION->prepare($sql);
      $query->bindParam(1, $idExamenF, PDO::PARAM_STR);
      $query->bindParam(2, $descripcionPiel, PDO::PARAM_STR);
      if ($query->execute()) {
        return true;
      }else{
        return false;
      }
    } catch (Exception $e) {
      return false;
    }

  }
  function ValidarDespachoUnico(){
    try {
      $idDespacho = $this->__GET("_idDespacho");
      $sql = "CALL spUniqueDespachoReporteaph(?)";
      $query = $this->_CONEXION->prepare($sql);
      $query->bindParam(1, $idDespacho);
      if ($query->execute()) {
        return $query->fetch();
      }else{
        return null;
      }
    } catch (Exception $e) {
      return null;
    }

  }
  function RegistrarCuidadoAntesArriboAPH(){
    try {
      $descripcionCuidado = $this->__GET("_descripcionCuidado");
      $idReporte = $this->__GET("_idReporteAph");
      $sql = "CALL spRegistrarCuidadoantarribo(?,?)";
      $query = $this->_CONEXION->prepare($sql);
      $query->bindParam(1, $descripcionCuidado, PDO::PARAM_STR);
      $query->bindParam(2,$idReporte, PDO::PARAM_STR);
      if ($query->execute()) {
        return true;
      }else{
        return false;
      }
    } catch (Exception $e) {
      return false;
    }
  }
  function RegistrarTestigos(){
    try {
      $idReporteAPH = $this->__GET("_idReporteAph");
      $nombreTestigo = $this->__GET("_nombreTestigo");
      $identificacionTestigo = $this->__GET("_identificacionTestigo");
      $sql = "CALL spRegistrarTestigo(?,?,?)";
      $query = $this->_CONEXION->prepare($sql);
      $query->bindParam(1, $idReporteAPH, PDO::PARAM_STR);
      $query->bindParam(2, $nombreTestigo, PDO::PARAM_STR);
      $query->bindParam(3, $identificacionTestigo, PDO::PARAM_STR);
      if ($query->execute()) {
            return true;
      }else {
            return false;
      }
    } catch (Exception $e) {
            return false;
    }

  }
  function RegistrarNovedadesReporteInicial(){
    try {
      $reporteInicial = $this->__GET("_idReporteInicial");
      $descripcionNovedad = $this->__GET("_descripcionNovedad");
      $cantidadLesionados = $this->__GET("_numeroAfectados");
      $estadoNovedad = $this->__GET("_estadoNovedad");
      $sql = "CALL spRegistrarNovedadreporteinicial(?,?,?,?)";
      $query = $this->_CONEXION->prepare($sql);
      $query->bindParam(1, $reporteInicial, PDO::PARAM_STR);
      $query->bindParam(2, $descripcionNovedad, PDO::PARAM_STR);
      $query->bindParam(3, $cantidadLesionados, PDO::PARAM_STR);
      $query->bindParam(4, $estadoNovedad, PDO::PARAM_STR);
      if ($query->execute()) {
              return true;
      }else{
        return false;
      }
    } catch (Exception $e) {
        return false;
    }

  }
  function FinalizarReporteInicial(){
    try {
      $idReporteInicial = $this->__GET("_idReporteInicial");
        $sql = "SELECT fnFinalizarReporteInicial(?)";
        $query = $this->_CONEXION->prepare($sql);
        $query->bindParam(1, $idReporteInicial, PDO::PARAM_STR);
        if ($query->execute()) {
              return $query->fetchAll();
        }else{
              return 0;
        }
    } catch (Exception $e) {
              return 0;
    }

  }
}


?>

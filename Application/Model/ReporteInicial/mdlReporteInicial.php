<?php

/**
* Modelo reporteInicial:
* Este modelo se encarga de gestionar
* los accesos a la tabla tbl_reporteinicial,
* contiene las operaciones correspondientes
* para llevar a cabo dicha función.
*/
class mdlReporteInicial implements iModel {

  private static $_INSTANCIA; // Instancia única de esta clase
  private $_CONEXION;         // Variable de conexión PDO

  # Atributos de la clase:
  private $idReporteInicial;
  private $informacionInicial;
  private $ubicacionIncidente;
  private $puntoReferencia;
  private $numeroLesionados;
  private $fechaHoraEmergencia;
  private $fechaHoraEnvioReporte;
  private $estadoReporte;

  private $idEnteExterno;
  private $idTipoEvento;
  private $estadoTipoEvento;

  private $ejecutador;
  private $lista;

  # Constructor:
  private function __construct($_CON) {
    $this->_CONEXION = $_CON;
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

  # Métodos y funciones de la clase:

  /*
  * Funcion registrarReporteInicial:
  * N° parámetros (procedimiento almacendado):
  * Descripción: Permite registrar un nuevo reporte inicial
  */

  public function RegistrarReporteInicial() {
    $rs = false;
    try {
      $ejecutador = $this->_CONEXION->prepare("CALL spRegistrarReporteInicial(?,?,?,?,?,?,?)");
      $ejecutador->bindParam(1,$this->informacionInicial, PDO::PARAM_STR);
      $ejecutador->bindParam(2,$this->ubicacionIncidente, PDO::PARAM_STR);
      $ejecutador->bindParam(3,$this->puntoReferencia, PDO::PARAM_STR);
      $ejecutador->bindParam(4,$this->numeroLesionados, PDO::PARAM_STR);
      $ejecutador->bindParam(5,$this->fechaHoraEmergencia, PDO::PARAM_STR);
      $ejecutador->bindParam(6,$this->estadoReporte, PDO::PARAM_STR);
      $ejecutador->bindParam(7,$this->idChat, PDO::PARAM_STR);
      $ejecutador->execute();
      $rs = $ejecutador->fetch();
    } catch (Exception $e) {
      die("Ha ocurrido un error al intentar registrar el reporte inicial: $e");
    }
    return $rs;
  }

  /*
  * Funcion RegistrarNovedad:
  * N° parámetros (procedimiento almacendado):
  * Descripción: Permite añadir novedades a un reporte ya registrado
  */
  public function RegistrarNovedad() {
    $rs = false;
    try {
      $ejecutador = $this->_CONEXION->prepare("CALL spRegistrarNovedadreporteinicial(?,?,?,?)");
      $ejecutador->bindParam(1,$this->idReporteInicial);
      $ejecutador->bindParam(2,$this->descripcionNovedad);
      $ejecutador->bindParam(3,$this->numeroLesionados);
      $ejecutador->bindParam(4,$this->estadoNovedad);
      $rs = $ejecutador->execute();
      if($rs){
        return true;
      }else{
        return false;
      }
    } catch (Exception $e) {
      die("Ha ocurrido un error al registrar novedad: $e");
    }
  }

  /*
  * Funcion cancearReporteInicial:
  * N° parámetros (procedimiento almacendado):
  * Descripción: Permite insertar un un reporte inicial con estado de CANCELADO
  */
  public function CancelarReporte() {
    $rs = false;
    try {
      $ejecutador = $this->_CONEXION->prepare("CALL spCancelarReporteinicial(?,?,?)");
      $ejecutador->bindParam(1,$this->descripcionReporte);
      $ejecutador->bindParam(2,$this->estadoReporte);
      $ejecutador->bindParam(3,$this->idChat);
      $rs = $ejecutador->execute();
      if($rs){
        return true;
      }else{
        return false;
      }
    } catch (Exception $e) {
      die("Ha ocurrido un error: ".$e);
    }
  }

  public function RegistrarTipoEvento_ReporteInicial() {
    $rs = false;
    try {
      $ejecutador = $this->_CONEXION->prepare("CALL spRegistrarTipoevento_reporteinicial(?)");
      $ejecutador->bindParam(1,$this->idTipoEvento);
      $rs = $ejecutador->execute();
    } catch (Exception $e) {
      die("Ha ocurrido un error:". $e);
    }
    return $rs;
  }

  public function RegistrarEnteExterno_ReporteInicial() {
    $rs = false;
    try {
      $ejecutador = $this->_CONEXION->prepare("CALL spRegistrarEnteexterno_reporteinicial(?)");
      $ejecutador->bindParam(1,$this->idEnteExterno);
      $rs = $ejecutador->execute();
    } catch (Exception $e) {
      die("Ha ocurrido un error:". $e);
    }
    return $rs;
  }

  /*
  * Función ConsultarReporteInicial:
  * N° parámetros (procedimiento almacendado): 1
  * Descripción: Permite consultar un reporte inicial en especifico
  */
  public function ConsultarReporteInicial() {
    try {
      $this->ejecutador = $this->_CONEXION->prepare("CALL spConsultarReporteinicial(?)");
      $this->ejecutador->bindParam(1, $this->idReporteInicial);
      $this->ejecutador->execute();
      $this->lista = $this->ejecutador->fetch();
    } catch (Exception $e) {
      die("Ha ocurrido un error al intentar consultar el reporte: $e");
    }
    return $this->lista;
  }

  /*
  * Función ConsultarTipoEventoReporteInicial:
  * N° parámetros (procedimiento almacendado): 1
  * Descripción: Permite consultar los tipos de evento que están asociados a un reporte inicial
  */
  public function ConsultarTipoEventoReporteInicial() {
    $this->lista = null;
    try {
      $this->ejecutador = $this->_CONEXION->prepare("CALL spConsultarTipoevento_reporteinicial(?)");
      $this->ejecutador->bindParam(1, $this->idReporteInicial);
      $this->ejecutador->execute();
      if ($this->ejecutador->rowCount() > 0) {
        $this->lista = $this->ejecutador->fetchAll();
      }
    } catch (Exception $e) {
      die("Ha ocurrido un error al intentar consultar el reporte: $e");
    }
    return $this->lista;
  }

  /*
  * Función ConsultarEnteExternoReporteInicial:
  * N° parámetros (procedimiento almacendado): 1
  * Descripción: Permite consultar los entes externos que están asociados a un reporte inicial
  */
  public function ConsultarEnteExternoReporteInicial() {
    $this->lista = null;
    try {
      $this->ejecutador = $this->_CONEXION->prepare("CALL spConsultarEnteexterno_reporteinicial(?)");
      $this->ejecutador->bindParam(1, $this->idReporteInicial);
      $this->ejecutador->execute();
      if ($this->ejecutador->rowCount() > 0) {
        $this->lista = $this->ejecutador->fetchAll();
      }
    } catch (Exception $e) {
      die("Ha ocurrido un error al intentar consultar el reporte: $e");
    }
    return $this->lista;
  }

  /*
  * Función CancelarReporteInicial:
  * N° parámetros (procedimiento almacendado): 2
  * Descripción: Permite cancelar un reporte inicial en proceso
  */
  public function CancelarReporteInicial() {
    $r = null;
    try {
      $this->ejecutador = $this->_CONEXION->prepare("CALL spCambiarEstadoReporteinicial(?, ?)");
      $this->ejecutador->bindParam(1, $this->idReporteInicial);
      $this->ejecutador->bindParam(2, $this->estadoReporte);
      $this->ejecutador->execute();
      $r = $this->ejecutador->rowCount() > 0;
    } catch (Exception $e) {
      die("Ha ocurrido un error al intentar consultar el reporte: $e");
    }
    return $r;
  }

  # Métodos Getter & Setter:
  public function __GET($var) {
    return $this->$var;
  }

  public function __SET($var, $val) {
    $this->$var = $val;
  }

}


?>

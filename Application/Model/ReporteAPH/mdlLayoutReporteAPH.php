<?php
error_reporting(0);
/**
* Modelo MdlLayoutReporteAPH:
* Este modelo se encarga de funcionalidades extras de ReporteAPH
* esta funcionalidades estan representas en la vista llamada layoutReporteAPH
*/
class MdlLayoutReporteAPH implements iModel {

  private static $_INSTANCIA; // Instancia única de esta clase
  private $_CONEXION;// Variable de conexión PDO


  # Atributos de la clase:
  private $_idReporteInicial;
  private $_idDespacho;
  private $motivoCancelacion;
  private $idEnteExterno;
  private $tipoAyuda;
  private $descripcion;
  private $numeroLesionados;
  private $_idAmbulancia;
  private $_idPersona;



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

  # Métodos y funciones de la clase:


  /**
  * Consultar un ente externo
  */
  function ConsultarEnteExterno() {
    $sql = "CALL spConsultarEnteexterno(?)";
    $query = $this->_CONEXION->prepare($sql);
    $query->bindParam(1, $this->idEnteExterno);
    if ($query->execute()) {
      return $query->fetch();
    }else{
      return null;
    }
  }

  /**
  * Esta función se encarga de confirmar la llegada de la ambulancia al sitio de la emergencia
  */
  public function ConfirmarLlegada() {
    try {
      $sql = "CALL `spConfirmarLlegada`(?)";
      $query = $this->_CONEXION->prepare($sql);
      $query->bindParam(1, $this->_idDespacho);
      $query->execute();
      if ($query->rowCount() > 0) {
        return true;
      }else {
        return false;
      }
    } catch (Exception $e) {
      return false;
    }

  }


  /**
  * Esta función se encarga de cancelar una emergencia
  */
  public function CancelarEmergencia() {
    try {
      $sql = "SELECT fnCancelarEmergencia(?,?,?)";
      $query = $this->_CONEXION->prepare($sql);
      $query->bindParam(1,$this->_idReporteInicial);
      $query->bindParam(2,$this->_idDespacho);
      $query->bindParam(3,$this->motivoCancelacion);

      $query->execute();

      if ($query->rowCount() > 0) {
        return (int) $query->fetchColumn();
      }else {
        echo "Error al ejecutar la función fnCancelarEmergencia en la DB";
      }
    } catch (Exception $e) {
      return null;
    }

  }


  /**
  * Esta función se encarga de pedir una nueva AMBULANCIA
  */
  public function PedirAyuda()  {
    $sql = "SELECT `fnPedirAyuda`(?,?,?,?);";
    $query = $this->_CONEXION->prepare($sql);
    $query->bindParam(1, $this->_idReporteInicial);
    $query->bindParam(2, $this->descripcion);
    $query->bindParam(3, $this->tipoAyuda);
    $query->bindParam(4, $this->numeroLesionados);

    $query->execute();

    if ($query->rowCount() > 0) {
      return $query->fetchColumn();
    }else {
      echo "Error al ejecutar la función fnPedirAyuda en la DB";
    }
  }


  /**
  * Esta función se encarga de registrar una novedad cualquiera, es libre para el usuario
  */
  public function RegistrarNovedad()
  {
    $sql = "CALl `spRegistrarNovedadRinicial`(?,?,?);";
    $query = $this->_CONEXION->prepare($sql);
    $query->bindParam(1, $this->_idReporteInicial);
    $query->bindParam(2, $this->descripcion);
    $query->bindParam(3, $this->numeroLesionados);

    $query->execute();

    if ($query->rowCount() > 0) {
      return true;
    }else {
      return false;
    }
  }


  function ContarNotificacionesDespacho(){
    try {
      $idDespacho = $this->__GET("_idDespacho");
      $sqlVer ="call SpContarNotificacionesDespacho(?)";
      $queryVer= $this->_CONEXION->prepare($sqlVer);
      $queryVer->bindParam(1,$idDespacho, PDO::PARAM_INT);
      if ($queryVer->execute()) {
        return $queryVer->fetch();
      }else{
        return null;
      }

    } catch (Exception $e) {
      return null;
    }

  }

  function DescripcionNotificacionesDespacho(){
    try {
      $idDespacho = $this->__GET("_idDespacho");
      $sql ="call SpDescripcionNotificacionesDespacho(?)";
      $query = $this->_CONEXION->prepare($sql);
      $query->bindParam(1, $idDespacho, PDO::PARAM_INT);
      if ($query->execute()) {
        return $query->fetchAll();
      }else{
        return null;
      }
    } catch (Exception $e) {
      return null;
    }

  }

  /**
  * Consultar las ambulancias
  * @param $idReporteInicial; id de un registro de la tabla tbl_reporteinicial
  */
  public function ConsultarAmbulanciasModelo($idReporteInicial){
    $sql = "CALL spConsultarAmbulanciaEstado(?)";
    $query = $this->_CONEXION->prepare($sql);
    $query->bindParam(1,$idReporteInicial);
    if ($query->execute()) {
      return $query->fetchAll();
    }else{
      return null;
    }
  }


  public function ConsultaEstadoSolo($id){
    $sql="CALL spConsultarAmbulancia(?)";
    $query = $this->_CONEXION->prepare($sql);
    $query->bindParam(1,$id);
    if ($query->execute()) {
      return $query->fetchAll();
    }else{
      return null;
    }
  }

  /**
  * actualizar el Estado de la Ambulancia
  * @param $idAmbulancia; id de un registro de la tabla tbl_ambulancia
  * @param $estadoTabla; id de un registro de la tabla tbl_ambulancia
  */
  public function actualizarEstadoAmbulancia($idAmbulancia, $estadoNuevo){
    $sql = "CALL spModificarEstadoAmbulancia(?,?)";
    $query = $this->_CONEXION->prepare($sql);
    $query->bindParam(1,$idAmbulancia);
    $query->bindParam(2,$estadoNuevo);
    if ($query->execute()) {
      return true;
    }else{
      return false;
    }
  }
  public function ConsultaReporteInicialAPH(){
    try {
      $idReporte = $this->__GET("_idReporteInicial");
      $sql ="CALL spConsultarReporteInicialAPH(?)";
      $query = $this->_CONEXION->prepare($sql);
      $query->bindParam(1, $idReporte);
      $query->execute();
      return $query->fetchAll();
    } catch (Exception $e) {
      return null;
    }

  }
  public function ConsultaDespachoAPH(){
    try {
      $idDespacho = $this->__GET("_idDespacho");
      $sql ="CALL SpConsultarDespachoAPH(?)";
      $query = $this->_CONEXION->prepare($sql);
      $query->bindParam(1, $idDespacho);
      $query->execute();
      return $query->fetchAll();
    } catch (Exception $e) {
      return null;
    }

  }
  public function ConsultarGeolocalizacionAPH(){
    $idDespacho = $this->__GET("_idDespacho");
    $sql ="CALL SpConsultarGeolocalizacion(?)";
    $query = $this->_CONEXION->prepare($sql);
    $query->bindParam(1, $idDespacho);
    $query->execute();
    return $query->fetchAll();
    try {
      return null;
    } catch (Exception $e) {

    }
  }
  public function TraerIDDespacho(){
    try {
      $idPersona =  $this->__GET("_idPersona");
      $sql = "CALL spTraerIDDespacho(?)";
      $execute = $this->_CONEXION->prepare($sql);
      $execute->bindParam(1, $idPersona, PDO::PARAM_STR);
      if ($execute->execute()) {
        return $execute->fetch();
      }else{
        return null;
      }
    } catch (Exception $e) {
      return null;
    }

  }



  # Métodos Setter & Getter:
  public function __SET($var, $valor) {
    if (property_exists(__CLASS__, $var)) {
      $this->$var = $valor;
    } else {
      echo "No existe el atributo $var.";
    }
  }
  public function __GET($var) {
    if (property_exists(__CLASS__, $var)) {
      return $this->$var;
    }
    return NULL;
  }


}


?>

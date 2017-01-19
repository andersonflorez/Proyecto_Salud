<?php

/**
 * Modelo LocalizacionLesiones:
 * Este modelo se encarga de se encarga de consultar
 *las autorizaciones enviadas por el paramédico y
 *aporbarlas o rechazarlas.
 */
class mdlControlAutorizacion implements iModel {
  private static $_INSTANCIA; // Instancia única de esta clase
  private $_CONEXION;         // Variable de conexión PDO

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
  * Consultar Autorizaciones
  */




  public  function consultarAutorizacion($idAutorizacion){
    $sql="CALL spConsultarAutorizacionTemporal(?)";
    $query = $this->_CONEXION->prepare($sql);
    $query->bindParam(1,$idAutorizacion);
    if ($query->execute()) {
      return $query->fetchAll();
    }else{
      return null;
    }
  }

  public function insertarEvaluacionAutorizacion($miArray){

    $sql = "CALL spRegistrarEvaluacionAutorizacion(?,?,?,?,?);";
    $query = $this->_CONEXION->prepare($sql);
    $query->bindParam(1,$miArray[0]);
    $query->bindParam(2,$miArray[1]);
    $query->bindParam(3,$miArray[2]);
    $query->bindParam(4,$miArray[3]);
    $query->bindParam(5,$miArray[4]);
    if ($query->execute()) {
      return true;
    }else{
      return false;
    }

  }

  public  function ConsultarParamedico($idParamedico){
    $sql="CALL spConsultarDatosNotificacion(?)";
    $query = $this->_CONEXION->prepare($sql);
    $query->bindParam(1,$idParamedico);
    if ($query->execute()) {
      return $query->fetchAll();
    }else{
      return null;
    }
  }




}

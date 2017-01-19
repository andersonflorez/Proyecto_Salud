<?php

/**
 * Modelo LocalizacionLesiones:
 * Este modelo se encarga de se encarga de consultar
 *las autorizaciones enviadas por el paramédico y
 *aporbarlas o rechazarlas.
 */
class mdlGenerarReporteAPH implements iModel {
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
  * generarReporteAPH
  */

  public  function consultarReporteAPH($idReporteAPH){
    $sql="CALL spConsultarReporteAPH(?)";
    $query = $this->_CONEXION->prepare($sql);
    $query->bindParam(1,$idReporteAPH);
    if ($query->execute()) {
      return $query->fetch();
    }else{
      return null;
    }
  }


  function ConsultarAntecedentesAPH($idReporteAPH){
    $sql = "CALL spConsultarAntecedentesAPH(?)";
    $query = $this->_CONEXION->prepare($sql);
    $query->bindParam(1,$idReporteAPH);
    $query->execute();
    if ($query->rowCount() > 0) {
      return $query->fetchAll();
    }else{
      return null;
    }
  }

  function ConsultarMotivoConsultaAPH($idReporteAPH){
    $sql = "CALL spConsultarMotivoConsultaAPH(?)";
    $query = $this->_CONEXION->prepare($sql);
    $query->bindParam(1,$idReporteAPH);
    $query->execute();
    if ($query->rowCount() > 0) {
      return $query->fetchAll();
    }else{
      return null;
    }
  }





}

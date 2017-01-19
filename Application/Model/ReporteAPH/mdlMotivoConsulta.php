<?php


class MdlMotivoConsulta implements iModel{

  private static $_INSTANCIA; // Instancia única de esta clase
  private $_CONEXION;         // Variable de conexión PDO
  private $_motivoConsulta;
  private $_tipoMotivoConsulta;
  private $_idReporteAph;
  private $_idMotivoConsulta;

  # Constructor:
  private function __construct($_CON){
    try {
      $this->_CONEXION = $_CON;
    } catch (PDOException $e) {
      exit('Error al intentar conectar con la Base de Datos :' + $e);
    }
  }
  function __GET($atributo){
    return $this->$atributo;
  }
  function __SET($atributo,$valor){
    $this->$atributo = $valor;
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


  function InsertarMotivoConsulta() {
    try {
      $descripcionMotivoConsulta = $this->__GET("_motivoConsulta");
      $tipoMotivoConsulta = $this->__GET("_tipoMotivoConsulta");
      $sql = "CALL spRegistrarMotivoconsulta(?,?)";
      $query = $this->_CONEXION->prepare($sql);
      $query->bindParam(1,$descripcionMotivoConsulta,PDO::PARAM_STR);
      $query->bindParam(2,$tipoMotivoConsulta,PDO::PARAM_STR);
      if ($query->execute()) {
        return $query->fetch();
      }else{
        return false;
      }
    } catch (Exception $e) {
      return false;
    }


  }
  function ListarMotivoConsulta(){
    try {
      $sql = "CALL spListarMotivoconsulta()";
      $query = $this->_CONEXION->prepare($sql);
      if ($query->execute()) {
          return $query->fetchAll();
      }else{
          return null;
      }
    } catch (Exception $e) {
          return null;
    }

  }

  function ListarTipoAseguramiento(){
    try {
      $sql = "CALL spListarTipoaseguramiento()";
      $query = $this->_CONEXION->prepare($sql);
      if ($query->execute()) {
          return $query->fetchAll();
      }else{
          return null;
      }
    } catch (Exception $e) {
          return null;
    }

  }

function ListarAfectado(){
  try {
    $sql = "CALL spListarAfectadoaccidentetransito()";
    $query = $this->_CONEXION->prepare($sql);
    if ($query->execute()) {
        return $query->fetchAll();
    }else{
        return null;
    }
  } catch (Exception $e) {
        return null;
  }

}
function RegistrarReporteaphMotivoconsulta(){
  try {
      $idReporteAph = $this->__GET("_idReporteAph");

      $idMotivoConsulta = $this->__GET("_idMotivoConsulta");
      $especificacion = "NULL";
      $sql = "CALL spRegistrarReporteaph_motivoconsulta(?,?,?)";
      $query = $this->_CONEXION->prepare($sql);
      $query->bindParam(1, $idReporteAph);
      $query->bindParam(2, $idMotivoConsulta);
      $query->bindParam(3, $especificacion);
      if ($query->execute()) {
            return true;
      }else{
            return false;
      }
  } catch (Exception $e) {
          return false;
  }

}

}



?>

<?php

/**
 * Modelo mdlTipoKit:
 * Este modelo pertenece y controla el
 * acceso a los datos de la tabla tbl_tipoKit
 * perteneciente al módulo Stock
 */
class mdlTipoKit implements iModel {

  private static $_INSTANCIA; // Instancia única de esta clase
  private $_CONEXION;         // Variable de conexión PDO

  # Atributos de la clase:
  private $descripcionTipoKit;
  private $estadoTabla = 'Activo';
  private $idTipoKit;

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

  public function RegistrarTipoKit() {
    $r = false;
    try {
      $ejecutador = $this->_CONEXION->prepare("CALL spRegistrarTipokit(?, ?)");
      $ejecutador->bindParam(1, $this->descripcionTipoKit);
      $ejecutador->bindParam(2, $this->estadoTabla);
      $r = $ejecutador->execute();
    } catch (Exception $e) {
      die("Ha ocurrido un error: " . $e);
    }
    return $r;
  }

  public function ModificarTipoKit() {
    $r = false;
    try {
      $ejecutador = $this->_CONEXION->prepare("CALL spModificarTipokit(?, ?)");
      $ejecutador->bindParam(1, $this->idTipoKit);
      $ejecutador->bindParam(2, $this->descripcionTipoKit);
      $r = $ejecutador->execute();
    } catch (Exception $e) {
      die("Ha ocurrido un error: " . $e);
    }
    return $r;
  }

  public function CambiarestadoTabla() {
    $r = false;
    try {
      $ejecutador = $this->_CONEXION->prepare("CALL spCambiarEstadoTipokit(?, ?)");
      $ejecutador->bindParam(1, $this->idTipoKit);
      $ejecutador->bindParam(2, $this->estadoTabla);
      $r = $ejecutador->execute();
      $this->estadoTabla = 'Activo';
    } catch (Exception $e) {
      die("Ha ocurrido un error: " . $e);
    }
    return $r;
  }

  # Métodos Setter & Getter:

  public function SetDescripcionTipoKit($value) {
    $this->descripcionTipoKit = $value;
  }

  public function SetestadoTabla($value) {
    $this->estadoTabla = $value;
  }

  public function SetIdTipoKit($value) {
    $this->idTipoKit = $value;
  }

}


?>

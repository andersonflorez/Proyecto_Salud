<?php

/**
 * Modelo mdltipodocumento:
 * Este modelo pertenece y controla el
 * acceso a los datos de la tabla tbl_enteexterno
 * perteneciente al módulo reporte inicial
 */
class MdlTipoZona implements iModel {

  private static $_INSTANCIA; // Instancia única de esta clase
  private $_CONEXION;         // Variable de conexión PDO

  # Atributos de la clase:
  private $descripcionTipozona;
  private $estadoTabla = 'Activo';
  private $idTipoZona;

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

  public function RegistrarTipozona() {
    $r = false;
    try {
      $ejecutador = $this->_CONEXION->prepare("CALL spRegistrarTipozona(?,?)");
      $ejecutador->bindParam(1, $this->descripcionTipozona);
      $ejecutador->bindParam(2, $this->estadoTabla);
      $r = $ejecutador->execute();
    } catch (Exception $e) {
      die("Ha ocurrido un error: " . $e);
    }
    return $r;
  }

  public function ModificarTipozona() {
    $r = false;
    try {
      $ejecutador = $this->_CONEXION->prepare("CALL spModificarTipozona(?, ?)");
      $ejecutador->bindParam(1, $this->idTipoZona);
      $ejecutador->bindParam(2, $this->descripcionTipozona);
      $r = $ejecutador->execute();
    } catch (Exception $e) {
      die("Ha ocurrido un error: " . $e);
    }
    return $r;
  }

  public function CambiarEstadoTipozona() {
    $r = false;
    try {
      $ejecutador = $this->_CONEXION->prepare("CALL spCambiarEstadoTipozona(?, ?)");
      $ejecutador->bindParam(1, $this->idTipoZona);
      $ejecutador->bindParam(2, $this->estadoTabla);
      $r = $ejecutador->execute();
      $this->EstadoEnteExterno = 'Activo';
    } catch (Exception $e) {
      die("Ha ocurrido un error: " . $e);
    }
    return $r;
  }

  # Métodos Setter & Getter:

  public function SetdescripcionTipozona($value) {
    $this->descripcionTipozona = $value;
  }

  public function SetEstadoTipozona($value) {
    $this->estadoTabla = $value;
  }

  public function SetidTipoZona($value) {
    $this->idTipoZona = $value;
  }

}


?>

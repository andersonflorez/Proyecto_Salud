<?php

/**
 * Modelo mdlEnteExterno:
 * Este modelo pertenece y controla el
 * acceso a los datos de la tabla tbl_enteexterno
 * perteneciente al módulo reporte inicial
 */
class MdlTipoNovedad implements iModel {

  private static $_INSTANCIA; // Instancia única de esta clase
  private $_CONEXION;         // Variable de conexión PDO

  # Atributos de la clase:
  private $descripcionTiponovedad;
  private $estadoTabla = 'Activo';
  private $idTipoNovedad;

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

  public function RegistrarTipoNovedad() {
    $r = false;
    try {
      $ejecutador = $this->_CONEXION->prepare("CALL spRegistrarTipoNovedad(?,?)");
      $ejecutador->bindParam(1, $this->descripcionTiponovedad);
      $ejecutador->bindParam(2, $this->estadoTabla);
      $r = $ejecutador->execute();
    } catch (Exception $e) {
      die("Ha ocurrido un error: " . $e);
    }
    return $r;
  }

  public function ModificarTipoNovedad() {
    $r = false;
    try {
      $ejecutador = $this->_CONEXION->prepare("CALL spModificarTipoNovedad(?, ?)");
      $ejecutador->bindParam(1, $this->idTipoNovedad);
      $ejecutador->bindParam(2, $this->descripcionTiponovedad);
      $r = $ejecutador->execute();
    } catch (Exception $e) {
      die("Ha ocurrido un error: " . $e);
    }
    return $r;
  }

  public function CambiarestadoTabla() {
    $r = false;
    try {
      $ejecutador = $this->_CONEXION->prepare("CALL spCambiarEstadoTipoNovedad(?, ?)");
      $ejecutador->bindParam(1, $this->idTipoNovedad);
      $ejecutador->bindParam(2, $this->estadoTabla);
      $r = $ejecutador->execute();
      $this->estadoTabla = 'Activo';
    } catch (Exception $e) {
      die("Ha ocurrido un error: " . $e);
    }
    return $r;
  }

  # Métodos Setter & Getter:

  public function SetdescripcionTiponovedad($value) {
    $this->descripcionTiponovedad = $value;
  }

  public function SetestadoTabla($value) {
    $this->estadoTabla = $value;
  }

  public function SetidTipoNovedad($value) {
    $this->idTipoNovedad = $value;
  }

}


?>

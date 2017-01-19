<?php
/**
 * Modelo mdlTipoAsignacion:
 * Este modelo pertenece y controla el
 * acceso a los datos de la tabla tbl_TipoAsignacion
 * perteneciente al módulo reporte inicial
 */
class mdlTipoAsignacion implements iModel {

  private static $_INSTANCIA; // Instancia única de esta clase
  private $_CONEXION;         // Variable de conexión PDO

  # Atributos de la clase:
  private $descripcionTipoasignacion;
  private $estadoTabla = 'Activo';
  private $idTipoAsignacion;

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

  public function RegistrarTipoAsignacion() {
    $r = false;
    try {
      $ejecutador = $this->_CONEXION->prepare("CALL spRegistrarTipoasignacion(?,?)");
      $ejecutador->bindParam(1, $this->descripcionTipoasignacion);
      $ejecutador->bindParam(2, $this->estadoTabla);
      $r = $ejecutador->execute();
    } catch (Exception $e) {
      die("Ha ocurrido un error: " . $e);
    }
    return $r;
  }

  public function ModificarTipoAsignacion() {
    $r = false;
    try {
      $ejecutador = $this->_CONEXION->prepare("CALL spModificarTipoasignacion(?, ?)");
      $ejecutador->bindParam(1, $this->idTipoAsignacion);
      $ejecutador->bindParam(2, $this->descripcionTipoasignacion);
      $r = $ejecutador->execute();
    } catch (Exception $e) {
      die("Ha ocurrido un error: " . $e);
    }
    return $r;
  }

  public function CambiarEstadoTipoAsignacion() {
    $r = false;
    try {
      $ejecutador = $this->_CONEXION->prepare("CALL spCambiarEstadoTipoasignacion(?, ?)");
      $ejecutador->bindParam(1, $this->idTipoAsignacion);
      $ejecutador->bindParam(2, $this->estadoTabla);
      $r = $ejecutador->execute();
      $this->estadoTabla = 'Activo';
    } catch (Exception $e) {
      die("Ha ocurrido un error: " . $e);
    }
    return $r;
  }
  # Métodos Setter & Getter:
  public function setDescripcionTipoasignacion($value) {
    $this->descripcionTipoasignacion = $value;
  }
  public function SetEstadoTabla($value) {
    $this->estadoTabla = $value;
  }
  public function SetidTipoAsignacion($value) {
    $this->idTipoAsignacion = $value;
  }
}
?>

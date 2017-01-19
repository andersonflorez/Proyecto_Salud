<?php

/**
 * Modelo mdlTipoDevolucion:
 * Este modelo pertenece y controla el
 * acceso a los datos de la tabla tbl_tipodevolucion
 * perteneciente al módulo Stock
 */
class mdlTipoDevolucion implements iModel {

  private static $_INSTANCIA; // Instancia única de esta clase
  private $_CONEXION;         // Variable de conexión PDO

  # Atributos de la clase:
  private $descripcionDevolucion;
  private $estadoTabla = 'Activo';
  private $idTipoDevolucion;

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

  public function RegistrarTipoDevolucion() {
    $r = false;
    try {
      $ejecutador = $this->_CONEXION->prepare("CALL spRegistrarTipoDevolucion(?, ?)");
      $ejecutador->bindParam(1, $this->descripcionDevolucion);
      $ejecutador->bindParam(2, $this->estadoTabla);
      $r = $ejecutador->execute();
    } catch (Exception $e) {
      die("Ha ocurrido un error: " . $e);
    }
    return $r;
  }

  public function ModificarTipoDevolucion() {
    $r = false;
    try {
      $ejecutador = $this->_CONEXION->prepare("CALL spModificarTipoDevolucion(?, ?)");
      $ejecutador->bindParam(1, $this->idTipoDevolucion);
      $ejecutador->bindParam(2, $this->descripcionDevolucion);
      $r = $ejecutador->execute();
    } catch (Exception $e) {
      die("Ha ocurrido un error: " . $e);
    }
    return $r;
  }

  public function CambiarestadoTabla() {
    $r = false;
    try {
      $ejecutador = $this->_CONEXION->prepare("CALL spCambiarEstadoTipoDevolucion(?, ?)");
      $ejecutador->bindParam(1, $this->idTipoDevolucion);
      $ejecutador->bindParam(2, $this->estadoTabla);
      $r = $ejecutador->execute();
      $this->estadoTabla = 'Activo';
    } catch (Exception $e) {
      die("Ha ocurrido un error: " . $e);
    }
    return $r;
  }

  # Métodos Setter & Getter:

  public function SetdescripcionDevolucion($value) {
    $this->descripcionDevolucion = $value;
  }

  public function SetestadoTabla($value) {
    $this->estadoTabla = $value;
  }

  public function SetIdTipoDevolucion($value) {
    $this->idTipoDevolucion = $value;
  }

}


?>

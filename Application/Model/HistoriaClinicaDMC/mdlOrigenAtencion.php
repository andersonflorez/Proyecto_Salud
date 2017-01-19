<?php

/**
 * Modelo mdlTipoorigenAtencion:
 * Este modelo pertenece y controla el
 * acceso a los datos de la tabla tbl_tipoorigenAtencion
 * perteneciente al módulo historia Clinica
 */
class mdlOrigenAtencion implements iModel {

  private static $_INSTANCIA; // Instancia única de esta clase
  private $_CONEXION;         // Variable de conexión PDO

  # Atributos de la clase:
  private $descripcionorigenAtencion;
  private $estadoTabla = 'Activo';
  private $idTipoOrigenAtencion;

  # Constructor:
  private function __construct($_CON) {
    $this->_CONEXION = $_CON;
  }

  public static function getInstance($_CONEXION) {
    if (!self::$_INSTANCIA instanceof self) {
      self::$_INSTANCIA = new self($_CONEXION);
    }
    return self::$_INSTANCIA;
  }

  # Métodos y funciones de la clase:

  public function RegistrarTipoOrigenAtencion() {
    $registroOrigenAtencion = false;
    try {
      $ejecutador = $this->_CONEXION->prepare("CALL spRegistrarTipoorigenatencion(?,?)");
      $ejecutador->bindParam(1, $this->descripcionorigenAtencion);
      $ejecutador->bindParam(2, $this->estadoTabla);
      $registroOrigenAtencion = $ejecutador->execute();
    } catch (Exception $e) {
      die("Ha ocurrido un error: " . $e);
    }
    return $registroOrigenAtencion;
  }

  public function ModificarTipoOrigenAtencion() {
    $registroOrigenAtencion = false;
    try {
      $ejecutador = $this->_CONEXION->prepare("CALL spModificarTipoorigenatencion(?,?)");
      $ejecutador->bindParam(1, $this->idTipoOrigenAtencion);
      $ejecutador->bindParam(2, $this->descripcionorigenAtencion);
      $registroOrigenAtencion = $ejecutador->execute();
    } catch (Exception $e) {
      die("Ha ocurrido un error: " . $e);
    }
    return $registroOrigenAtencion;
  }

  public function CambiarEstadoTipoOrigenAtencion() {
    $registroOrigenAtencion = false;
    try {
      $ejecutador = $this->_CONEXION->prepare("CALL spCambiarEstadoTipoorigenatencion(?,?)");
      $ejecutador->bindParam(1, $this->idTipoOrigenAtencion);
      $ejecutador->bindParam(2, $this->estadoTabla);
      $registroOrigenAtencion = $ejecutador->execute();
      $this->estadoTabla = 'Activo';
    } catch (Exception $e) {
      die("Ha ocurrido un error: " . $e);
    }
    return $registroOrigenAtencion;
  }

  # Métodos Setter & Getter:

  public function SetDescripcionTipoOrigenAtencion($value) {
    $this->descripcionorigenAtencion = $value;
  }

  public function SetEstadoTipoOrigenAtencion($value) {
    $this->estadoTabla = $value;
  }

  public function SetIdTipoOrigenAtencion($value) {
    $this->idTipoOrigenAtencion = $value;
  }

}


?>

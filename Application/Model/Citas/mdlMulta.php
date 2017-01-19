<?php

/**
 * Modelo mdltipodocumento:
 * Este modelo pertenece y controla el
 * acceso a los datos de la tabla tbl_enteexterno
 * perteneciente al módulo reporte inicial
 */
class mdlMulta implements iModel {

  private static $_INSTANCIA; // Instancia única de esta clase
  private $_CONEXION;         // Variable de conexión PDO

  # Atributos de la clase:
  private $diasMulta;
  private $estadoTabla = 'Activo';
  private $idMulta;
  private $fechaMulta;

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

  public function RegistrarMulta() {
    $r = false;
    try {
      $ejecutador = $this->_CONEXION->prepare("CALL spRegistrarMulta(?,?,?)");
      $ejecutador->bindParam(1, $this->diasMulta);
      $ejecutador->bindParam(2, $this->fechaMulta);
      $ejecutador->bindParam(3, $this->estadoTabla);
      $r = $ejecutador->execute();
    } catch (Exception $e) {
      die("Ha ocurrido un error: " . $e);
    }
    return $r;
  }

  public function ModificarMulta() {
    $r = false;
    try {
      $ejecutador = $this->_CONEXION->prepare("CALL spModificarMulta(?,?,?)");
      $ejecutador->bindParam(1, $this->idMulta);
      $ejecutador->bindParam(2, $this->diasMulta);
      $ejecutador->bindParam(3, $this->fechaMulta);
      $r = $ejecutador->execute();
    } catch (Exception $e) {
      die("Ha ocurrido un error: " . $e);
    }
    return $r;
  }

  public function CambiarEstadoMulta() {
    $r = false;
    try {
      $ejecutador = $this->_CONEXION->prepare("CALL spCambiarEstadoMulta(?,?)");
      $ejecutador->bindParam(1, $this->idMulta);
      $ejecutador->bindParam(2, $this->estadoTabla);
      $r = $ejecutador->execute();
      $this->EstadoEnteExterno = 'Activo';
    } catch (Exception $e) {
      die("Ha ocurrido un error: " . $e);
    }
    return $r;
  }

  # Métodos Setter & Getter:

  public function SetDiasMulta($value) {
    $this->diasMulta = $value;
  }
  public function SetFechaMulta($value) {
    $this->fechaMulta = $value;
  }

  public function SetEstadoMulta($value) {
    $this->estadoTabla = $value;
  }

  public function SetidMulta($value) {
    $this->idMulta = $value;
  }

}


?>

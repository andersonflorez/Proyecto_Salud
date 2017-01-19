<?php

/**
* Modelo mdltipodocumento:
* Este modelo pertenece y controla el
* acceso a los datos de la tabla tbl_enteexterno
* perteneciente al módulo reporte inicial
*/
class MdlTipoDocumento implements iModel {

  private static $_INSTANCIA; // Instancia única de esta clase
  private $_CONEXION;         // Variable de conexión PDO

  # Atributos de la clase:
  private $descripcionTdocumento;
  private $estadoTabla = 'Activo';
  private $idTipoDocumento;

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

  public function RegistrarTipoDocumento() {
    $r = false;
    try {
      $ejecutador = $this->_CONEXION->prepare("CALL spRegistrarTipodocumento(?,?)");
      $ejecutador->bindParam(1, $this->descripcionTdocumento);
      $ejecutador->bindParam(2, $this->estadoTabla);
      $r = $ejecutador->execute();
    } catch (Exception $e) {
      die("Ha ocurrido un error: " . $e);
    }
    return $r;
  }

  public function ModificarTipoDocumento() {
    $r = false;
    try {
      $ejecutador = $this->_CONEXION->prepare("CALL spModificarTipodocumento(?, ?)");
      $ejecutador->bindParam(1, $this->idTipoDocumento);
      $ejecutador->bindParam(2, $this->descripcionTdocumento);
      $r = $ejecutador->execute();
    } catch (Exception $e) {
      die("Ha ocurrido un error: " . $e);
    }
    return $r;
  }

  public function CambiarEstadoTipoDocumento() {
    $r = false;
    try {
      $ejecutador = $this->_CONEXION->prepare("CALL spCambiarEstadoTipodocumento(?, ?)");
      $ejecutador->bindParam(1, $this->idTipoDocumento);
      $ejecutador->bindParam(2, $this->estadoTabla);
      $r = $ejecutador->execute();
      $this->EstadoEnteExterno = 'Activo';
    } catch (Exception $e) {
      die("Ha ocurrido un error: " . $e);
    }
    return $r;
  }

  # Métodos Setter & Getter:

  public function SetDescripcionTipoDocumento($value) {
    $this->descripcionTdocumento = $value;
  }

  public function SetEstadoTipoDocumento($value) {
    $this->estadoTabla = $value;
  }

  public function SetIdTipoDocumento($value) {
    $this->idTipoDocumento = $value;
  }

}


?>

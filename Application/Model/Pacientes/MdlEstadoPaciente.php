<?php

/**
* Modelo mdltipodocumento:
* Este modelo pertenece y controla el
* acceso a los datos de la tabla tbl_enteexterno
* perteneciente al módulo reporte inicial
*/
class MdlEstadoPaciente implements iModel {

  private static $_INSTANCIA; // Instancia única de esta clase
  private $_CONEXION;         // Variable de conexión PDO

  # Atributos de la clase:
  private $descripcionEstadoPaciente;
  private $estadoTabla = 'Activo';
  private $idEstadoPaciente;

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

  public function RegistrarEstadoPaciente() {
    $r = false;
    try {
      $ejecutador = $this->_CONEXION->prepare("CALL spRegistrarEstadopaciente(?,?)");
      $ejecutador->bindParam(1, $this->descripcionEstadoPaciente);
      $ejecutador->bindParam(2, $this->estadoTabla);
      $r = $ejecutador->execute();
    } catch (Exception $e) {
      die("Ha ocurrido un error: " . $e);
    }
    return $r;
  }

  public function ModificarEstadoPaciente() {
    $r = false;
    try {
      $ejecutador = $this->_CONEXION->prepare("CALL spModificarEstadopaciente(?, ?)");
      $ejecutador->bindParam(1, $this->idEstadoPaciente);
      $ejecutador->bindParam(2, $this->descripcionEstadoPaciente);
      $r = $ejecutador->execute();
    } catch (Exception $e) {
      die("Ha ocurrido un error: " . $e);
    }
    return $r;
  }

  public function CambiarEstadoTipoDocumento() {
    $r = false;
    try {
      $ejecutador = $this->_CONEXION->prepare("CALL spCambiarEstadoPaciente(?, ?)");
      $ejecutador->bindParam(1, $this->idEstadoPaciente);
      $ejecutador->bindParam(2, $this->estadoTabla);
      $r = $ejecutador->execute();
      $this->EstadoEnteExterno = 'Activo';
    } catch (Exception $e) {
      die("Ha ocurrido un error: " . $e);
    }
    return $r;
  }

  # Métodos Setter & Getter:

  public function SetDescripcionEstadoPaciente($value) {
    $this->descripcionEstadoPaciente = $value;
  }

  public function SetEstadoPaciente($value) {
    $this->estadoTabla = $value;
  }

  public function SetIdEstadoPaciente($value) {
    $this->idEstadoPaciente = $value;
  }

}


?>

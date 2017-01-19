<?php

/**
 * Modelo mdlEnteExterno:
 * Este modelo pertenece y controla el
 * acceso a los datos de la tabla tbl_enteexterno
 * perteneciente al módulo reporte inicial
 */
class mdlEnteExterno implements iModel {

  private static $_INSTANCIA; // Instancia única de esta clase
  private $_CONEXION;         // Variable de conexión PDO

  # Atributos de la clase:
  private $DescripcionEnteExterno;
  private $EstadoEnteExterno = 'Activo';
  private $idEnteExterno;

  private $lista;

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

  public function RegistrarEnteExterno() {
    $r = false;
    try {
      $ejecutador = $this->_CONEXION->prepare("CALL spRegistrarEnteexterno(?)");
      $ejecutador->bindParam(1, $this->descripcionEnteExterno);
      $r = $ejecutador->execute();
    } catch (Exception $e) {
      die("Ha ocurrido un error: " . $e);
    }
    return $r;
  }

  public function ModificarEnteExterno() {
    $r = false;
    try {
      $ejecutador = $this->_CONEXION->prepare("CALL spModificarEnteexterno(?, ?)");
      $ejecutador->bindParam(1, $this->idEnteExterno);
      $ejecutador->bindParam(2, $this->descripcionEnteExterno);
      $r = $ejecutador->execute();
    } catch (Exception $e) {
      die("Ha ocurrido un error: " . $e);
    }
    return $r;
  }

  public function CambiarEstadoEnteExterno() {
    $r = false;
    try {
      $ejecutador = $this->_CONEXION->prepare("CALL spCambiarEstadoEnteexterno(?, ?)");
      $ejecutador->bindParam(1, $this->idEnteExterno);
      $ejecutador->bindParam(2, $this->estadoEnteExterno);
      $r = $ejecutador->execute();
      $this->EstadoEnteExterno = 'Activo';
    } catch (Exception $e) {
      die("Ha ocurrido un error: " . $e);
    }
    return $r;
  }

  public function ListarEnteExterno(){
    try {
      $ejecutador = $this->_CONEXION->prepare("CALL spListarEnteExterno()");
      $ejecutador->execute();
      if($ejecutador->rowCount() > 0){
        $this->lista = $ejecutador->fetchAll();
      }
    } catch (Exception $e) {
      die("Ha ocurrido un error: ".$e);
    }
    return $this->lista;
  }

  # Métodos Setter & Getter:

  public function __GET($var) {
    return $this->$var;
  }

  public function __SET($var, $val) {
    $this->$var = $val;
  }

}


?>

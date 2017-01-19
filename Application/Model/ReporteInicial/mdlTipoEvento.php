<?php

/**
 * Modelo mdlTipoEvento:
 * Este modelo pertenece y controla el
 * acceso a los datos de la tabla tbl_tipoevento
 * perteneciente al módulo reporte inicial
 */
class mdlTipoEvento implements iModel {

  private static $_INSTANCIA; // Instancia única de esta clase
  private $_CONEXION;         // Variable de conexión PDO

  # Atributos de la clase:
  private $DescripcionTipoEvento;
  private $EstadoTipoEvento = 'Activo';
  private $idTipoEvento;

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

  public function RegistrarTipoEvento() {
    $r = false;
    try {
      $ejecutador = $this->_CONEXION->prepare("CALL spRegistrarTipoevento(?)");
      $ejecutador->bindParam(1, $this->descripcionTipoEvento);
      $r = $ejecutador->execute();
    } catch (Exception $e) {
      die("Ha ocurrido un error: " . $e);
    }
    return $r;
  }

  public function ModificarTipoEvento() {
    $r = false;
    try {
      $ejecutador = $this->_CONEXION->prepare("CALL spModificarTipoevento(?, ?)");
      $ejecutador->bindParam(1, $this->idTipoEvento);
      $ejecutador->bindParam(2, $this->descripcionTipoEvento);
      $r = $ejecutador->execute();
    } catch (Exception $e) {
      die("Ha ocurrido un error: " . $e);
    }
    return $r;
  }

  public function CambiarEstadoTipoEvento() {
    $r = false;
    try {
      $ejecutador = $this->_CONEXION->prepare("CALL spCambiarEstadoTipoevento(?, ?)");
      $ejecutador->bindParam(1, $this->idTipoEvento);
      $ejecutador->bindParam(2, $this->estadoTipoEvento);
      $r = $ejecutador->execute();
      $this->EstadoTipoEvento = 'Activo';
    } catch (Exception $e) {
      die("Ha ocurrido un error: " . $e);
    }
    return $r;
  }

  public function ListarTipoEvento(){
    try {
      $ejecutador = $this->_CONEXION->prepare("CALL spListarTipoevento()");
      $ejecutador->execute();
      if ($ejecutador->rowCount() > 0) {
        $this->lista = $ejecutador->fetchAll();
      }
    } catch (Exception $e) {
      die("Ha ocurrido un error: " . $e);
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

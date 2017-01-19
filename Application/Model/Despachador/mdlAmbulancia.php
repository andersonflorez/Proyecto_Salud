<?php

/**
 * Modelo mdlAmbulancia:
 * Este modelo pertenece y controla el
 * acceso a los datos de la tabla tbl_Ambulancia
 * perteneciente al módulo Despachador
 */
class mdlAmbulancia implements iModel {

  private static $_INSTANCIA; // Instancia única de esta clase
  private $_CONEXION;         // Variable de conexión PDO

  # Atributos de la clase:
  private $TipoAmbulancia;
  private $PlacaAmbulancia;
  private $EstadoAmbulancia = 'Activo';
  private $idAmbulancia;

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

  public function RegistrarAmbulancia() {
    $r = false;
    try {
      $ejecutador = $this->_CONEXION->prepare("CALL spRegistrarAmbulancia(?,?,?)");
      $ejecutador->bindParam(1, $this->TipoAmbulancia);
      $ejecutador->bindParam(2, $this->PlacaAmbulancia);
      $ejecutador->bindParam(3, $this->EstadoAmbulancia);
      $r = $ejecutador->execute();
    } catch (Exception $e) {
      die("Ha ocurrido un error: " . $e);
    }
    return $r;
  }

  public function ModificarAmbulancia() {
    $r = false;
    try {
      $ejecutador = $this->_CONEXION->prepare("CALL spModificarAmbulancia(?,?,?)");
      $ejecutador->bindParam(1, $this->idAmbulancia);
      $ejecutador->bindParam(2, $this->TipoAmbulancia);
      $ejecutador->bindParam(3, $this->PlacaAmbulancia);
      $r = $ejecutador->execute();
    } catch (Exception $e) {
      die("Ha ocurrido un error: " . $e);
    }
    return $r;
  }

  public function CambiarEstadoAmbulancia() {
    $r = false;
    try {
      $ejecutador = $this->_CONEXION->prepare("CALL spCambiarEstadoAmbulancia(?, ?)");
      $ejecutador->bindParam(1, $this->idAmbulancia);
      $ejecutador->bindParam(2, $this->EstadoAmbulancia);
      $r = $ejecutador->execute();
      $this->EstadoEnteExterno = 'Activo';
    } catch (Exception $e) {
      die("Ha ocurrido un error: " . $e);
    }
    return $r;
  }

  # Métodos Setter & Getter:

  public function SetPlacaAmbulancia($value) {
    $this->PlacaAmbulancia = $value;
  }

  public function SetTipoAmbulancia($value) {
    $this->TipoAmbulancia = $value;
  }

  public function SetIdAmbulancia($value) {
    $this->idAmbulancia = $value;
  }
  public function SetEstadoAmbulancia($value) {
    $this->EstadoAmbulancia = $value;
  }

}


?>

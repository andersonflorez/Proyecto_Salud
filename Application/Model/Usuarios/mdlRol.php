<?php

class mdlRol implements iModel {

  private static $_INSTANCIA; // Instancia única de esta clase
  private $_CONEXION;         // Variable de conexión PDO

  # Atributos de la clase:
  private $DescripcionRol;
  private $EstadoRol = 'Activo';
  private $idRol;

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

  public function RegistrarRol() {

    $r = false;

    try {

      $ejecutador = $this->_CONEXION->prepare("CALL spRegistrarRol(?,?)");
      $ejecutador->bindParam(1, $this->DescripcionRol);
      $ejecutador->bindParam(2, $this->EstadoRol);
      $r = $ejecutador->execute();

    } catch (Exception $e) {
      die("Ha ocurrido un error: " . $e);
    }

    return $r;

  }

  public function ModificarRol() {

    $r = false;

    try {

      $ejecutador = $this->_CONEXION->prepare("CALL spModificarRol(?, ?)");
      $ejecutador->bindParam(1, $this->idRol);
      $ejecutador->bindParam(2, $this->DescripcionRol);
      $r = $ejecutador->execute();

    } catch (Exception $e) {
      die("Ha ocurrido un error: " . $e);
    }

    return $r;

  }

  public function CambiarEstadoRol() {

    $r = false;

    try {

      $ejecutador = $this->_CONEXION->prepare("CALL spCambiarEstadoRol(?, ?)");
      $ejecutador->bindParam(1, $this->idRol);
      $ejecutador->bindParam(2, $this->EstadoRol);
      $r = $ejecutador->execute();
      $this->EstadoRol = 'Activo';

    } catch (Exception $e) {
      die("Ha ocurrido un error: " . $e);
    }

    return $r;

  }

  # Métodos Setter & Getter:

  public function SetDescripcionRol($value) {
    $this->DescripcionRol = $value;
  }

  public function SetEstadoRol($value) {
    $this->EstadoRol = $value;
  }

  public function SetIdRol($value) {
    $this->idRol = $value;
  }

}


?>

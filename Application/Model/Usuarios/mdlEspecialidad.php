<?php

class mdlEspecialidad implements iModel {

  private static $_INSTANCIA; // Instancia única de esta clase
  private $_CONEXION;         // Variable de conexión PDO

  # Atributos de la clase:
  private $DescripcionEspecialidad;
  private $EstadoEspecialidad = 'Activo';
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

  public function RegistrarEspecialidad() {

    $r = false;

    try {

      $ejecutador = $this->_CONEXION->prepare("CALL spRegistrarEspecialidad(?,?)");
      $ejecutador->bindParam(1, $this->DescripcionEspecialidad);
      $ejecutador->bindParam(2, $this->EstadoEspecialidad);
      $r = $ejecutador->execute();

    } catch (Exception $e) {
      die("Ha ocurrido un error: " . $e);
    }

    return $r;

  }

  public function ModificarEspecialidad() {

    $r = false;

    try {

      $ejecutador = $this->_CONEXION->prepare("CALL spModificarEspecialidad(?, ?)");
      $ejecutador->bindParam(1, $this->idEspecialidad);
      $ejecutador->bindParam(2, $this->DescripcionEspecialidad);
      $r = $ejecutador->execute();

    } catch (Exception $e) {
      die("Ha ocurrido un error: " . $e);
    }

    return $r;

  }

  public function CambiarEstadoEspecialidad() {

    $r = false;

    try {

      $ejecutador = $this->_CONEXION->prepare("CALL spCambiarEstadoEspecialidad(?, ?)");
      $ejecutador->bindParam(1, $this->idEspecialidad);
      $ejecutador->bindParam(2, $this->EstadoEspecialidad);
      $r = $ejecutador->execute();
      $this->EstadoEspecialidad = 'Activo';

    } catch (Exception $e) {
      die("Ha ocurrido un error: " . $e);
    }

    return $r;

  }
  
  # Métodos Setter & Getter:

  public function SetDescripcionEspecialidad($value) {
    $this->DescripcionEspecialidad = $value;
  }

  public function SetEstadoEspecialidad($value) {
    $this->EstadoEspecialidad = $value;
  }

  public function SetIdEspecialidad($value) {
    $this->idEspecialidad = $value;
  }

}


?>

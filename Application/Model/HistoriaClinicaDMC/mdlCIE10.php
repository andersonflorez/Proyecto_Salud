<?php

class MdlCIE10 implements iModel{
  private static $_INSTANCIA; // Instancia única de esta clase
  private $_CONEXION;         // Variable de conexión PDO

  # Atributos de la clase:
  private $DescripcionCie10;
  private $EstadoCie10 = 'Activo';
  private $idCie10;
  private $CodigoCie10;

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
  public function RegistrarCie10() {
    $r = false;
    try {
      $ejecutador = $this->_CONEXION->prepare("CALL spRegistrarCie10(?,?,?)");
      $ejecutador->bindParam(1, $this->CodigoCie10);
      $ejecutador->bindParam(2, $this->DescripcionCie10);
      $ejecutador->bindParam(3, $this->EstadoCie10);
      $r = $ejecutador->execute();
    } catch (Exception $e) {
      die("Ha ocurrido un error: " . $e);
    }
    return $r;
  }

  public function ModificarCie10() {
    $r = false;
    try {
      $ejecutador = $this->_CONEXION->prepare("CALL spModificarCie10(?,?,?)");
      $ejecutador->bindParam(1, $this->idCie10);
      $ejecutador->bindParam(2, $this->CodigoCie10);
      $ejecutador->bindParam(3, $this->DescripcionCie10);
      $ejecutador->execute();
      $r = $ejecutador->rowCount() > 0;
    } catch (Exception $e) {
      die("Ha ocurrido un error: " . $e);
    }
    return $r;
  }

  public function CambiarEstadoCie10() {
    $r = false;
    try {
      $ejecutador = $this->_CONEXION->prepare("CALL spCambiarEstadoCie10(?,?)");
      $ejecutador->bindParam(1, $this->idCie10);
      $ejecutador->bindParam(2, $this->EstadoCie10);
      $r = $ejecutador->execute();
      $this->EstadoCie10 = 'Activo';
    } catch (Exception $e) {
      die("Ha ocurrido un error: " . $e);
    }
    return $r;
  }

  public function SetDescripcionCie10($value) {
    $this->DescripcionCie10 = $value;
  }

  public function SetEstadoCie10($value) {
    $this->EstadoCie10 = $value;
  }

  public function SetIdCie10($value) {
    $this->idCie10 = $value;
  }

  public function SetCodigoCie10($value){
    $this->CodigoCie10 = $value;
  }


}





 ?>
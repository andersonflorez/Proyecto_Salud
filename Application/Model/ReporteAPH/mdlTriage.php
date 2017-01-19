<?php

class MdlTriage implements iModel{
  private static $_INSTANCIA; // Instancia única de esta clase
  private $_CONEXION;         // Variable de conexión PDO

  # Atributos de la clase:
  private $DescripcionTriage;
  private $EstadoTriage= 'Activo';
  private $idTriage;



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
  public function RegistrarTriage() {
    $r = false;
    try {
      $ejecutador = $this->_CONEXION->prepare("CALL spRegistrarTriage(?,?)");
      $ejecutador->bindParam(1, $this->DescripcionTriage);
      $ejecutador->bindParam(2, $this->EstadoTriage);
      $r = $ejecutador->execute();
    } catch (Exception $e) {
      die("Ha ocurrido un error: " . $e);
    }
    return $r;
  }

  public function ModificarTriage() {
    $r = false;
    try {
      $ejecutador = $this->_CONEXION->prepare("CALL spModificarTriage(?,?)");
      $ejecutador->bindParam(1, $this->idTriage);
      $ejecutador->bindParam(2, $this->DescripcionTriage);
      $ejecutador->execute();
      $r = $ejecutador->rowCount() > 0;
    } catch (Exception $e) {
      die("Ha ocurrido un error: " . $e);
    }
    return $r;
  }

  public function CambiarEstadoTriage() {
    $r = false;
    try {
      $ejecutador = $this->_CONEXION->prepare("CALL spCambiarEstadoTriage(?,?)");
      $ejecutador->bindParam(1, $this->idTriage);
      $ejecutador->bindParam(2, $this->EstadoTriage);
      $r = $ejecutador->execute();
      $this->EstadoTriage = 'Activo';
    } catch (Exception $e) {
      die("Ha ocurrido un error: " . $e);
    }
    return $r;
  }

  public function SetDescripcionTriage($value) {
    $this->DescripcionTriage = $value;
  }

  public function SetEstadoTriage($value) {
    $this->EstadoTriage = $value;
  }

  public function SetIdTriage($value) {
    $this->idTriage = $value;
  }





}






 ?>

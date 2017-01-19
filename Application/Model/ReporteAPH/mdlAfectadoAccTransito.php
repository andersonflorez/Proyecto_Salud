<?php

class MdlAfectadoAccTransito implements iModel{
  private static $_INSTANCIA; // Instancia única de esta clase
  private $_CONEXION;         // Variable de conexión PDO

  # Atributos de la clase:
  private $DescripcionAfectado;
  private $EstadoAfectado = 'Activo';
  private $idAfectado;


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
  public function RegistrarAfectado() {
    $r = false;
    try {
      $ejecutador = $this->_CONEXION->prepare("CALL spRegistrarAfectadoaccidentetransito(?,?)");
      $ejecutador->bindParam(1, $this->DescripcionAfectado);
      $ejecutador->bindParam(2, $this->EstadoAfectado);
      $r = $ejecutador->execute();
    } catch (Exception $e) {
      die("Ha ocurrido un error: " . $e);
    }
    return $r;
  }

  public function ModificarAfectado() {
    $r = false;
    try {
      $ejecutador = $this->_CONEXION->prepare("CALL spModificarAfectadoaccidentetransito(?,?)");
      $ejecutador->bindParam(1, $this->idAfectado);
      $ejecutador->bindParam(2, $this->DescripcionAfectado);
      $ejecutador->execute();
      $r = $ejecutador->rowCount() > 0;
    } catch (Exception $e) {
      die("Ha ocurrido un error: " . $e);
    }
    return $r;
  }

  public function CambiarEstadoAfectado() {
    $r = false;
    try {
      $ejecutador = $this->_CONEXION->prepare("CALL spCambiarEstadoAfectadoaccidentetransito(?,?)");
      $ejecutador->bindParam(1, $this->idAfectado);
      $ejecutador->bindParam(2, $this->EstadoAfectado);
      $r = $ejecutador->execute();
      $this->EstadoCie10 = 'Activo';
    } catch (Exception $e) {
      die("Ha ocurrido un error: " . $e);
    }
    return $r;
  }

  public function SetDescripcionAfectado($value) {
    $this->DescripcionAfectado = $value;
  }

  public function SetEstadoAfectado($value) {
    $this->EstadoAfectado = $value;
  }

  public function SetIdAfectado($value) {
    $this->idAfectado = $value;
  }



}





?>

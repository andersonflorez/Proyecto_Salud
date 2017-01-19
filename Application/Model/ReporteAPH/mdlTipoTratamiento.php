<?php

class MdlTipoTratamiento implements iModel{
  private static $_INSTANCIA; // Instancia única de esta clase
  private $_CONEXION;         // Variable de conexión PDO

  # Atributos de la clase:
  private $DescripcionTipoTratamiento;
  private $EstadoTipoTratamiento = 'Activo';
  private $idTipoTratamiento;
  private $categoriaTratamiento;
  private $categoriaItemTratamiento;


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
  public function RegistrarTipoTratamiento() {
    $r = false;
    try {
      $ejecutador = $this->_CONEXION->prepare("CALL spRegistrarTipotratamiento(?,?,?,?)");
      $ejecutador->bindParam(1, $this->DescripcionTipoTratamiento);
      $ejecutador->bindParam(2, $this->categoriaTratamiento);
      $ejecutador->bindParam(3, $this->categoriaItemTratamiento);
      $ejecutador->bindParam(4, $this->EstadoTipoTratamiento);
      $r = $ejecutador->execute();
    } catch (Exception $e) {
      die("Ha ocurrido un error: " . $e);
    }
    return $r;
  }

  public function ModificarTipoTratamiento() {
    $r = false;
    try {
      $ejecutador = $this->_CONEXION->prepare("CALL spModificarTipotratamiento(?,?,?,?)");
      $ejecutador->bindParam(1, $this->idTipoTratamiento);
      $ejecutador->bindParam(2, $this->DescripcionTipoTratamiento);
      $ejecutador->bindParam(3, $this->categoriaTratamiento);
      $ejecutador->bindParam(4, $this->categoriaItemTratamiento);
      $ejecutador->execute();
      $r = $ejecutador->rowCount() > 0;
    } catch (Exception $e) {
      die("Ha ocurrido un error: " . $e);
    }
    return $r;
  }

  public function CambiarEstadoTipoTratamiento() {
    $r = false;
    try {
      $ejecutador = $this->_CONEXION->prepare("CALL spCambiarEstadoTipotratamiento(?,?)");
      $ejecutador->bindParam(1, $this->idTipoTratamiento);
      $ejecutador->bindParam(2, $this->EstadoTipoTratamiento);
      $r = $ejecutador->execute();
      $this->EstadoTipoTratamiento = 'Activo';
    } catch (Exception $e) {
      die("Ha ocurrido un error: " . $e);
    }
    return $r;
  }

  public function SetDescripcionTipoTratamiento($value) {
    $this->DescripcionTipoTratamiento = $value;
  }

  public function SetEstadoTipoTratamiento($value) {
    $this->EstadoTipoTratamiento = $value;
  }

  public function SetIdTipoTratamiento($value) {
    $this->idTipoTratamiento = $value;
  }

  public function SetCategoriaTratamiento($value){
    $this->categoriaTratamiento = $value;
  }

  public function SetCategoriaItemTratamiento($value){
    $this->categoriaItemTratamiento = $value;
  }




}






 ?>

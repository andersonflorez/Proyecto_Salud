<?php

class MdlTipoAseguramiento implements iModel{
  private static $_INSTANCIA; // Instancia única de esta clase
  private $_CONEXION;         // Variable de conexión PDO

  # Atributos de la clase:
  private $DescripcionTipoAseguramiento;
  private $EstadoTipoAseguramiento = 'Activo';
  private $idTipoAseguramiento;

  public function __GET($atributo){
    return $this->$atributo;
  }
  public function __SET($atributo,$valor){
    $this->$atributo = $valor;
  }

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
  public function RegistrarTipoAseguramiento() {
    $r = false;
    try {
      $ejecutador = $this->_CONEXION->prepare("CALL spRegistrarTipoaseguramiento(?,?)");
      $ejecutador->bindParam(1, $this->DescripcionTipoAseguramiento);
      $ejecutador->bindParam(2, $this->EstadoTipoAseguramiento);
      $r = $ejecutador->execute();
    } catch (Exception $e) {
      die("Ha ocurrido un error: " . $e);
    }
    return $r;
  }

  public function ModificarTipoAseguramiento() {
    $r = false;
    try {
      $ejecutador = $this->_CONEXION->prepare("CALL spModificarTipoaseguramiento(?,?)");
      $ejecutador->bindParam(1, $this->idTipoAseguramiento);
      $ejecutador->bindParam(2, $this->DescripcionTipoAseguramiento);
      $ejecutador->execute();
      $r = $ejecutador->rowCount() > 0;
    } catch (Exception $e) {
      die("Ha ocurrido un error: " . $e);
    }
    return $r;
  }

  public function CambiarEstadoTipoAseguramiento() {
    $r = false;
    try {
      $ejecutador = $this->_CONEXION->prepare("CALL spCambiarEstadoTipoaseguramiento(?,?)");
      $ejecutador->bindParam(1, $this->idTipoAseguramiento);
      $ejecutador->bindParam(2, $this->EstadoTipoAseguramiento);
      $r = $ejecutador->execute();
      $this->EstadoTipoAseguramiento = 'Activo';
    } catch (Exception $e) {
      die("Ha ocurrido un error: " . $e);
    }
    return $r;
  }
  function registrarTipoAseguramientoHC(){
    try {
      $DescripcionTipoAseguramiento = $this->__GET("DescripcionTipoAseguramiento");
      $sql = "CALL spRegistrarTipoAseguramientoHC(?,?)";
      $query = $this->_CONEXION->prepare($sql);
      $query->bindParam(1, $DescripcionTipoAseguramiento, PDO::PARAM_STR);
      $query->bindParam(2, $this->EstadoTipoAseguramiento, PDO::PARAM_STR);
      if ($query->execute()) {
            return $query->fetch();
      }else{
              return null;
      }
    } catch (Exception $e) {
          return null;
    }

  }

  public function SetDescripcionTipoAseguramiento($value) {
    $this->DescripcionTipoAseguramiento = $value;
  }

  public function SetEstadoTipoAseguramiento($value) {
    $this->EstadoTipoAseguramiento = $value;
  }

  public function SetIdTipoAseguramiento($value) {
    $this->idTipoAseguramiento = $value;
  }





}


 ?>

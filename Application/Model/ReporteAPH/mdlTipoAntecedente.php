<?php

class MdlTipoAntecedente implements iModel{
  private static $_INSTANCIA; // Instancia única de esta clase
  private $_CONEXION;         // Variable de conexión PDO

  # Atributos de la clase:
  private $DescripcionTipoAntecedente;
  private $EstadoTipoAntecedente = 'Activo';
  private $idTipoAntecedente;


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
  public function RegistrarTipoAntecedente() {
    $r = false;
    try {
      $ejecutador = $this->_CONEXION->prepare("CALL spRegistrarTipoantecedente(?,?)");
      $ejecutador->bindParam(1, $this->DescripcionTipoAntecedente);
      $ejecutador->bindParam(2, $this->EstadoTipoAntecedente);
      $r = $ejecutador->execute();
    } catch (Exception $e) {
      die("Ha ocurrido un error: " . $e);
    }
    return $r;
  }

  public function ModificarTipoAntecedente() {
    $r = false;
    try {
      $ejecutador = $this->_CONEXION->prepare("CALL spModificarTipoantecedente(?,?)");
      $ejecutador->bindParam(1, $this->idTipoAntecedente);
      $ejecutador->bindParam(2, $this->DescripcionTipoAntecedente);
      $ejecutador->execute();
      $r = $ejecutador->rowCount() > 0;
    } catch (Exception $e) {
      die("Ha ocurrido un error: " . $e);
    }
    return $r;
  }

  public function CambiarEstadoTipoAntecedente() {
    $r = false;
    try {
      $ejecutador = $this->_CONEXION->prepare("CALL spCambiarEstadoTipoantecedente(?,?)");
      $ejecutador->bindParam(1, $this->idTipoAntecedente);
      $ejecutador->bindParam(2, $this->EstadoTipoAntecedente);
      $r = $ejecutador->execute();
      $this->EstadoCie10 = 'Activo';
    } catch (Exception $e) {
      die("Ha ocurrido un error: " . $e);
    }
    return $r;
  }

  public function SetDescripcionTipoAntecedente($value) {
    $this->DescripcionTipoAntecedente = $value;
  }

  public function SetEstadoTipoAntecedente($value) {
    $this->EstadoTipoAntecedente = $value;
  }

  public function SetIdTipoAntecedente($value) {
    $this->idTipoAntecedente = $value;
  }

    public function ListarTipoAntecedente(){
      try {
          $sql = "CALL `spListarTipoantecedente`() ";
          $query = $this->_CONEXION->prepare($sql);
          if ($query->execute()) {
              return $query->fetchAll();
          }else{
            return null;
          }
      } catch (Exception $e) {
          return null;
      }

    }





}



 ?>

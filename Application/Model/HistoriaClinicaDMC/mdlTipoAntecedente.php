<?php

/**
 * Modelo mdlTipoAntecedente:
 * Este modelo pertenece y controla el
 * acceso a los datos de la tabla tbl_tipoantecedente
 * perteneciente al módulo historia Clinica
 */
class mdlTipoAntecedente implements iModel {

  private static $_INSTANCIA; // Instancia única de esta clase
  private $_CONEXION;         // Variable de conexión PDO

  # Atributos de la clase:
  private $descripcion;
  private $estadoTabla = 'Activo';
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
    $registroAntecedente = false;
    try {
      $ejecutador = $this->_CONEXION->prepare("CALL spRegistrarTipoantecedente(?,?)");
      $ejecutador->bindParam(1, $this->descripcion);
      $ejecutador->bindParam(2, $this->estadoTabla);
      $registroAntecedente = $ejecutador->execute();
    } catch (Exception $e) {
      die("Ha ocurrido un error: " . $e);
    }
    return $registroAntecedente;
  }

  public function ModificarTipoAntecedente() {
    $registroAntecedente = false;
    try {
      $ejecutador = $this->_CONEXION->prepare("CALL spModificarTipoantecedente(?,?)");
      $ejecutador->bindParam(1, $this->idTipoAntecedente);
      $ejecutador->bindParam(2, $this->descripcion);
      $registroAntecedente = $ejecutador->execute();
    } catch (Exception $e) {
      die("Ha ocurrido un error: " . $e);
    }
    return $registroAntecedente;
  }

  public function CambiarEstadoTipoAntecedente() {
    $registroAntecedente = false;
    try {
      $ejecutador = $this->_CONEXION->prepare("CALL spCambiarEstadoTipoantecedente(?,?)");
      $ejecutador->bindParam(1, $this->idTipoAntecedente);
      $ejecutador->bindParam(2, $this->estadoTabla);
      $registroAntecedente = $ejecutador->execute();
      $this->estadoTabla = 'Activo';
    } catch (Exception $e) {
      die("Ha ocurrido un error: " . $e);
    }
    return $registroAntecedente;
  }

  # Métodos Setter & Getter:

  public function SetDescripcionTipoAntecedente($value) {
    $this->descripcion = $value;
  }

  public function SetEstadoTipoAntecedente($value) {
    $this->estadoTabla = $value;
  }

  public function SetIdTipoAntecedente($value) {
    $this->idTipoAntecedente = $value;
  }

}


?>

<?php

/**
 * Modelo mdlTipoAntecedente:
 * Este modelo pertenece y controla el
 * acceso a los datos de la tabla tbl_tipoexamenfisico
 * perteneciente al módulo historia Clinica
 */
class mdlTipoExamenFisico implements iModel {

  private static $_INSTANCIA; // Instancia única de esta clase
  private $_CONEXION;         // Variable de conexión PDO

  # Atributos de la clase:
  private $descripcionExamenFisico;
  private $estadoTabla = 'Activo';
  private $idtipoExamenFisico;

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

  public function RegistrarTipoExamenFisico() {
    $registroExamenFisico = false;
    try {
      $ejecutador = $this->_CONEXION->prepare("CALL spRegistrarTipoexamenfisico(?,?)");
      $ejecutador->bindParam(1, $this->descripcionExamenFisico);
      $ejecutador->bindParam(2, $this->estadoTabla);
      $registroExamenFisico = $ejecutador->execute();
    } catch (Exception $e) {
      die("Ha ocurrido un error: " . $e);
    }
    return $registroExamenFisico;
  }

  public function ModificarTipoExamenFisico() {
    $registroExamenFisico = false;
    try {
      $ejecutador = $this->_CONEXION->prepare("CALL spModificarTipoexamenfisico(?,?)");
      $ejecutador->bindParam(1, $this->idtipoExamenFisico);
      $ejecutador->bindParam(2, $this->descripcionExamenFisico);
      $registroExamenFisico = $ejecutador->execute();
    } catch (Exception $e) {
      die("Ha ocurrido un error: " . $e);
    }
    return $registroExamenFisico;
  }

  public function CambiarEstadoTipoExamenFisico() {
    $registroExamenFisico = false;
    try {
      $ejecutador = $this->_CONEXION->prepare("CALL spCambiarEstadoTipoexamenfisico(?,?)");
      $ejecutador->bindParam(1, $this->idtipoExamenFisico);
      $ejecutador->bindParam(2, $this->estadoTabla);
      $registroExamenFisico = $ejecutador->execute();
      $this->estadoTabla = 'Activo';
    } catch (Exception $e) {
      die("Ha ocurrido un error: " . $e);
    }
    return $registroExamenFisico;
  }

  # Métodos Setter & Getter:

  public function SetDescripcionTipoExamenFisico($value) {
    $this->descripcionExamenFisico = $value;
  }

  public function SetEstadoTipoExamenFisico($value) {
    $this->estadoTabla = $value;
  }

  public function SetIdTipoExamenFisico($value) {
    $this->idtipoExamenFisico = $value;
  }

}


?>

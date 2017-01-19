<?php


class mdlTipoExamenEspecializado implements iModel {

  private static $_INSTANCIA; // Instancia única de esta clase
  private $_CONEXION;         // Variable de conexión PDO

  # Atributos de la clase:
  private $descripcion;
  private $estadoTabla = 'Activo';
  private $idTipoExamenEspecializado;

  # Constructor:
  private function __construct($_CON) {
    $this->_CONEXION = $_CON;
  }

 
  public static function getInstance($_CONEXION) {
    if (!self::$_INSTANCIA instanceof self) {
      self::$_INSTANCIA = new self($_CONEXION);
    }
    return self::$_INSTANCIA;
  }

  # Métodos y funciones de la clase:

  public function RegistrarTipoExamenEspecializado() {
    $registroExamenEspecializado = false;
    try {
      $ejecutador = $this->_CONEXION->prepare("CALL spRegistrarTipoexamenespecializado(?,?)");
      $ejecutador->bindParam(1, $this->descripcion);
      $ejecutador->bindParam(2, $this->estadoTabla);
      $registroExamenEspecializado = $ejecutador->execute();
    } catch (Exception $e) {
      die("Ha ocurrido un error: " . $e);
    }
    return $registroExamenEspecializado;
  }

  public function ModificarTipoExamenEspecializado() {
    $registroExamenEspecializado = false;
    try {
      $ejecutador = $this->_CONEXION->prepare("CALL spModificarTipoexamenespecializado(?,?)");
      $ejecutador->bindParam(1, $this->idTipoExamenEspecializado);
      $ejecutador->bindParam(2, $this->descripcion);
      $registroExamenEspecializado = $ejecutador->execute();
    } catch (Exception $e) {
      die("Ha ocurrido un error: " . $e);
    }
    return $registroExamenEspecializado;
  }

  public function CambiarEstadoTipoExamenEspecializado() {
    $registroExamenEspecializado = false;
    try {
      $ejecutador = $this->_CONEXION->prepare("CALL spCambiarEstadoTipoexamenespecializado (?,?)");
      $ejecutador->bindParam(1, $this->idTipoExamenEspecializado);
      $ejecutador->bindParam(2, $this->estadoTabla);
      $registroExamenEspecializado = $ejecutador->execute();
      $this->estadoTabla = 'Activo';
    } catch (Exception $e) {
      die("Ha ocurrido un error: " . $e);
    }
    return $registroExamenEspecializado;
  }

  # Métodos Setter & Getter:

  public function SetDescripcionTipoExamenEspecializado($value) {
    $this->descripcion = $value;
  }

  public function SetEstadoTipoExamenEspecializado($value) {
    $this->estadoTabla = $value;
  }

  public function SetIdTipoExamenEspecializado($value) {
    $this->idTipoExamenEspecializado = $value;
  }

}


?>

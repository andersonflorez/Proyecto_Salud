<?php


class mdlTipoTratamiento implements iModel {

  private static $_INSTANCIA; // Instancia única de esta clase
  private $_CONEXION;         // Variable de conexión PDO

  # Atributos de la clase:
  private $Descripcion;
  private $estadoTabla = 'Activo';
  private $idTipoTratamiento;
  private $categoriaItemTratamiento;
  private $categoriaTratamientoAph= null;

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
    $registroTratamiento = false;
    try {
      $ejecutador = $this->_CONEXION->prepare("CALL spRegistrarTipotratamiento(?,?,?,?)");
      $ejecutador->bindParam(1, $this->Descripcion);
      $ejecutador->bindParam(2, $this->categoriaTratamientoAph);
      $ejecutador->bindParam(3, $this->categoriaItemTratamiento);
      $ejecutador->bindParam(4, $this->estadoTabla);
      
      $registroTratamiento = $ejecutador->execute();
    } catch (Exception $e) {
      die("Ha ocurrido un error: " . $e);
    }
    return $registroTratamiento;
  }

  public function ModificarTipoTratamiento() {
    $registroTratamiento = false;
    try {
      $ejecutador = $this->_CONEXION->prepare("CALL spModificarTipotratamiento(?,?,?,?)");
      $ejecutador->bindParam(1, $this->idTipoTratamiento);
      $ejecutador->bindParam(2, $this->Descripcion);
      $ejecutador->bindParam(3, $this->categoriaTratamientoAph);
      $ejecutador->bindParam(4, $this->categoriaItemTratamiento);
      $registroTratamiento = $ejecutador->execute();
    } catch (Exception $e) {
      die("Ha ocurrido un error: " . $e);
    }
    return $registroTratamiento;
  }

  public function CambiarEstadoTipoTratamiento() {
    $registroTratamiento = false;
    try {
      $ejecutador = $this->_CONEXION->prepare("CALL spCambiarEstadoTipotratamiento(?,?)");
      $ejecutador->bindParam(1, $this->idTipoTratamiento);
      $ejecutador->bindParam(2, $this->estadoTabla);
      $registroTratamiento = $ejecutador->execute();
      $this->estadoTabla = 'Activo';
    } catch (Exception $e) {
      die("Ha ocurrido un error: " . $e);
    }
    return $registroTratamiento;
  }

  # Métodos Setter & Getter:

  public function SetDescripcionTipoTratamiento($value) {
    $this->Descripcion = $value;
  }

  public function SetEstadoTipoTratamiento($value) {
    $this->estadoTabla = $value;
  }

  public function SetIdTipoTratamiento($value) {
    $this->idTipoTratamiento = $value;
  }

  public function SetCategoriaTratamiento($value){
    $this->categoriaItemTratamiento = $value;
  }

   public function SetCategoriaAph($value){
    $this->categoriaTratamientoAph = $value;
  }

}


?>

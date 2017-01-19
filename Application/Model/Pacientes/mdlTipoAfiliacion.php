<?php

/**
* Modelo nombre_modelo:
* Escribe aqui una descripcion de lo que hace
* este modelo. Copia esta estructura básica y
* utilízala en todos los modelos que necesites
* crear. Todos los modelos deben tener esta
* estructura.
*/
class MdlTipoAfiliacion implements iModel {

  private static $_INSTANCIA; // Instancia única de esta clase
  private $_CONEXION;         // Variable de conexión PDO

  # Atributos de la clase:
  private $descripcionAfiliacion;
  private $estadoTabla = 'Activo';
  private $idTipoAfiliacion;

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

  public function RegistrarTipoAfiliacion()
  {
    $r = false;
    try {
      $ejecutador = $this->_CONEXION->prepare("CALL spRegistrarTipoafiliacion(?,?)");
      $ejecutador->bindParam(1, $this->descripcionAfiliacion);
      $ejecutador->bindParam(2, $this->estadoTabla);
      $r = $ejecutador->execute();
    } catch (Exception $e) {
      die("Ha ocurrido un error: " . $e);
    }
    return $r;
  }

  public function ModificarTipoAfiliacion()
  {
    $r = false;
    try {
      $ejecutador = $this->_CONEXION->prepare("CALL spModificarTipoafiliacion(?, ?)");
      $ejecutador->bindParam(1, $this->idTipoAfiliacion);
      $ejecutador->bindParam(2, $this->descripcionAfiliacion);
      $r = $ejecutador->execute();
    } catch (Exception $e) {
      die("Ha ocurrido un error: " . $e);
    }
    return $r;
  }

  public function CambiarEstadoTipoAfiliacion()
  {
    $r = false;
    try {
      $ejecutador = $this->_CONEXION->prepare("CALL spCambiarEstadoTipoafiliacion(?, ?)");
      $ejecutador->bindParam(1, $this->idTipoAfiliacion);
      $ejecutador->bindParam(2, $this->estadoTabla);
      $r = $ejecutador->execute();
      $this->estadoTabla = 'Activo';
    } catch (Exception $e) {
      die("Ha ocurrido un error: " . $e);
    }
    return $r;
  }

  /*Métodos Setter & Getter:*/

  public function SetdescripcionAfiliacion($value)
  {
    $this->descripcionAfiliacion = $value;
  }
  public function SetestadoTabla($value)
  {
    $this->estadoTabla = $value;
  }
  public function SetidTipoAfiliacion($value)
  {
    $this->idTipoAfiliacion = $value;
  }

}


?>

<?php

/**
 * Modelo mdltipodocumento:
 * Este modelo pertenece y controla el
 * acceso a los datos de la tabla tbl_enteexterno
 * perteneciente al módulo reporte inicial
 */
class MdlConfiguracionCita implements iModel {

  private static $_INSTANCIA; // Instancia única de esta clase
  private $_CONEXION;         // Variable de conexión PDO

  # Atributos de la clase:
  private $cantidadCitasDia;
  private $cantidadCitasMes;
  private $descripcionConfiguracion;
  private $fechaConfiguracion;
  private $estadoTabla = 'Activo';
  private $idConfiguracion;

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

  public function RegistrarConfiguracion() {
    $r = false;
    try {
      $ejecutador = $this->_CONEXION->prepare("CALL spRegistrarConfiguracion(?,?,?,?,?)");
      $ejecutador->bindParam(1, $this->cantidadCitasDia);
      $ejecutador->bindParam(2, $this->cantidadCitasMes);
      $ejecutador->bindParam(3, $this->descripcionConfiguracion);
      $ejecutador->bindParam(4, $this->fechaConfiguracion);
      $ejecutador->bindParam(5, $this->estadoTabla);
      $r = $ejecutador->execute();
    } catch (Exception $e) {
      die("Ha ocurrido un error: " . $e);
    }
    return $r;
  }

  public function ModificarConfiguracion() {
    $r = false;
    try {
      $ejecutador = $this->_CONEXION->prepare("CALL spModificarConfiguracion(?,?,?,?,?)");
      $ejecutador->bindParam(1, $this->cantidadCitasDia);
      $ejecutador->bindParam(2, $this->cantidadCitasMes);
      $ejecutador->bindParam(3, $this->descripcionConfiguracion);
      $ejecutador->bindParam(4, $this->fechaConfiguracion);
      $ejecutador->bindParam(5, $this->idConfiguracion);
      $r = $ejecutador->execute();
    } catch (Exception $e) {
      die("Ha ocurrido un error: " . $e);
    }
    return $r;
  }

  public function CambiarEstadoConfiguracion() {
    $r = false;
    try {
      $ejecutador = $this->_CONEXION->prepare("CALL spCambiarEstadoConfiguracion(?, ?)");
      $ejecutador->bindParam(1, $this->idConfiguracion);
      $ejecutador->bindParam(2, $this->estadoTabla);
      $r = $ejecutador->execute();
      $this->EstadoEnteExterno = 'Activo';
    } catch (Exception $e) {
      die("Ha ocurrido un error: " . $e);
    }
    return $r;
  }

  # Métodos Setter & Getter:

  public function SetcantidadCitasDia($value) {
    $this->cantidadCitasDia = $value;
  }
  public function SetcantidadCitasMes($value) {
    $this->cantidadCitasMes = $value;
  }
  public function SetdescripcionConfiguracion($value) {
    $this->descripcionConfiguracion = $value;
  }
  public function SetfechaConfiguracion($value) {
    $this->fechaConfiguracion = $value;
  }
  public function SetEstadoConfiguracion($value) {
    $this->estadoTabla = $value;
  }
  public function SetidConfiguracion($value) {
    $this->idConfiguracion = $value;
  }
}


?>

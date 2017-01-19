<?php

class MdlCertificadoAtencion implements iModel{
  private static $_INSTANCIA; // Instancia única de esta clase
  private $_CONEXION;         // Variable de conexión PDO

  # Atributos de la clase:
  private $descripcionCertificadoAtencion;
  private $estadoTabla = 'Activo';
  private $idCertificadoAtencion;

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
  public function RegistrarCertificadosAtencion() {
    $registrar= false;
    try {
      $ejecutador = $this->_CONEXION->prepare("CALL spRegistrarCertificadoatencion(?,?)");
      $ejecutador->bindParam(1, $this->descripcionCertificadoAtencion);
      $ejecutador->bindParam(2, $this->estadoTabla);
      $registrar = $ejecutador->execute();
    }catch (Exception $e) {
      die("Ha ocurrido un error: " . $e);
    }
    return $registrar;

  }

  public function ModificarCertificadosAtencion() {
    $r = false;
    try {
      $ejecutador = $this->_CONEXION->prepare("CALL spModificarCertificadoatencion(?, ?)");
      $ejecutador->bindParam(1, $this->idCertificadoAtencion);
      $ejecutador->bindParam(2, $this->descripcionCertificadoAtencion);
      $r = $ejecutador->execute();
    } catch (Exception $e) {
      die("Ha ocurrido un error: " . $e);
    }
    return $r;

  }


    public function CambiarEstadoCertificadoAtencion() {
      $r = false;
      try {
        $ejecutador = $this->_CONEXION->prepare("CALL spCambiarEstadoCertificadoatencion(?, ?)");
        $ejecutador->bindParam(1, $this->idCertificadoAtencion);
        $ejecutador->bindParam(2, $this->estadoTabla);
        $r = $ejecutador->execute();
        $this->estadoTabla = 'Activo';
      } catch (Exception $e) {
        die("Ha ocurrido un error: " . $e);
      }
      return $r;
    }







  # Métodos Setter & Getter:

  public function SetDescripcionCertificadoAtencion($value) {
    $this->descripcionCertificadoAtencion = $value;
  }

  public function SetEstadoCertificadoAtencion($value) {
    $this->estadoTabla = $value;
  }

  public function SetIdCertificadoAtencion($value) {
    $this->idCertificadoAtencion = $value;
  }
}




 ?>

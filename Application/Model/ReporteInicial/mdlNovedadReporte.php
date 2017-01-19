<?php

/**
* Modelo mdlTipoEvento:
* Este modelo pertenece y controla el
* acceso a los datos de la tabla tbl_novedadreporteinicial
* perteneciente al módulo reporte inicial
*/
class mdlNovedadReporte implements iModel {

  private static $_INSTANCIA; // Instancia única de esta clase
  private $_CONEXION;         // Variable de conexión PDO

  # Atributos de la clase:
  private $idNovedad;
  private $descripcionNovedad;
  private $idReporteInicial;

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

  public function RegistrarNovedadReporteInicial() {
    $r = false;
    try {
      $ejecutador = $this->_CONEXION->prepare("CALL spRegistrarNovedadreporteinicial(?,?)");
      $ejecutador->bindParam(1, $this->idReporteInicial);
      $ejecutador->bindParam(2, $this->descripcionNovedad);
      $ejecutador->execute();
      $r = $ejecutador->rowCount() > 0;
    } catch (Exception $e) {
      die("Ha ocurrido un error: " . $e);
    }
    return $r;
  }

  public function ConsultarNovedadesReporteInicial()
  {
    $r = null;
    try {
      $ejecutador = $this->_CONEXION->prepare("CALL spConsultarNovedadreporteinicial(?)");
      $ejecutador->bindParam(1, $this->idReporteInicial);
      $ejecutador->execute();
      if ($ejecutador->rowCount() > 0) {
        $r = $ejecutador->fetchAll();
      }
    } catch (Exception $e) {
      die("Ha ocurrido un error: " . $e);
    }
    return $r;
  }

  # Métodos Setter & Getter:

  public function __GET($var) {
    return $this->$var;
  }

  public function __SET($var, $val) {
    $this->$var = $val;
  }

}


?>

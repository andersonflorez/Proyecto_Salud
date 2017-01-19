<?php
/**
 * Modelo mdlCategoriaRecurso:
 * Este modelo pertenece y controla el
 * acceso a los datos de la tabla tbl_categoriarecurso
 * perteneciente al módulo reporte inicial
 */
class mdlCategoriaRecurso implements iModel {

  private static $_INSTANCIA; // Instancia única de esta clase
  private $_CONEXION;         // Variable de conexión PDO

  # Atributos de la clase:
  private $descripcionCategoriarecurso;
  private $estadoTabla = 'Activo';
  private $idCategoriaRecurso;

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

  public function RegistrarCategoriaRecurso() {
    $r = false;
    try {
      $ejecutador = $this->_CONEXION->prepare("CALL spRegistrarCategoriarecurso(?,?)");
      $ejecutador->bindParam(1, $this->descripcionCategoriarecurso);
      $ejecutador->bindParam(2, $this->estadoTabla);
      $r = $ejecutador->execute();
    } catch (Exception $e) {
      die("Ha ocurrido un error: " . $e);
    }
    return $r;
  }

  public function ModificarCategoriarecurso() {
    $r = false;
    try {
      $ejecutador = $this->_CONEXION->prepare("CALL spModificarCategoriarecurso(?, ?)");
      $ejecutador->bindParam(1, $this->idCategoriaRecurso);
      $ejecutador->bindParam(2, $this->descripcionCategoriarecurso);
      $r = $ejecutador->execute();
    } catch (Exception $e) {
      die("Ha ocurrido un error: " . $e);
    }
    return $r;
  }

  public function CambiarEstadoCategoriarecurso() {
    $r = false;
    try {
      $ejecutador = $this->_CONEXION->prepare("CALL spCambiarEstadoCategoriarecurso(?, ?)");
      $ejecutador->bindParam(1, $this->idCategoriaRecurso);
      $ejecutador->bindParam(2, $this->estadoTabla);
      $r = $ejecutador->execute();
      $this->estadoTabla = 'Activo';
    } catch (Exception $e) {
      die("Ha ocurrido un error: " . $e);
    }
    return $r;
  }
  # Métodos Setter & Getter:
  public function SetDescripcionCategoriarecurso($value) {
    $this->descripcionCategoriarecurso = $value;
  }
  public function SetEstadoTabla($value) {
    $this->estadoTabla = $value;
  }
  public function SetIdCategoriaRecurso($value) {
    $this->idCategoriaRecurso = $value;
  }
}
?>

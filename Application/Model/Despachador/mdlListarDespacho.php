<?php

/**
 * Modelo mdlListarDespacho:
 * Este modelo pertenece y controla el
 * acceso a los datos de la tabla tbl_Despacho
 * perteneciente al módulo Despachador
 */
class mdlListarDespacho implements iModel {

  private static $_INSTANCIA; // Instancia única de esta clase
  private $_CONEXION;         // Variable de conexión PDO

  # Atributos de la clase:
  private $idDespacho;

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

  public function listarDespacho(){
    $sql = "call spListarDespacho()";
    $query = $this->_CONEXION->prepare($sql);

    if ($query->execute()) {
    return $query->fetchAll();
  }else{
    return 'no estoy ejecutando';
  }
  }

  public function datosReporte(){
      $sql = "call spInfoReporteDespacho(?)";
    $query = $this->_CONEXION->prepare($sql);
    $query->bindParam(1, $this->idDespacho);
    if ($query->execute()) {
    return $query->fetch();
  }else{
    return 'no estoy ejecutando';
  }
  }

  # Métodos Setter & Getter:

  public function SetIdDespacho($value) {
    $this->idDespacho = $value;
  }

}


?>

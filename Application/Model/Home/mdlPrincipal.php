<?php

/**
* Modelo del main Principal:
* Este modelo se encarga de
*/

class mdlPrincipal implements iModel {

  private static $_INSTANCIA; // Instancia única de esta clase
  private $_CONEXION;         // Variable de conexión PDO

  # Métodos Setter & Getter:

  public function __SET($atributo, $valor){
    $this->$atributo = $valor;
  }

  public function __GET($atributo){
    return $this->$atributo;
  }

  # Constructor:
  private function __construct($_CON){

    try {
      $this->_CONEXION = $_CON;
    } catch (PDOException $e) {
      exit('Error al intentar conectar con la Base de Datos: ' + $e);
    }

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

}

?>

<?php

/**
 * Modelo ModelNombreModelo:
 * Escribe aqui una descripcion de lo que hace
 * este modelo. Copia esta estructura básica y
 * utilízala en todos los modelos que necesites
 * crear. Todos los modelos deben tener esta
 * estructura.
 */
class ModelNombreModelo implements iModel {

  private static $_INSTANCIA; // Instancia única de esta clase
  private $_CONEXION;         // Variable de conexión PDO

  # Atributos de la clase:
  // ...

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

  // ...

  # Métodos Setter & Getter:

  // ...

}


?>

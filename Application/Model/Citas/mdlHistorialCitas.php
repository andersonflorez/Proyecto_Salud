<?php

/**
 * Modelo nombre_modelo:
 * Escribe aqui una descripcion de lo que hace
 * este modelo. Copia esta estructura básica y
 * utilízala en todos los modelos que necesites
 * crear. Todos los modelos deben tener esta
 * estructura.
 */
class MdlHistorialCitas implements iModel {

  private static $_INSTANCIA; // Instancia única de esta clase
  private $_CONEXION;         // Variable de conexión PDO

  private $_idCita;

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
  function __GET($atributo){
    return $this->$atributo;
  }
  function __SET($atributo,$valor){
    $this->$atributo = $valor;
  }

  public function ListarCitasTotal(){
    $sql = "CALL spHistorialCitas()";
    $query = $this->_CONEXION->prepare($sql);
    if ($query->execute()) {
        return $query->fetchAll();
    }else {
      return false;
    }
  }
  public function ConsultarPersonalAsis(){
    $idCita=$this->__GET("_idCita");
    $sql = "CALL spConsultarPersonalAsistencial(?)";
    $query = $this->_CONEXION->prepare($sql);
    $query->bindParam(1, $idCita);
    if ($query->execute()) {
        return $query->fetchAll();
    }else {
      return false;
    }
  }
}

?>

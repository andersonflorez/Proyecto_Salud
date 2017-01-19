<?php

/**
* Modelo nombre_modelo:
* Escribe aqui una descripcion de lo que hace
* este modelo. Copia esta estructura básica y
* utilízala en todos los modelos que necesites
* crear. Todos los modelos deben tener esta
* estructura.
*/
class MdlPacienteInicial implements iModel {

  private static $_INSTANCIA; // Instancia única de esta clase
  private $_CONEXION;         // Variable de conexión PDO

  # Atributos de la clase:
  // ...
  private $_idPaciente;
  private $_idEstadoPaciente;
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
  function __GET($atributo){
    return $this->$atributo;
  }
  function __SET($atributo,$valor){
    $this->$atributo = $valor;
  }
  // ...


  public function consultaPaciente(){

    $sql = "CALL spListarPacienteInnerJ()";
    $query = $this->_CONEXION->prepare($sql);
    if ($query->execute()) {
      return $query->fetchAll();
    }else {
      return null;
    }
  }


  public function CambiarEstadoPaciente(){
  $idEstadoPaciente=$this->__GET("_idEstadoPaciente");
  $idPaciente=$this->__GET("_idPaciente");
  $sql = "CALL spCambiarEstadoPaciente(?,?)";
  $query = $this->_CONEXION->prepare($sql);
  $query->bindParam(1, $idPaciente, PDO::PARAM_INT);
  $query->bindParam(2, $idEstadoPaciente, PDO::PARAM_INT);
  $query->execute();

   if ($query->rowCount() > 0) {
      return true;
    } else {
      return false;
    }
  }


}


?>

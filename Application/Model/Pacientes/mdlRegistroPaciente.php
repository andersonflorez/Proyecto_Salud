<?php

/**
* Modelo nombre_modelo:
* Escribe aqui una descripcion de lo que hace
* este modelo. Copia esta estructura básica y
* utilízala en todos los modelos que necesites
* crear. Todos los modelos deben tener esta
* estructura.
*/
class MdlRegistroPaciente implements iModel {

  private static $_INSTANCIA; // Instancia única de esta clase
  private $_CONEXION;         // Variable de conexión PDO

  # Atributos de la clase:
  // ...
  private $_DatosPaciente;
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
  function InsertarDatosPaciente (){
    $array=$this->__GET("_DatosPaciente");
    $sql = "CALL spRegistrarPaciente(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    $query = $this->_CONEXION->prepare($sql);
    $query->bindParam(1,$array[0]);
    $query->bindParam(2,$array[1]);
    $query->bindParam(3,$array[2]);
    $query->bindParam(4,$array[3]);
    $query->bindParam(5,$array[4]);
    $query->bindParam(6,$array[5]);
    $query->bindParam(7,$array[6]);
    $query->bindParam(8,$array[7]);
    $query->bindParam(9,$array[8]);
    $query->bindParam(10,$array[9]);
    $query->bindParam(11,$array[10]);
    $query->bindParam(12,$array[11]);
    $query->bindParam(13,$array[12]);
    $query->bindParam(14,$array[13]);
    $query->bindParam(15,$array[14]);
    $query->bindParam(16,$array[15]);
    $query->bindParam(17,$array[16]);
    $query->bindParam(18,$array[17]);
    $query->bindParam(19,$array[18]);
    $query->bindParam(20,$array[19]);
    $query->bindParam(21,$array[20]);
    $query->bindParam(22,$array[21]);
    $query->bindParam(23,$array[22]);
    $query->bindParam(24,$array[23]);
    if ($query->execute()) {
      return true;
    }else{
      return false;
    }
  }

  # Métodos Setter & Getter:

  public function listarComboTipoDocumento(){
    $sql = "CALL spListarTipodocumento()";
    $query = $this->_CONEXION->prepare($sql);

    if ($query->execute()) {
      return $query->fetchAll();
    }else{
      return false;
    }
  }


  public function listarComboTipoAfiliacion(){
    $sql = "CALL spListarTipoafiliacion()";
    $query = $this->_CONEXION->prepare($sql);

    if ($query->execute()) {
      return $query->fetchAll();
    }else {
      return false;
    }
  }

  public function listarComboEstadoP(){
    $sql = "CALL spListarEstadopaciente()";
    $query = $this->_CONEXION->prepare($sql);

    if ($query->execute()) {
      return $query ->fetchAll();
    }else{
      return false;
    }
  }

  public function validarDocumento($numeroDocumento){
    $sql = "CALL spvalidarDocumento(?)";
    $query = $this->_CONEXION->prepare($sql);
    $query->bindParam(1, $numeroDocumento);

    if ($query->execute()) {
      return $query->fetchAll();
    }else {
      return false;
    }

  }

  public function consultaPacienteD($numeroDocumento){
    $sql = "CALL spConsultarPacienteDocumento(?)";
    $query = $this->_CONEXION->prepare($sql);
$query->bindParam(1, $numeroDocumento);
    if($query->execute()){
      return $query ->fetchAll();
    }else {
      return false;
    }
  }
}


?>

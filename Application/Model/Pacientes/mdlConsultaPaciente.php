<?php

/**
* Modelo nombre_modelo:
* Escribe aqui una descripcion de lo que hace
* este modelo. Copia esta estructura básica y
* utilízala en todos los modelos que necesites
* crear. Todos los modelos deben tener esta
* estructura.
*/
class MdlConsultaPaciente
implements iModel {

  private static $_INSTANCIA; // Instancia única de esta clase
  private $_CONEXION;         // Variable de conexión PDO

  # Atributos de la clase:
  // ...
  private $_DatosPaciente;
  private $_idPaciente;
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
  function __GET($atributo){
    return $this->$atributo;
  }
  function __SET($atributo,$valor){
    $this->$atributo = $valor;
  }

  function ConsultaDatos(){
    $codigo=$this->__GET("_idPaciente");
    $sql = "CALL spConsultarPacienteDomiciliaria(?)";
    $query = $this->_CONEXION->prepare($sql);
    $query->bindParam(1,$codigo);
    if ($query->execute()) {
      return $query->fetch();
    }else{
      return null;
    }
  }

  function actualizarDatosPaciente(){
    $datosP=$this->__GET("_DatosPaciente");

    $sql = "CALL spModificarPaciente(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    $query = $this->_CONEXION->prepare($sql);
    for ($i=0; $i < count($datosP); $i++) {
      $query->bindParam($i+1,$datosP[$i]);
    }
    if ($query->execute()) {
      return true;
    }else{
      return false;
    }
  }

  function ConsultaTipoIdentificacion(){
    $sql = "CALL spListarTipodocumento()";
    $query = $this->_CONEXION->prepare($sql);
    if ($query->execute()) {
      return $query->fetchAll();
    }else{
      return false;
    }
  }

  public function ConsultarTipoAfiliado(){
    $sql = "CALL spListarTipoafiliacion()";
    $query = $this->_CONEXION->prepare($sql);
    if ($query->execute()) {
      return $query->fetchAll();
    }else {
      return false;
    }
  }

  public function ConsultarEstadoPaciente(){
    $sql = "CALL spListarEstadopaciente()";
    $query = $this->_CONEXION->prepare($sql);
    if ($query->execute()) {
      return $query->fetchAll();
    }else {
      return false;
    }

  }

  public function CambiarEtadoPaciente($idPaciente){
    $sql = "update tbl_paciente set idEstadoPaciente = '1' where idPaciente = :idPaciente";
    $query = $this->_CONEXION->prepare($sql);
    $query->bindParam(":idPaciente",$idPaciente);
    $query->execute();
  }

}


?>

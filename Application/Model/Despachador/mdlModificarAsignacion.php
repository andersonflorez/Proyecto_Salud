<?php

/**
* Modelo nombre_modelo:
* Escribe aqui una descripcion de lo que hace
* este modelo. Copia esta estructura básica y
* utilízala en todos los modelos que necesites
* crear. Todos los modelos deben tener esta
* estructura.
*/
class mdlModificarAsignacion implements iModel {

  private static $_INSTANCIA; // Instancia única de esta clase
  private $_CONEXION;         // Variable de conexión PDO
  private $_idAsignacion;
  private $_idAmbulancia;
  private $_fechaHora;
  private $_longitud;
  private $_latitud;
  private $_idPersona;
  private $_idDetalle;


  # Atributos de la clase:
  // ...

  # Constructor:
  private function __construct($_CON) {
    try {
      $this->_CONEXION = $_CON;
    } catch (Exception $e) {
      exit('Error al intentar conectar con la base de datos en mdlAsignacionPersonal'+e);
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

  public function __GET($atributo){
    return $this->$atributo;
  }
  public function __SET($atributo,$valor){
    $this->$atributo = $valor;
  }

  public function ConsultarPersonal(){
    //var_dump($_POST);
    $_idAmbulancia = $this->__GET("_idAmbulancia");
    $sql = "CALL spConsultaParametrizadaAsignacionAmbulancia(?)";
    $query = $this->_CONEXION->prepare($sql);
    $query->bindParam(1,$_idAmbulancia);
    if ($query->execute()) {
      return $query->fetchAll();
    }else{
      return false;
    }
  }

  public function ListarCombosPersona(){
    $sql = "CALL spListarPersonalAmbulancia()";
    $query = $this->_CONEXION->prepare($sql);
    if ($query->execute()) {
      return $query->fetchAll();
    }else{
      return false;
    }
  }

  public function ConsultarTipoAmbulancia(){
    $_idAmbulancia = $this->__GET("_idAmbulancia");
    $sql = "CALL spConsultarTipoAmbulancia(?)";
    $query = $this->_CONEXION->prepare($sql);
    $query->bindParam(1,$_idAmbulancia,PDO::PARAM_INT);
    if ($query->execute()) {
      return $query->fetch();
    }else{
      return false;
    }
  }

  public function ConsultarEspecialidadPersona(){
    $_idPersona = $this->__GET("_idPersona");
    $sql = "CALL spConsultarEspecialidadPersona(?)";
    $query = $this->_CONEXION->prepare($sql);
    $query->bindParam(1,$_idPersona,PDO::PARAM_STR);
    if ($query->execute()) {
      return $query->fetch();
    }else{
      return false;
    }
  }

  public function ModificarDetalleAsignacion(){
    $_idPersona = $this->__GET("_idPersona");
    $_idDetalle = $this->__GET("_idDetalle");
    $_idAmbulancia = $this->__GET("_idAmbulancia");
    $sql = "CALL spModificarDetalleAsignacion(?,?,?)";
    $query = $this->_CONEXION->prepare($sql);
    $query->bindParam(1,$_idPersona);
    $query->bindParam(2,$_idDetalle);
    $query->bindParam(3,$_idAmbulancia);
    if ($query->execute()) {
      return true;
    }else{
      return false;
    }
  }
  public function ModificarAsignacion(){
    $_idAsignacion = $this->__GET("_idAsignacion");
    $_idAmbulancia = $this->__GET("_idAmbulancia");
    $_fechaHora = $this->__GET("_fechaHoraAsignacion");
    $_longitud = $this->__GET("_longitud");
    $_latitud = $this->__GET("_latitud");
    $sql = "CALL spModificarAsignacionpersonal(?,?,?,?,?)";
    $query = $this->_CONEXION->prepare($sql);
    $query->bindParam(1,$_idAsignacion);
    $query->bindParam(2, $_idAmbulancia);
    $query->bindParam(3, $_fechaHora);
    $query->bindParam(4, $_longitud);
    $query->bindParam(5, $_latitud);
    if ($query->execute()) {
      return true;
    }else{
      return false;
    }
  }

  public function ActualizarEstadoDetalleAsignacion(){
    $_idPersona = $this->__GET("_idPersona");
    $sql = "CALL spActualizarEstadoDetalleAsignacion(?)";
    $query = $this->_CONEXION->prepare($sql);
    $query->bindParam(1, $_idPersona);
    if ($query->execute()) {
      return true;
    }else{
      return false;
    }
  }

}


?>

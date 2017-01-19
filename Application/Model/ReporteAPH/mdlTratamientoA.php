<?php

/**
* Modelo mdlTratamientoB:
* Este modelo se encarga del CRUD basico para la tabla de tratamiento Basico >
* tratamiento basico del Modulo ReporteAPH
*/
class mdlTratamientoA implements iModel{

  private static $_INSTANCIA; // Instancia única de esta clase
  private $_CONEXION;         // Variable de conexión PDO
  private $_idReporteAPH;
  private $_valor;
  private $_idTipoTratamiento;
  private $_horaDesfibrilacion;
  private $_joules;
  private $_mdlTratamientoA;


  /**
  * @param $db  objeto de la conección a la DB que recibe cuando se ejecuta la instancia.
  */

  # Constructor:
  function __construct($_CON){
    try {
      $this->_CONEXION = $_CON;
    } catch (PDOException $e) {
      exit('Error al intentar conectar con la Base de Datos en mdlTratamienA:' + $e);
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
  function __GET($atributo){
    return $this->$atributo;
  }
  function __SET($atributo, $valor){
    $this->$atributo = $valor;
  }

  # Métodos y funciones de la clase:

  /**
  * Listar todos los tipos de tratamiento
  */
  public function ListarTratamientoA() {
    $sql      = "CALL spListarTratamientoA();";
    $query    = $this->_CONEXION->prepare($sql);
    $query->execute();
    return $query->fetchAll();
  }
  public function RegistrarAutorizacionModelo() {
    $arrayAutorizacion = $this->__GET("datosAutorizacion");
    $sql               = "CALL spRegistrarTemporalAutorizacion(?,?,?,?,?,?,?);";
    $query             = $this->_CONEXION->prepare($sql);
    for ($i=0; $i < count($arrayAutorizacion); $i++) {
      $query->bindParam($i+1,$arrayAutorizacion[$i]);
    }
    if ($query->execute()) {
      return true;
    }else{
      return false;
    }
  }

  public function ActualizarTemporal(){
    $arrayActualizarAutorizacion = $this->__GET("datosActualizarAutorizacion");
    $sql                         = "Call SpActualizarEstadoTemporal(?,?)";
    $query                       = $this->_CONEXION->prepare($sql);
    for ($i=0; $i < count($arrayActualizarAutorizacion); $i++) {
      $query->bindParam($i+1,$arrayActualizarAutorizacion[$i]);
    }
    if ($query->execute()) {
      return true;
    }else{
      return false;
    }
  }

  //Listar Solicitudes de autorizacion
  function ListarAutorizacion($codigo,$tipo,$cedula){
      $sql ="CALL spListarTemporalAutorizacion(?,?,?)";
      $query = $this->_CONEXION->prepare($sql);
        $query->bindParam(1,$codigo);
        $query->bindParam(2,$tipo);
        $query->bindParam(3,$cedula);
      if($query->execute()){
          return $query->fetchAll();
      }else {
          return null;
      }
  }

  //Valida el tipo de ambulancia
  function registrarAutorizacionMedicalizada($tipo,$idSesion,$descripcion,$fecha,$id,$cedula,$resultado){
    if ($resultado != null ) {
      $sql = "CALL spRegistrarAutorizacionMedicalizada(?,?,?,?,?,?,?)";
      $query = $this->_CONEXION->prepare($sql);
      $query->bindParam(1,$tipo);
      $query->bindParam(2,$idSesion,PDO::PARAM_INT);
      $query->bindParam(3,$resultado,PDO::PARAM_INT);
      $query->bindParam(4,$id,PDO::PARAM_INT);
      $query->bindParam(5,$descripcion);
      $query->bindParam(6,$cedula);
      $query->bindParam(7,$fecha);
      if ($query->execute()) {
        return true;
      }else{
        return false;
      }
    }else{
      return false;
    }


  }


  //Valida el tipo de ambulancia
  function ValidarTipoAmbulancia($codigo){
    $sql ="CALL spValidarTipoAmbulancia(?)";
    $query = $this->_CONEXION->prepare($sql);
      $query->bindParam(1,$codigo);
    $query->execute();
    return $query->fetchall();
  }
  function RegistrarTratamientoaph(){
    try {
      $idReporteAph =$this->__GET("_idReporteAPH");
      $valor = $this->__GET("_valor");
      $idTipoTratamiento = $this->__GET("_idTipoTratamiento");
      $sql = "CALL spRegistrarTratamientoaph(?,?,?)";
      $query = $this->_CONEXION->prepare($sql);
      $query->bindParam(1, $idReporteAph, PDO::PARAM_STR);
      $query->bindParam(2, $valor, PDO::PARAM_STR);
      $query->bindParam(3, $idTipoTratamiento, PDO::PARAM_STR);
      if ($query->execute()) {
        return true;
      }else{
        return false;
      }
    } catch (Exception $e) {
      return false;
    }

  }
  function registrarDesfibrilacion(){
    try {
        $idReporteAPH = $this->__GET("_idReporteAPH");
        $horaDesfibrilacion = $this->__GET("_horaDesfibrilacion");
        $joules = $this->__GET("_joules");
        $sql = "CALL spRegistrarDesfibrilacion(?,?,?)";
        $query = $this->_CONEXION->prepare($sql);
        $query->bindParam(1, $idReporteAPH, PDO::PARAM_STR);
        $query->bindParam(2, $horaDesfibrilacion, PDO::PARAM_STR);
        $query->bindParam(3, $joules, PDO::PARAM_STR);
        if ($query->execute()) {
            return true;
        }else{
            return false;
        }
    } catch (Exception $e) {
            return false;
    }

  }


}

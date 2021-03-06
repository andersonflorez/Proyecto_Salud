<?php

/**
* Modelo mdlTratamientoB:
* Este modelo se encarga del CRUD basico para la tabla de tratamiento Basico >
* tratamiento basico del Modulo ReporteAPH
*/
class mdlTratamienB implements iModel{

  private static $_INSTANCIA; // Instancia única de esta clase
  private $_CONEXION;         // Variable de conexión PDO
  private $_idReporteAPH;
  private $_valor;
  private $_idTipoTratamiento;


  /**
  * @param $db  objeto de la conección a la DB que recibe cuando se ejecuta la instancia.
  */

  # Constructor:
  function __construct($_CON){
    try {
      $this->_CONEXION = $_CON;
    } catch (PDOException $e) {
      exit('Error al intentar conectar con la Base de Datos en mdlTratamienB:' + $e);
    }
  }


    function __GET($atributo){
      return $this->$atributo;
    }
  function __SET($atributo, $valor){
    $this->$atributo = $valor;
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

  /**
  * Listar todos los tipos de tratamiento
  */
  public function ListarTratamientoB() {

    $sql = "CALL spListarTratamientoB();";
    $query = $this->_CONEXION->prepare($sql);
    $query->execute();

    return $query->fetchAll();
  }


   public function RegistrarAutorizacionModelo($idParamedico,$idReporte,$idTipoTratamiento,$descripcion,$cedula,$estado,$horaEnvio) {

    $sql = "CALL spRegistrarTemporalAutorizacion(?,?,?,?,?,?,?);";
    $query = $this->_CONEXION->prepare($sql);
    $query->bindParam(1, $idParamedico);
    $query->bindParam(2, $idReporte);
    $query->bindParam(3, $idTipoTratamiento);
    $query->bindParam(4, $descripcion);
    $query->bindParam(5, $cedula);
    $query->bindParam(7, $horaEnvio);
    $query->bindParam(6, $estado);

    if ($query->execute()) {
      return true;
    }else{
      return false;

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

  public function ActualizarTemporal($FechaEnvio, $cedula){
    $sql = "Call SpActualizarEstadoTemporal(?,?)";
    $query = $this->_CONEXION->prepare($sql);
    $query->bindParam(2, $FechaEnvio);
    $query->bindParam(1, $cedula);
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



  function ListarRespuestaNotificacion(){

      $sql ="CALL spConsultarRespuestaNotificacionTemporal()";
      $query = $this->_CONEXION->prepare($sql);
      if($query->execute()){
          return $query->fetchAll();
      }else {
          return null;
      }
  }



}

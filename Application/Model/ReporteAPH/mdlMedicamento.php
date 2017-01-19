<?php

class mdlMedicamento implements iModel{
  private static $_INSTANCIA; // Instancia única de esta clase
  private $_CONEXION;         // Variable de conexión PDO
  private $_idReporteAPH;
  private $_dosis;
  private $_hora;
  private $_viaAdministracion;
  private $_cantidadUnidades;
  private $_idDetallekit;
  private $_idHistoriaClinica;

  # Constructor:
  private function __construct($_CON) {
    $this->_CONEXION = $_CON;
  }

  public function __GET($atributo){
    return $this->$atributo;
  }
  public function __SET($atributo, $valor){
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




  //codigo para consulta medicamento
  public function listarMedicamento_id($idPersona){
    $sql = "CALL spConsultarIdAmbulancia(?)";
    $query = $this->_CONEXION->prepare($sql);
    $query->bindParam(1,$idPersona,PDO::PARAM_INT);
    $query->execute();
    $idResultado = $query->fetch()->idAmbulancia;
    $sql = "CALL spListarMedicamentoAmbulancia(?)";
    $query = $this->_CONEXION->prepare($sql);
    $query->bindParam(1,$idResultado,PDO::PARAM_INT);
    $query->execute();
    return $query->fetchAll();

  }



  public function registrarMedicamento(){
    try {
      $idReporteAph = $this->__GET("_idReporteAPH");
      $dosis = $this->__GET("_dosis");
      $hora = $this->__GET("_hora");
      $viaAdministracion = $this->__GET("_viaAdministracion");
      $cantidadUnidades = $this->__GET("_cantidadUnidades");
      $idDetallekit = $this->__GET("_idDetallekit");
      $idHistoriaClinica = $this->__GET("_idHistoriaClinica");
      $sql ="CALL spRegistrarMedicamento(?,?,?,?,?,?,?)";
      $query = $this->_CONEXION->prepare($sql);
      $query->bindparam(1, $idReporteAph, PDO::PARAM_STR);
      $query->bindparam(2, $dosis, PDO::PARAM_STR);
      $query->bindparam(3, $hora, PDO::PARAM_STR);
      $query->bindparam(4, $viaAdministracion, PDO::PARAM_STR);
      $query->bindparam(5, $cantidadUnidades, PDO::PARAM_STR);
      $query->bindparam(6, $idDetallekit, PDO::PARAM_STR);
      $query->bindparam(7, $idHistoriaClinica, PDO::PARAM_STR);
      if ($query->execute()) {
        return true;
      }else{
        return false;
      }
    } catch (Exception $e) {
      return false;
    }

  }

  //Valida el tipo de ambulancia
  function registrarAutorizacionMedicalizada($tipo,$idSesion,$usuario,$clave,$descripcion,$fecha,$id,$cedula){
    $sql ="CALL spAutenticarMedico(?,?)";
    $query = $this->_CONEXION->prepare($sql);
    $query->bindParam(1,$usuario);
    $query->bindParam(2,$clave);
    $query->execute();
    $resultado = $query->fetch()->idUsuario;
    if ($resultado != null ) {
      //call spRegistrarAutorizacionMedicalizada('TRATAMIENTO',14,2,3,'descripcion','NN', '2016-05-31 16:52:38','2016-05-31 16:52:38')
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


  public function RegistrarAutorizacionModelo($idParamedico,$idMedicamento,$descripcion,$cedula,$estado,$horaEnvio) {

   $sql = "CALL spRegistrarTemporalautorizacionMedicamento(?,?,?,?,?,?);";
   $query = $this->_CONEXION->prepare($sql);
   $query->bindParam(1, $idParamedico);
   $query->bindParam(2, $idMedicamento);
   $query->bindParam(3, $descripcion);
   $query->bindParam(4, $cedula);
   $query->bindParam(6, $horaEnvio);
   $query->bindParam(5, $estado);

   if ($query->execute()) {
     return true;
   }else{
     return false;

   }
 }

 //Listar Solicitudes de autorizacion
 function ListarAutorizacion($codigo,$tipo,$cedula){
     $sql ="CALL spListarTemporalautorizacionMedicamento(?,?,?)";
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

public function consultarAllAutorizacion($idPersonal,$cedula,$idReporteAPH){
  $sql = "CALL listarAllAutorizacion(?,?)";
  $query = $this->_CONEXION->prepare($sql);
  $query->bindParam(1,$idPersonal);
  $query->bindParam(2,$cedula);
  if($query->execute()){
      return $query->fetchAll();
  }else {
      return null;
  }
}

public function registrarAllAutorizacion($tipo,$idUsuarioParamedico,$idUsuarioMedico,$idReporteAPH,$idTipo,$descripcionAutorizacion,$observacionRespuestaAutorizacion,$estadoEvaluacion,$fechaEnvio,$fechaEvaluacion,$cedulaPaciente){
$sql = "";
if ($tipo == "MEDICAMENTO") {
$sql = "CALL spRegistrarAllAutorizacionMedicamento(?,?,?,?,?,?,?,?,?,?);";
}else if($tipo == "TRATAMIENTO"){
$sql = "CALL spRegistrarAllAutorizacionTratamiento(?,?,?,?,?,?,?,?,?,?);";
}
$query = $this->_CONEXION->prepare($sql);
$query->bindParam(1, $idUsuarioParamedico);
$query->bindParam(2, $idUsuarioMedico);
$query->bindParam(3, $idReporteAPH);
$query->bindParam(4, $idTipo);
$query->bindParam(5, $descripcionAutorizacion);
$query->bindParam(6, $observacionRespuestaAutorizacion);
$query->bindParam(7, $estadoEvaluacion);
$query->bindParam(8, $fechaEnvio);
$query->bindParam(9, $fechaEvaluacion);
$query->bindParam(10, $cedulaPaciente);

if ($query->execute()) {
  return true;
}else{
  return false;

}

}
}




?>

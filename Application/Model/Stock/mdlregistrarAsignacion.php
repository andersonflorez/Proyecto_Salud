<?php
/**
 * Modelo mdlKit:
 * Escribe aqui una descripcion de lo que hace
 * este modelo. Copia esta estructura básica y
 * utilízala en todos los modelos que necesites
 * crear. Todos los modelos deben tener esta
 * estructura.
 */
class mdlregistrarAsignacion implements iModel {
  private static $_INSTANCIA; // Instancia única de esta clase
  private $_CONEXION;         // Variable de conexión PDO

  # Atributos de la clase:
  // ...
  # Constructor:
  private function __construct($_CON){
    try {
      $this->_CONEXION = $_CON;
    } catch (PDOException $e) {
      exit('Error al intentar conectar con la Base de Datos :' + $e);
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

  # Métodos y funciones de la clase:

  function RegistrarAsignacion($FechaAsignacion,$estadoTablaEstandarAsignacion,$NombreMedico,$CodigoAmbulancia,$TipoAsignacion,$NombrePaciente){

    $sql = "CALL spRegistrarAsignacionkit(?,?,?,?,?,?)";
    $query = $this->_CONEXION->prepare($sql);
    $query->bindParam(1, $FechaAsignacion);
    $query->bindParam(2, $estadoTablaEstandarAsignacion);
    $query->bindParam(3, $NombreMedico);
    $query->bindParam(4, $CodigoAmbulancia);
    $query->bindParam(5, $TipoAsignacion);
    $query->bindParam(6, $NombrePaciente);
  
   

      if ($query->execute()) {
      return true;
    } else {
      return false;
    }
  }

    function RegistrarRecursosAsignacion($Cantidad,$CantidadFinal,$Recursos,$CodigoAsignacion){
   
    $sql = "CALL spRegistrarDetallekit(?,?,?,?)";
    $query = $this->_CONEXION->prepare($sql);
    $query->bindParam(1, $Cantidad);
    $query->bindParam(2, $CantidadFinal);
    $query->bindParam(3, $Recursos);
    $query->bindParam(4, $CodigoAsignacion);
  
    
    $query->execute();
  }

  # Métodos Setter & Getter:

 public function listarComboTipoAsignacion(){
try {
 $sql = "CALL spListarTipoasignacion()";
 $query1 = $this->_CONEXION->prepare($sql);
 if($query1->execute()){
 return $query1->fetchAll();
 }else {
     return null;
 }
  
} catch (Exception $e) {
  return null;
  
}
}

public function listarComboAmbulancia(){
try {
 $sql = "CALL spListarAmbulancia()";
 $query1 = $this->_CONEXION->prepare($sql);
 if($query1->execute()){
     return $query1->fetchAll();
 }else {
     return null;
 }
  
} catch (Exception $e) {
      return null;
}
}

public function listarComboPaciente(){
try {
 $sql = "CALL spListarPaciente()";
 $query1 = $this->_CONEXION->prepare($sql);
 if($query1->execute()){
     return $query1->fetchAll();
 }else {
     return null;
 }
} catch (Exception $e) {
    return null;
}
}

public function listarComboPersona(){
try {
 $sql = "CALL spListarPersona()";
 $query1 = $this->_CONEXION->prepare($sql);
 if($query1->execute()){
     return $query1->fetchAll();
 }else {
     return null;
 }
} catch (Exception $e) {
   return null;
}
}

 public function listarComboidAsignacion(){
 try {
 $sql = "CALL spDetallekit";
 $query1 = $this->_CONEXION->prepare($sql);
 if($query1->execute()){
     return $query1->fetchAll();
 }else {
     return null;
 }
 } catch (Exception $e) {
   return null;
 }
}

public function listaCompletaRecursoEstandar(){
  try {
    $sql = "CALL splistaCompletaRecursoEstandar";
    $rs = $this->_CONEXION->prepare($sql);
    if($rs->execute()){
      return $rs->fetchAll();
    }
  } catch (Exception $e) {
    return null;
  }
}

 public function listarComboRecursokit(){
 try {
   $sql = "CALL splistarComboRecursokit";
 $query1 = $this->_CONEXION->prepare($sql);
 if($query1->execute()){
     return $query1->fetchAll();
 }else {
     return null;
 }
 } catch (Exception $e) {
   return null;
 }
}

 public function listarComboCantidadRecurso($ID){
 try {
   $sql = "CALL spListarCantidadRecurso(?)";
 $query1 = $this->_CONEXION->prepare($sql);
 $query1 ->bindParam(1,$ID);
 if($query1->execute()){
     return $query1->fetchAll();
 }else {
     return null;
 }
 } catch (Exception $e) {
   return null;
 }
}

 public function listarComboRecurso(){
 try {
   $sql = "CALL splistarComboRecursokit";
 $query1 = $this->_CONEXION->prepare($sql);
 if($query1->execute()){
     return $query1->fetchAll();
 }else {
     return null;
 }
 } catch (Exception $e) {
   return null;
 }
}

public function ConsultarAsignacion(){
  try {
     $sql ="CALL spListarAsignacionkit";
    $query = $this->_CONEXION->prepare($sql);
      if($query->execute()){
        return $query->fetchAll();
        }else {
            return null;
        }
    
  } catch (Exception $e) {
    return null;
  }
}

public function ConsultarDetalleKit(){
  try {
    $sql ="CALL spDetallekit";
    $query = $this->_CONEXION->prepare($sql);
      if($query->execute()){
          return $query->fetchAll();
    }else {
            return null;
        }
    
  } catch (Exception $e) {
       return null;
    
  }
  }


function ConsultarAsignacionId($cod){
$sql= 'SELECT * FROM tbl_asignacionKit where idAsignacion=:cod';
$query = $this->_CONEXION->prepare($sql);
$query->bindParam(":cod",$cod,PDO::PARAM_STR);
if ($query->execute()) {
  return $query->fetchAll();
}else{
  return null;
}
 }


 function consultarTblDetalleKit($cod){
 try {
    $sql="CALL spListartblDetalleKit(?)";
    $query=$this->_CONEXION->prepare($sql);
    $query->bindParam(1,$cod,PDO::PARAM_STR);
    $query->execute();
    if($query==true){
         return $query->fetchAll();
    }else{
      return null;
    }
   
 } catch (Exception $e) {
    return null;
   
 }
}


}
?>

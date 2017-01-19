<?php

/**
 * Modelo nombre_modelo:
 * Escribe aqui una descripcion de lo que hace
 * este modelo. Copia esta estructura básica y
 * utilízala en todos los modelos que necesites
 * crear. Todos los modelos deben tener esta
 * estructura.
 */
class mdlCProgramacion implements iModel {

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

public function consultarTurnos($id){
  try{
    $query = $this->_CONEXION->prepare("CALL spConsultarTurnosP(?)");
    $query->bindParam(1,$id);
    if($query->execute()){
      return $query->fetchALL();
    }else{
      return null;
    }
  }catch(Exception $e){
    die("Ha ocurrido un error". $e);
  }
}
  public function consultarDias($id){
    try{
    $query = $this->_CONEXION->prepare("CALL spConsultaProgramacionDias(?)");
    $query->bindParam(1,$id);
    if($query->execute()){
      return $query->fetchALL();
    }else{
      return null;
    }
    }catch(Exception $e){
      die("Ha ocurrido un error". $e);
    }
  }
    public function citasagendadas($id) {
        $sql = "call spConsultacitasU(?)";
        $query = $this->_CONEXION->prepare($sql);
        $query->bindParam(1,$id);
        if ($query->execute()){
            return $query->fetchAll();
        } else {
            return null;
        }
    }

public function inhabilitar($id){
$sql = "CALL spCambiarEstadoProgramacion (?)";
$query = $this->_CONEXION->prepare($sql);
$query->bindParam(1,$id);
if ($query->execute()) {
  return true;
}else{ return false;}
}



    public function citacion($id){
        $sql = "call spConsultacitasU(?)";
        $query = $this->_CONEXION->prepare($sql);
        $query->bindParam(1,$id);
        if ($query->execute()) {
            return $query->fetchAll();
        } else {
            return null;
        }
    }

public function historialProgramacion($fecha,$id){
$sql = "CALL spConsultarHistorialP(?,?)";
$query = $this->_CONEXION->prepare($sql);
$query->bindParam(1,$fecha);
$query->bindParam(2,$id);
if($query->execute()){
    return $query->fetchALL();
}else{
    return null;
}
}

public function traerTrunoshp($fecha,$id){
  $sql = "CALL spConsultarTurnosHP(?,?)";
  $query = $this->_CONEXION->prepare($sql);
  $query->bindParam(1,$fecha);
  $query->bindParam(2,$id);
  if($query->execute()){
    return $query->fetchALL();
  }else{
    return null;
  }
}


  # Métodos y funciones de la clase:
  // ...
  # Métodos Setter & Getter:
  // ...
}


?>

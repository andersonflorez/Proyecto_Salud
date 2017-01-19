<?php

/**
 * Modelo nombre_modelo:
 * Escribe aqui una descripcion de lo que hace
 * este modelo. Copia esta estructura básica y
 * utilízala en todos los modelos que necesites
 * crear. Todos los modelos deben tener esta
 * estructura.
 */
class mdlCalendario implements iModel {

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


  public function insertarTurnoProgramacion($turno,$idProgramacion,$idPersona){
    $estado = "Activo";
    try{
    $cantidad = count($turno);
    for($i=0; $i<=$cantidad-1; $i++){
    $turn = $turno[$i];
    $person = $idPersona;
    $query = $this->_CONEXION->prepare("CALL spRegistrarTurnoprogramacion(?,?,?,?)");
    $query->bindParam(1,$turn);
    $query->bindParam(2,$idProgramacion);
    $query->bindParam(3,$person);
    $query->bindParam(4,$estado);
    $query->execute();
    }
    }catch(Exception $e){
    die("Ha ocurrido un error". $e);
    }

  }
  public function insertarProgramacion($diaI,$diaF,$turno){
    try{
    $ejecutador = $this->_CONEXION->prepare("CALL spRegistrarProgramacion(?,?)");
    $ejecutador->bindParam(1,$diaI);
    $ejecutador->bindParam(2,$diaF);
    $ejecutador->execute();
    $consulta = $this->_CONEXION->prepare("CALL spConsultarProgramacion(?,?)");
    $consulta->bindParam(1,$diaI);
    $consulta->bindParam(2,$diaF);
    if ($consulta->execute()) {
      return $consulta->fetch();
    }else{
      return null;
    }
  }catch(Exception $e){
     die("Ha ocurrido un error". $e);
    }

  }

function consultarCorreo($id){
try{
  $consulta = $this->_CONEXION->prepare("CALL spConsultarCorreoPersonaP(?)");
  $consulta->bindParam(1,$id);
  if($consulta->execute()){
    return $consulta->fetch();
  }else{
    return null;
  }
}catch(Exception $e){
  die("Ha ocurrido un error");
}
}




  # Métodos y funciones de la clase:
  // ...
  # Métodos Setter & Getter:
  // ...
}


?>

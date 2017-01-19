<?php

/**
* Modelo nombre_modelo:
* Escribe aqui una descripcion de lo que hace
* este modelo. Copia esta estructura básica y
* utilízala en todos los modelos que necesites
* crear. Todos los modelos deben tener esta
* estructura.
*/
class mdlDetalleAsignacion implements iModel {

  private static $_INSTANCIA; // Instancia única de esta clase
  private $_CONEXION;         // Variable de conexión PDO

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



  # Métodos y funciones de la clase:
  function registrarDetalleAsignacion($idPersona,$ultimo,$estado,$cargoPersona){
    var_dump($idPersona,$ultimo,$estado);
    $sql = "CALL spRegistrarDetalleasignacion(?,?,?,?)";
    $query = $this->_CONEXION->prepare($sql);
    $query->bindParam(1,$ultimo);
    $query->bindParam(2,$idPersona);
    $query->bindParam(3,$estado);
    $query->bindParam(4,$cargoPersona);
    if ($query->execute()) {
      return true;
    }else{
      return false;
    }
  }

  //funcion para llamar el procedimiento que traiga el ultimo id de la tabla
  function capturarUltimoID(){
    $sql="CALL spSeleccionarUltimoid()";
    $query = $this->_CONEXION->prepare($sql);
    if ($query->execute()) {
      return $query->fetch();
    }else{
      return null;
    }
  }

  function ActualizarEstadoPersona($idPersona){
    $sql = "CALL spActualizarEstadoPersona(?)";
    $query = $this->_CONEXION->prepare($sql);
    $query->bindParam(1,$idPersona);
    if ($query->execute()) {
      return true;
    }else{
      return false;
    }
  }


  // ...

  # Métodos Setter & Getter:

  // ...

}


?>

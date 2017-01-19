<?php

/**
* Modelo nombre_modelo:
* Escribe aqui una descripcion de lo que hace
* este modelo. Copia esta estructura básica y
* utilízala en todos los modelos que necesites
* crear. Todos los modelos deben tener esta
* estructura.
*/
class mdlAsignacionPersonal implements iModel {

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

  public function registrarAsignacionPersonal($idAmbulancia,$fecha,$estado,$longitud,$latitud){

    $sql = "CALL spRegistrarAsignacionpersonal(?,?,?,?,?)";
    $query = $this->_CONEXION->prepare($sql);
    $query->bindParam(1,$idAmbulancia);
    $query->bindParam(2,$fecha);
    $query->bindParam(3,$estado);
    $query->bindParam(4,$longitud);
    $query->bindParam(5,$latitud);

    if ($query->execute()) {
      return true;
    }else{
      return false;
    }

  }


  public function ActualizarEstadoAmbulancia($idAmbulancia,$estado){
    $sql = "CALL spCambiarEstadoAmbulancia(?,?)";
    $query = $this->_CONEXION->prepare($sql);
    $query->bindParam(1,$idAmbulancia);
    $query->bindParam(2,$estado);
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

<?php
/**
* Modelo MdlConsultaDevolucion:
* Escribe aqui una descripcion de lo que hace
* este modelo. Copia esta estructura básica y
* utilízala en todos los modelos que necesites
* crear. Todos los modelos deben tener esta
* estructura.
*/
class MdlConsultaDevolucion implements iModel {

  private static $_INSTANCIA;
  private $_CONEXION;

  # Atributos de la clase:

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

  function ListarAsignacion() {
    $sql = "CALL spListarAsignacionkit()";
    $query = $this->_CONEXION->prepare($sql);
    if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return null;
    }
  }


  function ConsultarDevolucion($id){
    $sql ="CALL spListarDevolucion(?)";
    $query = $this->_CONEXION->prepare($sql);
    $query->bindParam(1,$id,PDO::PARAM_STR);
    if($query->execute()){
      return $query->fetchAll();
    }else {
      return null;
    }
  }

  # Métodos Setter & Getter:


}
?>

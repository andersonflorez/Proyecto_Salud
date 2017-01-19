<?php
/**
* Modelo mdlKit:
* Escribe aqui una descripcion de lo que hace
* este modelo. Copia esta estructura básica y
* utilízala en todos los modelos que necesites
* crear. Todos los modelos deben tener esta
* estructura.
*/
class MdlKit implements iModel {


  private static $_INSTANCIA;
  private $_CONEXION;

  # Atributos de la clase:
  private $_idRecurso;
  private $_stockminKit;
  private $_unidadMedida;
  private $_idTipoKit;
  private $_estadoTablaEstandarKit;

  private $_idEstandarKitA;
  private $_idRecursoA;
  private $_stockminKitA;
  private $_unidadMedidaA;
  private $_idTipoKitA;

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

  function RegistrarKit(){
    $idRecurso = $this->__GET('_idRecurso');
    $unidadMedida = $this->__GET('_unidadMedida');
    $stockminKit = $this->__GET('_stockminKit');
    $idTipoKit = $this->__GET('_idTipoKit');
    $estadoTablaEstandarKit = $this->__GET('_estadoTablaEstandarKit');

    $sql = "CALL spRegistrarEstandarkit(?,?,?,?,?)";

    $query = $this->_CONEXION->prepare($sql);
    $query->bindParam(1, $idRecurso);
    $query->bindParam (2, $unidadMedida);
    $query->bindParam (3, $stockminKit);
    $query->bindParam(4, $idTipoKit);
    $query->bindParam(5, $estadoTablaEstandarKit);
    if ($query->execute()) {
      return true;
    } else {
      return false;
    }
  }

  function ConsultarKit($id){
      $sql ="CALL spListarEstandarkit(?)";
      $query = $this->_CONEXION->prepare($sql);
      $query->bindParam(1,$id,PDO::PARAM_STR);
      if($query->execute()){
        return $query->fetchAll();
      }else {
        return null;
      }
    }

    function traerIdKit($cod){
      $sql='SELECT * FROM tbl_tipoKit where idTipoKit=:cod';
      $query = $this->_CONEXION->prepare($sql);
      $query->bindParam(":cod",$cod,PDO::PARAM_STR);
      if ($query->execute()) {
        return $query->fetch();
      }else{
        return null;
      }
    }

  function ActualizarKit(){
    $idRecurso = $this->__GET('_idRecursoA');
    $unidadMedida = $this->__GET('_unidadMedidaA');
    $stockminKit = $this->__GET('_stockminKitA');
    $idTipoKit = $this->__GET('_idTipoKitA');
    $idEstandarkit = $this->__GET('_idEstandarKitA');
    $sql = "CALL spModificarEstandarkit (?,?,?,?,?)";
    $query = $this->_CONEXION->prepare($sql);
    $query->bindParam(1, $idRecurso);
    $query->bindParam (2, $unidadMedida);
    $query->bindParam (3, $stockminKit);
    $query->bindParam(4, $idTipoKit);
    $query->bindParam(5, $idEstandarkit);
    if($query->execute()){
      return true;
    } else {
      return false;
    }
  }


  function ConsultarKitId($cod){
    $sql='SELECT * FROM tbl_estandarkit where idEstandarkit=:cod';
    $query = $this->_CONEXION->prepare($sql);
    $query->bindParam(":cod",$cod,PDO::PARAM_STR);
    if ($query->execute()) {
      return $query->fetch();
    }else{
      return null;
    }
  }

  function ListaridRecurso() {
    $sql = "CALL spListarRecurso()";
    $query = $this->_CONEXION->prepare($sql);
    if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return null;
    }
  }

  function ListarTipoKit() {
    $sql = "CALL spListarTipokit()";
    $query = $this->_CONEXION->prepare($sql);
    if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return null;
    }
  }

  public function CambiarEstadoEstandarKit(){
    $idEstandarkit = $this->__GET("_idEstandarKit");
    $estadoTablaEstandarKit = $this->__GET("_estadoTablaEstandarKit");
    $sql = "CALL spCambiarEstadoEstandarkit(?,?)";
    $query = $this->_CONEXION->prepare($sql);
    $query->bindParam(1, $idEstandarkit);
    $query->bindParam(2, $estadoTablaEstandarKit);
    if ($query->execute()) {
      return true;
    }else {
      return false;
    }

  }

  # Métodos Setter & Getter:
  function __GET($atributo){
    return $this->$atributo;
  }
  function __SET($atributo,$valor){
    $this->$atributo = $valor;
  }

}
?>

<?php
/**
* Modelo mdlNovedad:
* Escribe aqui una descripcion de lo que hace
* este modelo. Copia esta estructura básica y
* utilízala en todos los modelos que necesites
* crear. Todos los modelos deben tener esta
* estructura.
*/
class MdlNovedad implements iModel {


  private static $_INSTANCIA; // Instancia única de esta clase
  private $_CONEXION;         // Variable de conexión PDO

  # Atributos de la clase:
  private $_idNovedadRecurso;
  private $_descripcionNovedad;
  private $_fechaHoraNovedad;
  private $_estadoTablaNovedad;
  private $_idDetallekit;
  private $_idPersona;
  private $_idTipoNovedad;

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

  function RegistrarNovedad(){
    $descripcionNovedad = $this->__GET('_descripcionNovedad');
    $fechaHoraNovedad = $this->__GET('_fechaHoraNovedad') ;
    $estadoTablaNovedad= $this->__GET('_estadoTablaNovedad');
    $idDetallekit = $this->__GET('_idDetallekit');
    $idPersona  = $this->__GET('_idPersona');
    $idTipoNovedad = $this->__GET('_idTipoNovedad');

    $sql = "CALL spRegistrarNovedadrecurso(?,?,?,?,?,?)";

    $query = $this->_CONEXION->prepare($sql);
    $query->bindParam(1, $descripcionNovedad);
    $query->bindParam (2, $fechaHoraNovedad);
    $query->bindParam(3, $estadoTablaNovedad);
    $query->bindParam(4, $idDetallekit);
    $query->bindParam(5, $idPersona);
    $query->bindParam(6, $idTipoNovedad);
    if ($query->execute()) {
      return true;
    } else {
      return false;
    }
  }

  function ListarPersona() {
    $sql = "CALL spListarMedico()";
    $query = $this->_CONEXION->prepare($sql);
    if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return null;
    }
  }

  function ListarDetalleKit() {
    $sql = "CALL spListarDetallekit()";
    $query = $this->_CONEXION->prepare($sql);
    if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return null;
    }
  }

  function ListarTipoNovedad() {
    $sql = "CALL spListarTiponovedad()";
    $query = $this->_CONEXION->prepare($sql);
    if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return null;
    }
  }

  function ConsultarNovedad(){
    $sql ="CALL spListarNovedadrecurso()";
    $query = $this->_CONEXION->prepare($sql);
    if($query->execute()){
      return $query->fetchAll();
    }else {
      return null;
    }
  }


  function traerId($cod){
    $sql='SELECT * FROM tbl_novedadrecurso where idNovedadRecurso=:cod';
    $query = $this->_CONEXION->prepare($sql);
    $query->bindParam(":cod",$cod,PDO::PARAM_STR);
    if ($query->execute()) {
      return $query->fetch();
    }else{
      return null;
    }
  }

  public function CambiarEstadoNovedad (){
    $idNovedadRecurso = $this->__GET("_idNovedadRecurso");
    $estadoTablaNovedad = $this->__GET("_estadoTablaNovedad");
    $sql = "CALL spCambiarEstadonovedadrecurso(?,?)";
    $query = $this->_CONEXION->prepare($sql);
    $query->bindParam(1, $idNovedadRecurso);
    $query->bindParam(2, $estadoTablaNovedad);
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

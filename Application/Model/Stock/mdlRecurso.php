<?php

/**

*/
class mdlRecurso implements iModel {

  private static $_INSTANCIA;
  private $_CONEXION;

  # Atributos de la clase:
  private $_nombre;
  private $_descripcion;
  private $_cantidadRecurso;
  private $_estadoTablaRecurso;
  private $_idCategoriaRecurso;

  private $_idRecursoA;
  private $_nombreA;
  private $_descripcionA;
  private $_cantidadRecursoA;
  private $_idCategoriaRecursoA;

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

  function ListarCategoriaRecurso() {
    $sql = "CALL spListarCategoriarecurso()";
    $query = $this->_CONEXION->prepare($sql);
    if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return null;
    }
  }

  function RegistrarRecurso(){
    $nombre = $this->__GET('_nombre');
    $descripcion = $this->__GET('_descripcion');
    $cantidadRecurso = $this->__GET('_cantidadRecurso');
    $estadoTablaRecurso = $this->__GET('_estadoTablaRecurso');
    $idCategoriaRecurso = $this->__GET('_idCategoriaRecurso');
    $sql = "CALL spRegistrarRecurso(?,?,?,?,?);";
    $query = $this->_CONEXION->prepare($sql);
    $query->bindParam(1,$nombre);
    $query->bindParam(2,$descripcion);
    $query->bindParam(3,$cantidadRecurso);
    $query->bindParam(4,$estadoTablaRecurso);
    $query->bindParam(5,$idCategoriaRecurso);
    if ($query->execute()) {
      return true;
    }else{
      return false;
    }
  }

  function ConsultarRecurso(){
    $sql ="CALL spListarRecurso()";
    $query = $this->_CONEXION->prepare($sql);
    if($query->execute()){
      return $query->fetchAll();
    }else {
      return null;
    }
  }

  function ActualizarRecurso(){
    $nombre = $this->__GET('_nombreA');
    $descripcion = $this->__GET('_descripcionA');
    $cantidadRecurso = $this->__GET('_cantidadRecursoA');
    $idCategoriaRecurso = $this->__GET('_idCategoriaRecursoA');
    $idrecurso = $this->__GET('_idRecursoA');
    $sql = "CALL spModificarRecurso (?,?,?,?,?)";
    $query = $this->_CONEXION->prepare($sql);
    $query->bindParam(1,$nombre);
    $query->bindParam(2,$descripcion);
    $query->bindParam(3,$cantidadRecurso);
    $query->bindParam(4,$idCategoriaRecurso);
    $query->bindParam(5,$idrecurso);
    if($query->execute()){
      return true;
    } else {
      return false;
    }
  }

  function traerId($cod){
    $sql='SELECT * FROM tbl_recurso where idrecurso=:cod';
    $query = $this->_CONEXION->prepare($sql);
    $query->bindParam(":cod",$cod,PDO::PARAM_STR);
    if ($query->execute()) {
      return $query->fetch();
    }else{
      return null;
    }
  }

  public function CambiarEstadoRecurso ($idrecurso,$estadoTablaRecurso){
    $sql = "CALL spCambiarEstadoRecurso(?,?)";
    $query = $this->_CONEXION->prepare($sql);
    $query->bindParam(1, $idrecurso);
    $query->bindParam(2, $estadoTablaRecurso);
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

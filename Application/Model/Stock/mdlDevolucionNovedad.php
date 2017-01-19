<?php
/**
* Modelo mdlDevolucionNovedad:
* Escribe aqui una descripcion de lo que hace
* este modelo. Copia esta estructura básica y
* utilízala en todos los modelos que necesites
* crear. Todos los modelos deben tener esta
* estructura.
*/
class MdlDevolucionNovedad implements iModel {


  private static $_INSTANCIA; // Instancia única de esta clase
  private $_CONEXION;         // Variable de conexión PDO

  # Atributos de la clase:
  private $_cantidad;
  private $_fechaHoraDevolucion;
  private $_estadoTablaDevolucion;
  private $_idTipoDevolucion;
  private $_idDetallekit;
  private $_idPersona;

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

  public function RegistrarDevolucion(){
    $cantidad = $this->__GET('_cantidad');
    $fechaHoraDevolucion = $this->__GET('_fechaHoraDevolucion');
    $estadoTablaDevolucion = $this->__GET('_estadoTablaDevolucion');
    $idTipoDevolucion = $this->__GET('_idTipoDevolucion');
    $idDetallekit = $this->__GET('_idDetallekit');
    $idPersona = $this->__GET('_idPersona');
    $sql = "CALL spRegistrarDevolucion(?,?,?,?,?,?);";
    $query = $this->_CONEXION->prepare($sql);
    $query->bindParam(1, $cantidad);
    $query->bindParam(2, $fechaHoraDevolucion);
    $query->bindParam(3, $estadoTablaDevolucion);
    $query->bindParam(4, $idTipoDevolucion);
    $query->bindParam(5, $idDetallekit);
    $query->bindParam(6, $idPersona);
    if ($query->execute()) {
      $filasAfectadas = $query->rowCount();
      if ($filasAfectadas > 0) {
        $sql = "CALL spActualizarCantidadRecurso(?,?)";
        $query = $this->_CONEXION->prepare($sql);
        $query->bindParam(1, $cantidad);
        $query->bindParam(2, $idDetallekit);
        if ($query->execute()) {
          $filas = $query->rowCount();
          if ($filas > 0) {
            return true;
          }
          else{
            return false;
          }
        }else{
          return false;
        }
      }else{
        return false;
      }
    }else{
      return false;
    }
  }

  function ListarPaciente() {
    $sql = "CALL spListarPaciente()";
    $query = $this->_CONEXION->prepare($sql);
    if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return null;
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

  function ListarAmbulancia() {
    $sql = "CALL spListarAmbulancia()";
    $query = $this->_CONEXION->prepare($sql);
    if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return null;
    }
  }

  function ListarTipoDevolucion() {
    $sql = "CALL spListarTipodevolucion()";
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

  public function ConfirmarAsignacion($id,$select,$fecha){
    try {
      $sql="CALL spConfirmarAsignacion(?,?,?)";
      $query=$this->_CONEXION->prepare($sql);
      $query->bindParam(1,$id);
      $query->bindParam(2,$select);
      $query->bindParam(3,$fecha);
      $query->execute();
      if ($query->rowCount() >  0) {
        return $query->fetchAll();
      }else{
        return false;
      }
    } catch (Exception $e) {
      die($e);
    }


  }


  function traerId($cod){
    $sql='SELECT * FROM tbl_detallekit where idDetallekit=:cod';
    $query = $this->_CONEXION->prepare($sql);
    $query->bindParam(":cod",$cod,PDO::PARAM_STR);
    if ($query->execute()) {
      return $query->fetch();
    }else{
      return null;
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

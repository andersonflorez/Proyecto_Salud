<?php

class mdlPermisos implements iModel {

  private static $_INSTANCIA; // Instancia única de esta clase
  private $_CONEXION;         // Variable de conexión PDO
  private $_Usuario;
  private $_Clave;
  private $_idRol;
  private $_idModulo;
  private $_idUsuario;
  private $_idClave;
  private $_idEspecialidad;
  private $_idPersona;
  private $_idVista;
  private $_descripcionRol;
  # Métodos Setter & Getter:
  public function __SET($atributo, $valor){
      $this->$atributo = $valor;
  }

  public function __GET($atributo){
      return $this->$atributo;
  }

  # Constructor:
  private function __construct($_CON){

    try {
      $this->_CONEXION = $_CON;
    } catch (PDOException $e) {
      exit('Error al intentar conectar con la Base de Datos: ' + $e);
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

  public function listarComboRoles(){

    $sql = "CALL spListarRoles()";
    $query = $this->_CONEXION->prepare($sql);

    if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return false;
    }

  }

  public function consultaAsignacionPermiso(){

    $sql = "CALL spConcultaPermisoAsignado(?)";
    $desRol = $this->__GET("_descripcionRol");
    $query = $this->_CONEXION->prepare($sql);
    $query->bindParam(1, $desRol, PDO::PARAM_STR);
    if ($query->execute()){
      return $query->fetchAll();
    } else {
      return null;
    }
  }

  public function Permisos(){

    $sql = "CALL spValidarRolModuloVista(?)";
    $idRol = $this->__GET("_idRol");
    $query = $this->_CONEXION->prepare($sql);
    $query->bindParam(1, $idRol, PDO::PARAM_STR);

    if ($query->execute()){
      return $query->fetchAll();
    } else {
      return null;
    }

  }

  public function ConsultarModulos(){

    $sql = "CALL spConsultarModuloRol(?)";
    $idRol = $this->__GET("_idRol");
    $query = $this->_CONEXION->prepare($sql);
    $query->bindParam(1, $idRol, PDO::PARAM_STR);

    if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return null;
    }
  }

  public function ConsultarVistas(){

    $sql = "CALL spConsultarModuloVista(?,?)";
    $idRol = $this->__GET("_idRol");
    $idModulo = $this->__GET("_idModulo");
    $query = $this->_CONEXION->prepare($sql);
    $query->bindParam(1, $idRol, PDO::PARAM_STR);
    $query->bindParam(2, $idModulo, PDO::PARAM_STR);

    if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return null;
    }
  }

  public function RegistrarPermisos(){
    $idRol = $this->__GET("_idRol");
    $idModulo = $this->__GET("_idModulo");
    $idVista = $this->__GET("_idVista");
    $sql = "CALL spRegistrarPermiso(?,?,?)";
    $query = $this->_CONEXION->prepare($sql);
    $query->bindParam(1, $idRol);
    $query->bindParam(2, $idModulo);
    $query->bindParam(3, $idVista);
    $res = $query->execute();
    if ($res) {
      return "0";
    }else {
      return "1";
    }
  }
}

?>

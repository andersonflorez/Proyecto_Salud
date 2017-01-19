<?php

/**
* Modelo PersonaExterna:
* Este modelo se encarga del CRUD de la tabla de personas externas
*/

class mdlRegistrarPersonaExterna implements iModel {

  private static $_INSTANCIA; // Instancia única de esta clase
  private $_CONEXION;         // Variable de conexión PDO

  # Propiedades de esta clase:
  private $primerNombre;
  private $segundoNombre;
  private $primerApellido;
  private $segundoApellido;
  private $idTipoDocumento;
  private $numeroDocumento;
  private $lugarExpedicionDocumento;
  private $fechaNacimiento;
  private $lugarNacimiento;
  private $sexo;
  private $direccion;
  private $telefono;
  private $correoElectronico;
  private $grupoSanguineo;
  private $ciudad;
  private $departamento;
  private $pais;
  private $urlHojaDeVida;
  private $urlFirma;
  private $urlFoto;
  private $estadoTablaPersona;
  private $dependencia;
  private $usuario;
  private $clave;
  private $idRol;
  private $idPersona;

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

  function consultarUltimaPersona() {

    $sql="CALL spListarUltimaPersona()";
    $query = $this->_CONEXION->prepare($sql);

    if ($query->execute()) {
      return $query->fetch();
    } else {
      return null;
    }

  }
  //funciones de persona

  function InsertarDatosPersonaExterna() {

    $sql = "CALL spRegistrarPersona(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    $query = $this->_CONEXION->prepare($sql);

    $query->bindParam(1, $this->primerNombre);
    $query->bindParam(2, $this->segundoNombre);
    $query->bindParam(3, $this->primerApellido);
    $query->bindParam(4, $this->segundoApellido);
    $query->bindParam(5, $this->idTipoDocumento);
    $query->bindParam(6, $this->numeroDocumento);
    $query->bindParam(7, $this->lugarExpedicionDocumento);
    $query->bindParam(8, $this->fechaNacimiento);
    $query->bindParam(9, $this->lugarNacimiento);
    $query->bindParam(10, $this->sexo);
    $query->bindParam(11, $this->direccion);
    $query->bindParam(12, $this->telefono);
    $query->bindParam(13, $this->correoElectronico);
    $query->bindParam(14, $this->grupoSanguineo);
    $query->bindParam(15, $this->ciudad);
    $query->bindParam(16, $this->departamento);
    $query->bindParam(17, $this->pais);
    $query->bindParam(18, $this->urlHojaDeVida);
    $query->bindParam(19, $this->urlFirma);
    $query->bindParam(20, $this->urlFoto);
    $query->bindParam(21, $this->estadoTablaPersona);
    $query->bindParam(22, $this->dependencia);

    if ($query->execute() && $query->rowCount() > 0) {
      return true;
    } else {
      return false;
    }

  }


  function InsertarDatosUsuario() {

    $sql   = "CALL spRegistrarCuentausuario(?,?,?,?)";
    $query = $this->_CONEXION->prepare($sql);
    $query->bindParam(1,  $this->idPersona, PDO::PARAM_INT);
    $query->bindParam(2,  $this->usuario);
    $query->bindParam(3,  $this->clave);
    $query->bindParam(4,  $this->idRol);

    if ($query->execute() && $query->rowCount() > 0) {
      return true;
    } else {
      return false;
    }

  }

  public function listarComboTipoDocumento() {

    $sql = "CALL spListarTipodocumento()";
    $query = $this->_CONEXION->prepare($sql);

    if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return false;
    }

  }

  public function idUltimaPersona() {

    $sql = "CALL spUltimaPersona()";
    $query = $this->_CONEXION->prepare($sql);

    if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return false;
    }

  }

  public function consultaPersonaD($numeroDocumento) {

    $sql = "CALL spConsultaPersonaD(?)";
    $query = $this->_CONEXION->prepare($sql);
    $query->bindParam(1, $numeroDocumento);

    if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return false;
    }

  }

  public function validarDocumento($numeroDocumento) {

    $sql = "CALL spValidarDocumentoPersona(?)";
    $query = $this->_CONEXION->prepare($sql);
    $query->bindParam(1, $numeroDocumento);

    if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return false;
    }

  }

  public function consultaPersonaUsuario($usuario) {

    $sql   = "CALL spConsultaPersonaUsuario(?)";
    $query = $this->_CONEXION->prepare($sql);
    $query->bindParam(1, $usuario);
     if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return false;
    }

  }

  public function validarUsuario($usuario) {

    $sql   = "CALL spValidarUsuarioPersona(?)";
    $query = $this->_CONEXION->prepare($sql);
    $query->bindParam(1, $usuario);

    if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return false;
    }

  }

  public function consultaPersonaCorreo($correoElectronico) {

    $sql   = "CALL spConsultaPersonaCorreo(?)";
    $query = $this->_CONEXION->prepare($sql);
    $query->bindParam(1, $correoElectronico);

    if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return false;
    }

  }

  public function validarCorreo($correoElectronico) {

    $sql   = "CALL spValidarCorreoPersona(?)";
    $query = $this->_CONEXION->prepare($sql);
    $query->bindParam(1, $correoElectronico);

    if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return false;
    }

  }

  public function consultarUsuario() {

    $sql   = "CALL spConsultarUsuario()";
    $query = $this->_CONEXION->prepare($sql);

    if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return false;
    }

  }

  public function __SET($propiedad, $valor) {
    $this->$propiedad = $valor;
  }

  public function __GET($propiedad) {
    return $this->$propiedad;
  }

}

?>

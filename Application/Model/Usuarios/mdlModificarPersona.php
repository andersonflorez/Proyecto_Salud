<?php

class mdlModificarPersona implements iModel {

  private static $_INSTANCIA; // Instancia única de esta clase
  private $_CONEXION; // Variable de conexión PDO

  # Constructor:
  private function __construct($_CON) {

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

  function ActualizarPersona($idPersona, $primerNombre, $segundoNombre, $primerApellido, $segundoApellido, $idTipoDocumento, $numeroDocumento, $lugarExpedicionDocumento, $fechaNacimiento, $lugarNacimiento, $sexo, $direccion, $telefono, $correoElectronico, $grupoSanguineo, $ciudad, $departamento, $pais, $urlHojaDeVida, $urlFirma, $urlFoto, $dependencia,$idRol) {

    $sql = "CALL spModificarPersona (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    $query = $this->_CONEXION->prepare($sql);
    $query->bindParam(1, $idPersona, PDO::PARAM_INT);
    $query->bindParam(2, $primerNombre, PDO::PARAM_STR);
    $query->bindParam(3, $segundoNombre, PDO::PARAM_STR);
    $query->bindParam(4, $primerApellido, PDO::PARAM_STR);
    $query->bindParam(5, $segundoApellido, PDO::PARAM_STR);
    $query->bindParam(6, $idTipoDocumento, PDO::PARAM_STR);
    $query->bindParam(7, $numeroDocumento, PDO::PARAM_STR);
    $query->bindParam(8, $lugarExpedicionDocumento, PDO::PARAM_STR);
    $query->bindParam(9, $fechaNacimiento, PDO::PARAM_STR);
    $query->bindParam(10, $lugarNacimiento, PDO::PARAM_STR);
    $query->bindParam(11, $sexo, PDO::PARAM_STR);
    $query->bindParam(12, $direccion, PDO::PARAM_STR);
    $query->bindParam(13, $telefono, PDO::PARAM_STR);
    $query->bindParam(14, $correoElectronico, PDO::PARAM_STR);
    $query->bindParam(15, $grupoSanguineo, PDO::PARAM_STR);
    $query->bindParam(16, $ciudad, PDO::PARAM_STR);
    $query->bindParam(17, $departamento, PDO::PARAM_STR);
    $query->bindParam(18, $pais, PDO::PARAM_STR);
    $query->bindParam(19, $urlHojaDeVida, PDO::PARAM_STR);
    $query->bindParam(20, $urlFirma, PDO::PARAM_STR);
    $query->bindParam(21, $urlFoto, PDO::PARAM_STR);
    $query->bindParam(22, $dependencia, PDO::PARAM_STR);
    $query->bindParam(23, $idRol, PDO::PARAM_STR);
    $rs = $query->execute();
    if ( $rs ) {
      return true;
    } else {
      return false;
    }
  }

  function consultarUltimaPersona() {

    $sql   = "CALL spListarUltimaPersona()";
    $query = $this->_CONEXION->prepare($sql);

    if ($query->execute()) {
      return $query->fetch();
    } else {
      return null;
    }

  }

  public function idUltimaPersona() {

    $sql   = "CALL spUltimaPersona()";
    $query = $this->_CONEXION->prepare($sql);

    if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return false;
    }

  }

  function ActualizarRol($idUsuario, $idPersona, $usuario, $clave, $idRol) {

    $sql = "CALL spModificarCuentausuario (?,?,?,?,?)";
    $query = $this->_CONEXION->prepare($sql);
    $query->bindParam(1, $idUsuario, PDO::PARAM_STR);
    $query->bindParam(2, $idPersona, PDO::PARAM_STR);
    $query->bindParam(3, $usuario, PDO::PARAM_STR);
    $query->bindParam(4, $clave, PDO::PARAM_STR);
    $query->bindParam(5, $idRol, PDO::PARAM_STR);

    if ($query->execute() && $query->rowCount() > 0) {
      return true;
    } else {
      return false;
    }

  }

  public function listarComboTipoDocumento() {

    $sql   = "CALL spListarTipodocumento()";
    $query = $this->_CONEXION->prepare($sql);

    if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return false;
    }

  }

  public function listarComboRoles() {

    $sql   = "CALL spListarRoles()";
    $query = $this->_CONEXION->prepare($sql);

    if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return false;
    }
  }

  public function consultaPersonaD($numeroDocumento) {

    $sql   = "CALL spConsultaPersonaD(?)";
    $query = $this->_CONEXION->prepare($sql);
    $query->bindParam(1, $numeroDocumento);

    if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return false;
    }

  }

  public function validarDocumento($numeroDocumento) {

    $sql   = "CALL spValidarDocumentoPersona(?)";
    $query = $this->_CONEXION->prepare($sql);
    $query->bindParam(1, $numeroDocumento);

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

}

?>

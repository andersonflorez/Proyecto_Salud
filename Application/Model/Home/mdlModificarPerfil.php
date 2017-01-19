  <?php

/**
* Modelo del main Principal:
* Este modelo se encarga de
*/

class mdlModificarPerfil implements iModel {

  private static $_INSTANCIA; // Instancia única de esta clase
  private $_CONEXION;         // Variable de conexión PDO
    
  private $idUsuario;
  private $ejecutador;
  private $lista;

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
    
          
  public function ConsultarPerfil() {

    $this->lista = null;

    try {

      $this->ejecutador = $this->_CONEXION->prepare("CALL spConsultarPerfil(?)");
      $this->ejecutador->bindParam(1, $this->idUsuario);
      $this->ejecutador->execute();

      if ($this->ejecutador->rowCount() > 0) {
        $this->lista = $this->ejecutador->fetch();
      }

    } catch (Exception $e) {
      die("Ha ocurrido un error al intentar consultar el perfil: $e");
    }

    return $this->lista;

  }
    
function ActualizarPerfil($idPersona, $primerNombre, $segundoNombre, $primerApellido, $segundoApellido, $idTipoDocumento, $numeroDocumento, $fechaNacimiento, $sexo, $direccion, $telefono, $correoElectronico, $ciudad, $departamento, $pais, $urlFoto) {

    $sql = "CALL spModificarPerfil (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    $query = $this->_CONEXION->prepare($sql);
    $query->bindParam(1, $idPersona, PDO::PARAM_STR);
    $query->bindParam(2, $primerNombre, PDO::PARAM_STR);
    $query->bindParam(3, $segundoNombre, PDO::PARAM_STR);
    $query->bindParam(4, $primerApellido, PDO::PARAM_STR);
    $query->bindParam(5, $segundoApellido, PDO::PARAM_STR);
    $query->bindParam(6, $idTipoDocumento, PDO::PARAM_STR);
    $query->bindParam(7, $numeroDocumento, PDO::PARAM_STR);
    $query->bindParam(8, $fechaNacimiento, PDO::PARAM_STR);
    $query->bindParam(9, $sexo, PDO::PARAM_STR);
    $query->bindParam(10, $direccion, PDO::PARAM_STR);
    $query->bindParam(11, $telefono, PDO::PARAM_STR);
    $query->bindParam(12, $correoElectronico, PDO::PARAM_STR);
    $query->bindParam(13, $ciudad, PDO::PARAM_STR);
    $query->bindParam(14, $departamento, PDO::PARAM_STR);
    $query->bindParam(15, $pais, PDO::PARAM_STR);
    $query->bindParam(16, $urlFoto, PDO::PARAM_STR);

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
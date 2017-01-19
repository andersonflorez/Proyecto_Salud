  <?php

/**
* Modelo del main Principal:
* Este modelo se encarga de
*/

class mdlPerfil implements iModel {

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
    
     public function listarComboTipoDocumento() {

    $sql   = "CALL spListarTipodocumento()";
    $query = $this->_CONEXION->prepare($sql);

    if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return false;
    }

  }
    
}

?>
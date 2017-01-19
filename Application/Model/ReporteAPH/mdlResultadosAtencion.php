<?php
class MdlResultadosAtencion implements iModel{
  private static $_INSTANCIA; // Instancia única de esta clase
  private $_CONEXION;         // Variable de conexión PDO

  # Atributos de la clase:
  private $DescripcionAfectado;
  private $EstadoAfectado = 'Activo';
  private $idAfectado;
  private $numero;
  private $usuario;
  private $clave;

  # Constructor:
  private function __construct($_CON) {
    $this->_CONEXION = $_CON;
  }

  function __GET($atributo){
    return $this->$atributo;
  }
  function __SET($atributo,$valor){
    $this->$atributo = $valor;
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

  function ConsultarClaveUsuario() {
        try {
            $usuario = $this->__GET('usuario');
            $sql = "CALL spConsultarClaveUsuario(?)";
            $query = $this->_CONEXION->prepare($sql);
            $query->bindParam(1, $usuario);
            $query->execute();
            if ($query->rowCount() > 0) {
                return $query->fetch();
            } else {
                return false;
            }
        } catch(Exception $e) {
            die('Ha orrido un error: $e');
        }
    }

  function consultarPersonaExistente(){
  $numeroPaciente = $this->__GET("numero");
  $sql = "CALL spConsultarPersonaDocumento(?)";
  $query = $this->_CONEXION->prepare($sql);
  $query->bindParam(1, $numeroPaciente);
  if ($query->execute()) {
   return $query->fetchAll();
 }else{
   return null;
 }
}


function consultarPersona(){
  $numeroPersona = $this->__GET("numero");
  $sql = "CALL spConsultarAllPersonas(?)";
  $query = $this->_CONEXION->prepare($sql);
  $query->bindParam(1, $numeroPersona);
  if ($query->execute()) {
   return $query->fetchAll();
 }else{
   return null;
 }
}




//Inserta un medico en caso que no exista
function insertarMedicoRecibe($datosMedico){
  $sql = "CALL spRegistrarPersona(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
  $query = $this->_CONEXION->prepare($sql);
  for ($i=0; $i < count($datosMedico); $i++) {
    $query->bindParam($i+1,$datosMedico[$i]);
  }
  if ($query->execute()) {
  return true;
}else{
  return false;
}
}


//Lista la ultima persona para insertar en la tabla cuentaUsuario
function UltimaPersona(){
  $sql = "CALL spUltimaPersona()";
  $query = $this->_CONEXION->prepare($sql);
  if ($query->execute()) {

    return $query->fetchAll();
  }else{
    return null;
  }
}

//Función para consultar si la cédula de la persona existe
function validarCedulaPersona(){
  $sql = "CALL spValidarP()";
  $query = $this->_CONEXION->prepare($sql);
  if ($query->execute()) {
    return $query->fetchAll();
  }else{
    return null;
  }
}
//Function para traer el readonly
function MedicoExterno(){
  $sql = "CALL spConsultarMedicoExterno()";
  $query = $this->_CONEXION->prepare($sql);
  if ($query->execute()){
    return $query->fetchAll();
  }else{
    return null;
  }
}

//function para insertar los campos de persona en cuenta de Usuario
function insertarCuentaUsuario($idPersona, $usuario, $clave, $idRol){
  $sql = "CALL spRegistrarCuentausuario(?,?,?,?)";
  $query = $this->_CONEXION->prepare($sql);
  $query->bindParam(1, $idPersona,PDO::PARAM_INT);
  $query->bindParam(2, $usuario);
  $query->bindParam(3, $clave);
  $query->bindParam(4, $idRol);
  if ($query->execute()) {
    return true;
  }else{
    return false;
  }
}


//Llama el tipo de documento que hay insertadas en la tabla tipodocumento
function ListadoTipoDocumento(){
  $sql="CALL spListarTipodocumento()";
  $query = $this->_CONEXION->prepare($sql);
  if ($query->execute()) {
    return $query->fetchAll();
  }else{
    return null;
  }
}

//Valida el médico con usuario y contraseña; que es el correo electronico y la cedula.
function validarMedico(){
  $usuarioRecibe = $this->__GET("usuario");
  $claveRecibe = $this->__GET("clave");
  $sql = "CALL spValidarMedico(?,?)";
  $query = $this->_CONEXION->prepare($sql);
  $query->bindParam(1, $usuarioRecibe);
  $query->bindParam(2, $claveRecibe);
  if ($query->execute()) {
    return $query->fetchAll();
  }else{
    return null;
  }
}

function ListarCertificadoAtencion(){
  try {
      $sql = "CALL `spListarCertificadoatencion`()";
      $query = $this->_CONEXION->prepare($sql);
      if ($query->execute()) {
          return $query->fetchAll();
      }else{
        return null;
      }
  } catch (Exception $e) {
        return null;
  }

}



}









 ?>

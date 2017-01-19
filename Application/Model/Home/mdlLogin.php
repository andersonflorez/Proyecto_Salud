<?php

/**
* Modelo mdlLogin:
* Escribe aqui una descripcion de lo que hace
* este modelo. Copia esta estructura básica y
* utilízala en todos los modelos que necesites
* crear. Todos los modelos deben tener esta
* estructura.
*/

class mdlLogin {

    private static $_INSTANCIA; // Instancia única de esta clase
    private $_CONEXION;
    private $_Usuario;
    private $_Clave;
    private $_idRol;
    private $_idModulo;
    private $_idUsuario;
    private $_idClave;
    private $_idEspecialidad;
    private $_idPersona;
    private $_idVista;    // Variable de conexión PDO

    # Atributos de la clase:


    # Métodos Setter & Getter:
    public function __SET($atributo, $valor){
        $this->$atributo = $valor;
    }

    public function __GET($atributo){
        return $this->$atributo;
    }


    # Constructor:
    public function __construct($_CON){

        try {
            $this->_CONEXION = $_CON;
        } catch (PDOException $e) {
            exit('Error al intentar conectar con la Base de Datos :' + $e);
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

    # Métodos y funciones de la clase:

    function ConsultarClaveUsuario() {
        try {
            $usuario = $this->__GET('_Usuario');
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
            die('Ha ocurrido un error: $e');
        }
    }

    function Login(){

        $sql = "CALL spValidarUsuario(?,?)";
        $usuario =$this->__GET("_Usuario");
        $clave =$this->__GET("_Clave");

        $query = $this->_CONEXION->prepare($sql);
        $query->bindParam(1,$usuario , PDO::PARAM_STR);
        $query->bindParam(2, $clave , PDO::PARAM_STR);

        if ($query->execute()){
            return $query->fetchAll();
        } else {
            return null;
        }

    }

    public function Menu(){

        $sql = "CALL spValidarRolModuloVista(?)";
        $idRol = $this->__GET("_idRol");
        $query = $this->_CONEXION->prepare($sql);
        $query->bindParam(1, $idRol, PDO::PARAM_STR);

        if ($query->execute()) {
            return $query->fetchAll();
        } else {
            return null;
        }

    }

    public function ConsultarModulos() {

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

    public function ConsultarVistas() {

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

    public function ConsultarIdEspecialidad(){

        $sql = "CALL spConsultaridEspecialidad(?)";
        $idPersona = $this->__GET("_idPersona");
        $query = $this->_CONEXION->prepare($sql);
        $query->bindParam(1, $idPersona, PDO::PARAM_STR);

        if ($query->execute()) {
            return $query->fetch();
        } else {
            return null;
        }

    }

    public function ConsultarDescripcionEspecialidad() {

        $sql = "CALL spConsultarEspecialidad(?)";
        $idEspecialidad = $this->__GET("_idEspecialidad");
        $query = $this->_CONEXION->prepare($sql);
        $query->bindParam(1, $idEspecialidad, PDO::PARAM_STR);

        if ($query->execute()) {
            return $query->fetch();
        } else {
            return null;
        }

    }


    public function validarUrl($idRol){
        $sql = "CALL spValidarUrl(?)";
        $query = $this->_CONEXION->prepare($sql);
        $query->bindParam(1, $idRol, PDO::PARAM_INT);

        if ($query->execute()) {
            return $query->fetchAll();
        } else {
            return null;
        }
    }


    //RESTABLECER

    public function RestablecerClave($email) {

        $sql = "CALL spValidarCorreoElectronico(?)";
        $query = $this->_CONEXION->prepare($sql);
        $query->bindParam(1, $email, PDO::PARAM_STR);

        if ($query->execute()) {
            return $query->fetch();
        } else {
            return null;
        }

    }


    public function RegistrarCodigo($email,$codigo,$idUsuario){

        $sql = "update tbl_restablecer set estado = 'Inactivo' where email = :email";
        $query = $this->_CONEXION->prepare($sql);
        $query->bindParam(":email", $email, PDO::PARAM_STR);
        $query->execute();

        $sql = "CALL spRegistrarCodigoReestablecer(?,?,?)";
        $query = $this->_CONEXION->prepare($sql);
        $query->bindParam(1, $email, PDO::PARAM_STR);
        $query->bindParam(2, $codigo, PDO::PARAM_STR);
        $query->bindParam(3, $idUsuario, PDO::PARAM_STR);
        $query->execute();

    }

    public function validarCodigoRestablecer($codigo){
        $sql = "select idRestablecer, idUsuario, fecha from tbl_restablecer where codigo = :codigo and estado = 'Activo'";
        $query = $this->_CONEXION->prepare($sql);
        $query->bindParam(":codigo", $codigo, PDO::PARAM_STR);
        $query->execute();
        return $query->fetch();
    }

    public function cambiarEstadoCodigoRestablecer($id){
        $sql = "update tbl_restablecer set estado = 'Inactivo' where idRestablecer = :id";
        $query = $this->_CONEXION->prepare($sql);
        $query->bindParam(":id", $id, PDO::PARAM_STR);
        $query->execute();
    }


    public function cambiarClaveUsuario($id,$clave){
        $sql = "update tbl_cuentausuario set clave = :clave where idUsuario = :id";
        $query = $this->_CONEXION->prepare($sql);
        $query->bindParam(":clave", $clave, PDO::PARAM_STR);
        $query->bindParam(":id", $id, PDO::PARAM_STR);
        $query->execute();
    }

}

?>

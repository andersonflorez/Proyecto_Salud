<?php
class mdlConsultarPersona implements iModel {

	private static $_INSTANCIA; // Instancia única de esta clase
	private $_CONEXION; // Variable de conexión PDO

	// Constructor:

	private function __construct($_CON)	{

		try {
			$this->_CONEXION = $_CON;
		} catch(PDOException $e) {
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

	function listarComboTipoDocumento()	{

		$sql = "CALL spListarTipodocumento()";
		$query = $this->_CONEXION->prepare($sql);

		if ($query->execute()) {
			return $query->fetchAll();
		}	else {
			return false;
		}

	}

	function ConsultaDatos($codigo)	{

		$sql = "CALL spConsultarPersona(?)";
		$query = $this->_CONEXION->prepare($sql);
		$query->bindParam(1, $codigo);

		if ($query->execute()) {
			return $query->fetch();
		}	else {
			return null;
		}

	}

	function ConsultaDatoRol($codigo)	{

		$sql = "CALL spConsultarCuentausuario(?)";
		$query = $this->_CONEXION->prepare($sql);
		$query->bindParam(1, $codigo);

		if ($query->execute()) {
			return $query->fetch();
		}	else {
			return null;
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

	public function listarComboEspecialidad()	{

		$sql = "CALL spListarEspecialidad()";
		$query = $this->_CONEXION->prepare($sql);

		if ($query->execute()) {
			return $query->fetchAll();
		}	else {
			return false;
		}

	}

	function consultarPersonas() {

		$sql = "CALL spListarPersona()";
		$query = $this->_CONEXION->prepare($sql);

		if ($query->execute()) {
			return $query->fetchAll();
		}	else {
			return null;
		}

	}

	function ConsultarPersonaId($cod)	{

		$sql = 'SELECT * FROM tbl_persona where idPersona=:cod';
		$query = $this->_CONEXION->prepare($sql);
		$query->bindParam(":cod", $cod, PDO::PARAM_STR);

		if ($query->execute()) {
			return $query->fetch();
		}	else {
			return null;
		}
	}

	function ConsultarRol($cod)	{

		$sql = 'SELECT idRol FROM tbl_cuentausuario where idPersona=:cod';
		$query = $this->_CONEXION->prepare($sql);
		$query->bindParam(":cod", $cod, PDO::PARAM_STR);

		if ($query->execute()) {
			return $query->fetch();
		}	else {
			return null;
		}
	}

	public function idUltimaPersona() {

		$sql = "CALL spUltimaPersona()";
		$query = $this->_CONEXION->prepare($sql);

		if ($query->execute()) {
			return $query->fetchAll();
		}	else {
			return false;
		}

	}

	public function CambiarEstadoPersona($idPersona, $estadoTablaPersona) {

		$sql = "CALL spCambiarEstadoPersona(?,?)";
		$query = $this->_CONEXION->prepare($sql);
		$query->bindParam(1, $idPersona);
		$query->bindParam(2, $estadoTablaPersona);

		if ($query->execute()) {
			return true;
		}	else {
			return false;
		}

	}

}

?>

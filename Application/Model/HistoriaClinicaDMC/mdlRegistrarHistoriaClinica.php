<?php

/**
 * Modelo Para desarrolar las instrucciones del CRUD de Las maestras de Historia Clinica de Domiciliaria
 */
class   mdlRegistrarHistoriaClinica implements iModel {

	private static $_INSTANCIA; // Instancia única de esta clase
	private $_CONEXION;         // Variable de conexión PDO

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

	function listarTipoExamenFisico(){
		$sql = "CALL spListarTipoexamenespecializado()";
		$query = $this->_CONEXION->prepare($sql);
		if ($query->execute()) {
			return $query->fetchAll();
		} else {
			return null;
		}
	}

	function listarEspecialidad() {
		$sql = "CALL spListarEspecialidad()";
		$query = $this->_CONEXION->prepare($sql);
		if ($query->execute()) {
			return $query->fetchAll();
		} else {
			return null;
		}
	}

	function listarMedicamento() {
		$sql = "CALL spListarMedicamentodmc()";
		$query = $this->_CONEXION->prepare($sql);
		if ($query->execute()) {
			return $query->fetchAll();
		} else {
			return null;
		}
	}
	function listarCie10(){
		$sql = "CALL spListarCie10()";
		$query =$this->_CONEXION->prepare($sql);
		if ($query->execute()) {
			return $query->fetchAll();
		}else {
			return null;
		}

	}
	function listarTratamiento(){
		$sql = "CALL spListarTipotratamiento()";
		$query =$this->_CONEXION->prepare($sql);
		if ($query->execute()) {
			return $query->fetchAll();
		}else {
			return null;
		}

	}
	function listarEquipo(){
		$sql = "CALL spListarEquipoBiomedicoDmc()";
		$query =$this->_CONEXION->prepare($sql);
		if ($query->execute()) {
			return $query->fetchAll();
		}else {
			return null;
		}

	}

	function listarMedicacion($idPersona){
		$sql = "CALL spListarMedicacion(?)";
		$query =$this->_CONEXION->prepare($sql);
		$query->bindParam(1,$idPersona,PDO::PARAM_STR);
		if ($query->execute()) {
			return $query->fetchAll();
		}else {
			return null;
		}

	}


	function consultarInformacionPersonal($codigo) {
		$sql = "CALL spConsultarPaciente(?)";
		$query = $this->_CONEXION->prepare($sql);
		$query->bindParam(1,$codigo,PDO::PARAM_STR);
		if ($query->execute()) {
			return $query->fetch();
		} else {
			return null;
		}
	}

	function listarTipoDocumento() {
		$sql = "CALL spListarTipodocumento()";
		$query = $this->_CONEXION->prepare($sql);
		if ($query->execute()) {
			return $query->fetchAll();
		} else {
			return null;
		}
	}

	function listarOrigenAtencion() {
		$sql = "CALL spListarTipoorigenatencion()";
		$query = $this->_CONEXION->prepare($sql);
		if ($query->execute()) {
			return $query->fetchAll();
		} else {
			return null;
		}
	}

	function listarTipoAntecedentes() {
		$sql = "CALL spListarTipoantecedente()";
		$query = $this->_CONEXION->prepare($sql);
		if ($query->execute()) {
			return $query->fetchAll();
		} else {
			return null;
		}
	}

	function ListarExamenFisico() {
		$sql = "CALL spListarTipoexamenfisico()";
		$query = $this->_CONEXION->prepare($sql);
		if ($query->execute()) {
			return $query->fetchAll();
		}else{
			return null;
		}
	}

	function comboDiagnostico() {
		$sql = "CALL spListarCie10()";
		$conn=$this->_CONEXION;
		$query=$conn->prepare($sql);
		$query->execute();
		return $query->fetchAll();

	}

	function consultarDescripcionProcedimiento($filtro) {
		$sql = "CALL spconsultarDescripcionProcedimiento(?)";
		$query =$this->_CONEXION->prepare($sql);
		$query->bindParam(1,$filtro,PDO::PARAM_STR);
		$query->execute();
		return $query->fetchAll();

	}

	function consultarDescripcionIdProcedimiento($id) {
		$sql = "CALL spConsultarDescripcionIdProcedimiento(?)";
		$query =$this->_CONEXION->prepare($sql);
		$query->bindParam(1,$id,PDO::PARAM_STR);
		$query->execute();
		return $query->fetch();

	}

	function consultarCodigoIdProcedimiento($id) {
		$sql = "CALL spConsultarCodigoIdProcedimiento(?)";
		$query =$this->_CONEXION->prepare($sql);
		$query->bindParam(1,$id,PDO::PARAM_STR);
		$query->execute();
		return $query->fetch();

	}

	function contarDescripcionProcedimiento($filtro) {
		$sql = "CALL spContarDescripcionProcedimiento(?)";
		$query =$this->_CONEXION->prepare($sql);
		$query->bindParam(1,$filtro,PDO::PARAM_STR);
		$query->execute();
		return $query->fetch();
	}

	function consultarCodigoProcedimiento($filtro) {
		$sql = "CALL spConsultarCodigoProcedimientos(?)";
		$query =$this->_CONEXION->prepare($sql);
		$query->bindParam(1,$filtro,PDO::PARAM_STR);
		$query->execute();
		return $query->fetchAll();
	}


	function contarCodigoProcedimiento($filtro) {
		$sql = "CALL spContarCodigoProcedimiento(?)";
		$query =$this->_CONEXION->prepare($sql);
		$query->bindParam(1,$filtro,PDO::PARAM_STR);
		$query->execute();
		return $query->fetch();
	}

	function consultarDescripcionIdDiagnostico($id) {
		$sql = "CALL spConsultarDescripcionIdDiagnostico(?)";
		$query =$this->_CONEXION->prepare($sql);
		$query->bindParam(1,$id,PDO::PARAM_STR);
		$query->execute();
		return $query->fetch();

	}

	function consultarCodigoIdDiagnostico($id) {
		$sql = "CALL spConsultarCodigoIdDiagnostico(?)";
		$query =$this->_CONEXION->prepare($sql);
		$query->bindParam(1,$id,PDO::PARAM_STR);
		$query->execute();
		return $query->fetch();

	}

	function consultarDescripcionDiagnostico($filtro) {
		$sql = "CALL spConsultarDescripcionDiagnostico(?)";
		$query =$this->_CONEXION->prepare($sql);
		$query->bindParam(1,$filtro,PDO::PARAM_STR);
		$query->execute();
		return $query->fetchAll();

	}


	function contarDescripcionDiagnostico($filtro) {
		$sql = "CALL spContarDiagnostico(?)";
		$query =$this->_CONEXION->prepare($sql);
		$query->bindParam(1,$filtro,PDO::PARAM_STR);
		$query->execute();
		return $query->fetch();
	}

	function consultarCodigoDiagnostico($filtro) {
		$sql = "CALL spConsultarCodigoDiagnostico(?)";
		$query =$this->_CONEXION->prepare($sql);
		$query->bindParam(1,$filtro,PDO::PARAM_STR);
		$query->execute();
		return $query->fetchAll();
	}


	function contarCodigoDiagnostico($filtro) {
		$sql = "CALL spContarCodigoDiagnostico(?)";
		$query =$this->_CONEXION->prepare($sql);
		$query->bindParam(1,$filtro,PDO::PARAM_STR);
		$query->execute();
		return $query->fetch();
	}


	function actualizarInformacionPersonal($idPaciente,$estadoCivil,$ciudadResidencia,$barrioResidencia,$direccion,$correoElectronico,$telefonoFijo,$telefonoMovil,$empresa,$ocupacion){
		$sql = "CALL spActualizarInformacionPersonal(?,?,?,?,?,?,?,?,?,?)";
		$query =$this->_CONEXION->prepare($sql);
		$query->bindParam(1,$estadoCivil,PDO::PARAM_STR);
		$query->bindParam(2,$ciudadResidencia,PDO::PARAM_STR);
		$query->bindParam(3,$barrioResidencia,PDO::PARAM_STR);
		$query->bindParam(4,$direccion,PDO::PARAM_STR);
		$query->bindParam(5,$correoElectronico,PDO::PARAM_STR);
		$query->bindParam(6,$telefonoFijo,PDO::PARAM_STR);
		$query->bindParam(7,$telefonoMovil,PDO::PARAM_STR);
		$query->bindParam(8,$empresa,PDO::PARAM_STR);
		$query->bindParam(9,$ocupacion,PDO::PARAM_STR);
		$query->bindParam(10,$idPaciente,PDO::PARAM_STR);
		if ($query->execute()) {
			return true;
		}else {
			return null;
		}
	}

	function registrarTipoOrigenAtencion($descripcion){
		$sql = "CALL spRegistrarTipoOrigenAtencionOtro(?)";
		$query = $this->_CONEXION->prepare($sql);
		$query->bindParam(1,$descripcion,PDO::PARAM_STR);
		$query->execute();
		$sql = "CALL spUltimoDatoOrigenAtencion()";
		$query = $this->_CONEXION->prepare($sql);
		$query->execute();
		return $query->fetch();
	}

	function registrarHistoriaClinica($fechaAtencion,$motivoAtencion,$enfermedadActual,$placaVehiculo,$idTipoOrigenAtencion,$idCitaProgramacion,$idPaciente,$evolucion){
		$sql = "CALL spRegistrarHistoriaClinicaDmc(?,?,?,?,?,?,?,?)";
		$query = $this->_CONEXION->prepare($sql);
		$query->bindParam(1,$fechaAtencion,PDO::PARAM_STR);
		$query->bindParam(2,$motivoAtencion,PDO::PARAM_STR);
		$query->bindParam(3,$enfermedadActual,PDO::PARAM_STR);
		$query->bindParam(4,$placaVehiculo,PDO::PARAM_STR);
		$query->bindParam(5,$idTipoOrigenAtencion,PDO::PARAM_STR);
		$query->bindParam(6,$idCitaProgramacion,PDO::PARAM_STR);
		$query->bindParam(7,$idPaciente,PDO::PARAM_STR);
		$query->bindParam(8,$evolucion,PDO::PARAM_STR);
		$query->execute();

		$sql ="CALL spUltimoIdHistoriaClinica()";
		$query = $this->_CONEXION->prepare($sql);
		$query->execute();
		return $query->fetch();
	}

	function registrarAntecedente($descripcionAntecedente,$idTipoAntecedente,$idHistoriaClinica){
		$sql = "CALL spRegistrarAntecedentesDmc (?,?,?)";
		$query = $this->_CONEXION->prepare($sql);
		$query->bindParam(1,$descripcionAntecedente,PDO::PARAM_STR);
		$query->bindParam(2,$idTipoAntecedente,PDO::PARAM_STR);
		$query->bindParam(3,$idHistoriaClinica,PDO::PARAM_STR);
		$query->execute();

	}

	function registrarExamenFisico($descripcion,$idTipoExamenFisico,$estado,$idHistoriaClinica){
		$sql = "CALL spRegistrarExamenFisico(?,?,?,?)";
		$query = $this->_CONEXION->prepare($sql);
		$query->bindParam(1,$descripcion,PDO::PARAM_STR);
		$query->bindParam(2,$idTipoExamenFisico,PDO::PARAM_STR);
		$query->bindParam(3,$estado,PDO::PARAM_STR);
		$query->bindParam(4,$idHistoriaClinica,PDO::PARAM_STR);
		$query->execute();

	}

	function registrarDiagnostico($descripcion,$idCIE10,$idHistoriaClinica){
		$sql = "CALL spRegistrarDiagnostico(?,?,?)";
		$query = $this->_CONEXION->prepare($sql);
		$query->bindParam(1,$descripcion,PDO::PARAM_STR);
		$query->bindParam(2,$idCIE10,PDO::PARAM_STR);
		$query->bindParam(3,$idHistoriaClinica,PDO::PARAM_STR);
		$query->execute();

	}

	function registrarProcedimiento($descripcion,$idCUP,$idHistoriaClinica){
		$sql = "CALL spRegistrarProcedimiento(?,?,?)";
		$query = $this->_CONEXION->prepare($sql);
		$query->bindParam(1,$descripcion,PDO::PARAM_STR);
		$query->bindParam(2,$idCUP,PDO::PARAM_STR);
		$query->bindParam(3,$idHistoriaClinica,PDO::PARAM_STR);
		$query->execute();

	}

	function registrarSignosVitales($resultado,$hora,$idValoracion,$idHistoriaClinica){
		$sql = "CALL spRegistrarSignosVitales(?,?,?,?)";
		$query = $this->_CONEXION->prepare($sql);
		$query->bindParam(1,$resultado,PDO::PARAM_NULL);
		$query->bindParam(2,$hora,PDO::PARAM_NULL);
		$query->bindParam(3,$idValoracion,PDO::PARAM_NULL);
		$query->bindParam(4,$idHistoriaClinica,PDO::PARAM_NULL);
		$query->execute();
	}


	//update tbl_detallekit dt1,(select cantidadFinal-3 as nuevaCantidad from tbl_detallekit where idDetallekit = 1)as dt2 set dt1.cantidadFinal = dt2.nuevaCantidad where idDetallekit = 1
	function registrarMedicacion($dosis,$hora,$viaAdministracion,$cantidadUnidades,$idDetalleKit,$idHistoriaClinica){
		$sql = "CALL spRegistrarMedicacionDmc(?,?,?,?,?,?)";
		$query = $this->_CONEXION->prepare($sql);
		$query->bindParam(1,$dosis,PDO::PARAM_STR);
		$query->bindParam(2,$hora,PDO::PARAM_STR);
		$query->bindParam(3,$viaAdministracion,PDO::PARAM_STR);
		$query->bindParam(4,$cantidadUnidades,PDO::PARAM_STR);
		$query->bindParam(5,$idDetalleKit,PDO::PARAM_STR);
		$query->bindParam(6,$idHistoriaClinica,PDO::PARAM_STR);
		$query->execute();
		$sql = "CALL spActualizarMedicacionDmc(?,?)";
		$query = $this->_CONEXION->prepare($sql);
		$query->bindParam(1,$cantidadUnidades,PDO::PARAM_INT);
		$query->bindParam(2,$idDetalleKit,PDO::PARAM_STR);
		$query->execute();

	}


	function registrarTipoTratamiento($descripcion){
		$sql = "CALL spRegistrarTTratamiento(?)";
		$query = $this->_CONEXION->prepare($sql);
		$query->bindParam(1,$descripcion,PDO::PARAM_STR);
		$query->execute();
		$sql = "CALL spUltimoIdTTratamiento()";
		$query = $this->_CONEXION->prepare($sql);
		$query->execute();
		return $query->fetch();
	}

	function registrarTratamiento($descripcion,$fecha,$dosis,$idHistoriaClinica,$idTipoTratamiento){
		$sql = "CALL spRegistrarTratamiento(?,?,?,?,?)";
		$query = $this->_CONEXION->prepare($sql);
		$query->bindParam(1,$descripcion,PDO::PARAM_STR);
		$query->bindParam(2,$fecha,PDO::PARAM_STR);
		$query->bindParam(3,$dosis,PDO::PARAM_STR);
		$query->bindParam(4,$idHistoriaClinica,PDO::PARAM_STR);
		$query->bindParam(5,$idTipoTratamiento,PDO::PARAM_STR);
		$query->execute();
		$sql = "CALL spUltimoIdTratamiento()";
		$query = $this->_CONEXION->prepare($sql);
		$query->execute();
		return $query->fetch();
	}

	function registrarDetalleTratamientoEquipoBiomedico($idTratamiento,$descripcion){
		$sql = "CALL spRegistrarDetalleTratamientoEquipoBiomedico(?,?)";
		$query = $this->_CONEXION->prepare($sql);
		$query->bindParam(1,$descripcion);
		$query->bindParam(2,$idTratamiento);
		$query->execute();
	}

	function registrarDetalleTratamientoRecurso($idTratamiento,$idRecurso){
		$sql = "CALL spRegistrarDetalletratamientodmcrecurso(?,?)";
		$query = $this->_CONEXION->prepare($sql);
		$query->bindParam(1,$idRecurso);
		$query->bindParam(2,$idTratamiento);
		$query->execute();
		var_dump($idTratamiento);
		var_dump($idRecurso);

	}

	function registrarFormulaMedica($recomendacion,$idHistoriaClinica){
		$sql = "CALL spRegistrarFormulaMedica(?,?)";
		$query = $this->_CONEXION->prepare($sql);
		$query->bindParam(1,$recomendacion,PDO::PARAM_STR);
		$query->bindParam(2,$idHistoriaClinica,PDO::PARAM_STR);
		$query->execute();
		$sql = "CALL spUltimoIdFormula()";
		$query = $this->_CONEXION->prepare($sql);
		$query->execute();
		return $query->fetch();
	}

	function registrarFormulaMedicaMedicamentos($dosificacion,$descripcion,$cantidadMedicamento,$idMedicamento,$idFormulaMedica){
		$sql = "CALL spRegistrarFormulaMedicamento(?,?,?,?,?)"; 
		$query = $this->_CONEXION->prepare($sql);
		$query->bindParam(1,$dosificacion,PDO::PARAM_STR);
		$query->bindParam(2,$descripcion,PDO::PARAM_STR);
		$query->bindParam(3,$cantidadMedicamento,PDO::PARAM_STR);
		$query->bindParam(4,$idMedicamento,PDO::PARAM_STR);
		$query->bindParam(5,$idFormulaMedica,PDO::PARAM_STR);
		$query->execute();
	}

	function registrarTipoExamenEspecializado($descripcion){
		$sql = "CALL spRegistrarTExamenesEspecializados(?)";
		$query = $this->_CONEXION->prepare($sql);
		$query->bindParam(1,$descripcion,PDO::PARAM_STR);
		$query->execute();
		$sql = "CALL spUltimoIdTipoEspecializado()";
		$query = $this->_CONEXION->prepare($sql);
		$query->execute();
		return $query->fetch();
	}

	function registrarExamenEspecializado($historiaClinica, $observacion, $idTipoExamenEspecializado,$descripcion){
		$sql = "CALL spRegistrarExameneEspecializado(?,?,?,?)";
		$query = $this->_CONEXION->prepare($sql);
		$query->bindParam(1,$historiaClinica,PDO::PARAM_STR);
		$query->bindParam(2,$observacion,PDO::PARAM_STR);
		$query->bindParam(3,$idTipoExamenEspecializado,PDO::PARAM_STR);
		$query->bindParam(4,$descripcion,PDO::PARAM_STR);
		$query->execute();

	}
	function registrarInterconsulta($descripcion,$especialidad,$idHistoriaClinica,$fechaLimite){
		$sql = "CALL spRegistrarInterconsulta(?,?,?,?)";
		$query =$this->_CONEXION->prepare($sql);
		$query->bindParam(1,$descripcion,PDO::PARAM_STR);
		$query->bindParam(2,$especialidad,PDO::PARAM_STR);
		$query->bindParam(3,$idHistoriaClinica,PDO::PARAM_STR);
		$query->bindParam(4,$fechaLimite,PDO::PARAM_STR);
		$query->execute();
	}

	function registrarIncapacidad($numeroDias,$descripcion,$idCie10,$prorroga,$idHistoriaClinica){
		$sql = "CALL spRegistrarIncapacidad(?,?,?,?,?)";
		$query =$this->_CONEXION->prepare($sql);
		$query->bindParam(1,$numeroDias,PDO::PARAM_STR);
		$query->bindParam(2,$prorroga,PDO::PARAM_STR);
		$query->bindParam(3,$descripcion,PDO::PARAM_STR);
		$query->bindParam(4,$idCie10,PDO::PARAM_STR);
		$query->bindParam(5,$idHistoriaClinica,PDO::PARAM_STR);
		$query->execute();
	}

	function registrarOtro($descripcion,$idHistoriaClinica){
		$sql = "CALL spRegistrarOtroDmc(?,?)";
		$query =$this->_CONEXION->prepare($sql);
		$query->bindParam(1,$descripcion,PDO::PARAM_STR);
		$query->bindParam(2,$idHistoriaClinica,PDO::PARAM_STR);
		$query->execute();
	}

	function cambiarEstadoCita($idCita){
		$sql = "CALL spCambiarEstadoCita(?)";
		$query =$this->_CONEXION->prepare($sql);
		$query->bindParam(1,$idCita,PDO::PARAM_STR);
		$query->execute();
	}

}
?>
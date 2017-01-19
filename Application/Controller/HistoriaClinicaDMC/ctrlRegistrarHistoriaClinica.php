<?php
header('Content-Type: text/html; charset=UTF-8');
class CtrlRegistrarHistoriaClinica extends Controller{
	private $mdlHistoriaClinica = null;
	private $scripts;
	private $styles;
	private $vistasMenu;


	function __construct() {
		Sesion::init();
		if (!Sesion::exist()) {
			header("Location: ".URL);
		}
		$this->mdlHistoriaClinica = $this->loadModel('HistoriaClinicaDMC', 'mdlRegistrarHistoriaClinica');
	}

	public function index($idPaciente,$idCita,$idCitaProgramacion) {
		$this->vistasMenu = json_decode(Sesion::getValue('VISTAS_MENU'));
		$this->styles =array(
			'Todos/sweetalert.css',
			"HistoriaClinicaDMC/preloader.css"
		);
		$this->scripts =array(
			'Todos/sweetalert.js',
			"HistoriaClinicaDMC/registrar/scriptHistoriaClinica.js"
		);

		require APP . 'View/_layout/header.php';
		require APP . 'View/HistoriaClinicaDMC/viewRegistrarHistoriaClinica.php';
		require APP . 'View/_layout/footer.php';
		echo '<script> var idPaciente="'.$idPaciente.'";var idCita="'.$idCita.'";var idCitaProgramacion="'.$idCitaProgramacion.'";</script>';
	}

	public function registrarInformacionPersonal($idPaciente){
		$respuesta = $this->mdlHistoriaClinica->actualizarInformacionPersonal(base64_decode($idPaciente),$_POST["cmbEstadoCivil"],$_POST["txtCiudadResidencia"],$_POST["txtBarrioResidencia"],$_POST["txtDireccion"],$_POST["txtCorreoElectronico"],$_POST["txtTelefonoFijo"],$_POST["txtTelefonoCelular"],$_POST["txtEmpresa"],$_POST["txtOcupacion"]);
		if($respuesta){
			echo true;
		}else{
			echo false;
		}
	}

	public function registrarTipoOrigenAtencion(){
		$query = $this->mdlHistoriaClinica->registrarTipoOrigenAtencion(base64_decode($_POST["txtDescripcion"]));
		echo base64_encode($query->id);
	}

	public function registrarHistoriaClinica(){
		date_default_timezone_set("America/Bogota");
		$fechaAtencion = getDate();
		$query = $this->mdlHistoriaClinica->registrarHistoriaClinica($fechaAtencion['year']."/".$fechaAtencion['mon']."/".$fechaAtencion['mday'], nl2br($_POST["motivoAtencion"]), nl2br($_POST["enfermedadActual"]), $_POST["placaVehiculo"], base64_decode($_POST["idTipoOrigenAtencion"]), base64_decode($_POST["idCitaProgramacion"]), base64_decode($_POST["idPaciente"]),$_POST["evolucion"]);
		echo base64_encode($query->id);
	}

	public function registrarAntecedente(){
		$idHistoriaClinica = $_POST["idHistoriaClinica"];
		$datos = json_decode($_POST["datos"]);
		foreach($datos as $registro){
			$this->mdlHistoriaClinica->registrarAntecedente($registro->descripcion,base64_decode($registro->id),base64_decode($idHistoriaClinica));
		}
	}

	public function registrarExamenFisico(){
		$idHistoriaClinica = $_POST["idHistoriaClinica"];
		$datos = json_decode($_POST["datos"]);
		foreach($datos as $registro){
			$this->mdlHistoriaClinica->registrarExamenFisico($registro->descripcion,base64_decode($registro->id),$registro->estado,base64_decode($idHistoriaClinica));
		}
	}

	public function registrarDiagnostico(){
		$idHistoriaClinica = $_POST["idHistoriaClinica"];
		$datos = json_decode($_POST["datos"]);
		foreach($datos as $registro){
			$this->mdlHistoriaClinica->registrarDiagnostico($registro->descripcion,base64_decode($registro->id),base64_decode($idHistoriaClinica));
		}
	}

	public function registrarProcedimiento(){
		$idHistoriaClinica = $_POST["idHistoriaClinica"];
		$datos = json_decode($_POST["datos"]);
		foreach($datos as $registro){
			$this->mdlHistoriaClinica->registrarProcedimiento($registro->descripcion,base64_decode($registro->id),base64_decode($idHistoriaClinica));
		}
	}

	public function registrarSignosVitales(){
		$idHistoriaClinica = $_POST["idHistoriaClinica"];
		$datos = json_decode($_POST["datos"]);

		foreach($datos as $registro){
			if($registro->resultado == ""){
				$resultado = null;
			}else{

				$resultado = $registro->resultado;
			}

			if($registro->hora == ""){
				$hora = null;
			}else{
				$hora = $registro->hora;
			}

			if($registro->idValoracion == ""){
				$idValoracion = null;
			}else{
				$idValoracion = $registro->idValoracion;
			}
			$this->mdlHistoriaClinica->registrarSignosVitales($resultado,$hora,base64_decode($idValoracion),base64_decode($idHistoriaClinica));

		}
	}

	public function registrarMedicacion(){
		$idHistoriaClinica = $_POST["idHistoriaClinica"];
		$datos = json_decode($_POST["datos"]);
		foreach($datos as $registro){
			$this->mdlHistoriaClinica->registrarMedicacion($registro->dosis,$registro->hora,$registro->viaAdministracion,$registro->cantidad,base64_decode($registro->id),base64_decode($idHistoriaClinica));
		}
	}

	public function registrarTipoTratamiento(){
		$descripcion = base64_decode($_POST["txtDescripcion"]);
		$query = $this->mdlHistoriaClinica->registrarTipoTratamiento($descripcion);
		echo base64_encode($query->id);
	}

	public function registrarTratamiento(){
		$idHistoriaClinica = $_POST["idHistoriaClinica"];
		$datos = json_decode($_POST["datos"]);
		$idTipoTratamiento = $_POST["idTipoTratamiento"];

		$query = $this->mdlHistoriaClinica->registrarTratamiento($datos->descripcion,$datos->fechaLimite,$datos->dosis,base64_decode($idHistoriaClinica),base64_decode($idTipoTratamiento));
		echo base64_encode($query->id);
	}


	public function registrarDetalleTratamiento(){
		$idTratamiento = $_POST["idTratamiento"];
		$datos = json_decode(base64_decode($_POST["datos"]));
		for($i =0 ;$i<count($datos);$i++){

			if($datos[$i]->estado == "v"){
				$this->mdlHistoriaClinica->registrarDetalleTratamientoRecurso(base64_decode($idTratamiento),base64_decode($datos[$i]->id));
			}else{
				$this->mdlHistoriaClinica->registrarDetalleTratamientoEquipoBiomedico(base64_decode($idTratamiento),base64_decode($datos[$i]->id));
			}
		}
	}

	public function registrarFormulaMedica(){
		$idHistoriaClinica = $_POST["idHistoriaClinica"];
		$recomendacion = $_POST["recomendacion"];

		$query = $this->mdlHistoriaClinica->registrarFormulaMedica($recomendacion, base64_decode($idHistoriaClinica));
		echo base64_encode($query->id);
	}

	public function registrarFormulaMedicaMedicamentos(){
		$idFormulaMedica = $_POST["idFormulaMedica"];
		$datos = json_decode(base64_decode($_POST["datos"]));
		var_dump(base64_decode($_POST["datos"]));
		foreach($datos as $registro){
			$this->mdlHistoriaClinica->registrarFormulaMedicaMedicamentos($registro->dosificacion,$registro->descripcion,$registro->cantidad,base64_decode($registro->id),base64_decode($idFormulaMedica));
		}
	}

	public function registrarTipoExamenEspecializado(){
		$descripcion = base64_decode($_POST["txtDescripcion"]);

		$query = $this->mdlHistoriaClinica->registrarTipoExamenEspecializado($descripcion);
		echo base64_encode($query->id);
	}

	public function registrarExamenEspecializado(){
		$query = $this->mdlHistoriaClinica->registrarExamenEspecializado(base64_decode($_POST["idHistoriaClinica"]),$_POST["observacion"],base64_decode($_POST["idTipoExamenEspecializado"]),$_POST["descripcion"]);
	}

	public function registrarInterconsulta(){
		$idHistoriaClinica =$_POST["idHistoriaClinica"];
		$datos = json_decode(base64_decode($_POST["datos"]));
		$this->mdlHistoriaClinica->registrarInterconsulta($datos->descripcion,base64_decode($datos->tipoInterconsulta),base64_decode($idHistoriaClinica),$datos->fecha);
	}

	public function registrarIncapacidad(){
		$idHistoriaClinica =$_POST["idHistoriaClinica"];
		$datos = json_decode(base64_decode($_POST["datos"]));
        var_dump(base64_decode($_POST["datos"]));
		$this->mdlHistoriaClinica->registrarIncapacidad($datos->numeroDias,$datos->descripcion,base64_decode($datos->diagnostico),$datos->prorroga,base64_decode($idHistoriaClinica));
	}

	public function registrarOtro(){
		$idHistoriaClinica =$_POST["idHistoriaClinica"];
		$descripcion = base64_decode($_POST["datos"]);
		$this->mdlHistoriaClinica->registrarOtro($descripcion,base64_decode($idHistoriaClinica));
	}

	public function cambiarEstadoCita(){
		$idCita =$_POST["idCita"];
		$this->mdlHistoriaClinica->cambiarEstadoCita(base64_decode($idCita));
	}

}

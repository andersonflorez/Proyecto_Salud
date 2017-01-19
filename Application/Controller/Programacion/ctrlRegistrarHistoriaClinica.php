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

	public function index() {
		$this->vistasMenu = json_decode(Sesion::getValue('VISTAS_MENU'));
		$this->styles =array(
			'Todos/sweetalert.css',
			"HistoriaClinicaDMC/preloader.css"
		);
		$this->scripts =array(
			'Todos/sweetalert.js',
			//"HistoriaClinicaDMC/registrar/scriptHistoriaClinica.js"
		);

		require APP . 'View/_layout/header.php';
		require APP . 'View/Programacion/viewRegistrarHistoriaClinica.php';
		require APP . 'View/_layout/footer.php';
		//echo '<script> var idPaciente="'.$idPaciente.'";var idCita="'.$idCita.'";var idCitaProgramacion="'.$idCitaProgramacion.'";</script>';
	}


}

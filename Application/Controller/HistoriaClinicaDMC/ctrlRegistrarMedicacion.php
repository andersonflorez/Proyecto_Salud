<?php
class CtrlRegistrarMedicacion extends Controller{
    private $mdlmedicacion = null;
    private $mdlCita = null;
    private $scrips;
    private $styles;
    private $vistasMenu;


    function __construct() {
        Sesion::init();
        if (!Sesion::exist()) {
            header("Location: ".URL);
        }
        $this->mdlmedicacion = $this->loadModel('HistoriaClinicaDMC', 'mdlRegistrarHistoriaClinica');
        $this->mdlCita = $this->loadModel('HistoriaClinicaDMC', 'mdlConsultarCita');
    }
    public function index($idPaciente,$idCita,$idCitaProgramacion) {
         $this->vistasMenu = json_decode(Sesion::getValue('VISTAS_MENU'));
        $this->styles =array (
            "HistoriaClinicaDMC/style.css"
								);
        $this->scripts = array (
            "HistoriaClinicaDMC/registrar/scriptMedicacion.js",
            "HistoriaClinicaDMC/datatables.js"
								);
        require APP . 'View/_layout/header.php';
        require APP . 'View/HistoriaClinicaDMC/viewRegistrarMedicacion.php';
        require APP . 'View/_layout/footer.php';
        echo '<script> var idPaciente="'.$idPaciente.'";var idCita="'.$idCita.'";var idCitaProgramacion="'.$idCitaProgramacion.'";var horaCita="'.substr($this->mdlCita->consultarHoraCita(base64_decode($idCita))->horaInicial,0,-3).'";</script>';
    }
    function ListarComboMedicacion(){
        $id = $_SESSION["ID_PERSONA"];
        $ComboM = $this->mdlmedicacion->listarMedicacion($id);
        echo json_encode($ComboM);
    }


}

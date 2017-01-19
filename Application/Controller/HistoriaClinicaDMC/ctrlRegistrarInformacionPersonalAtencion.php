<?php
header('Content-Type: text/html; charset=UTF-8');
class CtrlRegistrarInformacionPersonalAtencion extends Controller{
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
        $idPaciente = base64_decode($idPaciente);

        $this->styles =array(
            'Todos/sweetalert.css',
            "HistoriaClinicaDMC/style.css"
        );
        $this->scripts= array(
            "HistoriaClinicaDMC/registrar/scriptInformacionPersonalAtencion.js",
            'Todos/sweetalert.js',
            "Validaciones/Functions_Validation.js"
        );
        $tiposOrigen = $this->mdlHistoriaClinica->listarOrigenAtencion();
        $queryInformacionPersonal = $this->mdlHistoriaClinica->consultarInformacionPersonal($idPaciente);
        $queryTipoDocumento = $this->mdlHistoriaClinica->listarTipoDocumento();
        require APP . 'View/_layout/header.php';
        require APP . 'View/HistoriaClinicaDMC/viewRegistrarInformacionPersonalAtencion.php';
        require APP . 'View/_layout/footer.php';
        echo '<script> var idPaciente="'.base64_encode($idPaciente).'";var idCita="'.$idCita.'";var idCitaProgramacion="'.$idCitaProgramacion.'";</script>';
        echo '<script>$("#cmbEstadoCivil > option[value='."'". $queryInformacionPersonal->estadoCivil."'".']").attr("selected","selected");</script>';
    }

}

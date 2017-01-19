<?php

class CtrlRegistrarAntecedentesExamenes extends Controller{
    private $mdlHistoriaClinica = null;
    private $styles;
    private $scripts;
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
        $this->styles = array (
            "HistoriaClinicaDMC/style.css"
        );
        $this->scripts = array (
            "HistoriaClinicaDMC/registrar/scriptAntecedentesExamenes.js",
            "Validaciones/Functions_Validation.js"

        );

        $queryTipoAntecedentes = $this->mdlHistoriaClinica->listarTipoAntecedentes();
        $queryListarExamenFisico = $this->mdlHistoriaClinica->ListarExamenFisico();
        require APP . 'View/_layout/header.php';
        require APP . 'View/HistoriaClinicaDMC/viewRegistrarAntecedentesExamenes.php';
        require APP . 'View/_layout/footer.php';
        echo '<script> var idPaciente="'.$idPaciente.'";var idCita="'.$idCita.'";var idCitaProgramacion="'.$idCitaProgramacion.'";</script>';
    }


}

?>

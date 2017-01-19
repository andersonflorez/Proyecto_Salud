<?php

class CtrlRegistrarSignosVitales extends Controller{
    private $mdlconsultarCita = null;
    private $scripts;
    private $styles;
private $vistasMenu;


    function __construct() {
        Sesion::init();
        if (!Sesion::exist()) {
            header("Location: ".URL);
        }
        
        $this->mdlconsultarCita = $this->loadModel('HistoriaClinicaDMC','mdlConsultarCita');
    }

    public function index($idPaciente,$idCita,$idCitaProgramacion) {
         $this->vistasMenu = json_decode(Sesion::getValue('VISTAS_MENU'));
        $this->styles =array(
            'Todos/sweetalert.css',
            "HistoriaClinicaDMC/style.css"
        );
        $this->scripts= array(
            'Todos/sweetalert.js',
            "Validaciones/Functions_Validation.js",
            'HistoriaClinicaDMC/registrar/scriptSignosVitales.js'
        );
        require APP . 'View/_layout/header.php';
        require APP . 'View/HistoriaClinicaDMC/viewRegistrarSignosVitales.php';
        require APP . 'View/_layout/footer.php';
        echo '<script> var idPaciente="'.$idPaciente.'";var idCita="'.$idCita.'";var idCitaProgramacion="'.$idCitaProgramacion.'";var horaCita="'.substr($this->mdlconsultarCita->consultarHoraCita(base64_decode($idCita))->horaInicial,0,-3).'";</script>';
        
    }
    
    
}


<?php
class CtrlRegistrarOrdenesMedicas extends Controller{
    private $mdlRegistrarHistoriaClinica = null;
    private $styles;
    private $scripts;
    private $vistasMenu;


    function __construct() {
        Sesion::init();
        if (!Sesion::exist()) {
            header("Location: ".URL);
        }
        $this->mdlRegistrarHistoriaClinica = $this->loadModel('HistoriaClinicaDMC', 'mdlRegistrarHistoriaClinica');

    }

    public function index($idPaciente,$idCita,$idCitaProgramacion) {
         $this->vistasMenu = json_decode(Sesion::getValue('VISTAS_MENU'));
        $this->scripts = array (
            'Todos/sweetalert.js',
            "HistoriaClinicaDMC/datatables.js",
            "HistoriaClinicaDMC/registrar/scriptOrdenesMedicas/scriptValidaciones.js",
            "HistoriaClinicaDMC/registrar/scriptOrdenesMedicas/scriptGeneral.js",
            "HistoriaClinicaDMC/registrar/scriptOrdenesMedicas/scriptTratamiento.js",
            "HistoriaClinicaDMC/registrar/scriptOrdenesMedicas/scriptFormulaMedica.js",
            "HistoriaClinicaDMC/registrar/scriptOrdenesMedicas/scriptExamenEspecializado.js",
            "HistoriaClinicaDMC/registrar/scriptOrdenesMedicas/scriptInterconsulta.js",
            "HistoriaClinicaDMC/registrar/scriptOrdenesMedicas/scriptIncapacidad.js",
            "HistoriaClinicaDMC/registrar/scriptOrdenesMedicas/scriptOtro.js",
            "HistoriaClinicaDMC/es.js"

        );
        $this->styles = array (
            'Todos/sweetalert.css',
            "HistoriaClinicaDMC/style.css"
        );

        require APP . 'View/_layout/header.php';
        require APP . 'View/HistoriaClinicaDMC/viewRegistrarOrdenesMedicas.php';
        require APP . 'View/_layout/footer.php';
        echo '<script> var idPaciente="'.$idPaciente.'";var idCita="'.$idCita.'";var idCitaProgramacion="'.$idCitaProgramacion.'";</script>';

    }

    public function consultarTipoExamenEspecializado(){
        $query = $this->mdlRegistrarHistoriaClinica->listarTipoExamenFisico();
        echo json_encode($query);
    }

    public function consultarEspecialidad(){
        $query = $this->mdlRegistrarHistoriaClinica->listarEspecialidad();
        echo json_encode($query);
    }

    public function consultarMedicamentos(){
        $query = $this->mdlRegistrarHistoriaClinica->listarMedicamento();
        echo json_encode($query);
    }
    public function consultarCie10(){
        $query = $this->mdlRegistrarHistoriaClinica->listarCie10();
        echo json_encode($query);
    }
    public function consultarTratamiento(){
        $query = $this->mdlRegistrarHistoriaClinica->listarTratamiento();
        echo json_encode($query);
    }
    public function consultarEquipo(){
        $query = $this->mdlRegistrarHistoriaClinica->listarEquipo();
        echo json_encode($query);
    }



}

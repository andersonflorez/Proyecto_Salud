<?php

class CtrlConsultarHistoria extends Controller{
    private $mdlAtencion = null;

    private $styles;
    private $scripts;
private $vistasMenu;


    function __construct() {
        Sesion::init();
        if (!Sesion::exist()) {
            header("Location: ".URL);
        }
        $this->mdlAtencion=$this->loadModel('HistoriaClinicaDMC','MdlConsultarHistoria');
    }

    public function Index() {
      $this->vistasMenu = json_decode(Sesion::getValue('VISTAS_MENU'));

        $this->styles= array(
            'Todos/sweetalert.css',
            "HistoriaClinicaDMC/style.css",
            "Maestras/jquery.dataTables.css"
        );
        $this->scripts= array(
            'Todos/sweetalert.js',
            "HistoriaClinicaDMC/datatables.js",
            "HistoriaClinicaDMC/consultar/scriptConsultarHistoria.js"
        );

        require APP . 'View/_layout/header.php';
        require APP . 'View/HistoriaClinicaDMC/viewConsultarHistoria.php';
        require APP . 'View/_layout/footer.php';

    }

    function listarHistoriaClinica(){
        $listar =$this->mdlAtencion->consultarIndex();
        echo json_encode($listar);
    }
}

?>

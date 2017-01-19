<?php

class CtrlConsultarTratamiento extends Controller{
    private $mdlAtencion = null;

    private $styles;
    private $scripts;
private $vistasMenu;


    function __construct() {
        Sesion::init();
        if (!Sesion::exist()) {
            header("Location: ".URL);
        }
        $this->mdlAtencion=$this->loadModel('Stock','mdlConsultarTratamiento');
    }

    public function Index() {
      $this->vistasMenu = json_decode(Sesion::getValue('VISTAS_MENU'));

        $this->styles= array(
            'Todos/sweetalert.css',
            "Stock/style.css",
            "Maestras/jquery.dataTables.css"
        );
        $this->scripts= array(
            'Todos/sweetalert.js',
            "Stock/datatables.js",
            "Stock/consultar/scriptConsultarTratamiento.js"
        );

        require APP . 'View/_layout/header.php';
        require APP . 'View/Stock/viewConsultarTratamiento.php';
        require APP . 'View/_layout/footer.php';

    }

    function ListarTratamiento(){
        $listar =$this->mdlAtencion->consultarIndex();
        echo json_encode($listar);
    }




}

?>

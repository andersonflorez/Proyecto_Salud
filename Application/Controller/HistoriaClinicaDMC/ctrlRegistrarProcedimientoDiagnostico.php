<?php
class CtrlRegistrarProcedimientoDiagnostico extends Controller{
    private $mdlHistoriaClinica = null;
    private $scrips;
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
        $this->styles =array (
            "HistoriaClinicaDMC/style.css"

        );  
        $this->scripts = array (
            "HistoriaClinicaDMC/registrar/scriptProcedimientoDiagnostico.js",
            "HistoriaClinicaDMC/es.js"
        );
        require APP . 'View/_layout/header.php';
        require APP . 'View/HistoriaClinicaDMC/viewRegistrarProcedimientoDiagnostico.php';
        require APP . 'View/_layout/footer.php';
        echo '<script> var idPaciente="'.$idPaciente.'";var idCita="'.$idCita.'";var idCitaProgramacion="'.$idCitaProgramacion.'";</script>';
    }

    function consultarDescripcionCup(){
        $query = $this->mdlHistoriaClinica->consultarDescripcionProcedimiento($_POST["q"]);
        $cantidad = $this->mdlHistoriaClinica->contarDescripcionProcedimiento($_POST["q"]);
        $datos = array(
            "items"=>$query,
            "total"=>$cantidad->cont
        );
        echo json_encode($datos);
    }

    function consultarDescripcionIdCup(){
        $query = $this->mdlHistoriaClinica->consultarDescripcionIdProcedimiento($_POST["id"]);
        echo $query->nombreCup;
    }

    function consultarCodigoCup(){
        $query = $this->mdlHistoriaClinica->consultarCodigoProcedimiento($_POST["q"]);
        $cantidad = $this->mdlHistoriaClinica->contarCodigoProcedimiento($_POST["q"]);
        $datos = array(
            "items"=>$query,
            "total"=>$cantidad->cont
        );
        echo json_encode($datos);
    }

    function consultarCodigoIdCup(){
        $query = $this->mdlHistoriaClinica->consultarCodigoIdProcedimiento($_POST["id"]);
        echo $query->codigoCup;
    }
    
    

    function consultarDescripcionCie10(){
        $query = $this->mdlHistoriaClinica->consultarDescripcionDiagnostico($_POST["q"]);
        $cantidad = $this->mdlHistoriaClinica->contarDescripcionDiagnostico($_POST["q"]);
        $datos = array(
            "items"=>$query,
            "total"=>$cantidad->cont
        );
        echo json_encode($datos);
    }

    function consultarDescripcionIdCie10(){
        $query = $this->mdlHistoriaClinica->consultarDescripcionIdDiagnostico($_POST["id"]);
        echo $query->descripcionCIE10;
    }

    function consultarCodigoCie10(){
        $query = $this->mdlHistoriaClinica->consultarCodigoDiagnostico($_POST["q"]);
        $cantidad = $this->mdlHistoriaClinica->contarCodigoDiagnostico($_POST["q"]);
        $datos = array(
            "items"=>$query,
            "total"=>$cantidad->cont
        );
        echo json_encode($datos);
    }

    function consultarCodigoIdCie10(){
        $query = $this->mdlHistoriaClinica->consultarCodigoIdDiagnostico($_POST["id"]);
        echo $query->codigoCIE10;
    }

}



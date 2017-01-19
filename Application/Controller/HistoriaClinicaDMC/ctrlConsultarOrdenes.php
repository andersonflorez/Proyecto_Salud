<?php

class CtrlConsultarOrdenes extends Controller{
    private $mdlOrdenes = null;

    private $styles;
    private $scripts;
    private $vistasMenu;

    function __construct() {
        Sesion::init();
        if (!Sesion::exist()) {
            header("Location: ".URL);
        }
        $this->mdlOrdenes=$this->loadModel('HistoriaClinicaDMC','MdlConsultarOrdenes');
    }

    public function Index($idAtencion,$idPersona) {
        $this->vistasMenu = json_decode(Sesion::getValue('VISTAS_MENU'));

        $this->styles= array(
            'Todos/sweetalert.css',
            "HistoriaClinicaDMC/style.css",
            "Maestras/jquery.dataTables.css"

        );
        $this->scripts= array(
            'Todos/sweetalert.js',
            "HistoriaClinicaDMC/datatables.js",
            "HistoriaClinicaDMC/Consultar/scriptConsultarOrdenes.js"
        );
    $email = $this->mdlOrdenes->consultarEmailPaciente(base64_decode($idPersona));

        require APP . 'View/_layout/header.php';
        require APP . 'View/HistoriaClinicaDMC/viewConsultarOrdenes.php';
        require APP . 'View/_layout/footer.php';
        echo "<script>var idAtencion = '".$idAtencion."';</script>";
        echo "<script>var idPersona = '".$idPersona."';</script>";
        echo "<script>var emailPaciente = '".$email."';</script>";

    }

    function consultarDatos(){
      $datos = [];
      $dato1 = $this->mdlOrdenes->consultarPersona(base64_decode($_POST["idAtencion"]));
      $dato2 = $this->mdlOrdenes->consultarPaciente(base64_decode($_POST["idPersona"]));
      $dato3 = $this->mdlOrdenes->consultarFechaAtencion(base64_decode($_POST["idAtencion"]));
      $datos = array('Fecha' => $dato3,'Medico' => $dato1, 'Paciente' => $dato2);

      echo json_encode($datos);
    }

    function listarHistoriaClinica(){
        $listar =$this->mdlOrdenes->consultarIndex();
        echo json_encode($listar);
    }
    //Funcion para consultar el tratamiento
    function consultarTratamiento(){
        $queryConsultarTratamiento=$this->mdlOrdenes->consultarTratamiento(base64_decode($_POST["idAtencion"]));
        echo json_encode($queryConsultarTratamiento);

    }
    function consultarDetalleTratamiento(){
        $queryconsultarDetalleTratamiento=$this->mdlOrdenes->consultarDetalleTratamiento(base64_decode($_POST["idTratamiento"]));
        echo json_encode($queryconsultarDetalleTratamiento);
    }

    function consultarEquipoBiomedicoTratamiento(){
        $queryconsultarDetalleTratamiento=$this->mdlOrdenes->consultarEquipoBiomedicoTratamiento(base64_decode($_POST["idTratamiento"]));
        echo json_encode($queryconsultarDetalleTratamiento);
    }

    //Funcion para consultarFormulaMedica
    function consultarFormula(){
        $queryconsultarFormula=$this->mdlOrdenes->consultarFormulaMedica(base64_decode($_POST["idAtencion"]));
        echo json_encode($queryconsultarFormula);
    }
    function consultarDetalleFormula(){
        $queryDetalleFormula=$this->mdlOrdenes->consultarDetalleFormula(base64_decode($_POST["idFormula"]));
        echo json_encode($queryDetalleFormula);
    }
    //Funcion consultar Examenes Especializados
    function consultarExamenEspecializado(){
        $queryconsultarExamenE=$this->mdlOrdenes->consultarExamenEspecializado(base64_decode($_POST["idAtencion"]));
        echo json_encode($queryconsultarExamenE);
    }
    //Funcion consultar Interconsulta
    function consultarInterconsulta(){
        $queryconsultarInterconsulta=$this->mdlOrdenes->consultarInterconsulta(base64_decode($_POST["idAtencion"]));
        echo json_encode($queryconsultarInterconsulta);
    }
    //Funcion para consultar incapacidad
    function consultarIncapacidad(){
        $queryconsultarIncapacidad=$this->mdlOrdenes->consultarIncapacidad(base64_decode($_POST["idAtencion"]));
        echo json_encode($queryconsultarIncapacidad);
    }
    //Funcion para consultar otro tipo de orden medica
    function consultarOtro(){
        $queryconsultarOtro=$this->mdlOrdenes->consultarOtro(base64_decode($_POST["idAtencion"]));
        echo json_encode($queryconsultarOtro);
    }
}

?>

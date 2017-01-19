<?php

class CtrlConsultarAtencion extends Controller {
    private $mdlConsultarAtencion = null;
    private $mdlConsultarInformacion = null;
    private $mdlPaginacion = null;

    private $styles;
    private $scripts;
    private $vistasMenu;


    function __construct() {
        Sesion::init();
        if (!Sesion::exist()) {
            header("Location: ".URL);
        }
        
        $this->mdlConsultarAtencion=$this->loadModel('HistoriaClinicaDMC','MdlConsultarAtencion');
        $this->mdlConsultarInformacion=$this->loadModel('HistoriaClinicaDMC','mdlRegistrarHistoriaClinica');
        $this->mdlPaginacion = $this->loadModel('HistoriaClinicaDMC','mdlPaginacionHC');
    }

    public function Index($idPaciente) {
        $this->vistasMenu = json_decode(Sesion::getValue('VISTAS_MENU'));
        $this->styles = array(
            'HistoriaClinicaDMC/style.css',
            'Todos/sweetalert.css',
            "Maestras/jquery.dataTables.css"
        );

        $this->scripts = array(
            "Todos/Paginador.js",
            'Todos/sweetalert.js',
            "HistoriaClinicaDMC/datatables.js",
            "HistoriaClinicaDMC/consultar/scriptConsultarAtencion.js",
            "HistoriaClinicaDMC/registrar/scriptOrdenesMedicas/scriptValidaciones.js",
            "Todos/modal.js"
        );
        $queryInformacionPersonal = $this->mdlConsultarInformacion->consultarInformacionPersonal(base64_decode($idPaciente));
        $queryAtencion=$this->mdlConsultarAtencion->consultarAtencion(base64_decode($idPaciente));
        require APP . 'View/_layout/header.php';
        require APP . 'View/HistoriaClinicaDMC/viewConsultarAtencion.php';
        require APP . 'View/_layout/footer.php';
        echo "<script>var idPersona='".$idPaciente."';</script>";
    }

    function consultarAtenciones($idPaciente){
        $datos = $_POST;
        $datos["tableName"] = "viewconsultaratencion";
        $datos['nameColumnOrderBy'] = $datos['nameColumnFilter'];


        switch ((int) $datos['nameColumnOrderBy']) {
            case 1:
                $datos['nameColumnOrderBy'] = 'idHistoriaClinica';
                break;

            case 2:
                $datos['nameColumnOrderBy'] = 'primerNombre';
                break;

            case 3:
                $datos['nameColumnOrderBy'] = 'primerApellido';
                break;

            case 4:
                $datos['nameColumnOrderBy'] = 'numeroDocumento';
                break;

            default:
                $datos['nameColumnOrderBy'] = 'idHistoriaClinica';
                $datos['orderBy'] = 'DESC';
                break;
        }


        if (!empty($datos['filter'])) {
            // Opciones select buscar por:
            switch ((int) $datos['nameColumnFilter']) {
                case 1:
                    $datos['nameColumnFilter'] = 'idHistoriaClinica';
                    $datos['nameColumnOrderBy'] = 'idHistoriaClinica';
                    break;

                case 2:
                    $datos['nameColumnFilter'] = 'primerNombre';
                    $datos['nameColumnOrderBy'] = 'primerNombre';
                    break;

                case 3:
                    $datos['nameColumnFilter'] = 'primerApellido';
                    $datos['nameColumnOrderBy'] = 'primerApellido';
                    break;

                case 4:
                    $datos['nameColumnFilter'] = 'numeroDocumento';
                    $datos['nameColumnOrderBy'] = 'numeroDocumento';
                    break;

                default:
                    $datos['nameColumnFilter'] = '';
                    $datos['filter'] = '';
                    break;
            }

            $new_arr = array_map('trim', explode(",", $datos['filter']));
            $new_arr = array_filter($new_arr, "strlen");
            $stringArray = '';
            $i = 0;
            foreach ($new_arr as $value) {
                $coma = ($i !== (count($new_arr) - 1) ) ? ',':'';
                $stringArray .= $value . $coma;
                $i++;
            }
            $datos['filter'] = $stringArray;

        }else {
            $datos['nameColumnFilter'] = '';
            $datos['filter'] = '';
        }
        if(empty($datos["filterDateTimeStart"]) && empty($datos["filterDateTimeEnd"])){
            $datos['nameColumnDateTime'] = '';
        }else{
            $datos['nameColumnDateTime'] = 'fechaAtencion';
        }
        $res = $this->mdlPaginacion->consultar($datos,base64_decode($idPaciente),"idPaciente");
        echo json_encode($res);
    }


    function consultarAtencedentes(){
        $queryAntecedente=$this->mdlConsultarAtencion->consultarAntecedentes(base64_decode($_POST["idAtencion"]));
        echo json_encode($queryAntecedente);
    }
    function consultarExamenesFisicos(){
        $queryExamenFisico=$this->mdlConsultarAtencion->consultarExamenFisico(base64_decode($_POST["idAtencion"]));
        echo json_encode($queryExamenFisico);
    }

    function consultarMedicacion(){
        $queryMedicacion=$this->mdlConsultarAtencion->consultarMedicacion(base64_decode($_POST["idAtencion"]));
        echo json_encode($queryMedicacion);
    }
    function consultarOrigenAtencion(){
        $queryOrigenAtencion=$this->mdlConsultarAtencion->consultarOrigenAtencion(base64_decode($_POST["idAtencion"]));
        echo json_encode($queryOrigenAtencion);
    }
    function consultarDiagnosticos(){
        $queryDiagnostico=$this->mdlConsultarAtencion->consultarDiagnostico(base64_decode($_POST["idAtencion"]));
        echo json_encode($queryDiagnostico);
    }
    function consultarProcedimiento(){
        $queryProcedimiento=$this->mdlConsultarAtencion->consultarProcedimiento(base64_decode($_POST["idAtencion"]));
        echo json_encode($queryProcedimiento);
    }
    function registarNotaEnfermeria(){
        $queryNotaEnfermeria=$this->mdlConsultarAtencion->registarNotasEnfermeria(nl2br($_POST["descripcion"]),base64_decode($_POST["idProcedimiento"]),$_SESSION["ID_PERSONA"]);
    }
    function consultarAtencion(){
        $queryAtencion=$this->mdlConsultarAtencion->consultarOrigenAtencion(base64_decode($_POST["idAtencion"]));
        echo json_encode($queryAtencion);
    }

    function consultarSignosVitales(){
        $querySignosVitalesHora=$this->mdlConsultarAtencion->consultarHoraSignosVitales(base64_decode($_POST["idAtencion"]));
        $querySignosVitalesResultado=$this->mdlConsultarAtencion->consultarResultadoSignosVitales(base64_decode($_POST["idAtencion"]));
        echo json_encode([$querySignosVitalesHora,$querySignosVitalesResultado]);
    }
    function consultarNotasEnfermeria(){
        $queryConsultarNotasProcedi=$this->mdlConsultarAtencion->consultarProcedimientoNotas(base64_decode($_POST["idProcedimiento"]));
        echo json_encode($queryConsultarNotasProcedi);

    }

}


?>

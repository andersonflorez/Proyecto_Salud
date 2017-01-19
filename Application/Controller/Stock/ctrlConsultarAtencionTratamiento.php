<?php

class ctrlConsultarAtencionTratamiento extends Controller {
    private $mdlConsultarAtencionTratamiento = null;
    private $mdlConsultarInformacion = null;
    private $styles;
    private $scripts;
private $vistasMenu;
private $objPagination = null;


    function __construct() {
        Sesion::init();
        if (!Sesion::exist()) {
            header("Location: ".URL);
        }
        $this->MdlConsultarAtencionTratamiento=$this->loadModel('Stock','mdlConsultarAtencionTratamiento');
        $this->mdlConsultarInformacion=$this->loadModel('Stock','mdlRegistrarHistoriaClinica');
        $this->objPagination = $this->loadModel('Stock', 'mdlPaginacion');
    }

    public function ListarPrestamos() {
      //error_reporting(0);s
      $configPaginador = $_POST;
      $res = $this->objPagination->Paginate($configPaginador);
      echo json_encode($res);
    }

    public function Index($idPaciente) {
      $this->vistasMenu = json_decode(Sesion::getValue('VISTAS_MENU'));
        $this->styles = array(
            'Stock/style.css',
            'Todos/sweetalert.css',
            "Maestras/jquery.dataTables.css"
        );

        $this->scripts = array(
            'Todos/sweetalert.js',
            "Stock/datatables.js",
            "Todos/Paginador.js",
            "Stock/consultar/scriptConsultarAtencion.js",
            "Stock/consultar/scriptComoQuiera.js",
            "Todos/modal.js"
        );
        $queryInformacionPersonal = $this->mdlConsultarInformacion->consultarInformacionPersonal(base64_decode($idPaciente));
        $queryAtencion=$this->MdlConsultarAtencionTratamiento->consultarAtencionTratamiento(base64_decode($idPaciente));
      //  var_dump($queryAtencion);
        require APP . 'View/_layout/header.php';
        require APP . 'View/Stock/viewConsultarAtencionTratamiento.php';
        require APP . 'View/_layout/footer.php';
        echo "<script>var idPaciente='".$idPaciente."';</script>";
    }

    function consultarAtencedentes(){
        $queryAntecedente=$this->MdlConsultarAtencionTratamiento->consultarAntecedentes(base64_decode($_POST["idAtencion"]));
        echo json_encode($queryAntecedente);
    }
    function consultarMedicacion(){
        $queryMedicacion=$this->MdlConsultarAtencionTratamiento->consultarMedicacion(base64_decode($_POST["idAtencion"]));
        echo json_encode($queryMedicacion);
    }
    function consultarOrigenAtencion(){
        $queryOrigenAtencion=$this->MdlConsultarAtencionTratamiento->consultarOrigenAtencion(base64_decode($_POST["idAtencion"]));
        echo json_encode($queryOrigenAtencion);
    }
    function consultarAtencion(){
        $queryAtencion=$this->MdlConsultarAtencionTratamiento->consultarOrigenAtencion(base64_decode($_POST["idAtencion"]));
        echo json_encode($queryAtencion);
    }


function consultarAtenciones($idPaciente){
    $datos = $_POST;
    $datos["tableName"] = "viewconsultarprestamos";
    $datos['nameColumnOrderBy'] = $datos['nameColumnFilter'];


    switch ((int) $datos['nameColumnOrderBy']) {
        case 1:
            $datos['nameColumnOrderBy'] = 'idHistoriaClinica';
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
    $res = $this->objPagination->consultar($datos,base64_decode($idPaciente),"idPaciente");
    echo json_encode($res);
}
}

?>

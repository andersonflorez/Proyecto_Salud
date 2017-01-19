<?php
class CtrlConsultarCita extends Controller implements iController{
    private $mdlconsultarCita = null;
    private $mdlPaginacion = null;
    private $scripts;
    private $styles;
    private $vistasMenu;


    function __construct() {
        Sesion::init();
        if (!Sesion::exist()) {
            header("Location: ".URL);
        }
        $this->mdlconsultarCita = $this->loadModel('HistoriaClinicaDMC','mdlConsultarCita');
        $this->mdlPaginacion = $this->loadModel('HistoriaClinicaDMC','mdlPaginacionHC');
    }

    public function index() {

        $this->vistasMenu = json_decode(Sesion::getValue('VISTAS_MENU'));
        $this->styles= array(
            'Todos/sweetalert.css',
            "HistoriaClinicaDMC/style.css"
        );
        $this->scripts= array(
            "Todos/Paginador.js",
            'Todos/sweetalert.js',
            'Todos/Maestras/ComportamientoMenu.js',
            "HistoriaClinicaDMC/Consultar/scriptConsultarCita.js"
        );
        require APP . 'View/_layout/header.php';
        require APP . 'View/HistoriaClinicaDMC/viewConsultarCita.php';
        require APP . 'View/_layout/footer.php';
    }

    function ListarCitas(){
        $id = $_SESSION["ID_PERSONA"];
        $datos = $_POST;
        $datos["tableName"] = "viewconsultarcitamedico";

        if (!empty($datos['filter'])) {
            // Opciones select buscar por:
            switch ((int) $datos['nameColumnFilter']) {
                case 1:
                    $datos['nameColumnFilter'] = 'primerNombre';
                    break;

                case 2:
                    $datos['nameColumnFilter'] = 'primerApellido';
                    break;

                case 3:
                    $datos['nameColumnFilter'] = 'numeroDocumento';
                    break;

                case 4:
                    $datos['nameColumnFilter'] = 'direccionCita';
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

        $res = $this->mdlPaginacion->consultar($datos,$id,"idPersona");
        echo json_encode($res);
    }


    function cancelarCita(){
          $fecha = date("Y")."-".date("m")."-".date("d");

          $this->mdlconsultarCita->__SET("_descripcion",$_POST['des']);
          $this->mdlconsultarCita->__SET("_idCita", $_POST['idCita']);
          $this->mdlconsultarCita->__SET("_fecha",$fecha);

          $cancela = $this->mdlconsultarCita->cancelarCita();
          if ($cancela == 0) {
            $this->mdlconsultarCita->cambiarEstado();
          }
          echo $cancela;

    }

    function consultarCitaPersona($id){
        $this->mdlconsultarCita->__SET("_id",$id);
        $consulta = $this->mdlconsultarCita->consultarCitaPersona();
        echo json_encode($consulta);
    }
    function cambiarEstadoProceso($id){
        $this->mdlconsultarCita->__SET("_id",$id);
        $res = $this->mdlconsultarCita->cambiarEstadoProceso();
        echo json_encode($res);
    }
}

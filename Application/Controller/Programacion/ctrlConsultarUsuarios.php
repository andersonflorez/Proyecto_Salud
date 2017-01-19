<?php
header('Content-Type: text/html; charset=UTF-8');
class ctrlConsultarUsuarios extends Controller {
    private $mdlUsuarios = null;
    private $vistasMenu;


    function __construct() {
        Sesion::init();
        if (!Sesion::exist()) {
            header("Location: ".URL);
        }
        $this->mdlUsuarios = $this->loadModel('Programacion', 'mdlUsuarios');
    }

    public function Index(){
        $this->vistasMenu = json_decode(Sesion::getValue('VISTAS_MENU'));
        $this->styles = array(
            "Todos/sweetalert.css",
            "Maestras/jquery.dataTables.css"
            // Y asi sucesivamente, separando con comas (,) cada estilo.css
        );

        // Cargar JAVASCRIPTS de 'ViewAlgunaVista.php':
        $this->scripts = array(
            "Programacion/ConsultarUsuarios.js",
            "Todos/Maestras/datatables.js",
            "Todos/modal.js",
            "Todos/Maestras/ComportamientoMenu.js",
            "Validaciones/Standard_Validations.js",
            "Todos/sweetalert.js"


      // Y asi sucesivamente, separando con comas (,) cada script.js
    );
    // Luego se debe cargar la vista:
    require APP . 'View/_layout/header.php';
    require APP . 'View/Programacion/Viewusuarios.php';
    require APP . 'View/_layout/footer.php';

    }

    public function consultarPersona() {
        $queryusuarios = $this->mdlUsuarios->consultarPersona();
        echo json_encode($queryusuarios);
    }

public function consultarPersonatodo($id){
    $id = base64_decode($id);
$INFO = $this->mdlUsuarios->consultarPersonatodo($id);
$this->scripts = array(
"Programacion/ConsultarUsuarios.js",
"Todos/Maestras/datatables.js",
"Todos/modal.js",
"Todos/Maestras/ComportamientoMenu.js",
"Validaciones/Standard_Validations.js",
"Todos/sweetalert.js" );
 $this->vistasMenu = json_decode(Sesion::getValue('VISTAS_MENU'));
 $this->styles = array(
"Todos/sweetalert.css",
 "Maestras/jquery.dataTables.css" );
 require APP . 'View/_layout/header.php';
 require APP . 'View/Programacion/ViewverInfo.php';
require APP . 'View/_layout/footer.php';

}

    public function consultarturno(){
        $idtu = $_POST["id"] != null ? $_POST["id"] : 0;
        $turno = $this->mdlUsuarios->consultarturno($idtu);
        
        if ($turno!=null) {
            echo json_encode($turno);
        }else{
            echo json_encode("0");
        }
    }
public function validarcitas(){
  $idp = $_POST["id"];
$citasion = $this->mdlUsuarios->citasagendadas($idp);
if ($citasion!=null) {
  echo json_encode($citasion);
}else{
  echo json_encode("0");
}
}
public function listarcitas($idt){
  $idt = base64_decode($idt);
$consultorio = $this->mdlUsuarios->consultarcitas($idt);
}

function programacionVencidas(){
  $fecha = date('Y-m-d');
  $res =  $this->mdlUsuarios->programacionesVencidas($fecha);
  foreach ($res as $key ){
    $id = $key->idTurnoProgramacion;
    $in = (int)$id;
    $this->mdlUsuarios->actualizarProgramaciones($in);
  }
}
}
?>

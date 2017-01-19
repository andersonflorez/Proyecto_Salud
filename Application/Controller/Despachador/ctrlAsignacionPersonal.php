<?php

/**
* NOMBRE DE LA CLASE: ControlNombreDelControlador
* TIPO DE CLASE: Controlador
* DESCRIPCIÓN:
* Escribe aqui la descripción de lo que hace este controlador.
* Copia este formato de controlador para todos los controladores
* que necesites crear ya que todos deben tener esta estructura.
*/
class ctrlAsignacionPersonal extends Controller implements iController {

  // NOTA: Revisar el archivo 'COMO LINKEAR CSS - IMG - JS.txt' para entender
  // las dos siguientes lineas de código:
  private $styles;
  private $scripts;
  private $_mdlAsignacionPersonal = null;
  private $_mdlDetalleAsignacion = null;
  private $objPagination;
  private $vistasMenu;
  /**
  * Método constructor()
  * Inicializa el uso de variables de sesión y
  * valida si hay una sesión abierta, sino la hay
  * redirecciona hacia el login de la aplicación:
  */
  public function __construct() {

  Sesion::init();

    if (!Sesion::exist()) {

      header("Location: " . URL);
      exit();

    } else if (Sesion::getValue('TIPO_USUARIO') === 'ADMINISTRADOR') {

      $this->mdlAsignacionPersonal = $this->loadModel('Despachador','mdlAsignacionPersonal');
    $this->mdlDetalleAsignacion = $this->loadModel('Despachador','mdlDetalleAsignacion');
    $this->objPagination = $this->loadModel('Otros', 'mdlPagination');

    } else {

      header('Location: ' . URL . 'Error/Error');
      exit();

    }

}

/**
* Método Index() obligatorio
* Renedriza la página principal de este controlador (ej: 'View/Home/index.php')
*/
public function Index() {

  $this->vistasMenu = json_decode(Sesion::getValue('VISTAS_MENU'));

  $this->styles = array(
    "Despachador/style.css",
    "Despachador/radio.css",
    "Despachador/leaflet.css",
    "Todos/sweetalert.css"
  );

  // Cargar JAVASCRIPTS de 'Asignación del personal':
  $this->scripts = array(
    "Despachador/leaflet.js",
    "Despachador/GeolocalizacionAsignacion.js",
    "Todos/Paginador.js",
    "Despachador/AsignacionPersonal.js",
    "Todos/sweetalert.js"

  );


  require APP . 'View/_layout/header.php'; // Carga la barra de navegación y los CSS
  require APP . 'View/Despachador/ViewAsignacionPersonal.php'; // Carga nuestra vista
  require APP . 'View/_layout/footer.php'; // Carga los Javascripts


}

public function ListarAmbulancias() {
  //error_reporting(0);
  $configPaginador = $_POST;
  $res = $this->objPagination->Paginate($configPaginador);
  echo json_encode($res);
}

public function ListarPersonal() {
  //error_reporting(0);
  $configuracion = $_POST;
  $res = $this->objPagination->Paginate($configuracion);
  echo json_encode($res);
}

public function registrarAsignacion(){
  //  var_dump($_POST);
  $idAmbulancia = $_POST['TxtAmbulancia'];

  $longitud = $_POST['TxtLongitud'];
  $latitud = $_POST['TxtLatitud'];
  $personaU =  $_POST['personaU'];
  $personaD =  $_POST['personaD'];
  $personaT =  $_POST['personaT'];
  date_default_timezone_set('America/Bogota');
  $timestamp = date("Y-m-d H:i:s");
  $estadoAsignacion = "Activo";
  $estadoAmbulancia = "Personal Asignado";
  $cargoPersonaU = "Líder";
  $cargoPersonaD = "Tripulante";
  $cargoPersonaT = "Tripulante";
  //var_dump($pesonaU,$pesonaD,$pesonaT);
  $registrarAsignacion = $this->mdlAsignacionPersonal->registrarAsignacionPersonal($idAmbulancia,$timestamp,$estadoAsignacion,$longitud,$latitud);
  if ($registrarAsignacion == true) {
    $ultimo = $this->mdlDetalleAsignacion->capturarUltimoID();
    $idAsignacion = $ultimo->ultimo;



    $regDetalleU = $this->mdlDetalleAsignacion->registrarDetalleAsignacion($personaU,$idAsignacion,$estadoAsignacion,$cargoPersonaU);
    $ActualizarDetalleU = $this->mdlDetalleAsignacion->ActualizarEstadoPersona($personaU);
    $regDetalleD= $this->mdlDetalleAsignacion->registrarDetalleAsignacion($personaD,$idAsignacion,$estadoAsignacion,$cargoPersonaD);
    $ActualizarDetalleD = $this->mdlDetalleAsignacion->ActualizarEstadoPersona($personaD);
    $regDetalleT = $this->mdlDetalleAsignacion->registrarDetalleAsignacion($personaT,$idAsignacion,$estadoAsignacion,$cargoPersonaT);
    $ActualizarDetalleT = $this->mdlDetalleAsignacion->ActualizarEstadoPersona($personaT);
    $actualizarEstadoAmbulancia = $this->mdlAsignacionPersonal->ActualizarEstadoAmbulancia($idAmbulancia,$estadoAmbulancia);



    echo json_encode(['Bien']);
  }else{
    echo json_encode(['Mal']);
  }

}


}

?>

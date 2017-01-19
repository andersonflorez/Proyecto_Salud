<?php

/**
* NOMBRE DE LA CLASE: CtrlDespacho
* TIPO DE CLASE: Controlador
* DESCRIPCIÓN:
* Escribe aqui la descripción de lo que hace este controlador.
* Copia este formato de controlador para todos los controladores
* que necesites crear ya que todos deben tener esta estructura.
*/
class CtrlDespacho extends Controller implements iController {

  // NOTA: Revisar el archivo 'COMO LINKEAR CSS - IMG - JS.txt' para entender
  // las dos siguientes lineas de código:
  private $styles;
  private $scripts;
  private $objDespacho = null;
  private $vistasMenu;
  private $objPagination;
  private $notificaciones = true;
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

    } else if (Sesion::getValue('TIPO_USUARIO') === 'PARAMEDICO' || Sesion::getValue('TIPO_USUARIO') === 'ADMINISTRADOR' || Sesion::getValue('TIPO_USUARIO') === 'MEDICO' || Sesion::getValue('TIPO_USUARIO') === 'DESPACHADOR') {

      $this->objDespacho = $this->loadModel('Despachador', 'mdlDespacho');
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
      "Despachador/leaflet.css",
      "Despachador/styleLeaflet.css",
      "Despachador/estilo.css",
      "Todos/sweetalert.css"
    );

    // Cargar JAVASCRIPTS de 'Asignación del personal':
    $this->scripts = array(
      'Lib/fancywebsocket.js',
      'Despachador/leaflet.js',
      "Despachador/check.js",
      "Despachador/tabs.js",
      "Lib/select2.js",
      "Todos/Paginador.js",
      "Despachador/Despacho.js",
      "Todos/sweetalert.js",
      'Despachador/socket_registro_despacho.js'
    );


    require APP . 'View/_layout/header.php'; // Carga la barra de navegación y los CSS
    require APP . 'View/Despachador/viewRegistrarDespacho.php'; // Carga nuestra vista
    require APP . 'View/_layout/footer.php'; // Carga los Javascripts


  }

public function Ejemplo(){
    echo "Si entre a la función común y corriente";
}

  public function ListarReportes() {
  //error_reporting(0);
  $configPaginador = $_POST;
  $res = $this->objPagination->Paginate($configPaginador);
  echo json_encode($res);
}

  public function RegistrarDespacho(){
    $this->objDespacho->__SET("_idReporteIni", $_POST['txtidReporte']);
    $this->objDespacho->__SET("_idAmbu",$_POST['txtidAmbulancia']);
    $this->objDespacho->__SET("_estadoDespa",$_POST['txtEstado']);
    $this->objDespacho->__SET("_longiE",$_POST['txtLong']);
    $this->objDespacho->__SET("_latiEm",$_POST['txtLati']);
    $this->objDespacho->__SET("_idPersona",Sesion::getValue('ID_USUARIO'));
    $this->objDespacho->__SET("_estadoTabla","En proceso");
    $this->objDespacho->__SET("_esatdoReporte","Despachado");

    date_default_timezone_set('America/Bogota');
    $timestamp = date("Y-m-d H:i:s");
    $this->objDespacho->__SET("_fechaHd",$timestamp);

   $regDespacho= $this->objDespacho->InsertarDespacho();
    if ($regDespacho == true) {
      $actualizarEstado = $this->objDespacho->ActualizarEstadoAmbulancia();
      if ($actualizarEstado == true) {
        $actualizarReporte = $this->objDespacho->ActualizarEstadoReporteInicial();
        if ($actualizarReporte == true) {
          echo json_encode($regDespacho);
        }
      }

    }else{
      echo json_encode("0");
    }
  }

  public function RegistrarDespachoNovedad(){
$this->objDespacho->__SET("_idReporteInicial",$_POST['txtReporteInicial']);
$this->objDespacho->__SET("_idAmbulancia",$_POST['txtIdAmbulancia']);
$this->objDespacho->__SET("_estadoDespacho",$_POST['txtEstadoDespacho']);
$this->objDespacho->__SET("_Longitud ",$_POST['txtLongitud']);
$this->objDespacho->__SET("_LatitudEmergencia",$_POST['txtLatitud']);
$this->objDespacho->__SET("_idPersona",$_POST['txtIdPersona']);
$this->objDespacho->__SET("_estado","En proceso");
$this->objDespacho->__SET("_idNovedad",$_POST['txtNovedad']);

date_default_timezone_set('America/Bogota');
$timestamp = date("Y-m-d H:i:s");
   $this->objDespacho->__SET("_fechaHd",$timestamp);

    $regDespacho= $this->objDespacho->InsertarDespacho();
    if ($regDespacho == true) {
      $actualizarEstado = $this->objDespacho->ActualizarEstadoAmbulancia();
      $actualizar = $this->objDespacho->ActualizarEstadoNovedad();
      if ($actualizarEstado == true) {
        if ($actualizar == true) {
          echo 1;
        }else{
          echo 0;
        }
      }

    }else{
      echo 0;
    }
  }

  public function ListadoReporte() {
    $Listar = $this->objDespacho->ListadoReporteI();
    echo json_encode($Listar);
  }

  public function ListadoMarcadores() {
    $ListarM = $this->objDespacho->ListarMarcadoresAmulancias();
    echo json_encode($ListarM);
  }

  public function ListarNovedades(){
    $ListarNovedad = $this->objDespacho->ListarNovedadReporte();
    echo json_encode($ListarNovedad);
  }



}

?>

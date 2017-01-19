<?php

/**
* NOMBRE DE LA CLASE: ctrlReporteInicialAPH
* Se encarga de consultar toda la información
* referente al despacho de la ambulancia
*/
class ctrlReporteInicialAPH extends Controller implements iController {
  private $styles;
  private $scripts;
  private $vistasMenu;
  private $menuEmergencia = true;

  private $_mdlLayout = null;


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
    }

    // Si la var de sesion esModoConsulta no existe redirecciona al index
    if (is_null(Sesion::getValue("esModoConsulta"))) {
      header("Location: " . URL . "ReporteAPH/CtrlIndex");
    }
    if(!Sesion::varExist('VISTAS_BARRA_PROGRESO')){

      $vistas = array(
        "ctrlInformacionGeneral" => true,
        "ctrlTipoEvento" => false,
        "ctrlMotivoConsulta" => false,
        "ctrlAntecedentesPaciente" => false,
        "ctrlLocalizacionLesiones" => false,
        "ctrlTratamientoB" => false,
        "ctrlTratamientoA" => false,
        "ctrlMedicamento" => false,
        "ctrlResultadosAtencion" => false
      );
      Sesion::SetValue('VISTAS_BARRA_PROGRESO',$vistas);

    }




    $this->_mdlLayout = $this->loadModel('ReporteAPH', 'mdlLayoutReporteAPH');

  }


  /**
  * Método Index() obligatorio
  * Renedriza la página principal de este
  * controlador (ej: 'View/Home/ReporteInicialAPH.php')
  */
  public function Index() {
    // RENDERIZA EL MENÚ DE NAVEGACIÓN
    $this->vistasMenu = json_decode(Sesion::getValue('VISTAS_MENU'));

    // CARGAR CSS
    $this->styles = array(
      'ReporteAPH/Descripcion.css',
      'ReporteAPH/leaflet.css',
      'ReporteAPH/leaflet-routing-machine.css',
      'ReporteAPH/estilo.css',
      'ReporteAPH/sweetalert.css',
      'ReporteAPH/leaflet.extra-markers.css'
    );

    // CARGAR JAVASCRIPTS
    $this->scripts = array(
      'ReporteAPH/generalScript.js',
      'Lib/angular.min.js',
      'Lib/ngStorage.min.js',
      'ReporteAPH/AngularJs/Checklist-model.js',
      'ReporteAPH/AngularJs/mdlReporteAPH.js',
      'ReporteAPH/sweetalert-dev.js',
      'ReporteAPH/Descripcion.js',
      'ReporteAPH/informacionAmbulancia.js',
      'ReporteAPH/AngularJs/Controller/layoutReporteAPH.js',
      'ReporteAPH/AngularJs/Controller/ReporteInicialAPH.js',
      'ReporteAPH/leaflet.js',
      'ReporteAPH/leaflet-routing-machine.min.js',
      'ReporteAPH/GeolocalizacionRutaEmergencia.js',
      'ReporteAPH/ConsultarNotificacionDespacho.js'
    );

    // CARGAR VISTAS
    require APP . 'View/_layout/header.php';
    require APP . 'View/ReporteAPH/reporteInicialAPH.php';
    require APP . 'View/ReporteAPH/layoutReporteAPH.php';
    require APP . 'View/_layout/footer.php';

  }


}

?>

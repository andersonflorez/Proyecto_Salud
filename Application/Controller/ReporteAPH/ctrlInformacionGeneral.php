<?php

/**
* Class CtrlInformacionGeneral
*/
class CtrlInformacionGeneral extends Controller implements iController {
  private $scripts;
  private $styles;
  private $vistasMenu;
  private $notificaciones = true;
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
    if ( is_null(Sesion::getValue("esModoConsulta")) ) {
      header("Location: " . URL . "ReporteAPH/CtrlIndex");
    }
    	$vistas = Sesion::getValue('VISTAS_BARRA_PROGRESO');
      $vistaActual = Sesion::setValue('VISTA_ACTUAL','ctrlInformacionGeneral');
    $this->_mdlLayout = $this->loadModel('ReporteAPH', 'mdlLayoutReporteAPH');

  }


  /**
  * METODO: Index
  * Este metodo se ejecuta cuando solicito la URL :
  * http://nombreDeTuProyecto/ReporteAPH/CtrlInformacionGeneral
  * NOTA: Esta es la página por defecto cuando no se encuentra la URL.
  */
  public function Index() {
    // RENDERIZA EL MENÚ DE NAVEGACIÓN
    $this->vistasMenu = json_decode(Sesion::getValue('VISTAS_MENU'));

    // CARGAR CSS
    $this->styles     = array(
      'ReporteAPH/estilo.css',
      'ReporteAPH/sweetalert.css',
      "ReporteAPH/estiloInformacionGeneral.css"
    );

    // CARGAR JAVASCRIPTS
    $this->scripts = array(
      'Lib/fancywebsocket.js',
      'ReporteAPH/MigasPan.js',
      'ReporteAPH/generalScript.js',
      'Lib/angular.min.js',
      'Lib/ngStorage.min.js',
      'ReporteAPH/AngularJs/mdlReporteAPH.js',
      'ReporteAPH/AngularJs/Checklist-model.js',
      'ReporteAPH/sweetalert-dev.js',
      'ReporteAPH/informacionAmbulancia.js',
      'ReporteAPH/AngularJs/Controller/layoutReporteAPH.js',
      'ReporteAPH/AngularJs/Controller/InformacionGeneral.js',
      'ReporteAPH/ConsultarNotificacionDespacho.js'
    );
    $this->_mdlLayout->__SET("_idPersona", Sesion::getValue("ID_PERSONA"));
    $idDespacho = $this->_mdlLayout->TraerIDDespacho();
    $numero = $this->RecibirNumeroNotificacion($idDespacho->idDespacho);
    $datos  = $this->RecibirDescripcionNotificacion($idDespacho->idDespacho);

    // CARGA LAS VISTAS
    require APP . 'View/_layout/header.php';
    require APP . 'View/ReporteAPH/informacionGeneral.php';
    require APP . 'View/ReporteAPH/layoutReporteAPH.php';
    require APP . 'View/_layout/footer.php';

  }
  public function RecibirNumeroNotificacion($id) {
      if ($id != 0) {
          $idDespacho = $id;
      }else{
        $idDespacho = $_POST["idDespacho"];
      }
      $request  = $_POST["request"];
      $this->_mdlLayout->__SET("_idDespacho", $idDespacho);
      $numero = $this->_mdlLayout->ContarNotificacionesDespacho();
      if ($request == "ajax") {
        echo json_encode($numero);
      } else {
        return $numero;
      }

    }

  public function RecibirDescripcionNotificacion($id) {
      if ($id != 0) {
          $idDespacho = $id;
      }else{
        $idDespacho = $_POST["idDespacho"];
      }
      $request  = $_POST["request"];
      $this->_mdlLayout->__SET("_idDespacho", $idDespacho);
      $datos = $this->_mdlLayout->DescripcionNotificacionesDespacho();
      if ($request == "ajax") {
        echo json_encode($datos);
      } else {
        return $datos;
      }

    }


}

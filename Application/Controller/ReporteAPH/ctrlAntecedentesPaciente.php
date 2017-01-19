<?php

/**
* Class AntecedentesPaciente
*/
class CtrlAntecedentesPaciente extends Controller implements iController {
  private $styles;
  private $scripts;
  private $vistasMenu;
  private $notificaciones = true;
  private $menuEmergencia = true;


  private $_mdlAntecedentes = null;
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
    $vistas = Sesion::getValue('VISTAS_BARRA_PROGRESO');
    $vistaActual = Sesion::setValue('VISTA_ACTUAL','ctrlAntecedentesPaciente');
    if (	$vistas['ctrlAntecedentesPaciente'] == true) {
      $this->_mdlAntecedentes = $this->loadModel('ReporteAPH', 'mdlAntecedentesPaciente');
      $this->_mdlLayout       = $this->loadModel('ReporteAPH', 'mdlLayoutReporteAPH');

    }else {
      $redireccionar = '';
      foreach ($vistas as $key => $value) {

          if ($value == true) {
            $redireccionar = $key;

          }
      }

    header("Location: " . URL . "ReporteAPH/$redireccionar");
    }


  }


  /**
  * METODO: Index
  * Este metodo se ejecuta cuando solicito la URL :
  * http://nombreDeTuProyecto/ReporteAPH/ctrlAntecedentesPaciente
  * NOTA: Esta es la página por defecto cuando no se encuentra la URL.
  */
  public function Index() {
    // RENDERIZA EL MENÚ DE NAVEGACIÓN
    $this->vistasMenu = json_decode(Sesion::getValue('VISTAS_MENU'));

    // CARGAR CSS
    $this->styles     = array(
      'ReporteAPH/estilo.css',
      'ReporteAPH/sweetalert.css',
      'ReporteAPH/antecedentes.css'
    );

    // CARGAR JAVASCRIPTS
    $this->scripts    = array(
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
      'ReporteAPH/AngularJs/Controller/AntecedentesPaciente.js',
      'ReporteAPH/ConsultarNotificacionDespacho.js'
    );

    $this->_mdlLayout->__SET("_idPersona", Sesion::getValue("ID_PERSONA"));
    $idDespacho = $this->_mdlLayout->TraerIDDespacho();
    $numero = $this->RecibirNumeroNotificacion($idDespacho->idDespacho);
    $datos  = $this->RecibirDescripcionNotificacion($idDespacho->idDespacho);

    // CARGA LAS VISTAS
    require APP . 'View/_layout/header.php';
    require APP . 'View/ReporteAPH/antecedentesPaciente.php';
    require APP . 'View/ReporteAPH/layoutReporteAPH.php';
    require APP . 'View/_layout/footer.php';

  }

  /*
  *METODO BarraProgreso:  se encarga de dar permiso para acceder a
  *la vista.
  */
  public function BarraProgreso()
  {
    $vistaRedireccionar = $_POST['vistaRedireccionar'];
    $vistas = Sesion::getValue('VISTAS_BARRA_PROGRESO');
    $vistas['ctrlAntecedentesPaciente'] = true;
    Sesion::SetValue('VISTAS_BARRA_PROGRESO',$vistas);
    echo json_encode($vistas);
  }


  function RegistrarAntecedenteAPH() {
    $objetoDatos = json_decode(file_get_contents("php://input"));
    if (!isset($objetoDatos)) {
      echo "Datos nulos";
    } else {
      if (empty($objetoDatos->obj)) {
        echo json_encode(true);
      } else {
        $objetoAntecedentes = $objetoDatos->obj;
        foreach ($objetoAntecedentes as $key) {
          $this->_mdlAntecedentes->__SET("_idReporteAPH", $objetoDatos->ultimo);
          $this->_mdlAntecedentes->__SET("_idAntecedente", $key->idTipoAntecedente);
          isset($key->especificacion) ? $this->_mdlAntecedentes->__SET("_especificacion", $key->especificacion) : $this->_mdlAntecedentes->__SET("_especificacion", "No se registro Especificacion");
          $registro = $this->_mdlAntecedentes->RegistrarAntecedenteAPH();
        }

        if ($registro == true) {
          echo json_encode(true);
        } else {
          echo json_encode(false);
        }
      }
    }

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

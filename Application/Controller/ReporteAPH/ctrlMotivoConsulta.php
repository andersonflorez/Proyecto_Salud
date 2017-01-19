<?php


class CtrlMotivoConsulta extends Controller implements iController {
  private $styles;
  private $scripts;
  private $vistasMenu;
  private $notificaciones = true;
  private $menuEmergencia = true;

  private $_mdlMotivoConsulta = null;
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

    Sesion::setValue("idAmbulancia", 18);

    // Si la var de sesion esModoConsulta no existe redirecciona al index
    if (is_null(Sesion::getValue("esModoConsulta"))) {
      header("Location: " . URL . "ReporteAPH/CtrlIndex");
    }

    	$vistas = Sesion::getValue('VISTAS_BARRA_PROGRESO');
      $vistaActual = Sesion::setValue('VISTA_ACTUAL','ctrlMotivoConsulta');
    if (	$vistas['ctrlMotivoConsulta'] == true) {
      $this->_mdlLayout         = $this->loadModel('ReporteAPH', 'mdlLayoutReporteAPH');
      $this->_mdlMotivoConsulta = $this->loadModel('ReporteAPH', 'mdlMotivoConsulta');
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
  * http://nombreDeTuProyecto/ReporteAPH/informacionGeneral
  * NOTA: Esta es la página por defecto cuando no se encuentra la URL.
  */
  public function Index() {
    // RENDERIZA EL MENÚ DE NAVEGACIÓN
    $this->vistasMenu = json_decode(Sesion::getValue('VISTAS_MENU'));

    // CARGAR CSS
    $this->styles = array(
      'ReporteAPH/estilo.css',
      'ReporteAPH/sweetalert.css',
      'ReporteAPH/estiloMotivoConsulta.css'
    );

    // CARGAR JAVASCRIPTS
    $this->scripts = array(
      'Lib/fancywebsocket.js',
      'ReporteAPH/MigasPan.js',
      'ReporteAPH/generalScript.js',
      'Lib/angular.min.js',
      'ReporteAPH/motivoConsulta.js',
      'Lib/ngStorage.min.js',
      'ReporteAPH/AngularJs/mdlReporteAPH.js',
      'ReporteAPH/AngularJs/Checklist-model.js',
      'ReporteAPH/sweetalert-dev.js',
      'ReporteAPH/informacionAmbulancia.js',
      'ReporteAPH/AngularJs/Controller/layoutReporteAPH.js',
      'ReporteAPH/AngularJs/Controller/motivoConsulta.js',
      'ReporteAPH/ConsultarNotificacionDespacho.js'
    );

    $this->_mdlLayout->__SET("_idPersona", Sesion::getValue("ID_PERSONA"));
    $idDespacho = $this->_mdlLayout->TraerIDDespacho();
    $numero = $this->RecibirNumeroNotificacion($idDespacho->idDespacho);
    $datos  = $this->RecibirDescripcionNotificacion($idDespacho->idDespacho);

    // CARGA LAS VISTAS
    require APP . 'View/_layout/header.php';
    require APP . 'View/ReporteAPH/motivoConsulta.php';
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
		$vistas['ctrlMotivoConsulta'] = true;
		Sesion::SetValue('VISTAS_BARRA_PROGRESO',$vistas);
		echo json_encode($vistas);
	}

  /**
  * ----------------------------------------------------- *
  *           CRUD: Motivo Consulta                 *
  * ----------------------------------------------------- *
  */

  /**
  *Insertar Motivo de Consulta*
  */
  // public function RegistrarMotivoConsulta(){
  //
  //   $descripcionUrgenciaMedica = $_POST['rdUrgenciaMedica'];
  //   $descripcionEspecificacionMedica = $_POST['txtEspecifiqueUrgenciaMedica'];
  //   $descripcionEspecificacionTraumatica = $_POST['txtEspecifiqueUrgenciaTraumatica'];
  //
  //   $regMotivoConsulta = $this->mdlMotivoConsulta->InsertarMotivoConsulta();
  //   if ($regMotivoConsulta == true) {
  //     echo json_encode("Registro Exitoso");
  //   }else{
  //     echo json_encode("No se pudo registrar");
  //   }
  //
  //
  // }
  public function ListarMotivoConsulta() {
    $listaMotivoConsulta = $this->_mdlMotivoConsulta->ListarMotivoConsulta();
    if ($listaMotivoConsulta != null) {
      echo json_encode($listaMotivoConsulta);
    } else {
      echo json_encode(null);
    }
  }

  public function ListarTipoAseguramiento() {
    $listaTipoAseguramiento = $this->_mdlMotivoConsulta->ListarTipoAseguramiento();
    if ($listaTipoAseguramiento != null) {
      echo json_encode($listaTipoAseguramiento);
    } else {
      echo json_encode(null);
    }
  }

  public function ListarAfectado() {
    $listaTipoAseguramiento = $this->_mdlMotivoConsulta->ListarAfectado();
    if ($listaTipoAseguramiento != null) {
      echo json_encode($listaTipoAseguramiento);
    } else {
      echo json_encode(null);
    }
  }
  function InsertarMotivoConsulta() {
    $objDatosMotivoConsulta = json_decode(file_get_contents("php://input"));
    if (!isset($objDatosMotivoConsulta)) {
      echo "Datos vacíos";
    } else {

      $descripcionMC = $objDatosMotivoConsulta->descripcionMotivoConsulta;
      $dcategoriaMC  = $objDatosMotivoConsulta->categoriaMotivoConsulta;
      $this->_mdlMotivoConsulta->__SET("_motivoConsulta", $descripcionMC);
      $this->_mdlMotivoConsulta->__SET("_tipoMotivoConsulta", $dcategoriaMC);
      $registro = $this->_mdlMotivoConsulta->InsertarMotivoConsulta();
      echo json_encode($registro);

    }
  }
  function RegistrarReporteaphMotivoconsulta() {
    $objDatosInsert = json_decode(file_get_contents("php://input"));
    if (!isset($objDatosInsert)) {
      echo "Datos nulos";
    } else {
      $idReporteAPH     = $objDatosInsert->idReporteAph;
      $idMotivoConsulta = $objDatosInsert->idMotivoConsulta;
      $this->_mdlMotivoConsulta->__SET("_idReporteAph", $idReporteAPH);
      $this->_mdlMotivoConsulta->__SET("_idMotivoConsulta", $idMotivoConsulta);
      $registro = $this->_mdlMotivoConsulta->RegistrarReporteaphMotivoconsulta();
      if ($registro == true) {
        echo json_encode(true);
      } else {
        echo json_encode(false);
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
?>

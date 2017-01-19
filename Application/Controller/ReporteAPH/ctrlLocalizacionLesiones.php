<?php

/**
* Class LocalizacionLesiones:
* Esta clase se encarga gestionar toda la funcionalidad del cuerpo.
*/
class CtrlLocalizacionLesiones extends Controller implements iController {
  private $styles;
  private $scripts;
  private $vistasMenu;
  private $notificaciones = true;
  private $menuEmergencia = true;

  private $objLocalizacionLesion = null;
  private $_mdlLayout = null;
  private $objPagination = null;

  /**
  * Método constructor()
  * Inicializa el uso de variables de sesión y
  * valida si hay una sesión abierta, sino la hay
  * redirecciona hacia el login de la aplicación:
  */
  function __construct() {
    Sesion::init();
    if (!Sesion::exist()) {
      header("Location: " . URL);
      exit();
    }

    // Si la var de sesion esModoConsulta no existe redirecciona al index
    if (is_null(Sesion::getValue("esModoConsulta"))) {
      header("Location: " . URL . "ReporteAPH/CtrlIndex");
    }

    // Migas de pan
    $vistaActual = Sesion::setValue('VISTA_ACTUAL','ctrlLocalizacionLesiones');
    $vistas = Sesion::getValue('VISTAS_BARRA_PROGRESO');
    if (	$vistas['ctrlLocalizacionLesiones'] == true) {
      $this->objLocalizacionLesion = $this->loadModel('ReporteAPH', 'mdlLocalizacionLesion');
      $this->_mdlLayout            = $this->loadModel('ReporteAPH', 'mdlLayoutReporteAPH');
      $this->objPagination         = $this->loadModel('Otros', 'mdlPagination');
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
  * Método Index() obligatorio
  * Carga la página principal de este controlador:
  * Este metodo se ejecuta cuando solicito la URL :
  * http://nombreDeTuProyecto/ReporteAPH/LocalizacionLesiones
  */
  public function Index() {
    // RENDERIZA EL MENÚ DE NAVEGACIÓN
    $this->vistasMenu = json_decode(Sesion::getValue('VISTAS_MENU'));

    // CARGAR CSS de 'ReporteAPH/index.php':
    $this->styles = array(
      'ReporteAPH/estilo.css',
      'ReporteAPH/sweetalert.css',
      'ReporteAPH/cuerpo.css'
    );

    // CARGAR JAVASCRIPTS de 'ReporteAPH/CtrlIndex':
    $this->scripts = array(
      'Lib/fancywebsocket.js',
      'ReporteAPH/MigasPan.js',
      'ReporteAPH/generalScript.js',
      'Lib/angular.min.js',
      'Lib/ngStorage.min.js',
      'ReporteAPH/AngularJs/mdlReporteAPH.js',
      'ReporteAPH/AngularJs/Checklist-model.js',
      'ReporteAPH/AngularJs/Controller/layoutReporteAPH.js',
      'Todos/Paginador.js',
      'ReporteAPH/cuerpo.js',
      'ReporteAPH/sweetalert-dev.js',
      'ReporteAPH/informacionAmbulancia.js',
      'Todos/notify.js',
      'ReporteAPH/ConsultarNotificacionDespacho.js'
    );

    $this->_mdlLayout->__SET("_idPersona", Sesion::getValue("ID_PERSONA"));
    $idDespacho = $this->_mdlLayout->TraerIDDespacho();
    $numero = $this->RecibirNumeroNotificacion($idDespacho->idDespacho);
    $datos  = $this->RecibirDescripcionNotificacion($idDespacho->idDespacho);

    // CARGAR VISTAS
    require APP . 'View/_layout/header.php';
    require APP . 'View/ReporteAPH/localizacionLesiones.php';
    require APP . 'View/ReporteAPH/layoutReporteAPH.php';
    require APP . 'View/_layout/footer.php';

  }


  /**
  * METODO BarraProgreso:  se encarga de dar permiso para acceder a
  * la vista.
  */
  public function BarraProgreso()
  {
    $vistaRedireccionar = $_POST['vistaRedireccionar'];
    $vistas = Sesion::getValue('VISTAS_BARRA_PROGRESO');
    $vistas['ctrlLocalizacionLesiones'] = true;
    Sesion::SetValue('VISTAS_BARRA_PROGRESO', $vistas);
    echo json_encode($vistas);
  }


  /**
  * Esta función se encarga de consultar los registros de cie10
  * a traves del paginador, con la opción de filtro.
  */
  public function ListadoCIE10() {
    $configPaginador              = $_POST;
    $configPaginador['tableName'] = 'ViewCie10APH';
    $configPaginador['fields']    = '*';

    if (!empty($configPaginador['filter'])) {
      $configPaginador['nameColumnFilter'] = 'codigoCIE10';

      $new_arr     = array_map('trim', explode(",", $configPaginador['filter']));
      $new_arr     = array_filter($new_arr, "strlen");
      $stringArray = '';
      $i           = 0;
      foreach ($new_arr as $value) {
        $coma = ($i !== (count($new_arr) - 1)) ? ',' : '';
        $stringArray .= $value . $coma;
        $i++;
      }
      $configPaginador['filter'] = $stringArray;
    }

    $resPaginador = $this->objPagination->Paginate($configPaginador);
    echo json_encode($resPaginador);

  }


  /**
  * Esta función se encarga de consultar los puntos y sus lesiones,
  * y crea estructura de json
  */
  public function ListarDatosPuntos() {
    $idReporteAPH = $_POST['idReporteAPH'];

    if (isset($idReporteAPH)) {
      $this->objLocalizacionLesion->__SET('idReporteAPH', $idReporteAPH);
      $puntos = $this->objLocalizacionLesion->ListarPuntoLesion();
      $datos  = array();

      foreach ($puntos as $punto) {
        $this->objLocalizacionLesion->__SET('idPuntoLesion', $punto->idPuntoLesion);
        $lesiones = $this->objLocalizacionLesion->ConsultarLesiones();

        array_push($datos, array(
          "datosPunto" => $punto,
          "datosLesiones" => $lesiones
        ));

      }

      $json = json_encode($datos);
      echo $json;

    } else {
      echo 'Para completar la operación se necesita idReporteAPH ';
    }

  }


  /**
  * Esta función se encarga registrar una lesión
  */
  public function RegistrarPuntoLesion() {
    $datosOBJ = json_decode(file_get_contents("php://input"));
    if (!isset($datosOBJ)) {
      echo json_encode("null");
    } else {
      $idReporteAPH = $datosOBJ->idReporteAPH;
      $datos        = $datosOBJ->datosLocalizacionLesiones;
      $i            = 0;
      $esExito      = true;
      $idPunto      = 0;

      foreach ($datos as $dato) {
        $infoPunto    = $dato->infoPunto;
        $infoLesiones = $dato->infoLesion;

        $this->objLocalizacionLesion->__SET('posX', $infoPunto->posX);
        $this->objLocalizacionLesion->__SET('PosY', $infoPunto->posY);
        $this->objLocalizacionLesion->__SET('idReporteAPH', $idReporteAPH);

        $idPunto = (int) $this->objLocalizacionLesion->RegistrarPuntoLesion();

        if ($idPunto > 0 || $idPunto != '0') {

          $j = 0;

          foreach ($infoLesiones as $lesion) {
            $this->objLocalizacionLesion->__SET('idPuntoLesion', $idPunto);
            $this->objLocalizacionLesion->__SET('especificacionLesion', $lesion->especificacion);
            $this->objLocalizacionLesion->__SET('idCIE10', $lesion->id);

            $res2 = (bool) $this->objLocalizacionLesion->RegistrarLesion();

            if ($res2) {
              continue;
            } else {
              $esExito = false;
              echo 'No se pudó registrar la lesion en el indice $infoLesiones[' . $j . ']';
              break;
            }

            $j++;
          }

        } else {
          $esExito = false;
          echo 'La respuesta de RegistrarPuntoLesion en el indice $datos[' . $i . ']  es ==> 0 ';
          break;
        }

        $i++;
      }

      if ($esExito) {
        echo json_encode(true);
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

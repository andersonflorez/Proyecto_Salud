<?php
/**
* Class Index:
* Esta clase se encarga de consultar y realizar cierta tareas
* con las historias clinicas
*/
class CtrlIndex extends Controller implements iController {
  private $styles;
  private $scripts;
  private $vistasMenu;
  private $notificaciones = true;
  private $cambiarEstadoAmbulancia = true;

  private $_mdlIndex = null;
  private $_mdlLayout = null;
  private $objPagination = null;

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

    // Eliminar variable esModoConsulta si es true y no es una petición ajax
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
      // Si es una petición ajax
    }else {
      if (Sesion::varExist('esModoConsulta')) {
        if (Sesion::getValue("esModoConsulta") == 1) {
          Sesion::unsetValue('esModoConsulta');
        }
      }
    }

    $this->_mdlIndex     = $this->loadModel('ReporteAPH', 'mdlIndex');
    $this->_mdlLayout    = $this->loadModel('ReporteAPH', 'mdlLayoutReporteAPH');
    $this->objPagination = $this->loadModel('Otros', 'mdlPagination');

  }

  /**
  * Método Index() obligatorio
  * Carga la página principal de este controlador:
  * Este metodo se ejecuta cuando solicito la URL :
  * http://localhost/PROYECTO_SALUD_DEV/ReporteAPH/CtrlIndex
  */
  public function Index() {
    // RENDERIZA EL MENÚ DE NAVEGACIÓN
    $this->vistasMenu = json_decode(Sesion::getValue('VISTAS_MENU'));

    // CARGAR CSS
    $this->styles     = array(
      'ReporteAPH/estilo.css',
      'ReporteAPH/sweetalert.css',
      'ReporteAPH/Consultar_HC.css'
    );

    // CARGAR JAVASCRIPTS
    $this->scripts = array(
      'Lib/fancywebsocket.js',
      'ReporteAPH/generalScript.js',
      'Lib/angular.min.js',
      'Lib/ngStorage.min.js',
      'ReporteAPH/AngularJs/mdlReporteAPH.js',
      'ReporteAPH/AngularJs/Checklist-model.js',
      'ReporteAPH/sweetalert-dev.js',
      'Todos/Paginador.js',
      'ReporteAPH/informacionAmbulancia.js',
      'ReporteAPH/AngularJs/Controller/layoutReporteAPH.js',
      'ReporteAPH/index.js',
      'ReporteAPH/ConsultarNotificacionDespacho.js'
    );
    $this->_mdlLayout->__SET("_idPersona", Sesion::getValue("ID_PERSONA"));
    $idDespacho = $this->_mdlLayout->TraerIDDespacho();
    $numero = $this->RecibirNumeroNotificacion($idDespacho->idDespacho);
    $datos  = $this->RecibirDescripcionNotificacion($idDespacho->idDespacho);
    // CARGAR VISTAS
    require APP . 'View/_layout/header.php';
    require APP . 'View/ReporteAPH/index.php';
    require APP . 'View/ReporteAPH/layoutReporteAPH.php';
    require APP . 'View/_layout/footer.php';

  }


  /**
  * Lista los reportesAPH paginados
  */
  public function ListarReportes() {
    $configPaginador              = $_POST;
    $configPaginador['tableName'] = 'ViewDatosBasicosReporteAPH';
    $configPaginador['fields']    = '*';

    if (!empty($configPaginador['filterDateTimeStart']) && !empty($configPaginador['filterDateTimeEnd'])) {
      $configPaginador['nameColumnDateTime'] = 'fechaHoraFinalizacion';
    }

    if (!empty($configPaginador['filter'])) {
      // Opciones select buscar por:
      switch ((int) $configPaginador['nameColumnFilter']) {
        case 0:
        $configPaginador['nameColumnFilter'] = 'nombreCompleto';
        break;

        case 1:
        $configPaginador['nameColumnFilter'] = 'numeroDocumento';
        break;

        case 2:
        $configPaginador['nameColumnFilter'] = 'idReporteAPH';
        break;

        case 3:
        $configPaginador['nameColumnFilter'] = 'idAmbulancia';
        break;

        default:
        $configPaginador['nameColumnFilter'] = '';
        $configPaginador['filter']           = '';
        break;
      }

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

    } else {
      $configPaginador['nameColumnFilter'] = '';
      $configPaginador['filter']           = '';
    }

    if (!empty($configPaginador['orderBy'])) {
      // Opciones select ordenar por:
      switch ((int) $configPaginador['nameColumnOrderBy']) {
        case 0:
        $configPaginador['nameColumnOrderBy'] = 'nombreCompleto';
        break;

        case 1:
        $configPaginador['nameColumnOrderBy'] = 'numeroDocumento';
        break;

        case 2:
        $configPaginador['nameColumnOrderBy'] = 'idReporteAPH';
        break;

        case 3:
        $configPaginador['nameColumnOrderBy'] = 'idAmbulancia';
        break;

        case 4:
        $configPaginador['nameColumnOrderBy'] = 'genero';
        break;

        default:
        $configPaginador['nameColumnOrderBy'] = '';
        $configPaginador['orderBy']           = '';
        break;
      }
    } else {
      $configPaginador['nameColumnOrderBy'] = '';
      $configPaginador['orderBy']           = '';
    }

    $resPaginador = $this->objPagination->Paginate($configPaginador);

    if (count($resPaginador['datos']) > 0) {
      foreach ($resPaginador['datos'] as $key => $value) {
        $this->_mdlIndex->__SET('idAsignacionPersonal', $value->idAsignacionPersonal);
        $resPersonal = $this->_mdlIndex->ConsultarPersonalReporteAPH();

        $value->personal = $resPersonal;
      }
    }

    echo json_encode($resPaginador, JSON_UNESCAPED_UNICODE);

  }


  /**
  * Consultar toda la información de un ReporteAPH
  */
  public function ConsultarReporteAPH() {

    if ($_POST['request'] == 'ajax') {
      $this->_mdlIndex->__SET('idReporteAPH', (int) $_POST['idReporteAph']);
      $reporte          = $this->_mdlIndex->ConsultarReporteAPH();
      $tratamientos     = $this->_mdlIndex->ConsultarTratamientosAPH();
      $desfibrilaciones = $this->_mdlIndex->ConsultarDesfibrilacionAPH();
      $antecedentes     = $this->_mdlIndex->ConsultarAntecedentesAPH();
      $motivosConsulta  = $this->_mdlIndex->ConsultarMotivoConsultaAPH();
      $testigos         = $this->_mdlIndex->ConsultarTestigoAPH();
      $medicamentos     = $this->_mdlIndex->ConsultarMedicamentosAPH();
      $viasComunicacion = $this->_mdlIndex->ConsultarViaComunicacionAPH();

      $datos = array_merge($reporte, $tratamientos, $desfibrilaciones, $antecedentes, $motivosConsulta, $testigos, $medicamentos, $viasComunicacion);
      if ($reporte['reporte'] != null && $viasComunicacion['viasComunicacion'] != null) {
        Sesion::setValue("esModoConsulta", 1);

        if (Sesion::varExist('esModoConsulta')) {
          if ( Sesion::getValue('esModoConsulta') == 1 ) {
            $vistas = array(
              "ctrlInformacionGeneral" => true,
              "ctrlTipoEvento" => true,
              "ctrlMotivoConsulta" => true,
              "ctrlAntecedentesPaciente" => true,
              "ctrlLocalizacionLesiones" => true,
              "ctrlTratamientoB" => true,
              "ctrlTratamientoA" => true,
              "ctrlMedicamento" => true,
              "ctrlResultadosAtencion" => true
            );
            Sesion::SetValue('VISTAS_BARRA_PROGRESO',$vistas);
          }
        }

      }

      echo json_encode($datos, JSON_UNESCAPED_UNICODE);
    }

  }


  /**
  * Cambiar disponibilidad de la ambulancia
  */
  public function CambiarDisponibilidad() {
    if ($_POST['request'] == 'ajax') {
      echo $res = (int) $this->_mdlIndex->CambiarDisponibilidad();
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





} // Fin clase
?>

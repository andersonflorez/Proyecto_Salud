<?php

/**
* Class ctrlControlAutorizacion
*/
class ctrlControlAutorizacion extends Controller implements iController {
  private $scripts;
  private $styles;
  private $vistasMenu;

  /**
  * Método constructor()
  */
  public function __construct() {
    Sesion::init();
    if (!Sesion::exist()) {
      header("Location: " . URL);
      exit();
    }

    $this->objControlAutorizacion = $this->loadModel('ReporteAPH', 'mdlControlAutorizacion');
    $this->objPagination          = $this->loadModel('Otros', 'mdlPagination');

  }


  public function Index() {
    // RENDERIZA EL MENÚ DE NAVEGACIÓN
    $this->vistasMenu = json_decode(Sesion::getValue('VISTAS_MENU'));

    // CARGAR CSS
    $this->styles     = array(
      'ReporteAPH/estilo.css',
      'ReporteAPH/controlAutorizaciones.css',
      'Todos/sweetalert.css'
    );

    // CARGAR JAVASCRIPTS
    $this->scripts = array(
      'Lib/fancywebsocket.js',
      'Todos/Paginador.js',
      'ReporteAPH/controlAutorizaciones.js',
      'Todos/sweetalert.js',
      'ReporteAPH/sockets/SocketTratamientoControlMedico.js'
    );

    // CARGA LAS VISTAS
    require APP . 'View/_layout/header.php';
    require APP . 'View/ReporteAPH/controlAutorizacion.php';
    require APP . 'View/_layout/footer.php';

  }


  public function ListarAutorizaciones() {
    $configPaginador              = $_POST;
    $configPaginador['tableName'] = 'viewtemporalautorizacion';
    $configPaginador['fields']    = '*';

    if (!empty($configPaginador['filterDateTimeStart']) && !empty($configPaginador['filterDateTimeEnd'])) {
      $configPaginador['nameColumnDateTime'] = 'fechaEnvio';
    }

    if (!empty($configPaginador['filter'])) {
      // Opciones select buscar por:
      switch ((int) $configPaginador['nameColumnFilter']) {
        case 0:
        $configPaginador['nameColumnFilter'] = 'idTemporalAutorizacion';
        break;

        case 1:
        $configPaginador['nameColumnFilter'] = 'nombreCompleto';
        break;

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
        $configPaginador['nameColumnOrderBy'] = 'idTemporalAutorizacion';
        break;

        case 1:
        $configPaginador['nameColumnOrderBy'] = 'nombreCompleto';
        break;

        case 2:
        $configPaginador['nameColumnOrderBy'] = 'fechaEnvio';
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

    echo json_encode($resPaginador,JSON_UNESCAPED_UNICODE);

  }


  public function insertarRespuestaAutorizacion() {
    $idAutorizacion       = $_POST['id'];
    $estadoAutorizacion   = $_POST['estado'];
    $descripcionRespuesta = $_POST['des'];
    $idMedico             = Sesion::getValue('ID_USUARIO');
    ;
    date_default_timezone_set('America/Bogota');
    $fechaSistema   = time();
    $fechaEvalucion = date('y-m-d H:i:s', $fechaSistema);

    $array = array(
      $idAutorizacion,
      $idMedico,
      $descripcionRespuesta,
      $estadoAutorizacion,
      $fechaEvalucion
    );

    $respuesta = $this->objControlAutorizacion->insertarEvaluacionAutorizacion($array);

      echo json_encode($respuesta);

  }

  public function ConsultarAutorizacion() {
    $idAutorizacion = $_POST['idAutorizacion'];
    $respuesta      = $this->objControlAutorizacion->consultarAutorizacion($idAutorizacion);

    echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
  }

  public function ConsultarParamedico() {
    $idParamedico = $_POST['idParamedico'];
    $respuesta    = $this->objControlAutorizacion->ConsultarParamedico($idParamedico);
    echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
  }

}
?>

<?php

/* ========================================================================== *
*  NOMBRE DE LA CLASE: ControlReporteInicial                                  *
*  TIPO DE CLASE: Controlador                                                 *
*  DESCRIPCIÓN: Este es el controlador principal de la vista de consulta de   *
*  reportes iniciales, permite listar todos los reportes registrados hasta el *
*  momento y gestionar todas las funcionalidades del lado del servidor        *
*  ========================================================================== */

class ctrlConsultarReporte extends Controller implements iController {

  // Declaración de objetos que utiliza esta clase:
  private $objReporteInicial;
  private $objNovedadReporteInicial;
  private $objChatReporteInicial;
  private $objPagination;
  private $vistasMenu;

  // Atributos adicionales:
  private $scripts;
  private $styles;

  /* ========================================================================== *
  *  MÉTODO CONSTRUCTOR: Validar sesión y cargar modelos                        *
  *  ========================================================================== */
  public function __construct() {

    Sesion::init();

    if (!Sesion::exist()) {

      header("Location: " . URL);
      exit();

    } else if (Sesion::getValue('TIPO_USUARIO') === 'RECEPTOR_INICIAL' || Sesion::getValue('TIPO_USUARIO') === 'ADMINISTRADOR') {

      $this->objReporteInicial = $this->loadModel('ReporteInicial', 'mdlReporteInicial');
      $this->objNovedadReporteInicial = $this->loadModel('ReporteInicial', 'mdlNovedadReporte');
      $this->objChatReporteInicial = $this->loadModel('ReporteInicial', 'mdlChatUsuario');
      $this->objPagination = $this->loadModel('Otros', 'mdlPagination');

    } else {

      header('Location: ' . URL . 'Error/Error');
      exit();

    }

  }

  /* ========================================================================== *
  *  MÉTODO Index(): Renderizar la vista de consulta de reportes                *
  *  ========================================================================== */
  public function Index() {

    $this->vistasMenu = json_decode(Sesion::getValue('VISTAS_MENU'));

    $this->scripts = array(
      "Lib/fancywebsocket.js",
      "Todos/Paginador.js",
      "ReporteInicial/chat_controller.js",
      "ReporteInicial/funciones_reporte_inicial.js",
      "ReporteInicial/ajax_reporte_inicial.js",
      "ReporteInicial/consulta_reporte.js",
      "Todos/sweetalert.js"
    );

    $this->styles = array(
      //"ReporteInicial/chat-reporte-inicial.css",
      "ReporteInicial/consulta_reportes.css",
      "ReporteInicial/comun.css",
      "Todos/sweetalert.css"
    );

    require APP . 'View/_layout/header.php';
    require APP . 'View/ReporteInicial/viewConsultarReportes.php';
    require APP . 'View/_layout/footer.php';
  }

  /* ========================================================================== *
  *  FUNCIÓN ConsultarReporteInicial():                                         *
  *  Consulta la información de un reporte en específico                        *
  *  ========================================================================== */
  public function ConsultarReporteInicial() {

    if (isset($_POST['ajax'])) {

      $idReporteInicial = $_POST['idReporteInicial'];
      $this->objReporteInicial->__SET('idReporteInicial', $idReporteInicial);
      $this->objNovedadReporteInicial->__SET('idReporteInicial', $idReporteInicial);
      $PaqueteReporte = $this->objReporteInicial->ConsultarReporteInicial();
      $TiposEvento = $this->objReporteInicial->ConsultarTipoEventoReporteInicial();
      $EntesExternos = $this->objReporteInicial->ConsultarEnteExternoReporteInicial();
      $Novedades = $this->objNovedadReporteInicial->ConsultarNovedadesReporteInicial();

      // Agregar los atributos del reporte a un array
      $Reporte = array(
        "idReporteInicial" => $PaqueteReporte->idReporteInicial,
        "idReporteVista" => $this->AgregarCeros($PaqueteReporte->idReporteInicial),
        "informacionInicial" => $PaqueteReporte->informacionInicial,
        "ubicacionIncidente" => $PaqueteReporte->ubicacionIncidente,
        "puntoReferencia" => $PaqueteReporte->puntoReferencia,
        "numeroLesionados" => $PaqueteReporte->numeroLesionados,
        "fechaEmergencia" => $this->ExtraerFormatoFecha($PaqueteReporte->fechaHoraAproximadaEmergencia).' '.$this->ExtraerFormatoHora($PaqueteReporte->fechaHoraAproximadaEmergencia),
        "fechaEnvioReporte" => $this->ExtraerFormatoFecha($PaqueteReporte->fechaHoraEnvioReporteInicial).' '.$this->ExtraerFormatoHora($PaqueteReporte->fechaHoraEnvioReporteInicial),
        "estadoReporteInicial" => $PaqueteReporte->estadoTablaReporteInicial,
        "idChat" => $PaqueteReporte->idChat
      );

      // Comprobar si el reporte contiene tipos de evento y agregarlos al array:
      if (is_array($TiposEvento)) {
        $Reporte['tiposEvento'] = array();
        foreach ($TiposEvento as $TipoEvento) {
          array_push($Reporte['tiposEvento'], $TipoEvento->descripcionTipoEvento);
        }
      }

      // Comprobar si el reporte contiene entes externos y agregarlos al array:
      if (is_array($EntesExternos)) {
        $Reporte['entesExternos'] = array();
        foreach ($EntesExternos as $EnteExterno) {
          array_push($Reporte['entesExternos'], $EnteExterno->descripcionEnteExterno);
        }
      }

      // Comprobar si el reporte contiene novedades y agregarlas al array:
      if (is_array($Novedades)) {
        $Reporte['novedades'] = array();
        foreach ($Novedades as $Novedad) {
          array_push($Reporte['novedades'], array('Descripcion' => $Novedad->descripcionNovedad, 'Fecha' => $Novedad->fechaHoraNovedad));
        }
      }

      // Enviar respuesta ajax en formato JSON:
      echo json_encode($Reporte);

    } else {
      header("Location: " . URL . "Error/Error");
    }
  }

  /* ========================================================================== *
  *  FUNCIÓN ConsultarChatReporteInicial():                                     *
  *  Consulta los mensajes pertenecientes a un chat en especifico               *
  *  ========================================================================== */
  public function ConsultarChatReporteInicial() {

    if (isset($_POST['ajax'])) {

      $this->objChatReporteInicial->__SET('idChat', $_POST['idChat']);
      $chat = $this->objChatReporteInicial->ConsultarChat();

      if (isset($chat)) {

        $array = array();
        $this->objChatReporteInicial->__SET('idReceptorInicial', $chat->idReceptorInicial);
        $this->objChatReporteInicial->__SET('idUsuarioExterno', $chat->idUsuarioExterno);

        $infoReceptorInicial = $this->objChatReporteInicial->ConsultarReceptorInicial();
        $infoUsuarioExterno = $this->objChatReporteInicial->ConsultarUsuarioExterno();
        $mensajes = $this->objChatReporteInicial->ConsultarMensajesChat();

        $array['idChat'] = $chat->idChat;
        $array['usuarioExterno'] = $infoUsuarioExterno;
        $array['receptorInicial'] = $infoReceptorInicial;
        $array['mensajes'] = $mensajes;

        echo json_encode($array);

      } else {
        echo 0;
      }

    } else {
      header("Location: " . URL . "Error/Error");
    }

  }

  /* ========================================================================== *
  *  FUNCIÓN PaginarReportes():                                                 *
  *  Consulta los reportes iniciales y retorna los que deben ser mostrados en   *
  *  la página actual.                                                          *
  *  ========================================================================== */
  public function PaginarReportes() {

    if (isset($_POST['ajax'])) {
      // error_reporting(0);
      $configPaginador = $_POST;

      // TABLE:
      $configPaginador['tableName'] = 'tbl_reporteinicial';

      // FIELDS:
      $configPaginador['fields'] = '*';

      // ORDER BY:
      switch ($configPaginador['orderBy']) {
        case '1':
        $configPaginador['orderBy'] = 'DESC';
        break;
        case '2':
        $configPaginador['orderBy'] = 'ASC';
        break;
        default:
        $configPaginador['orderBy'] = 'DESC';
        break;
      }

      // COLUMN ORDER BY NAME:
      switch ($configPaginador['nameColumnOrderBy']) {
        case '1':
        $configPaginador['nameColumnOrderBy'] = 'fechaHoraEnvioReporteInicial';
        break;
        case '2':
        $configPaginador['nameColumnOrderBy'] = 'idReporteInicial';
        break;
        case '3':
        $configPaginador['nameColumnOrderBy'] = 'estadoTablaReporteInicial';
        break;
        default:
        $configPaginador['nameColumnOrderBy'] = 'fechaHoraEnvioReporteInicial';
        break;
      }

      if (!empty($configPaginador['nameColumnDateTime'])) {
        $configPaginador['nameColumnDateTime'] = 'fechaHoraEnvioReporteInicial';
      }

      // COLUMN FILTER NAME:
      if (!empty($configPaginador['nameColumnFilter'])) {
        switch ($configPaginador['nameColumnFilter']) {
          case '1':
          $configPaginador['nameColumnFilter'] = 'informacionInicial';
          break;
          case '2':
          $configPaginador['nameColumnFilter'] = 'idReporteInicial';
          break;
          case '3':
          $configPaginador['nameColumnFilter'] = 'ubicacionIncidente';
          break;
          case '4':
          $configPaginador['nameColumnFilter'] = 'estadoTablaReporteInicial';
          break;
          case '5':
          $configPaginador['nameColumnFilter'] = 'numeroLesionados';
          break;
          case '6':
          $configPaginador['nameColumnFilter'] = 'puntoReferencia';
          break;
          default:
          $configPaginador['nameColumnFilter'] = 'informacionInicial';
          break;
        }
      }

      $res = $this->objPagination->Paginate($configPaginador);
      echo json_encode($res);

    } else {
      // Retornar a la página de error en caso de que la consulta no sea via ajax:
      header('location: '. URL .'Error/error');
    }

  }

  /* ========================================================================== *
  *  FUNCIÓN CancelarReporte():                                                 *
  *  Cancela un reporte inicial de emergencia con estado 'en proceso'           *
  *  ========================================================================== */
  public function CancelarReporte() {

    if (isset($_POST['ajax'])) {

      $idReporte = $_POST['idReporte'];
      $descripcion = "El reporte ha sido cancelado por el siguiente motivo: " . $_POST['descripcion'];
      $this->objReporteInicial->__SET('idReporteInicial', $idReporte);
      $this->objReporteInicial->__SET('estadoReporte', 'cancelado');
      $cancelado = $this->objReporteInicial->CancelarReporteInicial();

      if ($cancelado) {
        $this->objNovedadReporteInicial->__SET('idReporteInicial', $idReporte);
        $this->objNovedadReporteInicial->__SET('descripcionNovedad', $descripcion);
        $this->objNovedadReporteInicial->RegistrarNovedadReporteInicial();
        $novedades = $this->objNovedadReporteInicial->ConsultarNovedadesReporteInicial();

        // Comprobar si el reporte contiene novedades y agregarlas al array:
        $contnovedades = array();

        if (is_array($novedades)) {
          foreach ($novedades as $novedad) {
            array_push($contnovedades, array('Descripcion' => $novedad->descripcionNovedad, 'Fecha' => $novedad->fechaHoraNovedad));
          }
        }

        echo json_encode($contnovedades);

      } else {
        echo '0';
      }

    } else {
      header("location: ".URL."error/error");
    }

  }

  /* ========================================================================== *
  *  FUNCIÓN AgregarNovedadReporte():                                           *
  *  Agrega una novedad a un reporte inicial de emergencia                      *
  *  ========================================================================== */
  public function AgregarNovedadReporte() {

    if (isset($_POST['ajax'])) {

      $idReporte = $_POST['idReporte'];
      $descripcion = $_POST['descripcion'];
      $this->objNovedadReporteInicial->__SET('idReporteInicial', $idReporte);
      $this->objNovedadReporteInicial->__SET('descripcionNovedad', $descripcion);
      $r = $this->objNovedadReporteInicial->RegistrarNovedadReporteInicial();

      if ($r) {

        $novedades = $this->objNovedadReporteInicial->ConsultarNovedadesReporteInicial();

        // Comprobar si el reporte contiene novedades y agregarlas al array:
        $contnovedades = false;

        if (is_array($novedades)) {

          $contnovedades = array();

          foreach ($novedades as $novedad) {

            array_push($contnovedades, array('Descripcion' => $novedad->descripcionNovedad, 'Fecha' => $novedad->fechaHoraNovedad));

          }

        }

        echo json_encode($contnovedades);

      } else {
        echo 0;
      }

    } else {
      header("location: ".URL."error/error");
    }

  }

  /* ========================================================================== *
  *  LOS SIGUIENTES MÉTODOS Y FUNCIONES SE USAN PARA REALIZAR CÁLCULOS INTERNOS *
  *  ========================================================================== */

  # Función para agregar ceros a la izquierda de cada código de reporte:
  private function AgregarCeros($string) {
    return strlen($string) < 4 ? $this->agregarCeros("0$string") : $string;
  }

  # Función para obtener solo la fecha de un DATETIME:
  private function ExtraerFormatoFecha($datetime) {
    return date("d/m/Y", strtotime($datetime));
  }

  # Función para obtener solo la hora de un DATETIME:
  private function ExtraerFormatoHora($datetime) {
    return date("H:i:s", strtotime($datetime));
  }
}

?>

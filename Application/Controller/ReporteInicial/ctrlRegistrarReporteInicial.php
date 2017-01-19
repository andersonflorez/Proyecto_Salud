<?php

/**
* NOMBRE DE LA CLASE: ctrlRegistrarReporteInicial
* TIPO DE CLASE: Controlador
* DESCRIPCIÓN: Este controlador gestiona el registro
* del reporte inicial y toda la funcionalidad del lado
* del servidor que ello conlleva.
*/
class ctrlRegistrarReporteInicial extends Controller implements iController {

  private $objEnteExterno;
  private $objTipoEvento;
  private $objReporteInicial;
  private $objChatUsuario;
  private $vistasMenu;
  private $notificaciones = true;
  private $permisoVista;

  private $styles;
  private $scripts;

  private $listaTipoEvento;
  private $listaEntesExternos;

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

    } else if (Sesion::getValue('TIPO_USUARIO') === 'RECEPTOR_INICIAL' || Sesion::getValue('TIPO_USUARIO') === 'ADMINISTRADOR') {

      if (!Sesion::varExist('permisoVista')) {
        Sesion::setValue('permisoVista',true);
      } else {

      }

      $this->objReporteInicial = $this->loadModel('ReporteInicial', 'mdlReporteInicial');
      $this->objEnteExterno = $this->loadModel('ReporteInicial', 'mdlEnteExterno');
      $this->objTipoEvento = $this->loadModel('ReporteInicial', 'mdlTipoEvento');
      $this->objPagination = $this->loadModel('Otros', 'mdlPagination');
      $this->objChatUsuario = $this->loadModel('ReporteInicial', 'mdlChatUsuario');

    } else {

      header("Location: " . URL . 'Error/Error');
      exit();

    }

  }

  /**
  * Método Index() obligatorio
  * Renderiza la página principal de este controlador (ViewRegistrarReporte)
  */
  public function Index() {

    $this->vistasMenu = json_decode(Sesion::getValue('VISTAS_MENU'));

    $this->listaTipoEvento = $this->objTipoEvento->ListarTipoEvento();
    $this->listaEnteExterno = $this->objEnteExterno->ListarEnteExterno();

    $this->scripts = array(
      "Lib/fancywebsocket.js",
      "ReporteInicial/chat_controller.js",
      "ReporteInicial/registro_reporte.js",
      "ReporteInicial/socket_receptor.js",
      "Todos/Paginador.js",
      "ReporteInicial/funciones_reporte_inicial.js",
      "Todos/sweetalert.js",
      "ReporteInicial/bootstrap-select.js",
      "ReporteInicial/bootstrap.min.js"
    );

    $this->styles = array(
      "Todos/sweetalert.css",
      "ReporteInicial/comun.css",
      "ReporteInicial/registro-reporte-inicial.css",
      "ReporteInicial/bootstrap-select.css"
    );

    require APP . 'View/_layout/header.php'; // Carga la barra de navegación y los CSS
    require APP . 'View/ReporteInicial/viewRegistrarReporte.php'; // Carga nuestra vista
    require APP . 'View/_layout/footer.php'; // Carga los Javascripts
  }

  /* ========================================================================== *
  *  FUNCIÓN RegistrarReporte():                                                *
  *  Registra el reporte inicial de emergencia                                  *
  *  ========================================================================== */
  function RegistrarReporte() {

    if(isset($_POST['ajax'])){

      date_default_timezone_set('America/Bogota');
      $time = time();
      $fecha = date("Y-m-d",$time);

      // Capturar los valores:
      $selectEnte = $_POST['slcEnteExterno'];
      $selectTEvento = $_POST['slcTipoEvento'];
      $informacionInicial = $_POST['txtDescripcion'];
      $ubicacionInicidente = $_POST['txtDireccion'];
      $puntoReferencia = $_POST['txtPuntoReferencia'];
      $numeroLesionados = $_POST['txtNumeroLesionados'];
      $fechaHoraEmergencia = $fecha.' '.$_POST['txtHoraAproximada'];
      $estadoReporte = "activo";
      $idChat = $_POST['idChat'];

      // Enviar datos al modelo
      $this->objReporteInicial->__SET('informacionInicial', $informacionInicial);
      $this->objReporteInicial->__SET('ubicacionIncidente', $ubicacionInicidente);
      $this->objReporteInicial->__SET('puntoReferencia', $puntoReferencia);
      $this->objReporteInicial->__SET('numeroLesionados', $numeroLesionados);
      $this->objReporteInicial->__SET('fechaHoraEmergencia', $fechaHoraEmergencia);
      $this->objReporteInicial->__SET('estadoReporte', $estadoReporte);
      $this->objReporteInicial->__SET('idChat', $idChat);

      // Registrar el reporte inicial:
      $registro = $this->objReporteInicial->RegistrarReporteInicial();

      // Registrar tipo(s) de evento(s)
      $this->objReporteInicial->__SET('estadoTipoEvento', "Activo");

      if (!empty($selectTEvento)) {
        foreach ($selectTEvento as $tipoEvento) {

          $this->objReporteInicial->__SET('idTipoEvento', $tipoEvento);
          $this->objReporteInicial->RegistrarTipoEvento_ReporteInicial();

        }
      }

      // Registrar ente(s) externo(s)
      if (!empty($selectEnte)) {
        foreach ($selectEnte as $enteExterno) {

          $this->objReporteInicial->__SET('idEnteExterno', $enteExterno);
          $this->objReporteInicial->RegistrarEnteExterno_ReporteInicial();

        }
      }

      echo json_encode($registro);

    } else {
      header("Location: ".URL."Error/Error");
    }

  }

  /* =========================================================================  *
  *  FUNCIÓN RegistrarNovedad():                                                *
  *  Registrar novedad a reporte                                                *
  *  ========================================================================= */

  public function RegistrarNovedad(){
    if(isset($_POST['ajax'])){

      $idReporte = $_POST['idReporte'];
      $descripcionNovedad = $_POST['txtNovedad'];
      $numeroLesionados = $_POST['txtLesionadosNovedad'];
      $estadoNovedad = 'activo';

      // Enviar al modelo
      $this->objReporteInicial->__SET('idReporteInicial',$idReporte);
      $this->objReporteInicial->__SET('descripcionNovedad',$descripcionNovedad);
      $this->objReporteInicial->__SET('numeroLesionados',$numeroLesionados);
      $this->objReporteInicial->__SET('estadoNovedad',$estadoNovedad);
      $registrarN = $this->objReporteInicial->RegistrarNovedad();

      echo $registrarN;
    } else {
      header("Location: ".URL."Error/Error");
    }
  }

  /* ========================================================================== *
  *  FUNCIÓN CancelarReporte():                                                 *
  *  Cancelar reporte inicial                                                   *
  *  ========================================================================== */

  public function CancelarReporte() {
    if(isset($_POST['ajax'])){
      $idChat = $_POST['idChat'];
      $descripcion = $_POST['descripcion'];
      $estadoReporte = "cancelado";

      $this->objReporteInicial->__SET('descripcionReporte', $descripcion);
      $this->objReporteInicial->__SET('estadoReporte', $estadoReporte);
      $this->objReporteInicial->__SET('idChat', $idChat);

      $cancelar = $this->objReporteInicial->CancelarReporte();

      echo $cancelar;
    } else {
      header('location: '.URL.'error/error');
    }
  }

  /* ========================================================================== *
  *  FUNCIÓN FinalizarReporte():                                                *
  *  Finaliza el reporte que se esta atendiendo                                 *
  *  ========================================================================== */

  public function FinalizarReporte(){
    if(isset($_POST['ajax'])){
      $rsp = $_POST['confirm'];
      $idUsuarioExterno = $_POST['idUsuarioE'];
      $this->objChatUsuario->__SET('idUsuarioExterno', $idUsuarioExterno);
      $finalizar = $this->objChatUsuario->FinalizarChat();
      echo $finalizar;
    } else {
      header('location: '. URL .'Error/error');
    }
  }

  /* ========================================================================== *
  *  FUNCIÓN PaginarReportes():                                                 *
  *  Consulta los reportes iniciales que se encuentren en proceso               *
  *  ========================================================================== */

  public function PaginarReportes() {
    if(isset($_POST['ajax'])){
      $configPaginador = $_POST;

      // TABLE
      $configPaginador['tableName'] = 'viewlistarreporteinicial';

      // FIELDS
      $configPaginador['fields'] = '*';

      // FILTER
      $configPaginador['filter'] = 'Activo';

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

      // COLUMN ORDER BY NAME
      $configPaginador['nameColumnOrderBy'] = 'fechaHoraEnvioReporteInicial';

      // COLUMN
      $configPaginador['nameColumnFilter'] = 'estadoTablaReporteInicial';

      $res = $this->objPagination->Paginate($configPaginador);
      echo json_encode($res);
    }else{
      header('location: '. URL .'Error/error');
    }
  }

  /* ========================================================================== *
  *  FUNCIÓN ConsultarNotificacionesChat():                                     *
  *  Consulta las notificaciones de chat del receptor inicial                   *
  *  ========================================================================== */
  public function ConsultarNotificacionesChat() {

    if (isset($_POST['ajax'])) {

      $this->objChatUsuario->__SET('idReceptorInicial', $_POST['idReceptor']);
      $notificaciones = $this->objChatUsuario->ConsultarNotificacionesChat();

      if (isset($notificaciones)) {

        $matriz = array();
        $array = array();

        foreach ($notificaciones as $notificacion) {
          $this->objChatUsuario->__SET('idChat', $notificacion->idChat);
          $mensaje = $this->objChatUsuario->ConsultarMensajeNotificacion();
          $array['idChat'] = $notificacion->idChat;
          $array['detalles'] = $mensaje;
          array_push($matriz, $array);
        }

        echo json_encode($matriz);

      } else {
        echo 0;
      }

    } else {
      header('location: '.URL.'error/error');
    }

  }

  // FUNCIÓN PARA CONSULTAR EL CHAT DE UNA NOTIFICACIÓN:
  public function ConsultarChatNotificacion() {

    if (isset($_POST['ajax'])) {

      $array = array();
      $this->objChatUsuario->__SET('idChat', $_POST['idChat']);
      $this->objChatUsuario->RegistrarVistoChat();
      $chat = $this->objChatUsuario->ConsultarChat();
      $this->objChatUsuario->__SET('idUsuarioExterno', $chat->idUsuarioExterno);
      $array['usuarioExterno'] = $this->objChatUsuario->ConsultarUsuarioExterno();
      $array['usuarioExterno']->idUsuario = $chat->idUsuarioExterno;
      $array['mensajes'] = $this->objChatUsuario->ConsultarMensajesChat();
      echo json_encode($array);

    } else {
      header('location: '.URL.'error/error');
    }

  }

  // FUNCIÓN PARA VALIDAR SI UN RECEPTOR INICIAL TIENE ALGÚN CHAT ACTIVO:
  public function ValidarChatActivoReceptor() {

    if (isset($_POST['ajax'])) {

      $this->objChatUsuario->__SET('idReceptorInicial', Sesion::getValue('ID_USUARIO'));
      $chat = $this->objChatUsuario->ValidarChatActivoReceptor();

      if (isset($chat)) {

        $array = array();
        $this->objChatUsuario->__SET('idChat', $chat->idChat);
        $this->objChatUsuario->__SET('idReceptorInicial', $chat->idReceptorInicial);
        $this->objChatUsuario->__SET('idUsuarioExterno', $chat->idUsuarioExterno);

        $infoReceptorInicial = $this->objChatUsuario->ConsultarReceptorInicial();
        $infoUsuarioExterno = $this->objChatUsuario->ConsultarUsuarioExterno();
        $mensajes = $this->objChatUsuario->ConsultarMensajesChat();

        $array['idChat'] = $chat->idChat;
        $array['usuarioExterno'] = $infoUsuarioExterno;
        $array['usuarioExterno']->idUsuario = $chat->idUsuarioExterno;
        $array['receptorInicial'] = $infoReceptorInicial;
        $array['receptorInicial']->idUsuario = $chat->idReceptorInicial;
        $array['mensajes'] = $mensajes;

        echo json_encode($array);

      } else {
        echo 0;
      }

    } else {
      header('location: '.URL.'error/error');
    }

  }

  // FUNCIÓN PARA REGISTRAR UN MENSAJE DE CHAT:
  public function RegistrarMensaje() {

    if (isset($_POST['ajax'])) {

      $this->objChatUsuario->__SET('idChat', $_POST['idChat']);
      $this->objChatUsuario->__SET('mensaje', $_POST['mensaje']);
      $this->objChatUsuario->__SET('tipo', 1);
      $mensajeRegistrado = $this->objChatUsuario->RegistrarMensaje();

      if ($mensajeRegistrado) {
        echo 1;
      } else {
        echo 0;
      }

    } else {
      header('Location: '.URL.'error/error');
    }

  }

}

?>

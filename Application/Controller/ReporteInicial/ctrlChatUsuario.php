<?php

/**
* NOMBRE DE LA CLASE: ctrlChatUsuario
* TIPO DE CLASE: Controlador
* DESCRIPCIÓN:
* Gestiona toda la funcionalidad del lado
* del servidor para la vista del usuario
*/
class ctrlChatUsuario extends Controller implements iController {

  private $objChatUsuario;

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

    } else if (Sesion::getValue('TIPO_USUARIO') === 'USUARIO' || Sesion::getValue('TIPO_USUARIO') === 'ADMINISTRADOR') {

      $this->objChatUsuario = $this->loadModel('ReporteInicial', 'mdlChatUsuario');

    } else {

      header('Location: ' . URL . 'Error/Error');
      exit();

    }

  }

  /**
  * Método Index() obligatorio
  * Renderiza la página principal de este controlador (ViewChatUsuario)
  */
  public function Index() {

    $idUsuario = intval(Sesion::getValue('ID_USUARIO'));
    $this->objChatUsuario->__SET('idUsuarioExterno', $idUsuario);
    $usuario = $this->objChatUsuario->ConsultarUsuarioExterno();

    require APP . 'View/ReporteInicial/viewChatUsuario.php'; // Carga nuestra vista
  }

  // FUNCIÓN PARA CONSULTAR LA INFORMACIÓN DE UN RECEPTOR INICIAL:
  public function ConsultarReceptorInicial() {

    if (isset($_POST['ajax'])) {

      $idReceptorInicial = $_POST['idReceptorInicial'];
      $this->objChatUsuario->__SET('idReceptorInicial', $idReceptorInicial);
      $infoReceptorInicial = $this->objChatUsuario->ConsultarReceptorInicial();
      echo json_encode($infoReceptorInicial);

    } else {
      header('location: '.URL.'error/error');
    }

  }

  // FUNCIÓN PARA REGISTRAR UN CHAT DE REPORTE INICIAL:
  public function RegistrarChat() {

    if (isset($_POST['ajax'])) {

      $this->objChatUsuario->__SET('idReceptorInicial', $_POST['idReceptorInicial']);
      $this->objChatUsuario->__SET('idUsuarioExterno', $_POST['idUsuarioExterno']);
      $idChatRegistrado = $this->objChatUsuario->RegistrarChat()[0];
      echo $idChatRegistrado;

    } else {
      header('location: '.URL.'error/error');
    }
  }

  public function ConsultarChatsReporteInicial() {
    if (isset($_POST['ajax'])) {
      $this->objChatUsuario->__SET('idUsuarioExterno', Sesion::getValue('ID_USUARIO'));
      $historialChat = $this->objChatUsuario->ConsultarChatsUsuario();
      if (isset($historialChat)) {

        $chats = array();

        foreach ($historialChat as $chatReporte) {
          $idReceptor = $chatReporte->idReceptorInicial;
          $idUsuarioExterno = $chatReporte->idUsuarioExterno;
          $this->objChatUsuario->__SET('idChat', $chatReporte->idChat);
          $PaqueteMensajesChatReporte = $this->objChatUsuario->ConsultarMensajesChat();
          $this->objChatUsuario->__SET('idReceptorInicial', $idReceptor);
          $this->objChatUsuario->__SET('idUsuarioExterno', $idUsuarioExterno);
          $PaqueteDatosReceptor = $this->objChatUsuario->ConsultarReceptorInicial();
          $PaqueteDatosUsuario = $this->objChatUsuario->ConsultarUsuarioExterno();

          // Agregar los atributos del chat a un array
          $Chat = array(
            "idChat" => $chatReporte->idChat,
            "fechaHoraInicioChat" => $chatReporte->fechaHoraInicioChat,
            "urlFotoReceptor" => $PaqueteDatosReceptor->urlFoto,
            "nombreReceptor" => $PaqueteDatosReceptor->nombre,
            "nombreUsuario" => $PaqueteDatosUsuario->nombre,
            "chat" => array()
          );

          if (isset($PaqueteMensajesChatReporte)) {
            foreach ($PaqueteMensajesChatReporte as $mensaje) {
              $mensajeChat = array();
              $mensajeChat["mensaje"] = $mensaje->mensaje;
              $mensajeChat["fechaHora"] = $mensaje->fechaHora;
              $mensajeChat["tipo"] = $mensaje->tipo;
              array_push($Chat['chat'], $mensajeChat);
            }
          }


          array_push($chats, $Chat);

        }
        echo json_encode($chats);

      } else {
        echo 0;
      }

    } else {
      header("Location: " . URL . "Error/Error");
    }
  }

  // FUNCIÓN PARA REGISTRAR UN MENSAJE DE CHAT:
  public function RegistrarMensaje() {

    if (isset($_POST['ajax'])) {

      $this->objChatUsuario->__SET('idChat', $_POST['idChat']);
      $this->objChatUsuario->__SET('mensaje', $_POST['mensaje']);
      $this->objChatUsuario->__SET('tipo', 2);
      $mensajeRegistrado = $this->objChatUsuario->RegistrarMensaje();

      if ($mensajeRegistrado) {
        echo 2;
      } else {
        echo 0;
      }

    } else {
      header('Location: '.URL.'error/error');
    }

  }

  // FUNCIÓN PARA VALIDAR SI UN USUARIO TIENE UN CHAT ACTIVO:
  public function ValidarChatActivo() {

    if (isset($_POST['ajax'])) {

      $array = array();
      $this->objChatUsuario->__SET('idUsuarioExterno', Sesion::getValue('ID_USUARIO'));
      $chat = $this->objChatUsuario->ValidarChatActivoUsuario();

      if (isset($chat)) {

        $this->objChatUsuario->__SET('idChat', $chat->idChat);
        $this->objChatUsuario->__SET('idReceptorInicial', $chat->idReceptorInicial);
        $this->objChatUsuario->__SET('idUsuarioExterno', $chat->idUsuarioExterno);
        $infoReceptorInicial = $this->objChatUsuario->ConsultarReceptorInicial();
        $infoUsuarioExterno = $this->objChatUsuario->ConsultarUsuarioExterno();
        $mensajes = $this->objChatUsuario->ConsultarMensajesChat();
        $array['idChat'] = $chat->idChat;
        $array['usuarioExterno'] = $infoUsuarioExterno;
        $array['receptorInicial'] = $infoReceptorInicial;
        $array['mensajes'] = $mensajes;

        echo json_encode($array);

      } else {
        echo 0;
      }

    } else {
      header('Location: '.URL.'error/error');
    }

  }

  // FUNCIÓN PARA FINALIZAR UN CHAT ACTIVO:
  public function FinalizarChat() {
    $this->objChatUsuario->__SET('idUsuarioExterno', Sesion::getValue('ID_USUARIO'));
    $this->objChatUsuario->FinalizarChat();
  }


}

?>

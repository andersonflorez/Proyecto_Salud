<?php

/**
* NOMBRE DE LA CLASE: ctrlSocket
* TIPO DE CLASE: Controlador
* DESCRIPCIÓN:
* Este controlador permite consultar la
* configuración de conexión al socket
* vía ajax.
*/
class ctrlSocket {

  /**
  * Método Index()
  * Lleva hacia la página de error debido a que este controlador solo
  * debe ser accedido vía ajax
  */
  public function Index() {
    header('location: ' . URL . 'error/error');
  }

  // La siguiente función retorna la configuración de acceso al socket:
  public function getWebSocketUrl() {

    if (isset($_POST['wsajax'])) {

      $config = array('socketIP' => SOCKET_IP, 'socketPort' => SOCKET_PORT);
      echo json_encode($config);

    } else {
      header('location: ' . URL . 'error/error');
    }

  }

}

?>

<?php

/**
* NOMBRE DE LA CLASE: ctrlSesion
* TIPO DE CLASE: Controlador
* DESCRIPCIÓN:
* Controlador creado con el fin de responder a las
* peticiones ajax de las vistas que requieran los datos
* de la sesión de un usuario
*/
class ctrlSesion extends Controller implements iController {

  /**
  * Método constructor()
  * Inicializa el uso de variables de sesión y
  * valida si hay una sesión abierta, sino la hay
  * redirecciona hacia el login de la aplicación:
  */
  public function __construct() {

    Sesion::init();

    if (!Sesion::exist()) {

      header("Location: " . URL . "Usuarios/Usuario");
      exit();

    }

  }

  /**
  * Método Index()
  * Renderiza la página de error debido a que este archivo solo puede
  * ser accedido mediante ajax
  */
  public function Index() {

    if (isset($_POST['ajax'])) {

      $_SESION_ACTUAL = array(
        "ID_USUARIO" => Sesion::getValue('ID_USUARIO'),
        "NOMBRE" => Sesion::getValue('NOMBRES') . ' ' . Sesion::getValue('APELLIDOS'),
        "USUARIO" => Sesion::getValue('USUARIO'),
        "TIPO_USUARIO" => Sesion::getValue('TIPO_USUARIO'),
        "DIRECCION_IP" => $_SERVER['REMOTE_ADDR']
      );

      echo json_encode($_SESION_ACTUAL);

    } else {
      header("Location: " . URL . "error/error");
    }

  }

}

?>

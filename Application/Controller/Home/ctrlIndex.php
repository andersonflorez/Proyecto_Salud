<?php
/**
* NOMBRE DE LA CLASE: CtrlIndex
* Este controlador esta asociado a la vista de usuario externo,
* y su única finalidad es recibir a este tipo de usuarios e informar,
* sobre las caracteristicas del aplicativo.
*/
class CtrlIndex extends Controller implements iController {


  /**
  * Método constructor()
  * Inicializa el uso de variables de sesión y
  * valida si hay una sesión abierta, sino la hay
  * redirecciona hacia el login de la aplicación:
  */
  public function __construct() {
    // Descomentar lo siguiente cuando el login de usuarios se encuentre listo (y eliminar este comentario):

    /*Sesion::init();
    if (!Sesion::exist()) {
      header("Location: " . URL . "Usuarios/Usuario");
      exit();
    }*/
  }

  /**
  * Método Index() obligatorio
  * Renedriza la página principal de este controlador (ej: 'View/Home/index.php')
  */
  public function Index() {
    require APP . 'View/Home/index.php'; // Carga nuestra vista
  }

} // Fin clase php

?>

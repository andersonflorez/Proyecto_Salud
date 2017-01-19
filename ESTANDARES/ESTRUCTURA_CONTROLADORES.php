<?php

/**
* NOMBRE DE LA CLASE: ControlNombreDelControlador
* TIPO DE CLASE: Controlador
* DESCRIPCIÓN:
* Escribe aqui la descripción de lo que hace este controlador.
* Copia este formato de controlador para todos los controladores
* que necesites crear ya que todos deben tener esta estructura.
*/
class ControlNombreDelControlador extends Controller implements iController {

  // NOTA: Revisar el archivo 'COMO LINKEAR CSS - IMG - JS.txt' para entender
  // las dos siguientes lineas de código:
  private $styles;
  private $scripts;

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

    // NOTA: Revisar el archivo 'COMO LINKEAR CSS - IMG - JS.txt' para entender
    // las dos siguientes lineas de código:
    $this->styles = array();
    $this->scripts = array();

    require APP . 'View/_layout/header.php'; // Carga la barra de navegación y los CSS
    require APP . 'View/TuMódulo/ViewNombreVista.php'; // Carga nuestra vista
    require APP . 'View/_layout/footer.php'; // Carga los Javascripts
  }

}

?>

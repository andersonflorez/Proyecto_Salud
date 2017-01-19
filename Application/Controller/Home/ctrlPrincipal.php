<?php

class CtrlPrincipal extends Controller implements iController {

  private $_mdlPrincipal = null;
  private $styles;
  private $scripts;
  private $vistasMenu;
  private $MdlCitas;

  function __construct() {

    Sesion::init();

    if (!Sesion::exist()) {
      header("Location: ".URL);
    } else {
      $this->_mdlPrincipal = $this->loadModel('Home', 'mdlPrincipal');
      $this->MdlCitas=$this->loadModel('Citas','mdlCitas');
      $this->MdlCitas->RemoveMoraPaciente();
    }

  }

  /**
  * METODO: Index
  * Este metodo se ejecuta cuando solicito la URL :
  * http://nombreDeTuProyecto/Cuentas/registros
  * NOTA: Esta es la página por defecto cuando no se encuentra la URL.
  */
  public function Index() {

    // Carga las vistas
    $this->vistasMenu = json_decode(Sesion::getValue('VISTAS_MENU'));

    $this->styles = array(
      'Todos/main.css',
      'Todos/animate.css',
      'user.css'
    );

    require APP . 'View/_layout/header.php';
    require APP . 'View/Home/viewIndex.php';
    require APP . 'View/_layout/footer.php';

  }

}

?>

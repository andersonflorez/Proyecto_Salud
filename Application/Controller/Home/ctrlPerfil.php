<?php

class ctrlPerfil extends Controller implements iController {

  private $scripts;
  private $styles;
  private $objPerfil = null;
  private $objConsultarPerfil = null;
  private $vistasMenu;

  public function __construct() {

    // Primero se debe habilitar el uso de sesiones:
    Sesion::init();

    // Luego preguntar si el usuario esta logueado:
    if (!Sesion::exist()) {

      // Sino, sera enviado hacia el login:
      header("Location: " . URL);
      exit();

    } else if (Sesion::getValue('TIPO_USUARIO') === 'ADMINISTRADOR' || Sesion::getValue('TIPO_USUARIO') === 'PARAMEDICO'  || Sesion::getValue('TIPO_USUARIO') === 'MEDICO' || Sesion::getValue('TIPO_USUARIO') === 'AUXILIAR_DE_ENFERMERIA' || Sesion::getValue('TIPO_USUARIO') === 'CONTROL_MEDICO' || Sesion::getValue('TIPO_USUARIO') === 'ENFERMERA_JEFE' || Sesion::getValue('TIPO_USUARIO') === 'RECEPTOR_INICIAL' || Sesion::getValue('TIPO_USUARIO') === 'USUARIO' || Sesion::getValue('TIPO_USUARIO') === 'MEDICO_EXTERNO') {

    $this->objPerfil = $this->loadModel('Home', 'mdlPerfil');

    } else {

      // En caso de que no cumpla ninguna de estas condiciones entonces sera redireccionado a la pagina de error:
      header("Location: " . URL . 'Error/Error');
      exit();

    }

  }

  public function Index() {

    $idUsuario = intval(Sesion::getValue('ID_USUARIO'));
    $this->objPerfil->__SET('idUsuario', $idUsuario);
    $usuario = $this->objPerfil->ConsultarPerfil();

    $this->vistasMenu = json_decode(Sesion::getValue('VISTAS_MENU'));

    $this->styles = array(
      "Usuarios/perfil.css",
      "ReporteInicial/comun.css"
    );

    require APP . 'View/_layout/header.php';
    require APP . 'View/Home/viewPerfil.php';
    require APP . 'View/_layout/footer.php';

  }

}

?>

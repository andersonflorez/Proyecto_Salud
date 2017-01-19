<?php

class ctrlConsultarPersona extends Controller implements iController
{

  private $styles;
  private $scripts;
  private $objConsultarPersona = null;
  private $vistasMenu;

  public function __construct() {

    Sesion::init();

    if (!Sesion::exist()) {

      header("Location: " . URL);
      exit();

    } else if (Sesion::getValue('TIPO_USUARIO') === 'ADMINISTRADOR') {

      $this->objConsultarPersona = $this->loadModel('Usuarios', 'mdlConsultarPersona');

    } else {

      header("Location: " . URL . 'Error/Error');
      exit();

    }

  }

  /**
  * METODO: Index
  * Este metodo se ejecuta cuando solicito la URL :
  * http://nombreDeTuProyecto/Cuentas/registros
  * NOTA: Esta es la página por defecto cuando no se encuentra la URL.
  */

  public function Index() {

    $this->vistasMenu = json_decode(Sesion::getValue('VISTAS_MENU'));

    $this->scripts = array(
      "Usuarios/consultarPersona.js",
      "Todos/Maestras/datatables.js",
      "Todos/modal.js"
    );

    $this->styles = array(
      "Maestras/jquery.dataTables.css"
    );

    $tipoDocumento = $this->objConsultarPersona->listarComboTipoDocumento();
      $rol= $this->objConsultarPersona->listarComboRoles();

    require APP . 'View/_layout/header.php';
    require APP . 'View/Usuarios/viewConsultarPersona.php';
    require APP . 'View/_layout/footer.php';

  }

  public function ListarPersonas() {

    $Listar = $this->objConsultarPersona->consultarPersonas();
    echo json_encode($Listar);

  }

  public function ListarComboTipoDocumento() {

    $respuestaTD = $this->objConsultarPersona->listarComboTipoDocumento();
    echo json_encode($respuestaTD);

  }

  public function ListarComboRol() {

    $respuestaR = $this->objConsultarPersona->listarComboRol();
    echo json_encode($respuestaR);

  }

  public function ListarComboRoles() {

    $respuestaR = $this->objModificarPersona->listarComboRoles();
    echo json_encode($respuestaR);

  }

  public function ListarComboEspecialidad() {

    $respuestaE = $this->objConsultarPersona->listarComboEspecialidad();
    echo json_encode($respuestaE);

  }

  public function traerId() {

    $ConsultPersonaid12 = $this->objConsultarPersona->ConsultarPersonaId($_POST['id']);
    echo json_encode($ConsultPersonaid12);

  }

  public function traerRol() {

    $ConsultRolid12 = $this->objConsultarPersona->ConsultarRol($_POST['id']);
    echo json_encode($ConsultRolid12);

  }

  public function CambiarEstadoPersona() {

    $idPersona          = $_POST['idPersona'];
    $estadoTablaPersona = $_POST['estadoTablaPersona'];
    $estadoTablaPersona = $estadoTablaPersona == 'Activo' ? 'Inactivo' : 'Activo';
    echo $this->objConsultarPersona->CambiarEstadoPersona($idPersona, $estadoTablaPersona);

  }

}

?>

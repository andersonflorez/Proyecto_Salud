<?php

/**
* Class nombre_del_controlador:
* Escribe aqui la descripción de lo que hace este controlador
* Copia este formato de controlador para todos los controladores
* que necesites crear ya que todos deben tener esta estructura.
*/
class CtrlHistorialCitas extends Controller implements iController {

  private $scripts;
  private $styles;
  private $objCitas = null;
  private $vistasMenu;

  /**
* Método constructor()
* Inicializa el uso de variables de sesión y
* valida si hay una sesión abierta, sino la hay
* redirecciona hacia el login de la aplicación:
*/
public function __construct() {

  // Primero se debe habilitar el uso de sesiones:
  Sesion::init();

  // Luego preguntar si el usuario esta logueado:
  if (!Sesion::exist()) {

    // Sino, sera enviado hacia el login:
    header("Location: " . URL);
    exit();

  // En caso de que el usuario este logueado, preguntar por su rol,
  // Aqui hay que validar los roles que tienen permiso a esta vista (deben ir en mayusculas):
  // ADMINISTRADOR, RECEPTOR_INICIAL, USUARIO, ENFERMERA_JEFE, AUXILIAR_DE_ENFERMERIA, MEDICO,
  // CONTROL_MEDICO, DESPACHADOR
  } else if (Sesion::getValue('TIPO_USUARIO') === 'ADMINISTRADOR' || Sesion::getValue('TIPO_USUARIO') === 'MEDICO') {

    // Es recomendable cargar los modelos en este apartado:
    $this->mdlHistorialCitas=$this->loadModel('Citas','mdlHistorialCitas');

  } else {

    // En caso de que no cumpla ninguna de estas condiciones entonces sera redireccionado a la pagina de error:
    header("Location: " . URL . 'Error/Error');
    exit();

  }

}

  /**
  * Método Index() obligatorio
  * Carga la página principal de este controlador:
  */
  public function Index() {
    $this->vistasMenu = json_decode(Sesion::getValue('VISTAS_MENU'));
    $this->scripts = array(
      "Citas/Historial.js",
      "Todos/modal.js",
      "Citas/DtaTable.js"

    );

    $this->styles = array(
      "Citas/DtaTable.css"
    );

    require APP . 'View/_layout/header.php';
    require APP . 'View/Citas/ViewHistorialCitas.php';
    require APP . 'View/_layout/footer.php';
  }

  public function ListarCitasT(){
    $respuestaA = $this->mdlHistorialCitas->ListarCitasTotal();
    if ($respuestaA) {
      echo json_encode($respuestaA);
    }else {
      echo json_encode(null);
    }
  }

  public function ConsultaPersonalAsi(){
    $idCita= $_POST['idCita'];
    $this->mdlHistorialCitas->__SET("_idCita",$idCita);
    $respuestaA = $this->mdlHistorialCitas->ConsultarPersonalAsis();
    echo json_encode($respuestaA);
  }



}

?>

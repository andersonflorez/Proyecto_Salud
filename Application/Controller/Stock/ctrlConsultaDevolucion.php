<?php
/*
* NOMBRE DE LA CLASE: CtrlConsultaDevolucion
* TIPO DE CLASE: Controlador
* DESCRIPCIÓN:
* Escribe aqui la descripción de lo que hace este controlador.
* Copia este formato de controlador para todos los controladores
* que necesites crear ya que todos deben tener esta estructura.
*/
class CtrlConsultaDevolucion extends Controller implements iController {
  private $scripts;
  private $styles;
  private $MdlConsultaDev=null;
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
      // ADMINISTRADOR
    } else if (Sesion::getValue('TIPO_USUARIO') === 'ADMINISTRADOR') {
      // Es recomendable cargar los modelos en este apartado:
      $this->MdlConsultaDev = $this->loadModel('Stock', 'MdlConsultaDevolucion');
    } else {
      // En caso de que no cumpla ninguna de estas condiciones entonces sera redireccionado a la pagina de error:
      header("Location: " . URL . 'Error/Error');
      exit();
    }
  }
  /*
  * Método Index() obligatorio
  * Renedriza la página principal de este controlador (ej: 'View/Home/index.php')
  */
  public function Index() {
    $this->vistasMenu = json_decode(Sesion::getValue('VISTAS_MENU'));
    $this->styles = array(
      "Stock/style.css",
      "Todos/select2.css",
      "Todos/sweetalert.css",
      "Maestras/jquery.dataTables.css"
    );
    $this->scripts = array (
    "Stock/consultaDevolucion.js",
    "Todos/modal.js",
    "Lib/select2.js",
    "Stock/datatables.js",
    "Todos/sweetalert.js",
    "Validaciones/Standard_Validations.js"
  );
  require APP . 'View/_layout/header.php'; // Carga la barra de navegación y los CSS
  require APP . 'View/Stock/ViewConsultaDevolucion.php'; // Carga nuestra vista
  require APP . 'View/_layout/footer.php'; // Carga los Javascripts
}


public function ListarAsignacion(){
  $ConsultAsig = $this->MdlConsultaDev->ListarAsignacion();
  echo json_encode($ConsultAsig);
}

public function ConsultarDevolucion(){

  $ConsultKDev = $this->MdlConsultaDev->ConsultarDevolucion($_POST['idAsignacion']);
  echo json_encode($ConsultKDev);
}




}
?>

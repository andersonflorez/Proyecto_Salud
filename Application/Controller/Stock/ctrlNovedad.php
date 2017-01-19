<?php
/*
* NOMBRE DE LA CLASE: CtrlNovedad
* TIPO DE CLASE: Controlador
* DESCRIPCIÓN:
* Escribe aqui la descripción de lo que hace este controlador.
* Copia este formato de controlador para todos los controladores
* que necesites crear ya que todos deben tener esta estructura.
*/
class CtrlNovedad extends Controller implements iController {
  private $scripts;
  private $styles;
  private $MdlNovedad = null;
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
      $this->MdlNovedad = $this->loadModel('Stock', 'MdlNovedad');
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
    // NOTA: Revisar el archivo 'COMO LINKEAR CSS - IMG - JS.txt' para entender
    // las dos siguientes lineas de código:
    $this->styles = array(
      "Stock/style.css",
      "Todos/select2.css",
      "Todos/sweetalert.css",
      "Maestras/jquery.dataTables.css"
    );
    $this->scripts = array (
    "Stock/novedad.js",
    "Todos/modal.js",
    "Lib/select2.js",
    "Stock/datatables.js",
    "Todos/sweetalert.js",
    "Validaciones/Standard_Validations.js"
  );
  $idPersona = $this->MdlNovedad->ListarPersona();
  $idDetallekit = $this->MdlNovedad->ListarDetalleKit();
  $idTipoNovedad= $this->MdlNovedad->ListarTipoNovedad();
  require APP . 'View/_layout/header.php'; // Carga la barra de navegación y los CSS
  require APP . 'View/Stock/ViewConsultaNovedad.php'; // Carga nuestra vista
  require APP . 'View/_layout/footer.php'; // Carga los Javascripts
}

public function RegistrarNovedad(){
  $descripcionNovedad = $_POST['descripcionNovedad'];
  date_default_timezone_get('America/Bogota');
  $fechaHoraNovedad= date("Y-m-d H:m:s");
  $estadoTablaNovedad = 'Activo';
  $idDetallekit = $_POST['idDetallekit'];
  $idPersona = $_POST['idPersona'];
  $idTipoNovedad = $_POST['idTipoNovedad'];
  $this->MdlNovedad->__SET("_descripcionNovedad", $descripcionNovedad);
  $this->MdlNovedad->__SET("_fechaHoraNovedad", $fechaHoraNovedad);
  $this->MdlNovedad->__SET("_estadoTablaNovedad", $estadoTablaNovedad);
  $this->MdlNovedad->__SET("_idDetallekit", $idDetallekit);
  $this->MdlNovedad->__SET("_idPersona", $idPersona);
  $this->MdlNovedad->__SET("_idTipoNovedad", $idTipoNovedad);

  $this->MdlNovedad->RegistrarNovedad();
  if ($this == true) {
    echo json_encode(['Bien']);
  }else{
    echo json_encode(['Mal']);
  }
}

public function ConsultarNovedad(){
  $ConsultNovedad = $this->MdlNovedad->ConsultarNovedad();
  echo json_encode($ConsultNovedad);
}


public function traerId(){
  $ConsultNovedadid12 = $this->MdlNovedad->traerId($_POST['id']);
  echo json_encode($ConsultNovedadid12);
}

public function CambiarEstadoNovedad(){
  $idNovedadRecurso = $_POST['idNovedadRecurso'];
  $estadoTablaNovedad = $_POST['estadoTablaNovedad'];
  $estadoTablaNovedad = $estadoTablaNovedad == 'Activo'? 'Inactivo' : 'Activo';

  $this->MdlNovedad->__SET("_idNovedadRecurso",$idNovedadRecurso);
  $this->MdlNovedad->__SET("_estadoTablaNovedad",$estadoTablaNovedad);
  echo $this->MdlNovedad->CambiarEstadoNovedad();
}

}
?>

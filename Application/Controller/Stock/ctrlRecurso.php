<?php
/*
* NOMBRE DE LA CLASE: CtrlRecurso
* TIPO DE CLASE: Controlador
* DESCRIPCIÓN:
* Escribe aqui la descripción de lo que hace este controlador.
* Copia este formato de controlador para todos los controladores
* que necesites crear ya que todos deben tener esta estructura.
*/
class CtrlRecurso extends Controller implements iController {
  private $scripts;
  private $styles;
  private $MdlRecurso = null;
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
      $this->MdlRecurso= $this->loadModel('Stock','mdlRecurso');
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
    "Stock/recurso.js",
    "Todos/modal.js",
    "Lib/select2.js",
    "Stock/datatables.js",
    "Todos/sweetalert.js",
    "Validaciones/Standard_Validations.js"
  );
  $idCategoriaRecurso = $this->MdlRecurso->ListarCategoriaRecurso();
  require APP . 'View/_layout/header.php'; // Carga la barra de navegación y los CSS
  require APP . 'View/Stock/ViewRegistroRecurso.php'; // Carga nuestra vista
  require APP . 'View/_layout/footer.php'; // Carga los Javascripts
}

public function RegistrarRecurso(){
  $nombre = $_POST['nombre'];
  $descripcion = $_POST['descripcion'];
  $cantidadRecurso = $_POST['cantidadRecurso'];
  $estadoTablaRecurso = 'Activo';
  $idCategoriaRecurso = $_POST['idCategoriaRecurso'];

  $this->MdlRecurso->__SET("_nombre", $nombre);
  $this->MdlRecurso->__SET("_descripcion", $descripcion);
  $this->MdlRecurso->__SET("_cantidadRecurso", $cantidadRecurso);
  $this->MdlRecurso->__SET("_estadoTablaRecurso", $estadoTablaRecurso);
  $this->MdlRecurso->__SET("_idCategoriaRecurso", $idCategoriaRecurso);

  $this->MdlRecurso->RegistrarRecurso();

  if ($this == true) {
    echo json_encode(['Bien']);
  }else{
    echo json_encode(['Mal']);
  }
}

public function ConsultarRecurso(){
  $ConsultRecurso = $this->MdlRecurso->ConsultarRecurso();
  echo json_encode($ConsultRecurso);
}

public function ActualizarRecurso(){
  $nombre = $_POST['nombreA'];
  $descripcion = $_POST['descripcionA'];
  $cantidadRecurso = $_POST['cantidadRecursoA'];
  $idCategoriaRecurso = $_POST['idCategoriaRecursoA'];
  $idrecurso = $_POST['idrecursoA'];

  $this->MdlRecurso->__SET("_nombreA", $nombre);
  $this->MdlRecurso->__SET("_descripcionA", $descripcion );
  $this->MdlRecurso->__SET("_cantidadRecursoA", $cantidadRecurso);
  $this->MdlRecurso->__SET("_idCategoriaRecursoA", $idCategoriaRecurso);
  $this->MdlRecurso->__SET("_idrecursoA", $idrecurso);
  $Act = $this->MdlRecurso->ActualizarRecurso();
  if ($Act == true){
    echo json_encode(['Bien']);
  } else{
    echo json_encode(['Mal']);
  }
}

public function traerId(){
  $ConsultRecursoid12 = $this->MdlRecurso->traerId($_POST['id']);
  echo json_encode($ConsultRecursoid12);
}

public function CambiarEstadoRecurso(){
  $idrecurso = $_POST['idrecurso'];
  $estadoTablaRecurso = $_POST['estadoTablaRecurso'];
  $estadoTablaRecurso = $estadoTablaRecurso == 'Activo'? 'Inactivo' : 'Activo';
  echo $this->MdlRecurso->CambiarEstadoRecurso($idrecurso, $estadoTablaRecurso);
}

}

?>

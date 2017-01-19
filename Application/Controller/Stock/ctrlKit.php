<?php
/*
* NOMBRE DE LA CLASE: ctrlKit
* TIPO DE CLASE: Controlador
* DESCRIPCIÓN:
* Escribe aqui la descripción de lo que hace este controlador.
* Copia este formato de controlador para todos los controladores
* que necesites crear ya que todos deben tener esta estructura.
*/
class CtrlKit extends Controller implements iController {
  private $scripts;
  private $styles;
  private $MdlKit=null;
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
      $this->MdlKit = $this->loadModel('Stock', 'MdlKit');
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
    "Stock/kit.js",
    "Todos/modal.js",
    "Lib/select2.js",
    "Stock/CamposKit.js",
    "Stock/datatables.js",
    "Todos/sweetalert.js",
    "Validaciones/Standard_Validations.js"
  );
  $tipoKit = $this->MdlKit->ListarTipoKit();
  $idRecurso = $this->MdlKit->ListaridRecurso();
  require APP . 'View/_layout/header.php'; // Carga la barra de navegación y los CSS
  require APP . 'View/Stock/ViewRegistroKit.php'; // Carga nuestra vista
  require APP . 'View/_layout/footer.php'; // Carga los Javascripts
}

public function RegistrarKit(){
  $idRecurso = $_POST['idRecurso'];
  $unidadMedida = $_POST['unidadMedida'];
  $stockminKit = $_POST['stockminKit'];
  $idTipoKit = $_POST['tipokit'];
  $estadoTablaEstandarKit = 'Activo';

  for($i=0;$i<count($idRecurso);$i++){
    $this->MdlKit->__SET("_idRecurso",$idRecurso[$i]);
    $this->MdlKit->__SET("_unidadMedida",$unidadMedida[$i] );
    $this->MdlKit->__SET("_stockminKit",$stockminKit[$i]);
    $this->MdlKit->__SET("_idTipoKit",$idTipoKit );
    $this->MdlKit->__SET("_estadoTablaEstandarKit",$estadoTablaEstandarKit);

    $this->MdlKit->RegistrarKit();
  }
}

public function ListaridRecurso(){
  $idRecurso = $this->MdlKit->ListaridRecurso();
  echo json_encode($idRecurso);
}

public function ListarTipoKit(){
  $ConsultTKit = $this->MdlKit->ListarTipoKit();
  echo json_encode($ConsultTKit);
}

public function ConsultarKit(){
  $ConsultKit = $this->MdlKit->ConsultarKit($_POST['idTipoKit']);
  echo json_encode($ConsultKit);
}

public function ActualizarKit(){
  $idRecurso= $_POST['idRecursoA'];
  $stockminKit = $_POST['stockminKitA'];
  $unidadMedida = $_POST['unidadMedidaA'];
  $idTipoKit = $_POST['tipokitA'];
    $idEstandarkit = $_POST['idEstandarkitA'];

  $this->MdlKit->__SET("_idRecursoA",$idRecurso);
  $this->MdlKit->__SET("_unidadMedidaA",$unidadMedida);
  $this->MdlKit->__SET("_stockminKitA",$stockminKit);
  $this->MdlKit->__SET("_idTipoKitA",$idTipoKit);
    $this->MdlKit->__SET("_idEstandarKitA",$idEstandarkit);
  $this->MdlKit->ActualizarKit();
  if ($this == true){
    echo json_encode(['Bien']);
  } else{
    echo json_encode(['Mal']);
  }
}

public function traerId(){
  $ConsultKitid12 = $this->MdlKit->ConsultarKitId($_POST['id']);
  echo json_encode($ConsultKitid12);
}

public function traerIdKit(){
  $ConsulTipoKit = $this->MdlKit->traerIdKit($_POST['id']);
  echo json_encode($ConsulTipoKit);
}

public function CambiarEstadoEstandarKit(){
  $idEstandarkit = $_POST['idEstandarkit'];
  $estadoTablaEstandarKit = $_POST['estadoTablaEstandarKit'];

  $estadoTablaEstandarKit = $estadoTablaEstandarKit == 'Activo'? 'Inactivo' : 'Activo';
  $this->MdlKit->__SET("_idEstandarKit", $idEstandarkit);
  $this->MdlKit->__SET("_estadoTablaEstandarKit", $estadoTablaEstandarKit);
  echo $this->MdlKit->CambiarEstadoEstandarKit();
}

}
?>

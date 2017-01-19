<?php
/*
* NOMBRE DE LA CLASE: ctrlDevolucionNovedad
* TIPO DE CLASE: Controlador
* DESCRIPCIÓN:
* Escribe aqui la descripción de lo que hace este controlador.
* Copia este formato de controlador para todos los controladores
* que necesites crear ya que todos deben tener esta estructura.
*/
class CtrlDevolucionNovedad extends Controller implements iController {
  private $scripts;
  private $styles;
  private $MdlDevolucion = null;
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
      $this->MdlDevolucion = $this->loadModel('Stock', 'MdlDevolucionNovedad');
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
    "Stock/devolucionNovedad.js",
    "Todos/modal.js",
    "Lib/select2.js",
    "Stock/datatables.js",
    "Todos/sweetalert.js",
    "Validaciones/Standard_Validations.js"
  );
  $idPaciente = $this->MdlDevolucion->ListarPaciente();
  $idPersona = $this->MdlDevolucion->ListarPersona();
  $idAmbulancia = $this->MdlDevolucion->ListarAmbulancia();
  $idTipoDevolucion = $this->MdlDevolucion->ListarTipoDevolucion();
  $idTipoNovedad = $this->MdlDevolucion->ListarTipoNovedad();

  require APP . 'View/_layout/header.php'; // Carga la barra de navegación y los CSS
  require APP . 'View/Stock/ViewDevolucionNovedad.php'; // Carga nuestra vista
  require APP . 'View/_layout/footer.php'; // Carga los Javascripts
}

public function ConfirmarAsignacion(){
  $id = $_POST['idTipo'];
  $select = $_POST['select'];
  $fecha = $_POST['fecha'];
  $ConfiAsignacion=$this->MdlDevolucion->ConfirmarAsignacion($id,$select,$fecha);

  if ($ConfiAsignacion != null) {
    echo json_encode($ConfiAsignacion);
  }else{
    echo json_encode(null);
  }
}

public function RegistrarDevolucion(){
  $datos = json_decode($_POST['datos']);
  foreach ($datos as $key => $value) {
    $cantidad= $value->cantidad;
    date_default_timezone_get('America/Bogota');
    $fechaHoraDevolucion=  $value->fechaHoraDevolucion = date("Y-m-d H:m:s");
    $estadoTablaDevolucion = $value->estadoTablaDevolucion = 'Activo';
    $idTipoDevolucion = $value->idTipoDevolucion;
    $idDetallekit =$value->idDetallekit;
    $idPersona = $value->idPersona;
    $this->MdlDevolucion->__SET("_cantidad", $cantidad);
    $this->MdlDevolucion->__SET("_fechaHoraDevolucion", $fechaHoraDevolucion);
    $this->MdlDevolucion->__SET("_estadoTablaDevolucion", $estadoTablaDevolucion);
    $this->MdlDevolucion->__SET("_idTipoDevolucion", $idTipoDevolucion);
    $this->MdlDevolucion->__SET("_idDetallekit", $idDetallekit);
    $this->MdlDevolucion->__SET("_idPersona", $idPersona);
    $res = $this->MdlDevolucion->RegistrarDevolucion();
  }
  if ($res) {
    echo json_encode($res);
  }else{
    echo json_encode("Mal");
  }

}


public function traerId(){
  $ConsultDet = $this->MdlDevolucion->traerId($_POST['id']);
  echo json_encode($ConsultDet);
}

public function ConsultaDetalle(){
  require APP . 'View/_layout/header.php'; // Carga la barra de navegación y los CSS
  require APP . 'View/Stock/ViewConsultaDetalle.php'; // Carga nuestra vista
  require APP . 'View/_layout/footer.php'; // Carga los Javascripts json_encode(null);
}

}
?>

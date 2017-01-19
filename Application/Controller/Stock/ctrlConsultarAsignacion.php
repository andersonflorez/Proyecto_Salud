<?php
/*
* NOMBRE DE LA CLASE: ctrlregistroAsignacion
* TIPO DE CLASE: Controlador
* DESCRIPCIÓN:
* Escribe aqui la descripción de lo que hace este controlador.
* Copia este formato de controlador para todos los controladores
* que necesites crear ya que todos deben tener esta estructura.
*/
class ctrlConsultarAsignacion extends Controller implements iController {
    private $scripts;
    private $styles;
     private $vistasMenu;
    private $objAsignacion = null;
  // NOTA: Revisar el archivo 'COMO LINKEAR CSS - IMG - JS.txt' para entender
  // las dos siguientes lineas de código:
  /*
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
    $this->objAsignacion = $this->loadModel ('Stock', 'mdlregistrarAsignacion');
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
    // NOTA: Revisar el archivo 'COMO LINKEAR CSS - IMG - JS.txt' para entender
    // las dos siguientes lineas de código:
    $this->vistasMenu = json_decode(Sesion::getValue('VISTAS_MENU'));
      $this->styles = array(
      "Stock/style.css",
      "Maestras/jquery.dataTables.css"

      );
      $this->scripts = array (
      "Stock/datatables.js",
      "Stock/Asignacion.js",
      "Todos/modal.js",
      "Stock/datatables.js",
      "Todos/sweetalert.js",
      "Validaciones/Standard_Validations.js"

      );

    require APP . 'View/_layout/header.php'; // Carga la barra de navegación y los CSS
    require APP . 'View/Stock/ViewConsultaAsignacion.php'; // Carga nuestra vista
    require APP . 'View/_layout/footer.php'; // Carga los Javascripts
  }


public function listarComboTipoAsignacion(){
$respuesta = $this->objAsignacion->listarComboTipoAsignacion();
echo json_encode($respuesta);

}

public function listarComboAmbulancias(){
$respuesta = $this->objAsignacion->listarComboAmbulancia();
echo json_encode($respuesta);

}

public function listarComboPaciente(){
$respuesta = $this->objAsignacion->listarComboPaciente();
echo json_encode($respuesta);
}

public function listarComboPersona(){
$respuesta = $this->objAsignacion->listarComboPersona();
echo json_encode($respuesta);
}

public function ConsultarAsignacion(){
$ConsultAsignacion = $this->objAsignacion->ConsultarAsignacion();
echo json_encode($ConsultAsignacion);
}

 public function consultarTblDetalleKit(){
    $listarTblKit=$this->objAsignacion->consultarTblDetalleKit($_POST['idAsignacion']);
    echo json_encode($listarTblKit);
  }


public function ActualizarAsignacion(){
require APP . 'View/_layout/header.php'; // Carga la barra de navegación y los CSS
require APP . 'View/Stock/ViewModificarAsignacion.php'; // Carga nuestra vista
require APP . 'View/_layout/footer.php'; // Carga los Javascripts
$idAsignacion = $_POST['idAsignacion'];
$FechaAsignacion = $_POST['FechaAsiganacion'];
$TipoAsignacion = $_POST['slcTipoAsignacion'];
$CodigoAmbulancia = $_POST['slcCodigoAmbulancia'];
$NombreMedico = $_POST['slcNombrePersona'];
$NombrePaciente = $_POST['slcNombrePaciente'];
$ActAsignacion = $this->objAsignacion->ActualizarAsignacion($idAsignacion,$FechaAsignacion,
$TipoAsignacion,$CodigoAmbulancia,$NombreMedico,$NombrePaciente);
    if ($ActAsignacion == true){
      echo json_encode(['Bien']);
    } else{
        echo json_encode(['Mal']);
    }
}

      public function ConsultarAsignacionId(){
        require APP . 'View/_layout/header.php'; // Carga la barra de navegación y los CSS
        require APP . 'View/Stock/ViewModificarAsignacion.php'; // Carga nuestra vista
        require APP . 'View/_layout/footer.php';
 }

 public function traerId2($id){
  error_reporting(0);
   $ConsultAsignacionid12 = $this->objAsignacion->ConsultarAsignacionId($id);
   $TipoAsignacion = $this->objAsignacion->listarComboTipoAsignacion();
   $this->scripts = array (
   "Stock/Asignacion.js"
   );
       require APP . 'View/_layout/header.php'; // Carga la barra de navegación y los CSS
       require APP . 'View/Stock/ViewModificarAsignacion.php'; // Carga nuestra vista
       require APP . 'View/_layout/footer.php';
    echo '<script>
      $("#txtTipoAsignacion> option[value='."'".$ConsultAsignacionid12->idAsignacion."'".']").attr("selected", "selected");
    </script>';
    }
  }
?>

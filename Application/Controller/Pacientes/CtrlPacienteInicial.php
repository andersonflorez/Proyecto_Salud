<?php

/**
* Class nombre_del_controlador:
* Escribe aqui la descripción de lo que hace este controlador
* Copia este formato de controlador para todos los controladores
* que necesites crear ya que todos deben tener esta estructura.
*/
class CtrlPacienteInicial extends Controller implements iController {

  private $scripts;
  private $styles;
  private $objPaciente = null;
  private $objPagination = null;
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
      $this->objPaciente = $this->loadModel('Pacientes', 'mdlPacienteInicial');
      $this->objPagination = $this->loadModel('Otros', 'mdlPagination');

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

      "Todos/Paginador.js",
      //"Pacientes/ArchivoPaciente.js",
      "Pacientes/Paginador.js"

    );

    $this->styles = array(
      "Pacientes/Campanita.css",
      "Pacientes/Estilo.css",
      "Pacientes/estilos.css",
      "Pacientes/cssPaciente.css",
      "Pacientes/Paginador.css"
    );

    require APP . 'View/_layout/header.php';
    require APP . 'View/Pacientes/ViewPacienteInicial.php';
    require APP . 'View/_layout/footer.php';
  }



  public function ConsultarPaciente(){
    // error_reporting(0);
    $configPaginador = $_POST;
    $configPaginador['tableName'] = 'viewdatosbasicospacientes';
    $configPaginador['fields'] = '*';

    if (!empty($configPaginador['filterDateTimeStart']) && !empty($configPaginador['filterDateTimeEnd'])) {
      $configPaginador['nameColumnDateTime'] = 'fechaAfiliacionRegistro';
    }

    if (!empty($configPaginador['filter'])) {
      // Opciones select buscar por:
      switch ((int) $configPaginador['nameColumnFilter']) {
        case 0:
        $configPaginador['nameColumnFilter'] = 'NombreCompleto';
        break;

        case 1:
        $configPaginador['nameColumnFilter'] = 'numeroDocumento';
        break;

        case 2:
        $configPaginador['nameColumnFilter'] = 'ciudadResidencia';
        break;

        case 3:
        $configPaginador['nameColumnFilter'] = 'fechaNacimiento';
        break;

        default:
        $configPaginador['nameColumnFilter'] = '';
        $configPaginador['filter'] = '';
        break;
      }

      $new_arr = array_map('trim', explode(",", $configPaginador['filter']));
      $new_arr = array_filter($new_arr, "strlen");
      $stringArray = '';
      $i = 0;
      foreach ($new_arr as $value) {
        $coma = ($i !== (count($new_arr) - 1) ) ? ',':'';
        $stringArray .= $value . $coma;
        $i++;
      }
      $configPaginador['filter'] = $stringArray;

    }else {
      $configPaginador['nameColumnFilter'] = '';
      $configPaginador['filter'] = '';
    }

    if (!empty($configPaginador['orderBy'])) {
      // Opciones select ordenar por:
      switch ((int) $configPaginador['nameColumnOrderBy']) {
        case 0:
        $configPaginador['nameColumnOrderBy'] = 'NombreCompleto';
        break;

        case 1:
        $configPaginador['nameColumnOrderBy'] = 'fechaAfiliacionRegistro';
        break;

        case 2:
        $configPaginador['nameColumnOrderBy'] = 'idPaciente';
        break;

        case 3:
        $configPaginador['nameColumnOrderBy'] = 'ciudadResidencia';
        break;

        default:
        $configPaginador['nameColumnOrderBy'] = '';
        $configPaginador['orderBy'] = '';
        break;
      }
    }else {
      $configPaginador['nameColumnOrderBy'] = '';
      $configPaginador['orderBy'] = '';
    }
    $resPaginador = $this->objPagination->Paginate($configPaginador);

    echo json_encode($resPaginador);
  }

  public function CambiarEstado()
{

  $idPaciente = $_POST['id'];
  $idEstadoPaciente = intval($_POST['idEstado']);
  $idEstadoPaciente = $idEstadoPaciente === 1 ? 2 : 1;
  $this->objPaciente->__SET("_idPaciente",$idPaciente);
  $this->objPaciente->__SET("_idEstadoPaciente",$idEstadoPaciente);
  $bool = $this->objPaciente->CambiarEstadoPaciente();

  if ($bool) {
    echo $idEstadoPaciente;
  } else {
    echo 0;
  }

}

} //Fin Clase
?>

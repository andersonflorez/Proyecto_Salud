<?php
/**
* NOMBRE DE LA CLASE: ctrlMaestras
* TIPO DE CLASE: Controlador
* DESCRIPCIÓN:
* Controlador de todas las tablas maestras
* Consulta los datos la tabla solicitada y
* permite generar dinámicamnte el menú de
* maestras
*/
class ctrlMaestras extends Controller implements iController {

  // Scripts y estilos:
  private $styles;
  private $scripts;
  private $objMaestras;
  private $menu;
  private $vistasMenu;

  // El siguiente constructor permite validar si el usuario tiene permiso de acceder a la vista:
  public function __construct() {

    Sesion::init();

    if (!Sesion::exist()) {

      header("Location: " . URL . "Home/ctrlLogin");
      exit();

    } else if (Sesion::getValue('TIPO_USUARIO') === 'ADMINISTRADOR') {

      require APP . "Model/Maestras/SSP.php";
      $this->objMaestras = $this->loadModel("Maestras", "mdlMaestras");
      $this->menu = $this->objMaestras->getMenuMaestras();

    } else {

      header("Location: " . URL . "Error/Error");
      exit();

    }
  }

  /**
  * Método Index()
  * Renderiza la página principal de configuración de tablas maestras:
  */
  public function Index() {

    $this->vistasMenu = json_decode(Sesion::getValue('VISTAS_MENU'));

    // Estilos:
    $this->styles = array(
      'Todos/sweetalert.css',
      'Maestras/jquery.dataTables.css'
    );

    // Javascripts:
    $this->scripts = array(
      'Todos/sweetalert.js',
      'Todos/Maestras/Funciones.js',
      'Todos/Maestras/ComportamientoMenu.js',
      'Todos/Maestras/datatables.js',
      'Todos/Maestras/datatableconfig.js'
    );

    // Renderizar vista:
    require APP . 'View/_layout/header.php'; // Carga la barra de navegación y los CSS
    require APP . 'View/Maestras/ViewMaestras.php'; // Carga nuestra vista
    require APP . 'View/_layout/footer.php'; // Carga los Javascripts

  }

  // La siguiente función permite consultar cualquier tabla maestra de la base de datos y manipularla con datatable:
  public function ConsultarTabla($idTabla) {

    // Validar que la solicitud sea mediante ajax:
    if (!empty($_GET['columns'])) {

      $Tabla = $this->objMaestras->BuscarTabla($idTabla);
      $table = $Tabla['NombreTablaBD'];
      $columnas = $Tabla['ColumnasBD'];
      $primaryKey = $Tabla['PrimaryKey'];

      // Capturar columnas de la tabla (base de datos):
      $columns = array();

      for($i = 0; $i < count($columnas); $i++){
        array_push($columns, array('db' => $columnas[$i], 'dt' => $i));
      }

      // Campos en común de todas las tablas:
      array_push($columns,array('db' => 'estadoTabla', 'dt' => count($columnas)),array('btn' => 'modificar', 'dt' =>count($columnas)+1),array('btn' => 'eliminar', 'dt' => count($columnas) + 2));

      // Retornar consulta completa de la tabla:
      echo json_encode(SSP::simple($_GET, $table, $primaryKey, $columns));

    } else {
      header("Location: " . URL . "Error/Error");
    }

    exit();

  }

}

?>

<?php

/**
* NOMBRE DE LA CLASE: CtrlEjemplos
* TIPO DE CLASE: Controlador
* DESCRIPCIÓN:
* Esta clase se encarga de renderizar la vista de los ejemplos del estandar,
* simplemente es un apoyo que les permitirá ver como utilizar lo nuevo
* que se vaya implementando en el proyecto.
*/
class CtrlEjemplos extends Controller implements iController {
  private $styles;
  private $scripts;
  private $objPagination = null;
  private $vistasMenu;



  function __construct() {
    Sesion::init();
    $this->objPagination = $this->loadModel('Otros', 'mdlPagination');
  }


  /**
  * Método Index() obligatorio
  * Renderiza la página principal de este controlador ('View/EJEMPLOS/index.php')
  */
  public function Index() {
    // RENDERIZA EL MENÚ DE NAVEGACIÓN
    $this->vistasMenu = json_decode(Sesion::getValue('VISTAS_MENU'));

    $this->styles = array(
      "Todos/select2.css",
      "Todos/ejemplo.css"
    );

    $this->scripts = array(
      "Validaciones/Standard_Validations.js",
      "Lib/select2.js",
      "Todos/modal.js",
      'Todos/Paginador.js',
      "Ejemplo/ejemplo.js"
    );

    require APP . 'View/_layout/header.php'; // Carga la barra de navegación y los CSS
    require APP . 'View/EJEMPLOS/index.php'; // Carga nuestra vista
    require APP . 'View/_layout/footer.php'; // Carga los Javascripts
  }


  // Función de prueba de petición ajax al servidor luego de diligenciar un formulario:
  public function PruebaAjax() {
    echo "Esta es la respuesta del servidor a la petición ajax";
  }

  /**
  * Prueba paginador
  */
  public function PruebaPaginador() {
    error_reporting(0);
    $configPaginador = $_POST;
    $res = $this->objPagination->Paginate($configPaginador);
    echo json_encode($res);
  }

}

?>

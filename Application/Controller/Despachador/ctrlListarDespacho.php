<?php

/**
* NOMBRE DE LA CLASE: CtrlListarDespacho
* TIPO DE CLASE: Controlador
* DESCRIPCIÓN:
* Se encarga de gestionar la información de las ambulancias.
*/
class CtrlListarDespacho extends Controller implements iController {

  private $objListarDespacho;

  // NOTA: Revisar el archivo 'COMO LINKEAR CSS - IMG - JS.txt' para entender
  // las dos siguientes lineas de código:
  private $styles;
  private $scripts;
  private $vistasMenu;
  /**
  * Método constructor()
  * Inicializa el uso de variables de sesión y
  * valida si hay una sesión abierta, sino la hay
  * redirecciona hacia el login de la aplicación:
  */
  public function __construct() {

    Sesion::init();

     if (!Sesion::exist()) {

       header("Location: " . URL);
       exit();

     } else if (Sesion::getValue('TIPO_USUARIO') === 'PARAMEDICO' || Sesion::getValue('TIPO_USUARIO') === 'ADMINISTRADOR' || Sesion::getValue('TIPO_USUARIO') === 'MEDICO' || Sesion::getValue('TIPO_USUARIO') === 'DESPACHADOR') {

       $this->objListarDespacho = $this->loadModel('Despachador', 'mdlListarDespacho');


     } else {

       header('Location: ' . URL . 'Error/Error');
       exit();

     }

  }

  /**
  * Método Index() obligatorio
  * Renedriza la página principal de este controlador (ej: 'View/Home/index.php')
  */
  public function Index() {
    $this->vistasMenu = json_decode(Sesion::getValue('VISTAS_MENU'));
    // NOTA: Revisar el archivo 'COMO LINKEAR CSS - IMG - JS.txt' para entender
    // las dos siguientes lineas de código:
    $this->styles = array(
      "Maestras/jquery.dataTables.css",
      "Todos/validacion.css",
      "Despachador/estiloListarDespacho.css"
    );
    $this->scripts = array(
      "Despachador/datatables.js",
      "Despachador/listarDespacho.js",
      "Todos/modal.js",
      "Lib/jquery.validate.js"
  );

    require APP . 'View/_layout/header.php'; // Carga la barra de navegación y los CSS
    require APP . 'View/Despachador/viewListarDespacho.php'; // Carga nuestra vista
    require APP . 'View/_layout/footer.php'; // Carga los Javascripts
  }

  //Funcion para listar el despacho.
  public function listarDespacho(){
  $datos = $this->objListarDespacho->listarDespacho();
  echo json_encode($datos);
  }

}

?>

<?php

class ctrlHistorialprogramacion extends Controller implements iController {
 private $styles;
 private $scripts;
 private $vistasMenu;






 public function Index() {
   $this->vistasMenu = json_decode(Sesion::getValue('VISTAS_MENU'));
   $Personal = $this->mdlHistorialprogramacion->consul();
   $this->styles = array(
    "Maestras/jquery.dataTables.css",
    /*"Css/Programacion/modal.css",*/
    "Todos/select2.css",
    "Todos/ejemplo.css",
      "Todos/sweetalert.css"

    /*"Css/Programacion/diseño.css"*/

    );
   $this->scripts = array(
    "Programacion/h.js",
    "Todos/script.js",
    "Programacion/datatables.js",
    "Todos/Maestras/ComportamientoMenu.js",
    "datatableconfig.js",
    "Validaciones/Standard_Validations.js",
    "Ejemplo/ejemplo.js",
    "Lib/select2.js",
    "Todos/modal.js",
    "Todos/sweetalert.js"
    );
   require APP . 'View/_layout/header.php';
   require APP . 'View/Programacion/ViewHistorialprogramacion.php';
   require APP . 'View/_layout/footer.php';
 }

  // public function __construct() {
  //   Sesion::init();
  //       if (!Sesion::exist()) {
  //           header("Location: ".URL);
  //       }
  //   $this->mdlHistorialprogramacion = $this->loadModel('Programacion', 'mdlHistorialprogramacion');
  // }

 public function __construct() {
  Sesion::init();
  if (!Sesion::exist()) {
    header("Location: ".URL);
    exit();
  }else if (Sesion::getValue('TIPO_USUARIO') === 'MEDICO') {
               // Es recomendable cargar los modelos en este apartado:
   $this->mdlHistorialprogramacion = $this->loadModel('Programacion','mdlHistorialprogramacion');
 }
 else {
  header("Location: " . URL . 'Error/Error');
  exit();
}

}




function consultaragenda (){
  $queryagenda = $this->mdlHistorialprogramacion->consultaragenda();
  echo json_encode($queryagenda);
}

function consul(){
  $COL = $this->mdlHistorialprogramacion->consul();
  if ($COL != null) {
    echo json_encode($COL);
  } else {
    echo json_encode("0");

  }

}


}


?>

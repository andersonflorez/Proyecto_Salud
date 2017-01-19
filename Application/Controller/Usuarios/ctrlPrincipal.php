<?php

class ctrlPermisos extends Controller implements iController {

  private $objPermisos = null;

  public function __construct() {

    Sesion::init();

    if (!Sesion::exist()) {

      header("Location: " . URL);
      exit();

    } else if (Sesion::getValue('TIPO_USUARIO') === 'ADMINISTRADOR') {

      $this->objPermisos = $this->loadModel('Usuarios', 'mdlPermisos');
    } else {

      header("Location: " . URL . 'Error/Error');
      exit();
    }
  }


  /**
  * METODO: Index
  * Este metodo se ejecuta cuando solicito la URL :
  * http://nombreDeTuProyecto/Cuentas/registros
  * NOTA: Esta es la página por defecto cuando no se encuentra la URL.
  */
  private $styles;
  private $scripts;

  public function Index() {

    $this->vistasMenu = json_decode(Sesion::getValue('VISTAS_MENU'));

    $this->styles = array(
      'Usuarios/estiloAcordeon.css',
      'Usuarios/estiloCheckbox.css'
    );

    $this->scripts = array(
      'Usuarios/permisos.js'
    );

    require APP . 'View/_layout/header.php';
    require APP . 'View/Usuarios/viewPermisos.php';
    require APP . 'View/_layout/footer.php';
    echo "<script>var array = ".$_SESSION['VISTAS_MENU']."</script>";
  }


  public function ListarComboRol(){

    $respuestaR = $this->objPermisos->listarComboRol();
    echo json_encode($respuestaR);

  }

  private function GenerarPermisos(){

    $consultaMenu = array();
    $this->objPermisos->__SET('_idRol', Sesion::getValue('ID_ROL'));
    $Modulos = $this->objPermisos->ConsultarModulos();

    foreach ($Modulos as $Modulo) {

      $idModulo = $Modulo->idModulo;
      $this->objPermisos->__SET('_idModulo', $idModulo);
      $Vistas = $this->objPermisos->ConsultarVistas();
      $arrayModulo = array('iconoModulo' =>$Modulo->iconoModulo,'Modulo' => $Modulo->descripcionModulo, 'Vistas' => array());

      foreach ($Vistas as $Vista) {
        array_push($arrayModulo['Vistas'], $Vista);
      }
      array_push($consultaMenu, $arrayModulo);
    }
    return json_encode($consultaMenu);
  }


  public function AsignarPermisos(){
   $array =  json_decode($_POST['dato']);
   foreach ($array as $key) {
     $this->objPermisos->__SET('_idRol',$key->rol);
     $this->objPermisos->__SET("_idModulo",$key->modulo);
     $this->objPermisos->__SET("_idVista",$key->idVista);
      try {
        $insert = $this->objPermisos->RegistrarPermisos();
      } catch (Exception $e) {
        $insert = "1";
      }
  }
   echo json_encode($insert);
  }

}

?>

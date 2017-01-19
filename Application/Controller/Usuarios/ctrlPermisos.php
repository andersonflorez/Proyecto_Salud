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
    echo "<script>var array = ".Sesion::getValue('VISTAS_MENU')."</script>";

  }

  public function ListarComboRoles(){

    $respuestaR = $this->objPermisos->listarComboRoles();
    echo json_encode($respuestaR);

  }

  public function AsignarPermisos(){
   $array =  json_decode($_POST['dato']);
   $var = "";
   foreach ($array as $key) {
     $this->objPermisos->__SET('_idRol',$key->rol);
     $this->objPermisos->__SET("_idModulo",$key->modulo);
     $this->objPermisos->__SET("_idVista",$key->idVista);

      try {
        $insert = $this->objPermisos->RegistrarPermisos();

        if ($insert == "0") {
          $var = "0";
        }else{
          $var = "1";
        }
      } catch (Exception $e) {
        $var = "2";
      }
  }
   echo json_encode($var);
  }

  public function consultaAsignacionPermiso(){
    $this->objPermisos->__SET('_descripcionRol',$_POST['rol']);
    $consulta = $this->objPermisos->consultaAsignacionPermiso();
    echo json_encode($consulta);
  }
}

?>

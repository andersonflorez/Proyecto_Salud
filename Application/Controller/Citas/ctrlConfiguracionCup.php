<?php

/**
* Class nombre_del_controlador:
* Escribe aqui la descripción de lo que hace este controlador
* Copia este formato de controlador para todos los controladores
* que necesites crear ya que todos deben tener esta estructura.
*/
class ctrlConfiguracionCup extends Controller implements iController {
  private $scripts;
  private $styles;
  private $MdlConfi=null;
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
        $this->MdlConfi=$this->loadModel('Citas','mdlConfiguracionCup');

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
      "Citas/JsConfiguracion.js",
      "Citas/scriptCitas.js",
      "Citas/es.js"
    );

    $this->styles = array(
      "Citas/Citasestilos.css",
      "Todos/sweetalert.css"

    );

    require APP . 'View/_layout/header.php';
    require APP . 'View/Citas/ViewConfiguracionCup.php';
    require APP . 'View/_layout/footer.php';
  }

  public function ListarComboTipoConfiguracion(){
    $respuesta = $this->MdlConfi->listarComboTipoConfiguracion();
    echo json_encode($respuesta);
  }

  function consultarDescripcionCup(){
    $this->MdlConfi->__SET("_filtros",$_POST["q"]);

    $query = $this->MdlConfi->consultarDescripcionProcedimiento();
    $cantidad = $this->MdlConfi->contarDescripcionProcedimiento();
    $datos = array(
      "items"=>$query,
      "total"=>$cantidad
    );
    echo json_encode($datos);
  }

  function consultarDescripcionIdCup(){
    $this->MdlConfi->__SET("_idCup",$_POST["id"]);

    $query = $this->MdlConfi->consultarDescripcionIdProcedimiento();
    echo $query->nombreCup;
  }

  function consultarCodigoCup(){
    $this->MdlConfi->__SET("_filtros",$_POST["q"]);
    $query = $this->MdlConfi->consultarCodigoProcedimiento();
    $cantidad = $this->MdlConfi->contarCodigoProcedimiento();
    $datos = array(
      "items"=>$query,
      "total"=>$cantidad
    );
    echo json_encode($datos);
  }

  function consultarCodigoIdCup(){
    $this->MdlConfi->__SET("_idCup",$_POST["id"]);
    $query = $this->MdlConfi->consultarCodigoIdProcedimiento();
    echo $query->codigoCup;
  }


  public function Registrarcup(){
    $nombreCUP = $_POST['txtNombreCup'];
    $idConfiguracion = $_POST['SlTipoConfi'];
    $idTipoCup = $_POST['SlTipoCup'];

    $this->MdlConfi->__SET("_CUP",$nombreCUP);
    $this->MdlConfi->__SET("_idConfig",$idConfiguracion);
    $this->MdlConfi->__SET("_idTipoCup",$idTipoCup);

    //Asigno al objeto del modelo la funcion insertarReporte y le paso el array.
    $regcup = $this->MdlConfi->InsertarDatosCup();
    if ($regcup==true) {
      echo json_encode(['Bien']);
    }else{
      echo json_encode(['Mal']);
    }
  }

public function ListarConfiguracion(){
  $respuesta = $this->MdlConfi->ListarConfiguracion();
  echo json_encode($respuesta);
}
public function ModificarConfiCup(){
   $idConfiguracion = $_POST['SltTipoConfi'];
   $idCUP = $_POST['cmbCodigoCUP'];

   $datosC = array($idConfiguracion ,$idCUP);
   $this->MdlConfi->__SET("_DatosConfig",$datosC);
   $actualizar = $this->MdlConfi->ModificarConfi();
       if ($actualizar==true) {
         echo json_encode(['Exito']);
       }else{
         echo json_encode(['Mal']);
       }
}

}




?>

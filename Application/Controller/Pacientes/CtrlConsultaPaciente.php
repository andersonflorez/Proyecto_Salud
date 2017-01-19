<?php
/**
* Class nombre_del_controlador:
* Escribe aqui la descripción de lo que hace este controlador
* Copia este formato de controlador para todos los controladores
* que necesites crear ya que todos deben tener esta estructura.
*/
class CtrlConsultaPaciente extends Controller implements iController {
  private $scripts;
  private $styles;
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
      $this->objPaciente = $this->loadModel(
      'Pacientes',
      'mdlConsultaPaciente'
    );

    } else {

      // En caso de que no cumpla ninguna de estas condiciones entonces sera redireccionado a la pagina de error:
      header("Location: " . URL . 'Error/Error');
      exit();

    }
  }

public function Index(){
  /**
  * Método Index() obligatorio
  * Carga la página principal de este controlador:
  */

  $this->vistasMenu = json_decode(Sesion::getValue('VISTAS_MENU'));
  $this->scripts = array(
    "Pacientes/ArchivoPaciente.js",
    "Todos/sweetalert.js"
  );

  $this->styles = array(
    "Pacientes/cssPaciente.css",
    "Pacientes/Estilo.css",
    "Todos/validacion.css",
    "Todos/sweetalert.css"
  );

  require APP . 'View/_layout/header.php';
  require APP . 'View/Pacientes/ViewConsultaPaciente.php';
  require APP . 'View/_layout/footer.php';
}

public function ActualizarDatosPaciente(){
  $idPaciente = $_POST['txtid'];
  $numeroDocumento = $_POST['txtDocumento'];
  $primerNombre  = $_POST['txtPrimerNombre'];
  $segundoNombre = $_POST['txtSegundoNombre'];
  $primerApellido = $_POST['txtPrimerApellido'];
  $segundoApellido = $_POST['txtSegundoApellido'];
  $estadoCivil = $_POST['SlcEstadoCivil'];
  $ciudadResidencia = $_POST['TxtCiudadR'];
  $barrioResidencia = $_POST['txtBarrioR'];
  $direccion = $_POST['txtDireccion'];
  $telefonoFijo = $_POST['txtTelefonoFijo'];
  $telefonoMovil = $_POST['txtTelefonoCelular'];
  $correoElectronico = $_POST['txtCorreo'];
  $empresa = $_POST['txtEmpresa'];
  $ocupacion = $_POST['txtOcupacion'];
  $profesion = $_POST['txtProfesion'];
  $idtipoDocumento = $_POST['SlcTipoDocumento'];
  $idtipoAfiliacion = $_POST['SlcTipoAfiliacion'];
  $foto = $_FILES["txtUrl"];
  if ($foto["size"] > 0) {
    //se extrae el nombre de la foto
    $nombreFoto = $foto["name"];
    //se guarda la ruta temporal
    $rutaTemporal = $foto["tmp_name"];
    //Se crea la ruta donde va a ir la foto en el servidor, en este caso la carpeta fotos
    //esta seria la variable que va en la base de datos
    $url = "/Public/Img/Pacientes/".$nombreFoto;
    //se copia y pega la foto de la ruta temporal al servidor
    move_uploaded_file($rutaTemporal, ".." .$url);
  }else{
    $url =$_POST['txtVieja'];
  }
  $Extension = $_POST['txtExt2'];
  if ($telefonoFijo!="") {
    $telefonoFijo=$telefonoFijo."-".$Extension;
  }
  $datosPaciente = array($idPaciente ,$numeroDocumento,
  $primerNombre, $segundoNombre, $primerApellido, $segundoApellido,  $estadoCivil,
  $ciudadResidencia, $barrioResidencia, $direccion, $telefonoFijo,
  $telefonoMovil, $correoElectronico, $empresa, $ocupacion, $profesion,
 $idtipoDocumento, $idtipoAfiliacion, $url);

  $this->objPaciente->__SET("_DatosPaciente",$datosPaciente);
  $actualizarPaciente = $this->objPaciente->actualizarDatosPaciente();
  if ($actualizarPaciente==true) {
    echo json_encode(['Exito']);
  }else{
    echo json_encode(['Mal']);
  }
}

public function ConsultarPaciente(){
  $idPaciente = $_POST['data'];
  $this->objPaciente->__SET("_idPaciente",$idPaciente);

  $respuestaC = $this->objPaciente->ConsultaDatos();
  if ($respuestaC == null) {
    echo "1";
  }else{
    echo json_encode($respuestaC);
  }
}

}

?>

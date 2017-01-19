<?php

/**
* Class nombre_del_controlador:
* Escribe aqui la descripción de lo que hace este controlador
* Copia este formato de controlador para todos los controladores
* que necesites crear ya que todos deben tener esta estructura.
*/
class CtrlRegistroPaciente extends Controller implements iController {

  private $scripts;
  private $styles;
  private $objPaciente = null;
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
      'mdlRegistroPaciente'
    );

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
    "Lib/jquery.validate.js",
    "Validaciones/Functions_Validation.js",
    "Todos/sweetalert.js",
    "Lib/messages_es.min.js",
    "Pacientes/RegistroPaciente.js"
  );

  $this->styles = array(
    "Pacientes/cssPaciente.css",
    "Todos/validacion.css",
    "Pacientes/Estilo.css",
    "Pacientes/cssPaciente.css",
    "Todos/sweetalert.css"

  );

  require APP . 'View/_layout/header.php'; // Carga la barra de navegación y los CSS
  require APP . 'View/Pacientes/ViewRegistroPaciente.php'; // Carga nuestra vista
  require APP . 'View/_layout/footer.php'; // Carga los Javascripts
}


public function RegistrarPaciente(){
  $numeroDocumento = $_POST['txtDocumento'];
  $fechaNacimiento = $_POST['txtFechanacimiento'];
  $tipoSangre = $_POST['SlcTipoSangre'];
  $primerNombre = $_POST['txtPrimerNombre'];
  $segundoNombre = $_POST['txtSegundoNombre'];
  $primerApellido = $_POST['txtPrimerApellido'];
  $segundoApellido = $_POST['txtSegundoApellido'];
  $genero = $_POST['SlcGenero'];
  $estadoCivil = $_POST['SlcEstadoCivil'];
  $ciudadResidencia = $_POST['TxtCiudadR'];
  $barrioResidencia = $_POST['txtBarrioR'];
  $direccion = $_POST['txtDireccion'];
  $telefonoFijo = $_POST['txtTelefonoFijo'];
  $telefonoMovil = $_POST['txtTelefonoCelular'];
  $correoElectronico = $_POST['txtCorreo'];
  $empresa = $_POST['txtEmpresa'];
  $ocupacion  = $_POST['txtOcupacion'];
  $profesion = $_POST['txtProfesion'];
  $FechaSistema =date("Y-m-d");
  $fechaAfiliacionRegistro =$FechaSistema;
  $idtipoDocumento  = $_POST['SlcTipoDocumento'];
  $idTipoAfiliacion = $_POST['SlcTipoAfiliacion'];
  $fechanac= time() - strtotime($fechaNacimiento);
  $edadPaciente =  floor((($fechanac / 3600) / 24) / 360);
  $foto = $_FILES["txtUrl"];
  $Extension = $_POST['txtExt'];
  $idEstadoPaciente = 1;
  //se extrae el nombre de la foto
  $nombreFoto = $foto["name"];
  //se guarda la ruta temporal
  $rutaTemporal = $foto["tmp_name"];
  //Se crea la ruta donde va a ir la foto en el servidor, en este caso la carpeta fotos
  //esta seria la variable que va en la base de datos
  //  var_dump($nombreFoto);
  if ($Extension!="") {
    $telefonoFijo=$telefonoFijo."-".$Extension;
  }
  if ($nombreFoto=='') {
    $url = "/Public/Img/Pacientes/unnamed.jpg";
  }else{
    $url = "/Public/Img/Pacientes/".$nombreFoto;
  }
  //se copia y pega la foto de la ruta temporal al servidor
  move_uploaded_file($rutaTemporal, ".." .$url);

  //Caturo los campos dentro de un array  para llevarlos al modelo.

  $miArray  = array(
    $numeroDocumento,
    $fechaNacimiento,
    $tipoSangre,
    $primerNombre,
    $segundoNombre,
    $primerApellido,
    $segundoApellido,
    $genero,
    $estadoCivil,
    $ciudadResidencia,
    $barrioResidencia,
    $direccion,
    $telefonoFijo,
    $telefonoMovil,
    $correoElectronico,
    $empresa,
    $ocupacion,
    $profesion,
    $fechaAfiliacionRegistro,
    $idtipoDocumento,
    $idTipoAfiliacion,
    $edadPaciente,
    $url,
    $idEstadoPaciente);
    //Asigno al objeto del modelo la funcion insertarReporte y le paso el array.
    $this->objPaciente->__SET("_DatosPaciente",$miArray);
    $regPaciente = $this->objPaciente->InsertarDatosPaciente();

    if ($regPaciente) {
      echo json_encode(['Bien']);
    }else{
      echo json_encode(['Mal']);
    }

  }
  public function ListarComboTipoDocumento(){

    $respuesta = $this->objPaciente->listarComboTipoDocumento();
    echo json_encode($respuesta);
  }

  public function ListarComboTipoAfiliacion(){


    $respuestaA = $this->objPaciente->listarComboTipoAfiliacion();
    echo json_encode($respuestaA);

  }

  public function ListarComboEstadoP(){

    $RespuestaB = $this->objPaciente->listarComboEstadoP();
    echo json_encode($RespuestaB);
  }

  Public function ValidarDocumento(){
    $numeroDocumento = $_POST['txtDocumento'];
    $respuestaD =$this->objPaciente->validarDocumento($numeroDocumento);
    if ( count($respuestaD) > 0 ) {
      echo json_encode(1);
    }else{
      echo json_encode(0);
    }
  }
  public function ConsultarPacienteD(){
    $Documento = $_POST['txtDocumento'];
    $respuestaC = $this->objPaciente->consultaPacienteD($Documento);
    if ($respuestaC == null) {
      echo "1";
    }else{
      echo json_encode($respuestaC);
    }
  }

  public function FechaServidor()
  {
    date_default_timezone_set("America/Bogota");
    $FechasServidor = date("Y-m-d");
    echo json_encode($FechasServidor);
  }


}


?>

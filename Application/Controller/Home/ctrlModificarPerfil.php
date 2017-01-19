<?php

class ctrlModificarPerfil extends Controller implements iController {

  private $scripts;
  private $styles;
  private $objModificarPerfil = null;
  private $objPerfil = null;
  private $vistasMenu;

  public function __construct() {

    // Primero se debe habilitar el uso de sesiones:
    Sesion::init();

    // Luego preguntar si el usuario esta logueado:
    if (!Sesion::exist()) {

      // Sino, sera enviado hacia el login:
      header("Location: " . URL);
      exit();

    } else if (Sesion::getValue('TIPO_USUARIO') === 'ADMINISTRADOR' || Sesion::getValue('TIPO_USUARIO') === 'PARAMEDICO'  || Sesion::getValue('TIPO_USUARIO') === 'MEDICO' || Sesion::getValue('TIPO_USUARIO') === 'AUXILIAR_DE_ENFERMERIA' || Sesion::getValue('TIPO_USUARIO') === 'CONTROL_MEDICO' || Sesion::getValue('TIPO_USUARIO') === 'ENFERMERA_JEFE' || Sesion::getValue('TIPO_USUARIO') === 'RECEPTOR_INICIAL' || Sesion::getValue('TIPO_USUARIO') === 'USUARIO' || Sesion::getValue('TIPO_USUARIO') === 'MEDICO_EXTERNO') {

    $this->objModificarPerfil = $this->loadModel('Home', 'mdlModificarPerfil');

    } else {

      // En caso de que no cumpla ninguna de estas condiciones entonces sera redireccionado a la pagina de error:
      header("Location: " . URL . 'Error/Error');
      exit();

    }

  }

  public function Index() {

    $idUsuario = intval(Sesion::getValue('ID_USUARIO'));
    $this->objModificarPerfil->__SET('idUsuario', $idUsuario);
    $usuario = $this->objModificarPerfil->ConsultarPerfil();

    $this->vistasMenu = json_decode(Sesion::getValue('VISTAS_MENU'));

    $this->styles = array(
      "Usuarios/estiloCheckbox.css",
    );

    $this->scripts = array(
      "Home/perfil.js",
    );

//    $queryConsultarPerfil = $this->objPerfil->ConsultarPerfil($idUsuario);
//    $tipoDocumento = $this->objPerfil->listarComboTipoDocumento();

    require APP . 'View/_layout/header.php';
    require APP . 'View/Home/viewModificarPerfil.php';
    require APP . 'View/_layout/footer.php';

//    echo '<script>
//    $("#slcTipoDocumento > option[value='."'".$queryConsultarPerfil->idTipoDocumento."'".']").attr("selected","selected");
//    $("#slcSexo > option[value='."'".$queryConsultarPerfil->sexo."'".']").attr("selected","selected");
//    </script>';
  }

      public function ActualizarPerfil() {

    $idPersona       = $_POST['txtIdPersona'];
    $primerNombre    = $_POST['txtPrimerNombre'];
    $segundoNombre   = $_POST['txtSegundoNombre'];
    $primerApellido  = $_POST['txtPrimerApellido'];
    $segundoApellido = $_POST['txtSegundoApellido'];
    $idTipoDocumento = $_POST['slcTipoDocumento'];
    $numeroDocumento = $_POST['txtNumeroDocumento'];
    $fechaNacimiento          = $_POST['txtFechaNacimiento'];
    $sexo                     = $_POST['slcSexo'];
    $direccion                = $_POST['txtDireccion'];
    $telefono                 = $_POST['txtTelefono'];
    $correoElectronico        = $_POST['txtCorreo'];
    $ciudad                   = $_POST['txtCiudad'];
    $departamento             = $_POST['txtDepartamento'];
    $pais                     = $_POST['txtPais'];

    $foto = $_FILES["txtFoto"];

    if ($foto["size"] > 0) {

      //se extrae el nombre de la foto
      $nombreFoto   = $foto["name"];
      //se guarda la ruta temporal
      $rutaTemporal = $foto["tmp_name"];
      //Se crea la ruta donde va a ir la foto en el servidor, en este caso la carpeta fotos
      //esta seria la variable que va en la base de datos
      $urlFoto      = "/Public/Img/Usuarios/FotosPersona/" . $nombreFoto;
      //se copia y pega la foto de la ruta temporal al servidor
      move_uploaded_file($rutaTemporal, ".." . $urlFoto);

    } else {
      $urlFoto = $_POST['txtViejaFoto'];
    }

    $ActPerfil = $this->objModificarPerfil->ActualizarPerfil($idPersona, $primerNombre, $segundoNombre, $primerApellido, $segundoApellido, $idTipoDocumento, $numeroDocumento, $fechaNacimiento, $sexo, $direccion, $telefono, $correoElectronico, $ciudad, $departamento, $pais, $urlFoto);

    if (isset($ActPerfil) && $ActPerfil == true) {
      echo 1;
    } else {
      echo 0;
    }

  }

  public function ListarComboTipoDocumento() {

    $respuestaTD = $this->objModificarPerfil->listarComboTipoDocumento();
    echo json_encode($respuestaTD);

  }

     public function ConsultarPersonaD() {

    $numeroDocumento = $_POST['txtNumeroDocumento'];
    $respuestaC      = $this->objModificarPerfil->consultaPersonaD($numeroDocumento);

    if ($respuestaC == null) {
      echo "1";
    } else {
      echo json_encode($respuestaC);
    }

  }

  public function ValidarDocumento()  {

    $numeroDocumento = $_POST['txtNumeroDocumento'];
    $respuestaD      = $this->objModificarPerfil->validarDocumento($numeroDocumento);

    if (count($respuestaD) > 0) {
      echo json_encode(1);
    } else {
      echo json_encode(0);
    }

  }

  public function ConsultarPersonaCorreo()  {

    $correoElectronico = $_POST['txtCorreo'];
    $respuestaE      = $this->objModificarPerfil->consultaPersonaCorreo($correoElectronico);

    if ($respuestaE == null) {
      echo "1";
    } else {
      echo json_encode($respuestaE);
    }

  }

  public function ValidarCorreo()  {

    $correoElectronico = $_POST['txtCorreo'];
    $respuestaF      = $this->objModificarPerfil->validarCorreo($correoElectronico);

    if (count($respuestaF) > 0) {
      echo json_encode(1);
    } else {
      echo json_encode(0);
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

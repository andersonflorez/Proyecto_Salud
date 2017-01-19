<?php

class ctrlModificarPersona extends Controller
{

  private $scripts;
  private $styles;
  private $objModificarPersona = null;
  private $objConsultarPersona = null;
  private $vistasMenu;


  public function __construct() {

    Sesion::init();

    if (!Sesion::exist()) {

      header("Location: " . URL);
      exit();

    } else if (Sesion::getValue('TIPO_USUARIO') === 'ADMINISTRADOR') {

      $this->objModificarPersona = $this->loadModel('Usuarios', 'mdlModificarPersona');
      $this->objConsultarPersona = $this->loadModel('Usuarios', 'mdlConsultarPersona');

    } else {

      header("Location: " . URL . 'Error/Error');
      exit();

    }

  }

  public function Index($idPersona) {

    $this->vistasMenu = json_decode(Sesion::getValue('VISTAS_MENU'));

    $this->scripts = array(
      "Usuarios/consultarPersona.js"
    );

    $this->styles = array(
      "Usuarios/estiloCheckbox.css"
    );

    $queryConsultarPersona = $this->objConsultarPersona->ConsultaDatos(base64_decode($idPersona));
    $queryConsultarRol = $this->objConsultarPersona->ConsultaDatoRol(base64_decode($idPersona));
    $tipoDocumento = $this->objConsultarPersona->listarComboTipoDocumento();
    $rol = $this->objConsultarPersona->listarComboRoles();

    require APP . 'View/_layout/header.php';
    require APP . 'View/Usuarios/viewModificarPersona.php';
    require APP . 'View/_layout/footer.php';

    echo '<script> var idPersona="'.base64_encode($idPersona).'";</script>';
    echo '<script>
    $("#slcTipoDocumento > option[value='."'".$queryConsultarPersona->idTipoDocumento."'".']").attr("selected","selected");
    $("#slcSexo> option[value='."'".$queryConsultarPersona->sexo."'".']").attr("selected","selected");
    $("#slcGrupoSanguineo > option[value='."'".$queryConsultarPersona->grupoSanguineo."'".']").attr("selected","selected");
    $("#slcDependencia > option[value='."'".$queryConsultarPersona->dependencia."'".']").attr("selected","selected");
    $("#slcRol> option[value='."'".$queryConsultarRol->idRol."'".']").attr("selected","selected");
    </script>';
  }

  public function ActualizarPersona() {

    $idPersona       = $_POST['txtIdPersona'];
    $primerNombre    = $_POST['txtPrimerNombre'];
    $segundoNombre   = $_POST['txtSegundoNombre'];
    $primerApellido  = $_POST['txtPrimerApellido'];
    $segundoApellido = $_POST['txtSegundoApellido'];
    $idTipoDocumento = $_POST['slcTipoDocumento'];
    $numeroDocumento = $_POST['txtNumeroDocumento'];
    $lugarExpedicionDocumento = $_POST['txtLugarExpedicionDocumento'];
    $fechaNacimiento          = $_POST['txtFechaNacimiento'];
    $lugarNacimiento          = $_POST['txtLugarNacimiento'];
    $sexo                     = $_POST['slcSexo'];
    $direccion                = $_POST['txtDireccion'];
    $telefono                 = $_POST['txtTelefono'];
    $correoElectronico        = $_POST['txtCorreo'];
    $grupoSanguineo           = $_POST['slcGrupoSanguineo'];
    $ciudad                   = $_POST['txtCiudad'];
    $departamento             = $_POST['txtDepartamento'];
    $pais                     = "Colombia";
    $urlFirma                 = $_POST['txtFirma'];
    $idRol = "";
    $rol = "";

    $HojaDeVida = $_FILES["txtHojaVida"];

    if ($HojaDeVida["size"] > 0) {

      $nombreHojaDeVida = $HojaDeVida["name"];
      $rutaTemporal     = $HojaDeVida["tmp_name"];
      $urlHojaDeVida    = "/Public/HojasDeVidaPersona/" . $nombreHojaDeVida;
      move_uploaded_file($rutaTemporal, ".." . $urlHojaDeVida);

    } else {

      $urlHojaDeVida = $_POST['txtViejaHojaDeVida'];

    }

if (isset($_FILES['txtFirma'])) {

      $Firma = $_FILES["txtFirma"];

    if ($Firma["size"] > 0) {

      $nombreFirma = $Firma["name"];
      $rutaTemporal     = $Firma["tmp_name"];
      $urlFirma    = "/Public/Img/Usuarios/FirmasMedico/" . $nombreFirma;
      move_uploaded_file($rutaTemporal, ".." . $urlFirma);

    } else {

      $urlFirma = $_POST['txtViejaFirma'];

    }


    }

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


    $slcRol = $_POST['slcRol'];
    if ($slcRol != $rol) {
      $idRol = $slcRol;
    } else {
      $idRol = $rol;
    }

    $dependencia = $_POST['slcDependencia'];
    $ActPersona = $this->objModificarPersona->ActualizarPersona($idPersona, $primerNombre, $segundoNombre, $primerApellido, $segundoApellido, $idTipoDocumento, $numeroDocumento, $lugarExpedicionDocumento, $fechaNacimiento, $lugarNacimiento, $sexo, $direccion, $telefono, $correoElectronico, $grupoSanguineo, $ciudad, $departamento, $pais, $urlHojaDeVida, $urlFirma, $urlFoto, $dependencia,$idRol);

    if ($ActPersona) {
      echo 1;
    } else {
      echo 0;
    }

  }

  public function ListarComboTipoDocumento() {

    $respuestaTD = $this->objModificarPersona->listarComboTipoDocumento();
    echo json_encode($respuestaTD);

  }

  public function ListarComboRoles() {

    $respuestaR = $this->objModificarPersona->listarComboRoles();
    echo json_encode($respuestaR);

  }

  public function ConsultarPersonaD() {

    $numeroDocumento = $_POST['txtNumeroDocumento'];
    $respuestaC      = $this->objModificarPersona->consultaPersonaD($numeroDocumento);

    if ($respuestaC == null) {
      echo "1";
    } else {
      echo json_encode($respuestaC);
    }

  }

  public function ValidarDocumento()  {

    $numeroDocumento = $_POST['txtNumeroDocumento'];
    $respuestaD      = $this->objModificarPersona->validarDocumento($numeroDocumento);

    if (count($respuestaD) > 0) {
      echo json_encode(1);
    } else {
      echo json_encode(0);
    }

  }

  public function ConsultarPersonaCorreo()  {

    $correoElectronico = $_POST['txtCorreo'];
    $respuestaE      = $this->objModificarPersona->consultaPersonaCorreo($correoElectronico);

    if ($respuestaE == null) {
      echo "1";
    } else {
      echo json_encode($respuestaE);
    }

  }

  public function ValidarCorreo()  {

    $correoElectronico = $_POST['txtCorreo'];
    $respuestaF      = $this->objModificarPersona->validarCorreo($correoElectronico);

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

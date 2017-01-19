<?php

class ctrlRegistrarPersonaExterna extends Controller implements iController {

  private $scripts;
  private $objRegistrarPersonaExterna = null;

  function __construct() {

    $this->objRegistrarPersonaExterna = $this->loadModel('Usuarios', 'mdlRegistrarPersonaExterna');

  }

  public function Index() {

    $this->scripts = array(
      "Usuarios/funcionesPersona.js"
    );

    require APP . 'View/Usuarios/viewRegistrarPersonaExterna.php';
    require APP . 'View/_layout/footer.php';
  }

  public function RegistrarPersonaExterna() {

    $urlFoto = '';
    $Foto            = $_FILES["txtFoto"];

    if(!empty($Foto["name"])) {
      $nombreFoto      = $Foto["name"];
      $rutaTemporalFoto = $Foto["tmp_name"];
      $urlFoto         = "Public/Img/Usuarios/FotosPersona/" . $nombreFoto;
      move_uploaded_file($rutaTemporalFoto, "../" . $urlFoto);
    } else {
      $urlFoto         = "Public/Img/Usuarios/FotosPersona/default.png";
    }

    $segundoNombre = isset($_POST['txtSegundoNombre']) ? $_POST['txtSegundoNombre'] : '';
    $this->objRegistrarPersonaExterna->__SET('primerNombre', $_POST['txtPrimerNombre']);
    $this->objRegistrarPersonaExterna->__SET('segundoNombre', $segundoNombre);
    $this->objRegistrarPersonaExterna->__SET('primerApellido', $_POST['txtPrimerApellido']);
    $this->objRegistrarPersonaExterna->__SET('segundoApellido', $_POST['txtSegundoApellido']);
    $this->objRegistrarPersonaExterna->__SET('idTipoDocumento', $_POST['slcTipoDocumento']);
    $this->objRegistrarPersonaExterna->__SET('numeroDocumento', $_POST['txtNumeroDocumento']);
    $this->objRegistrarPersonaExterna->__SET('lugarExpedicionDocumento', "");
    $this->objRegistrarPersonaExterna->__SET('fechaNacimiento', $_POST['txtFechaNacimiento']);
    $this->objRegistrarPersonaExterna->__SET('lugarNacimiento', "");
    $this->objRegistrarPersonaExterna->__SET('sexo', $_POST['slcSexo']);
    $this->objRegistrarPersonaExterna->__SET('direccion', $_POST['txtDireccion']);
    $this->objRegistrarPersonaExterna->__SET('telefono', $_POST['txtTelefono']);
    $this->objRegistrarPersonaExterna->__SET('correoElectronico', $_POST['txtCorreo']);
    $this->objRegistrarPersonaExterna->__SET('grupoSanguineo', "");
    $this->objRegistrarPersonaExterna->__SET('ciudad', $_POST['txtCiudad']);
    $this->objRegistrarPersonaExterna->__SET('departamento', $_POST['txtDepartamento']);
    $this->objRegistrarPersonaExterna->__SET('pais', "Colombia");
    $this->objRegistrarPersonaExterna->__SET('estadoTablaPersona', "Activo");
    $this->objRegistrarPersonaExterna->__SET('dependencia', "");
    $this->objRegistrarPersonaExterna->__SET('urlFoto', $urlFoto);
    $this->objRegistrarPersonaExterna->__SET('urlHojaDeVida', "");
    $this->objRegistrarPersonaExterna->__SET('urlFirma', "");

    $rol = $this->objRegistrarPersonaExterna->consultarUsuario();

    $usuario   = $_POST['txtUsuario'];
    $clave     = $_POST['txtClave1'];
    $confClave = $_POST['txtClave2'];
    $idRol = $rol[0]->Rol;

    if ($clave == $confClave) {
      $password = Encrypter::encrypt($clave);
      $regPersonaExterna = $this->objRegistrarPersonaExterna->InsertarDatosPersonaExterna();

    if ($regPersonaExterna == true) {
      $ultima = $this->objRegistrarPersonaExterna->idUltimaPersona();

      $idPersona = $ultima[0]->ultima;

      if (isset($idPersona) && isset($idRol) ) {

        $this->objRegistrarPersonaExterna->__SET('idPersona', $idPersona);
        $this->objRegistrarPersonaExterna->__SET('usuario', $usuario);
        $this->objRegistrarPersonaExterna->__SET('clave', $password);
        $this->objRegistrarPersonaExterna->__SET('idRol', $idRol);

        $registrarCuentaU = $this->objRegistrarPersonaExterna->InsertarDatosUsuario();

        if ($registrarCuentaU) {
          echo 1;
        } else {
          echo 0;
        }

      } else {
        echo 0;
      }
    } else {
      echo 0;
    }
  }
  }

  public function FechaServidorE()
  {
   date_default_timezone_set("America/Bogota");
   $FechasServidor = date("Y-m-d");
   echo json_encode($FechasServidor);
  }


  public function ListarComboTipoDocumento(){

    $respuestaTD = $this->objRegistrarPersonaExterna->listarComboTipoDocumento();
    echo json_encode($respuestaTD);
  }

  public function ConsultarPersonaD(){
    $numeroDocumento = $_POST['txtNumeroDocumento'];
    $respuestaC = $this->objRegistrarPersonaExterna->consultaPersonaD($numeroDocumento);
    if ($respuestaC == null) {
      echo "1";
    }else{
      echo json_encode($respuestaC);
    }
  }

  public function ValidarDocumento(){
    $numeroDocumento = $_POST['txtNumeroDocumento'];
    $respuestaD =$this->objRegistrarPersonaExterna->validarDocumento($numeroDocumento);
    if ( count($respuestaD) > 0 ) {
      echo json_encode(1);
    }else{
      echo json_encode(0);
    }
  }

  public function ConsultarPersonaUsuario(){
    $usuario = $_POST['txtUsuario'];
    $respuestaC = $this->objRegistrarPersonaExterna->consultaPersonaUsuario($usuario);
    if ($respuestaC == null) {
      echo "1";
    }else{
      echo json_encode($respuestaC);
    }
  }

  public function ValidarUsuario(){
    $usuario = $_POST['txtUsuario'];
    $respuestaD =$this->objRegistrarPersonaExterna->validarUsuario($usuario);
    if ( count($respuestaD) > 0 ) {
      echo json_encode(1);
    }else{
      echo json_encode(0);
    }
  }

  public function ConsultarPersonaCorreo()  {
    $correoElectronico = $_POST['txtCorreo'];
    $respuestaE      = $this->objRegistrarPersonaExterna->consultaPersonaCorreo($correoElectronico);
    if ($respuestaE == null) {
      echo "1";
    } else {
      echo json_encode($respuestaE);
    }
  }

  public function ValidarCorreo()  {
    $correoElectronico = $_POST['txtCorreo'];
    $respuestaF      = $this->objRegistrarPersonaExterna->validarCorreo($correoElectronico);
    if (count($respuestaF) > 0) {
      echo json_encode(1);
    } else {
      echo json_encode(0);
    }
  }

}

?>

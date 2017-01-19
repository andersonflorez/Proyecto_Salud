<?php

class ctrlRegistrarPersona extends Controller implements iController {

  private $scripts;
  private $styles;
  private $objRegistrarPersona = null;
  private $vistasMenu;

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
    } else if (Sesion::getValue('TIPO_USUARIO') === 'ADMINISTRADOR') {

      // Es recomendable cargar los modelos en este apartado:
      $this->objRegistrarPersona = $this->loadModel('Usuarios', 'mdlRegistrarPersona');

    } else {

      // En caso de que no cumpla ninguna de estas condiciones entonces sera redireccionado a la pagina de error:
      header("Location: " . URL . 'Error/Error');
      exit();

    }

  }

  public function Index() {

    $this->vistasMenu = json_decode(Sesion::getValue('VISTAS_MENU'));

    $this->scripts = array(
      "Usuarios/funcionesPersona.js"
    );

    $this->styles = array(
      "Usuarios/estiloCheckbox.css"
    );

    require APP . 'View/_layout/header.php';
    require APP . 'View/Usuarios/viewRegistrarPersona.php';
    require APP . 'View/_layout/footer.php';

  }


  //  CRUD: Personas

  public function RegistrarPersona() {

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

    $HojaDeVida            = $_FILES["txtHojaVida"];
    $nombreHojaVida        = $HojaDeVida["name"];
    $rutaTemporalHojadeVida = $HojaDeVida["tmp_name"];
    $urlHojaDeVida        = "Public/HojasDeVidaPersona/" . $nombreHojaVida;
    move_uploaded_file($rutaTemporalHojadeVida, "../" . $urlHojaDeVida);

    if (isset($_FILES['txtFirma'])) {

      $Firma             = $_FILES["txtFirma"];
      $nombreFirma       = $Firma["name"];
      $rutaTemporalFirma = $Firma["tmp_name"];
      $urlFirma          = "Public/Img/Usuarios/FirmasMedico/" . $nombreFirma;
      move_uploaded_file($rutaTemporalFirma, "../" . $urlFirma);
      $this->objRegistrarPersona->__SET('urlFirma', $urlFirma);

    }

    $segundoNombre = isset($_POST['txtSegundoNombre']) ? $_POST['txtSegundoNombre'] : '';
    $this->objRegistrarPersona->__SET('primerNombre', $_POST['txtPrimerNombre']);
    $this->objRegistrarPersona->__SET('segundoNombre', $segundoNombre);
    $this->objRegistrarPersona->__SET('primerApellido', $_POST['txtPrimerApellido']);
    $this->objRegistrarPersona->__SET('segundoApellido', $_POST['txtSegundoApellido']);
    $this->objRegistrarPersona->__SET('idTipoDocumento', $_POST['slcTipoDocumento']);
    $this->objRegistrarPersona->__SET('numeroDocumento', $_POST['txtNumeroDocumento']);
    $this->objRegistrarPersona->__SET('lugarExpedicionDocumento', $_POST['txtLugarExpedicionDocumento']);
    $this->objRegistrarPersona->__SET('fechaNacimiento', $_POST['txtFechaNacimiento']);
    $this->objRegistrarPersona->__SET('lugarNacimiento', $_POST['txtLugarNacimiento']);
    $this->objRegistrarPersona->__SET('sexo', $_POST['slcSexo']);
    $this->objRegistrarPersona->__SET('direccion', $_POST['txtDireccion']);
    $this->objRegistrarPersona->__SET('telefono', $_POST['txtTelefono']);
    $this->objRegistrarPersona->__SET('correoElectronico', $_POST['txtCorreo']);
    $this->objRegistrarPersona->__SET('grupoSanguineo', $_POST['slcGrupoSanguineo']);
    $this->objRegistrarPersona->__SET('ciudad', $_POST['txtCiudad']);
    $this->objRegistrarPersona->__SET('departamento', $_POST['txtDepartamento']);
    $this->objRegistrarPersona->__SET('pais', "Colombia");
    $this->objRegistrarPersona->__SET('estadoTablaPersona', "Activo");
    $this->objRegistrarPersona->__SET('dependencia', $_POST['slcDependencia']);
    $this->objRegistrarPersona->__SET('urlFoto', $urlFoto);
    $this->objRegistrarPersona->__SET('urlHojaDeVida', $urlHojaDeVida);

    $regPersona = $this->objRegistrarPersona->InsertarDatosPersona();

    if ($regPersona == true) {

      $ultima = $this->objRegistrarPersona->idUltimaPersona();
      $idPersona = $ultima[0]->ultima;

      if (isset($idPersona)) {

        $usuario   = $_POST['txtCorreo'];
        $clave     = $_POST['txtNumeroDocumento'];
        $password = Encrypter::encrypt($clave);
        $idRol     = $_POST['slcRol'];

        $this->objRegistrarPersona->__SET('idPersona', $idPersona);
        $this->objRegistrarPersona->__SET('usuario', $usuario);
        $this->objRegistrarPersona->__SET('clave', $password);
        $this->objRegistrarPersona->__SET('idRol', $idRol);

        $registrarCuentaU = $this->objRegistrarPersona->InsertarDatosUsuario();

        if (isset($_POST['slcEspecialidad'])) {

          $this->objRegistrarPersona->__SET('idEspecialidad', $_POST['slcEspecialidad']);
          $this->objRegistrarPersona->__SET('estadoTablaEspecialidad', "Activo");
          $registrarEspecialidad = $this->objRegistrarPersona->InsertarDatosEspecialidad();

        }

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

  public function FechaServidor()
  {
  date_default_timezone_set("America/Bogota");
  $FechasServidor = date("Y-m-d");
  echo json_encode($FechasServidor);
  }

  public function ListarComboTipoDocumento()  {

    $respuestaTD = $this->objRegistrarPersona->listarComboTipoDocumento();
    echo json_encode($respuestaTD);

  }

  public function ListarComboRol() {

    $respuestaR = $this->objRegistrarPersona->listarComboRol();
    echo json_encode($respuestaR);

  }

  public function ListarComboEspecialidad() {

    $respuestaE = $this->objRegistrarPersona->listarComboEspecialidad();
    echo json_encode($respuestaE);

  }

  public function ConsultarPersonaD() {

    $numeroDocumento = $_POST['txtNumeroDocumento'];
    $respuestaC      = $this->objRegistrarPersona->consultaPersonaD($numeroDocumento);

    if ($respuestaC == null) {
      echo "1";
    } else {
      echo json_encode($respuestaC);
    }

  }

  public function ValidarDocumento()  {

    $numeroDocumento = $_POST['txtNumeroDocumento'];
    $respuestaD      = $this->objRegistrarPersona->validarDocumento($numeroDocumento);

    if (count($respuestaD) > 0) {
      echo json_encode(1);
    } else {
      echo json_encode(0);
    }

  }

  public function ConsultarPersonaCorreo()  {

    $correoElectronico = $_POST['txtCorreo'];
    $respuestaE      = $this->objRegistrarPersona->consultaPersonaCorreo($correoElectronico);

    if ($respuestaE == null) {
      echo "1";
    } else {
      echo json_encode($respuestaE);
    }

  }

  public function ValidarCorreo()  {

    $correoElectronico = $_POST['txtCorreo'];
    $respuestaF      = $this->objRegistrarPersona->validarCorreo($correoElectronico);

    if (count($respuestaF) > 0) {
      echo json_encode(1);
    } else {
      echo json_encode(0);
    }

  }

}

?>

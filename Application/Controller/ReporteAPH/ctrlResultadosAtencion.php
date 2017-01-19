<?php

/**
* Class resultadosAtencion.
*/
class CtrlResultadosAtencion extends Controller implements iController {
  private $scripts;
  private $styles;
  private $vistasMenu;
  private $notificaciones = true;
  private $menuEmergencia = true;

  private $_mdlLayout = null;
  private $objResultadosAtencion = null;


  /**
  * Método constructor()
  * Inicializa el uso de variables de sesión y
  * valida si hay una sesión abierta, sino la hay
  * redirecciona hacia el login de la aplicación:
  */
  public function __construct() {
    Sesion::init();
    if (!Sesion::exist()) {
      header("Location: " . URL);
      exit();
    }

    // Si la var de sesion esModoConsulta no existe redirecciona al index
    if (is_null(Sesion::getValue("esModoConsulta"))) {
      header("Location: " . URL . "ReporteAPH/CtrlIndex");
    }
    $vistaActual = Sesion::setValue('VISTA_ACTUAL','ctrlResultadosAtencion');
    $vistas = Sesion::getValue('VISTAS_BARRA_PROGRESO');

    if (	$vistas['ctrlResultadosAtencion'] == true) {
      $this->_mdlLayout            = $this->loadModel('ReporteAPH', 'mdlLayoutReporteAPH');
      $this->objResultadosAtencion = $this->loadModel('ReporteAPH', 'mdlResultadosAtencion');
    }else {
      $redireccionar = '';
      foreach ($vistas as $key => $value) {

          if ($value == true) {
            $redireccionar = $key;

          }
      }

    header("Location: " . URL . "ReporteAPH/$redireccionar");
  }

  }


  /**
  * METODO: Index
  * Este metodo se ejecuta cuando solicito la URL :
  * http://nombreDeTuProyecto/ReporteAPH/CtrlResultadosAtencion
  * NOTA: Esta es la página por defecto cuando no se encuentra la URL.
  */
  public function Index() {
    // RENDERIZA EL MENÚ DE NAVEGACIÓN
    $this->vistasMenu = json_decode(Sesion::getValue('VISTAS_MENU'));

    // CARGAR CSS
    $this->styles = array(
      'ReporteAPH/estilo.css',
      'ReporteAPH/sweetalert.css',
      "ReporteAPH/estiloResultadosAtencion.css",
      "Todos/otro.css",
      "ReporteAPH/antecedentes.css"
    );

    // CARGAR JAVASCRIPTS
    $this->scripts = array(
      'Lib/fancywebsocket.js',
      'ReporteAPH/MigasPan.js',
      'ReporteAPH/generalScript.js',
      'Lib/angular.min.js',
      'Lib/ngStorage.min.js',
      'Lib/jquery.validate.js',
      'Lib/messages_es.min.js',
      'Validaciones/Functions_Validation.js',
      'Validaciones/Standard_Validations.js',
      'ReporteAPH/AngularJs/mdlReporteAPH.js',
      'ReporteAPH/sweetalert-dev.js',
      'ReporteAPH/informacionAmbulancia.js',
      'ReporteAPH/AngularJs/Checklist-model.js',
      'ReporteAPH/AngularJs/Controller/layoutReporteAPH.js',
      'ReporteAPH/AngularJs/Controller/ResultadosAtencion.js',
      'ReporteAPH/resultadosAtencion.js',
      "Todos/modal.js",
      'ReporteAPH/ConsultarNotificacionDespacho.js'
    );

    $this->_mdlLayout->__SET("_idPersona", Sesion::getValue("ID_PERSONA"));
  $idDespacho = $this->_mdlLayout->TraerIDDespacho();
  $numero = $this->RecibirNumeroNotificacion($idDespacho->idDespacho);
  $datos  = $this->RecibirDescripcionNotificacion($idDespacho->idDespacho);

    // CARGA LAS VISTAS
    require APP . 'View/_layout/header.php';
    require APP . 'View/ReporteAPH/resultadosAtencion.php';
    require APP . "View/ReporteAPH/layoutReporteAPH.php";
    require APP . 'View/_layout/footer.php';

  }

  /*
	*METODO BarraProgreso:  se encarga de dar permiso para acceder a
	*la vista.
	*/
  public function BarraProgreso()
  {
    $vistaRedireccionar = $_POST['vistaRedireccionar'];
    $vistas = Sesion::getValue('VISTAS_BARRA_PROGRESO');
    $vistas['ctrlResultadosAtencion'] = true;
    Sesion::SetValue('VISTAS_BARRA_PROGRESO',$vistas);
    echo json_encode($vistas);
  }


  public function ConsultarPersona(){
   $numeroDocumento = $_POST['txtNumeroNumeroDocumento'];
   $this->objResultadosAtencion->__SET("numero", $numeroDocumento);
   $consultaPersona = $this->objResultadosAtencion->consultarPersonaExistente();
   if ($consultaPersona != null) {
     echo json_encode($consultaPersona);
   }else{
     echo json_encode(null);
   }
 }

 public function consultarNPersona(){
   $numeroDocumentoP = $_POST['txtNumeroNumeroDocumento'];
   $this->objResultadosAtencion->__SET("numero", $numeroDocumentoP);
   $consultarCualquierPersona = $this->objResultadosAtencion->consultarPersona();
   if ($consultarCualquierPersona != null) {
     echo 1;
   }else{
     echo 2;
   }
 }


  public function ListarTipoDocumento() {
    $listadoTipoDocumento = $this->objResultadosAtencion->ListadoTipoDocumento();
    echo json_encode($listadoTipoDocumento);
  }

  public function RegistrarMedicoRecibe() {
      $correoElectronico = $_POST['txtCorreoMedico'];
      $primerNombre      = $_POST['txtNombreMedico'];
      $segundoNombre     = null;
      $primerApellido    = $_POST['txtApellidoMedico'];
      $segundoApellido   = null;
      $idTipoDocumento   = $_POST['opTipoDocumento'];
      $numeroDocumento   = $_POST['txtNumeroNumeroDocumento'];
      $lugarExpedicion   = null;
      $fechaNacimiento   = null;
      $lugarNacimiento   = null;
      $sexo              = null;
      $direccion         = null;
      $telefono          = null;
      $grupoSanguineo    = null;
      $ciudad            = null;
      $departamento      = null;
      $pais              = null;
      $urlHojaVida       = null;
      $urlEstadoTabla    = null;
      $dependencia       = null;
     if ($_FILES['imgImagenMedico']["size"] > 0) {
        $urlFoto      = $_FILES['imgImagenMedico'];
        $nombreFoto   = $urlFoto["name"];
        $rutaTemporal = $urlFoto["tmp_name"];
        $url          = "Public/Img/ReporteAPH/Medico/" . $nombreFoto;
        move_uploaded_file($rutaTemporal, "../" . $url);
      } else {
        $url = null;
      }
      if ($_FILES['imgFirmaMedico']["size"] > 0) {
        $urlFirma      = $_FILES['imgFirmaMedico'];
        $nombreFirma   = $urlFirma["name"];
        $temporalFirma = $urlFirma["tmp_name"];
        $urlF          = "Public/Img/ReporteAPH/Medico/" . $nombreFirma;
        move_uploaded_file($temporalFirma, "../" . $urlF);
      } else {
        $urlF = null;
      }
      $DatosMedico = array(
        $primerNombre,
        $segundoNombre,
        $primerApellido,
        $segundoApellido,
        $idTipoDocumento,
        $numeroDocumento,
        $lugarExpedicion,
        $fechaNacimiento,
        $lugarNacimiento,
        $sexo,
        $direccion,
        $telefono,
        $correoElectronico,
        $grupoSanguineo,
        $ciudad,
        $departamento,
        $pais,
        $urlHojaVida,
        $urlF,
        $url,
        $urlEstadoTabla,
        $dependencia
      );
      $rol = $this->objResultadosAtencion->MedicoExterno();
      $idRol = $rol;

      if ($idRol == null) {
      echo 3;
    }else {
      $idRol = $rol[0]->Rol;
        $regMedicoRecibe = $this->objResultadosAtencion->insertarMedicoRecibe($DatosMedico);
        $ultima = $this->objResultadosAtencion->UltimaPersona();
        $idPersona = $ultima[0]->ultima;
        $correoElectronico = $_POST['txtCorreoMedico'];
        $numeroDocumento   = $_POST['txtNumeroNumeroDocumento'];
        $password = Encrypter::encrypt($numeroDocumento);
;        if ($idPersona != null) {
         $regCuentaUsuario = $this->objResultadosAtencion->insertarCuentaUsuario($idPersona, $correoElectronico, $password, $idRol);
        }
      }

    }


  public function ValidarMedicoRecibe() {
    $usuario = $_POST['txtUsuarioAutentificacion'];
    $this->objResultadosAtencion->__SET("usuario", $usuario);
    $resPswd = $this->objResultadosAtencion->ConsultarClaveUsuario();
    if ($resPswd) {
      $realPassword = $resPswd->clave;
      $clave = Encrypter::decrypt(Encrypter::encrypt($_POST['txtClaveAutentificacion']));
      $decrypted = Encrypter::decrypt($realPassword);
      if ($decrypted == $clave) {
        $this->objResultadosAtencion->__SET("clave", $realPassword);
      }
    }

        $validarMedico = $this->objResultadosAtencion->validarMedico();

     if ($validarMedico == null) {
      echo "1";
    } else {
      echo json_encode($validarMedico);
    }
  }

  function ListarCertificadoAtencion() {
    $listadoCertificadoAtencion = $this->objResultadosAtencion->ListarCertificadoAtencion();
    if ($listadoCertificadoAtencion != null) {
      echo json_encode($listadoCertificadoAtencion);
    } else {
      echo json_encode(null);
    }
  }
  public function RecibirNumeroNotificacion($id) {
      if ($id != 0) {
          $idDespacho = $id;
      }else{
        $idDespacho = $_POST["idDespacho"];
      }
      $request  = $_POST["request"];
      $this->_mdlLayout->__SET("_idDespacho", $idDespacho);
      $numero = $this->_mdlLayout->ContarNotificacionesDespacho();
      if ($request == "ajax") {
        echo json_encode($numero);
      } else {
        return $numero;
      }

    }

  public function RecibirDescripcionNotificacion($id) {
      if ($id != 0) {
          $idDespacho = $id;
      }else{
        $idDespacho = $_POST["idDespacho"];
      }
      $request  = $_POST["request"];
      $this->_mdlLayout->__SET("_idDespacho", $idDespacho);
      $datos = $this->_mdlLayout->DescripcionNotificacionesDespacho();
      if ($request == "ajax") {
        echo json_encode($datos);
      } else {
        return $datos;
      }

    }

}
?>

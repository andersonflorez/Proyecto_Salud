<?php

class ctrlTratamientoB extends Controller implements iController {
  private $scripts;
  private $styles;
  private $vistasMenu;
  private $notificaciones = true;
  private $menuEmergencia = true;

  private $_mdlTratamientoB = null;
  private $_mdlLayout = null;
  private $_mdlLogin = null;

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
      $vistaActual = Sesion::setValue('VISTA_ACTUAL','ctrlTratamientoB');
    	$vistas = Sesion::getValue('VISTAS_BARRA_PROGRESO');

    if (	$vistas['ctrlTratamientoB'] == true) {
      $this->_mdlLayout       = $this->loadModel('ReporteAPH', 'mdlLayoutReporteAPH');
      $this->_mdlTratamientoB = $this->loadModel('ReporteAPH', 'mdlTratamienB');
      $this->_mdlLogin        = $this->loadModel('Home', 'mdlLogin');
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
  * http://PROYECTO_SALUD_DEV/ReporteAPH/ctrlTratamientoB
  * NOTA: Esta es la página por defecto cuando no se encuentra la URL.
  */
  public function Index() {
    // RENDERIZA EL MENÚ DE NAVEGACIÓN
    $this->vistasMenu = json_decode(Sesion::getValue('VISTAS_MENU'));

    // CARGAR CSS
    $this->styles = array(
      'ReporteAPH/estilo.css',
      'ReporteAPH/sweetalert.css',
      'ReporteAPH/tratamiento.css',
      'ReporteAPH/antecedentes.css'
    );

    // CARGAR JAVASCRIPTS
    $this->scripts = array(
      'ReporteAPH/MigasPan.js',
      'Lib/fancywebsocket.js',
      'ReporteAPH/generalScript.js',
      'Todos/modal.js',
      'ReporteAPH/sockets/SocketTratamientoControlMedico.js',
      'Lib/angular.min.js',
      'Lib/ngStorage.min.js',
      'ReporteAPH/AngularJs/Checklist-model.js',
      'ReporteAPH/AngularJs/mdlReporteAPH.js',
      'ReporteAPH/ConsultarNotificacionDespacho.js',
      'ReporteAPH/sweetalert-dev.js',
      'ReporteAPH/informacionAmbulancia.js',
      'ReporteAPH/AngularJs/Controller/layoutReporteAPH.js',
      'ReporteAPH/AngularJs/Controller/tratamientoBasico.js',
      'ReporteAPH/tratamientoB.js',
      'ReporteAPH\AngularJs\Checklist-model.js'
    );

    $this->_mdlLayout->__SET("_idPersona", Sesion::getValue("ID_PERSONA"));
    $idDespacho = $this->_mdlLayout->TraerIDDespacho();
    $numero = $this->RecibirNumeroNotificacion($idDespacho->idDespacho);
    $datos  = $this->RecibirDescripcionNotificacion($idDespacho->idDespacho);

    // CARGAR VISTAS
    require APP . 'View/_layout/header.php';
    require APP . 'View/ReporteAPH/tratamientoB.php';
    require APP . 'View/ReporteAPH/layoutReporteAPH.php';
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
    $vistas['ctrlTratamientoB'] = true;
    Sesion::SetValue('VISTAS_BARRA_PROGRESO',$vistas);
    echo json_encode($vistas);
  }


  /**
  * Listar todos los tipo de tratamiento basico
  */
  public function ListarTratamientoBasico() {
    $listaB = $this->_mdlTratamientoB->ListarTratamientoB();
    if ($listaB != null) {
      echo json_encode($listaB);
    } else {
      echo json_encode("Error");
    }
  }


  public function RegistrarAutorizacion() {
    $idParamedico      = Sesion::getValue('ID_USUARIO');
    $idReporte         = $_POST['idReporte'];
    $idTipoTratamiento = $_POST['idTipoTratamiento'];
    $descripcion       = $_POST['descripcion'];
    $cedula            = $_POST['cedula'];
    date_default_timezone_set('America/Bogota');
    $time = time();

    $horaEnvio             = date("Y-m-d H:i:s", $time);
    $RegistrarAutorizacion = $this->_mdlTratamientoB->RegistrarAutorizacionModelo($idParamedico, $idReporte, $idTipoTratamiento, $descripcion, $cedula, 'Por Evaluar', $horaEnvio);
    if ($RegistrarAutorizacion == true) {
      $mensaje   = "Respuesta";
      $arrayName = array(
        'idparamedico' => $idParamedico,
        'cedula' => $cedula,
        'mensaje' => $mensaje,
        'idReporte' => $idReporte,
        'idTipoTratamiento' => $idTipoTratamiento,
        'descripcion' => $descripcion,
        'horaEnvio' => $horaEnvio
      );
      echo json_encode([$arrayName]);

    } else {
      echo json_encode(["Registro exitoso"]);
    }

  }

  //realiza la consulta del tipo de ambulancia por el id
  public function registrarAutorizacionMedicalizada() {

    $tipo        ='TRATAMIENTO';
    $idSesion    =Sesion::getValue('ID_USUARIO');
    $usuario     =$_POST['usuario'];
    $clave       =$_POST['pass'];
    $this->_mdlLogin->__SET("_Usuario", $usuario);
    $resPswd = $this->_mdlLogin->ConsultarClaveUsuario();

    if($resPswd) {

        $realPassword = $resPswd->clave;
        $clave = Encrypter::decrypt(Encrypter::encrypt($clave));
        $decrypted = Encrypter::decrypt($realPassword);

        if($decrypted === $clave && strtoupper($resPswd->descripcionRol) === 'MEDICO') {
          $resultado   =$resPswd->idUsuario;
          $descripcion =$_POST['descripcion'];
          $cedula      =$_POST['cedula'];
          date_default_timezone_set('America/Bogota');
          $time        = time();
          $horaEnvio   = date("Y-m-d H:i:s", $time);
          $id          =$_POST['id'];
          $RespuestaValidacion = $this->_mdlTratamientoB->registrarAutorizacionMedicalizada($tipo,$idSesion,$descripcion,$horaEnvio,$id,$cedula,$resultado);

          if ($RespuestaValidacion) {
            echo json_encode(["Registro exitoso"]);
          } else {
            echo json_encode(["Registro NO exitoso"]);
          }

        }
      }

  }


  //realiza la consulta del tipo de ambulancia por el id
  public function ValidarTipoAmbulancia() {
    $idParamedico = Sesion::getValue('ID_USUARIO');
    $RespuestaValidacion = $this->_mdlTratamientoB->ValidarTipoAmbulancia($idParamedico);
    echo json_encode($RespuestaValidacion);
  }



  public function ActualizarEstadoTratamientoAvanzado() {
    $cedula     = $_POST['cedula'];
    $FechaEnvio = $_POST['FechaEnvio'];
    $Actualizar = $this->_mdlTratamientoB->ActualizarTemporal($FechaEnvio, $cedula);
    if ($Actualizar) {
      echo json_encode(["Registro exitoso"]);
    } else {
      echo json_encode(["Registro NO exitoso"]);
    }
  }


  //Solicitudes autorizacion
  public function ListadoAutorizacion() {
    $idParamedico = Sesion::getValue('ID_USUARIO');
    $tipo         = "Temporal";
    $cedula       = $_POST['cedulaPaciente'];
    $reporte      = $_POST["idReporte"];

    if (Sesion::getValue("esModoConsulta") == 1) {
      $tipo        = "Reporte";
      $ConsultAuto = $this->_mdlTratamientoB->ListarAutorizacion($reporte, $tipo, $cedula);
      echo json_encode($ConsultAuto);
    } else {
      $tipo        = "Temporal";
      $ConsultAuto = $this->_mdlTratamientoB->ListarAutorizacion($idParamedico, $tipo, $cedula);
      echo json_encode($ConsultAuto);
    }

  }


  public function ListarRespuestaNotificacion() {
    $Consult = $this->_mdlTratamientoB->ListarRespuestaNotificacion();
    echo json_encode($Consult);
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

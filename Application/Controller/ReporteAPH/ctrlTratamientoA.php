<?php

class ctrlTratamientoA extends Controller implements iController {
  private $scripts;
  private $styles;
  private $vistasMenu;
  private $notificaciones = true;
  private $menuEmergencia = true;

  private $_mdlTratamientoA = null;
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
      $vistaActual = Sesion::setValue('VISTA_ACTUAL','ctrlTratamientoA');
    	$vistas = Sesion::getValue('VISTAS_BARRA_PROGRESO');
    if (	$vistas['ctrlTratamientoA'] == true) {
      $this->_mdlLayout       = $this->loadModel('ReporteAPH', 'mdlLayoutReporteAPH');
      $this->_mdlTratamientoA = $this->loadModel('ReporteAPH', 'mdlTratamientoA');
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
      'ReporteAPH/antecedentes.css',
      'ReporteAPH/jquery.timepicker.css'
    );

    // CARGAR JAVASCRIPTS
    $this->scripts = array(
      'ReporteAPH/MigasPan.js',
      'Lib/fancywebsocket.js',
      'ReporteAPH/generalScript.js',
      'Todos/modal.js',
      'ReporteAPH/sockets/SocketTratamientoControlMedico.js',
      'Lib/jquery.timepicker.min.js',
      'ReporteAPH/ConsultarNotificacionDespacho.js',
      'Lib/angular.min.js',
      'Lib/ngStorage.min.js',
      'ReporteAPH/AngularJs/Checklist-model.js',
      'ReporteAPH/AngularJs/mdlReporteAPH.js',
      'ReporteAPH/informacionAmbulancia.js',
      'ReporteAPH/sweetalert-dev.js',
      'ReporteAPH/AngularJs/Controller/layoutReporteAPH.js',
      'ReporteAPH/AngularJs/Controller/tratamientoAvanzado.js',
      'ReporteAPH/tratamientoA.js'
    );

    $this->_mdlLayout->__SET("_idPersona", Sesion::getValue("ID_PERSONA"));
    $idDespacho = $this->_mdlLayout->TraerIDDespacho();
    $numero = $this->RecibirNumeroNotificacion($idDespacho->idDespacho);
    $datos  = $this->RecibirDescripcionNotificacion($idDespacho->idDespacho);

    // CARGAR VISTAS
    require APP . 'View/_layout/header.php';
    require APP . 'View/ReporteAPH/tratamientoA.php';
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
    $vistas['ctrlTratamientoA'] = true;
    Sesion::SetValue('VISTAS_BARRA_PROGRESO',$vistas);
    echo json_encode($vistas);
  }

  /**
  * Listar todos los tipo de tratamiento basico
  */
  public function ListarTratamientoAvanzado() {
    $listaA = $this->_mdlTratamientoA->ListarTratamientoA();
    if ($listaA != null) {
      echo json_encode($listaA);
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
    $time              = time();
    $horaEnvio         = date("Y-m-d H:i:s", $time);
    $estado            = 'Por Evaluar';
    $autorizacion      = array(
      $idParamedico,
      $idReporte,
      $idTipoTratamiento,
      $descripcion,
      $cedula,
      $estado,
      $horaEnvio
    );
    $this->_mdlTratamientoA->__SET("datosAutorizacion",$autorizacion);
    $RegistrarAutorizacion = $this->_mdlTratamientoA->RegistrarAutorizacionModelo();
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
      echo json_encode(["Error en el registro"]);
    }
  }


  public function ActualizarEstadoTratamientoAvanzado() {
    $cedula     = $_POST['cedula'];
    $FechaEnvio = $_POST['FechaEnvio'];
    $ActualizarAutorizacion = array(
      $cedula,
      $FechaEnvio
    );
    $this->_mdlTratamientoA->__SET("datosActualizarAutorizacion",$ActualizarAutorizacion);
    $Actualizar = $this->_mdlTratamientoA->ActualizarTemporal();
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
      $ConsultAuto = $this->_mdlTratamientoA->ListarAutorizacion($reporte, $tipo, $cedula);
      echo json_encode($ConsultAuto);
    } else {
      $tipo        = "Temporal";
      $ConsultAuto = $this->_mdlTratamientoA->ListarAutorizacion($idParamedico, $tipo, $cedula);
      echo json_encode($ConsultAuto);
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
          $RespuestaValidacion = $this->_mdlTratamientoA->registrarAutorizacionMedicalizada($tipo,$idSesion,$descripcion,$horaEnvio,$id,$cedula,$resultado);

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
    $RespuestaValidacion = $this->_mdlTratamientoA->ValidarTipoAmbulancia($idParamedico);
    echo json_encode($RespuestaValidacion);
  }

  function RegistrarTratamientoaph() {
    $objetoTratamiento = json_decode(file_get_contents("php://input"));
    if (!isset($objetoTratamiento)) {
      echo "Datos Vacíos";
    } else {
      if (isset($objetoTratamiento->tratamientoBasicoOxigeno)) {
        $this->_mdlTratamientoA->__SET("_idReporteAPH", $objetoTratamiento->reporte);
        $this->_mdlTratamientoA->__SET("_valor", $objetoTratamiento->tratamientoBasicoOxigeno->descripcionOxigeno);
        $this->_mdlTratamientoA->__SET("_idTipoTratamiento", $objetoTratamiento->tratamientoBasicoOxigeno->idTipoTratamiento[0]);
        $reg = $this->_mdlTratamientoA->RegistrarTratamientoaph();
      } else {
        $reg = true;
      }

      if (isset($objetoTratamiento->tratamientoAvanzadoDextrosa)) {
        $this->_mdlTratamientoA->__SET("_idReporteAPH", $objetoTratamiento->reporte);
        $this->_mdlTratamientoA->__SET("_valor", $objetoTratamiento->tratamientoAvanzadoDextrosa->descripcionDextrosa);
        $this->_mdlTratamientoA->__SET("_idTipoTratamiento", $objetoTratamiento->tratamientoAvanzadoDextrosa->idTipoTratamiento[0]);
        $reg = $this->_mdlTratamientoA->RegistrarTratamientoaph();
      } else {
        $reg = true;
      }

      if (isset($objetoTratamiento->TA->desfibrilacion) && $objetoTratamiento->TA->desfibrilacion != "") {
        foreach ($objetoTratamiento->TA->desfibrilacion as $key1) {
          $this->_mdlTratamientoA->__SET("_idReporteAPH", $objetoTratamiento->reporte);
          $this->_mdlTratamientoA->__SET("_horaDesfibrilacion", $key1->hora);
          $this->_mdlTratamientoA->__SET("_joules", $key1->julios);
          $reg = $this->_mdlTratamientoA->registrarDesfibrilacion();
        }
      } else {
        $reg = true;
      }
      if (isset($objetoTratamiento->TB->idTipoTratamiento)) {
        foreach ($objetoTratamiento->TB->idTipoTratamiento as $key) {
          $this->_mdlTratamientoA->__SET("_idReporteAPH", $objetoTratamiento->reporte);
          $this->_mdlTratamientoA->__SET("_valor", NULL);
          $this->_mdlTratamientoA->__SET("_idTipoTratamiento", $key);
          $reg = $this->_mdlTratamientoA->RegistrarTratamientoaph();
        }
      } else {
        $reg = true;
      }
      if (isset($objetoTratamiento->TA->idTipoTratamiento) && $objetoTratamiento->TA->idTipoTratamiento != "") {
        foreach ($objetoTratamiento->TA->idTipoTratamiento as $val) {
          $this->_mdlTratamientoA->__SET("_idReporteAPH", $objetoTratamiento->reporte);
          $this->_mdlTratamientoA->__SET("_valor", NULL);
          $this->_mdlTratamientoA->__SET("_idTipoTratamiento", $val);
          $reg = $this->_mdlTratamientoA->RegistrarTratamientoaph();
        }
      } else {
        $reg = true;
      }
      if (isset($reg)) {
        if ($reg == true) {
          echo json_encode(true);
        } else {
          echo json_encode(false);
        }
      } else {
        echo json_encode(true);
      }
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


} // Fin clase

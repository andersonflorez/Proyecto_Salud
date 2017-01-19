<?php

/**
* Class controlAutorizacion
*/
class ctrlMedicamento extends Controller implements iController {
  private $styles;
  private $scripts;
  private $vistasMenu;
  private $notificaciones = true;
  private $menuEmergencia = true;

  private $_mdlLayout = null;
  private $_mdlMedicamento = null;


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
    $vistaActual = Sesion::setValue('VISTA_ACTUAL','ctrlMedicamento');
    $vistas = Sesion::getValue('VISTAS_BARRA_PROGRESO');
    if (	$vistas['ctrlMedicamento'] == true) {
      $this->_mdlLayout      = $this->loadModel('ReporteAPH', 'mdlLayoutReporteAPH');
      $this->_mdlMedicamento = $this->loadModel('ReporteAPH', 'mdlMedicamento');

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
  * http://PROYECTO_SALUD_DEV/ReporteAPH/ctrlTratamientoA
  * NOTA: Esta es la página por defecto cuando no se encuentra la URL.
  */
  public function Index() {
    // RENDERIZA EL MENÚ DE NAVEGACIÓN
    $this->vistasMenu = json_decode(Sesion::getValue('VISTAS_MENU'));

    // CARGAR CSS
    $this->styles = array(
      'ReporteAPH/medicamento.css',
      'ReporteAPH/estilo.css',
      'ReporteAPH/sweetalert.css',
      'ReporteAPH/antecedentes.css'
    );

    $this->_mdlLayout->__SET("_idPersona", Sesion::getValue("ID_PERSONA"));
  $idDespacho = $this->_mdlLayout->TraerIDDespacho();
  $numero = $this->RecibirNumeroNotificacion($idDespacho->idDespacho);
  $datos  = $this->RecibirDescripcionNotificacion($idDespacho->idDespacho);

    // CARGAR JAVASCRIPTS
    $this->scripts = array(
      'Lib/fancywebsocket.js',
      'ReporteAPH/sockets/SocketTratamientoControlMedico.js',
      'ReporteAPH/medicamento.js',
      'ReporteAPH/generalScript.js',
      'Lib/angular.min.js',
      'Lib/ngStorage.min.js',
      'Todos/modal.js',
      'ReporteAPH/AngularJs/mdlReporteAPH.js',
      'ReporteAPH/AngularJs/Checklist-model.js',
      'ReporteAPH/sweetalert-dev.js',
      'ReporteAPH/informacionAmbulancia.js',
      'ReporteAPH/AngularJs/Controller/layoutReporteAPH.js',
      'ReporteAPH/MigasPan.js',
      'ReporteAPH/AngularJs/Controller/medicamento.js',
      'ReporteAPH/ConsultarNotificacionDespacho.js'
    );

    // CARGAR VISTAS
    require APP . 'View/_layout/header.php';
    require APP . 'View/ReporteAPH/medicamento.php';
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
    $vistas['ctrlMedicamento'] = true;
    Sesion::SetValue('VISTAS_BARRA_PROGRESO',$vistas);
    echo json_encode($vistas);
  }


  /**
  * Listar todos los tipo de tratamiento basico
  */
  public function ListarMedicamento() {
    $idParamedico = Sesion::getValue('ID_USUARIO');
    $listaM       = $this->_mdlMedicamento->listarMedicamento_id($idParamedico);
    echo json_encode($listaM);
  }

  public function registrarMedicamento() {
    $objMedicamento = json_decode(file_get_contents("php://input"));
    if (!isset($objMedicamento)) {
      echo json_encode("Datos nulos");
    } else {
      if (isset($objMedicamento->medicamento)) {
        foreach ($objMedicamento->medicamento as $key) {
          $this->_mdlMedicamento->__SET("_idDetallekit", $key->id);
          $this->_mdlMedicamento->__SET("_idReporteAPH", $objMedicamento->idReporte);
          $this->_mdlMedicamento->__SET("_dosis", $key->dosis);
          $this->_mdlMedicamento->__SET("_hora", $key->hora);
          $this->_mdlMedicamento->__SET("_viaAdministracion", $key->viaAdministracion);
          $this->_mdlMedicamento->__SET("_cantidadUnidades", $key->cantidad);
          $this->_mdlMedicamento->__SET("_idHistoriaClinica", NULL);
          $med = $this->_mdlMedicamento->registrarMedicamento();

        }
        if ($med == true) {
          echo json_encode(true);
        } else {
          echo json_encode(false);
        }
      } else {
        echo json_encode(true);
      }

    }

  }


  //realiza la consulta del tipo de ambulancia por el id
  public function registrarAutorizacionMedicalizada() {
    $tipo        ='MEDICAMENTO';
    $idSesion    =Sesion::getValue('ID_USUARIO');
    $usuario     =$_POST['usuario'];
    $clave       =$_POST['pass'];
    $descripcion =$_POST['descripcion'];
    $cedula      =$_POST['cedula'];
    date_default_timezone_set('America/Bogota');
    $time        = time();
    $horaEnvio   = date("Y-m-d H:i:s", $time);
    $id          =$_POST['id'];
    $RespuestaValidacion = $this->_mdlMedicamento->registrarAutorizacionMedicalizada($tipo,$idSesion,$usuario,$clave,$descripcion,$horaEnvio,$id,$cedula);
    if ($RespuestaValidacion) {
      echo json_encode(["Registro exitoso"]);
    } else {
      echo json_encode(["Registro NO exitoso"]);
    }
  }


  //realiza la consulta del tipo de ambulancia por el id
  public function ValidarTipoAmbulancia() {
    $idParamedico = Sesion::getValue('ID_USUARIO');
    $RespuestaValidacion = $this->_mdlMedicamento->ValidarTipoAmbulancia($idParamedico);
    echo json_encode($RespuestaValidacion);
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

  public function RegistrarAutorizacion() {
    $idParamedico      = Sesion::getValue('ID_USUARIO');
    $idMedicamento     = $_POST['idMedicamento'];
    $descripcion       = $_POST['descripcion'];
    $cedula            = $_POST['cedula'];
    date_default_timezone_set('America/Bogota');
    $time      = time();
    $horaEnvio = date("Y-m-d H:i:s", $time);

    $RegistrarAutorizacion = $this->_mdlMedicamento->RegistrarAutorizacionModelo($idParamedico,$idMedicamento, $descripcion, $cedula, 'Por Evaluar', $horaEnvio);
    if ($RegistrarAutorizacion == true) {
      $mensaje   = "Respuesta";
      $arrayName = array(
        'idparamedico' => $idParamedico,
        'cedula' => $cedula,
        'mensaje' => $mensaje,
        'idMedicamento' => $idMedicamento,
        'descripcion' => $descripcion,
        'horaEnvio' => $horaEnvio
      );
      echo json_encode([$arrayName]);
    } else {
      echo json_encode(["Error en el registro"]);
    }
  }

  //Solicitudes autorizacion
  public function ListadoAutorizacion() {
    //  var_dump($_POST);
    $idParamedico = Sesion::getValue('ID_USUARIO');
    $tipo         = "Temporal";
    $cedula       = $_POST['cedulaPaciente'];
    $reporte      = $_POST["idReporte"];

    if (Sesion::getValue("esModoConsulta") == 1) {
      $tipo        = "Reporte";
      $ConsultAuto = $this->_mdlMedicamento->ListarAutorizacion($reporte, $tipo, $cedula);
      echo json_encode($ConsultAuto);
    } else {
      $tipo        = "Temporal";
      $ConsultAuto = $this->_mdlMedicamento->ListarAutorizacion($idParamedico, $tipo, $cedula);
      echo json_encode($ConsultAuto);
    }

  }

  public function ActualizarEstadoAutorizacion() {
    $cedula     = $_POST['cedula'];
    $FechaEnvio = $_POST['FechaEnvio'];
    $Actualizar = $this->_mdlMedicamento->ActualizarTemporal($FechaEnvio, $cedula);
    if ($Actualizar) {
      echo json_encode(["Registro exitoso"]);
    } else {
      echo json_encode(["Registro NO exitoso"]);
    }
  }

  public function consultarAllAutorizacion(){
    $objetoAutorizacion = json_decode(file_get_contents("php://input"));
    if (!isset($objetoAutorizacion)) {
          echo json_encode("Datos null");
    }else{
      $idReporteAPH = $objetoAutorizacion->idReporte;
      $cedula = $objetoAutorizacion->cedulaPaciente;
      $personal     = Sesion::getValue('ID_USUARIO');
      $respuesta    = $this->_mdlMedicamento->consultarAllAutorizacion($personal,$cedula,$idReporteAPH);
      $dev;
      if ($respuesta != null) {
        foreach ($respuesta as $key) {
          if ($key->idMedicamento == null) {
            $tipo = "TRATAMIENTO";
          }else{
            $tipo = "MEDICAMENTO";
          }
          $dev = $this->_mdlMedicamento->registrarAllAutorizacion($tipo,$key->idParamedico,$key->idMedico,$idReporteAPH,$key->idTipoTratamiento,$key->descripcionAutorizacion,$key->observacionRespuestaAutorizacion,$key->estadoEvaluacion,$key->fechaEnvio,$key->fechaEvaluacion,$key->cedulaPaciente);
        }
        if ($dev) {
              echo json_encode(1);
        }else{
              echo json_encode(0);
        }
      }else{
        echo json_encode(1);
      }
    }

  }


}

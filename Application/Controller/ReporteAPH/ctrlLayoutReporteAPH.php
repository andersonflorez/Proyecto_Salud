<?php

/**
* Class CtrlLayoutReporteAPH se encarga de suministrar contenido y funcionalidad
* necesaria para el correcto funcionamiento de las vista de reporteAPH
*/
class CtrlLayoutReporteAPH extends Controller implements iController {
  private $objCtrlLayoutReporteAPH = null;
  private $_mdlIndex = null;

  /**
  * Método constructor()
  */
  function __construct() {
    $this->objCtrlLayoutReporteAPH = $this->loadModel('ReporteAPH', 'mdlLayoutReporteAPH');
    Sesion::init();
  }

  /**
  * Método Index()
  * Renderiza la página de error debido a que este archivo solo puede
  * ser accedido mediante ajax
  */
  public function Index() {
    header('Location: ' . URL . 'Error/Error');
  }


  /**
  * Encarga de informar el modo de trabajo de la aplicación( ModoConsulta - ModoRegistro)
  */
  public function WhichWorkMode() {
    if ($_POST['request'] == 'ajax') {
      if (Sesion::varExist('esModoConsulta')) {
        echo Sesion::getValue('esModoConsulta');
      } else {
        echo -1;
      }
    }
  }



  /**
  * Esta función se encarga de confirmar la llegada
  * de la ambulancia al sitio de la emergencia
  */
  public function ConfirmarLlegada() {
    $objDatos = json_decode(file_get_contents("php://input"));

    if (!isset($objDatos)) {
      echo 'Los datos no llegarón';
    } else {
      $this->objCtrlLayoutReporteAPH->__SET("_idDespacho", $objDatos->idDespacho);
      $res = $this->objCtrlLayoutReporteAPH->ConfirmarLlegada();
      if ($res) {
        echo "Llegada confirmada";
      } else {
        echo "Error al intentar confirmar la llegada a la emergencia";
      }
    }

  }



  /**
  * Esta función se encarga de cancelar una emergencia
  */
  public function CancelarEmergencia() {
    $objDatos = json_decode(file_get_contents("php://input"));

    if (!isset($objDatos)) {
      echo 'Los datos no llegarón';
    } else {
      $this->objCtrlLayoutReporteAPH->__SET('_idReporteInicial', $objDatos->idReporteInicial);
      $this->objCtrlLayoutReporteAPH->__SET('_idDespacho', $objDatos->idDespacho);
      $this->objCtrlLayoutReporteAPH->__SET('motivoCancelacion', $objDatos->motivoCancelacion);
      $res = $this->objCtrlLayoutReporteAPH->CancelarEmergencia();
      if ($res == 1) {
        Sesion::setValue("esModoConsulta", 1);
        echo "Emergencia cancelada";
      } else {
        echo "Error al intentar cancelar la emergencia";
      }
    }

  }



  /**
  * Esta función se encarga de pedir una nueva ambulancia
  */
  public function PedirNuevaAmbulancia() {
    $objDatos = json_decode(file_get_contents("php://input"));

    if (!isset($objDatos)) {
      echo 'Los datos no llegarón';
    } else {

      $idReporteInicial = $objDatos->idReporteInicial;

      $valTAB = ( (int) $objDatos->txtNumeroBasico > 0 ) ? true : false;
      $valTAM = ( (int) $objDatos->txtNumeroMedicalizada > 0 ) ? true : false;
      $valRes = 0;

      $this->objCtrlLayoutReporteAPH->__SET('_idReporteInicial', $idReporteInicial);

      if ($valTAB) {
        $descripcion = "Se solicita ambulancia de tipo TAB por el siguiente motivo: $objDatos->txtMotivoAyuda";
        $this->objCtrlLayoutReporteAPH->__SET('descripcion', $descripcion);
        $this->objCtrlLayoutReporteAPH->__SET('tipoAyuda', 1);
        $this->objCtrlLayoutReporteAPH->__SET('numeroLesionados', $objDatos->txtNumeroBasico);
        $valRes += ( $this->objCtrlLayoutReporteAPH->PedirAyuda() == 1) ? 1 : 0;
      }

      if ($valTAM) {
        $descripcion = "Se solicita ambulancia de tipo TAM por el siguiente motivo: $objDatos->txtMotivoAyuda";
        $this->objCtrlLayoutReporteAPH->__SET('descripcion', $descripcion);
        $this->objCtrlLayoutReporteAPH->__SET('tipoAyuda', 1);
        $this->objCtrlLayoutReporteAPH->__SET('numeroLesionados', $objDatos->txtNumeroMedicalizada);
        $valRes += ( $this->objCtrlLayoutReporteAPH->PedirAyuda() == 1) ? 1 : 0;
      }

      if ($valRes > 0) {
        echo "Ayuda solicitada";
      } else {
        echo "Error al intentar solicitar ayuda";
      }

    } // Fin else

  }


  /**
  * Esta función se encarga de pedir una ayuda externa
  */
  public function PedirAyudaExterna() {
    $objDatos = json_decode(file_get_contents("php://input"));

    if (!isset($objDatos)) {
      echo 'Los datos no llegarón';
    } else {
      $idReporteInicial = $objDatos->idReporteInicial;
      $motivo           = mb_strtolower($objDatos->txtMotivoAyudaExterna, 'UTF-8');

      $this->objCtrlLayoutReporteAPH->__SET('idEnteExterno', $objDatos->tipoAyuda);
      $tipoAyuda = $this->objCtrlLayoutReporteAPH->ConsultarEnteExterno();

      $descripcion = "Se solicita ayuda externa de $tipoAyuda->descripcionEnteExterno por el siguiente motivo: $motivo";

      $this->objCtrlLayoutReporteAPH->__SET('_idReporteInicial', $idReporteInicial);
      $this->objCtrlLayoutReporteAPH->__SET('descripcion', $descripcion);
      $this->objCtrlLayoutReporteAPH->__SET('tipoAyuda', $objDatos->tipoAyuda);
      $this->objCtrlLayoutReporteAPH->__SET('numeroLesionados', null);
      $res = $this->objCtrlLayoutReporteAPH->PedirAyuda();
      if ($res == 1) {
        echo "Ayuda solicitada";
      } else {
        echo "Error al intentar solicitar ayuda";
      }
    }

  }


  /**
  * Esta función se encarga de registrar una novedad cualquiera,
  * es libre para el usuario
  */
  public function RegistrarNovedad() {
    $objDatos = json_decode(file_get_contents("php://input"));

    if (!isset($objDatos)) {
      echo 'Los datos no llegarón';
    } else {
      $this->objCtrlLayoutReporteAPH->__SET('_idReporteInicial', $objDatos->idReporteInicial);
      $this->objCtrlLayoutReporteAPH->__SET('descripcion', $objDatos->descripcion);
      $this->objCtrlLayoutReporteAPH->__SET('numeroLesionados', $objDatos->numeroLesionados);
      $res = $this->objCtrlLayoutReporteAPH->RegistrarNovedad();
      if ($res) {
        echo "Novedad agregada";
      } else {
        echo "Error al intentar registrar la novedad";
      }
    }

  }


  /*
  * Esta funcion se encarga de listar la informacion de todas
  * las ambulancias, donde todas tengan asociado un mismo
  * id de reporte inicial.
  */
  public function ListadoAmbulancias() {

    $idReporteInicial   = $_POST['idReporteInicial'];
    $_listadoAmbulancia = $this->objCtrlLayoutReporteAPH->ConsultarAmbulanciasModelo($idReporteInicial);

    if ($_listadoAmbulancia == null) {
      echo json_encode(['mal']);
    } else {

      echo json_encode($_listadoAmbulancia, JSON_UNESCAPED_UNICODE);
    }
  }


  /*
  * Ejecuta la consulta de reporte Inicial y despacho en APH
  */
  public function ConsultarReporteInicial() {
    $objDatos = json_decode(file_get_contents("php://input"));
    if (!isset($objDatos)) {
      echo 'No hay parametros';
    } else {
      $idReporteInicial = $objDatos->idReporteInicial;
      $this->objCtrlLayoutReporteAPH->__SET("_idReporteInicial", $idReporteInicial);
      $listaReporteinicialAPH = $this->objCtrlLayoutReporteAPH->ConsultaReporteInicialAPH();
      if ($listaReporteinicialAPH != null) {
        echo json_encode($listaReporteinicialAPH, JSON_UNESCAPED_UNICODE);
      } else {
        echo json_encode(null);
      }
    }

  }


  public function ConsultarDespacho() {
    $objDatos = json_decode(file_get_contents("php://input"));
    if (!isset($objDatos)) {
      echo 'No hay parametros';
    } else {
      $idDespacho = $objDatos->idDespacho;
      $this->objCtrlLayoutReporteAPH->__SET("_idDespacho", $idDespacho);
      $listaDespacho = $this->objCtrlLayoutReporteAPH->ConsultaDespachoAPH();
      if ($listaDespacho != null) {
        echo json_encode($listaDespacho, JSON_UNESCAPED_UNICODE);
      } else {
        echo json_encode(null);
      }
    }

  }


  public function ConsultarGeolocalizacion() {
    Sesion::setValue("esModoConsulta", 0);
    Sesion::unsetValue('VISTAS_BARRA_PROGRESO');
    $idDespacho = isset($_POST["idDespacho"]) ? $_POST["idDespacho"] : 0;
    $this->objCtrlLayoutReporteAPH->__SET("_idDespacho", $idDespacho);
    $LgnLat = $this->objCtrlLayoutReporteAPH->ConsultarGeolocalizacionAPH();
    if ($LgnLat != null) {
      echo json_encode($LgnLat, JSON_UNESCAPED_UNICODE);
    } else {
      echo json_encode(null);
    }
  }


} // Fin clase
?>

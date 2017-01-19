<?php

/**
* NOMBRE DE LA CLASE: CtrlReporteAPH
* Se encarga de gestionar el registro de todo el ReporteAPH
*/
class CtrlReporteAPH extends Controller implements iController {
  private $_mdlReporteAPH = null;

  /**
  * Método constructor()
  */
  public function __construct() {
    $this->_mdlReporteAPH = $this->loadModel('ReporteAPH', 'mdlReporteAPH');
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


  function TraerProximoIDReporteAPH() {
    $objectoTabla = json_decode(file_get_contents("php://input"));
    if (!isset($objectoTabla)) {
      echo "Tabla vacía";
    } else {
      $nombreTabla = $objectoTabla->nombreTabla;
      $this->_mdlReporteAPH->__SET("_nombreTabla", "tbl_reporteaph");
      $ProximoID = $this->_mdlReporteAPH->TraerProximoIDReporteAPH();
      if ($ProximoID != null) {
        echo json_encode($ProximoID);
      } else {
        echo json_encode(null);
      }
    }

  }


  function RegistrarHistoriaClinicaAPH() {
    $objetoAPH = json_decode(file_get_contents("php://input"));
    if (!isset($objetoAPH)) {
      echo "No hay datos";
    } else {
      date_default_timezone_set('America/Bogota');
      $time = time();
      $horaFinish = date("Y-m-d H:i:s", $time);
      $horaIPS = date("Y-m-d"). ' '. $objetoAPH->objParametrosAPH->horaIPS;
      $horaEscena = date("Y-m-d") . ' '.$objetoAPH->objParametrosAPH->horaEscena;
      $this->_mdlReporteAPH->__SET("_idExamenFisico", $objetoAPH->ultimoRegistro);
      $this->_mdlReporteAPH->__SET("_idDespacho", $objetoAPH->objParametrosAPH->idDespacho);
      $this->_mdlReporteAPH->__SET("_idAsignacionPersonal", $objetoAPH->objParametrosAPH->idAsignacionPersonal);
      if ($objetoAPH->objParametrosAPH->idPersonalRecibeReg != "") {
        $this->_mdlReporteAPH->__SET("_idPersonalRecibe", $objetoAPH->objParametrosAPH->idPersonalRecibeReg);
      }else{
        $this->_mdlReporteAPH->__SET("_idPersonalRecibe", NULL);
      }
      $this->_mdlReporteAPH->__SET("_idTriage", $objetoAPH->objParametrosAPH->triage);
      $this->_mdlReporteAPH->__SET("_idTipoAseguramiento", $objetoAPH->objParametrosAPH->idTipoAseguramientoReg);
      $this->_mdlReporteAPH->__SET("_idCertificadoAtencion", $objetoAPH->objParametrosAPH->idCertiAtencion);
      $this->_mdlReporteAPH->__SET("_fechaFinalizacion", $horaFinish);
      $this->_mdlReporteAPH->__SET("_fechaArriboEscena", $horaEscena);
      $this->_mdlReporteAPH->__SET("_fechaArriboIps", $horaIPS);
      $this->_mdlReporteAPH->__SET("_horaUltimaIngesta", $objetoAPH->objParametrosAPH->horaUltimaIngesta);
      if ($objetoAPH->objParametrosAPH->idAfectado != "") {
        $this->_mdlReporteAPH->__SET("_idAfectado", $objetoAPH->objParametrosAPH->idAfectado);
      }else {
        $this->_mdlReporteAPH->__SET("_idAfectado", NULL);
      }
      $this->_mdlReporteAPH->__SET("_placaVehiculo", $objetoAPH->objParametrosAPH->placa);
      $this->_mdlReporteAPH->__SET("_poliza", $objetoAPH->objParametrosAPH->poliza);
      $this->_mdlReporteAPH->__SET("_codigoAseguradora", $objetoAPH->objParametrosAPH->codAseguradora);
      $this->_mdlReporteAPH->__SET("_descripcionTratamientoBasico", $objetoAPH->objParametrosAPH->tratamientoA);
      $this->_mdlReporteAPH->__SET("_descripcionTratamientoAvanzado", $objetoAPH->objParametrosAPH->tratamientoB);
      $this->_mdlReporteAPH->__SET("_evaluacionResultado", $objetoAPH->objParametrosAPH->evaluacionRes);
      $this->_mdlReporteAPH->__SET("_institucionReceptora", $objetoAPH->objParametrosAPH->instReceptora);
      $this->_mdlReporteAPH->__SET("_situacionEntrega", $objetoAPH->objParametrosAPH->situacionEntrega);
      $this->_mdlReporteAPH->__SET("_presionArterial", $objetoAPH->objParametrosAPH->presionArt);
      $this->_mdlReporteAPH->__SET("_pulso", $objetoAPH->objParametrosAPH->pulsoReg);
      $this->_mdlReporteAPH->__SET("_respiracion", $objetoAPH->objParametrosAPH->respiracionReg);
      $this->_mdlReporteAPH->__SET("_estado", $objetoAPH->objParametrosAPH->estado);
      $this->_mdlReporteAPH->__SET("_complicaciones", $objetoAPH->objParametrosAPH->complicacionesReg);
      $this->_mdlReporteAPH->__SET("_idPaciente", $objetoAPH->objParametrosAPH->idPaciente);
      $this->_mdlReporteAPH->__SET("_TAPHPresente", $objetoAPH->objParametrosAPH->TAPHPresente);
      $this->_mdlReporteAPH->__SET("_TPAPHPresente", $objetoAPH->objParametrosAPH->TPAPHPresente);
      $this->_mdlReporteAPH->__SET("_otroPersonalPresente", $objetoAPH->objParametrosAPH->otroPersonal);
      $objetoAPH->objParametrosAPH->otroPersonal == "true" ? $this->_mdlReporteAPH->__SET("_nombreOtroPersonal", $objetoAPH->objParametrosAPH->nombreotroPersonal) : $this->_mdlReporteAPH->__SET("_nombreOtroPersonal", NULL);
      $this->_mdlReporteAPH->__SET("_protocolo", $objetoAPH->objParametrosAPH->protocolo);
      $this->_mdlReporteAPH->__SET("_idParamedicoAtiende", Sesion::getValue('ID_USUARIO'));
      if ($objetoAPH->objParametrosAPH->idAcompanante != "" ) {
        $this->_mdlReporteAPH->__SET("_idAcompanante", $objetoAPH->objParametrosAPH->idAcompanante);
      }else{
        $this->_mdlReporteAPH->__SET("_idAcompanante", NULL);
      }
      $ultimoRegistroAPH = $this->_mdlReporteAPH->RegistrarHistoriaClinicaAPH();
      if ($ultimoRegistroAPH != null) {
        echo json_encode($ultimoRegistroAPH);
      } else {
        echo json_encode(null);
      }
    }

  }


  function RegistrarViaDeComunicacion() {
    $objViaCom = json_decode(file_get_contents("php://input"));
    if (!isset($objViaCom)) {
      echo "null";
    } else {
      $objeto    = $objViaCom->obj;
      $ultimoAPH = $objViaCom->ultimoAPH;
      foreach ($objeto as $key) {
        $this->_mdlReporteAPH->__SET("_reporteAph", $ultimoAPH);
        $this->_mdlReporteAPH->__SET("_viaComunicacion", $key);
        $respuesta = $this->_mdlReporteAPH->RegistrarViaComunicacion();
      }
      if ($respuesta == true) {
        echo json_encode(true);
      } else {
        echo json_encode(false);
      }
    }
  }


  function RegistrarPiel() {
    $objPiel = json_decode(file_get_contents("php://input"));
    if (!isset($objPiel)) {
      echo "datos NULL";
    } else {
      $objP     = $objPiel->obj;
      $ultimoEF = $objPiel->ultimoEX;
      foreach ($objP as $key) {
        $this->_mdlReporteAPH->__SET("_descripcionPiel", $key);
        $this->_mdlReporteAPH->__SET("_idExamenFisico", $ultimoEF);
        $regPiel = $this->_mdlReporteAPH->RegistrarPiel();
      }
      if ($regPiel == true) {
        echo json_encode(true);
      } else {
        echo json_encode(false);
      }
    }
  }


  function ValidarDespachoUnico() {
    $objDespacho = json_decode(file_get_contents("php://input"));
    if (!isset($objDespacho)) {
      echo json_encode("datos nulos");
    } else {
      $this->_mdlReporteAPH->__SET("_idDespacho", $objDespacho->idDespacho);
      $ultimo = $this->_mdlReporteAPH->ValidarDespachoUnico();
      if ($ultimo != null) {
        echo json_encode($ultimo);
      } else {
        echo json_encode(0);
      }
    }
  }


  function RegistrarCuidadoAntesArriboAPH() {

    $objetoCuidado = json_decode(file_get_contents("php://input"));
    if (!isset($objetoCuidado)) {
      echo json_encode("nulos");
    } else {
      $idReporte = $objetoCuidado->idReporte;
      $cuidado   = $objetoCuidado->cuidado;
      foreach ($cuidado as $key) {
        $this->_mdlReporteAPH->__SET("_idReporteAph", $idReporte);
        $this->_mdlReporteAPH->__SET("_descripcionCuidado", $key);
        $registroCuidado = $this->_mdlReporteAPH->RegistrarCuidadoAntesArriboAPH();
      }
      if ($registroCuidado == true) {
        echo json_encode(1);
      } else {
        echo json_encode(0);
      }
    }
  }
  function RegistrarTestigos(){
    $testigos = json_decode(file_get_contents("php://input"));
    if (!isset($testigos)) {
      echo json_encode("Datos testigos null");
    }else{
      $idReporte = $testigos->idReporte;
      $nombreTestigos =  $testigos->testigos;
      if (!empty($nombreTestigos)) {
        foreach ($nombreTestigos as $key) {
          if ($key->nombre != "" && $key->cedula != "") {
            $this->_mdlReporteAPH->__SET("_idReporteAph", $idReporte);
            $this->_mdlReporteAPH->__SET("_nombreTestigo", $key->nombre);
            $this->_mdlReporteAPH->__SET("_identificacionTestigo", $key->cedula);
            $regTestigo = $this->_mdlReporteAPH->RegistrarTestigos();
          }

        }
        if ($regTestigo == true) {
          echo json_encode(1);
        }else{
          echo json_encode(0);
        }
      }else{
        echo json_encode(1);
      }

    }
  }
  function RegistrarNovedadesReporteInicial(){
    $novedades = json_decode(file_get_contents("php://input"));
    if (!isset($novedades)) {
      echo json_encode("Datos novedades null");
    }else{
      if (!empty($novedades->novedades)) {
        foreach ($novedades->novedades as $key) {
          $idReporteinicial = $novedades->idReporteInicial;
          $this->_mdlReporteAPH->__SET("_idReporteInicial", $idReporteinicial);
          $this->_mdlReporteAPH->__SET("_descripcionNovedad", $key->txtNovedadLibre);
          $this->_mdlReporteAPH->__SET("_numeroAfectados", $key->txtNumeroLesionados);
          $this->_mdlReporteAPH->__SET("_estadoNovedad", 'Activo');
          $registroNovedad =$this->_mdlReporteAPH->RegistrarNovedadesReporteInicial();
        }
        if ($registroNovedad == true) {
          echo json_encode(1);
        }else{
          echo json_encode(0);
        }
      }else{
        echo json_encode(1);
      }
    }
  }

  public function Reset() {
    $request = json_decode(file_get_contents("php://input"));
    if (!isset($request)) {
      echo json_encode("datos nulos");
    }else{
      Sesion::setValue("esModoConsulta", 1);
      Sesion::unsetValue('VISTAS_BARRA_PROGRESO');
    }
  }
  public function FinalizarReporteInicial(){
    $request = json_decode(file_get_contents("php://input"));
    if (!isset($request)) {
            echo json_encode("null");
    }else{
      $idReporteInicial = $request->idReporteInicial;
        $this->_mdlReporteAPH->__SET("_idReporteInicial", $idReporteInicial);
        $respuestaFinalizacion =$this->_mdlReporteAPH->FinalizarReporteInicial();
        if ($respuestaFinalizacion != 0) {
              echo json_encode(1);
        }else{
              echo json_encode(0);
        }
    }
  }


}
?>

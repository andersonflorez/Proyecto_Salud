<?php

class CtrlExamenFisico extends Controller implements iController {

  private $_mdlExamenFisico = null;

  /**
  * Método constructor()
  */
  public function __construct() {
    $this->_mdlExamenFisico = $this->loadModel('ReporteAPH', 'mdlExamenFisico');
  }

  /**
  * Método Index()
  * Renderiza la página de error debido a que este archivo solo puede
  * ser accedido mediante ajax
  */
  public function Index() {
    header('Location: ' . URL . 'Error/Error');
  }


  public function RegistrarExamenFisico() {
    $objExamenFisico = json_decode(file_get_contents("php://input"));
    if (!isset($objExamenFisico)) {
      echo "Datos Nulos";
    } else {
      date_default_timezone_set('America/Bogota');
      $time                       = time();
      $horaEnvio                  = date("Y-m-d H:i:s", $time);
      $estadoRespiracion          = $objExamenFisico->respiracion->estado;
      $respiracion_min            = $objExamenFisico->respiracion->valor;
      $SpO2                       = $objExamenFisico->respiracion->spo;
      $estadoPulso                = $objExamenFisico->pulso->estado;
      $pulso_min                  = $objExamenFisico->pulso->valor;
      $sistole                    = $objExamenFisico->presionArterial->sistolica;
      $diastole                   = $objExamenFisico->presionArterial->diastolica;
      $glucometria                = $objExamenFisico->presionArterial->glucometria;
      $conciencia                 = $objExamenFisico->conciencia->estado;
      $glasgow                    = $objExamenFisico->conciencia->glasgow;
      $estadoPupilaDerecha        = $objExamenFisico->pupilas->derecha;
      $estadoPupilaIzquierda      = $objExamenFisico->pupilas->izquierda;
      $gradoPupilaD               = $objExamenFisico->pupilas->derechaDilatacion;
      $gradoPupilaI               = $objExamenFisico->pupilas->izquierdaDilatacion;
      $especificacionVerbal       = $objExamenFisico->glasgow->verbal;
      $estadoHemodinamico         = isset($objExamenFisico->estadoHemodinamico) ? $objExamenFisico->estadoHemodinamico : "";
      $especificacionOcular       = $objExamenFisico->glasgow->ocular;
      $especificacionMotor        = $objExamenFisico->glasgow->motor;
      $especificacionExamenFisico = $objExamenFisico->especificacionExamen;
      if ($especificacionOcular == "No Evaluable") {
        $especificacionOcular = $objExamenFisico->glasgow->descripcionOcular;
      } else {
        $especificacionOcular = $objExamenFisico->glasgow->ocular;
      }
      if ($especificacionVerbal == "No Evaluable") {
        $especificacionVerbal = $objExamenFisico->glasgow->descripcionVerbal;
      } else {
        $especificacionVerbal = $objExamenFisico->glasgow->verbal;
      }
      if ($especificacionMotor == "No Evaluable") {
        $especificacionMotor = $objExamenFisico->glasgow->descripcionMotor;
      } else {
        $especificacionMotor = $objExamenFisico->glasgow->motor;
      }
      $this->_mdlExamenFisico->__SET("_fechaHoraExamen", $horaEnvio);
      $this->_mdlExamenFisico->__SET("_estadoRespiracion", $estadoRespiracion);
      $this->_mdlExamenFisico->__SET("_respiracion_min", $respiracion_min);
      $this->_mdlExamenFisico->__SET("_SpO2", $SpO2);
      $this->_mdlExamenFisico->__SET("_estado_pulso", $estadoPulso);
      $this->_mdlExamenFisico->__SET("_pulso_min", $pulso_min);
      $this->_mdlExamenFisico->__SET("_sistole", $sistole);
      $this->_mdlExamenFisico->__SET("_diastole", $diastole);
      $this->_mdlExamenFisico->__SET("_glucometria", $glucometria);
      $this->_mdlExamenFisico->__SET("_conciencia", $conciencia);
      $this->_mdlExamenFisico->__SET("_glasgow", $glasgow);
      $this->_mdlExamenFisico->__SET("_estadoPupilaDerecha", $estadoPupilaDerecha);
      $this->_mdlExamenFisico->__SET("_estadoPupilaIzquierda", $estadoPupilaIzquierda);
      $this->_mdlExamenFisico->__SET("_gradoDilatacionPupilaD", $gradoPupilaD);
      $this->_mdlExamenFisico->__SET("_gradoDilatacionPupilaI", $gradoPupilaI);
      $this->_mdlExamenFisico->__SET("_especificacionVerbal", $especificacionVerbal);
      $this->_mdlExamenFisico->__SET("_estadoHemodinamico", $estadoHemodinamico);
      $this->_mdlExamenFisico->__SET("_especificacionOcular", $especificacionOcular);
      $this->_mdlExamenFisico->__SET("_especificacion_Motor", $especificacionMotor);
      $this->_mdlExamenFisico->__SET("_especificacion_ExamenFisico", $especificacionExamenFisico);
      $registroExamen = $this->_mdlExamenFisico->RegistrarExamenFisico();

      if ($registroExamen != null) {
        echo json_encode($registroExamen);
      } else {
        echo json_encode(null);
      }
    }
  }


}
?>

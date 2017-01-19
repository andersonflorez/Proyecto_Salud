<?php

class CtrlCertificadoAtencion extends Controller implements iController {

  private $objCertificadoAtencion;

  /**
  * Método constructor()
  */
  public function __construct() {
    $this->objCertificadoAtencion = $this->loadModel('ReporteAPH', 'mdlCertificadoAtencion');
  }

  /**
  * Método Index()
  * Renderiza la página de error debido a que este archivo solo puede
  * ser accedido mediante ajax
  */
  public function Index() {
    header('Location: ' . URL . 'Error/Error');
  }

  public function Registrar() {
    $valores = json_decode($_POST['Valores']);
    $this->objCertificadoAtencion->SetDescripcionCertificadoAtencion($valores[0]);
    echo $this->objCertificadoAtencion->RegistrarCertificadosAtencion();
  }


  public function Modificar() {
    $valores = json_decode($_POST['Valores']);
    $this->objCertificadoAtencion->SetIdCertificadoAtencion($valores[0]);
    $this->objCertificadoAtencion->SetDescripcionCertificadoAtencion($valores[1]);
    echo $this->objCertificadoAtencion->ModificarCertificadosAtencion();
  }


  public function CambiarEstado() {
    $id     = $_POST['id'];
    $estado = $_POST['estado'];
    $estado = $estado == 'Activo' ? 'Inactivo' : 'Activo';
    $this->objCertificadoAtencion->SetIdCertificadoAtencion($id);
    $this->objCertificadoAtencion->SetEstadoCertificadoAtencion($estado);
    echo $this->objCertificadoAtencion->CambiarEstadoCertificadoAtencion();
  }



}
?>

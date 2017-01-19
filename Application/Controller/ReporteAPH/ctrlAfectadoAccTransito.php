<?php
class CtrlAfectadoAccTransito extends Controller implements iController {

  private $objAfectado;

  /**
  * Método constructor()
  */
  public function __construct() {
    $this->objAfectado = $this->loadModel('ReporteAPH', 'mdlAfectadoAccTransito');
  }

  /**
  * Método Index()
  * Renderiza la página de error debido a que este archivo solo puede
  * ser accedido mediante ajax
  */
  public function Index() {
    header('Location: ' . URL . 'Error/Error');
  }

  // Función para registrar un tipo de evento:
  public function Registrar() {
    $valores = json_decode($_POST['Valores']);
    $this->objAfectado->SetDescripcionAfectado($valores[0]);
    echo $this->objAfectado->RegistrarAfectado();
  }

  public function Modificar() {
    $valores = json_decode($_POST['Valores']);
    $this->objAfectado->SetIdAfectado($valores[0]);
    $this->objAfectado->SetDescripcionAfectado($valores[1]);
    echo $this->objAfectado->ModificarAfectado();
  }

  public function CambiarEstado() {
    $id     = $_POST['id'];
    $estado = $_POST['estado'];
    $estado = $estado == 'Activo' ? 'Inactivo' : 'Activo';
    $this->objAfectado->SetIdAfectado($id);
    $this->objAfectado->SetEstadoAfectado($estado);
    echo $this->objAfectado->CambiarEstadoAfectado();
  }



}
?>

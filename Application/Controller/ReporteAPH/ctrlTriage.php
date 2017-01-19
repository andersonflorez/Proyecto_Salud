<?php
class CtrlTriage extends Controller implements iController {
  private $objTriage;

  /**
  * Método constructor()
  */
  public function __construct() {
    $this->objTriage = $this->loadModel('ReporteAPH', 'mdlTriage');
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
    $this->objTriage->SetDescripcionTriage($valores[0]);
    echo $this->objTriage->RegistrarTriage();
  }

  public function Modificar() {
    $valores = json_decode($_POST['Valores']);
    $this->objTriage->SetIdTriage($valores[0]);
    $this->objTriage->SetDescripcionTriage($valores[1]);
    echo $this->objTriage->ModificarTriage();
  }

  public function CambiarEstado() {
    $id     = $_POST['id'];
    $estado = $_POST['estado'];
    $estado = $estado == 'Activo' ? 'Inactivo' : 'Activo';
    $this->objTriage->SetIdTriage($id);
    $this->objTriage->SetEstadoTriage($estado);
    echo $this->objTriage->CambiarEstadoTriage();
  }


} // Fin clase
?>
